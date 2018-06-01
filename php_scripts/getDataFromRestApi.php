<?php

if(true){

    $metod = isset($_GET["method"]);
    $url = "http://wiki.flexlog.site/rest/api/group/jira-users/member";
    $response = CallAPI("GET", $url);
   // $users = json_decode($response);
   echo $response;
}

function CallAPI($method, $url, $data = false)
{
    $headers = array(
    'Accept: application/json',
    'Content-Type: application/json',
    );
    $curl = curl_init();

    switch ($method)
    {
        case "POST":
            curl_setopt($curl, CURLOPT_POST, 1);

            if ($data)
                curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            break;
        case "PUT":
            curl_setopt($curl, CURLOPT_PUT, 1);
            break;
        default:
            if ($data)
                $url = sprintf("%s?%s", $url, http_build_query($data));
    }

    // Optional Authentication:
    curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
    curl_setopt($curl, CURLOPT_USERPWD, "wiki@flexlog.site:w1k1flexlog!");
    curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);


    curl_setopt($curl, CURLOPT_URL, $url);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);

    $result = curl_exec($curl);

    curl_close($curl);

    return $result;
}

?>