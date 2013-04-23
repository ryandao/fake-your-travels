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

  protected function postCurl($url, $data) {
    if (is_null($this->ch)) {
      $ch = curl_init();
      curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
      curl_setopt( $ch, CURLOPT_USERPWD, $this->username . ':' . $this->key );
      curl_setopt( $ch, CURLOPT_HEADER, 0 );
      curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
      $this->ch = $ch;
    }

    curl_setopt($this->ch, CURLOPT_URL, $url);
    curl_setopt($this->ch, CURLOPT_POST, 1);
    curl_setopt($this->ch, CURLOPT_POSTFIELDS, http_build_query($data));
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

  public function authUser($username, $pass) {
    $url = 'http://api.shutterstock.com/auth/customer';
    $data = array(
      'username' => $username,
      'password' => $pass
    );
    $ch = $this->postCurl($url, $data);
    $xmlStr = curl_exec($ch);
    $xml = new SimpleXMLElement($xmlStr);
    $authToken = $xml->body->div->dl->dd[0];
    return $authToken;
  }

  public function getSubscriptionId($authToken, $username) {
    $url = 'http://api.shutterstock.com/customers/' . $username . '/subscriptions?auth_token=' . $authToken;
    $ch = $this->getCurl($url);
    $xmlStr = curl_exec($ch);
    $xml = new SimpleXMLElement($xmlStr);
    $subscriptionId = $xml->body->div->dl->dd[8];
    return $subscriptionId;
  }

  public function getDownloadUrl($subscriptionId, $imageId, $authToken, $size, $format) {
    $url = 'http://api.shutterstock.com/subscriptions/' . $subscriptionId . '/images/' . $imageId . '/sizes/' . $size;
    $data = array(
      'auth_token' => $authToken,
      'format' => $format
    );
    $ch = $this->postCurl($url, $data);
    $xmlStr = curl_exec($ch);
    $xml = new SimpleXMLElement($xmlStr);
    $downloadUrl = $xml->body->div->dl->dd[1]->dl->dd->a;
    return $downloadUrl;
  }
}