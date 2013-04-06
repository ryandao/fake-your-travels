$(document).ready(function () {
  $('#bg-selector form').submit(function() {
    var location = $('#bg-selector input').val();
    $('#bg-modal .modal').modal();

    return false;
  })
})