<?php

use MallardDuck\LaravelHumanoID\Facades\HumanoID;
use MallardDuck\LaravelHumanoID\Facades\HumanoIDManager;
use MallardDuck\LaravelHumanoID\HumanoIDManager as ActualHumanoIDManager;
use RobThree\HumanoID\HumanoID as HumanoIDGenerator;

it('can get HumanoID manager class instance from App', function () {
    $manager = $this->app->make(HumanoIDManager::class);
    expect($manager)
        ->toBeInstanceOf(ActualHumanoIDManager::class)
        ->toBe($this->app->make(HumanoIDManager::class));
});

it('can get default HumanoID instance from App', function () {
    $appConfig = $this->app['config'];
    $default = $this->app->make(HumanoID::class);
    expect($default)
        ->toBeInstanceOf(HumanoIDGenerator::class)
        ->toBe($this->app->make(HumanoID::class));
    expect($default->create(42))
        ->toBe('Haumea-Pinwheel');
    expect($default->parse('Hypergiant-Quaoar-Pinwheel'))
        ->toBe(420);
});

it('can get HumanoID vendor path', function () {
    expect(ActualHumanoIDManager::getHumanoIDVendorPath())
        ->toBeString()
        ->toEndWith(agnosticPath('vendor/robthree/humanoid'));
});
