<?php

$application->registerModules([
  'Api' => [
    'className' => 'Api\Module',
    'path'      => __DIR__ . '/../apps/Api/Module.php'
  ],
  'Website' => [
    'className' => 'Website\Module',
    'path'      => __DIR__ . '/../apps/Website/Module.php'
  ]
]);
