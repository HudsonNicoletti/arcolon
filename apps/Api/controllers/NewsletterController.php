<?php

namespace Api\Controllers;


use Api\Misc\ApiExceptions as ApiExceptions,
    Api\Misc\ApiFunctions;

use Api\Models\Newsletter as Newsletter;

use Phalcon\Mvc\Controller;

class NewsletterController extends ControllerBase
{
  public function SubscribeAction()
  {
    $this->response->setContentType("application/json");

    try
    {
      if(!$this->request->isPost()):
        return ApiExceptions::InvalidRequestMethod();

      elseif(!$this->request->getPost("email","string")):
        return ApiExceptions::EmptyInput("E-Mail");

      elseif(!$this->isEmail($this->request->getPost("email","email"))):
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
}
