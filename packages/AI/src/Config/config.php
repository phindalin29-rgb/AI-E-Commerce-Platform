<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Recommendations
    |--------------------------------------------------------------------------
    |
    | Settings for the AI-powered product recommendation engine.
    |
    */

    'recommendation' => [
        'enabled'      => true,
        'min_score'    => 0.5,
        'max_results'  => 10,
    ],

    /*
    |--------------------------------------------------------------------------
    | Chatbot
    |--------------------------------------------------------------------------
    |
    | Settings for the AI customer service chatbot.
    |
    */

    'chatbot' => [
        'enabled'        => true,
        'model'          => 'gpt-4',
        'system_prompt'  => 'You are a friendly and helpful shopping assistant for an e-commerce store. Help customers find products, answer questions about orders, and provide recommendations.',
    ],

    /*
    |--------------------------------------------------------------------------
    | Smart Search
    |--------------------------------------------------------------------------
    |
    | Settings for AI-powered semantic search.
    |
    */

    'smart_search' => [
        'enabled'     => true,
        'use_ai'      => true,
        'min_results' => 5,
    ],

    /*
    |--------------------------------------------------------------------------
    | Insights
    |--------------------------------------------------------------------------
    |
    | Settings for AI-generated analytics and insights.
    |
    */

    'insight' => [
        'enabled'  => true,
        'cache_ttl' => 3600,
    ],

];
