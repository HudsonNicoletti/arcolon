<?php

namespace Api\Controllers;

use Phalcon\Mvc\Controller;

use Api\Misc\ApiExceptions  as ApiException,
    Api\Misc\ApiFunctions   as ApiFunctions;

  use Api\Models\Users as Users,
      Api\Models\UserInfo as UserInfo;

class ControllerBase extends Controller
{
  protected $arcolon_user;
  protected $arcolon_user_info;
  protected $flags = [
    "data" => false
  ];

  public function initialize()
  {

    if ($this->session->has("arcolon_secure"))
    {
      $_user = $this->session->get("arcolon_secure");

      # SET User data
      $user = Users::findFirst($_user);
      $this->arcolon_user = $user;

      $info = UserInfo::findFirstByUid($_user);
      $this->arcolon_user_info = $info;
    }
  }
}
