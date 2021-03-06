<?php

declare(strict_types=1);

namespace MallardDuck\LaravelHumanoID;

use Illuminate\Config\Repository;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use MallardDuck\LaravelHumanoID\Facades\HumanoIDManager as HumanoIDManagerFacade;

class LaravelHumanoIDServiceProvider extends ServiceProvider
{
    public static string $packageName = 'laravel-humanoid';

    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        $baseConfigPath = implode(DIRECTORY_SEPARATOR, [
            __DIR__,
            '..',
            'config',
            'humanoid.php',
        ]);
        $this->publishes([
            $baseConfigPath => config_path('humanoid.php'),
        ], ['humanoid-all', 'config', 'laravel-humanoid-config']);

        $humanoidPath = implode(DIRECTORY_SEPARATOR, [
            HumanoIDManager::getHumanoIDVendorPath(),
            'data',
            '',
        ]);
        $this->publishes([
            $humanoidPath.'space-words.json' => resource_path('humanoid' . DIRECTORY_SEPARATOR . 'space-words.json'),
            $humanoidPath.'zoo-words.json' => resource_path('humanoid' . DIRECTORY_SEPARATOR . 'zoo-words.json'),
        ], ['humanoid-all', 'humanoid']);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../config/humanoid.php',
            'humanoid'
        );

        $this->app->singleton(HumanoIDManagerFacade::class, function () {
            return new HumanoIDManager(
                fn () => new Repository(Container::getInstance()->make('config')->get('humanoid')),
            );
        });
        $this->app->alias(HumanoIDManagerFacade::class, static::$packageName);
        $this->app->alias(HumanoIDManagerFacade::class, HumanoIDManager::class);
    }
}
