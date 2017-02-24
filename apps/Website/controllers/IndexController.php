<?php

namespace Website\Controllers;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Hidden;

use Api\Models\Tips as Tips;

class IndexController extends ControllerBase
{
  public function IndexAction()
  {
    $form = new Form;
    $form->add(new Hidden( "security" ,[
      'name'  => $this->security->getTokenKey(),
      'value' => $this->security->getToken(),
    ]));

    $this->view->tips = Tips::find(["order"=>"_ DESC"]);
    $this->view->form = $form;
  }
  public function AboutAction()
  {

    $this->view->bodyclass = "about";
    $this->view->pick("index/about");
  }
}
