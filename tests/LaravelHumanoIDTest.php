<?php

use MallardDuck\LaravelHumanoID\Facades\HumanoID;
use MallardDuck\LaravelHumanoID\Facades\LaravelHumanoID;
use MallardDuck\LaravelHumanoID\LaravelHumanoID as HumanoIDManager;
use RobThree\HumanoID\HumanoID as HumanoIDGenerator;

it('can get HumanoID manager class instance from App', function () {
    $manager = $this->app->make(LaravelHumanoID::class);
    expect($manager)
        ->toBeInstanceOf(HumanoIDManager::class)
        ->toBe($this->app->make(LaravelHumanoID::class));
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
