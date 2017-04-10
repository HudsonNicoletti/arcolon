<?php

namespace Website\Controllers;

use Api\Models\Tips as Tips,
    Api\Models\TipFiles as TipFiles;

use Mustache_Engine as Mustache;

class TipsController extends ControllerBase
{
  public function onConstruct()
  {
    $this->view->bodyclass = "tips";
  }

  public function IndexAction()
  {
    $this->view->tips  = Tips::find(["order"=>"_ DESC"]);

  }

  public function PostAction()
  {
    $slug = $this->dispatcher->getParam("slug");
    $tip  = Tips::findFirstBySlug($slug);

    $tip->text = (new Mustache)->render($tip->text,[
      "p"     => "<p>" ,
      "p_end" => "</p>",
      "b"     => "<b>" ,
      "b_end" => "</b>",
      "u"     => "<u>" ,
      "u_end" => "</u>",
      "i"     => "<i>" ,
      "i_end" => "</i>",
      "s"     => "<s>" ,
      "s_end" => "</s>",
      "ul"    => "<ul>" ,
      "ul_end"  => "</ul>",
      "ol"      => "<ol>" ,
      "ol_end"  => "</ol>",
      "li"      => "<li>" ,
      "li_end"  => "</li>",
      "h1"      => "<h1>" ,
      "h1_end"  => "</h1>",
      "h2"      => "<h2>" ,
      "h2_end"  => "</h2>",
      "h3"      => "<h3>" ,
      "h3_end"  => "</h3>",
      "h4"      => "<h4>" ,
      "h4_end"  => "</h4>",
      "blockquote" => "<blockquote>" ,
      "blockquote_end" => "</blockquote>",
    ]);

    $this->view->tip   = $tip;
    $this->view->files = TipFiles::findByTip($tip->_) ?? false;
  }
}
