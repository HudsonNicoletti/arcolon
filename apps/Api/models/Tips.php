<?php

namespace Api\Models;

use \Phalcon\Mvc\Model as Model;

class Tips extends Model
{
  public function getSource()
  {
    return "tips";
  }
}
