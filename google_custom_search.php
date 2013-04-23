<?php

class GoogleCustomSearch {
  protected $ch;
  protected $api_key;
  protected $cx;

  public function __construct($api_key, $cx) {
    $this->api_key = $api_key;
    $this->cx = $cx;
  }

  protected function getCurl($url) {
    if (is_null($this->ch)) {
      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
      curl_setopt( $ch, CURLOPT_HEADER, 0 );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
      $this->ch = $ch;
    }
    curl_setopt( $this->ch, CURLOPT_URL, $url );
    return $this->ch;
  }

  public function searchImages($query, $size = 'xlarge', $start = 1) {
    $queryStr = http_build_query(array(
      'key' => $this->api_key,
      'cx' => $this->cx,
      'q' => $query,
      'searchType' => 'image',
      'imgSize' => $size,
      'start' => $start
    ));
    $url = 'https://www.googleapis.com/customsearch/v1?' . $queryStr;
    $ch = $this->getCurl($url);
    $json = curl_exec($ch);
    return json_decode($json);
  }
}