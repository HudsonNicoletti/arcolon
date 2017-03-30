<?php

namespace Admin\Controllers;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Hidden;

class LoginController extends ControllerBase
{

  public function IndexAction()
  {
    $form = new Form;

    $element['security'] = new Hidden( "security" ,[
      'name'  => $this->security->getTokenKey(),
      'value' => $this->security->getToken()
    ]);

    foreach ($element as $e)
    {
      $form->add($e);
    }

    $this->view->form = $form;
  }

}
