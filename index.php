<?php 

session_start();

require_once("vendor/autoload.php");

use \Slim\Slim;

$app = new Slim();

$app->config('debug', true);

require_once("site.php");
require_once("lockup.php");
require_once("dentist.php");
require_once("patient.php");
require_once("schedule.php");

$app->run();

?>