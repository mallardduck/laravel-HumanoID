<?php
// config for MallardDuck/HumanoIDManager
return [
    'defaultGeneratorConfig' => (class_exists('\App\HumanoID\MyAppConfig')) ? \App\HumanoID\MyAppConfig::class : \MallardDuck\LaravelHumanoID\DefaultGeneratorConfig::class,
    'wordSetsBasePath' => env('APP_HUMANOID_BASE', resource_path('humanoid/')),
];
