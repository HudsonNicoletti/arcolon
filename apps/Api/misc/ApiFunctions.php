<?php

namespace Api\Misc;

use Phalcon\Mvc\Controller,
    Mustache_Engine as Mustache;

use Api\Misc\ApiExceptions as ApiException;

class ApiFunctions extends ControllerBase
{
  /*
   * @throws
   */
  public function sendEmail(array $data)
  {
    $data     = (object) $data;
    $template = file_get_contents(__DIR__."/../../../templates/mail.tpl");

    if(!$template)
    {
      throw new \Exception("Template not found", 1);
    }

    $this->mail->functions->From       = $data->from->email;
    $this->mail->functions->FromName   = $data->from->name;

    $this->mail->functions->addAddress($this->configuration->mail->email);
    $this->mail->functions->Subject   = "Website Contact";

    $this->mail->functions->Body = (new Mustache)->render($template, [
      'NAME'    => $data->from->name,
      'TEXT'    => $data->message,
    ]);

    $response = ($this->mail->functions->send() ? true : false);
    $this->mail->functions->ClearAddresses();

    if(!$response)
    {
      throw new \Exception("Error Processing Request", 1);
    }

    return $response;
  }
}
