<?php

use Webkul\AI\Models\SearchHistory;
use Webkul\AI\Services\AI\InsightService;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('insight service returns insights array', function () {
    $service = app(InsightService::class);

    $insights = $service->getInsights();

    expect($insights)->toBeArray()
        ->and($insights)->toHaveKeys([
            'sales_forecast',
            'product_trends',
            'customer_segments',
            'low_stock_alerts',
            'conversion_insights',
            'search_insights',
        ]);
});