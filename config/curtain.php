<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Default Maintenance Template
    |--------------------------------------------------------------------------
    |
    | This is the default template that will be used for the maintenance page.
    | The value should match one of the template keys in the templates array.
    |
    */
    'default_template' => 'default',

    /*
    |--------------------------------------------------------------------------
    | Excluded Paths
    |--------------------------------------------------------------------------
    |
    | These paths will be accessible even when the application is in maintenance
    | mode. You can use wildcards (*) to match multiple paths.
    | Warning: Removing core paths may break maintenance mode functionality.
    |
    */
    'excluded_paths' => [
        '_debugbar/*',
        'horizon/*',
        'nova/*',
        'curtain/*',

        // Exclude your paths here..
    ],

    /*
    |--------------------------------------------------------------------------
    | IP Whitelist
    |--------------------------------------------------------------------------
    |
    | These IP addresses will be able to access the application even when it is
    | in maintenance mode. Uncomment and add IPs that should have access.
    |
    */
    'allowed_ips' => [
        // '127.0.0.1',
    ],

    /*
    |--------------------------------------------------------------------------
    | Auto-Refresh Interval
    |--------------------------------------------------------------------------
    |
    | Time in seconds before the maintenance page automatically refreshes.
    | This is useful for checking if maintenance mode has been disabled.
    |
    */
    'refresh_interval' => 60, // seconds

    /*
    |--------------------------------------------------------------------------
    | Available Templates
    |--------------------------------------------------------------------------
    |
    | List of available maintenance page templates. Each template should have a
    | name and a view path. Add your custom templates here if needed.
    |
    */
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

    /*
    |--------------------------------------------------------------------------
    | Custom Templates
    |--------------------------------------------------------------------------
    |
    | Allow users to create and use custom maintenance templates. When enabled,
    | templates can be placed in the custom templates directory.
    |
    */
    'allow_custom_templates' => true,

    /*
    |--------------------------------------------------------------------------
    | Custom Templates Path
    |--------------------------------------------------------------------------
    |
    | The path where custom maintenance templates can be stored. These templates
    | will be automatically detected and made available for use.
    |
    */
    'custom_templates_path' => resource_path('views/vendor/curtain/templates'),
];
