<?php
// config for MallardDuck/HumanoIDManager
return [
    'namespace' => '\App',
    'defaultGeneratorConfig' => 'MyAppConfig', // Can either be FQCN, or short name which will be resolved as ${namespace}\HumanoID\${defaultGeneratorConfig}
    'wordSetsBasePath' => env('APP_HUMANOID_BASE', resource_path('humanoid/')),
];
