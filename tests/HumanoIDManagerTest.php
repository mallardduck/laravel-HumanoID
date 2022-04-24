<?php

use MallardDuck\LaravelHumanoID\HumanoIDConfig;
use MallardDuck\LaravelHumanoID\LaravelHumanoID;
use MallardDuck\LaravelHumanoID\Tests\DefaultTestConfig;
use RobThree\HumanoID\HumanoID;
use RobThree\HumanoID\WordFormatOption;

it('can verify WordSets directory exists', function () {
    $integrationInstance = new LaravelHumanoID(__DIR__ . '/stubs/wordSets');
    expect($integrationInstance->hasWordSetsFolder())->toBeTrue();
});

it('can verify WordSets directory does NOT exists', function () {
    $integrationInstance = new LaravelHumanoID(__DIR__ . '/wordSets');
    expect($integrationInstance->hasWordSetsFolder())->toBeFalse();
});

it('can verify WordSets exists in folder', function () {
    $integrationInstance = new LaravelHumanoID(__DIR__ . '/stubs/wordSets');
    expect($integrationInstance->hasWordSetsFolder())->toBeTrue();
    expect($integrationInstance->hasWordSets())->toBeTrue();
});

it('can provide the default generator Config', function () {
    $integrationInstance = new LaravelHumanoID(__DIR__ . '/stubs/wordSets', DefaultTestConfig::class);
    $defaultGeneratorConfig = $integrationInstance->getDefaultGeneratorConfig();
    expect($defaultGeneratorConfig)->toBeInstanceOf(HumanoIDConfig::class);
    expect($defaultGeneratorConfig->wordSetsFilename)->toBeString()->toBe('space-words.json');
    expect($defaultGeneratorConfig->separator)->toBeString()->toBe('_');
    expect($defaultGeneratorConfig->formatOption)->toBeInstanceOf(WordFormatOption::class);
});

it('can provide the default generator', function () {
    $integrationInstance = new LaravelHumanoID(__DIR__ . '/stubs/wordSets', DefaultTestConfig::class);
    $defaultGenerator = $integrationInstance->getDefaultGenerator();
    expect($defaultGenerator)->toBeInstanceOf(HumanoID::class);
    expect($defaultGenerator->create(42))->toBe('HAUMEA_PINWHEEL');
    expect($defaultGenerator->parse('HYPERGIANT_QUAOAR_PINWHEEL'))->toBe(420);
});
