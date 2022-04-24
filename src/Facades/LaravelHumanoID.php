<?php

namespace MallardDuck\LaravelHumanoID\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Get the HumanoID integration manager class.
 *
 * @see \MallardDuck\LaravelHumanoID\LaravelHumanoID
 */
class LaravelHumanoID extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-humanoid';
    }
}
