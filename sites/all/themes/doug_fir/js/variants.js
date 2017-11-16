/**
 * JavaScript functions for Doug Fir variants
 *
 */
(function ($) {

  Drupal.behaviors.doug_fir = {
    attach: function(context, settings) {
    
      // Hide the variants that are not selected on initial load
      var option  = $('#edit-variant').val();
      for (var variant in settings.doug_fir_variants) {        
        if (option != variant) {
          $('.form-item-' + variant + '-class').hide();
        } else {
          var option2 = $('#edit-'+ variant +'-class').val();
          var bg_image = settings.doug_fir_bg[option2];
          $('.form-item-'+ variant +'-class').css('background', 'url('+bg_image+' )');
        }
      }

      // Show or hide the selected variant settings when a selection is made
      $('#edit-variant').change( function() {
        var option  = $('#edit-variant').val();
        for (var variant in settings.doug_fir_variants) {        
          if (option == variant) {
            $('.form-item-' + variant + '-class').show();
          }
          else {
           $('.form-item-' + variant + '-class').hide();
          }
        }
      });
      
      // Sets the background image for the variant background select box
      var cur_variant  = $('#edit-variant').val();
      $('#edit-'+cur_variant+'-class').change( function() {
        var option3 = $('#edit-'+cur_variant+'-class').val();
        var bg_image = settings.doug_fir_bg[option3]; 
        //$('.form-item-'+cur_variant+'-class').addClass(option3);
        $('.form-item-'+cur_variant+'-class').css('background', 'url('+bg_image+' )');        
      });

    }
  }

}(jQuery));