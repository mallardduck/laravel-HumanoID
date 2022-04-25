<?php

use Illuminate\Config\Repository as Config;
use MallardDuck\LaravelHumanoID\DefaultGeneratorConfig;
use MallardDuck\LaravelHumanoID\HumanoIDConfig;
use MallardDuck\LaravelHumanoID\HumanoIDManager;
use MallardDuck\LaravelHumanoID\Tests\DefaultTestConfig;
use MallardDuck\LaravelHumanoID\Tests\YamlTestConfig;
use RobThree\HumanoID\HumanoID;
use RobThree\HumanoID\WordFormatOption;

it('can verify WordSets directory exists', function () {
    expect(
        (new HumanoIDManager(
            getTestConfigRepo(defaultGeneratorConfig: DefaultGeneratorConfig::class)
        ))
            ->hasWordSetsFolder()
    )->toBeTrue();
});

it('can verify WordSets directory does NOT exists', function () {
    expect(
        (new HumanoIDManager(getTestConfigRepo('wordsets')))
            ->hasWordSetsFolder()
    )->toBeFalse();
});

it('can verify WordSets exists in folder', function () {
    $integrationInstance = new HumanoIDManager(getTestConfigRepo(__DIR__ . '/stubs/wordSets'));
    expect($integrationInstance->hasWordSetsFolder())->toBeTrue();
    expect($integrationInstance->hasWordSets())->toBeTrue();
});

it('can provide the default generator Config', function () {
    $integrationInstance = new HumanoIDManager(getTestConfigRepo());
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
    $integrationInstance = new HumanoIDManager(fn () => new Config());
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
    $integrationInstance = new HumanoIDManager(getTestConfigRepo());
    $defaultGenerator = $integrationInstance->getDefaultGenerator();
    expect($defaultGenerator)
        ->toBeInstanceOf(HumanoID::class);
    expect($defaultGenerator->create(42))
        ->toBe('HAUMEA_PINWHEEL');
    expect($defaultGenerator->parse('HYPERGIANT_QUAOAR_PINWHEEL'))
        ->toBe(420);
});

it('can provide the default (yaml) generator', function () {
    $integrationInstance = new HumanoIDManager(getTestConfigRepo(defaultGeneratorConfig: YamlTestConfig::class));
    $defaultGenerator = $integrationInstance->getDefaultGenerator();
    expect($defaultGenerator)
        ->toBeInstanceOf(HumanoID::class);
    expect($defaultGenerator->create(42))
        ->toBe('Hypergiant_Gonggong_Pinwheel');
    expect($defaultGenerator->parse('Orange_Whitedwarf_Gonggong_Pinwheel'))
        ->toBe(420);
});

it('can provide the default (default app) generator', function () {
    $integrationInstance = new HumanoIDManager(getTestConfigRepo(defaultGeneratorConfig: \App\HumanoID\DefaultAppConfig::class));
    $defaultGenerator = $integrationInstance->getDefaultGenerator();
    expect($defaultGenerator)
        ->toBeInstanceOf(HumanoID::class);
    expect($defaultGenerator->create(42))
        ->toBe('Haumea-Pinwheel');
    expect($defaultGenerator->parse('Hypergiant-Quaoar-Pinwheel'))
        ->toBe(420);
});

it('can provide the default (spice) generator', function () {
    $integrationInstance = new HumanoIDManager(getTestConfigRepo(defaultGeneratorConfig: \MallardDuck\LaravelHumanoID\Tests\SpiceTestConfig::class));
    $defaultGenerator = $integrationInstance->getDefaultGenerator();
    expect($defaultGenerator)
        ->toBeInstanceOf(HumanoID::class);
    expect($defaultGenerator->create(42))
        ->toBe('coriander|dill|salt');
    expect($defaultGenerator->parse('coriander|anise|chili|salt'))
        ->toBe(420);
    expect($defaultGenerator->create(96000001))
        ->toBe('cloves|coriander|coriander|nutmeg|lavender|lavender|allspice|poppy|basil|pepper');
    expect($defaultGenerator->parse('coriander|vanilla|basil|pepper'))
        ->toBe(401);

});
