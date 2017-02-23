<?php

namespace Website\Controllers;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Hidden;

use Api\Models\Tips as Tips;


class IndexController extends ControllerBase
{
  public function IndexAction()
  {
    $this->view->tips = Tips::find(["order"=>"_ DESC"]);
  }
  public function AboutAction()
  {

    $this->view->bodyclass = "about";
    $this->view->pick("index/about");
  }
}
