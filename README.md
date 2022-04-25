# Use [HumanoID](https://github.com/RobThree/HumanoID) in Laravel with Ease!

[![Latest Version on Packagist](https://img.shields.io/packagist/v/mallardduck/laravel-humanoid.svg?style=flat-square)](https://packagist.org/packages/mallardduck/laravel-humanoid)
[![GitHub Tests Action Status](https://img.shields.io/github/workflow/status/mallardduck/laravel-humanoid/run-tests?label=tests)](https://github.com/mallardduck/laravel-humanoid/actions?query=workflow%3Arun-tests+branch%3Amain)
[![GitHub Code Style Action Status](https://img.shields.io/github/workflow/status/mallardduck/laravel-humanoid/Check%20&%20fix%20styling?label=code%20style)](https://github.com/mallardduck/laravel-humanoid/actions?query=workflow%3A"Check+%26+fix+styling"+branch%3Amain)
[![Total Downloads](https://img.shields.io/packagist/dt/mallardduck/laravel-humanoid.svg?style=flat-square)](https://packagist.org/packages/mallardduck/laravel-humanoid)

This package allows you to configure a [HumanoID](https://github.com/RobThree/HumanoID) generator once and use it anywhere in your Laravel application.
Once you've configured your site/apps [HumanoID](https://github.com/RobThree/HumanoID) generator it's as easy as:

> Generates a HumanoID via your preconfigured for (int) 42
```php
HumanoID::create(42); // Using a facade to access the singleton.
app(\RobThree\HumanoID\HumanoID::class)->create(42); // Or, get it via the app container.
app(\MallardDuck\LaravelHumanoID\Facades\HumanoID::class)->create(42); // Or, get it via the app container.
```


## A message to Russian 🇷🇺 people

If you currently live in Russia, please read [this message](./ToRussianPeople.md).

## Installation

You can install the package via composer:

```bash
composer require mallardduck/laravel-humanoid
```

You can publish the config file with:

```bash
php artisan vendor:publish --tag="laravel-humanoid-config"
```

This is the contents of the published config file:

```php
return [
    'defaultGeneratorConfig' => (class_exists('\App\HumanoID\MyAppConfig')) ? \App\HumanoID\MyAppConfig::class : \MallardDuck\LaravelHumanoID\DefaultGeneratorConfig::class,
    'wordSetsBasePath' => env('APP_HUMANOID_BASE', resource_path('humanoid/')),
];
```


## Usage

1. Publish the necessary vendor files,
2. Publish the config files (optional),

```php
$humanoID = new HumanoID::create(42);
echo $humanoID; // 'Haumea-Pinwheel'
```

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](https://github.com/spatie/.github/blob/main/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [Dan Pock](https://github.com/MallardDuck)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
