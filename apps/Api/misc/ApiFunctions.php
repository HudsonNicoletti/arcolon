<?php

namespace Api\Misc;

use Phalcon\Mvc\Controller,
    Mustache_Engine as Mustache;

use Api\Misc\ApiExceptions as ApiException;

class ApiFunctions extends Controller
{
  /*
  * @param  string  $input String to verify if it is a valid e-mail address
  * @return boolean True|False if the parameter is a valid e-mail address
  */
  public function isEmail(string $input)
  {
   return (preg_match("/^[_\.0-9a-zA-Z-]+@([0-9a-zA-Z][0-9a-zA-Z-]+\.)+[a-zA-Z]{2,6}$/i", $input )) ? true : false;
  }

  /*
  * @param  array   $parameters parameters for unique cone generation
  * @return string  unique code generated
  */
  public function uniqueCode(array $parameters=["prefix"=>false,"suffix"=>false,"limit"=>16])
  {
    $parameters['limit'] = $parameters['limit'] - ($parameters['prefix'] ? strlen($parameters['prefix']) : 0) - ($parameters['suffix'] ? strlen($parameters['suffix']) : 0);
    return $parameters['prefix'].str_shuffle(substr(sha1("".round(time().uniqid())), 0, $parameters['limit'])).$parameters['suffix'];
  }

  /*
  * @uses   abeautifulsite\SimpleImage image manipulation library
  * @param  string  $src image source
  * @param  string  $parameters gets image destination , width and height
  * @return boolean saved or not
  */
  public function ResizeImage(string $src, array $parameters=["dest"=>false, "width"=>128, "height"=>128])
  {
    $image = new SimpleImage($src);
    $image->adaptive_resize($parameters['width'], $parameters['height']);
    (!$parameters["dest"]) ? $save = $image->save() : $save = $image->save($parameters["dest"]);
    return ($save) ? true : false;
  }

  /*
  * @param  array  $inputs gets string to remove spaces
  * @return string  striped spaces
  */
  public function StripSpaces(array $inputs)
  {
    $results = [];
    foreach ($inputs as $key => $value)
    {
      $results[$key] = preg_replace('/\s+/', '', $value );
    }
    return (object) $results;
  }

  /*
  * @param  array  $inputs gets inputs
  * @return boolean  if none is null
  * @throws EmptyInput if any is null
  * @example $ApiFunctions->CheckForNull([ $this->rhyno_translate->global->labels->username => $this->request->getPost("username","string") ]);
  */
  public function CheckForNull(array $inputs)
  {
    $fields = [];
    foreach ($inputs as $key => $value)
    {
      if(!$value)
      {
        array_push($fields, $key );
      }
    }
    return (count($fields) > 0) ? $ApiExceptions::EmptyInput($fields) : true;
  }
  /*
  * @param  string  $date gets date to output
  * @param  boolean  $time gets date_time to output
  * @return \DateTime
  */
  public function HandleSession()
  {
    $di       = \Phalcon\DI::getDefault();
    $session  = $di['session'];
    $router   = $di['router'];
    $response = $di['response'];

    $current_controller = $router->getControllerName();

    if($session->has("arcolon_secure"))
    {
      if ($current_controller == 'login')
      {
        $response->redirect("/admin/index",true);
      }
    }
    else
    {
      if ($current_controller == 'index')
      {
        $response->redirect("/admin",true);
      }
    }

    return $session->get("arcolon_secure") ?? false ;
  }
  /*
  * @param  array  $headers gets email headers
  * @return boolean  if e-mail sent
  * @throws EmailSendError if e-mail not sent
  *
  * @example $ApiFunctions->sendEmail([
  *  "to"    =>  [ "name"  => $name,
  *                "email" => $email ],
  *  "subject" => "Password Rest Confirmation",
  *  "body"    => $body,
  *  ]);
  */
  public function sendEmail(array $data)
  {
    $data     = (object) $data;
    $template = file_get_contents(__DIR__."/../../../templates/mail.tpl");

    if(!$template)
    {
      throw new \Exception("Template not found", 1);
    }

    $this->mail->functions->From       = $data->from['email'];
    $this->mail->functions->FromName   = $data->from['name'];

    $this->mail->functions->addAddress($this->configuration->mail->email);
    $this->mail->functions->Subject   = "Website Contact";

    $this->mail->functions->Body = (new Mustache)->render($template, [
      'NAME'    => $data->from['name'],
      'TEXT'    => $data->message,
    ]);

    $response = ($this->mail->functions->send() ? true : false);
    $this->mail->functions->ClearAddresses();

    if(!$response)
    {
      throw new \Exception("Error Processing Request", 1);
    }
  }
}
