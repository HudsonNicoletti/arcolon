<?php

namespace Website\Controllers;

use Api\Models\Tips as Tips;

use Mustache_Engine as Mustache;

class TipsController extends ControllerBase
{
  public function onConstruct()
  {
    $this->view->bodyclass = "tips";
  }

  public function IndexAction()
  {
    $this->view->tips = Tips::find();
  }

  public function PostAction()
  {
    $slug = $this->dispatcher->getParam("slug");
    $tip  = Tips::findFirstBySlug($slug);

    $tip->text = (new Mustache)->render($tip->text, [
      'p'     => "<p>",
      'p_end' => "</p>",
      'b'     => "<b>",
      'b_end' => "</b>",
      'u'     => "<u>",
      'u_end' => "</u>",
      'h1'     => "<h1>",
      'h1_end' => "</h1>",
      'h2'     => "<h2>",
      'h2_end' => "</h2>",
      'h3'     => "<h3>",
      'h3_end' => "</h3>"
    ]);

    $this->view->tip = $tip;
  }
}
