function bg_proxy(url) {
  jQuery.post("assets/php/image-proxy.php", {link: url}, update_bg, "json");
}

function update_bg(data_json) {
  backgroundImg = "data:image/png;base64," + data_json;
  var image = new Image();
  image.onload = function() {
    setBackgroundImage(image, backgroundGroup);
  }
  image.src = backgroundImg;
  // refresh_canvas();
}

$(document).ready(function () {
  initStage({});

  $('#bg-selector form').submit(function() {
    var modal$ = $('#bg-modal .modal');
    var resultsDiv$ = $('#bg-modal .modal-body .results')
    var loadingMessage$ = $('#bg-modal .message');

    // Empty the modal body and show loading message
    resultsDiv$.empty();
    loadingMessage$.show();

    // Query the proxy server
    var searchQuery = $('#bg-selector input').val();
    $.ajax({
      url: '/fake-your-travels/images.php',
      data: { query: searchQuery },
      type: 'GET',
      success: function(results) {
        loadingMessage$.hide();
        for (var i = 0; i < results.images.length; i++) {
          var imgHtml = '<a href="#" id="' + i + '"><img src=' + results.images[i].thumbnail.url + ' class="st-bg-image"></a>';
          resultsDiv$.append(imgHtml);
        }

        $('a', resultsDiv$).click(function() {
          var id = parseInt($(this).attr('id'));
          window.backgroundImg = results.images[id].url;
          bg_proxy(backgroundImg);

          modal$.modal('hide');

        })
      }
    })

    modal$.modal();

    return false;
  })
})