<?php

function osu_drupal_1_11_get_rotating_header_path() {
	global $theme_key;

	//If theme_key is not set, we need to get the theme path another way:
	$theme_path = drupal_get_path('theme', $theme_key);
	if (empty($theme_path)) {
		$theme_path = path_to_theme();
	}
	
	
	$use_custom_path = theme_get_setting('osu_rotating_header_custom_location');
	
	if ($use_custom_path) {
		$image_path = theme_get_setting('osu_rotating_header_directory');
		
		//check string does not start with a slash
		if (substr($image_path, 0, 1) == '/')
			$image_path = substr($image_path, 1);
		
			//check string ends with a slash
		if (substr($image_path, strlen($image_path) - 1, 1) != '/')
			$image_path .= '/';
			
		$osu_rotating_header_path = array(
			'abs' => realpath('.').'/'.file_directory_path().'/'.$image_path,
			'rel' => base_path().file_directory_path().'/'.$image_path
		) ;
		
		osu_drupal_1_11_check_custom_header_images_path($osu_rotating_header_path['abs'], $theme_path);
	} else {
		$osu_rotating_header_path = array(
			'abs' => realpath('.').'/'.$theme_path.'/images/rotating_headers/',
			'rel' => str_replace('//', '/', base_path().'/'.$theme_path.'/images/rotating_headers/')
		);
	}
	
	return $osu_rotating_header_path;
}

function osu_drupal_1_11_check_custom_header_images_path($custom_path, $theme_path) {
	if(!empty($custom_path)) {
		if (!is_dir($custom_path)) {
			mkdir($custom_path, 0775, true);
			$files_to_copy = glob(realpath('.').'/'.$theme_path.'/images/rotating_headers/*');
			foreach ($files_to_copy as $file_to_copy) {
				copy($file_to_copy, $custom_path.basename($file_to_copy));
			}
		}
	}
}

?>
