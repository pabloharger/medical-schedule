<?php 
session_start();

use Dotenv\Dotenv;
use Slim\Factory\AppFactory;
use \HOdonto\Service\I18n;

require_once("vendor/autoload.php");

// i18n
$i18n = new i18n('lang/lang_{LANGUAGE}.json', 'tmp/i18n-cache/', 'en_GB');
$i18n->setSectionSeparator('.');
$i18n->init();

// .ENV
if (file_exists(__DIR__ . '/.env')) {
  $dotenv = Dotenv::createMutable(__DIR__);
  $dotenv->load();
}

// Create App
$app = AppFactory::create();

// Add Routing Middleware
$app->addRoutingMiddleware();

$errorMiddleware = $app->addErrorMiddleware(true, true, true);

require_once("routes/functions.php");
require_once("routes/route-site.php");
require_once("routes/route-auth.php");
require_once("routes/route-lockup.php");
require_once("routes/route-dentist.php");
require_once("routes/route-patient.php");
require_once("routes/route-schedule.php");

$routes = $app->getRouteCollector()->getRoutes();
echo 'aq<pre>';
var_dump($routes);
echo '</pre>';
exit;

$app->run();

?>