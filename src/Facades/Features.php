<?php

namespace FilamentPro\Features\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \FilamentPro\Features\Features
 */
class Features extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'filament-features';
    }
}
