<?php

use Illuminate\Config\Repository as Config;
use MallardDuck\LaravelHumanoID\DefaultGeneratorConfig;
use MallardDuck\LaravelHumanoID\HumanoIDConfig;
use MallardDuck\LaravelHumanoID\LaravelHumanoID;
use MallardDuck\LaravelHumanoID\Tests\DefaultTestConfig;
use MallardDuck\LaravelHumanoID\Tests\YamlTestConfig;
use RobThree\HumanoID\HumanoID;
use RobThree\HumanoID\WordFormatOption;

it('can verify WordSets directory exists', function () {
    expect(
        (new LaravelHumanoID(
            getTestConfigRepo(defaultGeneratorConfig: DefaultGeneratorConfig::class)
        ))
            ->hasWordSetsFolder()
    )->toBeTrue();
});

it('can verify WordSets directory does NOT exists', function () {
    expect(
        (new LaravelHumanoID(getTestConfigRepo('wordsets')))
            ->hasWordSetsFolder()
    )->toBeFalse();
});

it('can verify WordSets exists in folder', function () {
    $integrationInstance = new LaravelHumanoID(getTestConfigRepo(__DIR__ . '/stubs/wordSets'));
    expect($integrationInstance->hasWordSetsFolder())->toBeTrue();
    expect($integrationInstance->hasWordSets())->toBeTrue();
});

it('can provide the default generator Config', function () {
    $integrationInstance = new LaravelHumanoID(getTestConfigRepo());
    $defaultGeneratorConfig = $integrationInstance->getDefaultGeneratorConfig();
    expect($defaultGeneratorConfig)
        ->toBeInstanceOf(HumanoIDConfig::class)
        ->toBeInstanceOf(DefaultTestConfig::class);
    expect($defaultGeneratorConfig->wordSetsFilename)
        ->toBeString()
        ->toBe('space-words.json');
    expect($defaultGeneratorConfig->separator)
        ->toBeString()
        ->toBe('_');
    expect($defaultGeneratorConfig->formatOption)
        ->toBeInstanceOf(WordFormatOption::class);
});

it('can provide the default generator Config when App config file missing', function () {
    $integrationInstance = new LaravelHumanoID(fn () => new Config());
    $defaultGeneratorConfig = $integrationInstance->getDefaultGeneratorConfig();
    expect($defaultGeneratorConfig)
        ->toBeInstanceOf(HumanoIDConfig::class)
        ->toBeInstanceOf(DefaultGeneratorConfig::class);
    expect($defaultGeneratorConfig->wordSetsFilename)
        ->toBeString()
        ->toBe('space-words.json');
    expect($defaultGeneratorConfig->separator)
        ->toBeString()
        ->toBe('-');
    expect($defaultGeneratorConfig->formatOption)
        ->toBeInstanceOf(WordFormatOption::class);
});

it('can provide the default (test) generator', function () {
    $integrationInstance = new LaravelHumanoID(getTestConfigRepo());
    $defaultGenerator = $integrationInstance->getDefaultGenerator();
    expect($defaultGenerator)
        ->toBeInstanceOf(HumanoID::class);
    expect($defaultGenerator->create(42))
        ->toBe('HAUMEA_PINWHEEL');
    expect($defaultGenerator->parse('HYPERGIANT_QUAOAR_PINWHEEL'))
        ->toBe(420);
});

it('can provide the default (yaml) generator', function () {
    $integrationInstance = new LaravelHumanoID(getTestConfigRepo(defaultGeneratorConfig: YamlTestConfig::class));
    $defaultGenerator = $integrationInstance->getDefaultGenerator();
    expect($defaultGenerator)
        ->toBeInstanceOf(HumanoID::class);
    expect($defaultGenerator->create(42))
        ->toBe('Hypergiant_Gonggong_Pinwheel');
    expect($defaultGenerator->parse('Orange_Whitedwarf_Gonggong_Pinwheel'))
        ->toBe(420);
});
