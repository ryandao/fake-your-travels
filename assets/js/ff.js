function ff_add(image_url) {
  var data = { method: 'add', url: image_url };

  ff_post(data, ff_remove_bg);
}

function ff_get(image_json) {
  if (image_json.status == "success") {
    var data = { method: 'get', image_id: g_image_id };
    ff_post(data, display_image);
  }
}

function ff_remove_bg(image_json) {
  g_image_id = image_json.Image.id;
  var data = { method: 'remove_bg', image_id: g_image_id };

  ff_post(data, ff_get);
}

function display_image(image_data) {
  $('#person').attr('src', 'data:image/png;base64,' + image_data);
  window.personImg = $('#person').attr('src')

  if (typeof backgroundImg != 'undefined') {
    loadImages({
      person: personImg,
      background: backgroundImg
    }, initStage)
  }
}

function ff_post(data, callback) {
  var base_url = "assets/php/ff.php/";
  jQuery.post(base_url, data, callback, "json");
}

var featherEditor = new Aviary.Feather({
  apiKey: '1234567',
  apiVersion: 2,
  tools: ['draw', 'stickers'],
  onSave: function(imageID, newURL) {
    var img = document.getElementById(imageID);
    img.src = newURL;
    var sources = {
      darthVader: $('#person').attr('src'),
      yoda: 'http://www.html5canvastutorials.com/demos/assets/yoda.jpg'
    };
    loadImages(sources, initStage);
  }
});

function launchEditor(id, src) {
  featherEditor.launch({
    image: id,
    url: src
  });
  return false;
}

$(document).ready(function() {
  filepicker.setKey('AhyWohKMSG6uimWcifzE1z');
  $('.photo').click(function() {
    launchEditor($(this).attr('id'), $(this).attr('src'));
  })

  $('#person_filepicker').change(function() {
    var out = '';
    for(var i = 0; i < event.fpfiles.length; i++) {
      out += event.fpfiles[i].url;
      out += ' ';
    }
    ff_add(out);
  });
});