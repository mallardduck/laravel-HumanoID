<?php

use MallardDuck\LaravelHumanoID\Facades\HumanoID;
use MallardDuck\LaravelHumanoID\Facades\HumanoIDManager;

it('can verify HumanoIDManager facade exists', function () {
    expect(class_exists(HumanoIDManager::class))->toBeTrue();
    expect(HumanoIDManager::class)->callStatic('getFacadeAccessor')->toBeString()->toBe('laravel-humanoid');
});

it('can use the HumanoIDManager facade', function () {
    expect(HumanoIDManager::hasWordSetsFolder())->toBeTrue();
    $generator = HumanoIDManager::getDefaultGenerator();
    expect($generator)
        ->toBeInstanceOf(\RobThree\HumanoID\HumanoID::class);
    expect($generator->create(42))
        ->toBeString()
        ->toBe('Haumea-Pinwheel');
    expect($generator->parse('Aperture-Blue-Remnant-Hypergiant-Venus-Cigar'))
        ->toBeInt()
        ->toBe(42069);
});

it('can verify HumanoID facade exists', function () {
    expect(class_exists(HumanoID::class))->toBeTrue();
    expect(HumanoID::class)->callStatic('getFacadeAccessor')->toBeString()->toBe('humanoid');
});

it('can use the HumanoID facade', function () {
    expect(HumanoID::create(42))
        ->toBeString()
        ->toBe('Haumea-Pinwheel');
    expect(HumanoID::parse('Aperture-Blue-Remnant-Hypergiant-Venus-Cigar'))
        ->toBeInt()
        ->toBe(42069);
});
