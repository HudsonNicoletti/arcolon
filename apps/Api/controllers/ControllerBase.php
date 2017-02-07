<?php

namespace Api\Controllers;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
  protected $flags = [
    "data" => false
  ];

  public function initialize()
  {
  }

  protected function isEmail($e)
  {
    return preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $e );
  }

  protected function uniqueCode($prefix = null, $limit = 10)
  {
    $limit = ($prefix ? $limit - strlen($prefix) : $limit);

    return $prefix.str_shuffle(substr(md5(round(time().uniqid())), 0, $limit));
  }
}
