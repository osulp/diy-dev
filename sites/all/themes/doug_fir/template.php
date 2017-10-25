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
    drupal_add_css($path . '/css/less/main-responsive.css', $options);
  }

  // Include stylesheets for theme variants
  $variant = theme_get_setting('variant');

  if ($variant != 'doug_fir') {
    drupal_add_css($path . '/css/variants/' . $variant . '/' . $variant . '.css');
  }
}

function google_tracking_code() {
  return theme_get_setting('custom_ga_code') ? theme_get_setting('custom_ga_code') : 'UA-48705802-1';
}

function hide_book_nav() {
  // CSS to hide the book navigation
  $output = '';
  if (theme_get_setting('hide_book_nav')) {
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

/* Returns a new logo for Cascades or others */
function get_logo($logo_path) {
  $site_url = '//www.oregonstate.edu';
  $logo_name = 'logo';
  $site = theme_get_setting('site_logo');
  if ($site == 'Cascades') {
    $site_url = '//osucascades.edu/';
    $logo_name = 'osucascades';
  }
  return '<a href="'.$site_url.'"><img src="'.$logo_path.'/'.$logo_name.'.svg"  alt="Oregon State University '.$site.'"/></a>';
}


/**
 * Reads the theme settings and generates the HTML
 * to include stylesheets based on the settings
 */
function get_variant_classes() {
  // Stylesheets for color schemes

  $classes = ' ';
  $variant = theme_get_setting('variant');

  $classes .= theme_get_setting($variant . '_class');

  return $classes;
}

/**
 * Build site header based on various factors, Including: Organic Groups,
 * theme option for parent name, and other small things.
 */
function doug_fir_header_set_up($front_page, $node, $site_name, $title) {

  // Setting object to store the title and header information
  $headers = new stdClass();
  $headers->title = $title;

  if (function_exists('osu_groups_get_group_name') ) {
    $node = isset($node) ? $node : NULL;

    $group_name = osu_groups_get_group_name($node);
    if ($group_name) {
      // Set parent name and link to be 'site - unit'
      $unit_name = isset($group_name['parent_name']) ? $group_name['parent_name'] : '';
      $unit_path = isset($group_name['parent_path']) ? $group_name['parent_path'] : '';

      $parent = array(
        'url'       => $front_page,
        'name'      => $site_name,
        'unit_name' => $unit_name,
        'unit_path' => $front_page . $unit_path,
        );

      // Set site name and link to be the top-level group page
      $site_name   =  $group_name['title'];
      $front_page .= $group_name['path'];

      // Don't show node title for the top-level group page
      if ($title == check_plain($site_name)) {
        $headers->title = '';
      }
    }
  }

  // Test variable to check if site has parent_site_name setup in DougFir settings
  $test_parent = parent_site_name();
  if (empty($parent) && !empty($test_parent)) {
    $parent = parent_site_name();
    $parent['url'] = '//' . $parent['url'];
  }

  // Check for domains
  if (function_exists('domain_default')) {
    $domain = domain_default();
    $parent['url'] = $domain['scheme'] . '://' . $domain['subdomain'];
  }

  // Set the link header hierarchy
  $html = '';
  if (!empty($parent['url'])) {
    $html .= '<span class="group-header">';
    $html .= '<a class="parent" href=' . $parent['url'] . '> ';
    $html .= isset($parent['name']) ? $parent['name'] : '';
    $html .= '</a>';
    if (isset($parent['unit_name']) && !empty($parent['unit_name'])) {
      $html .= ' &raquo; <a class="parent" href=' . $parent['unit_path'] . '>' . $parent['unit_name'] . '</a>';
    }
    $html .= " &raquo; ";
  }

  $html .= '<h1><a href=' . $front_page . '>' . $site_name . '</a></h1>';

  if (!empty($parent)) {
    $html .= '</span>';
  }
  $headers->header = $html;

  return $headers;
}

/*
 * Creates a mobile menu based on available menus on page
 */
function doug_fir_mobile_menu() {
  $menu_name = 'main-menu';
  $book_menu= '';
  $depth = 8;
  // Check for a book menu first
  Global $base_url;
  if (function_exists('osu_groups_get_book_menu_name')) {
    if (osu_groups_get_book_menu_name()) {
      $menu_name = osu_groups_get_book_menu_name();
      $book_menu = "book-menu";
    }
  }
  // Hack for transportation site that is using a different menu type
  if ($base_url == 'http://transportation.oregonstate.edu' || $base_url == 'https://transportation.oregonstate.edu') {
    $menu_name = 'menu-transportation-parent-menu';
  }

  $audience_menu = menu_tree_all_data('audience-menu', '', 1);
  $main_menu = menu_tree_all_data($menu_name, '', $depth);
  $tophat_menu = menu_tree_all_data('osu-top-hat', '', 1);

  $menu = '';
  if ( !empty($audience_menu) || !empty($main_menu) || !empty($tophat_menu) ) {
    $menu .= '<ul id="mobile-menu" role="navigation">';
      if (!empty($main_menu) ) {
        $menu .= '<li id="mobile-main-menu" class="'.$book_menu.'">';
          $menu_tree = menu_tree_output($main_menu);
          $menu .= render($menu_tree);
        $menu .= '</li>';
      }
      if (!empty($audience_menu) ) {
        $menu .= '<li id="mobile-audience-menu">';
          $menu_tree = menu_tree_output($audience_menu);
          $menu .= render($menu_tree);
        $menu .= '</li>';
      }
      if (!empty($tophat_menu) ) {
        $menu .= '<li id="mobile-osu-top-hat">';
          $menu_tree = menu_tree_output($tophat_menu);
          $menu .= render($menu_tree);
        $menu .= '</li>';
      }
     $menu .= '</ul>';
    }

    return $menu;
}
/**
 * If social media links have been set by an admin user for this theme,
 * this function takes care of displaying them.
 * If adding or removing anything work with this and the theme-settings.php
 * file as well.
 **/
function doug_fir_social_media() {

  // These keys  in $social_media need to match those in theme-settings for the form creation
  $social_media = array(
    'facebook' => 'Facebook',
    'youtube-play' => 'YouTube',
    'flickr' => 'Flickr',
    'linkedin' => 'LinkedIn',
    'twitter' => 'Twitter',
    'google-plus' => 'Google+',
    'instagram' => 'Instagram',
  );

  $html = '';
  foreach ($social_media as $src => $name) {

    $link = theme_get_setting($src);
    if (!empty($link)) {
      $html .= '<a href="' . $link . '" title="Go to our ' . $name
        . ' page"><i class="icon-' . $src . '"></i> ' . $name . '</a>';
    }
  }
  return $html;
}

/**
 * @return string
 * Returns container or container-fluid based on selections.
 */
function doug_fir_full_screen() {
  $container = 'container';
  if ( (theme_get_setting('variant')== 'pine') && (theme_get_setting('full_screen') == true) ) {
   $container = 'container-fluid';
  }

  return $container;
}

/**
 * This function returns true or false depending on the tophat selection
 */
function doug_fir_top_hat() {
  if (function_exists('osu_top_hat_render') && !(theme_get_setting('new_top_hat'))) {
    return true;
  } else {
    return false;
  }
}

/**
 * Returns the rendered search if function present
 */
function doug_fir_search_overlay() {
  if(function_exists('osu_search_top_hat_form')) {
    $search_form = drupal_get_form('osu_search_top_hat_form');
    $search_overlay = render($search_form);
    return $search_overlay;
  }
}
