<?php

namespace Meadow\Facades;

use Illuminate\Support\Facades\Facade;

class Meadow extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return 'meadow';
    }
}
