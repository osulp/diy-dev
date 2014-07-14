<?php

// $Id: template.php,v 1.12.2.26 2007/11/29 06:41:40 johnalbin Exp $

/**
 * @file
 * File which contains theme overrides for the Zen theme.
 *
 * ABOUT
 *
 * The template.php file is one of the most useful files when creating or
 * modifying Drupal themes. You can add new regions for block content, modify or
 * override Drupal's theme functions, intercept or make additional variables
 * available to your theme, and create custom PHP logic. For more information,
 * please visit the Theme Developer's Guide on Drupal.org:
 * http://drupal.org/theme-guide
 */

/*
 * To make this file easier to read, we split up the code into managable parts.
 * Theme developers are likely to only be interested in functions that are in
 * this main template.php file.
 */

// Sub-theme support
include_once 'template-subtheme.php';

// Initialize theme settings
include_once 'theme-settings-init.php';

// Tabs and menu functions
include_once 'template-menus.php';

/**
 * Declare the available regions implemented by this theme.
 *
 * Regions are areas in your theme where you can place blocks. The default
 * regions used in themes are "left sidebar", "right sidebar", "header", and
 * "footer", although you can create as many regions as you want. Once declared,
 * they are made available to the page.tpl.php file as a variable. For instance,
 * use <?php print $header ?> for the placement of the "header" region in
 * page.tpl.php.
 *
 * By going to the administer > site building > blocks page you can choose
 * which regions various blocks should be placed. New regions you define here
 * will automatically show up in the drop-down list by their human readable name.
 *
 * @return
 *   An array of regions. The first array element will be used as the default
 *   region for themes. Each array element takes the format:
 *   variable_name => t('human readable name')
 */
function osulibraries_regions() {
  // Allow a sub-theme to add/alter variables
  global $theme_key;
  if ($theme_key != 'osulibraries') {
    $function = str_replace('-', '_', $theme_key) . '_regions';
    if (function_exists($function)) {
      return call_user_func($function);
    }
  }

  return array (
    'left' => t('left sidebar'
  ), 'right' => t('right sidebar'), 'navbar' => t('navigation bar'), 'top_bar' => t('top navigation bar'), 'content_top' => t('content top'), 'content_bottom' => t('content bottom'), 'header' => t('header'), 'footer' => t('footer'), 'closure_region' => t('closure'), 'central' => t('central'));
}

/*
 * OVERRIDING THEME FUNCTIONS
 *
 * The Drupal theme system uses special theme functions to generate HTML output
 * automatically. Often we wish to customize this HTML output. To do this, we
 * have to override the theme function. You have to first find the theme
 * function that generates the output, and then "catch" it and modify it here.
 * The easiest way to do it is to copy the original function in its entirety and
 * paste it here, changing the prefix from theme_ to phptemplate_ or osulibraries_. For
 * example:
 *
 *   original: theme_breadcrumb()
 *   theme override: osulibraries_breadcrumb()
 *
 * See the following example. In this function, we want to change all of the
 * breadcrumb separator characters from >> to a custom string.
 */

/**
 * Return a themed breadcrumb trail.
 *
 * @param $breadcrumb
 *   An array containing the breadcrumb links.
 * @return
 *   A string containing the breadcrumb output.
 */
function osulibraries_breadcrumb($breadcrumb) {
  $show_breadcrumb = theme_get_setting('osulibraries_breadcrumb');
  $show_breadcrumb_home = theme_get_setting('osulibraries_breadcrumb_home');
  $breadcrumb_separator = theme_get_setting('osulibraries_breadcrumb_separator');
  $trailing_separator = theme_get_setting('osulibraries_breadcrumb_trailing') ? $breadcrumb_separator : '';

  // Determine if we are to display the breadcrumb
  if ($show_breadcrumb == 'yes' || $show_breadcrumb == 'admin' && arg(0) == 'admin') {
    //if (!$show_breadcrumb_home) {
      // Optionally get rid of the homepage link
      array_shift($breadcrumb);
   // }
    if (!empty ($breadcrumb)) {
    	$uri_request_id = $_SERVER['REQUEST_URI'];
    	$urlexplode = explode("?", $uri_request_id);
    	$url = explode("/",$urlexplode[0]);

      if ($breadcrumb) {
        if (arg(0) == 'user') {
        $breadcrumb = array('<a href="http://osulibrary.oregonstate.edu/about.html">About OSU Libraries</a>', '<a href="http://osulibrary.oregonstate.edu/locations/findus.html">Directories</a>', '<a href = "/staff/directory/">Staff</a>');
        }
        else if (arg(1) == 'directory') {
          $breadcrumb = array('<a href="http://osulibrary.oregonstate.edu/about.html">About OSU Libraries</a>', '<a href="http://osulibrary.oregonstate.edu/locations/findus.html">Directories</a>');
        }
        else if ($url[1] == 'cascades' || $url[1] == 'guin') {
         array_shift($breadcrumb);
         array_shift($breadcrumb);
         }
      }
      // Return the breadcrumb with separators
      return '<div class="breadcrumb">' . implode($breadcrumb_separator, $breadcrumb) . "</div>";
    }
  }
  // Otherwise, return an empty string
  return '';
}

/**
* Catch the theme_user_profile function, and redirect through the template api
*/

function phptemplate_user_profile($user, $fields = array ()) {
  // Pass to phptemplate, including translating the parameters to an associative array. The element names are the names that the variables
  // will be assigned within your template.
  /* potential need for other code to extract field info */

 return _phptemplate_callback('user_profile', array (
    'user' => $user,
    'fields' => $fields,

  ));
}

/*** hide the tab in My Account, Edit that is created by ldap mapping to profile  ***/

function osulibraries_removetab($label, &$vars) {
  $tabs = explode("\n", $vars['tabs']);
  $vars['tabs'] = '';

  foreach($tabs as $tab) {
    if(strpos($tab, '>' . $label . '<') === FALSE) {
      $vars['tabs'] .= $tab . "\n";
    }
  }
}

/*
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 * The most powerful function available to themers is _phptemplate_variables().
 * It allows you to pass newly created variables to different template (tpl.php)
 * files in your theme. Or even unset ones you don't want to use.
 *
 * It works by switching on the hook, or name of the theme function, such as:
 *   - page
 *   - node
 *   - comment
 *   - block
 *
 * By switching on this hook you can send different variables to page.tpl.php
 * file, node.tpl.php (and any other derivative node template file, like
 * node-forum.tpl.php), comment.tpl.php, and block.tpl.php.
 */

/**
 * Intercept template variables
 *
 * @param $hook
 *   The name of the theme function being executed (name of the .tpl.php file)
 * @param $vars
 *   A copy of the array containing the variables for the hook.
 * @return
 *   The array containing additional variables to merge with $vars.
 */
function _phptemplate_variables($hook, $vars = array ()) {
  // Get the currently logged in user
  global $user;

  // Set a new $is_admin variable. This is determined by looking at the
  // currently logged in user and seeing if they are in the role 'admin'. The
  // 'admin' role will need to have been created manually for this to work this
  // variable is available to all templates.
  $vars['is_admin'] = in_array('admin', $user->roles);

  switch ($hook) {
    case 'page' :
    global $theme, $theme_key;

      // If we're in the main theme
        if ($theme == $theme_key) {

          if(arg(0) == 'user' && arg(1)) {
              $account = user_load(array('uid' => arg(1)));
              $fields = ldapdata_user_view($account);
              $firstname = $fields['LDAP attributes'][0]['value'];
              $lastname = $fields['LDAP attributes'][1]['value'];
              if ($firstname && $lastname) {
                $fullname = $firstname . " " . $lastname . " | ";
                $headtitle = $fullname . variable_get('site_name', 'Drupal');
              }
              drupal_set_html_head('<meta name="keywords" content="staff, directory, ' . $firstname . ", " . $lastname .  '" />');
              drupal_set_html_head('<meta name="description" content="Staff page for ' . $firstname . " " . $lastname .  '" />');
              $vars['head_title'] = $headtitle;
          }

        // These next lines add additional CSS files and redefine
        // the $css and $styles variables available to your page template
        // We had previously used @import declarations in the css files,
        // but these are incompatible with the CSS caching in Drupal 5
        drupal_add_css($vars['directory'] . '/layout.css', 'theme', 'all');
        drupal_add_css($vars['directory'] . '/html-elements.css', 'theme', 'all');
        drupal_add_css($vars['directory'] . '/tabs.css', 'theme', 'all');
        drupal_add_css($vars['directory'] . '/osulibraries.css', 'theme', 'all');
        drupal_add_css($vars['directory'] . '/two_column.css', 'theme', 'all');
        drupal_add_css($vars['directory'] . '/simpletree.css', 'theme', 'all');
        $vars['css'] = drupal_add_css();
        $vars['styles'] = drupal_get_css();

        //Alternate styles for font size switcher
        $altlink = '<link rel="alternate stylesheet" type="text/css" href="/';
        $vars['altstyles'] = $altlink . $vars['directory'] . '/small.css" title="small" />' . "\n" .
        $altlink . $vars['directory'] . '/medium.css" title="medium" />' . "\n" .
        $altlink . $vars['directory'] . '/large.css"  title="large" />';

        // Avoid IE5 bug that always loads @import print stylesheets
        $vars['head'] = osulibraries_add_print_css($vars['directory'] . '/print.css');

        // Add javascript files for template
        drupal_add_js($vars['directory'] . '/two_column.js');
        drupal_add_js($vars['directory'] . '/domutils.js');
        //drupal_add_js($vars['directory'] . '/menu.js');
        drupal_add_js($vars['directory'] . '/simpletreemenu.js');
        $vars['scripts'] = drupal_get_js();
      }

      // Send a new variable, $logged_in, to page.tpl.php to tell us if the
      // current user is logged in or out. An anonymous user has a user id of 0.
      $vars['logged_in'] = ($user->uid > 0) ? TRUE : FALSE;

      // Classes for body element. Allows advanced theming based on context
      // (home page, node of certain type, etc.)
      $body_classes = array ();
      $body_classes[] = ($vars['is_front']) ? 'front' : 'not-front';
      $body_classes[] = ($vars['logged_in']) ? 'logged-in' : 'not-logged-in';
      if ($vars['node']->type) {
        // If on an individual node page, put the node type in the body classes
        $body_classes[] = 'node-type-' . $vars['node']->type;
      }
      if ($vars['sidebar_left'] && $vars['sidebar_right']) {
        $body_classes[] = 'two-sidebars';
      }
      elseif ($vars['sidebar_left']) {
        $body_classes[] = 'one-sidebar sidebar-left';
      }
      elseif ($vars['sidebar_right']) {
        $body_classes[] = 'one-sidebar sidebar-right';
      } else {
        $body_classes[] = 'no-sidebars';
      }
      if (!$vars['is_front']) {
	// Add unique classes for each page and website section
        // First, remove base path and any query string.
        global $base_path;
        list (, $path) = explode($base_path, $_SERVER['REQUEST_URI'], 2);
        // If clean URLs are off, strip remainder of query string.
        list ($path,) = explode('&', $path, 2);
        // Strip query string.
        list ($path,) = explode('?', $path, 2);
        $path = rtrim($path, '/');
        // Construct the id name from the path, replacing slashes with dashes.
        $full_path = str_replace('/', '-', $path);
        // Construct the class name from the first part of the path only.
        list ($section,) = explode('/', $path, 2);
        $body_classes[] = osulibraries_id_safe('page-' . $full_path);
        $body_classes[] = osulibraries_id_safe('section-' . $section);
      }
	else {
$vars['head_title'] = variable_get('site_name', 'Drupal');
}
      $vars['body_classes'] = implode(' ', $body_classes); // implode with spaces
      osulibraries_removetab('ldap', $vars);
      break;

        case 'user_profile' :

        drupal_add_css($vars['directory'] . '/user_profile.css', 'theme', 'all');

        foreach ($vars['fields'] as $category => $items) {
          foreach ($items as $item) {
            if (isset($item['title'])) {
              switch ($item['title']) {
               case 'First Name':
               $vars['firstname'] = $item['value'] . ' ';
               break;

               case 'Last Name' :
               $vars['lastname'] .= $item['value'];
               break;

               case 'Email' :
               $vars['email'] = $item['value'];
               break;
              }
            }
          }
        }
        $vars['directoryinfo'] = node_load(array('type' => 'directory_info', 'uid' => arg(1)));
        $vars['branchaddress'] = node_load(array('type' => 'branch', 'nid' => $vars['directoryinfo']->field_branch[0]['nid']));
        if ($vars['directoryinfo']) {
          foreach ($vars['directoryinfo']->field_im as $item) {
            if (isset($item['value'])) {
              if ($vars['im'] != NULL) $vars['im'] .=', ';
              $vars['im'] .= $item['value'];
            }
          }
          foreach ($vars['directoryinfo']->field_blogs as $item) {
              if (isset($item['url']) && $item['url'] !== "") {
                if ($vars['blogs'] != NULL) $vars['blogs'] .= ', ';
                if (isset($item['title']) && $item['title'] !== "") {
                  $blog_title = $item['title'];
                }
                else {
                  $blog_title = $item['url'];
                }
                $blog_url = $item['url'];
                $vars['blogs'] .= '<a href="' . $blog_url . '">' . $blog_title . '</a>';
            }
          }
          foreach ($vars['directoryinfo']->field_websites as $item) {
              if (isset($item['url']) && $item['url'] !== "") {
                if ($vars['websites'] != NULL) $vars['websites'] .= ', ';
                if (isset($item['title']) && $item['title'] !== "") {
                  $blog_title = $item['title'];
                }
                else {
                  $blog_title = $item['url'];
                }
                $blog_url = $item['url'];
                $vars['websites'] .= '<a href="' . $blog_url . '">' . $blog_title . '</a>';
              }
          }
        }
        break;

        case 'node' :
          if ($vars['submitted']) {
            // We redefine the format for submitted.
            $vars['submitted'] = t('Posted <abbr class="created" title="!microdate">@date</abbr> by !username', array (
              '!username' => theme('username',
              $vars['node']
            ), '@date' => format_date($vars['node']->created, 'custom', "F jS, Y"), '!microdate' => format_date($vars['node']->created, 'custom', "Y-m-d\TH:i:sO"),));
          }

          // In this section you can also edit the following variables:
          // $vars['links']

          // Special classes for nodes
          $node_classes = array ();
          if ($vars['sticky']) {
            $node_classes[] = 'sticky';
          }
          if (!$vars['node']->status) {
            $node_classes[] = 'node-unpublished';
          }
          if ($vars['node']->uid && $vars['node']->uid == $user->uid) {
            // Node is authored by current user
            $node_classes[] = 'node-mine';
          }
          // Class for node type: "node-type-page", "node-type-story", "node-type-my-custom-type", etc.
          $node_classes[] = 'node-type-' . $vars['node']->type;
          $vars['node_classes'] = implode(' ', $node_classes); // implode with spaces

          break;

        case 'comment' :
          // We load the node object that the current comment is attached to
          $node = node_load($vars['comment']->nid);
          // If the author of this comment is equal to the author of the node, we
          // set a variable so we can theme this comment uniquely.
          $vars['author_comment'] = $vars['comment']->uid == $node->uid ? TRUE : FALSE;

          $comment_classes = array ();

          // Odd/even handling
          static $comment_odd = TRUE;
          $comment_classes[] = $comment_odd ? 'odd' : 'even';
          $comment_odd = !$comment_odd;

          if ($vars['comment']->status == COMMENT_NOT_PUBLISHED) {
            $comment_classes[] = 'comment-unpublished';
          }
          if ($vars['author_comment']) {
            // Comment is by the node author
            $comment_classes[] = 'comment-by-author';
          }
          if ($vars['comment']->uid == 0) {
            // Comment is by an anonymous user
            $comment_classes[] = 'comment-by-anon';
          }
          if ($user->uid && $vars['comment']->uid == $user->uid) {
            // Comment was posted by current user
            $comment_classes[] = 'comment-mine';
          }
          $vars['comment_classes'] = implode(' ', $comment_classes);

          // If comment subjects are disabled, don't display 'em
          if (variable_get('comment_subject_field', 1) == 0) {
            $vars['title'] = '';
          }

          break;
      }

      // Allow a sub-theme to add/alter variables
      if (function_exists('osulibraries_variables')) {
        $vars = osulibraries_variables($hook, $vars);
      }
      return $vars;

  }

  /**
   * Converts a string to a suitable html ID attribute.
   *
   * - Preceeds initial numeric with 'n' character.
   * - Replaces space and underscore with dash.
   * - Converts entire string to lowercase.
   * - Works for classes too!
   *
   * @param string $string
   *   The string
   * @return
   *   The converted string
   */
  function osulibraries_id_safe($string) {
    if (is_numeric($string {
      0 })) {
      // If the first character is numeric, add 'n' in front
      $string = 'n' . $string;
    }
    return strtolower(preg_replace('/[^a-zA-Z0-9-]+/', '-', $string));
  }

  /**
   * Adds a print stylesheet to the page's $head variable.
   *
   * This is a work-around for a serious bug in IE5 in which it loads print
   * stylesheets for screen display when using an @import method, Drupal's default
   * method when using drupal_add_css().
   *
   * @param string $url
   *   The URL of the print stylesheet
   * @return
   *   All the rendered links for the $head variable
   */
  function osulibraries_add_print_css($url) {
    global $base_path;
    return drupal_set_html_head('<link' .
    drupal_attributes(array (
      'rel' => 'stylesheet',
      'href' => $base_path . $url,
      'type' => 'text/css',
      'media' => 'print',

    )) . " />\n");
  }

  /**
 * views template to output a view.
 * This code was generated by the views theming wizard
 * Date: Fri, 01/25/2008 - 21:25
 * View: tab_brief_cv
 *
 * This function goes in your template.php file
 */
function phptemplate_views_view_list_tab_brief_cv($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }

  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';
    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
    $vars['icap_label'] = "Class Pages";
    $vars['icap_value'] = icap_list(arg(1));
    $items[] = _phptemplate_callback('tab_brief_cv', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}



/**
 * views template to output a view.
 * This code was generated by the views theming wizard
 * Date: Tue, 01/29/2008 - 21:00
 * View: tab_committees
 *
 * This function goes in your template.php file
 */
function phptemplate_views_view_list_tab_committees($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }


  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';
    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
    $items[] = _phptemplate_callback('views-list-tab_committees', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}


function phptemplate_views_view_list_tab_pubs($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }

  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';
    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
 //print_r($vars[field_materials_links_url]);
  //  if($vars[field_materials_uploads_fid]) {
  //  $vars[field_materials_links_url] .= $vars[field_materials_uploads_fid];
   // }
    $items[] = _phptemplate_callback('views-list-tab_pubs', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

function phptemplate_views_view_list_awardsoncv($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }

  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';
    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
    $items[] = _phptemplate_callback('views-list-awardsoncv', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}
function phptemplate_views_view_list_staff_contact_for($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }

  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';
    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
    $items[] = _phptemplate_callback('views-list-staff_contact_for', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}

//panel functions

function osulibraries_panels_tabs_style_render_panel($display, $panel_id, $panes, $settings) {
      $output = '';
      $tabs = array();
      $id = $display->css_id .'-'. $panel_id;

      // Add the Javascript to the page, and save the settings for this panel.
      panels_tabs_add_js();
      drupal_add_js(
        array(
          'panelsTabs' => array(
            $display->css_id => array(
              'fillingTabs' => $settings['filling_tabs'],
            ),
          )
        ),
        'setting'
      );

      $tabs[$id] = array(
        '#type' => 'tabset',
      );

      foreach ($panes as $pane_id => $content) {
        // Remove the title from the content. We don't want titles in both the tab
        // and the content associated with the tab.
        $content_without_title = drupal_clone($content);
        unset($content_without_title->title);
        if ((!strcmp($content->content,"")==0)&&content_check($content->content)) {
        $tabs[$id][$pane_id] = array(
          '#type' => 'tabpage',
          '#title' => $content->title,
          '#content' => theme('panels_pane', $content_without_title, $display->content[$pane_id], $display),
          '#weight' => $pane_id,
        );
      }
      }

      $output = tabs_render($tabs);
      return $output;
}

function content_check($content) {
  if(strpos($content, '<li></li>')!==FALSE)
  return FALSE;
  else
  return TRUE;
}

// Changes the default username display to full name based on profile fields filled by ldap mapping

function phptemplate_username($object, $link = TRUE) {
if ( !$object->profile_ldap_first_name  && !$object->profile_ldap_last_name ) {
if ( $object->uid && function_exists('profile_load_profile') ) {
profile_load_profile($object);
}
}

if ( $object->profile_ldap_common_name && $object->profile_ldap_last_name) {

$name = $object->profile_ldap_first_name . " " . $object->profile_ldap_last_name;

    if ( $link && user_access('access user profiles')) {
      return l($name, 'user/'. $object->uid, array('title' => t('View user profile.')));
    }
    else {
      return check_plain($name);
    }
}

// Profile field not set, default to standard behaviour

  if ($object->uid && $object->name) {
    // Shorten the name when it is too long or it will break many tables.
    if (drupal_strlen($object->name) > 20) {
      $name = drupal_substr($object->name, 0, 15) .'...';
    }
    else {
      $name = $object->name;
    }

    if ( $link && user_access('access user profiles')) {
      $output = l($name, 'user/'. $object->uid, array('title' => t('View user profile.')));
    }
    else {
      $output = check_plain($name);
    }
  }
  else if ($object->name) {
    // Sometimes modules display content composed by people who are
    // not registered members of the site (e.g. mailing list or news
    // aggregator modules). This clause enables modules to display
    // the true author of the content.
    if ($object->homepage) {
      $output = l($object->name, $object->homepage);
    }
    else {
      $output = check_plain($object->name);
    }

    $output .= ' ('. t('not verified') .')';
  }
  else {
    $output = variable_get('anonymous', 'Anonymous');
  }

  return $output;
}

/**
 * views template to output a view.
 * This code was generated by the views theming wizard
 * Date: Wed, 11/05/2008 - 10:22am
 * View: Subject_Specialist_by_name
 *
 * This function goes in your template.php file
 */
function phptemplate_views_view_list_Subject_Specialist_by_name($view, $nodes, $type) {
  $fields = _views_get_fields();

  $taken = array();

  // Set up the fields in nicely named chunks.
  foreach ($view->field as $id => $field) {
    $field_name = $field['field'];
    if (isset($taken[$field_name])) {
      $field_name = $field['queryname'];
    }
    $taken[$field_name] = true;
    $field_names[$id] = $field_name;
  }

  // Set up some variables that won't change.
  $base_vars = array(
    'view' => $view,
    'view_type' => $type,
  );

  foreach ($nodes as $i => $node) {
    $vars = $base_vars;
    $vars['node'] = $node;
    $vars['count'] = $i;
    $vars['stripe'] = $i % 2 ? 'even' : 'odd';
    foreach ($view->field as $id => $field) {
      $name = $field_names[$id];
      $vars[$name] = views_theme_field('views_handle_field', $field['queryname'], $fields, $field, $node, $view);
      if (isset($field['label'])) {
        $vars[$name . '_label'] = $field['label'];
      }
    }
    $items[] = _phptemplate_callback('views-list-Subject_Specialist_by_name', $vars);
  }
  if ($items) {
    return theme('item_list', $items);
  }
}


// make scheduler fields visually appear required on News form 
function osulibraries_news_node_form($form) {
	$form['scheduler_settings']['publish_on']['#required'] = TRUE;
	$form['scheduler_settings']['publish_on']['#description'] = str_replace("Leave blank to disable scheduled publishing", "Required", $form['scheduler_settings']['publish_on']['#description']);

	$form['scheduler_settings']['unpublish_on']['#required'] = TRUE;
	$form['scheduler_settings']['unpublish_on']['#description'] = str_replace("Leave blank to disable scheduled unpublishing", "Required", $form['scheduler_settings']['unpublish_on']['#description']);

	$output .= drupal_render($form);
	return $output;
}

// make scheduler fields actually required on News form
function news_node_form_validate($form, &$form_state) {
	if ($form_state['unpublish_on'] == '') form_set_error('', t('The unpublish date is required.'));
	if ($form_state['publish_on'] == '') form_set_error('', t('The publish date is required.'));
}