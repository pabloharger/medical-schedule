<?php

use \HOdonto\Model\Patient;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/patient', function (RouteCollectorProxy $group) {
	$group->post('/find', function(Request $request, Response $response, $args){

		if (!isset($_POST['id_patient'])) $_POST['id_patient'] = 0;

		$patient = new Patient();

		$patient->get((int)$_POST['id_patient']);

		echo json_encode($patient->getValues());

		return $response;
	});

	$group->post('/save', function(Request $request, Response $response, $args){

		$patient = new Patient();

		if (!isset($_POST['id_patient'])) $_POST['id_patient'] = 0;
		
		if (!isset($_POST['name'])){
			$patient->setcode(1);
			$patient->setmessage('Inform the patient name.');
		} else {
			$patient->setValues($_POST);
			$patient->save();
		}

		echo json_encode($patient->getValues());

		return $response;
	});

	$group->post('/delete', function(Request $request, Response $response, $args){

		if (!isset($_POST['id_patient'])) $_POST['id_patient'] = 0;

		$patient = new Patient();

		$patient->delete((int)$_POST['id_patient']);
		$patient->setcode(0);
		$patient->setmessage('Patient deleted!');
		echo json_encode($patient->getValues());

		return $response;
	});

});

?>