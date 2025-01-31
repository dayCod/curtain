<?php

declare(strict_types=1);

namespace Daycode\Curtain\Tests;

use Daycode\Curtain\CurtainServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        // Ensure storage directory exists
        $this->makeStorageDirectories();
    }

    protected function getPackageProviders($app): array
    {
        return [
            CurtainServiceProvider::class,
        ];
    }

    protected function getPackageAliases($app): array
    {
        return [
            'Curtain' => \Daycode\Curtain\Facades\Curtain::class,
        ];
    }

    protected function defineEnvironment($app): void
    {
        // Set storage path
        $app->useStoragePath(__DIR__.'/storage');
    }

    protected function makeStorageDirectories(): void
    {
        // Create necessary directories
        $directories = [
            __DIR__.'/storage',
            __DIR__.'/storage/framework',
            __DIR__.'/storage/framework/cache',
            __DIR__.'/storage/framework/sessions',
            __DIR__.'/storage/framework/views',
        ];

        foreach ($directories as $directory) {
            if (! is_dir($directory)) {
                mkdir($directory, 0777, true);
            }
        }
    }

    protected function tearDown(): void
    {
        // Cleanup maintenance file
        $maintenanceFile = __DIR__.'/storage/framework/down';
        if (file_exists($maintenanceFile)) {
            unlink($maintenanceFile);
        }

        parent::tearDown();
    }
}
