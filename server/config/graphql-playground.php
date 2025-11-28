<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | Set the URI at which the GraphQL Playground can be viewed
    | and any additional configuration for the route.
    |
    */

    'route' => [
        'uri' => '/graphiql',
        'name' => 'graphql-playground',
        'middleware' => [
            'web',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Default Endpoint
    |--------------------------------------------------------------------------
    |
    | The default endpoint that the Playground should send requests to.
    |
    */

    'endpoint' => '/graphql',

    /*
    |--------------------------------------------------------------------------
    | Subscription Endpoint
    |--------------------------------------------------------------------------
    |
    | The endpoint for subscription requests.
    |
    */

    'subscription_endpoint' => env('GRAPHQL_PLAYGROUND_SUBSCRIPTION_ENDPOINT', null),

    /*
    |--------------------------------------------------------------------------
    | Default Settings
    |--------------------------------------------------------------------------
    |
    | Default settings for the Playground interface.
    |
    */

    'settings' => [
        'editor.theme' => 'dark',
        'editor.cursorShape' => 'line',
        'editor.reuseHeaders' => true,
        'tracing.hideTracingResponse' => true,
        'queryPlan.hideQueryPlanResponse' => true,
        'editor.fontSize' => 14,
        'editor.fontFamily' => "'Source Code Pro', 'Consolas', 'Inconsolata', 'Droid Sans Mono', 'Monaco', monospace",
        'request.credentials' => 'omit',
    ],
];
