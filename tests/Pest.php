<?php

use Illuminate\Config\Repository as Config;
use MallardDuck\LaravelHumanoID\Tests\DefaultTestConfig;
use MallardDuck\LaravelHumanoID\Tests\TestCase;
use Pest\Expectation;
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
            'wordSetsBasePath' => $basePath,
            'defaultGeneratorConfig' => $defaultGeneratorConfig,
        ]);
    };
}

function agnosticPath(string $path): string
{
    if (DIRECTORY_SEPARATOR === '/') {
        return $path;
    }

    return str_replace('/', DIRECTORY_SEPARATOR, $path);
}

function callStaticMethod(string $className, string $methodName, ...$args): Expectation
{
    $expectation = expect($className)
                    ->toBeClass();
    $classInfo = (new BetterReflection())
        ->reflector()
        ->reflectClass($className);
    $expectation = $expectation
        ->and($classInfo->hasMethod($methodName))
        ->toBeTrue(sprintf("Verify that `%s` has method `%s`", $className, $methodName));
    $method = $classInfo->getMethod($methodName);
    $expectation = $expectation
        ->and($method->isStatic())
        ->toBeTrue(sprintf("Verify that `%s` is static", $methodName));

    return $expectation
        ->and($method->invoke(null, ...$args))
        ->toBeString();
}
