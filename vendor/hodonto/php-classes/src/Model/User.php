<?php

namespace HOdonto\Model;

use \HOdonto\Model\Model;
use \HOdonto\API\Api;

class User extends Model {

  const SESSION = "User";
  // const ERROR   = "UserError";
  // const INFO    = 'UserInfo';
  const SECRET  = "HCodePhp7_Secret";
  const SECIV   = "HCodePhp7_SecIV_";
  const ENCRYPTMETHOD = "AES-256-CBC";

  public function get($idUser)
  {
    $res = Api::run(Api::formatRouteUri(Api::getRoutes()->user->getId, $idUser));
    $this->setcode(0);

    if ($res['status']['code'] == 201) {
      if ($res['response']) return $this->setValues($res['response']);
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    } else {
      $this->setcode(1);
      $this->setmessage("User code $idUser not found!");
    }
    return $this->getValues();
  }

  public function post()
  {
    $res = Api::run(Api::getRoutes()->user->post, $this->getValues());
    if ($res['status']['code'] !== 201) throw new \Exception($res['status']['message']);
    $this->setValues($res['response']);
  }

  public static function signIn($email, $password)
  {
    $res = Api::run(Api::getRoutes()->auth->signIn, [
      'email' => $email,
      'password' => $password
    ]);

    $userApi = $res['response']['user'];

    if ($res['status']['code'] == 200 && $userApi) {
      $userApi['name'] = utf8_encode($userApi['name']);

      $user = new User();
      $user->setValues($userApi);

      $_SESSION[User::SESSION] = $user->getValues();
      $_SESSION[Api::API_TOKEN] = $res['response']['token'];

      return $user;
    } else {
      User::setError($res['status']['message']);
      header('Location: /account/signin');
      exit;
    }
  }

  public static function verifySignIn()
  {
    return User::checkSignIn();
  }

  public static function checkSignIn()
  {
    if (
    !isset($_SESSION[User::SESSION])
    ||
    !$_SESSION[User::SESSION]
    ||
    !isset($_SESSION[User::SESSION]["id"])
    ||
    !(int)$_SESSION[User::SESSION]["id"] > 0
    ) return false;
    return true;
  }

  public static function logout()
  {
    $_SESSION[User::SESSION] = NULL;
  }

  public static function forgotSend($email)
  {
    $res = Api::run(Api::getRoutes()->auth->forgot, [ "email" => $email ]);
    if ($res['status']['code'] !== 201) throw new \Exception($res['status']['message']);
    return true;
  }

  public static function validateForgotToken($token)
  {
    $res = Api::run(Api::getRoutes()->auth->forgotCheck, [ "token" => $token ]);
    if ($res['status']['code'] !== 201) throw new \Exception($res['status']['message']);
    return $res['response'];
  }

  public function recoverForgotPassword($token, $password, $password_confirmation)
  {
    $res = Api::run(Api::getRoutes()->auth->forgotReset, [
      "token" => $token,
      "password" => $password,
      "password_confirmation" => $password_confirmation
    ]);
    if ($res['status']['code'] !== 201) throw new \Exception($res['status']['message']);
    return true;
  }

  public static function resendActivationEmail($email)
  {
    $res = Api::run(Api::getRoutes()->auth->resendActivationEmail, ["email" => $email]);
    if ($res['status']['code'] !== 201) throw new \Exception($res['status']['message']);
    return true;
  }

  public static function activateAccount($token)
  {
    $res = Api::run(Api::getRoutes()->auth->activateAccount, ["token" => $token]);
    if ($res['status']['code'] !== 201) throw new \Exception($res['status']['message']);
    return true;
  }
}

?>