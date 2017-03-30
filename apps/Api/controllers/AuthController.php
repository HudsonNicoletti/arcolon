<?php

namespace Api\Controllers;

use Phalcon\Mvc\Controller;

use Api\Misc\ApiExceptions  as ApiException,
    Api\Misc\ApiFunctions   as ApiFunctions;

use Api\Models\Users     as Users,
    Api\Models\UserInfo  as UserInfo;

class AuthController extends ControllerBase
{
  public function LoginAction()
  {
    $this->response->setContentType("application/json");

    $ApiFunctions  = new ApiFunctions;

    try
    {
      /* strip spacing */
      $inputs = $ApiFunctions->StripSpaces([
        "username" => $this->request->getPost("username","string"),
        "password" => $this->request->getPost("password","string"),
      ]);

      /* verify empty inputs */
      $ApiFunctions->CheckForNull([
        $this->rhyno_translate->global->labels->username => $inputs->username ,
        $this->rhyno_translate->global->labels->password => $inputs->password ,
      ]);

      /* user data */
      $user = (!$ApiFunctions->isEmail($inputs->username)) ? Users::findFirstByUsername($inputs->username) : Users::findFirstByEmail($inputs->username);

      if(!$this->request->isPost()):
        return ApiException::InvalidRequestMethod();

      elseif(!$user):
        return ApiException::AccessDenied();

      elseif(!password_verify( $inputs->password , $user->password )):
        return ApiException::PasswordDenied();

      elseif(!$this->security->checkToken()):
        return ApiException::InvalidCsrfToken();
      else:

        $this->session->set("arcolon_secure", $user->_);
        $name = UserInfo::findFirstByUid($user->_)->name;

        if(!$name)
        {
          return ApiException::DoesNotExist("user");
        }

        $this->flags['data'] = [
          'status'    =>  true,
          'label'     =>  "success",
          'message'   =>  "Wellcome, {$name} !",
          'redirect'  =>  (object)["location"=>"/admin","time"=>0]
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

  public function LogoutAction()
  {
    $this->session->destroy();
    return $this->response->redirect();
  }
}
