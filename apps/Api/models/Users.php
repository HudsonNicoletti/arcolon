<?php

namespace Api\Models;

use \Phalcon\Mvc\Model as Model;

class Users extends Model
{
  public function getSource()
  {
    return "users";
  }
}
