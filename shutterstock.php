<?php
  class ShutterstockAPI {

    protected $ch;
    protected $username;
    protected $key;

    public function __construct($username, $key) {
      $this->username = $username;
      $this->key      = $key;
    }

    protected function getCurl($url) {
      if (is_null($this->ch)) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
        curl_setopt( $ch, CURLOPT_USERPWD, $this->username . ':' . $this->key );
        curl_setopt( $ch, CURLOPT_HEADER, 0 );
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $this->ch = $ch;
      }
      curl_setopt( $this->ch, CURLOPT_URL, $url );
      return $this->ch;
    }

    public function search($search_terms, $type='images') {
      $search_terms_for_url = preg_replace('/ /', '+', $search_terms);
      $url                  = 'http://api.shutterstock.com/' . $type . '/search.json?searchterm=' . $search_terms_for_url;
      $username             = $this->username;
      $key                  = $this->key;
      $ch                   = $this->getCurl( $url );
      $json                 = curl_exec( $ch );
      return json_decode( $json );
    }
  }

  $api_username = "phd4";
  $api_key      = "ce077fbd895028ca877141ec8dbfc2a0a5b85736";
  $search_terms = $_GET['search_terms']; // Add your own security checks to cleanse this input

  $api          = new ShutterstockAPI($api_username, $api_key);
  $images       = $api->search($search_terms);
  // echo("<pre>");
  // var_dump($images);
  // echo("</pre>");

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