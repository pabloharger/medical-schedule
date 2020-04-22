<?php

use \HOdonto\Service\Page;
use \HOdonto\Model\User;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('', function (RouteCollectorProxy $group) {

  $group->get('/', function(Request $request, Response $response, $args){
    if (!User::checkSignIn()){
      header('Location: /account/signin');
      exit;
    }

    $page = new Page();
    $page->setTpl('index', [
      'name' => $_SESSION[User::SESSION]['firstName']
    ]);
    return $response;
  });

  $group->get('/lang/{lang}', function(Request $request, Response $response, $args){
    setcookie('lang', $args['lang'], time() + (10 * 365 * 24 * 60 * 60), '/');
    setcookie('langInitials', substr($args['lang'], 0, 2), time() + (10 * 365 * 24 * 60 * 60), '/');

    header('Location: ' . $request->getServerParams()['HTTP_REFERER']);
    exit;
  });

  $group->get('/error', function(Request $request, Response $response, $args){
    $page = new Page();
    $page->setTpl('error', Array(
      'error'=>User::getError()
    ));
    return $response;
  });

  $group->get('/doctor', function(Request $request, Response $response, $args){
    User::verifySignIn();
    $page = new Page();
    $page->setTpl('doctor');
    return $response;
  });

  $group->get('/patient', function(Request $request, Response $response, $args){
    User::verifySignIn();
    $page = new Page();
    $page->setTpl('patient');
    return $response;
  });

  $group->get('/schedule', function(Request $request, Response $response, $args){
    User::verifySignIn();
    $page = new Page();
    $page->setTpl('schedule');
    return $response;
  });

  $group->group('/account', function (RouteCollectorProxy $group) {

    $group->get('/signin', function(Request $request, Response $response, $args){
      if (User::verifySignIn()){
        header('Location: /');
        exit;
      }
  
      $page = new Page();
      $page->setTpl('signIn', Array(
        'error'=>User::getError(),
        'info'=>User::getInfo()
      ));
  
      return $response;
    });

    $group->get('/signup', function(Request $request, Response $response, $args){
      $page = new Page();
  
      $page->setTpl('signUp', Array(
        'error'=>User::getError(),
        'regVal'=>(isset($_SESSION['signUpValues'])
        ? $_SESSION['signUpValues'] 
        : Array(
          'email'=>'',
          'name'=>''
        ))
      ));
  
      return $response;
    });

    $group->group('/forgot', function (RouteCollectorProxy $group) {

      $group->get('', function(Request $request, Response $response, $args){
        $page = new Page();
        $page->setTpl('forgot', Array(
          'error'=>User::getError()
        ));
        return $response;
      });

      $group->get('/reset/{token}', function(Request $request, Response $response, $args){
        try {
          $user = User::validateForgotToken($args['token']);	
        } catch(Exception $e) {
          User::setError($e->getMessage());
          header('Location: /error');
          exit;
        }

        $page = new Page();

        $page->setTpl('forgot-reset', array(
          'name'=>$user["name"],
          'token'=>$args['token'],
          "error"=>User::getError()
        ));

        return $response;
      });

    });

    $group->group('/activate', function (RouteCollectorProxy $group) {

      $group->get('', function(Request $request, Response $response, $args){
        $page = new Page();
        $page->setTpl('resend-activation', Array(
          'error'=>User::getError()
        ));
        return $response;
      });
  
    });

  });

});

?>
