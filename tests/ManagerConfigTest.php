<?php

use MallardDuck\LaravelHumanoID\DefaultGeneratorConfig;
use MallardDuck\LaravelHumanoID\HumanoIDConfig;
use MallardDuck\LaravelHumanoID\Tests\DefaultTestConfig;
use RobThree\HumanoID\WordFormatOption;

it('can verify the integration config classes exist', function () {
    expect(class_exists(HumanoIDConfig::class))->toBeTrue();
    expect(class_exists(DefaultGeneratorConfig::class))->toBeTrue();
    expect(class_exists(DefaultTestConfig::class))->toBeTrue();
});

it('cannot instantiate an abstract base class', function () {
    new HumanoIDConfig();
})->throws(Error::class, 'Cannot instantiate abstract class ' . HumanoIDConfig::class);

it('can instantiate a default config', function () {
    expect(new DefaultGeneratorConfig())
        ->toBeInstanceOf(DefaultGeneratorConfig::class)
        ->toMatchObject([
            'wordSetsFilename' => 'space-words.json',
            'separator' => '-',
            'formatOption' => WordFormatOption::ucfirst(),
        ]);
});
