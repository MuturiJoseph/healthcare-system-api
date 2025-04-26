<?php

return [
    'defaults' => [
        'routes' => [
            'docs' => 'api/docs', // JSON file at /api/docs/api-docs.json
            'docs_json' => 'api-docs.json',
            'docs_yaml' => 'api-docs.yaml',
            'oauth2_callback' => 'api/oauth2-callback',
            'middleware' => [
                'api' => [],
                'asset' => [],
                'docs' => [],
                'oauth2_callback' => [],
            ],
            'group' => 'api',
        ],
        'paths' => [
            'docs' => storage_path('api-docs'),
            'docs_json' => 'api-docs.json',
            'docs_yaml' => 'api-docs.yaml',
            'annotations' => base_path('app'), // Scan controllers for annotations
            'base' => env('L5_SWAGGER_BASE_PATH', null),
            'swagger_ui_assets_path' => env('L5_SWAGGER_UI_ASSETS_PATH', 'vendor/swagger-api/swagger-ui/dist'),
            'excludes' => [],
        ],
        'info' => [
            'title' => 'Health Information System API',
            'description' => 'API for managing health programs and clients, restricted to doctors.',
            'version' => '1.0.0',
        ],
        'securityDefinitions' => [
            'securitySchemes' => [
                'sanctum' => [
                    'type' => 'apiKey',
                    'name' => 'Authorization',
                    'in' => 'header',
                    'description' => 'Enter token in format: Bearer <token>',
                ],
            ],
        ],
    ],
];