<?php

declare(strict_types=1);

namespace Daycode\Curtain\Facades;

use Illuminate\Support\Facades\Facade;

class Curtain extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'curtain';
    }
}
