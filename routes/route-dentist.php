<?php

use \HOdonto\Model\Dentist;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/dentist', function (RouteCollectorProxy $group) {

  $group->get('/{id}', function(Request $request, Response $response, $args){
    $dentist = new Dentist();
    echo json_encode($dentist->get((int)$args['id']));
    return $response;
  });

  $group->post('/', function(Request $request, Response $response, $args){
    $dentist = new Dentist();

    $dentist->setValues($_POST);
    echo json_encode($dentist->post());
    return $response;
  });

  $group->put('/{id}', function(Request $request, Response $response, $args){
    parse_str(file_get_contents("php://input"), $PUT);
    $dentist = new Dentist();

    if (!isset($args['id'])) {
      $dentist->setcode(1);
      $dentist->setmessage('Incorrect argument "id".');
      echo json_encode($dentist->getValues());
      return $response;
    }

    $dentist->setValues($PUT);
    $dentist->put($args['id']);

    echo json_encode($dentist->getValues());
    return $response;
  });

  $group->delete('/{id}', function(Request $request, Response $response, $args){
    $dentist = new Dentist();

    if (!isset($args['id'])) {
      $dentist->setcode(1);
      $dentist->setmessage('Incorrect argument "id".');
      echo json_encode($dentist->getValues());
      return $response;
    }
    
    $dentist->delete((int)$args['id']);
    $dentist->setcode(0);
    $dentist->setmessage('Dentist deleted!');
    echo json_encode($dentist->getValues());
    return $response;
  });

});

?>