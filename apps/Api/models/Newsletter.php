<?php

namespace Api\Models;

use \Phalcon\Mvc\Model as Model;

class Newsletter extends Model
{
  public function getSource()
  {
    return "newsletter";
  }
}
