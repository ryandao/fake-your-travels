<?php
  include('shutterstock.php');

  $api_username = "phd4";
  $api_key      = "ce077fbd895028ca877141ec8dbfc2a0a5b85736";
  $search_terms = $_GET['search_terms']; // Add your own security checks to cleanse this input

  $api          = new ShutterstockAPI($api_username, $api_key);
  $images       = $api->search($search_terms);

  $images_json = array('images' => array());
  if ($images) {
    for ( $i = 0; $i < 50; $i++ ) {
      $image = array();
      $description  = $images->results[$i]->description;
      $thumb_url    = $images->results[$i]->thumb_large->url;
      $thumb_width  = $images->results[$i]->thumb_large_width;
      $thumb_height = $images->results[$i]->thumb_large_height;
      $preview      = $images->results[$i]->preview;
      $photo_id     = $images->results[$i]->photo_id;

      $image['description']  = $description;
      $image['thumb_url']    = $thumb_url;
      $image['thumb_width']  = $thumb_width;
      $image['thumb_height'] = $thumb_height;
      $image['preview']      = $preview;
      $image['photo_id']     = $photo_id;

      array_push($images_json['images'], $image);
    }
  }

  header('Content-Type: application/json');
  echo json_encode($images_json);
?>