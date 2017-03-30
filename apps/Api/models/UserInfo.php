<?php

namespace Api\Models;

use \Phalcon\Mvc\Model as Model;

class UserInfo extends Model
{
  public function getSource()
  {
    return "user_info";
  }
}
