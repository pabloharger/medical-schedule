<?php 
session_start();

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;

require_once("vendor/autoload.php");

$dotenv = Dotenv::createMutable(__DIR__);
$dotenv->load();

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