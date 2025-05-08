<p align="center">
  <img src="https://github.com/dayCod/curtain/blob/master/art/curtain-logo.png?raw=true" alt="Curtain Logo">
</p>

<p align="center">
  <a href="https://packagist.org/packages/daycode/curtain"><img src="https://img.shields.io/packagist/v/daycode/curtain" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/daycode/curtain"><img src="https://img.shields.io/packagist/dt/daycode/curtain" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/daycode/curtain"><img src="https://img.shields.io/packagist/l/daycode/curtain" alt="License"></a>
</p>

## Enhanced Laravel Maintenance Mode Handler

Curtain is a powerful Laravel package that enhances your application's maintenance mode functionality. Instead of the basic maintenance page, Curtain provides beautiful templates, countdown timers, IP whitelisting, and more flexible control over your maintenance mode.

## Features

- 🎨 **Beautiful Templates**
  - Multiple pre-built templates
  - Customizable designs
  - Support for custom templates
  - Modern, responsive layouts

- ⏲️ **Countdown Timer**
  - Auto-disable maintenance mode
  - Real-time countdown display
  - Automatic page refresh
  - Configurable durations

- 🔒 **Advanced Access Control**
  - IP address whitelisting
  - Path exclusions with wildcard support
  - Bypass token generation
  - Flexible middleware system

- 🛠️ **Developer Friendly**
  - Simple command-line interface
  - Preview maintenance pages
  - Easy configuration
  - Extensible architecture

## Quick Installation

1. Install the package via Composer:
```bash
composer require daycode/curtain

2. Publish the configuration:
```bash
php artisan vendor:publish --provider="Daycode\Curtain\CurtainServiceProvider"
```

3. Preview maintenance page:
```bash
php artisan curtain:preview --template=modern --timer="30 minutes"
```

4. Disable maintenance mode:
```bash
php artisan curtain:down
```

## Configuration

After publishing the configuration file, you can modify these settings in `config/curtain.php`:
```php
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

```

## Available Commands
Maintenance Mode Control:

```bash
# Enable with options
php artisan curtain:up [options]

# Available options:
--timer="2 hours"      # Set duration
--message="text"       # Custom message
--template="modern"    # Select template
--refresh             # Enable auto-refresh
--secret="token"      # Custom bypass token

# Disable maintenance mode
php artisan curtain:down

# Preview maintenance page
php artisan curtain:preview [options]
```

## Template Preview

<details>
<summary>🎨 View Previews</summary>

### Modern Template
<p align="center">
  <img src="https://github.com/dayCod/curtain/blob/master/art/modern-page-example.png?raw=true" alt="Modern Template" width="600px">
</p>

### Default Template
<p align="center">
  <img src="https://github.com/dayCod/curtain/blob/master/art/default-page-example.png?raw=true" alt="Default Template" width="600px">
</p>

</details>

## Testing
```bash
composer test
```

## Contributing
Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details on contributing to Curtain.

## Security

If you discover any security-related issues, please email daycodestudioproject@gmail.com instead of using the issue tracker.

## Credits

- [Daycode](https://github.com/dayCod)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
