<?php

declare(strict_types=1);

namespace MallardDuck\LaravelHumanoID\Facades;

use Illuminate\Support\Facades\Facade;
use MallardDuck\LaravelHumanoID\HumanoIDConfig;
use RobThree\HumanoID\HumanoID;

/**
 * Get the HumanoID integration manager class.
 *
 * @method static bool              hasWordSetsFolder()
 * @method static bool              hasWordSets()
 * @method static HumanoIDConfig    getDefaultGeneratorConfig()
 * @method static HumanoID          getDefaultGenerator()
 *
 * @see \MallardDuck\LaravelHumanoID\HumanoIDManager
 */
class HumanoIDManager extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-humanoid';
    }
}
