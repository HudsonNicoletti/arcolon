<?php

namespace Api\Controllers;

use Api\Models\Gallery as Gallery;
use Api\Misc\ApiFunctions  as ApiFunctions,
    Api\Misc\ApiExceptions as ApiException;

class GalleryController extends ControllerBase
{

  public function uploadAction()
  {
    $this->response->setContentType("application/json");

    $ApiFunctions  = new ApiFunctions;

    try
    {
      if(!$this->request->isPost()):
        return ApiException::InvalidRequestMethod();

      elseif(!$this->request->hasFiles()):
        throw new \Exception("Nehuma imagem foi enviada.");

      elseif(!$this->security->checkToken()):
        return ApiException::InvalidCsrfToken();
      else:


        foreach($this->request->getUploadedFiles() as $file):
          if($file->getError() != 0):
            $this->flags['data']['redirect'] = (object)["location"=>"/admin/gallery","time"=>2500];
            return ApiException::UploadError($file->getError());
          endif;
          $filename = $ApiFunctions->uniqueCode().".".$file->getExtension();
          array_push($images, $filename);
          $file->moveTo("assets/public/images/content/gallery/{$filename}");
          $ApiFunctions->ResizeImage("assets/public/images/content/gallery/{$filename}", ["dest"=>"assets/public/images/content/gallery/thumbnails/{$filename}", "width"=>280, "height"=>280]);

          $gallery = new Gallery;
          $gallery->image = $filename;
          $gallery->save();
        endforeach;


        $this->flags['data'] = [
          'status'    =>  true,
          'label'     =>  "success",
          'message'   =>  "Imagens Cadastradas !",
          'redirect'  =>  (object)["location"=>"/admin/gallery","time"=>0]
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

  public function removeAction()
  {
    $this->response->setContentType("application/json");

    $ApiFunctions  = new ApiFunctions;

    try
    {
      if(!$this->request->isPost()):
        return ApiException::InvalidRequestMethod();

      elseif(!$this->dispatcher->getParam("image")):
        throw new \Exception("Nehuma imagem foi selecionada.");

      elseif(!$this->security->checkToken()):
        return ApiException::InvalidCsrfToken();
      else:

        $gallery = Gallery::findFirst($this->dispatcher->getParam("image","int"));

        @unlink("assets/public/images/content/gallery/{$galler->image}");
        @unlink("assets/public/images/content/gallery/thumbnails/{$galler->image}");

        $gallery->delete();


        $this->flags['data'] = [
          'status'    =>  true,
          'label'     =>  "success",
          'message'   =>  "Imagem Removida !",
          'redirect'  =>  (object)["location"=>"/admin/gallery","time"=>0]
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
