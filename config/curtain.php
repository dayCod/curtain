<?php

declare(strict_types=1);

return [
    'default_template' => 'default',

    'excluded_paths' => [
        '_debugbar/*',
        'horizon/*',
        'nova/*',
    ],

    'allowed_ips' => [
        // '127.0.0.1',
    ],

    'refresh_interval' => 60, // seconds
];
