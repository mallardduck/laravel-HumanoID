<?php

namespace MallardDuck\LaravelHumanoID\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Get the HumanoID integration manager class.
 *
 * @see \MallardDuck\LaravelHumanoID\HumanoIDManager
 */
class LaravelHumanoID extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-humanoid';
    }
}
