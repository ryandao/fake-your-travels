$(document).ready(function () {
  initStage({});

  $('#bg-selector form').submit(function() {
    debugger
    var modal$ = $('#bg-modal .modal');
    var resultsDiv$ = $('#bg-modal .modal-body .results');
    var loadingMessage$ = $('#bg-modal .message');
    var loadMoreBtn$ = $('#load-more-btn');

    // Empty the modal body and show loading message
    resultsDiv$.empty();
    loadingMessage$.show();
    // Disable the Load more button while loading
    loadMoreBtn$.addClass('disabled');

    // Query the proxy server
    var searchQuery = $('#bg-selector input').val();
    $.ajax({
      url: 'images.php',
      data: { query: searchQuery },
      type: 'GET',
      success: function(results) {
        // Hide loading message and enable load more btn
        loadingMessage$.hide();
        loadMoreBtn$.removeClass('disabled');

        // Display the images
        addResultImagesToDiv(results.images, resultsDiv$)

        // Save the current search query and next search index
        window.currentSearch = searchQuery;
        window.startIndex = results.nextPage.startIndex;
      }
    })

    modal$.modal();

    return false;
  });

  $('#load-more-btn').click(function() {
    debugger
    var resultsDiv$ = $('#bg-modal .modal-body .results');

    // Show the loading spinner
    $('#load-more-btn .searching').show();

    $.ajax({
      url: 'images.php',
      data: { query: window.currentSearch, start: window.startIndex},
      type: 'GET',
      success: function(results) {
        // Hide the loading spinner
        $('#load-more-btn .searching').hide();

        // Display the images
        addResultImagesToDiv(results.images, resultsDiv$)

        // Update the next search index
        window.startIndex = results.nextPage.startIndex;
      }
    })
  });

  function addResultImagesToDiv(imageArr, resultsDiv) {
    for (var i = 0; i < imageArr.length; i++) {
      var imgDOM$ = $('<a href="#" id=' + i + '>').append('<img src=' + imageArr[i].thumbnail.url + ' class="st-bg-image"></a>');
      resultsDiv.append(imgDOM$);

      $(imgDOM$).click(function() {
        var id = parseInt($(this).attr('id'));
        window.backgroundImg = imageArr[id].url;
        bg_proxy(backgroundImg);

        $('#bg-modal .modal').modal('hide');

      });
    }
  }

  function bg_proxy(url) {
    jQuery.post("image-proxy.php", {link: url}, update_bg, "json");
  }

  function update_bg(data_json) {
    console.log(data_json);
    backgroundImg = "data:image/png;base64," + data_json;
    var image = new Image();
    image.onload = function() {
      setBackgroundImage(image, backgroundGroup);
    }
    image.src = backgroundImg;
  }
})