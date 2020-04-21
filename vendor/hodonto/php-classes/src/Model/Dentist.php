<?php

namespace HOdonto\Model;

use \HOdonto\Model\Model;
use \HOdonto\API\Api;

class Dentist extends Model
{

  public static function lockUp($search)
  {
    $res = Api::run(Api::getRoutes()->dentist->get, ['firstName' => [ '$substring' => $search ]]);

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

  public function get($idDentist)
  {
    $res = Api::run(Api::formatRouteUri(Api::getRoutes()->dentist->getId, $idDentist));

    $this->setcode(0);
    if ($res['status']['code'] == 200) {
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
    $res = Api::run(Api::getRoutes()->dentist->post, $data);

    if ($res['status']['code'] == 201) {
      $this->setcode(0);
      $this->setmessage(L('interface_info_dentistSaved'));
      $this->setValues($res['response']);
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }
    return $this->getValues();
  }

  public function put()
  {
    $res = Api::run(Api::formatRouteUri(Api::getRoutes()->dentist->put, (int)$this->getid()), $this->getvalues());

    if ($res['status']['code'] == 201) {
      $this->setcode(0);
      $this->setmessage(L('interface_info_dentistSaved'));
    } else {
      $this->setcode(1);
      $this->setmessage($res['status']['message']);
    }
    return $this->getValues();
  }

  public function delete($idDentist)
  {
    Api::run(Api::formatRouteUri(Api::getRoutes()->dentist->delete, $idDentist));
  }

}

?>