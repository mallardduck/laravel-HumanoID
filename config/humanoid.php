<?php
// config for MallardDuck/LaravelHumanoID
return [
    'defaultGeneratorConfig' => (class_exists('\App\HumanoID\MyAppConfig')) ? \App\HumanoID\MyAppConfig::class : \MallardDuck\LaravelHumanoID\DefaultGeneratorConfig::class,
    'wordSetsBasePath' => resource_path('humanoid/'),
];
