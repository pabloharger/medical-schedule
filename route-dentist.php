<?php

use \HOdonto\Model\Dentist;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/dentist', function (RouteCollectorProxy $group) {

	$group->post('/find', function(Request $request, Response $response, $args){

		if (!isset($_POST['id_dentist'])) $_POST['id_dentist'] = 0;
	
		$dentist = new Dentist();
	
		$dentist->get((int)$_POST['id_dentist']);
	
		echo json_encode($dentist->getValues());
	
		return $response;
	});
	
	$group->post('/save', function(Request $request, Response $response, $args){
	
		$dentist = new Dentist();
	
		if (!isset($_POST['id_dentist'])) $_POST['id_dentist'] = 0;
		
		if (!isset($_POST['name'])){
			$dentist->setcode(1);
			$dentist->setmessage('Inform the dentist name.');
		} else {
			$dentist->setValues($_POST);
			$dentist->save();
		}
	
		echo json_encode($dentist->getValues());
	
		return $response;
	});
	
	$group->post('/delete', function(Request $request, Response $response, $args){
	
		if (!isset($_POST['id_dentist'])) $_POST['id_dentist'] = 0;
	
		$dentist = new Dentist();
	
		$dentist->delete((int)$_POST['id_dentist']);
		$dentist->setcode(0);
		$dentist->setmessage('Dentist deleted!');
		echo json_encode($dentist->getValues());
	
		return $response;
	});

});

?>