<?php

namespace Admin\Controllers;

use Phalcon\Forms\Form,
    Phalcon\Forms\Element\Text,
    Phalcon\Forms\Element\File,
    Phalcon\Forms\Element\Textarea,
    Phalcon\Forms\Element\Password,
    Phalcon\Forms\Element\Hidden;

use Api\Models\Tips as Tips,
    Api\Models\TipFiles as TipFiles;

use Mustache_Engine as Mustache;

class TipsController extends ControllerBase
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
    $this->view->tips = Tips::find();
  }

  public function newAction()
  {
    $form = new Form;

    $element['security'] = new Hidden( "security" ,[
      'name'  => $this->security->getTokenKey(),
      'value' => $this->security->getToken()
    ]);

    $element['title'] = new Text( "title" ,[
      'class'                 => "form-control",
      'data-validate'         => "required",
      'data-message-required' => "* Este campo é obrigatório.",
    ]);
    $element['image'] = new File( "image",[
      'accept'                => "image/x-png, image/jpeg",
      'multiple'              => true,
      'class'                 => "form-control",
      'data-validate'         => "required",
      'data-message-required' => "* Este campo é obrigatório.",
    ]);
    $element['doc'] = new File( "doc[]",[
      'accept'                => "application/msword, application/vnd.ms-excel, application/pdf",
      'multiple'              => true,
      'class'                 => "form-control"
    ]);
    $element['docTitle'] = new Text( "docTitle[]",[
      'class'                 => "form-control",
      'data-validate'         => "required"
    ]);
    $element['text']  = new Textarea( "text",[
      'class'                 => "form-control ckeditor",
      'name'                  => 'text',
    ]);
    $element['font']  = new Text( "font",[
      'placeholder'           => 'http://www.arcolon.com.br',
      'class'                 => "form-control",
    ]);

    foreach ($element as $e)
    {
      $form->add($e);
    }

    $this->view->form = $form;
  }

  public function editAction()
  {
    $slug = $this->dispatcher->getParam("slug","string");
    $tip  = Tips::findFirstBySlug($slug);
    $files = TipFiles::findByTip($tip->_);

    if (!$slug) {
      $this->view->pick("error/404");
      exit;
    }

    $text = (new Mustache)->render($tip->text,[
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

    $form = new Form;

    $element['security'] = new Hidden( "security" ,[
      'name'  => $this->security->getTokenKey(),
      'value' => $this->security->getToken()
    ]);

    $element['title'] = new Text( "title" ,[
      'class'                 => "form-control",
      'data-validate'         => "required",
      'data-message-required' => "* Este campo é obrigatório.",
      'value'                 => $tip->title
    ]);
    $element['image'] = new File( "image",[
      'accept'                => "image/x-png, image/jpeg",
      'class'                 => "form-control",
    ]);
    $element['text']  = new Textarea( "text",[
      'class'                 => "form-control ckeditor",
      'value'                 => $text
    ]);
    $element['doc'] = new File( "doc[]",[
      'accept'                => "application/msword, application/vnd.ms-excel, application/pdf",
      'multiple'              => true,
      'class'                 => "form-control"
    ]);
    $element['docTitle'] = new Text( "docTitle[]",[
      'class'                 => "form-control",
      'data-validate'         => "required"
    ]);
    $element['font']  = new Text( "font",[
      'placeholder'           => 'http://www.arcolon.com.br',
      'class'                 => "form-control",
      'value'                 => $tip->font
    ]);

    foreach ($element as $e)
    {
      $form->add($e);
    }

    $this->view->form  = $form;
    $this->view->files = $files;
  }

}
