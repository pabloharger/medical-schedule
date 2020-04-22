<?php

namespace HOdonto\API;

class Api
{
  const API_TOKEN = 'API_TOKEN';

  public static function run($config, $data = null)
  {
    $curl = curl_init();

    $params = array(
      CURLOPT_URL => getenv('API_URI') . $config->uri,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => $config->method,
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "auth-token: " . $_SESSION[Api::API_TOKEN],
        "Accept-Language: " . $_COOKIE['lang']
      ),
    );

    // Add post fields if it's necessary
    if ($data) $params[CURLOPT_POSTFIELDS] = json_encode($data);

    echo json_encode($params);exit;

    curl_setopt_array($curl, $params);

    $response = json_decode(curl_exec($curl), true);

    curl_close($curl);
    return $response;
  }

  public static function getRoutes()  {
      return json_decode(file_get_contents(__DIR__.'/api-routes.json'));
  }

  public static function formatRouteUri($route, $args) {
    $route->uri = sprintf($route->uri, $args);
    return $route;
  }
}

?>