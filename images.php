<?php

include('google_custom_search.php');

$api_key = 'AIzaSyCSa7KMZCFCit1R3NHW45itRcc_tDv8MNY';
$cx = '005628824904312303925:vrivvhjelhi';

$api = new GoogleCustomSearch($api_key, $cx);
if ($query = $_GET['query']) {
  $start = 1;
  if (isset($_GET['start'])) {
    $start = $_GET['start'];
  }
  $results = $api->searchImages($query . ' scenery', null, $start);

  $images = array('images' => array());
  for ($i = 0; $i < count($results->items); $i++) {
    $image = array(
      'url' => $results->items[$i]->link,
      'height' => $results->items[$i]->image->height,
      'width' => $results->items[$i]->image->width,
      'thumbnail' => array(
        'url' => $results->items[$i]->image->thumbnailLink,
        'height' => $results->items[$i]->image->thumbnailHeight,
        'width' => $results->items[$i]->image->thumbnailWidth
      ),
      'nextPage' => array(
        'startIndex' => $results->queries->nextPage[0]->startIndex
      )
    );
    array_push($images['images'], $image);
  }
  $images['nextPage'] = array('startIndex' => $results->queries->nextPage[0]->startIndex);

  header('Content-Type: application/json');
  echo json_encode($images);
}
