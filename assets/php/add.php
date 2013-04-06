<?php

include "flashfoto.php";

$base_url = "http://flashfotoapi.com/api/";
$username = "alexljz";
$apikey = "jDe8jrGkjzyd1JvN8ZOa7UCpjuscRQ8h";

$image_url = $_POST['url'];

$ff = new FlashFoto($username, $apikey, $base_url);