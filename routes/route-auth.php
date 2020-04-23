<?php

use \HOdonto\Model\User;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('', function (RouteCollectorProxy $group) {

  $group->group('/account', function(RouteCollectorProxy $group) {

    $group->post('/signin', function(Request $request, Response $response, $args){
      if (!isset($_POST['email']) || $_POST['email'] === '') {
        User::setError(L('interface_waring_informEmail'));
        header('Location: /account/signin');
        exit;
      }
  
      if (!isset($_POST['password']) || $_POST['password'] === '') {
        User::setError(L('interface_waring_informPassword'));
        header('Location: /account/signin');
        exit;
      }
  
      User::signin($_POST['email'], $_POST['password']);
      header('Location: /');
      exit;
    });

    $group->get('/logout', function(){
      User::logout();
      header('Location: /account/signin');
      exit;
    });

    $group->post('/signup', function(Request $request, Response $response, $args){
      if (isset($_POST['email']))  $_SESSION['signUpValues']['email'] = $_POST['email'];
      if (isset($_POST['firstName'])) $_SESSION['signUpValues']['firstName'] = $_POST['namfirstName'];
  
      if (!isset($_POST['email']) || $_POST['email'] === '') {
        User::setError(L('interface_waring_informEmail'));
        header('Location: /account/signup');
        exit;
      }
  
      if (!isset($_POST['password']) || $_POST['password'] === '') {
        User::setError(L('interface_waring_informPassword'));
        header('Location: /account/signup');
        exit;
      }
  
      if (!isset($_POST['firstName']) || $_POST['name'] === '') {
        User::setError(L('interface_waring_informFirstName'));
        header('Location: /account/signup');
        exit;
      }
  
      if (!isset($_POST['firstName']) || $_POST['lastName'] === '') {
        User::setError(L('interface_waring_informFirstName'));
        header('Location: /account/signup');
        exit;
      }
  
      try {
        $user = new User();
        $user->setValues($_POST);
        $user->signUp();
        User::setInfo(L('interface_info_userHasBeenRegistered'));
      } catch(Exception $e) {
        User::setError($e->getMessage());
        header('Location: /account/signup');
        exit;
      }
  
      $_SESSION['signUpValues'] = NULL;
      header('Location: /account/signin');
      exit;
    });

    $group->group('/forgot', function (RouteCollectorProxy $group) {

      $group->post('', function(){
        if (!isset($_POST['email']) || $_POST['email'] === ''){
          User::setError(L('interface_waring_informEmail'));
          header('Location: /account/forgot');
          exit;
        }

        try {
          User::forgotSend($_POST['email']);
          User::setInfo(L('interface_info_passwordHasBeenSentFollowInstructions'));
          header('Location: /account/signin');
          exit;
        } catch(Exception $e) {
          User::setError($e->getMessage());
          header('Location: /account/forgot');
          exit;
        }
      });
  
      $group->post('/reset', function(Request $request, Response $response, $args){
        try {
          User::validateForgotToken($_POST["token"]);
        } catch(Exception $e) {
          User::setError($e->getMessage());
          header('Location: /account/forgot/reset');
          exit;
        }
  
        try {
          User::recoverForgotPassword($_POST["token"], $_POST["password"], $_POST["password_confirmation"]);
          User::setInfo(L('interface_info_passwordChangedSuccessfully'));
          header('Location: /account/signin');
          exit;
        } catch(Exception $e) {
          User::setError($e->getMessage());
          header('Location: /account/forgot/reset/' . $_POST["token"] );
          exit;
        }
  
        exit;
      });
  
    });

    $group->group('/activate', function(RouteCollectorProxy $group) {

      $group->post('', function(Request $request, Response $response, $args){
        try {
          User::resendActivationEmail($_POST["email"]);
          User::setInfo(L('interface_info_passwordHasBeenSentFollowInstructions'));
        } catch(Exception $e) {
          User::setError($e->getMessage());
          header('Location: /account/activate');
          exit;
        }
  
        header('Location: /account/signin');
        exit;
      });

      $group->get('/{token}', function(Request $request, Response $response, $args){
        try {
          $user = User::activateAccount($args['token']);	
          User::setInfo(L('interface_info_accountActivatedSuccessfully'));
          header('Location: /account/signin');
          exit;
        } catch(Exception $e) {
          User::setError($e->getMessage());
          header('Location: /error');
          exit;
        }
        return $response;
      });

    });

  });

});

?>