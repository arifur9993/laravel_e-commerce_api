<?php

namespace App\Services\CustomServices;

class CustomServices{

  /*=============================================
  * Get Verification Code for User Registration
  *
  * @param optional (random number minimum and maximum range)
  * @return int (between $min/$max)
  #=============================================*/
  public function getVerificationCode($min = 10000, $max=99999){
    return rand($min, $max);
  }

  /*=============================================
  * Call External Webservices using CURL
  *
  * @param $requestURL, $header -> (OPTIONAL)
  * @return json
  #=============================================*/
  public function curlRequest($requestURL, $headers = array())
  {
    $getData = curl_init($requestURL);
    curl_setopt($getData, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($getData, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($getData, CURLOPT_SSL_VERIFYHOST, false);
    if (count($headers) != 0) {
      curl_setopt($getData, CURLOPT_HTTPHEADER, $headers);
    }
    $response = curl_exec($getData);
    return json_decode($response);
  }


}
