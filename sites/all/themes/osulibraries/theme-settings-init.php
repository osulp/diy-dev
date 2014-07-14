<?php
// $Id: theme-settings-init.php,v 1.1.2.2 2007/11/25 00:37:15 johnalbin Exp $

if (is_null(theme_get_setting('osulibraries_breadcrumb_trailing'))) {
  global $theme_key;
  // Save default theme settings
  $defaults = array(
    'osulibraries_breadcrumb' => 'yes',
    'osulibraries_breadcrumb_separator' => ' › ',
    'osulibraries_breadcrumb_home' => 1,
    'osulibraries_breadcrumb_trailing' => 1,
  );
  variable_set(
    str_replace('/', '_', 'theme_'. $theme_key .'_settings'),
    array_merge($defaults, theme_get_settings($theme_key))
  );
  // Force refresh of Drupal internals
  theme_get_setting('', TRUE);
}
