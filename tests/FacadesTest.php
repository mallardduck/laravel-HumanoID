<?php

use MallardDuck\LaravelHumanoID\Facades\HumanoID;
use MallardDuck\LaravelHumanoID\Facades\HumanoIDManager;

it('can verify HumanoID facade exists', function () {
    expect(class_exists(HumanoID::class))->toBeTrue();
    expect(HumanoID::class)->callStatic('getFacadeAccessor')->toBeString()->toBe('humanoid');
});

it('can verify HumanoIDManager facade exists', function () {
    expect(class_exists(HumanoIDManager::class))->toBeTrue();
    expect(HumanoIDManager::class)->callStatic('getFacadeAccessor')->toBeString()->toBe('laravel-humanoid');
});
