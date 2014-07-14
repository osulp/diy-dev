<?php
// $Id: theme-settings.php,v 1.1.2.2 2007/11/25 00:37:15 johnalbin Exp $

/**
 * Implementation of THEMEHOOK_settings() function.
 *
 * @param $saved_settings
 *   An array of saved settings for this theme.
 * @param $subtheme_defaults
 *   Allow a subtheme to override the default values.
 * @return
 *   A form array.
 */
function osulibraries_settings($saved_settings, $subtheme_defaults = array()) {

  // Add javascript to show/hide optional settings
  drupal_add_js(path_to_theme().'/theme-settings.js', 'theme');

  // The default values for the theme variables
  $defaults = array(
    'osulibraries_breadcrumb' => 'yes',
    'osulibraries_breadcrumb_separator' => ' › ',
    'osulibraries_breadcrumb_home' => 0,
    'osulibraries_breadcrumb_trailing' => 1,
  );
  $defaults = array_merge($defaults, $subtheme_defaults);

  // Merge the saved variables and their default values
  $settings = array_merge($defaults, $saved_settings);

  /*
   * Create the form using Form API
   */
  $form['breadcrumb'] = array(
    '#type'          => 'fieldset',
    '#title'         => t('Breadcrumb settings'),
  );
  $form['breadcrumb']['osulibraries_breadcrumb'] = array(
    '#type'          => 'select',
    '#title'         => t('Display breadcrumb'),
    '#default_value' => $settings['osulibraries_breadcrumb'],
    '#options'       => array(
                          'yes'   => 'Yes',
                          'admin' => 'Only in admin section',
                          'no'    => 'No',
                        ),
  );
  $form['breadcrumb']['osulibraries_breadcrumb_separator'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Breadcrumb separator'),
    '#description'   => 'Text only. Don’t forget to include spaces.',
    '#default_value' => $settings['osulibraries_breadcrumb_separator'],
    '#size'          => 5,
    '#maxlength'     => 10,
    '#prefix'        => '<div id="div-osulibraries-breadcrumb">', // jquery hook to show/hide optional widgets
  );
  $form['breadcrumb']['osulibraries_breadcrumb_home'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Show home page link in breadcrumb'),
    '#default_value' => $settings['osulibraries_breadcrumb_home'],
  );
  $form['breadcrumb']['osulibraries_breadcrumb_trailing'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Append a separator to the end of the breadcrumb'),
    '#default_value' => $settings['osulibraries_breadcrumb_trailing'],
    '#description'   => 'Useful when the breadcrumb is placed just before the title.',
    '#suffix'        => '</div>', // #div-osulibraries-breadcrumb
  );

  // Return the form
  return $form;
}
