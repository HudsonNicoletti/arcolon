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

# START - Admin

$router->add("/admin", [
  "namespace"  => "Admin\Controllers",
  "module"     => "Admin",
  'controller' => 'login',
  'action'     => 'index'
]);

$router->add("/admin/login/auth", [
  'module'     => 'Api',
  'namespace'  => 'Api\Controllers',
  'controller' => 'auth',
  'action'     => 'login'
])->via(["POST"]);

$router->add("/admin/logout", [
  'module'     => 'Api',
  'namespace'  => 'Api\Controllers',
  'controller' => 'auth',
  'action'     => 'logout',
]);

$router->add("/admin/index", [
  "namespace"  => "Admin\Controllers",
  "module"     => "Admin",
  'controller' => 'index',
  'action'     => 'index'
]);

$router->add("/admin/tips", [
  "namespace"  => "Admin\Controllers",
  "module"     => "Admin",
  'controller' => 'tips',
  'action'     => 'index'
]);

$router->add("/admin/tips/new", [
  "namespace"  => "Admin\Controllers",
  "module"     => "Admin",
  'controller' => 'tips',
  'action'     => 'new'
]);

$router->add("/admin/tips/create", [
  "namespace"  => "Api\Controllers",
  "module"     => "Api",
  'controller' => 'tips',
  'action'     => 'create'
])->via(["POST"]);


$router->add("/admin/tip/{slug:[a-zA-Z0-9\_\-\.]+}", [
  "namespace"  => "Admin\Controllers",
  "module"     => "Admin",
  'controller' => 'tips',
  'action'     => 'edit'
]);

$router->add("/admin/tip/update/{slug:[a-zA-Z0-9\_\-\.]+}", [
  "namespace"  => "Api\Controllers",
  "module"     => "Api",
  'controller' => 'tips',
  'action'     => 'update'
])->via(["POST"]);

$router->add("/admin/gallery", [
  "namespace"  => "Admin\Controllers",
  "module"     => "Admin",
  'controller' => 'gallery',
  'action'     => 'index'
]);

$router->add("/admin/gallery/upload", [
  "namespace"  => "Api\Controllers",
  "module"     => "Api",
  'controller' => 'gallery',
  'action'     => 'upload'
])->via(["POST"]);

$router->add("/admin/gallery/remove/{image:[0-9]+}", [
  "namespace"  => "Api\Controllers",
  "module"     => "Api",
  'controller' => 'gallery',
  'action'     => 'remove'
])->via(["POST"]);
