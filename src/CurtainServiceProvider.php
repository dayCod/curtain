<?php

declare(strict_types=1);

namespace Daycode\Curtain;

use Daycode\Curtain\Http\Middleware\CurtainMiddleware;
use Daycode\Curtain\Services\CurtainService;
use Illuminate\Contracts\Http\Kernel;
use Illuminate\Foundation\Http\Middleware\PreventRequestsDuringMaintenance;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class CurtainServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__.'/../config/curtain.php', 'curtain');

        $this->app->singleton('curtain', fn ($app): \Daycode\Curtain\Services\CurtainService => new CurtainService);
    }

    /**
     * Bootstrap any application services.
     */
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

        $this->replaceDefaultMaintenanceMiddleware($kernel);

        Route::middleware('web')
            ->group(__DIR__.'/routes.php');
    }

    /**
     * Replace the default PreventRequestsDuringMaintenance middleware with our own.
     * This allows us to support both maintenance mode and the preview feature.
     *
     * @return void
     */
    protected function replaceDefaultMaintenanceMiddleware(mixed $kernel)
    {
        $reflection = new \ReflectionClass($kernel);
        $middlewareProperty = $reflection->getProperty('middleware');
        $middlewareProperty->setAccessible(true);

        $currentMiddleware = $middlewareProperty->getValue($kernel);

        $filteredMiddleware = array_filter($currentMiddleware, fn ($middleware): bool => $middleware !== PreventRequestsDuringMaintenance::class);

        $middlewareProperty->setValue($kernel, array_values($filteredMiddleware));

        $kernel->prependMiddleware(CurtainMiddleware::class);
    }
}
