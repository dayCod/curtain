<?php

declare(strict_types=1);

namespace Daycode\Curtain\Facades;

use Illuminate\Support\Facades\Facade;

class Curtain extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'curtain';
    }
}
