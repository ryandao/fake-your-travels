<?php
  include('shutterstock.php');

  $api_username = "phd4";
  $api_key      = "ce077fbd895028ca877141ec8dbfc2a0a5b85736";

  if ($imgId = $_POST['image_id']) {
    $api = new ShutterstockAPI($api_username, $api_key);
    $imgUrl = $api->getDownloadUrl(
      '8102993',
      $imgId,
      '76cddca46f577aa17c5c311d2247abcbdfb7a56a',
      'medium',
      'jpg'
    );

    header('Content-Type: application/json');
    echo json_encode(array('url' => (string)$imgUrl));
  }
?>