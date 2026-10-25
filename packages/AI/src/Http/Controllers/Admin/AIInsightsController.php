<?php

namespace Webkul\AI\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Webkul\AI\Services\AI\InsightService;
use Webkul\AI\Services\AI\RecommendationService;

class AIInsightsController
{
    public function __construct(
        protected InsightService $insightService,
        protected RecommendationService $recommendationService
    ) {}

    /**
     * Display the AI insights dashboard.
     */
    public function index()
    {
        $insights = $this->insightService->getInsights();

        return view('ai::admin.insights.index', [
            'insights' => $insights,
            'recommendations' => $this->recommendationService->getRecommendations(null, null, 10),
        ]);
    }

    /**
     * Show the AI configuration page.
     */
    public function config()
    {
        return view('ai::admin.config.index');
    }

    /**
     * Update AI configuration.
     */
    public function updateConfig(Request $request)
    {
        $validated = $request->validate([
            'recommendation.enabled' => 'boolean',
            'recommendation.min_score' => 'numeric|min:0|max:1',
            'recommendation.max_results' => 'integer|min:1|max:50',
            'chatbot.enabled' => 'boolean',
            'smart_search.enabled' => 'boolean',
            'smart_search.use_ai' => 'boolean',
            'insight.enabled' => 'boolean',
        ]);

        foreach ($validated as $key => $value) {
            core()->setConfigData("ai.{$key}", $value);
        }

        return redirect()->back()->with('success', 'AI configuration updated successfully.');
    }
}