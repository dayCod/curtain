<?php

declare(strict_types=1);

namespace Daycode\Curtain;

use Daycode\Curtain\Services\CurtainService;
use Illuminate\Support\ServiceProvider;

class CurtainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/curtain.php', 'curtain');

        $this->app->singleton('curtain', fn ($app): \Daycode\Curtain\Services\CurtainService => new CurtainService);
    }

    public function boot(): void
    {
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'curtain');

        $this->publishes([
            __DIR__.'/../config/curtain.php' => config_path('curtain.php'),
            __DIR__.'/../resources/views' => resource_path('views/vendor/curtain'),
        ], 'curtain');
    }
}
