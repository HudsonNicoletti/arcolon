<?php

namespace Api\Models;

use \Phalcon\Mvc\Model as Model;

class Gallery extends Model
{
  public function getSource()
  {
    return "gallery";
  }
}
