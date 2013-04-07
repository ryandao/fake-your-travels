<?php

$apikey = "a61e8e47ca83e86a2b8c705899ae9f6d";
$afid = 'hackathon';

$_POST['url'] = "https://services-qa.walgreens.com/api/util/v2.0/mweb5url";
$_POST['data'] = array(
                       "transaction" => "photoCheckoutv2",
                       "apiKey" => $apikey,
                       "devinf" => "Android,2.33",
                       "appver" => "0.1",
                       "act" => "genCredV2",
                       "view" => "genCredV2JSON",
                       "affId" => $afid,
                       "image" => array("https://www.dropbox.com/s/nokbnwstqywjfpt/walking-on-air-27l4gzc.jpeg")
                       );

$url = $_POST['url'];
$data = $_POST['data'];
var_dump($data);
$postdata = http_build_query($data);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/x-www-form-urlencoded',
        'content' => $postdata
    )
);
$context  = stream_context_create($opts);

$result = file_get_contents($url, false, $context);

echo $result;