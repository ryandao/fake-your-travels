$(document).ready(function () {
  $('#bg-selector form').submit(function() {
    var modal$ = $('#bg-modal .modal');

    // Query the proxy server
    var searchQuery = $('#bg-selector input').val();
    $.ajax({
      url: '/wish-you-were-here/shutterstock.php',
      data: { search_terms: searchQuery },
      type: 'GET',
      success: function(results) {
        // Empty the modal body
        var modalBody$ = $('#bg-modal .modal-body')
        modalBody$.empty();
        for (var i = 0; i < results.images.length; i++) {
          modalBody$.append('<img src=' + results.images[i].thumb_url + ' class="st-bg-image">')
          debugger
        }
      }
    })

    modal$.modal();

    return false;
  })
})