function ff_add(image_url) {
  var data = { method: 'add', url: image_url };

  ff_post(data, ff_remove_bg);
}

function ff_get(image_json) {
  var data = { method: 'get', image_id: image_json.Image.id };

  ff_post(data, display_result);
}

function ff_remove_bg(image_json) {
  var data = { method: 'remove_bg', image_id: image_json.Image.id };

  ff_post(data, display_result);
}

function display_result(image_json) {

}

function ff_post(data, callback) {
  var base_url = "assets/php/ff.php/";
  jQuery.post(base_url, data, callback, "json");
}

$(document).ready(function() {
  filepicker.setKey('AhyWohKMSG6uimWcifzE1z');
});