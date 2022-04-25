<?php

declare(strict_types=1);

namespace MallardDuck\LaravelHumanoID\Facades;

use Illuminate\Support\Facades\Facade;
use MallardDuck\LaravelHumanoID\HumanoIDConfig;
use RobThree\HumanoID\HumanoID;

/**
 * Get the HumanoID integration manager class.
 *
 * @method static hasWordSetsFolder(): bool
 * @method static hasWordSets(): bool
 * @method static getDefaultGeneratorConfig(): HumanoIDConfig
 * @method static getDefaultGenerator(): HumanoID
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
