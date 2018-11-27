<?php

use \HOdonto\Model\Patient;

$app->post('/patient/find', function(){

	if (!isset($_POST['id'])) $_POST['id'] = 0;

	$patient = new Patient();

	$patient->get((int)$_POST['id']);

	echo json_encode($patient->getValues());
});

$app->post('/patient/save', function(){

	$patient = new Patient();

	if (!isset($_POST['id'])) $_POST['id'] = 0;
	
	if (!isset($_POST['name'])){
		$patient->setcode(1);
		$patient->setmessage('Inform the patient name.');
	} else {
		$patient->setData($_POST);
		$patient->save();
	}

	echo json_encode($patient->getValues());
});

$app->post('/patient/delete', function(){

	if (!isset($_POST['id'])) $_POST['id'] = 0;

	$patient = new Patient();

	$patient->delete((int)$_POST['id']);
	$patient->setcode(0);
	$patient->setmessage('Patient deleted!');
	echo json_encode($patient->getValues());
});

?>