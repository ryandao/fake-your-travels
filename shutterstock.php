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
  echo("<pre>");
  var_dump($images);
  echo("</pre>");

  if ($images) {
    for ( $i = 0; $i < 3; $i++ ) {
      $description  = $images->results[$i]->description;
      $thumb        = $images->results[$i]->thumb_large->url;
      $thumb_width  = $images->results[$i]->thumb_large_width;
      $thumb_height = $images->results[$i]->thumb_large_height;
      echo '<div style="display:inline-block;width:' . $thumb_width . 'px; height:' . $thumb_height . 'px; overflow:hidden;">';
      echo '<img src="' . $thumb . '" alt="' . $description . '">' . "\n\n";
      echo '</div>';
      echo '<textarea rows="10" cols="80">' . "\n";
      var_dump($images->results[$i]);
      echo "</textarea><br><hr>\n\n";
    }
  }
?>