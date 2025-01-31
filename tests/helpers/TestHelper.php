<?php

declare(strict_types=1);

namespace Daycode\Curtain\Tests\Helpers;

use Illuminate\Support\Facades\File;

class TestHelper
{
    public static function createMaintenanceFile(array $data = []): void
    {
        $path = test()->app->storagePath('framework/down');

        File::put($path, json_encode($data, JSON_PRETTY_PRINT));
    }

    public static function removeMaintenanceFile(): void
    {
        $path = test()->app->storagePath('framework/down');

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
