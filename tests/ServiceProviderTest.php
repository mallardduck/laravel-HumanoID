<?php

use Illuminate\Support\ServiceProvider;
use MallardDuck\LaravelHumanoID\LaravelHumanoIDServiceProvider;

it('can verify LaravelHumanoIDServiceProvider exists', function () {
    expect(class_exists(LaravelHumanoIDServiceProvider::class))->toBeTrue();
});

it('can verify LaravelHumanoIDServiceProvider booted published', function () {
    expect(ServiceProvider::$publishes['MallardDuck\LaravelHumanoID\LaravelHumanoIDServiceProvider'])
        ->toBeArray()
        ->toHaveCount(3);
});

it('can verify LaravelHumanoIDServiceProvider booted groups', function () {
    expect(ServiceProvider::$publishGroups)->toHaveKeys([
        'humanoid-all',
        'humanoid',
        'config',
        'laravel-humanoid-config',
    ]);

    expect(ServiceProvider::$publishGroups['laravel-humanoid-config'])
        ->toBeArray()
        ->toHaveCount(1);

    expect(ServiceProvider::$publishGroups['humanoid-all'])
        ->toBeArray()
        ->toHaveCount(3);

    expect(ServiceProvider::$publishGroups['humanoid'])
        ->toBeArray()
        ->toHaveCount(2);

    $configs = ServiceProvider::$publishGroups['laravel-humanoid-config'];
    expect(array_keys($configs)[0])->toEndWith(agnosticPath('/../config/humanoid.php'));
    expect(array_values($configs)[0])->toEndWith(agnosticPath('/config/humanoid.php'));

    $configs = ServiceProvider::$publishGroups['humanoid'];
    expect(array_keys($configs)[0])->toEndWith(agnosticPath('/data/space-words.json'));
    expect(array_values($configs)[0])->toEndWith(agnosticPath('/humanoid/space-words.json'));

    expect(array_keys($configs)[1])->toEndWith(agnosticPath('/data/zoo-words.json'));
    expect(array_values($configs)[1])->toEndWith(agnosticPath('/humanoid/zoo-words.json'));
});
