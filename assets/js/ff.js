function ff_add(image_url) {
  console.log(image_url);
  var data = { method: 'add', url: image_url };

  ff_post(data, ff_remove_bg);
}

function ff_get(image_json) {
  console.log(image_json);
  if (image_json.status == "success") {
    var data = { method: 'get', image_id: g_image_id };
    ff_post(data, display_image);
  }
}

function ff_remove_bg(image_json) {
  console.log(image_json);
  g_image_id = image_json.Image.id;
  var data = { method: 'remove_bg', image_id: g_image_id };

  ff_post(data, ff_get);
}

function display_image(image_data) {
  console.log('here');
  console.log(image_data);
  $('#photo').attr('src', 'data:image/png;base64,' + image_data);
}

function ff_post(data, callback) {
  console.log(data);
  var base_url = "assets/php/ff.php/";
  jQuery.post(base_url, data, callback, "json");
}

$(document).ready(function() {
  filepicker.setKey('AhyWohKMSG6uimWcifzE1z');
});