<?php

namespace HOdonto\Model;

use \HOdonto\API\Api;
use \HOdonto\Model\Model;

class Schedule extends Model
{
  public function get($idSchedule)
  {
    $res = Api::run(Api::formatRouteUri(Api::getRoutes()->schedule->getId, $idSchedule));
    $this->setcode(0);
    if ($res['status']['code'] == 200) {
      $this->setValues($res['response']);
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }

    return $this->getValues();
  }

  public function getInterval($dateTimeStart, $dateTimeEnd)
  {
    $res = Api::run(
      Api::getRoutes()->schedule->get,
      [
        "dateTimeBegin" => [
          '$between' => [$dateTimeStart, $dateTimeEnd]
        ],
        "dateTimeEnd" => [
          '$between' => [$dateTimeStart, $dateTimeEnd]
        ]
      ]
    );

    if ($res['status']['code'] == 200) {
      return $res['response'];
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }
    return $this;
  }

  public function post()
  {
    $data = $this->getValues();
    unset($data['id']);
    $res = Api::run(Api::getRoutes()->schedule->post, $data);

    if ($res['status']['code'] == 201) {
      $this->setcode(0);
      $this->setmessage(L('interface_info_scheduleSaved'));
      $this->setValues($res['response']);
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }
    return $this;
  }

  public function put()
  {
    $res = Api::run(
      Api::formatRouteUri(
        Api::getRoutes()->schedule->put,
        (int)$this->getid()
      ),
        $this->getValues()
      );

    if ($res['status']['code'] == 201) {
      $this->setcode(0);
      $this->setmessage(L('interface_info_scheduleSaved'));
      $this->setValues($res['response']);
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }
    return $this->getValues();
  }

  public function delete($idSchedule)
  {
    Api::run(Api::formatRouteUri(Api::getRoutes()->schedule->delete, $idSchedule));
  }
}

?>