<?php

namespace Website\Controllers;


class ServicesController extends ControllerBase
{
  public function onConstruct()
  {
    $this->view->bodyclass = "about";
  }

  public function IndexAction()
  {
    $service = $this->dispatcher->getParam("service");

    $this->view->pick("services/{$service}");
  }
}
