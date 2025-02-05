<?php

declare(strict_types=1);

return [
    'default_template' => 'default',

    'excluded_paths' => [

        // Don't remove these line
        '_debugbar/*',
        'horizon/*',
        'nova/*',
        'curtain/*',
        'curtain/disable',
        // End

        // Here's your excluded paths

        //
    ],

    'allowed_ips' => [
        // '127.0.0.1',
    ],

    'refresh_interval' => 60, // seconds

    'templates' => [
        'default' => [
            'name' => 'Default Template',
            'view' => 'curtain::templates.default',
        ],
        'modern' => [
            'name' => 'Modern Template',
            'view' => 'curtain::templates.modern',
        ],
    ],

    'allow_custom_templates' => true,

    'custom_templates_path' => resource_path('views/vendor/curtain/templates'),
];
