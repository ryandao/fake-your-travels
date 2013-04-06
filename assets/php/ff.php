<?php

require_once "flashfoto.php";
require_once "ff.conf.php";


// for testing only
$_POST['method'] = 'get';
$_POST['url'] = 'https://www.filepicker.io/api/file/OGAgCDZESeqNDIAOCc8W';
$_POST['image_id'] = '178353';

function dispatch() {
  $method = $_POST['method'];

  switch ($method) {
    case "add":
      ff_add();
      break;
    case "get":
      ff_get();
      break;
    case "remove_bg":
      ff_remove_bg();
      break;
    default:
      break;
  }
}

function ff_add() {
  global $conf;
  $ff = new FlashFoto($conf['user'], $conf['key'], $conf['url']);

  $image_url = $_POST['url'];
  $response = $ff->add(file_get_contents($image_url));

  echo json_encode($response);
}

function ff_get() {
  global $conf;
  $ff = new FlashFoto($conf['user'], $conf['key'], $conf['url']);

  $image_id = $_POST['image_id'];
  $response = $ff->get($image_id, array('version' => "UniformBackgroundMasked"));

  // header()
  echo "<img src='data:image/png;base64," . base64_encode($response) . "'>";
  // echo base64_encode($response);
}

function ff_remove_bg() {
  global $conf;
  $ff = new FlashFoto($conf['user'], $conf['key'], $conf['url']);
  
  $image_id = $_POST['image_id'];
  $response = $ff->remove_uniform_background($image_id);

  echo json_encode($response);
}

dispatch();