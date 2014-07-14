$(document).ready( function() {
  // Breadcrumb
  $('#edit-osulibraries-breadcrumb').change(
    function() {
      div = $('#div-osulibraries-breadcrumb');
      if ($('#edit-osulibraries-breadcrumb').val() == 'no') {
        div.slideUp('slow');
      } else if (div.css('display') == 'none') {
        div.slideDown('slow');
      }
    }
  );
  if ($('#edit-osulibraries-breadcrumb').val() == 'no') {
    $('#div-osulibraries-breadcrumb').css('display', 'none');
  }
} );
