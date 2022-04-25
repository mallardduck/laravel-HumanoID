<?php

use MallardDuck\LaravelHumanoID\Facades\HumanoID as HumanoIDFacade;
use MallardDuck\LaravelHumanoID\Facades\HumanoIDManager as HumanoIDManagerFacade;
use RobThree\HumanoID\HumanoID;

it('can verify HumanoIDManager facade exists', function () {
    expect(class_exists(HumanoIDManagerFacade::class))->toBeTrue();
    expect(HumanoIDManagerFacade::class)->callStatic('getFacadeAccessor')->toBeString()->toBe('laravel-humanoid');
});

it('can verify HumanoIDManager facade aliases exists', function () {
    /**
     * @var \Illuminate\Foundation\Application $app
     */
    $app = $this->app;
    expect($app->has('laravel-humanoid'))->toBeTrue();
    expect($app->has(\MallardDuck\LaravelHumanoID\HumanoIDManager::class))->toBeTrue();
});

it('can use the HumanoIDManager facade', function () {
    expect(HumanoIDManagerFacade::hasWordSetsFolder())->toBeTrue();
    $generator = HumanoIDManagerFacade::getDefaultGenerator();
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
    expect(class_exists(HumanoIDFacade::class))->toBeTrue();
    expect(HumanoIDFacade::class)->callStatic('getFacadeAccessor')->toBeString()->toBe('humanoid');
});

it('can verify HumanoID facade aliases exists', function () {
    /**
     * @var \Illuminate\Foundation\Application $app
     */
    $app = $this->app;
    expect($app->has('humanoid'))->toBeTrue();
    expect($app->has(HumanoID::class))->toBeTrue();
});

it('can use the HumanoID facade', function () {
    expect(HumanoIDFacade::create(42))
        ->toBeString()
        ->toBe('Haumea-Pinwheel');
    expect(HumanoIDFacade::parse('Aperture-Blue-Remnant-Hypergiant-Venus-Cigar'))
        ->toBeInt()
        ->toBe(42069);
});
