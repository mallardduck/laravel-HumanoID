<?php

declare(strict_types=1);

namespace MallardDuck\LaravelHumanoID\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Gets the default instance for the Laravel Application.
 *
 * @method static string    create(int $id)
 * @method static int       parse(string $text)
 *
 * @see \RobThree\HumanoID\HumanoID
 */
class HumanoID extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'humanoid';
    }
}
