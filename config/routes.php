<?php
$router->add("/sobre", [
  "namespace"  => "Website\Controllers",
  "module"     => "Website",
  'controller' => 'index',
  'action'     => 'about'
]);
$router->add("/servicos/{service:[a-zA-Z0-9\_\-\.]+}", [
  "namespace"  => "Website\Controllers",
  "module"     => "Website",
  'controller' => 'services',
  'action'     => 'index'
]);

$router->add("/dicas", [
  "namespace"  => "Website\Controllers",
  "module"     => "Website",
  'controller' => 'tips',
  'action'     => 'index'
]);

$router->add("/dica/{slug:[a-zA-Z0-9\_\-\.]+}", [
  "namespace"  => "Website\Controllers",
  "module"     => "Website",
  'controller' => 'tips',
  'action'     => 'post'
]);

$router->add("/newsletter/subscribe", [
  "namespace"  => "Api\Controllers",
  "module"     => "Api",
  'controller' => 'newsletter',
  'action'     => 'subscribe'
])->via(["POST"]);

$router->add("/contact/send", [
  "namespace"  => "Api\Controllers",
  "module"     => "Api",
  'controller' => 'contact',
  'action'     => 'send'
])->via(["POST"]);
