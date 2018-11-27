<?php

use \HOdonto\Model\Dentist;
use \HOdonto\Model\Patient;

$app->post('/lockup/dentist', function(){
	if (isset($_POST['q']))
		echo Dentist::lockUp($_POST['q']);
});

$app->post('/lockup/patient', function(){
	if (isset($_POST['q']))
		echo Patient::lockUp($_POST['q']);
});

?>