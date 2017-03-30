<?php

namespace Admin\Controllers;

use Api\Models\Users as Users,
    Api\Models\UserInfo as UserInfo;

use Api\Misc\ApiExceptions  as ApiException,
    Api\Misc\ApiFunctions   as ApiFunctions;

use Phalcon\Mvc\Controller;

class ControllerBase extends Controller
{
  protected $arcolon_user;
  protected $arcolon_user_info;
  protected $flags = [ "data" => false ];

  public function initialize()
  {
    # CSS
    $this->assets
         ->addCss('http://fonts.googleapis.com/css?family=Arimo:400,700,400italic', false)
         ->addCss("/assets/private/css/fonts/linecons/css/linecons.css")
         ->addCss("/assets/private/css/fonts/fontawesome/css/font-awesome.min.css")
         ->addCss("/assets/private/css/bootstrap.css")
         ->addCss("/assets/private/css/xenon-core.css")
         ->addCss("/assets/private/css/xenon-forms.css")
         ->addCss("/assets/private/css/xenon-components.css")
         ->addCss("/assets/private/css/xenon-skins.css")
         ->addCss("/assets/private/css/custom.css");

    # JS
    $this->assets
         ->addJs("/assets/private/js/jquery-1.11.1.min.js")
         ->addJs("/assets/private/js/jquery-ui/jquery-ui.min.js")
         ->addJs("/assets/private/js/jquery-validate/jquery.validate.min.js")
         ->addJs("/assets/private/js/bootstrap.min.js")
         ->addJs("/assets/private/js/toastr/toastr.min.js")
         ->addJs("/assets/private/js/jQuery.filtr.js")
         ->addjs("/assets/private/js/TweenMax.min.js")
         ->addjs("/assets/private/js/joinable.js")
         ->addjs("/assets/private/js/resizeable.js")
         ->addjs("/assets/private/js/xenon-api.js")
         ->addjs("/assets/private/js/xenon-toggles.js")
         ->addjs("/assets/private/js/moment.min.js")
         ->addjs("/assets/private/js/xenon-custom.js")
         ->addjs("/assets/private/js/custom.js")
         ->addjs("/assets/private/js/ckeditor/ckeditor.js");

     $ApiFunctions    = new ApiFunctions;
     $current_session = $ApiFunctions->HandleSession();

     if($current_session)
     {
       # SET User data
       $user = Users::findFirst($current_session);
       $this->arcolon_user = $user;

       $info = UserInfo::findFirstByUid($current_session);
       $this->arcolon_user_info = $info;

       $this->view->current_user = (object)[
         "name" => $info->name,
         "email" => $user->email,
         "username" => $user->username,
       ];
     }

   }

}
