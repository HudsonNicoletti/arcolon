<?php

namespace Website\Controllers;

use Api\Models\Tips as Tips;
use Api\Models\Gallery   as Gallery;

class IndexController extends ControllerBase
{
  public function IndexAction()
  {
    $this->view->gallery     = Gallery::find();
    $this->view->tips = Tips::find(["order"=>"_ DESC"]);
  }
  public function AboutAction()
  {
    $this->view->bodyclass = "about";
    $this->view->pick("index/about");
  }
}
