<?php
/**
 * @file - template.php
 *
 * Theme helper functions
 */

/**
 * Add an html class for theme variants
 *
 */
function doug_fir_get_html_classes() {
  $variant = theme_get_setting('variant');
  $variant = $variant == 'default' ? '' : $variant;
  return $variant;
}

/**
 * Implements hook_preprocess_html()
 *
 * Load stylesheets for theme variants
 *
 */
function doug_fir_preprocess_html(&$variables) {

  $path = drupal_get_path('theme', 'doug_fir');

  // Include responsive stylesheets
  if (theme_get_setting('responsive')) {
    // Need these options to get these stylesheets to load last
    $options = array(
      'group'  =>  CSS_THEME,
      'weight' => 500,
    );
    drupal_add_css($path . '/bootstrap/css/responsive.css', $options );
    drupal_add_css($path . '/css/main-responsive.css', $options);
  }

  // Include stylesheets for theme variants
  $variant = theme_get_setting('variant');
  switch ($variant) {
    case 'classic' :
      drupal_add_css($path . '/css/variants/classic/classic.css');
      break;
    case 'marine' :
      drupal_add_css($path . '/css/variants/marine/marine.css');
      break;
    case 'science' :
      drupal_add_css($path . '/css/variants/science/science.css');
      break;
    case 'honors' :
      drupal_add_css($path . '/css/variants/honors/honors.css');
      break;
    case 'default' :
      break;
  }
}

function google_tracking_code() {
 return theme_get_setting('custom_ga_code') ? theme_get_setting('custom_ga_code') : 'UA-4834799-1';
}

function hide_book_nav() {
  // CSS to hide the book navigation
  $output = '';
  if (theme_get_setting('hide_book_nav')){
    $output = "<style type='text/css'> div.book-navigation { display: none;} </style>\n";
  }
  return $output;
}

function hide_terms() {
  // Hide the taxonomy tems
  $output = '';
  if (theme_get_setting('hide_terms')) {
    $output = "<style type='text/css'> div.terms { display: none;} </style>\n";
  }
  return $output;
}

function parent_site_name() {
  $name =  theme_get_setting('parent_site_name');
  $url  =  theme_get_setting('parent_site_url');
  if (!empty($name)) {
    return array('name' => $name, 'url' => $url);
  }
}

/**
 * If social media links have been set by an admin user for this theme,
 * this function takes care of displaying them.
 * If adding or removing anything work with this and the theme-settings.php
 * file as well.
 **/
function doug_fir_social_media() {

  // These values in $social_media need to match those in theme-settings
  // for the form creation
  $social_media = array(
      'facebook',
      'youtube',
      'flickr',
      'linkedin',
      'twitter',
      'google'
      );

  // Handles irregular names - like YouTube instead of Youtube for example.
  $name_exceptions = array(
      'linkedin'=>'LinkedIn',
      'youtube' => 'YouTube',
      'google'  => 'Google+',
      );
  $html = '';
  foreach ($social_media as $value) {
    //$name = substr($value, $theme_name_length);
    if (!isset($name_exceptions[$value])) {
      $full_name = ucfirst($value);
    } else {
      $full_name = $name_exceptions[$value];
    }

    // Gets the value in the database - currently users are asked to input a
    // link to their social media page
    $link = theme_get_setting($value);
    if (!empty($link)) {
      $html .= '<a href="' . $link . '" title="Go to our ' . $full_name
        . ' page"><img src="http://oregonstate.edu/main/sites/default/files/'
        . $value . '.png" alt="' . $full_name . ' logo" />' . $full_name . '</a>';
    }
  }
  return $html;
}

function doug_fir_biblio_entry(&$variables) {
  dpm($variables);
}

