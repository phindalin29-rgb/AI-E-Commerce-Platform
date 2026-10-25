<?php

namespace Webkul\AI\Services\AI;

use Webkul\AI\Models\SearchHistory;
use Webkul\Product\Repositories\ProductRepository;
use Webkul\MagicAI\Facades\MagicAI;
use Illuminate\Support\Facades\Cache;

class SmartSearchService
{
    public function __construct(
        protected ProductRepository $productRepository
    ) {}

    /**
     * Process a smart search query with intent extraction.
     *
     * @param  string  $query
     * @return array
     */
    public function search(string $query): array
    {
        $useAi = core()->getConfigData('ai.smart_search.use_ai') ?? true;

        $intent = $useAi
            ? $this->extractIntentWithAI($query)
            : $this->extractIntentRuleBased($query);

        $products = $this->searchProducts($intent);

        $suggestions = $this->getSuggestions($query);

        $this->recordSearch($query, $intent, count($products));

        return [
            'query' => $query,
            'intent' => $intent,
            'products' => $products,
            'suggestions' => $suggestions,
        ];
    }

    /**
     * Extract intent using AI.
     */
    protected function extractIntentWithAI(string $query): array
    {
        $cacheKey = 'ai.intent.' . md5($query);

        return Cache::remember($cacheKey, 3600, function () use ($query) {
            $prompt = $this->buildIntentPrompt($query);

            try {
                $response = MagicAI::generateContent($prompt);
                $intent = json_decode($response, true);

                if (! is_array($intent)) {
                    return $this->extractIntentRuleBased($query);
                }

                return $intent;
            } catch (\Exception $e) {
                report($e);

                return $this->extractIntentRuleBased($query);
            }
        });
    }

    /**
     * Build the intent extraction prompt.
     */
    protected function buildIntentPrompt(string $query): string
    {
        return implode("\n", [
            'Analyze the following product search query and extract structured intent information.',
            'Return ONLY valid JSON with this exact structure (no markdown, no explanation):',
            '',
            '{',
            '  "intent": "product_search",',
            '  "category": "category name or null",',
            '  "product_type": "type of product or null",',
            '  "min_price": number or null,',
            '  "max_price": number or null,',
            '  "brand": "brand name or null",',
            '  "features": "comma-separated features or null",',
            '  "search_terms": "key search terms"',
            '}',
            '',
            'Search query: "' . $query . '"',
            '',
            'JSON:',
        ]);
    }

    /**
     * Extract intent using rule-based fallback.
     */
    protected function extractIntentRuleBased(string $query): array
    {
        $intent = [
            'intent' => 'product_search',
            'category' => null,
            'product_type' => null,
            'min_price' => null,
            'max_price' => null,
            'brand' => null,
            'features' => null,
            'search_terms' => $query,
        ];

        // Extract price constraints
        if (preg_match('/under\s+\$?(\d+)/i', $query, $matches)) {
            $intent['max_price'] = (float) $matches[1];
        }

        if (preg_match('/above\s+\$?(\d+)/i', $query, $matches)) {
            $intent['min_price'] = (float) $matches[1];
        }

        if (preg_match('/between\s+\$?(\d+)\s+and\s+\$?(\d+)/i', $query, $matches)) {
            $intent['min_price'] = (float) $matches[1];
            $intent['max_price'] = (float) $matches[2];
        }

        // Extract category
        $categories = ['electronics', 'fashion', 'clothing', 'fitness', 'home', 'kitchen', 'beauty', 'sports', 'books', 'toys'];
        foreach ($categories as $cat) {
            if (stripos($query, $cat) !== false) {
                $intent['category'] = $cat;
                break;
            }
        }

        return $intent;
    }

    /**
     * Search products based on extracted intent.
     */
    protected function searchProducts(array $intent): array
    {
        $params = [
            'channel_id' => core()->getCurrentChannel()->id,
            'status' => 1,
            'visible_individually' => 1,
            'locale' => app()->getLocale(),
        ];

        if (! empty($intent['search_terms'])) {
            $params['query'] = $intent['search_terms'];
        }

        if (! empty($intent['max_price'])) {
            $params['price_to'] = $intent['max_price'];
        }

        if (! empty($intent['min_price'])) {
            $params['price_from'] = $intent['min_price'];
        }

        try {
            $products = $this->productRepository
                ->setSearchEngine('database')
                ->getAll($params);

            return $products->take(20)->map(function ($product) {
                return [
                    'id' => $product->id,
                    'name' => $product->name,
                    'price' => core()->convertPrice($product->price),
                    'image' => $product->image_url ?? $product->images->first()->image ?? '/images/placeholder.png',
                    'category' => $product->categories->first()->name ?? '',
                ];
            })->toArray();
        } catch (\Exception $e) {
            report($e);

            return [];
        }
    }

    /**
     * Get search suggestions.
     */
    protected function getSuggestions(string $query): array
    {
        if (strlen($query) < 2) {
            return [];
        }

        return Cache::remember('ai.suggestions.' . md5($query), 600, function () use ($query) {
            try {
                $products = $this->productRepository
                    ->setSearchEngine('database')
                    ->getAll([
                        'query' => $query,
                        'channel_id' => core()->getCurrentChannel()->id,
                        'status' => 1,
                        'visible_individually' => 1,
                        'locale' => app()->getLocale(),
                    ]);

                return $products->take(5)->pluck('name')->toArray();
            } catch (\Exception $e) {
                return [];
            }
        });
    }

    /**
     * Record the search.
     */
    protected function recordSearch(string $query, array $intent, int $resultCount): void
    {
        try {
            SearchHistory::create([
                'customer_id' => auth('customer')->id() ?: null,
                'session_id' => session()->getId(),
                'query' => $query,
                'intent' => $intent,
                'results_count' => $resultCount,
                'ip_address' => request()->ip(),
            ]);
        } catch (\Exception $e) {
            report($e);
        }
    }
}