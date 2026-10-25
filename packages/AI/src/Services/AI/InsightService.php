<?php

namespace Webkul\AI\Services\AI;

use Webkul\AI\Models\ProductView;
use Webkul\AI\Models\UserInteraction;
use Webkul\AI\Models\SearchHistory;
use Webkul\AI\Models\Recommendation;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class InsightService
{
    /**
     * Generate AI-powered insights for the admin dashboard.
     *
     * @return array
     */
    public function getInsights(): array
    {
        return Cache::remember('ai.insights', 300, function () {
            return [
                'sales_forecast' => $this->getSalesForecast(),
                'product_trends' => $this->getProductTrends(),
                'customer_segments' => $this->getCustomerSegments(),
                'low_stock_alerts' => $this->getLowStockAlerts(),
                'conversion_insights' => $this->getConversionInsights(),
                'search_insights' => $this->getSearchInsights(),
            ];
        });
    }

    /**
     * Get sales forecast based on historical data.
     */
    protected function getSalesForecast(): array
    {
        $days = 30;
        $historical = DB::table('orders')
            ->selectRaw('DATE(created_at) as date, SUM(grand_total) as total, COUNT(*) as count')
            ->where('created_at', '>=', now()->subDays($days * 2))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        $recent = $historical->filter(fn ($d) => $d->date >= now()->subDays($days)->format('Y-m-d'));
        $previous = $historical->filter(fn ($d) => $d->date < now()->subDays($days)->format('Y-m-d') && $d->date >= now()->subDays($days * 2)->format('Y-m-d'));

        $recentTotal = $recent->sum('total');
        $previousTotal = $previous->sum('total');

        $growth = $previousTotal > 0
            ? (($recentTotal - $previousTotal) / $previousTotal) * 100
            : 0;

        $forecast = $recentTotal + ($recentTotal * ($growth / 100));

        return [
            'current' => $recentTotal,
            'forecast' => $forecast,
            'growth' => round($growth, 2),
            'trend' => $growth >= 0 ? 'up' : 'down',
        ];
    }

    /**
     * Get product trends.
     */
    protected function getProductTrends(): array
    {
        $topProducts = DB::table('order_items')
            ->selectRaw('product_id, SUM(qty_ordered) as total_sold, SUM(total) as revenue')
            ->groupBy('product_id')
            ->orderByDesc('total_sold')
            ->take(10)
            ->get();

        $trends = [];
        foreach ($topProducts as $item) {
            $product = \Webkul\Product\Models\Product::find($item->product_id);
            if ($product) {
                $trends[] = [
                    'id' => $product->id,
                    'name' => $product->name,
                    'sold' => $item->total_sold,
                    'revenue' => $item->revenue,
                    'trend' => $this->calculateProductTrend($product->id),
                ];
            }
        }

        return $trends;
    }

    /**
     * Calculate product trend direction.
     */
    protected function calculateProductTrend(int $productId): string
    {
        $recent = DB::table('order_items')
            ->where('product_id', $productId)
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $previous = DB::table('order_items')
            ->where('product_id', $productId)
            ->whereBetween('created_at', [now()->subDays(14), now()->subDays(7)])
            ->count();

        if ($recent > $previous) return 'up';
        if ($recent < $previous) return 'down';
        return 'stable';
    }

    /**
     * Get customer segments.
     */
    protected function getCustomerSegments(): array
    {
        return [
            'new_users' => DB::table('customers')
                ->where('created_at', '>=', now()->subDays(30))
                ->count(),
            'returning_users' => DB::table('customers')
                ->where('created_at', '<', now()->subDays(30))
                ->whereHas('orders', fn ($q) => $q->where('created_at', '>=', now()->subDays(30)))
                ->count(),
            'vip_users' => DB::table('customers')
                ->whereHas('orders', fn ($q) => $q->groupBy('customer_id')
                    ->havingRaw('SUM(grand_total) > ?', [1000]))
                ->count(),
        ];
    }

    /**
     * Get low stock alerts.
     */
    protected function getLowStockAlerts(): array
    {
        $products = \Webkul\Product\Models\Product::where('inventory', '<=', 5)
            ->where('status', 1)
            ->take(10)
            ->get();

        return $products->map(fn ($p) => [
            'id' => $p->id,
            'name' => $p->name,
            'stock' => $p->inventory,
        ])->toArray();
    }

    /**
     * Get conversion insights.
     */
    protected function getConversionInsights(): array
    {
        $views = ProductView::where('created_at', '>=', now()->subDays(7))->count();
        $purchases = UserInteraction::where('interaction_type', 'purchase')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();
        $conversion = $views > 0 ? ($purchases / $views) * 100 : 0;

        $cartAdds = UserInteraction::where('interaction_type', 'cart')
            ->where('created_at', '>=', now()->subDays(7))
            ->count();

        $cartToPurchase = $cartAdds > 0 ? ($purchases / $cartAdds) * 100 : 0;

        return [
            'view_to_purchase' => round($conversion, 2),
            'cart_to_purchase' => round($cartToPurchase, 2),
            'total_views' => $views,
            'total_purchases' => $purchases,
        ];
    }

    /**
     * Get search insights.
     */
    protected function getSearchInsights(): array
    {
        $topSearches = SearchHistory::where('created_at', '>=', now()->subDays(30))
            ->groupBy('query')
            ->selectRaw('query, COUNT(*) as count')
            ->orderByDesc('count')
            ->take(10)
            ->get();

        $zeroResultSearches = SearchHistory::where('created_at', '>=', now()->subDays(30))
            ->where('results_count', 0)
            ->groupBy('query')
            ->selectRaw('query, COUNT(*) as count')
            ->orderByDesc('count')
            ->take(5)
            ->get();

        return [
            'top_searches' => $topSearches->toArray(),
            'zero_result_searches' => $zeroResultSearches->toArray(),
        ];
    }
}