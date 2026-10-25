<?php

use Webkul\AI\Models\ProductView;
use Webkul\AI\Models\SearchHistory;
use Webkul\AI\Models\UserInteraction;
use Webkul\AI\Models\Recommendation;
use Webkul\AI\Services\AI\RecommendationService;
use Webkul\AI\Services\AI\SmartSearchService;
use Webkul\AI\Services\AI\InsightService;
use Webkul\Product\Models\Product;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('product view can be recorded', function () {
    $product = Product::factory()->create();

    ProductView::create([
        'product_id' => $product->id,
        'session_id' => 'test-session',
        'ip_address' => '127.0.0.1',
    ]);

    expect(ProductView::where('product_id', $product->id)->count())->toBe(1);
});

test('user interaction can be recorded', function () {
    $product = Product::factory()->create();

    UserInteraction::create([
        'product_id' => $product->id,
        'session_id' => 'test-session',
        'interaction_type' => 'view',
        'weight' => 1,
    ]);

    expect(UserInteraction::where('product_id', $product->id)->count())->toBe(1);
});

test('search history can be recorded', function () {
    SearchHistory::create([
        'session_id' => 'test-session',
        'query' => 'test query',
        'results_count' => 5,
    ]);

    expect(SearchHistory::where('query', 'test query')->count())->toBe(1);
});

test('recommendation can be created', function () {
    $product = Product::factory()->create();
    $recommended = Product::factory()->create();

    Recommendation::create([
        'product_id' => $product->id,
        'recommended_product_id' => $recommended->id,
        'score' => 0.85,
        'type' => 'related',
    ]);

    expect(Recommendation::where('product_id', $product->id)->count())->toBe(1);
});

test('recommendation service returns recommendations', function () {
    $service = app(RecommendationService::class);

    $recommendations = $service->getRecommendations(null, 'test-session', 5);

    expect($recommendations)->toBeArray();
});