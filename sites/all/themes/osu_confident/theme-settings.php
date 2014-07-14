<?php
// $Id: theme-settings.php,v 1.7 2008/09/11 09:36:50 johnalbin Exp $
global $theme_info;

// Include the definition of zen_settings() and zen_theme_get_default_settings().
include_once './' . drupal_get_path('theme', 'zen') . '/theme-settings.php';

// Include the definition of osu_drupal_settings()
include_once './' . drupal_get_path('theme', 'osu_drupal_1_11') . '/theme-settings.php';


/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @return
 *   A form array.
 */
function osu_confident_settings($saved_settings) {

  // Get the default values from the .info file.
  $defaults = zen_theme_get_default_settings('osu_confident');

  // Merge the saved variables and their default values.
  $settings = array_merge($defaults, $saved_settings);

  /*
   * Create the form using Forms API: http://api.drupal.org/api/6
   */
  $form = array();
	
  $themes = list_themes();
	
  $stylesheets = $themes['osu_confident']->info['styles'];
	
  if (!empty($stylesheets)) {
    $styles = array();
    foreach ($stylesheets as $title => $file) {
      $styles[$file['file']] = t($file['title']);
    }
  }

	//set up the array for select box values
	$info_background_colors = $themes['osu_confident']->info['osu_confident_background_colors'];
	if (!empty($info_background_colors)) {
		foreach ($info_background_colors as $background_color) {
			$background_colors[$background_color] = t($background_color);
		}
	}

    $form['osu_confident_hide_site_name'] = array(
        '#title'         => t('Hide site name'),
        '#type'          => 'checkbox',
        '#description'   => t('Prevent the site name from displaying in the header section'),
        '#default_value' => $settings['osu_confident_hide_site_name'],
    );

	$form['osu_confident_color_scheme'] = array(
		'#title'         => t('Color Scheme'),
		'#type'          => 'select',
		'#description'   => t("Color Scheme for OSU Confident theme"),
		'#default_value' => $settings['osu_confident_color_scheme'],
		'#options'       => $styles
	);
	
	$form['osu_confident_background_color'] = array(
		'#title'         => t('Background Color'),
		'#type'          => 'select',
		'#description'   => t("Color for the background"),
		'#default_value' => $settings['osu_confident_background_color'],
		'#options'       => $background_colors
	);
	
  // Add the osu_drupal header options
  $form += osu_drupal_1_11_settings($settings);

  // Remove some of the base theme's settings.
  //unset($form['themedev']['zen_layout']); // We don't need to select the base stylesheet.

  // Return the form
  return $form;
}
?>
