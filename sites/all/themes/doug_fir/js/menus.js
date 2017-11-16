/* Toggles the Menu if it's hidden */
(function ($) {
$(document).ready(function() {

  $("#mobile-osu-top-hat a:eq(0)").prepend('<i class="icon-calendar"></i><br />');
  $("#mobile-osu-top-hat a:eq(1)").prepend('<i class="icon-book"></i><br />');
  $("#mobile-osu-top-hat a:eq(2)").prepend('<i class="icon-map-marker"></i><br />');
  $("#mobile-osu-top-hat a:eq(3)").prepend('<i class="icon-cogs"></i><br />');
  $("#mobile-osu-top-hat a:eq(4)").prepend('<i class="icon-gift"></i><br />');

  // Adds chevron right to all menu parents on mobile menu
  $("#mobile-main-menu .menu > .expanded > a").after('<i class="icon-chevron-right"></i>');


  $("#toggle-mobile-menu").click(function() {
    
    if ($("#mobile-menu").is(":hidden")) {
      $("#mobile-menu").show("slow");
      
    } else {
      $("#mobile-menu").slideUp();
    }
  });

  //Expands and collapses mobile menu as you tap on items
  $("#mobile-main-menu .menu > .expanded").click(function(e) {
    // prevents event from going to all the items (limit to just the one below)
    e.stopPropagation();
    $(this).children('i').first().toggleClass("icon-chevron-right icon-chevron-down");
    $(this).children('ul').first().slideToggle("slow");
  });

  /* New top hat search overlay */
  $("#search-link").click(function(event) {
    event.preventDefault();
    if ($("#search-overlay").is(":hidden")) {
      $("#search-overlay").slideDown();
      $("#search-overlay .search-terms").focus();

    } else {
      $("#search-overlay").slideUp();
    }
  });

  $("#search-overlay .exit-search").click(function() {
    $("#search-overlay").slideUp();
  });


});
}(jQuery));