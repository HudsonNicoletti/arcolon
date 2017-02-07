<?php
$router->add("/servicos/instalacao", [
  "namespace"  => "Website\Controllers",
  "module"     => "Website",
  'controller' => 'services',
  'action'     => 'installation'
]);

$router->add("/servicos/locacao", [
  "namespace"  => "Website\Controllers",
  "module"     => "Website",
  'controller' => 'services',
  'action'     => 'rental'
]);

$router->add("/servicos/menutencao", [
  "namespace"  => "Website\Controllers",
  "module"     => "Website",
  'controller' => 'services',
  'action'     => 'maintenance'
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
  'action'     => 'tip'
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
