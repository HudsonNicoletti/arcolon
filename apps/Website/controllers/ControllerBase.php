<?php

namespace Website\Controllers;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Hidden;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{

  public function initialize()
  {
    $this->assets
        ->addCss('assets/public/styles/main.css')
        ->addJs('https://maps.googleapis.com/maps/api/js?key=AIzaSyCCuzQHd-qcwqDiyOCJ9OX8ejGdUf3hxuc',false)
        ->addJs('assets/public/scripts/jquery.min.js')
        ->addJs('assets/public/scripts/scrollIt.js')
        ->addJs('assets/public/scripts/lightbox.min.js')
        ->addJs('assets/public/scripts/owl.carousel.min.js')
        ->addJs('assets/public/scripts/functions.min.js');


      $form = new Form;
      $form->add(new Hidden( "security" ,[
        'name'  => $this->security->getTokenKey(),
        'value' => $this->security->getToken(),
      ]));
      $this->view->form = $form;
  }

}
