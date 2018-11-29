<?php

use \HOdonto\Model\Schedule;

$app->post('/schedule/get', function(){

	if (!isset($_POST['id'])) $_POST['id'] = 0;

	$schedule = new Schedule();

	echo json_encode( $schedule->get((int)$_POST['id']) );

});

$app->post('/schedule/save', function(){

	$schedule = new Schedule();

	if (!isset($_POST['id'])) $_POST['id'] = 0;
	
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

	$schedule->setData($_POST);
	$schedule->save();	

	echo json_encode($schedule->getValues());
});

$app->post('/schedule/delete', function(){

	if (!isset($_POST['id'])) $_POST['id'] = 0;

	$schedule = new Schedule();

	$schedule->delete((int)$_POST['id']);
	$schedule->setcode(0);
	$schedule->setmessage('Schedule deleted!');
	echo json_encode($schedule->getValues());
});

$app->post('/schedule/refresh', function(){
	if (isset($_POST['id']) || (int)$_POST['id'] > 0){
		$schedule = new Schedule();
		$schedule->get((int)$_POST['id']);
		$schedule->setdate_time_begin($_POST['date_time_begin']);
		$schedule->setdate_time_end($_POST['date_time_end']);
		$schedule->save();
		$schedule->setcode(0);
		$schedule->setmessage('');
		$schedule->get((int)$_POST['id']);
		echo json_encode($schedule->getValues());
	}
});

?>