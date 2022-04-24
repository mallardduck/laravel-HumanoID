<?php

use MallardDuck\LaravelHumanoID\Facades\HumanoID;

it('can verify HumanoID facade exists', function () {
    expect(class_exists(HumanoID::class))
        ->toBeTrue();
});

it('can verify LaravelHumanoID facade exists', function () {
    expect(class_exists(\MallardDuck\LaravelHumanoID\LaravelHumanoID::class))
        ->toBeTrue();
});
