<?php

use Illuminate\Config\Repository as Config;
use MallardDuck\LaravelHumanoID\Tests\DefaultTestConfig;
use MallardDuck\LaravelHumanoID\Tests\TestCase;
use Roave\BetterReflection\BetterReflection;

uses(TestCase::class)->in(__DIR__);

/**
 * @param null|string $basePath
 * @param null|string $defaultGeneratorConfig
 *
 * @return Closure<Config>
 */
function getTestConfigRepo(
    ?string $basePath = __DIR__ . '/stubs/wordSets',
    ?string $defaultGeneratorConfig = DefaultTestConfig::class,
): Closure {
    return function () use ($basePath, $defaultGeneratorConfig) {
        return new Config([
            'humanoid' => [
                'wordSetsBasePath' => $basePath,
                'defaultGeneratorConfig' => $defaultGeneratorConfig,
            ],
        ]);
    };
}


expect()->extend('callStatic', function (string $methodName) {
    $classInfo = (new BetterReflection())
        ->reflector()
        ->reflectClass($this->value);
    $method = $classInfo->getMethod($methodName);
    return $this->and($method->invoke(new $this->value));
});
