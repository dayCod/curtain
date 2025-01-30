<?php

declare(strict_types=1);

namespace Daycode\Curtain;

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Daycode\Curtain\Services\CurtainService;
use Daycode\Curtain\Http\Middleware\CurtainMiddleware;

class CurtainServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/curtain.php', 'curtain');

        $this->app->singleton('curtain', fn ($app): \Daycode\Curtain\Services\CurtainService => new CurtainService);
    }

    public function boot(Kernel $kernel): void
    {
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/curtain'),
        ], 'curtain-views');

        $this->publishes([
            __DIR__.'/../config/curtain.php' => config_path('curtain.php'),
        ], 'curtain-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\CurtainUpCommand::class,
                Commands\CurtainDownCommand::class,
                Commands\CurtainPreviewCommand::class,
                Commands\CurtainTemplatesCommand::class,
            ]);
        }

        $this->loadRoutesFrom(__DIR__.'/routes.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'curtain');

        $kernel->prependMiddleware(CurtainMiddleware::class);

        Route::middleware('web')
            ->group(__DIR__.'/routes.php');
    }
}
