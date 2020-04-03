<?php

use \HOdonto\Model\Dentist;
use \HOdonto\Model\Patient;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/lockup', function (RouteCollectorProxy $group) {

	$group->post('/dentist', function (Request $request, Response $response, $args) {
		if (isset($_POST['q']))
			echo Dentist::lockUp($_POST['q']);
		return $response;
	});

	$group->post('/patient', function (Request $request, Response $response, $args) {
		if (isset($_POST['q']))
			echo Patient::lockUp($_POST['q']);
			return $response;
	});
});

?>