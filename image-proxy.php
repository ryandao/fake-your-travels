<?php

$image_url = $_POST['link'];

echo json_encode(base64_encode(file_get_contents($image_url)));