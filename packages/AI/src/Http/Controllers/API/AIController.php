<?php

namespace Webkul\AI\Http\Controllers\API;

use Illuminate\Http\JsonResponse;
use Webkul\Shop\Http\Controllers\API\APIController;
use Webkul\AI\Services\AI\ChatbotService;
use Webkul\AI\Services\AI\SmartSearchService;
use Webkul\AI\Services\AI\RecommendationService;
use Webkul\AI\Services\AI\InsightService;
use Illuminate\Http\Request;

class AIController extends APIController
{
    public function __construct(
        protected ChatbotService $chatbotService,
        protected SmartSearchService $smartSearchService,
        protected RecommendationService $recommendationService,
        protected InsightService $insightService
    ) {}

    /**
     * AI chat endpoint.
     */
    public function chat(Request $request): JsonResponse
    {
        $request->validate([
            'message' => 'required|string|max:500',
            'session_id' => 'nullable|string|max:100',
        ]);

        $sessionId = $request->session_id ?? session()->getId();
        $customerId = auth('customer')->id() ?: null;

        $result = $this->chatbotService->chat(
            $request->message,
            $sessionId,
            $customerId
        );

        return response()->json($result);
    }

    /**
     * Smart search endpoint.
     */
    public function smartSearch(Request $request): JsonResponse
    {
        $request->validate([
            'query' => 'required|string|max:500',
        ]);

        $result = $this->smartSearchService->search($request->query);

        return response()->json($result);
    }

    /**
     * Search suggestions endpoint.
     */
    public function searchSuggestions(Request $request): JsonResponse
    {
        $request->validate([
            'q' => 'required|string|min:2|max:100',
        ]);

        $suggestions = $this->smartSearchService->getSuggestions($request->q);

        return response()->json([
            'suggestions' => $suggestions,
        ]);
    }

    /**
     * Product recommendations endpoint.
     */
    public function recommendations(Request $request): JsonResponse
    {
        $request->validate([
            'limit' => 'nullable|integer|min:1|max:50',
        ]);

        $limit = $request->limit ?? 12;
        $sessionId = session()->getId();
        $customerId = auth('customer')->id() ?: null;

        $products = $this->recommendationService->getRecommendations(
            $customerId,
            $sessionId,
            $limit
        );

        return response()->json([
            'products' => $products,
            'session_id' => $sessionId,
        ]);
    }

    /**
     * Related products endpoint.
     */
    public function relatedProducts(int $id): JsonResponse
    {
        $products = $this->recommendationService->getRelatedProducts($id);

        return response()->json([
            'products' => $products,
        ]);
    }

    /**
     * AI insights endpoint (admin).
     */
    public function insights(): JsonResponse
    {
        $insights = $this->insightService->getInsights();

        return response()->json($insights);
    }

    /**
     * Record product view.
     */
    public function recordView(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
        ]);

        \Webkul\AI\Models\ProductView::create([
            'product_id' => $request->product_id,
            'customer_id' => auth('customer')->id() ?: null,
            'session_id' => session()->getId(),
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'referrer' => $request->referer,
        ]);

        return response()->json(['success' => true]);
    }

    /**
     * Record user interaction.
     */
    public function recordInteraction(Request $request): JsonResponse
    {
        $request->validate([
            'product_id' => 'required|integer|exists:products,id',
            'type' => 'required|string|in:view,wishlist,cart,purchase,search',
        ]);

        $this->recommendationService->recordInteraction([
            'product_id' => $request->product_id,
            'type' => $request->type,
            'customer_id' => auth('customer')->id() ?: null,
            'session_id' => session()->getId(),
            'ip_address' => $request->ip(),
        ]);

        return response()->json(['success' => true]);
    }
}