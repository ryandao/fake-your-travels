<?php

$apikey = "a61e8e47ca83e86a2b8c705899ae9f6d";
$afid = 'hackathon';

$url = "https://services-qa.walgreens.com/api/util/v2.0/mweb5url";
$data = array(
                       "transaction" => "photoCheckoutv2",
                       "apikey" => $apikey,
                       "devinf" => "Chrome,2.33",
                       "act" => "mweb5UrlV2",
                       "view" => "mweb5UrlV2JSON",
                       "affId" => $afid,
                       "expiryTime" => "04-20-2013 03:11:36",
                       "appver" => "0.1",
                       "images" => array($_POST['url']),
                       "lat" => "42.138199",
                       "lng" => "-87.945799",
                       "customer" => array(
                          "firstName" => "",
                          "lastName" => "",
                          "email" => "",
                          "phone" => ""
                        ),
                        "channelInfo" => "",
                        "callBackLink" => "",
                        "publisherId" => "0123456789",
                        "prodGroupId" => ""
                       );

$postdata = http_build_query($data);

$opts = array('http' =>
    array(
        'method'  => 'POST',
        'header'  => 'Content-type: application/json',
        'content' => json_encode($data)
    )
);
$context  = stream_context_create($opts);

$result = file_get_contents($url, false, $context);

echo $result;