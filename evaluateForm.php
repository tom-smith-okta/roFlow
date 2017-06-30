<?php

$json = file_get_contents("config.json");

$config = json_decode($json, TRUE);

$url = $config["oktaOrg"] . "/oauth2/v1/token";

$postFields["grant_type"] = "password";
$postFields["username"] = $_POST["username"];
$postFields["password"] = $_POST["password"];
$postFields["scope"] = "openid";

$postFields["client_id"] = $config["client_id"];
$postFields["client_secret"] = $config["client_secret"];

$fields_string = http_build_query($postFields);

$curl = curl_init();

curl_setopt_array($curl, array(
  CURLOPT_URL => $url,
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => "",
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 30,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_POSTFIELDS => $fields_string,

  CURLOPT_CUSTOMREQUEST => "POST",
  CURLOPT_HTTPHEADER => array(
    "accept: application/json",
    "cache-control: no-cache",
    "content-type: application/x-www-form-urlencoded",
  ),
));

$response = curl_exec($curl);
$err = curl_error($curl);

curl_close($curl);

if ($err) {
  echo "cURL Error #:" . $err;
} else {
  echo $response;
}