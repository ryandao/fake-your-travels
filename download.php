<?php
  include('shutterstock.php');

  $api_username = "phd4";
  $api_key      = "ce077fbd895028ca877141ec8dbfc2a0a5b85736";

  if ($imgId = $_GET['image_id']) {
    $api = new ShutterstockAPI($api_username, $api_key);
    $imgUrl = $api->getDownloadUrl(
      '8102993',
      $imgId,
      'e3850e6fbcf942d39cf036e1b028196ee2b86188',
      'medium',
      'jpg'
    );

    header('Content-Type: application/json');
    echo json_encode(array('url' => (string)$imgUrl));
  }
?>