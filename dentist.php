<?php

use \HOdonto\Model\Dentist;

$app->post('/dentist/find', function(){

	if (!isset($_POST['id_dentist'])) $_POST['id_dentist'] = 0;

	$dentist = new Dentist();

	$dentist->get((int)$_POST['id_dentist']);

	echo json_encode($dentist->getValues());
});

$app->post('/dentist/save', function(){

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
});

$app->post('/dentist/delete', function(){

	if (!isset($_POST['id_dentist'])) $_POST['id_dentist'] = 0;

	$dentist = new Dentist();

	$dentist->delete((int)$_POST['id_dentist']);
	$dentist->setcode(0);
	$dentist->setmessage('Dentist deleted!');
	echo json_encode($dentist->getValues());
});

?>