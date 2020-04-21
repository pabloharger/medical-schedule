<?php

namespace HOdonto\Model;

use \HOdonto\Model\Model;
use \HOdonto\API\Api;

class Patient extends Model
{

  public static function lockUp($search)
  {
    $res = Api::run(Api::getRoutes()->patient->get, ['firstName' => [ '$substring' => $search ]]);
    if ($res['status']['code'] == 200) {
      $data = Array();
      $data['items'] = [];

      foreach ($res['response'] as $row) {
        array_push(
          $data['items'],
          Array(
            'id'=>$row['id'],
            'text'=>$row['firstName']
        ));
      }
    }
    return json_encode($data);
  }

  public function get($idPatient)
  {
    $res = Api::run(Api::formatRouteUri(Api::getRoutes()->patient->getId, $idPatient));
    if ($res['status']['code'] == 200) {
      $this->setcode(0);
      $this->setValues($res['response']);
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }
    return $this->getValues();
  }

  public function post()
  {
    $data = $this->getvalues();
    unset($data['id']);
    $res = Api::run(Api::getRoutes()->patient->post, $data);

    if ($res['status']['code'] == 201) {
      $this->setcode(0);
      $this->setmessage(L('interface_info_patientSaved'));
      $this->setValues($res['response']);
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }
    return $this->getValues();
  }

  public function put()
  {
    $res = Api::run(Api::formatRouteUri(Api::getRoutes()->patient->put, (int)$this->getid()), $this->getvalues());

    if ($res['status']['code'] == 201) {
      $this->setcode(0);
      $this->setmessage(L('interface_info_patientSaved'));
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }
    return $this->getValues();
  }

  public function delete($idPatient)
  {
    Api::run(Api::formatRouteUri(Api::getRoutes()->patient->delete, $idPatient));
  }

}

?>