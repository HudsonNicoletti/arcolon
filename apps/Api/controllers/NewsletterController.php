<?php

namespace Api\Controllers;


use Api\Misc\ApiExceptions as ApiExceptions,
    Api\Misc\ApiFunctions as ApiFunctions;

use Api\Models\Newsletter as Newsletter;

use Phalcon\Mvc\Controller;

class NewsletterController extends ControllerBase
{
  public function SubscribeAction()
  {
    $this->response->setContentType("application/json");

    try
    {
      $ApiFunctions = new ApiFunctions;
      if(!$this->request->isPost()):
        return ApiExceptions::InvalidRequestMethod();

      elseif(!$this->request->getPost("email","string")):
        return ApiExceptions::EmptyInput("E-Mail");

      elseif(!$ApiFunctions->isEmail($this->request->getPost("email","email"))):
        return ApiExceptions::InvalidEmailAddress();

      elseif(Newsletter::findFirstByEmail($this->request->getPost("email","email"))):
        return ApiExceptions::RegisteredEmailAddress();

      elseif(!$this->security->checkToken()):
        return ApiExceptions::InvalidCsrfToken();
      endif;

      $n = new Newsletter;
        $n->email = $this->request->getPost("email","email");
        $n->date  = (new \DateTime())->format("Y-m-d H:i:s");
      $n->save();

      $this->flags['data'] = [
        "status"=> true,
        "message" => "Seu E-Mail foi cadastrado!"
      ];

    }
    catch (\Exception $e)
    {
      $this->flags['data'] = [
        "status"=> false,
        "message" => $e->getMessage()
      ];
    }

    return $this->response->setJsonContent($this->flags);
    $this->response->send();
    $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

  }

  public function removeAction()
  {
    $this->response->setContentType("application/json");

    try
    {
      $id = $this->dispatcher->getParam("email_id","string");
      if(!$this->request->isPost()):
        return ApiExceptions::InvalidRequestMethod();

      elseif(!$id):
        throw new \Exception("Nehum E-Mail Selecionado");

      elseif(!$this->security->checkToken()):
        return ApiExceptions::InvalidCsrfToken();
      endif;

      $n = Newsletter::findFirst($id);
      $n->delete();

      $this->flags['data'] = [
        'status'    =>  true,
        'label'     =>  "success",
        'message'   =>  "E-Mail removido com sucesso !",
        'redirect'  =>  (object)["location"=>"/admin","time"=>0]
      ];

    }
    catch (\Exception $e)
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

  public function ListAction()
  {
    $this->response->setContentType("application/json");

    try
    {
      if(!$this->request->isPost()):
        return ApiExceptions::InvalidRequestMethod();

      elseif(!$this->security->checkToken()):
        return ApiExceptions::InvalidCsrfToken();
      endif;

      $emails = "";
      $n = Newsletter::find();
      foreach ($n as $line)
      {
        $emails .= "{$line->email} \n";
      }

      file_put_contents( __DIR__ ."/../../../list.txt" , $emails);

      $this->flags['data'] = [
        'status'    =>  true,
        'label'     =>  "success",
        'message'   =>  "Lista está sengo gerada, aguarde ... !",
        'redirect'  =>  (object)["location"=>"/admin/newsletter/download","time"=>0]
      ];

    }
    catch (\Exception $e)
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


  public function downloadAction()
  {
    $this->response->setHeader("Content-Type", "text/plain");
    $this->response->setHeader("Content-Disposition", 'attachment; filename="list.txt"');
    echo file_get_contents( __DIR__ ."/../../../list.txt" );
    $this->view->setRenderLevel(\Phalcon\Mvc\View::LEVEL_NO_RENDER);
  }


}
