function remove_background(image) {
  console.log(image);
}

function ff_add(image_url) {
  var add_url = "assets/php/add.php/";
  var method_name = 'add';
  jQuery.post(add_url, {method: method_name, url: image_url}, remove_background, "json");
}

function utf8_to_b64( str ) {
    return window.btoa(unescape(encodeURIComponent( str )));
}

$(document).ready(function() {
  filepicker.setKey('AhyWohKMSG6uimWcifzE1z');
});