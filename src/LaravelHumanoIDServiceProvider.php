<?php

declare(strict_types=1);

namespace MallardDuck\LaravelHumanoID;

use Composer\InstalledVersions;
use Illuminate\Container\Container;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use MallardDuck\LaravelHumanoID\Facades\HumanoID as HumanoIDFacade;
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
        $this->publishes([
            __DIR__.'/../config/humanoid.php' => config_path('humanoid.php'),
        ], ['humanoid-all', 'config']);

        $humanoidPath = realpath(InstalledVersions::getInstallPath('robthree/humanoid'));
        $this->publishes([
            $humanoidPath.'/data/space-words.json' => resource_path('humanoid/space-words.json'),
            $humanoidPath.'/data/zoo-words.json' => resource_path('humanoid/zoo-words.json'),
        ], ['humanoid-all', 'humanoid']);

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
        $this->mergeConfigFrom(
            __DIR__.'/../config/humanoid.php', 'humanoid'
        );

        $this->app->singleton(HumanoIDManagerFacade::class, function (Application $app) {
            return new HumanoIDManager(
                fn () => Container::getInstance()->make('config'),
            );
        });

        $this->app->singleton(HumanoIDFacade::class, function (Application $app) {
            /**
             * @var HumanoIDManager $humanoIdManager
             */
            $humanoIdManager = $app->get(HumanoIDManagerFacade::class);

            return $humanoIdManager->getDefaultGenerator();
        });
    }
}
