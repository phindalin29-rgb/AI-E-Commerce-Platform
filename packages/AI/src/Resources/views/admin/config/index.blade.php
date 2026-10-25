<x-admin::layout>
    <x-slot:title>AI Configuration</x-slot>

    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-slate-800 mb-6">AI Configuration</h1>

        <form action="{{ route('admin.ai.config.update') }}" method="POST">
            @csrf
            <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Recommendation Engine</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-slate-700">Enable Recommendations</label>
                        <input type="checkbox" name="recommendation.enabled" value="1" {{ core()->getConfigData('ai.recommendation.enabled') ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Minimum Score (0-1)</label>
                        <input type="number" step="0.1" min="0" max="1" name="recommendation.min_score" value="{{ core()->getConfigData('ai.recommendation.min_score') ?? 0.1 }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-700 mb-1">Max Results</label>
                        <input type="number" min="1" max="50" name="recommendation.max_results" value="{{ core()->getConfigData('ai.recommendation.max_results') ?? 12 }}" class="w-full px-3 py-2 border border-slate-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">Smart Search</h2>
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-slate-700">Enable Smart Search</label>
                        <input type="checkbox" name="smart_search.enabled" value="1" {{ core()->getConfigData('ai.smart_search.enabled') ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    </div>
                    <div class="flex items-center justify-between">
                        <label class="text-sm font-medium text-slate-700">Use AI for Intent Extraction</label>
                        <input type="checkbox" name="smart_search.use_ai" value="1" {{ core()->getConfigData('ai.smart_search.use_ai') ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl border border-slate-200 p-6 mb-6">
                <h2 class="text-lg font-semibold text-slate-800 mb-4">AI Insights</h2>
                <div class="flex items-center justify-between">
                    <label class="text-sm font-medium text-slate-700">Enable AI Insights Dashboard</label>
                    <input type="checkbox" name="insight.enabled" value="1" {{ core()->getConfigData('ai.insight.enabled') ? 'checked' : '' }} class="rounded border-slate-300 text-indigo-600 focus:ring-indigo-500">
                </div>
            </div>

            <button type="submit" class="px-6 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">Save Configuration</button>
        </form>
    </div>
</x-admin::layout>
