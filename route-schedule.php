<?php

use \HOdonto\Model\Schedule;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/schedule', function (RouteCollectorProxy $group) {

	$group->get('/get/{id_schedule}', function (Request $request, Response $response, $args) {
		if (!isset($args['id_schedule'])) $args['id_schedule'] = 0;
		$schedule = new Schedule();
		echo json_encode( $schedule->get((int)$args['id_schedule']) );
		return $response;
	});

	$group->get('/get', function (Request $request, Response $response, $args) {
		$schedule = new Schedule();
		$payload = json_encode($schedule->getInterval($_GET['start'], $_GET['end']), JSON_PRETTY_PRINT);
		$response->getBody()->write($payload);
		return $response->withHeader('Content-Type', 'application/json');
	});

	$group->post('/save', function (Request $request, Response $response, $args) {

		$schedule = new Schedule();

		if (!isset($_POST['id_schedule'])) $_POST['id_schedule'] = 0;

		try {
			if (!isset($_POST['id_dentist']) || (int)$_POST['id_dentist'] === 0){
				throw new Exception("Inform the dentist");
			}

			if (!isset($_POST['id_patient']) || (int)$_POST['id_patient'] === 0){
				throw new Exception("Inform the patient");
			}

			if (!isset($_POST['date_time_begin'])){
				throw new Exception("Inform the initial date and time");
			}

			if (!isset($_POST['date_time_end'])){
				throw new Exception("Inform the final date and time");
			}
		} catch (Exception $e) {
			$schedule->setcode(1);
			$schedule->setmessage($e->getMessage());
		}

		$schedule->setValues($_POST);
		$schedule->save();	

		echo json_encode($schedule->getValues());
		return $response;
	});

	$group->post('/delete', function (Request $request, Response $response, $args) {

		if (!isset($_POST['id_schedule'])) $_POST['id_schedule'] = 0;

		$schedule = new Schedule();

		$schedule->delete((int)$_POST['id_schedule']);
		$schedule->setcode(0);
		$schedule->setmessage('Schedule deleted!');
		echo json_encode($schedule->getValues());
		return $response;

	});

	$group->post('/refresh', function (Request $request, Response $response, $args) {

		if (isset($_POST['id_schedule']) || (int)$_POST['id_schedule'] > 0){
			$schedule = new Schedule();
			$schedule->get((int)$_POST['id_schedule']);
			$schedule->setdate_time_begin($_POST['date_time_begin']);
			$schedule->setdate_time_end($_POST['date_time_end']);
			$schedule->save();
			$schedule->setcode(0);
			$schedule->setmessage('');
			$schedule->get((int)$_POST['id_schedule']);
			echo json_encode($schedule->getValues());
		}
		return $response;
	});

});

?>