<?php

namespace Api\Models;

use \Phalcon\Mvc\Model as Model;

class TipFiles extends Model
{
  public function getSource()
  {
    return "tip_files";
  }
}
