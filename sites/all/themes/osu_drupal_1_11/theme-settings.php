<?php
// $Id: theme-settings.php,v 1.7 2008/09/11 09:36:50 johnalbin Exp $

//include_once './' . drupal_get_path('theme', 'osu_drupal_1_11') . '/template.php';

// Include the definition of zen_settings() and zen_theme_get_default_settings().
include_once './' . drupal_get_path('theme', 'zen') . '/theme-settings.php';

include_once './' . drupal_get_path('theme', 'osu_drupal_1_11') . '/template.theme-registry.inc';

/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array.
 */
function osu_drupal_1_11_settings($saved_settings) {
	
	// Get the default values from the .info file.
	$defaults = zen_theme_get_default_settings('osu_drupal_1_11');
  
	//Add javascript to show/hide optional settings
	drupal_add_js(drupal_get_path('theme', 'osu_drupal_1_11') . '/theme-settings.js', 'theme');

	
	// Merge the saved variables and their default values.
	$settings = array_merge($defaults, $saved_settings);

	
	$osu_rotating_header_path = osu_drupal_1_11_get_rotating_header_path();
	
	$form = array();

	// Add the base theme's settings.
	$form += zen_settings($saved_settings, $defaults);

    $form['breadcrumb']['zen_breadcrumb_title'] = array(
        '#suffix'        => '' // removing #div-zen-breadcrumb
    );
    $form['breadcrumb']['osu_breadcrumb_first'] = array(
		'#title' => t('Text in First Breadcrumb'),
		'#type' => 'textfield',
		'#default_value' => $settings['osu_breadcrumb_first'],
		'#description' => 'Enter the text or name to use for the first breadcrumb',
        '#size'         => '40',
        '#maxlength'    => '500'
    );
    $form['breadcrumb']['osu_breadcrumb_prefix'] = array(
		'#title' => t('Breadcrumb Prefix Text'),
		'#type' => 'textfield',
		'#default_value' => $settings['osu_breadcrumb_prefix'],
		'#description' => 'Enter the text or html to display before the breadcrumbs',
        '#suffix'        => '</div>', // #div-zen-breadcrumb
        '#size'         => '40',
        '#maxlength'    => '500'
    );

	$form['osu_start_fieldset_0'] = array(
		'#value' => '<fieldset><legend>Rotating Header Image Directory</legend>'
	);
	
	$form['osu_rotating_header_custom_location'] = array(
		'#title' => 'Use a custom rotating header location?',
		'#type' => 'checkbox',
		'#default_value' => $settings['osu_rotating_header_custom_location']
	);
	
	$form['osu_rotating_header_directory'] = array(
		'#title' => t('Rotating header images directory'),
		'#type' => 'textfield',
		'#default_value' => $settings['osu_rotating_header_directory'],
		'#description' => 'Enter the path to your rotating header images (relative to sites/default/files/)'
	);
	
	$form['osu_end_fieldset_0'] = array(
		'#value' => '</fieldset>'
	);		
	
	//rotating-image settings:
	$form['osu_start_fieldset_1'] = array(
		'#value' => '<fieldset><legend>Front Page Header Image</legend>'
	);
	
	$themes = list_themes();
	$info_rotating_header_types = $themes['osu_drupal_1_11']->info['osu_rotating_header_types'];
	//var_dump($info_rotating_header_types);
	//set up the array for select box values
	if (!empty($info_rotating_header_types)) {
		$i = 0;
		foreach ($info_rotating_header_types as $rotating_header_type) {
			$rotating_header_types[$i++] = t($rotating_header_type);
		}
	}
	
	$form['osu_rotating_header_type'] = array(
		'#title' 		 => t('Rotating Header Type'),
		'#type'  		 => 'select',
		'#description'	 => t('Select the way you wish your header images to rotate'),
		'#default_value' => $settings['osu_rotating_header_type'],
		'#options' 		 => $rotating_header_types
	);
	
	//input for rotating interval
	$form['osu_rotating_header_interval'] = array(
		'#title' => t('Rotating Header Interval'),
		'#type' => 'textfield',
		'#size' => '3',
		'#default_value' => $settings['osu_rotating_header_interval'],
		'#description' => 'Enter the time <strong>in seconds</strong> between each transition'
	);
		
	
	//select for 'single image' rotation type
	$available_images = glob($osu_rotating_header_path['abs'].'*');
	//set up the array for select box values
	if (!empty($available_images)) {
		foreach($available_images as $available_image) {
			$rotating_images[t(basename($available_image))] = t(basename($available_image));
		}
	} else {
		$rotating_images = array();
	}
	$form['osu_rotating_header_single_image'] = array(
		'#title' => t('Select header image'),
		'#type'  => 'select',
		'#description' => 'Select the image you want to appear in the header',
		'#default_value' => $settings['osu_rotating_header_single_image'],
		'#options' => $rotating_images
	);
	
	//header image preview:
	$form['osu_rotating_header_image_preview'] = array(
  		'#value' => '<img id="osu-rotating-header-image-preview" src="'.$osu_rotating_header_path['rel'].$settings['osu_rotating_header_single_image'].'" />'
	);
	
	$form['osu_end_fieldset_1'] = array(
		'#value' => '</fieldset>'
	);
	

	//Secondary Page headers, reuses form elements for front pages and sets sepear
	
	$form['osu_start_fieldset_2'] = array(
		'#value' => '<fieldset><legend>Secondary Page Header Image</legend>'
	);
	
	
	$info_second_header_types = $themes['osu_drupal_1_11']->info['osu_second_header_types'];	
	$form['osu_second_header_type'] = array(
		'#title' 		 => t('Secondary Page Header Type'),
		'#type'  		 => 'select',
		'#description'	 => t('Choose either a short header or a taller header with graphics'),
		'#default_value' => $settings['osu_second_header_type'],
		'#options' 		 => $info_second_header_types
	);
	
	$form['osu_second_rotating_header_type'] = $form['osu_rotating_header_type'];
	$form['osu_second_rotating_header_type']['#default_value'] =  $settings['osu_second_rotating_header_type'];
	
	//input for rotating interval
	$form['osu_second_rotating_header_interval'] = $form['osu_rotating_header_interval'];
	$form['osu_second_rotating_header_interval']['#default_value'] = $settings['osu_second_rotating_header_interval'];
	
	$form['osu_second_rotating_header_single_image'] = $form['osu_rotating_header_single_image'];
	$form['osu_second_rotating_header_single_image']['#default_value'] = $settings['osu_second_rotating_header_single_image'];
	
	//header image preview:
	$form['osu_second_rotating_header_image_preview'] = array(
  		'#value' => '<img id="osu-second-rotating-header-image-preview" src="'.$osu_rotating_header_path['rel'].$settings['osu_second_rotating_header_single_image'].'" />'
	);
	
	$form['osu_end_fieldset_2'] = array(
		'#value' => '</fieldset>'
	);	
	
	// Remove some of the base theme's settings.
	unset($form['themedev']['zen_layout']); // We don't need to select the base stylesheet.
	
	// Return the form
	return $form;
}
