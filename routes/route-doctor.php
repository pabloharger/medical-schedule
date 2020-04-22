<?php

use \HOdonto\Model\Doctor;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/doctor', function (RouteCollectorProxy $group) {

  $group->get('/{id}', function(Request $request, Response $response, $args){
    $doctor = new Doctor();
    echo json_encode($doctor->get((int)$args['id']));
    return $response;
  });

  $group->post('/', function(Request $request, Response $response, $args){
    $doctor = new Doctor();

    $doctor->setValues($_POST);
    echo json_encode($doctor->post());
    return $response;
  });

  $group->put('/{id}', function(Request $request, Response $response, $args){
    parse_str(file_get_contents("php://input"), $PUT);
    $doctor = new Doctor();

    if (!isset($args['id'])) {
      $doctor->setcode(1);
      $doctor->setmessage('Incorrect argument "id".');
      echo json_encode($doctor->getValues());
      return $response;
    }

    $doctor->setValues($PUT);
    $doctor->put($args['id']);

    echo json_encode($doctor->getValues());
    return $response;
  });

  $group->delete('/{id}', function(Request $request, Response $response, $args){
    $doctor = new Doctor();

    if (!isset($args['id'])) {
      $doctor->setcode(1);
      $doctor->setmessage('Incorrect argument "id".');
      echo json_encode($doctor->getValues());
      return $response;
    }
    
    $doctor->delete((int)$args['id']);
    $doctor->setcode(0);
    $doctor->setmessage('Doctor deleted!');
    echo json_encode($doctor->getValues());
    return $response;
  });

});

?>