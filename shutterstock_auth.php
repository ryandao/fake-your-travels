<?php

include('shutterstock.php');

$api_username = "phd4";
$api_key      = "ce077fbd895028ca877141ec8dbfc2a0a5b85736";
$username     = "ryandao";
$password     = "asdfasdf";

$api = new ShutterstockAPI($api_username, $api_key);
$authToken = $api->authUser($username, $password);
print($authToken);
