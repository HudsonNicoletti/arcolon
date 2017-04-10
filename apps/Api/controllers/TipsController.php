<?php

namespace Api\Controllers;

use Api\Models\Tips as Tips,
    Api\Models\TipFiles as TipFiles;
use Api\Misc\ApiFunctions  as ApiFunctions,
    Api\Misc\ApiExceptions as ApiException;

class TipsController extends ControllerBase
{

  public function CreateAction()
  {
    $this->response->setContentType("application/json");

    $ApiFunctions  = new ApiFunctions;

    try
    {
      if(!$this->request->isPost()):
        return ApiException::InvalidRequestMethod();

      elseif(!$this->request->getPost("title","string")):
        throw new \Exception("Título da dica não pode estar em branco.");

      elseif(!$this->request->hasFiles()):
        throw new \Exception("A imagem de destaque não pode faltar.");

      elseif(!$this->security->checkToken()):
        return ApiException::InvalidCsrfToken();
      else:

        $documents = [];
        $img = "";
        foreach($this->request->getUploadedFiles() as $id => $file):
          if($file->getError() != 0):
            $this->flags['data']['redirect'] = (object)["location"=>"/admin/tips/new","time"=>2500];
            return ApiException::UploadError($file->getError());
          endif;
          $filename = $ApiFunctions->uniqueCode().".".$file->getExtension();
          switch (explode( ".", $file->getKey() )[0])
          {
            case "image":
              $img = $filename;
              $file->moveTo("assets/public/images/tips/{$filename}");
            break;
            case "doc":
              array_push($documents, ["filename" => $filename, "title" => $this->request->getPost("docTitle")[($id-1)] ]);
              $file->moveTo("assets/public/files/{$filename}");
            break;
          }
        endforeach;

        $htmlchars = [
          "<p>"   =>"{{{p}}}",
          "</p>"  =>"{{{p_end}}}",
          "<b>"   =>"{{{b}}}",
          "</b>"  =>"{{{b_end}}}",
          "<u>"   =>"{{{u}}}",
          "</u>"  =>"{{{u_end}}}",
          "<i>"   =>"{{{i}}}",
          "</i>"  =>"{{{i_end}}}",
          "<s>"   =>"{{{s}}}",
          "</s>"  =>"{{{s_end}}}",
          "<ul>"   =>"{{{ul}}}",
          "</ul>"  =>"{{{ul_end}}}",
          "<ol>"   =>"{{{ol}}}",
          "</ol>"  =>"{{{ol_end}}}",
          "<li>"   =>"{{{li}}}",
          "</li>"  =>"{{{li_end}}}",
          "<h1>"   =>"{{{h1}}}",
          "</h1>"  =>"{{{h1_end}}}",
          "<h2>"   =>"{{{h2}}}",
          "</h2>"  =>"{{{h2_end}}}",
          "<h3>"   =>"{{{h3}}}",
          "</h3>"  =>"{{{h3_end}}}",
          "<h4>"   =>"{{{h4}}}",
          "</h4>"  =>"{{{h4_end}}}",
          "<blockquote>"   =>"{{{blockquote}}}",
          "</blockquote>"  =>"{{{blockquote_end}}}",
        ];
        $text = $this->request->getPost("text");
        foreach ($htmlchars as $key => $value)
        {
          $text = str_replace($key,$value,$text);
        }

        $tip = new Tips;
        $tip->slug  = substr( $ApiFunctions->slugify($this->request->getPost("title","string")) ,0,60);
        $tip->title = $this->request->getPost("title","string");
        $tip->font  = $this->request->getPost("font","string");
        $tip->text  = $text;
        $tip->image = $img;
        $tip->date  = (new \DateTime())->format("Y-m-d H:i:s");
        if($tip->save())
        {
          foreach ($documents as $file) {
            $tipdoc = new TipFiles;
            $tipdoc->tip    = $tip->_;
            $tipdoc->file   = $file["filename"];
            $tipdoc->title  = $file["title"];
            $tipdoc->save();
          }
        }

        $this->flags['data'] = [
          'status'    =>  true,
          'label'     =>  "success",
          'message'   =>  "Dica cadastrada com sucesso !",
          'redirect'  =>  (object)["location"=>"/admin/tips","time"=>0]
        ];

      endif;
    }
    catch(\Exception $e)
    {
      $this->flags['data'] = [
        'status'  => false,
        "label"   => "error",
        'message' => $e->getMessage(),
        'redirect'=> false
      ];
    }

    return $this->response->setJsonContent($this->flags);

    $this->response->send();
    $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
  }

  public function UpdateAction()
  {
    $this->response->setContentType("application/json");

    $ApiFunctions  = new ApiFunctions;

    try
    {
      $slug = $this->dispatcher->getParam("slug","string");
      $tip = Tips::findFirstBySlug($slug);

      if(!$this->request->isPost()):
        return ApiException::InvalidRequestMethod();

      elseif(!$this->request->getPost("title","string")):
        throw new \Exception("Título da dica não pode estar em branco.");

      elseif(!$this->security->checkToken()):
        return ApiException::InvalidCsrfToken();
      else:

        $documents = [];
        $img = null;
        foreach($this->request->getUploadedFiles() as $id => $file):
          if($file->getError() != 0):
            $this->flags['data']['redirect'] = (object)["location"=>"/admin/tip/{$slug}","time"=>2500];
            return ApiException::UploadError($file->getError());
          endif;
          $filename = $ApiFunctions->uniqueCode().".".$file->getExtension();
          switch (explode( ".", $file->getKey() )[0])
          {
            case "image":
              @unlink("assets/public/images/tips/{$tip->image}");
              $img = $filename;
              $file->moveTo("assets/public/images/tips/{$filename}");
            break;
            case "doc":
              array_push($documents, ["filename" => $filename, "title" => $this->request->getPost("docTitle")[$id] ]);
              $file->moveTo("assets/public/files/{$filename}");
            break;
          }
        endforeach;

        $htmlchars = [
          "<p>"   =>"{{{p}}}",
          "</p>"  =>"{{{p_end}}}",
          "<b>"   =>"{{{b}}}",
          "</b>"  =>"{{{b_end}}}",
          "<u>"   =>"{{{u}}}",
          "</u>"  =>"{{{u_end}}}",
          "<i>"   =>"{{{i}}}",
          "</i>"  =>"{{{i_end}}}",
          "<s>"   =>"{{{s}}}",
          "</s>"  =>"{{{s_end}}}",
          "<ul>"   =>"{{{ul}}}",
          "</ul>"  =>"{{{ul_end}}}",
          "<ol>"   =>"{{{ol}}}",
          "</ol>"  =>"{{{ol_end}}}",
          "<li>"   =>"{{{li}}}",
          "</li>"  =>"{{{li_end}}}",
          "<h1>"   =>"{{{h1}}}",
          "</h1>"  =>"{{{h1_end}}}",
          "<h2>"   =>"{{{h2}}}",
          "</h2>"  =>"{{{h2_end}}}",
          "<h3>"   =>"{{{h3}}}",
          "</h3>"  =>"{{{h3_end}}}",
          "<h4>"   =>"{{{h4}}}",
          "</h4>"  =>"{{{h4_end}}}",
          "<blockquote>"   =>"{{{blockquote}}}",
          "</blockquote>"  =>"{{{blockquote_end}}}",
        ];
        $text = $this->request->getPost("text");
        foreach ($htmlchars as $key => $value)
        {
          $text = str_replace($key,$value,$text);
        }

        $tip->slug  = substr( $ApiFunctions->slugify($this->request->getPost("title","string")) ,0,60);
        $tip->title = $this->request->getPost("title","string");
        $tip->font  = $this->request->getPost("font","string");
        $tip->text  = $text;
        $tip->image = $img ?? $tip->image;
        $tip->date  = (new \DateTime())->format("Y-m-d H:i:s");
        if($tip->save())
        {
          foreach ($documents as $file) {
            $tipdoc = new TipFiles;
            $tipdoc->tip    = $tip->_;
            $tipdoc->file   = $file["filename"];
            $tipdoc->title  = $file["title"];
            $tipdoc->save();
          }
        }

        $this->flags['data'] = [
          'status'    =>  true,
          'label'     =>  "success",
          'message'   =>  "Dica alterada com sucesso !",
          'redirect'  =>  (object)["location"=>"/admin/tip/{$slug}","time"=>0]
        ];

      endif;
    }
    catch(\Exception $e)
    {
      $this->flags['data'] = [
        'status'  => false,
        "label"   => "error",
        'message' => $e->getMessage(),
        'redirect'=> false
      ];
    }

    return $this->response->setJsonContent($this->flags);

    $this->response->send();
    $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
  }

  public function RemoveAction()
  {
    $this->response->setContentType("application/json");

    $ApiFunctions  = new ApiFunctions;

    try
    {
      $slug = $this->dispatcher->getParam("slug","string");

      if(!$this->request->isPost()):
        return ApiException::InvalidRequestMethod();

      elseif(!$slug):
        throw new \Exception("Nehuma Dica Selecionada");

      elseif(!$this->security->checkToken()):
        return ApiException::InvalidCsrfToken();
      else:

        $tip = Tips::findFirstBySlug($slug);
        $files = TipFiles::findByTip($tip->_);

        foreach ($files as $file) {
          @unlink("assets/public/files/{$file->file}");
          $file->delete();
        }


        @unlink("assets/public/images/tips/{$tip->image}");
        $tip->delete();

        $this->flags['data'] = [
          'status'    =>  true,
          'label'     =>  "success",
          'message'   =>  "Dica removida com sucesso !",
          'redirect'  =>  (object)["location"=>"/admin/tips","time"=>0]
        ];

      endif;
    }
    catch(\Exception $e)
    {
      $this->flags['data'] = [
        'status'  => false,
        "label"   => "error",
        'message' => $e->getMessage(),
        'redirect'=> false
      ];
    }

    return $this->response->setJsonContent($this->flags);

    $this->response->send();
    $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
  }

  public function RemoveFileAction()
  {
    $this->response->setContentType("application/json");

    $ApiFunctions  = new ApiFunctions;

    try
    {
      $file_id = $this->dispatcher->getParam("file","int");

      if(!$this->request->isPost()):
        return ApiException::InvalidRequestMethod();

      elseif(!$file_id):
        throw new \Exception("Nehuma Dica Selecionada");

      elseif(!$this->security->checkToken()):
        return ApiException::InvalidCsrfToken();
      else:

        $file = TipFiles::findFirst($file_id);
        $tip  = Tips::findFirst($file->tip);
        @unlink("assets/public/files/{$file->file}");
        $file->delete();

        $this->flags['data'] = [
          'status'    =>  true,
          'label'     =>  "success",
          'message'   =>  "Documento removido com sucesso !",
          'redirect'  =>  (object)["location"=>"/admin/tip/{$tip->slug}","time"=>0]
        ];

      endif;
    }
    catch(\Exception $e)
    {
      $this->flags['data'] = [
        'status'  => false,
        "label"   => "error",
        'message' => $e->getMessage(),
        'redirect'=> false
      ];
    }

    return $this->response->setJsonContent($this->flags);

    $this->response->send();
    $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);
  }
}
