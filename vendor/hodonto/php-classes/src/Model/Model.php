<?php

namespace HOdonto\Model;

class Model {

  const ERROR = "error";
  const INFO  = 'info';

  private $values = [];

  public function __call($name, $args)
  {
    $method = substr($name, 0, 3);
    $fieldName = substr($name, 3, strlen($name));

    switch ($method)
    {
      case "get":
        return (isset($this->values[$fieldName])) ? $this->values[$fieldName] : NULL;
        break;

      case "set":
        $this->values[$fieldName] = $args[0];
        break;
    }
  }

  public function setValues($data = array())
  {
    foreach ($data as $key => $value) {
      $this->{"set".$key}($value);
    }
  }

  public function getValues()
  {
    return $this->values;
  }

  public function __toString()
  {
    try
    {
      return json_encode($this->values);
    } 
    catch (\Exception $exception) 
    {
      return '';
    }
  }

  public static function setError($msg)
  {
    $_SESSION[Model::ERROR] = $msg;
  }

  public static function getError()
  {
    $msg = (isset($_SESSION[Model::ERROR]) && $_SESSION[Model::ERROR]) ? $_SESSION[Model::ERROR] : '';
    Model::clearError();
    return $msg;
  }

  public static function clearError()
  {
    $_SESSION[Model::ERROR] = NULL;
  }

  public static function setInfo($msg)
  {
    $_SESSION[Model::INFO] = $msg;
  }

  public static function getInfo()
  {
    $msg = (isset($_SESSION[Model::INFO]) && $_SESSION[Model::INFO]) ? $_SESSION[Model::INFO] : '';
    Model::clearInfo();
    return $msg;
  }

  public static function clearInfo()
  {
    $_SESSION[Model::INFO] = NULL;
  }

}

?>