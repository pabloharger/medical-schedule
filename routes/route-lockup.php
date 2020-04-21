<?php

use \HOdonto\Model\Dentist;
use \HOdonto\Model\Patient;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/lockup', function (RouteCollectorProxy $group) {

	$group->get('/dentist', function (Request $request, Response $response) {
  	if (isset($_GET['q'])) echo Dentist::lockUp($_GET['q']);
		return $response;
	});

	$group->get('/patient', function (Request $request, Response $response) {
		if (isset($_GET['q']))
			echo Patient::lockUp($_GET['q']);
			return $response;
	});
});

?>