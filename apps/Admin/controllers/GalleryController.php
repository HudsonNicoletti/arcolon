<?php

namespace Admin\Controllers;

use Api\Models\Gallery as Gallery;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\File,
    Phalcon\Forms\Element\Hidden;

class GalleryController extends ControllerBase
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
    $this->view->gallery = Gallery::find();
  }

}
