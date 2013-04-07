function wg_post() {
  jQuery.post("assets/php/wg.php", {url: $('#preview').attr('src')}, wg_checkout, "json");
}

function wg_checkout(data) {
  var url = data.landingUrl;
  var token = data.token;

  open_in_new_tab(url + "&" + token);
}

function open_in_new_tab(url )
{
  var win=window.open(url, '_blank');
  win.focus();
}

$(document).ready(function() {
  $('#wg_btn').click(function() {
    wg_post();
  });
});