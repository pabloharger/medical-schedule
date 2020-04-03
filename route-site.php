<?php

use \HOdonto\Page;
use \HOdonto\Model\User;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('', function (RouteCollectorProxy $group) {

	$group->get('/', function(Request $request, Response $response, $args){

		if (!User::checkLogin()){
			header('Location: /login');
			exit;
		}

		$page = new Page();

		$page->setTpl('index');

		return $response;
	});

	$group->get('/logout', function(){

		User::logout();

		header('Location: /login');
		exit;

	});

	$group->get('/login', function(Request $request, Response $response, $args){

		if (User::checkLogin()){
			header('Location: /');
			exit;
		}

		$page = new Page();

		$page->setTpl('login', Array(
			'error'=>User::getError()
		));

		return $response;

	});

	$group->post('/login', function(Request $request, Response $response, $args){

		if (!isset($_POST['email']) || $_POST['email'] === '') {
			User::setError('Inform the email.');
			header('Location: /login');
			exit;
		}

		if (!isset($_POST['password']) || $_POST['password'] === '') {
			User::setError('Inform the password.');
			header('Location: /login');
			exit;
		}

		User::login($_POST['email'], $_POST['password']);

		header('Location: /');

		exit;
	});

	$group->get('/register', function(Request $request, Response $response, $args){
		$page = new Page();

		$page->setTpl('register', Array(
			'error'=>User::getError(),
			'regVal'=>(isset($_SESSION['registerValues']) 
				? $_SESSION['registerValues'] 
				: Array(
					'email'=>'',
					'name'=>''
			))
		));

		return $response;
	});

	$group->post('/register', function(Request $request, Response $response, $args){
		if (isset($_POST['email']))  $_SESSION['registerValues']['email'] = $_POST['email'];
		if (isset($_POST['name'])) $_SESSION['registerValues']['name'] = $_POST['name'];


		if (!isset($_POST['email']) || $_POST['email'] === '') {
			User::setError('Inform the email.');
			header('Location: /register');
			exit;
		}

		if (!isset($_POST['password']) || $_POST['password'] === '') {
			User::setError('Inform the password.');
			header('Location: /register');
			exit;
		}

		if (!isset($_POST['name']) || $_POST['name'] === '') {
			User::setError('Inform your name.');
			header('Location: /register');
			exit;
		}

		$user = new User();

		$user->setValues($_POST);

		$user->save();

		$_SESSION['registerValues'] = NULL;

		header('Location: /login');

		return $response;
	});

	$group->get('/dentist', function(Request $request, Response $response, $args){

		User::verifyLogin();

		$page = new Page();

		$page->setTpl('dentist');


		return $response;
	});

	$group->get('/patient', function(Request $request, Response $response, $args){

		User::verifyLogin();

		$page = new Page();

		$page->setTpl('patient');

		return $response;
	});

	$group->get('/schedule', function(Request $request, Response $response, $args){

		User::verifyLogin();

		$page = new Page();

		$page->setTpl('schedule');

		return $response;
	});

	$group->get('/forgot-sent', function(Request $request, Response $response, $args){

		$page = new Page();

		$page->setTpl('forgot-sent');

		return $response;
	});

	$group->get('/forgot-error', function(Request $request, Response $response, $args){

		$page = new Page();

		$page->setTpl('forgot-error', Array(
			'error'=>User::getError()
		));

		return $response;
	});

	$group->get('/forgot-reset-success', function(Request $request, Response $response, $args){

		$page = new Page();

		$page->setTpl('forgot-reset-success');

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
	
		$group->post('', function(){
			if (!isset($_POST['email']) || $_POST['email'] === ''){
				User::setError('Inform the email.');
				header('Location: /forgot');
				exit;
			}
	
			if (!User::forgotSent($_POST['email'])){
				header('Location: /forgot');
				exit;
			}
	
			header('Location: /forgot-sent');
			exit;
	
		});

		$group->post('/reset', function(Request $request, Response $response, $args){

			try {
				$forgot = User::validForgotDecrypt($_POST["code"]);	
			} catch(Exception $e) {
				User::setError($e->getMessage());
				header('Location: /forgot-error');
				exit;		
			}

			User::setForgotUsed($forgot["id_recovery"]);

			$user = new User();

			$user->get((int)$forgot["iduser"]);

			$user->setpassword($_POST["password"]);

			$user->update();

			$page = new Page();

			$page->setTpl("forgot-reset-success");

			return $response;
		});

		$group->get('/reset/{code}', function(Request $request, Response $response, $args){
			
			try {
				$user = User::validForgotDecrypt($args['code']);	
			} catch(Exception $e) {
				User::setError($e->getMessage());
				header('Location: /forgot-error');
				exit;
			}
	
			$page = new Page();
	
			$page->setTpl('forgot-reset', array(
				'name'=>$user["name"],
				'code'=>$args['code']
			));
	
			return $response;
		});
	});
});

?>
