<?php
// config for MallardDuck/LaravelHumanoID
return [
    'defaultGeneratorConfig' => (class_exists('\App\HumanoID\MyAppConfig')) ? \App\HumanoID\MyAppConfig::class : \MallardDuck\LaravelHumanoID\DefaultGeneratorConfig::class,
    'wordSetsBasePath' => env('APP_HUMANOID_BASE', resource_path('humanoid/')),
];
