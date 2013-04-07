<?php
  include('shutterstock.php');

  $api_username = "phd4";
  $api_key      = "ce077fbd895028ca877141ec8dbfc2a0a5b85736";

  if ($imgId = $_POST['image_id']) {
    $api = new ShutterstockAPI($api_username, $api_key);
    $imgUrl = $api->getDownloadUrl(
      '8102993',
      $imgId,
      '6f1e7687d7d3b6234f240e0a1e7870af278a4d3a',
      'medium',
      'jpg'
    );

    header('Content-Type: application/json');
    echo json_encode(array('url' => (string)$imgUrl));
  }
?>