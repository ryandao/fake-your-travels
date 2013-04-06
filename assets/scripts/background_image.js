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
      url: '/wish-you-were-here/shutterstock.php',
      data: { search_terms: searchQuery },
      type: 'GET',
      success: function(results) {
        loadingMessage$.hide();
        for (var i = 0; i < results.images.length; i++) {
          resultsDiv$.append('<img src=' + results.images[i].thumb_url + ' class="st-bg-image">')
        }
      }
    })

    modal$.modal();

    return false;
  })
})