<?php

namespace Api\Misc;

use \Phalcon\Exception;

class ApiExceptions extends \Phalcon\Exception
{
  public static function InvalidCsrfToken()
  {
    throw new Exception("Invalid CSRF Token", 6);
  }

  public static function InvalidEmailAddress()
  {
    throw new Exception("Invalid E-Mail Address", 1);
  }

  public static function WrongNumberOfParams()
  {
    throw new Exception("Wrong number of parameters", 1);
  }

  public static function InvalidRequestMethod()
  {
    throw new Exception("Invalid Request Method", 1);
  }

  public static function RegisteredEmailAddress()
  {
    throw new Exception("E-Mail already in use, please use a different e-mail address.", 1);
  }

  public static function RegisteredUsername()
  {
    throw new Exception("Username already in use, please use a different username.", 1);
  }

  public static function EmptyInput($field)
  {
    if(is_array($field))
    {
      $fl = "";
      foreach ($field as $f){ $fl .= " {$f},"; }
      $fl = rtrim($fl,",");
      $message = "The &nbsp;<u><b>{$fl}</u></b>&nbsp; fields can't be left empty. Please fill out the fields to continue.";
    }
    else
    {
      $message = "The &nbsp;<u><b>{$field}</u></b>&nbsp; field can't be left empty. Please fill out the field to continue.";
    }
    throw new Exception($message, 1);
  }

  public static function Unreachable()
  {
    throw new Exception("Server was unable to reach the request in the database.", 1);
  }

  public static function DBError()
  {
    throw new Exception("Unable to save information to database.", 1);
  }

  public static function NotIncluded($a)
  {
    if(is_array($a))
    {
      $as = "";
      foreach ($a as $s){ $as .= " {$s},"; }
      $as = rtrim($as,",");

      $msg = "Unable to include: &nbsp;<u><b>{$as}</b></u>&nbsp;";
    }
    else
    {
      $msg = "Unable to include: &nbsp;<u><b>{$a}</b></u>&nbsp;";
    }
    throw new Exception($msg, 1);
  }

  public static function NotificationError($user)
  {
    if(is_array($user))
    {
      $users = "";
      foreach ($user as $u){ $users .= " {$u},"; }
      $users = rtrim($users,",");

      $msg = "Unable to create notifications for the users: &nbsp;<u><b>{$users}</b></u>&nbsp;";
    }
    else
    {
      $msg = "Unable to create notification for the user: &nbsp;<u><b>{$user}</b></u>&nbsp;";
    }
    throw new Exception($msg, 1);
  }

  public static function EmailSendError($email)
  {
    if(is_array($email))
    {
      $emails = "";
      foreach ($email as $e){ $emails .= " {$e},"; }
      $emails = rtrim($emails,",");

      $msg = "Unable to send e-mail notifications to: &nbsp;<b><u>{$emails}</u></b>&nbsp;";
    }
    else
    {
      $msg = "Unable to send e-mail notification to &nbsp;<b><u>{$email}</u></b>&nbsp;";
    }
    throw new Exception($msg, 1);
  }

  public static function AccessDenied($type)
  {
    switch ($type) {
      case null: $str = "Sorry, you don't have access to the dashbord!";  break;
      case "password": $str = "Sorry, you don't have the right authorazation access to the dashbord!";  break;
    }
    throw new Exception("Sorry, you don't have access to the dashbord!", 1);
  }


  public static function Unknown()
  {
    throw new Exception("Somthing went wrong!", 1);
  }

  public static function UploadError($level = 0)
  {
    switch ($level)
    {
      case 1 : $e = "The file exceeded the max file size accepted!"; break;
      case 2 : $e = "The file exceeded the max file size accepted!"; break;
      case 3 : $e = "The file was only partially uploaded!"; break;
      case 4 : $e = "Unable to upload file!"; break;
      case 6 : $e = "Missing temporary folder!"; break;
      case 7 : $e = "Failed to write file to disk!"; break;
      case 8 : $e = "A PHP extension conflicted and stopped the file upload."; break;
      default : $e = "No file was submited!"; break;
    }
    throw new Exception($e, 1);
  }

}
