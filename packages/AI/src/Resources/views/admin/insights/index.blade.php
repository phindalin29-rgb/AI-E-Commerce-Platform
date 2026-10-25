<x-admin::layout>
    <x-slot:title>AI Insights</x-slot>

    <div class="container mx-auto p-6">
        <div class="mb-6">
            <h1 class="text-2xl font-bold text-slate-800">AI E-Commerce Analytics</h1>
            <p class="text-slate-500 mt-1">AI-powered insights for your e-commerce store</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-6">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <div class="flex items-center justify-between">
                    <span class="text-slate-500 text-sm">Revenue (30d)</span>
                    <span class="text-xs px-2 py-1 rounded-full {{ $insights['sales_forecast']['trend'] === 'up' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ $insights['sales_forecast']['growth'] }}%
                    </span>
                </div>
                <div class="text-2xl font-bold text-slate-900 mt-2">${{ number_format($insights['sales_forecast']['current'], 2) }}</div>
                <div class="text-sm text-slate-500 mt-1">Forecast: ${{ number_format($insights['sales_forecast']['forecast'], 2) }}</div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <span class="text-slate-500 text-sm">Total Views</span>
                <div class="text-2xl font-bold text-slate-900 mt-2">{{ $insights['conversion_insights']['total_views'] }}</div>
                <div class="text-sm text-slate-500 mt-1">Purchases: {{ $insights['conversion_insights']['total_purchases'] }}</div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <span class="text-slate-500 text-sm">Conversion Rate</span>
                <div class="text-2xl font-bold text-slate-900 mt-2">{{ $insights['conversion_insights']['view_to_purchase'] }}%</div>
                <div class="text-sm text-slate-500 mt-1">Cart to purchase: {{ $insights['conversion_insights']['cart_to_purchase'] }}%</div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <span class="text-slate-500 text-sm">New Users (30d)</span>
                <div class="text-2xl font-bold text-slate-900 mt-2">{{ $insights['customer_segments']['new_users'] }}</div>
                <div class="text-sm text-slate-500 mt-1">VIP: {{ $insights['customer_segments']['vip_users'] }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Top Products</h2>
                <div class="space-y-3">
                    @foreach ($insights['product_trends'] as $product)
                        <div class="flex items-center justify-between p-3 bg-slate-50 rounded-lg">
                            <div>
                                <div class="font-medium text-slate-800">{{ $product['name'] }}</div>
                                <div class="text-sm text-slate-500">Sold: {{ $product['sold'] }}</div>
                            </div>
                            <span class="text-xs px-2 py-1 rounded-full {{ $product['trend'] === 'up' ? 'bg-green-100 text-green-700' : ($product['trend'] === 'down' ? 'bg-red-100 text-red-700' : 'bg-slate-100 text-slate-700') }}">
                                {{ $product['trend'] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Low Stock Alerts</h2>
                <div class="space-y-3">
                    @foreach ($insights['low_stock_alerts'] as $item)
                        <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg">
                            <div class="font-medium text-slate-800">{{ $item['name'] }}</div>
                            <span class="text-xs px-2 py-1 bg-red-100 text-red-700 rounded-full">Stock: {{ $item['stock'] }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <div class="bg-white rounded-xl border border-slate-200 p-6">
            <h2 class="text-lg font-semibold text-slate-800 mb-4">Top Search Terms</h2>
            <div class="flex flex-wrap gap-2">
                @foreach ($insights['search_insights']['top_searches'] as $search)
                    <span class="px-3 py-1 bg-indigo-50 text-indigo-700 text-sm rounded-lg">{{ $search['query'] }} <span class="text-indigo-400">({{ $search['count'] }})</span></span>
                @endforeach
            </div>
        </div>
    </div>
</x-admin::layout>
