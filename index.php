<?php 
session_start();

use Slim\Factory\AppFactory;
use Slim\Handlers\Strategies\RequestResponseArgs;

require_once("vendor/autoload.php");

$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

require_once("functions.php");
require_once("route-site.php");
require_once("route-lockup.php");
require_once("route-dentist.php");
require_once("route-patient.php");
require_once("route-schedule.php");

$app->run();

?>