<?php

namespace Website;

use Phalcon\Loader,
    Phalcon\Mvc\View,
    Phalcon\Config\Adapter\Ini,
    Phalcon\Mvc\ModuleDefinitionInterface,
    Phalcon\Db\Adapter\Pdo\Mysql as DbAdapter;

class Module
{
  public function registerAutoloaders()
  {
    $loader = new Loader;

    $loader->registerNamespaces([
      'Website\Controllers' => __DIR__ . '/controllers/',
      'Api\Controllers'     => __DIR__ . '/../Api/controllers/',
      'Api\Models'          => __DIR__ . '/../Api/models/',
    ]);

    $loader->register();
  }

  public function registerServices($di)
  {

    $config = new Ini( __DIR__ . "/../../config/config.ini");

    $di['view'] = function() {
      $view = new View;
      $view->setViewsDir(__DIR__ . '/views/');

      return $view;
    };


    #   Database connection
    // $di['db'] = function() use ($config) {
    //   return new DbAdapter([
    //     "host"      => $config->database->host,
    //     "username"  => $config->database->username,
    //     "password"  => $config->database->password,
    //     "dbname"    => $config->database->dbname,
    //     "charset"   => $config->database->charset
    //   ]);
    // };

  }
}
