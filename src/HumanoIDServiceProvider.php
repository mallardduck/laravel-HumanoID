<?php

declare(strict_types=1);

namespace MallardDuck\LaravelHumanoID;

use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Foundation\Application;
use Illuminate\Support\ServiceProvider;
use MallardDuck\LaravelHumanoID\Facades\HumanoID as HumanoIDFacade;
use MallardDuck\LaravelHumanoID\Facades\HumanoIDManager as HumanoIDManagerFacade;
use RobThree\HumanoID\HumanoID;

class HumanoIDServiceProvider extends ServiceProvider implements DeferrableProvider
{
    public static string $packageName = 'laravel-humanoid';

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(HumanoIDFacade::class, function (Application $app) {
            /**
             * @var HumanoIDManager $humanoIdManager
             */
            $humanoIdManager = $app->get(HumanoIDManagerFacade::class);

            return $humanoIdManager->getDefaultGenerator();
        });
        $this->app->alias(HumanoIDFacade::class, 'humanoid');
        $this->app->alias(HumanoIDFacade::class, HumanoID::class);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'humanoid',
            HumanoID::class,
            HumanoIDFacade::class,
        ];
    }
}
