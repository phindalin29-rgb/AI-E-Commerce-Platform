<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class PreventPromptInjection
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): \Symfony\Component\HttpFoundation\Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Sanitize all string inputs to prevent prompt injection
        $inputs = $request->all();

        foreach ($inputs as $key => $value) {
            if (is_string($value)) {
                $request->offsetSet($key, $this->sanitize($value));
            }
        }

        return $next($request);
    }

    /**
     * Sanitize input to prevent prompt injection attacks.
     */
    protected function sanitize(string $value): string
    {
        // Remove common prompt injection patterns
        $patterns = [
            '/ignore\s+(all\s+)?(previous|above|prior)\s+instructions?/i',
            '/disregard\s+(all\s+)?(previous|above|prior)\s+instructions?/i',
            '/forget\s+(all\s+)?(previous|above|prior)\s+instructions?/i',
            '/you\s+are\s+now\s+(a|an)\s+/i',
            '/new\s+instructions?:/i',
            '/system\s*:\s*/i',
            '/assistant\s*:\s*/i',
            '/user\s*:\s*/i',
        ];

        $sanitized = preg_replace($patterns, '', $value);

        // Remove excessive whitespace
        $sanitized = preg_replace('/\s+/', ' ', $sanitized);

        return trim($sanitized);
    }
}