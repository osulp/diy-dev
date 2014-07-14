(function ($) {
$(document).ready(function() {

  var col_height = Math.max($('#content').height(), $('#sidebar-first').height() );
  $('#content').css({'min-height' : col_height });
  $('.front #sidebar-second').css({'min-height' : col_height + 236 });

});
}(jQuery));