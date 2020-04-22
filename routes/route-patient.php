<?php

use \HOdonto\Model\Patient;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/patient', function (RouteCollectorProxy $group) {

  $group->get('/{id}', function(Request $request, Response $response, $args){
    $patient = new Patient();
    echo json_encode($patient->get((int)$args['id']));
    return $response;
  });

  $group->post('/', function(Request $request, Response $response, $args){
    $patient = new Patient();

    $patient->setValues($_POST);

    echo json_encode($patient->post());
    return $response;
  });

  $group->put('/{id}', function(Request $request, Response $response, $args){
    parse_str(file_get_contents("php://input"), $PUT);
    $patient = new Patient();

    if (!isset($args['id'])) {
      $patient->setcode(1);
      $patient->setmessage(L('interface_waring_incorrectArgument'));
      echo json_encode($patient->getValues());
      return $response;
    }

    $patient->setValues($PUT);
    $patient->put($args['id']);

    echo json_encode($patient->getValues());
    return $response;
  });

  $group->delete('/{id}', function(Request $request, Response $response, $args){
    $patient = new Patient();

    if (!isset($args['id'])) {
      $patient->setcode(1);
      $patient->setmessage(L('interface_waring_incorrectArgument'));
      echo json_encode($patient->getValues());
      return $response;
    }
    
    $patient->delete((int)$args['id']);
    $patient->setcode(0);
    $patient->setmessage(L('interface_info_patientDeleted'));
    echo json_encode($patient->getValues());
    return $response;
  });

});

?>