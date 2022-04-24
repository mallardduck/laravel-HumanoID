<?php

namespace MallardDuck\LaravelHumanoID;

use Illuminate\Support\ServiceProvider;
use MallardDuck\LaravelHumanoID\Commands\LaravelHumanoIDCommand;

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
        $this->publishes([
            __DIR__.'/../config/humanoid.php' => config_path('humanoid.php'),
        ]);

        if ($this->app->runningInConsole()) {
            // $this->commands([
            //     LaravelHumanoIDCommand::class,
            // ]);
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\MallardDuck\LaravelHumanoID\Facades\LaravelHumanoID::class, function ($app) {
            return new LaravelHumanoID(
                $app->config('humanoid.wordSetsBasePath', resource_path('humanoid/')),
                $app->config('humanoid.defaultConfig', null),
            );
        });
    }
}
