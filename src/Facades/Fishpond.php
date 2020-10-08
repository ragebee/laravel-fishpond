<?php

declare (strict_types = 1);

namespace Ragebee\LaravelFishpond\Facades;

use Illuminate\Support\Facades\Facade;

class Fishpond extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'fishpond';
    }
}
