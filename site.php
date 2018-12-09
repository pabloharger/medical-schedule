<?php

use \HOdonto\Page;
use \HOdonto\Model\User;

$app->get('/', function(){

	if (!User::checkLogin()){
		header('Location: /login');
		exit;
	}

	$page = new Page();

	$page->setTpl('index');

});

$app->get('/logout', function(){

	User::logout();

	header('Location: /login');
	exit;

});

$app->get('/login', function(){

	if (User::checkLogin()){
		header('Location: /');
		exit;
	}

	$page = new Page();

	$page->setTpl('login', Array(
		'error'=>User::getError()
	));
});

$app->post('/login', function(){

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

$app->get('/register', function(){
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
});

$app->post('/register', function(){
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

	exit;
});

$app->get('/dentist', function(){

	User::verifyLogin();

	$page = new Page();

	$page->setTpl('dentist');

});

$app->get('/patient', function(){

	User::verifyLogin();

	$page = new Page();

	$page->setTpl('patient');

});

$app->get('/schedule', function(){

	User::verifyLogin();

	$page = new Page();

	$page->setTpl('schedule');

});

$app->get('/forgot', function(){

	$page = new Page();

	$page->setTpl('forgot', Array(
		'error'=>User::getError()
	));

});

$app->post('/forgot', function(){
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

$app->get('/forgot/sent', function(){

	$page = new Page();

	$page->setTpl('/forgot-sent');

});

$app->get('/forgot/reset/:code', function($code){
	
	try {
		$user = User::validForgotDecrypt($code);	
	} catch(Exception $e) {
		User::setError($e->getMessage());
		header('Location: /forgot-error');
		exit;		
	}

	$page = new Page();

	$page->setTpl('forgot-reset', array(
		'name'=>$user["name"],
		'code'=>$code
	));

});

$app->get('/forgot-error', function(){

	$page = new Page();

	$page->setTpl('forgot-error', Array(
		'error'=>User::getError()
	));

});

$app->post('/forgot/reset', function(){

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

});

$app->get('/forgot-reset-success', function(){

	$page = new Page();

	$page->setTpl('forgot-reset-success');

})

?>












