<?php

namespace Webkul\AI\Services\AI;

use Webkul\MagicAI\Facades\MagicAI;
use Webkul\AI\Models\SearchHistory;
use Webkul\Product\Repositories\ProductRepository;
use Illuminate\Support\Facades\Cache;

class ChatbotService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    /**
     * Process a chat message and return AI response with product suggestions.
     *
     * @param  string  $message
     * @param  string  $sessionId
     * @param  int|null  $customerId
     * @return array
     */
    public function chat(string $message, string $sessionId, ?int $customerId = null): array
    {
        $context = $this->buildContext($message, $sessionId, $customerId);

        $prompt = $this->buildPrompt($message, $context);

        try {
            $response = MagicAI::generateContent($prompt);

            $products = $this->extractProductsFromResponse($response, $message);

            $this->recordSearchHistory($message, $sessionId, $customerId, [
                'products' => count($products),
                'engine' => 'ai',
            ]);

            return [
                'response' => $response,
                'products' => $products,
                'session_id' => $sessionId,
            ];
        } catch (\Exception $e) {
            report($e);

            return [
                'response' => 'I apologize, but I am having trouble connecting to the AI service. Please try again later.',
                'products' => [],
                'session_id' => $sessionId,
                'error' => true,
            ];
        }
    }

    /**
     * Build context from recent interactions and product catalog.
     */
    protected function buildContext(string $message, string $sessionId, ?int $customerId): array
    {
        $recentSearches = SearchHistory::query()
            ->when($customerId, fn ($q) => $q->where('customer_id', $customerId))
            ->when(! $customerId, fn ($q) => $q->where('session_id', $sessionId))
            ->latest()
            ->take(5)
            ->pluck('query')
            ->toArray();

        $catalogSummary = $this->getCatalogSummary();

        return [
            'recent_searches' => $recentSearches,
            'catalog' => $catalogSummary,
            'currency' => core()->getCurrentCurrency()->code,
            'locale' => app()->getLocale(),
        ];
    }

    /**
     * Build the AI prompt with context.
     */
    protected function buildPrompt(string $message, array $context): string
    {
        $catalogSummary = $context['catalog'];

        $recentSearches = ! empty($context['recent_searches'])
            ? "Recent searches: " . implode(', ', $context['recent_searches'])
            : '';

        return implode("\n\n", [
            'You are a helpful AI shopping assistant for an e-commerce store.',
            'Your role is to help customers find products, answer questions, and make purchasing decisions.',
            '',
            "Customer message: {$message}",
            '',
            "Catalog summary: {$catalogSummary}",
            $recentSearches,
            '',
            'Rules:',
            '- NEVER invent product names, prices, or specifications that are not in the catalog',
            '- If you cannot find a matching product, say so honestly',
            '- Keep responses concise and helpful',
            '- When recommending products, mention the name and price',
            '- Format product recommendations clearly',
            '',
            'Respond to the customer message now.',
        ]);
    }

    /**
     * Get a summary of the product catalog for AI context.
     */
    protected function getCatalogSummary(): string
    {
        return Cache::remember('ai.catalog_summary', 3600, function () {
            $categories = \Webkul\Category\Models\Category::where('status', 1)
                ->where('status', 1)
                ->take(20)
                ->get()
                ->pluck('name')
                ->implode(', ');

            $productCount = \Webkul\Product\Models\Product::where('status', 1)->count();

            return "Available categories: {$categories}. Total active products: {$productCount}.";
        });
    }

    /**
     * Extract product recommendations from AI response.
     */
    protected function extractProductsFromResponse(string $response, string $query): array
    {
        $products = [];

        try {
            $searchTerms = $this->extractSearchTerms($query);

            if (! empty($searchTerms)) {
                $results = $this->productRepository
                    ->setSearchEngine('database')
                    ->getAll([
                        'query' => $searchTerms,
                        'channel_id' => core()->getCurrentChannel()->id,
                        'status' => 1,
                        'visible_individually' => 1,
                        'locale' => app()->getLocale(),
                    ]);

                $products = $results->take(5)->map(function ($product) {
                    return [
                        'id' => $product->id,
                        'name' => $product->name,
                        'price' => core()->convertPrice($product->price),
                        'image' => $product->image_url ?? $product->images->first()->image ?? '/images/placeholder.png',
                        'category' => $product->categories->first()->name ?? '',
                    ];
                })->toArray();
            }
        } catch (\Exception $e) {
            report($e);
        }

        return $products;
    }

    /**
     * Extract search terms from a natural language query.
     */
    protected function extractSearchTerms(string $query): string
    {
        $stopWords = ['the', 'a', 'an', 'is', 'are', 'for', 'with', 'under', 'above', 'between', 'i', 'need', 'want', 'looking', 'find', 'me', 'show', 'do', 'you', 'have', 'to', 'in', 'on', 'at', 'by', 'from', 'about', 'what', 'how', 'can', 'could', 'would', 'should', 'will', 'may', 'might', 'shall', 'please'];

        $terms = preg_split('/\s+/', strtolower($query));
        $filtered = array_diff($terms, $stopWords);

        return implode(' ', $filtered);
    }

    /**
     * Record search history.
     */
    protected function recordSearchHistory(string $query, string $sessionId, ?int $customerId, array $data = []): void
    {
        try {
            SearchHistory::create([
                'customer_id' => $customerId,
                'session_id' => $sessionId,
                'query' => $query,
                'intent' => $data ?? null,
                'results_count' => $data['products'] ?? 0,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Exception $e) {
            report($e);
        }
    }
}