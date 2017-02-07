<?php

namespace Api\Controllers;

use Mustache_Engine as Mustache;
use Api\Misc\ApiExceptions as ApiExceptions;

use Phalcon\Mvc\Controller;

class ContactController extends ControllerBase
{
  public function IndexAction()
  {
    $this->response->setContentType("application/json");

    try
    {
      if(!$this->request->isPost() || !$this->request->isAjax()):
        return ApiExceptions::InvalidRequestMethod();

      elseif(!$this->request->getPost("name","string")):
        return ApiExceptions::EmptyInput("Name");

      elseif(!$this->request->getPost("email","string")):
        return ApiExceptions::EmptyInput("E-Mail");

      elseif(!$this->request->getPost("message","string")):
        return ApiExceptions::EmptyInput("Message");

      elseif(!$this->isEmail($this->request->getPost("email","email"))):
        return ApiExceptions::InvalidEmailAddress();

      elseif(!$this->security->checkToken()):
        return ApiExceptions::InvalidCsrfToken();
      endif;

      $Api = new ApiFunctions;

      $Api->sendEmail([
        "from"    => [ "name" => $this->request->getPost("name","string"), "email" => $this->request->getPost("email","email")],
        "message" => $this->request->getPost("message","string")
      ]);

      $this->flags['data'] = [ "status"=> true, "message" => "Your E-mail was sent! Thank you!" ];

    }
    catch (\Exception $e)
    {
      $this->flags['data'] = [ "status"=> false, "message" => $e->getMessage() ];
    }

    return $this->response->setJsonContent($this->flags);
    $this->response->send();
    $this->view->setRenderLevel(View::LEVEL_ACTION_VIEW);

  }
}
