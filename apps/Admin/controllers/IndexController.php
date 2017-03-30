<?php

namespace Admin\Controllers;

use Api\Models\Newsletter   as Newsletter;

class IndexController extends ControllerBase
{

  public function IndexAction()
  {

    $newsletters = Newsletter::find([
      'order' => 'date DESC'
    ]);

    $this->view->newsletters = $newsletters;
  }

}
