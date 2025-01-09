<p align="center">
  <img src="https://github.com/dayCod/curtain/blob/main/art/curtain-logo.png" alt="Curtain Logo">
</p>

<p align="center">
  <a href="https://packagist.org/packages/vendor/curtain"><img src="https://img.shields.io/packagist/v/vendor/curtain" alt="Latest Stable Version"></a>
  <a href="https://packagist.org/packages/vendor/curtain"><img src="https://img.shields.io/packagist/dt/vendor/curtain" alt="Total Downloads"></a>
  <a href="https://packagist.org/packages/vendor/curtain"><img src="https://img.shields.io/packagist/l/vendor/curtain" alt="License"></a>
<!--   <a href="https://github.com/dayCod/curtain/actions"><img src="https://github.com/dayCod/curtain/workflows/tests/badge.svg" alt="Build Status"></a> -->
</p>

## Elegantly Enhanced Maintenance Mode for Laravel

Curtain takes Laravel's maintenance mode to the next level by providing a beautiful, customizable, and feature-rich maintenance page system. Stop showing boring maintenance pages and create engaging "Coming Soon" pages with countdown timers, contact forms, and social media integration.

## Features

- 🎨 **Beautiful Pre-built Templates**
  - Multiple professional designs out of the box
  - Fully customizable with your branding
  - Mobile-responsive layouts

- ⏰ **Countdown Timer**
  - Show exactly when your site will be back
  - Auto-refresh when maintenance ends
  - Timezone support

- 📱 **Social Media Integration**
  - Keep users engaged during downtime
  - Customizable social media links
  - Share buttons integration

- 📬 **Contact Form**
  - Collect user inquiries during maintenance
  - Email/Slack notifications
  - Spam protection

- 🌍 **Multi-language Support**
  - Auto-detect browser language
  - Easy translation management
  - RTL support

- 📅 **Scheduled Maintenance**
  - Plan maintenance windows ahead
  - Automatic up/down scheduling
  - Timezone-aware scheduling

- 🔒 **IP Whitelist Management**
  - Allow specific IPs during maintenance
  - Temporary access links
  - Bulk import/export

- 📊 **Advanced Analytics**
  - Track visitor attempts during maintenance
  - Geographical data
  - Most requested pages

- 🔍 **Preview Mode**
  - Test maintenance page before activation
  - Device preview (Desktop/Tablet/Mobile)
  - Real-time customization

## Quick Installation

```bash
composer require vendor/curtain
```

## Basic Usage

```bash
# Show maintenance page with countdown
php artisan curtain:down --until="2024-01-10 15:00"

# Schedule maintenance
php artisan curtain:schedule --start="2024-01-10 14:00" --end="2024-01-10 15:00"

# Preview maintenance page
php artisan curtain:preview

# Disable maintenance mode
php artisan curtain:up
```

## Configuration

Publish the configuration file:

```bash
php artisan vendor:publish --tag="curtain-config"
```

Publish the views (optional):

```bash
php artisan vendor:publish --tag="curtain-views"
```

## Available Commands

```bash
# Basic commands
php artisan curtain:up                    # Disable maintenance mode
php artisan curtain:down                  # Enable maintenance mode
php artisan curtain:preview               # Preview maintenance page
php artisan curtain:schedule              # Schedule maintenance window

# Additional commands
php artisan curtain:whitelist             # Manage IP whitelist
php artisan curtain:translate             # Manage translations
php artisan curtain:status                # Check current status
```

## Template Customization

Curtain comes with several pre-built templates that you can easily customize:

```php
// config/curtain.php
return [
    'template' => 'default',
    'branding' => [
        'logo' => '/path/to/logo.png',
        'title' => 'Site Maintenance',
        'description' => 'We\'ll be back soon!',
    ],
    'features' => [
        'countdown' => true,
        'contact_form' => true,
        'social_links' => true,
    ],
];
```

## Facade Usage

```php
use Curtain;

// Check maintenance status
if (Curtain::isDown()) {
    // Site is in maintenance mode
}

// Schedule maintenance
Curtain::schedule('2024-01-10 14:00', '2024-01-10 15:00');

// Add IP to whitelist
Curtain::whitelist('192.168.1.1');
```

## Events

Curtain dispatches several events that you can listen to:

```php
Vendor\Curtain\Events\MaintenanceStarted
Vendor\Curtain\Events\MaintenanceEnded
Vendor\Curtain\Events\ContactSubmitted
Vendor\Curtain\Events\VisitorDetected
```

## Testing

```bash
composer test
```

## Contributing

Please see [CONTRIBUTING.md](CONTRIBUTING.md) for details.

## Security

If you discover any security-related issues, please email security@example.com instead of using the issue tracker.

## Credits

- [Your Name](https://github.com/yourusername)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
