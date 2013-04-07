var apikey = "a61e8e47ca83e86a2b8c705899ae9f6d";
var afid = 'hackathon';

var host = "https://services-qa.walgreens.com/";
var basepath = "api/util/v2.0/mweb5url";

var landing_data = {
  "serviceType": "wags3",
  "act": "genCredV2",
  "view": "genCredV2JSON",
  "affId": afid,
  "apiKey": apikey,
  "devinf": "Android,2.33",
  "appver": "0.1"
}

function wg_creds() {
  jQuery.post("assets/php/wg.php", {url: host + basepath, data: landing_data}, bleagh, "json");
}

function bleagh(data) {
  console.log(data);
}

$(document).ready(function() {
  $('#wg_btn').click(function() {
    wg_creds();
  })
});