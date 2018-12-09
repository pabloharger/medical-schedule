<?php

use \HOdonto\Model\Patient;

$app->post('/patient/find', function(){

	if (!isset($_POST['id_patient'])) $_POST['id_patient'] = 0;

	$patient = new Patient();

	$patient->get((int)$_POST['id_patient']);

	echo json_encode($patient->getValues());
});

$app->post('/patient/save', function(){

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
});

$app->post('/patient/delete', function(){

	if (!isset($_POST['id_patient'])) $_POST['id_patient'] = 0;

	$patient = new Patient();

	$patient->delete((int)$_POST['id_patient']);
	$patient->setcode(0);
	$patient->setmessage('Patient deleted!');
	echo json_encode($patient->getValues());
});

?>