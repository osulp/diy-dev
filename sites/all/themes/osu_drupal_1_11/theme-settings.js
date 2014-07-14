$(document).ready( function() {
	
  //custom rotating header path
  custom_rotating_header_path_setting = $('#edit-osu-rotating-header-custom-location').attr('checked');
  swap_custom_rotating_header_path_inputs(custom_rotating_header_path_setting);	

  $('#edit-osu-rotating-header-custom-location').click(
		  function() {
			  custom_rotating_header_path_setting = $(this).attr('checked');
			  swap_custom_rotating_header_path_inputs(custom_rotating_header_path_setting);	
		  }
  )
    
  
  //Rotating header image 
  //Show correct inputs depending on saved type
  saved_setting = parseInt($('#edit-osu-rotating-header-type').attr('value'));
  swap_rotating_header_inputs(saved_setting, '');

  second_type_setting = $('#edit-osu-second-header-type').attr('value');
  swap_second_header_inputs(second_type_setting);
  

  //Swap the inputs depending on the type choice
  $('#edit-osu-rotating-header-type').change(
	function() {
		setting = parseInt($(this).attr('value'));
		swap_rotating_header_inputs(setting, '');
	}
  );
  
  $('#edit-osu-second-rotating-header-type').change(
	function() {
		setting = parseInt($(this).attr('value'));
		swap_rotating_header_inputs(setting, 'second-');
	}
  );
  
  //Swap the rotating header image for single image type
  $('#edit-osu-rotating-header-single-image').change(
	  function() {
	      show_file = $(this).attr('value');
		  current_path = $('#osu-rotating-header-image-preview').attr('src');
		  show_path = current_path.substring( 0, (current_path.lastIndexOf('/')+1) );
		  rotating_header_preview_src = show_path+show_file;
		  $('#osu-rotating-header-image-preview').attr('src', rotating_header_preview_src);		  
	  }
  )
  
  $('#edit-osu-second-rotating-header-single-image').change(
	  function() {
	      show_file = $(this).attr('value');
		  current_path = $('#osu-second-rotating-header-image-preview').attr('src');
		  show_path = current_path.substring( 0, (current_path.lastIndexOf('/')+1) );
		  rotating_header_preview_src = show_path+show_file;
		  $('#osu-second-rotating-header-image-preview').attr('src', rotating_header_preview_src);		  
	  }
  )
  $('#edit-osu-second-header-type').change(
	function() {
		setting = $(this).attr('value');
		swap_second_header_inputs(setting);
	}
  );
});

function swap_custom_rotating_header_path_inputs(setting) {
	if (setting == true) {
		$('#edit-osu-rotating-header-directory-wrapper').show();
	} else {
		$('#edit-osu-rotating-header-directory-wrapper').hide();
	}
}

function swap_second_header_inputs(setting) {
	if (setting == 'short'){
		$('#edit-osu-second-rotating-header-interval-wrapper').hide();
		$('#edit-osu-second-rotating-header-single-image-wrapper').hide();
		$('#osu-second-rotating-header-image-preview').hide();
		$('#edit-osu-second-rotating-header-type-wrapper').hide();
	}else{
		$('#edit-osu-second-rotating-header-type-wrapper').show();
		second_setting = parseInt($('#edit-osu-second-rotating-header-type').attr('value'));
		//alert(second_setting);
		swap_rotating_header_inputs(second_setting, 'second-');
	}
}

function swap_rotating_header_inputs(setting, second) {
	switch(setting) {
		//continuous rotation:
		case 0:
			$('#edit-osu-'+second+'rotating-header-interval-wrapper').show();
			$('#edit-osu-'+second+'rotating-header-single-image-wrapper').hide();
			$('#osu-'+second+'rotating-header-image-preview').hide();
			break;
		//random on load:
		case 1:
			//hide interval input
			$('#edit-osu-'+second+'rotating-header-interval-wrapper').hide();
			$('#edit-osu-'+second+'rotating-header-single-image-wrapper').hide();
			$('#osu-'+second+'rotating-header-image-preview').hide();
			break;
		//single image:
		case 2:
			$('#edit-osu-'+second+'rotating-header-interval-wrapper').hide();
			$('#edit-osu-'+second+'rotating-header-single-image-wrapper').show();
			$('#osu-'+second+'rotating-header-image-preview').show();
			break;
	}
}
