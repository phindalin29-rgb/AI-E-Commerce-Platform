<?php

use Illuminate\Support\Facades\Route;
use Webkul\AI\Http\Controllers\API\AIController;

Route::group(['prefix' => 'ai', 'middleware' => ['web', 'shop', 'prompt.injection']], function () {
    // Rate limited AI endpoints
    Route::middleware('throttle:30,1')->group(function () {
        Route::post('chat', [AIController::class, 'chat'])->name('ai.chat');
        Route::post('smart-search', [AIController::class, 'smartSearch'])->name('ai.smart-search');
    });

    Route::get('search-suggestions', [AIController::class, 'searchSuggestions'])->name('ai.search-suggestions');

    // Cached recommendations (no rate limit needed)
    Route::get('recommendations', [AIController::class, 'recommendations'])->name('ai.recommendations');
    Route::get('related/{id}', [AIController::class, 'relatedProducts'])->name('ai.related-products');

    // Interaction tracking
    Route::post('record-view', [AIController::class, 'recordView'])->name('ai.record-view');
    Route::post('record-interaction', [AIController::class, 'recordInteraction'])->name('ai.record-interaction');

    // Admin-only insights
    Route::middleware(['admin', 'prompt.injection'])->group(function () {
        Route::get('insights', [AIController::class, 'insights'])->name('ai.insights');
    });
});