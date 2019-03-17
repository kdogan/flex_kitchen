<?php

if(isset($_REQUEST["tokenRequested"])){
  echo getToken();
}
function getToken(){
    $curl = curl_init();

    curl_setopt_array($curl, array(
    CURLOPT_URL => "http://openapi.elfihri.com/token",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "grant_type=password&username=open.coders&password=12345",
    CURLOPT_HTTPHEADER => array(
        "Accept: application/json",
        "Content-Type: application/x-www-form-urlencoded",
        "Postman-Token: 92324560-7d6b-4353-8aac-f3cec3047bb8",
        "cache-control: no-cache"
    ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    return "cURL Error #:" . $err;
    } else {
    return $response;
    }
}