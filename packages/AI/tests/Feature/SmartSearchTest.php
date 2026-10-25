<?php

use Webkul\AI\Models\SearchHistory;
use Webkul\AI\Services\AI\SmartSearchService;

uses(\Illuminate\Foundation\Testing\RefreshDatabase::class);

test('smart search extracts intent from natural language', function () {
    $service = app(SmartSearchService::class);

    $result = $service->search('wireless headphones under $100');

    expect($result['query'])->toBe('wireless headphones under $100')
        ->and($result['intent'])->toBeArray()
        ->and($result['products'])->toBeArray();
});

test('search records history', function () {
    $service = app(SmartSearchService::class);

    $service->search('laptop for programming');

    expect(SearchHistory::where('query', 'laptop for programming')->count())->toBe(1);
});