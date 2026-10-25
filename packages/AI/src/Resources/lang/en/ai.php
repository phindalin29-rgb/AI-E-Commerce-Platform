<?php

return [

    'menu' => [
        'ai'              => 'AI',
        'recommendations' => 'Recommendations',
        'chatbot'         => 'Chatbot',
        'smart_search'    => 'Smart Search',
        'insights'        => 'Insights',
        'search_history'  => 'Search History',
        'user_interactions' => 'User Interactions',
    ],

    'messages' => [
        'enabled'               => 'Enabled',
        'disabled'              => 'Disabled',
        'save'                  => 'Save',
        'saved'                 => 'Saved successfully.',
        'settings_updated'      => 'Settings have been updated successfully.',
        'no_data'               => 'No records found.',
        'actions'               => 'Actions',
        'view'                  => 'View',
        'edit'                  => 'Edit',
        'delete'                => 'Delete',
        'confirm_delete'        => 'Are you sure you want to delete this item?',
    ],

    'recommendations' => [
        'title'                => 'Recommendations',
        'description'          => 'AI-powered product recommendations based on customer behavior and preferences.',
        'min_score'            => 'Minimum Score',
        'max_results'          => 'Maximum Results',
        'score'                => 'Score',
        'product'              => 'Product',
        'recommended_product'  => 'Recommended Product',
        'type'                 => 'Type',
        'context'              => 'Context',
        'customer'             => 'Customer',
        'enabled_description'  => 'Enable AI product recommendations.',
    ],

    'chatbot' => [
        'title'               => 'Chatbot',
        'description'         => 'AI-powered customer service chatbot.',
        'model'               => 'Model',
        'system_prompt'       => 'System Prompt',
        'enabled_description' => 'Enable the AI chatbot for customer support.',
    ],

    'smart_search' => [
        'title'               => 'Smart Search',
        'description'         => 'AI-powered semantic search to understand customer intent.',
        'use_ai'              => 'Use AI for Search',
        'min_results'         => 'Minimum Results',
        'enabled_description' => 'Enable AI-powered smart search.',
        'query'               => 'Query',
        'intent'              => 'Intent',
        'results_count'       => 'Results Count',
    ],

    'insights' => [
        'title'               => 'Insights',
        'description'         => 'AI-generated analytics and insights for your store.',
        'cache_ttl'           => 'Cache TTL (seconds)',
        'enabled_description' => 'Enable AI-powered insights and analytics.',
    ],

    'search_history' => [
        'title'          => 'Search History',
        'query'          => 'Query',
        'intent'         => 'Intent',
        'results_count'  => 'Results Count',
        'customer'       => 'Customer',
        'session'        => 'Session',
        'date'           => 'Date',
    ],

    'user_interactions' => [
        'title'            => 'User Interactions',
        'product'          => 'Product',
        'customer'         => 'Customer',
        'interaction_type' => 'Interaction Type',
        'weight'           => 'Weight',
        'metadata'         => 'Metadata',
        'session'          => 'Session',
        'date'             => 'Date',
        'view'             => 'View',
        'purchase'         => 'Purchase',
        'wishlist'         => 'Wishlist',
        'cart'             => 'Cart',
        'search'           => 'Search',
    ],

    'product_views' => [
        'title'       => 'Product Views',
        'product'     => 'Product',
        'customer'    => 'Customer',
        'session'     => 'Session',
        'ip_address'  => 'IP Address',
        'user_agent'  => 'User Agent',
        'referrer'    => 'Referrer',
        'date'        => 'Date',
    ],

    'errors' => [
        'model_not_found' => 'The requested resource could not be found.',
        'invalid_input'   => 'The provided input is invalid.',
        'service_unavailable' => 'The AI service is currently unavailable. Please try again later.',
    ],

];
