<?php

declare(strict_types = 1);

return [
    'route' => [
        'prefix' => 'graphql',
        'controller' => \Rebing\GraphQL\GraphQLController::class . '@query',
        'middleware' => [],
        'group_attributes' => [],
    ],

    'default_schema' => 'default',

    'batching' => [
        'enable' => true,
    ],

    'schemas' => [
        'default' => [
            'query' => [
                // Player
                'players' => App\GraphQL\Queries\Player\PlayersQuery::class,
                'player' => App\GraphQL\Queries\Player\PlayerQuery::class,
            ],
            'mutation' => [
                // Player
                'createPlayer' => App\GraphQL\Mutations\Player\CreatePlayerMutation::class,
                'updatePlayer' => App\GraphQL\Mutations\Player\UpdatePlayerMutation::class,
                'deletePlayer' => App\GraphQL\Mutations\Player\DeletePlayerMutation::class,

                // Championship
                'createChampionship' => App\GraphQL\Mutations\Championship\CreateChampionshipMutation::class,
                'updateChampionship' => App\GraphQL\Mutations\Championship\UpdateChampionshipMutation::class,
            ],
            'types' => [
                // Player
                'Player' => App\GraphQL\Types\PlayerType::class,
                'Game' => App\GraphQL\Types\GameType::class,
                'Championship' => App\GraphQL\Types\ChampionshipType::class,
            ],

            // Laravel HTTP middleware
            'middleware' => null,

            // Which HTTP methods to support; must be given in UPPERCASE!
            'method' => ['GET', 'POST'],

            // An array of middlewares, overrides the global ones
            'execution_middleware' => null,
        ],
    ],

    'types' => [
        // ExampleType::class,
        // ExampleRelationType::class,
        // \Rebing\GraphQL\Support\UploadType::class,
    ],

    'error_formatter' => [\Rebing\GraphQL\GraphQL::class, 'formatError'],
    'errors_handler' => [\Rebing\GraphQL\GraphQL::class, 'handleErrors'],

    'security' => [
        'query_max_complexity' => null,
        'query_max_depth' => null,
        'disable_introspection' => false,
    ],

    'pagination_type' => \Rebing\GraphQL\Support\PaginationType::class,

    'simple_pagination_type' => \Rebing\GraphQL\Support\SimplePaginationType::class,

    'defaultFieldResolver' => null,

    'headers' => [],

    'json_encoding_options' => 0,

    'apq' => [
        // Enable/Disable APQ - See https://www.apollographql.com/docs/apollo-server/performance/apq/#disabling-apq
        'enable' => env('GRAPHQL_APQ_ENABLE', false),

        // The cache driver used for APQ
        'cache_driver' => env('GRAPHQL_APQ_CACHE_DRIVER', config('cache.default')),

        // The cache prefix
        'cache_prefix' => config('cache.prefix') . ':graphql.apq',

        // The cache ttl in seconds - See https://www.apollographql.com/docs/apollo-server/performance/apq/#adjusting-cache-time-to-live-ttl
        'cache_ttl' => 300,
    ],

    /*
     * Execution middlewares
     */
    'execution_middleware' => [
        \Rebing\GraphQL\Support\ExecutionMiddleware\ValidateOperationParamsMiddleware::class,
        // AutomaticPersistedQueriesMiddleware listed even if APQ is disabled, see the docs for the `'apq'` configuration
        \Rebing\GraphQL\Support\ExecutionMiddleware\AutomaticPersistedQueriesMiddleware::class,
        \Rebing\GraphQL\Support\ExecutionMiddleware\AddAuthUserContextValueMiddleware::class,
        // \Rebing\GraphQL\Support\ExecutionMiddleware\UnusedVariablesMiddleware::class,
    ],
];
