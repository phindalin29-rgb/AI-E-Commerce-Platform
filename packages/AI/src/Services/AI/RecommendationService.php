<?php

namespace Webkul\AI\Services\AI;

use Webkul\AI\Models\UserInteraction;
use Webkul\AI\Models\Recommendation;
use Webkul\AI\Models\ProductView;
use Webkul\Product\Models\Product;
use Webkul\Product\Repositories\ProductRepository;
use Illuminate\Support\Facades\Cache;

class RecommendationService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    /**
     * Get personalized product recommendations for a user.
     *
     * @param  int|null  $customerId
     * @param  string|null  $sessionId
     * @param  int  $limit
     * @return array
     */
    public function getRecommendations(?int $customerId, ?string $sessionId, int $limit = 12): array
    {
        $cacheKey = "recommendations.{$customerId}.{$sessionId}.{$limit}";

        return Cache::remember($cacheKey, 300, function () use ($customerId, $sessionId, $limit) {
            $scores = $this->calculateRecommendationScores($customerId, $sessionId);

            $productIds = array_keys($scores);

            if (empty($productIds)) {
                return $this->getTrendingProducts($limit);
            }

            $products = $this->productRepository
                ->setSearchEngine('database')
                ->getAll([
                    'ids' => $productIds,
                    'status' => 1,
                    'visible_individually' => 1,
                    'channel_id' => core()->getCurrentChannel()->id,
                    'locale' => app()->getLocale(),
                ]);

            return $products->take($limit)->map(function ($product) use ($scores) {
                $product->ai_score = $scores[$product->id] ?? 0;
                $product->is_ai_pick = true;
                return $product;
            })->toArray();
        });
    }

    /**
     * Calculate recommendation scores for products based on user behavior.
     *
     * @param  int|null  $customerId
     * @param  string|null  $sessionId
     * @return array
     */
    protected function calculateRecommendationScores(?int $customerId, ?string $sessionId): array
    {
        $scores = [];

        $query = UserInteraction::query();

        if ($customerId) {
            $query->where('customer_id', $customerId);
        } elseif ($sessionId) {
            $query->where('session_id', $sessionId);
        } else {
            return [];
        }

        $interactions = $query->get();

        foreach ($interactions as $interaction) {
            $weight = $this->getInteractionWeight($interaction->interaction_type);
            $scores[$interaction->product_id] = ($scores[$interaction->product_id] ?? 0) + $weight;
        }

        // Boost based on view count
        $viewQuery = ProductView::query();
        if ($customerId) {
            $viewQuery->where('customer_id', $customerId);
        } elseif ($sessionId) {
            $viewQuery->where('session_id', $sessionId);
        }

        $views = $viewQuery->groupBy('product_id')
            ->selectRaw('product_id, count(*) as view_count')
            ->get();

        foreach ($views as $view) {
            $scores[$view->product_id] = ($scores[$view->product_id] ?? 0) + ($view->view_count * 0.5);
        }

        // Normalize scores
        $maxScore = max($scores) ?: 1;
        foreach ($scores as &$score) {
            $score = $score / $maxScore;
        }

        arsort($scores);

        return $scores;
    }

    /**
     * Get weight for interaction type.
     */
    protected function getInteractionWeight(string $type): float
    {
        return match ($type) {
            'purchase' => 10.0,
            'cart' => 5.0,
            'wishlist' => 3.0,
            'view' => 1.0,
            'search' => 0.5,
            default => 0.0,
        };
    }

    /**
     * Get trending products as fallback recommendations.
     */
    protected function getTrendingProducts(int $limit): array
    {
        $products = $this->productRepository
            ->setSearchEngine('database')
            ->getAll([
                'status' => 1,
                'visible_individually' => 1,
                'channel_id' => core()->getCurrentChannel()->id,
                'locale' => app()->getLocale(),
                'sort' => 'created_at',
                'order' => 'desc',
            ]);

        return $products->take($limit)->map(function ($product) {
            $product->is_ai_pick = true;
            return $product;
        })->toArray();
    }

    /**
     * Get related products for a specific product.
     */
    public function getRelatedProducts(int $productId, int $limit = 8): array
    {
        $product = $this->productRepository->find($productId);

        if (! $product) {
            return [];
        }

        $relatedIds = $product->related_products()
            ->take($limit)
            ->pluck('related_product_id')
            ->toArray();

        if (empty($relatedIds)) {
            return [];
        }

        $products = $this->productRepository
            ->setSearchEngine('database')
            ->getAll([
                'ids' => $relatedIds,
                'status' => 1,
                'visible_individually' => 1,
                'channel_id' => core()->getCurrentChannel()->id,
                'locale' => app()->getLocale(),
            ]);

        return $products->map(function ($product) {
            $product->is_ai_pick = true;
            return $product;
        })->toArray();
    }

    /**
     * Record a user interaction.
     */
    public function recordInteraction(array $data): UserInteraction
    {
        return UserInteraction::create([
            'customer_id' => $data['customer_id'] ?? auth('customer')->id(),
            'session_id' => $data['session_id'] ?? session()->getId(),
            'product_id' => $data['product_id'],
            'interaction_type' => $data['type'],
            'weight' => $data['weight'] ?? $this->getInteractionWeight($data['type']),
            'metadata' => $data['metadata'] ?? null,
            'ip_address' => $data['ip_address'] ?? request()->ip(),
        ]);
    }
}