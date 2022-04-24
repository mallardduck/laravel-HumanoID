<?php
// config for MallardDuck/LaravelHumanoID
return [
    'defaultConfig' => (class_exists('\App\HumanoID\MyAppConfig')) ? \App\HumanoID\MyAppConfig::class : \MallardDuck\LaravelHumanoID\DefaultConfig::class,
    'wordSetsBasePath' => resource_path('humanoid/'),
];
