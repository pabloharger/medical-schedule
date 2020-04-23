<?php

use \HOdonto\Model\Schedule;
use Slim\Routing\RouteCollectorProxy;
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

$app->group('/schedule', function (RouteCollectorProxy $group) {

  $group->get('/{id}', function (Request $request, Response $response, $args) {
    $schedule = new Schedule();
    echo json_encode($schedule->get((int)$args['id']));
    return $response;
  });

  $group->get('/', function (Request $request, Response $response, $args) {
    $schedule = new Schedule();
    $payload = json_encode($schedule->getInterval($_GET['dateTimeStart'], $_GET['dateTimeEnd']), JSON_PRETTY_PRINT);
    $response->getBody()->write($payload);
    return $response->withHeader('Content-Type', 'application/json');
  });

  $group->post('/', function (Request $request, Response $response, $args) {
    $schedule = new Schedule();
    if (!isset($_POST['id'])) $_POST['id'] = 0;

    try {
      if (!isset($_POST['doctorId']) || (int)$_POST['doctorId'] === 0){
        throw new Exception(L('interface_waring_informDoctor'));
      }

      if (!isset($_POST['patientId']) || (int)$_POST['patientId'] === 0){
        throw new Exception(L('interface_waring_informPatient'));
      }

      if (!isset($_POST['dateTimeBegin'])){
        throw new Exception(L('interface_waring_informInitialTime'));
      }

      if (!isset($_POST['dateTimeEnd'])){
        throw new Exception(L('interface_waring_informFinalTime'));
      }
    } catch (Exception $e) {
      $schedule->setcode(1);
      $schedule->setmessage($e->getMessage());
    }

    $schedule->setValues($_POST);
    $schedule->post();

    echo json_encode($schedule->getValues());
    return $response;
  });

  $group->put('/{id}', function (Request $request, Response $response, $args) {
    parse_str(file_get_contents("php://input"), $PUT);

    $schedule = new Schedule();

    if (!isset($args['id'])) {
      $schedule->setcode(1);
      $schedule->setmessage(L('interface_waring_incorrectArgument'));
      echo json_encode($schedule->getValues());
      return $response;
    }

    $schedule->setValues($PUT);
    echo json_encode($schedule->put());
    return $response;
  });

  $group->delete('/{id}', function (Request $request, Response $response, $args) {
    $schedule = new Schedule();

    if (!isset($args['id'])) {
      $schedule->setcode(1);
      $schedule->setmessage(L('interface_waring_incorrectArgument'));
      echo json_encode($schedule->getValues());
      return $response;
    }
    
    $schedule->delete((int)$args['id']);
    $schedule->setcode(0);
    $schedule->setmessage(L('interface_info_ScheduleDeleted'));
    echo json_encode($schedule->getValues());
    return $response;
  });

});

?>