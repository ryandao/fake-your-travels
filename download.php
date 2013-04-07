<?php
  include('shutterstock.php');

  $api_username = "phd4";
  $api_key      = "ce077fbd895028ca877141ec8dbfc2a0a5b85736";

  if ($imgId = $_POST['image_id']) {
    $api = new ShutterstockAPI($api_username, $api_key);
    $imgUrl = $api->getDownloadUrl(
      '8102993',
      $imgId,
      '39410fbd01ae6e14af8721c4dddb8707dff87350',
      'medium',
      'jpg'
    );

    header('Content-Type: application/json');
    echo json_encode(array('url' => (string)$imgUrl));
  }
?>