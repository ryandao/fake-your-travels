function bg_proxy(url) {
  jQuery.post("assets/php/image-proxy.php", {link: url}, update_bg, "json");
}

function update_bg(data_json) {
  backgroundImg = "data:image/png;base64," + data_json;
  refresh_canvas();
}

$(document).ready(function () {
  $('#bg-selector form').submit(function() {
    var modal$ = $('#bg-modal .modal');
    var resultsDiv$ = $('#bg-modal .modal-body .results')
    var loadingMessage$ = $('#bg-modal li.message');

    // Empty the modal body and show loading message
    resultsDiv$.empty();
    loadingMessage$.show();

    // Query the proxy server
    var searchQuery = $('#bg-selector input').val();
    $.ajax({
      url: '/wish-you-were-here/images.php',
      data: { search_terms: searchQuery },
      type: 'GET',
      success: function(results) {
        loadingMessage$.hide();
        for (var i = 0; i < results.images.length; i++) {
          var imgHtml = '<a href="#" id="' + i + '"><img src=' + results.images[i].thumb_url + ' class="st-bg-image"></a>';
          resultsDiv$.append(imgHtml);
        }

        $('a', resultsDiv$).click(function() {
          var id = parseInt($(this).attr('id'));
          window.backgroundImg = results.images[id].preview.url;
          if (typeof personImg != 'undefined') {
            bg_proxy(backgroundImg);
          }

          modal$.modal('hide');

        })
      }
    })

    modal$.modal();

    return false;
  })
})