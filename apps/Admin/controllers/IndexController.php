<?php

namespace Admin\Controllers;

use Api\Models\Newsletter   as Newsletter;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Hidden;

class IndexController extends ControllerBase
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

    $newsletters = Newsletter::find([
      'order' => 'date DESC'
    ]);

    $this->view->newsletters = $newsletters;
  }

}
