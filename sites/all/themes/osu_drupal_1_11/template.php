<?php
// $Id: template.php,v 1.17.2.1 2009/02/13 06:47:44 johnalbin Exp $

/**
 * @file
 * Contains theme override functions and preprocess functions for the theme.
 *
 * ABOUT THE TEMPLATE.PHP FILE
 *
 *   The template.php file is one of the most useful files when creating or
 *   modifying Drupal themes. You can add new regions for block content, modify
 *   or override Drupal's theme functions, intercept or make additional
 *   variables available to your theme, and create custom PHP logic. For more
 *   information, please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/theme-guide
 *
 * OVERRIDING THEME FUNCTIONS
 *
 *   The Drupal theme system uses special theme functions to generate HTML
 *   output automatically. Often we wish to customize this HTML output. To do
 *   this, we have to override the theme function. You have to first find the
 *   theme function that generates the output, and then "catch" it and modify it
 *   here. The easiest way to do it is to copy the original function in its
 *   entirety and paste it here, changing the prefix from theme_ to STARTERKIT_.
 *   For example:
 *
 *     original: theme_breadcrumb()
 *     theme override: STARTERKIT_breadcrumb()
 *
 *   where STARTERKIT is the name of your sub-theme. For example, the
 *   zen_classic theme would define a zen_classic_breadcrumb() function.
 *
 *   If you would like to override any of the theme functions used in Zen core,
 *   you should first look at how Zen core implements those functions:
 *     theme_breadcrumbs()      in zen/template.php
 *     theme_menu_item_link()   in zen/template.php
 *     theme_menu_local_tasks() in zen/template.php
 *
 *   For more information, please visit the Theme Developer's Guide on
 *   Drupal.org: http://drupal.org/node/173880
 *
 * CREATE OR MODIFY VARIABLES FOR YOUR THEME
 *
 *   Each tpl.php template file has several variables which hold various pieces
 *   of content. You can modify those variables (or add new ones) before they
 *   are used in the template files by using preprocess functions.
 *
 *   This makes THEME_preprocess_HOOK() functions the most powerful functions
 *   available to themers.
 *
 *   It works by having one preprocess function for each template file or its
 *   derivatives (called template suggestions). For example:
 *     THEME_preprocess_page    alters the variables for page.tpl.php
 *     THEME_preprocess_node    alters the variables for node.tpl.php or
 *                              for node-forum.tpl.php
 *     THEME_preprocess_comment alters the variables for comment.tpl.php
 *     THEME_preprocess_block   alters the variables for block.tpl.php
 *
 *   For more information on preprocess functions and template suggestions,
 *   please visit the Theme Developer's Guide on Drupal.org:
 *   http://drupal.org/node/223440
 *   and http://drupal.org/node/190815#template-suggestions
 */


/*
 * Add any conditional stylesheets you will need for this sub-theme.
 *
 * To add stylesheets that ALWAYS need to be included, you should add them to
 * your .info file instead. Only use this section if you are including
 * stylesheets based on certain conditions.
 */
/* -- Delete this line if you want to use and modify this code
// Example: optionally add a fixed width CSS file.
if (theme_get_setting('STARTERKIT_fixed')) {
  drupal_add_css(path_to_theme() . '/layout-fixed.css', 'theme', 'all');
}
// */

include_once './' . drupal_get_path('theme', 'osu_drupal_1_11') . '/template.theme-registry.inc';

/**
 * Implementation of HOOK_theme().
 */
function osu_drupal_1_11_theme(&$existing, $type, $theme, $path) {
	$hooks = zen_theme($existing, $type, $theme, $path);
	// Add your theme hooks like this:
	/*
	  $hooks['hook_name_here'] = array( // Details go here );
	*/
	// @TODO: Needs detailed comments. Patches welcome!
  
	include_once './' . drupal_get_path('theme', 'osu_drupal_1_11') . '/template.theme-registry.inc';
	return $hooks;
}

/**
 * Override or insert variables into all templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered (name of the .tpl.php file.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the page templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("page" in this case.)
 */

function osu_drupal_1_11_preprocess_page(&$vars, $hook) {
	$vars['tabs2'] = menu_secondary_local_tasks();

	// Hook into color.module
	if (module_exists('color')) {
	  _color_page_alter($vars);
	}
	
	//Create the indexes in our vars array for population by osu_search_get_template_form
	$vars['osu_search_form'] = null;
	$vars['osu_search_image_submit_form'] = null;
	
	if (module_exists('osu_search')) {
	    osu_search_get_template_form($vars);
	}
}


/**
 * Override or insert variables into the node templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("node" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_node(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the comment templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("comment" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_comment(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * Override or insert variables into the block templates.
 *
 * @param $vars
 *   An array of variables to pass to the theme template.
 * @param $hook
 *   The name of the template being rendered ("block" in this case.)
 */
/* -- Delete this line if you want to use this function
function STARTERKIT_preprocess_block(&$vars, $hook) {
  $vars['sample_variable'] = t('Lorem ipsum.');
}
// */

/**
 * return OSU Top Hat
 * 
 */
function osu_drupal_1_11_top_hat() {
	return '<div id="osu-top-hat">
			<div id="top-hat-interior">
				<a href="http://oregonstate.edu"><img src="http://oregonstate.edu/u_central/images/blackWordmark.gif" alt="OSU Logo" /></a>
				<ul>
					<li><a href="http://catalog.oregonstate.edu/">Catalog</a></li>
					<li><a href="http://calendar.oregonstate.edu/">Calendar</a></li>
					<li><a href="http://oregonstate.edu/findsomeone/">Find Someone</a></li>
					<li><a href="http://oregonstate.edu/campusmap/">Maps</a></li>
					<li class="last"><a href="http://oregonstate.edu/siteindex.php">A-Z Index</a></li>
				</ul>
			</div>
		</div>';
}

/*
 * Returns the favicon embed
 */
function osu_drupal_1_11_get_favicon(){
    return sprintf("<link rel='icon' type='image/vnd.microsoft.icon' href='%s/favicon.ico' />",base_path() . drupal_get_path('theme', 'osu_drupal_1_11'))  ;
}


/*
 * 
 * You can use this to override the display of your feed icons
 * 

function THEMENAME_feed_icon($url, $title) {
  if ($image = theme('image', 'misc/feed.png', t('Syndicate content'), $title)) {
    $result = '<a href="'. check_url($url) .'" class="feed-icon">'. $image;
    $result .= '<span>subscribe to RSS feed</span>';
		$result .= '</a>';
    return $result;
  }
}
 */


	/* Uses the theme settings saved variables:
	 * 0: Continuous rotation;
	 * 1: Random on load
	 * 2: Same image always 
     *
     * @params bool $is_front
     * @params string $rotating_div         The #id or .class of the div containing rotating images
	 */
	function osu_drupal_1_11_rotating_header($is_front=false, $rotating_div='#hd') {
		$path = osu_drupal_1_11_get_rotating_header_path();
		//print_r($path);
		
		$rotating_header_type = ($is_front)?theme_get_setting('osu_rotating_header_type'):theme_get_setting('osu_second_rotating_header_type');		
		switch ($rotating_header_type) {
			case 0:
				include_once './' . drupal_get_path('theme', 'osu_drupal_1_11') . '/rotating-image.php';
				break;
			case 1:
				$available_images = glob($path['abs'].'*');
				$image = $available_images[rand(0, (count($available_images) - 1))];
				echo '<div class="slide">';
				echo '<img src="'.$path['rel'].basename($image).'" alt="header image" />';
				echo '</div>';
				break;
			case 2:
				if (theme_get_setting('osu_rotating_header_single_image')) {
					$image = ($is_front)?theme_get_setting('osu_rotating_header_single_image'):theme_get_setting('osu_second_rotating_header_single_image');
					echo '<div class="slide">';
					echo '<img src="'.$path['rel'].basename($image).'" alt="header image" />';
					echo '</div>';
				}
				break;
		}
	}	

    /**
     * Overriding the zen breadcrumb function so that we can insert the
     * breadcrumb prefix
     *
     */
	function osu_drupal_1_11_breadcrumb($breadcrumb) {
        if (!empty($breadcrumb) && theme_get_setting('osu_breadcrumb_first') != '') {
            $breadcrumb[0] = l(theme_get_setting('osu_breadcrumb_first'), '<front>');
        }

        // Get the breadcrumbs that zen generates
        $output = zen_breadcrumb($breadcrumb);
        if (!empty($output)) {
            $start_html = '<div class="breadcrumb">';
            if (theme_get_setting('osu_breadcrumb_prefix') != '') {
                $output = str_replace($start_html, '', $output); // workaround since zend returns a pre-formatted set of links within a div
                $output = $start_html.theme_get_setting('osu_breadcrumb_prefix')." $output";
            }
            return $output;
        }
    }

    /**
     * The  hook below is used to remove entries from the 
     * list of themes in admin/build/themes. 
     * For more info on this fix see:
     * [1] http://drupal.org/node/223463
     * [2] http://www.lullabot.com/articles/modifying-forms-5-and-6
     */
    function osu_drupal_1_11_system_themes_form($form) {
        // repeat the line below to remove themes from the list
        $form = osu_drupal_1_11_remove_theme('osu_drupal', $form);
        $form = osu_drupal_1_11_remove_theme('osu_drupal_1_9', $form);
	    $form = osu_drupal_1_11_remove_theme('osu_drupal_1_10', $form);
        return theme_system_themes_form($form);
    }

    /**
     * This method removes a theme from the list of themes in
     * the system themes form $form array. 
     *
     * @param string $theme_name          The theme that you want to remove
     * @param array $form                The $form array
     * @return array $form
     */
    function osu_drupal_1_11_remove_theme($theme_name, $form) {
        unset($form[$theme_name]);
        unset($form['status']['#options'][$theme_name]);
        unset($form['status'][$theme_name]);
        unset($form['theme_default']['#options'][$theme_name]);
        unset($form['theme_default'][$theme_name]);

        return $form;
    }
?>
