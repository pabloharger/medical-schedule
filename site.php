<?php

use \HOdonto\Page;

$app->get('/', function(){

	$page = new Page();

	$page->setTpl('index');

});

$app->get('/dentist', function(){

	$page = new Page();

	$page->setTpl('dentist');

});

$app->get('/patient', function(){

	$page = new Page();

	$page->setTpl('patient');

});

$app->get('/schedule', function(){

	$page = new Page();

	$page->setTpl('schedule');

});

?>