<?php

if (theme_get_setting('osu_confident_color_scheme')) {
    $path = drupal_get_path('theme', 'osu_confident') .'/' . theme_get_setting('osu_confident_color_scheme');
    drupal_add_css($path, 'theme', 'all');
}

/**
 * return OSU Top Hat
 *
 */
function osu_new_top_hat() {
    top_hat_print_hat();
}

/**
 * This sets the background color of the page
 * based on a setting.

function osu_confident_background() {
	$html = 'style="';
	$bg_color = '#dbd7d1';

	if (theme_get_setting('osu_confident_background_color') == 'light') {
		$bg_color = '#eeece8';
	 } elseif (theme_get_setting('osu_confident_background_color') == 'dark') {
		$bg_color = '#dbd7d1';
    }
	$html .= 'background-color:'.$bg_color.';"';


	return $html;
} */

/**
 * This sets the background color on the rounded edge
 * of the right sidebar h2.
 */
function osu_confident_corner_color() {
	$bg_color = '#dbd7d1';
    if (theme_get_setting('osu_confident_background_color') == 'light') {
        $bg_color = '#eeece8';
    } elseif (theme_get_setting('osu_confident_background_color') == 'dark') {
        $bg_color = '#dbd7d1';
    }

	return $bg_color;
}

function osu_confident_feed_icon($url, $title) {
    if ($image = theme('image', 'misc/feed.png', t('Syndicate content'), $title)) {
        $result = '<a href="'. check_url($url) .'" class="feed-icon">'. $image;
        $result .= '<span class="feed-text"> subscribe to RSS feed</span>';
        $result .= '</a>';
        return $result;
    }
}

/*** Modifying the google search appliance form that appears in the header ***/
function osu_confident_theme() {
  return array(
    // The form ID.
    'google_appliance_search_form' => array(
      // Forms always take the form argument.
      'arguments' => array('form' => NULL)
      ),
 //     'menu_local_task' => array(
 //     'arguments' => array('mid' => NULL, 'active' => NULL, 'primary' => NULL),
 //     ),
 		'page_node_form' => array(
 			'arguments' => array('form' => NULL),
 		)
  );
}

function osu_confident_page_node_form($form) {
	drupal_set_message(t($form['field_guidelines'][0]['#value']['value']), 'status');
	global $user;
	$account = user_load(array('uid' => $user->uid));
	if (!in_array('guidelines-editor', $account->roles) && !in_array('super-user', $account->roles) && !in_array('admin', $account->roles)) {
		unset($form['field_guidelines']);
	}
	$form['buttons']['#weight'] = 50;
	$output .= drupal_render($form);
	return $output;
}

function osu_confident_google_appliance_search_form($form) {
	$output = '';
	$form['keys']['#size'] = NULL;
	$form['keys']['#title'] = NULL;
	$form['keys']['#value'] = 'Search this site';
	$form['keys']['#attributes'] = array('onfocus' => "if(this.value=='" . $form['keys']['#value'] . "') {value='';};this.style.color='black'");
	$form['submit']['#type'] = 'image_button';
	$form['submit']['#src'] = 'sites/all/themes/osu_confident/images/osul_images/gogray.gif';
	$form['submit']['#attributes'] = array('class' => 'gobtn');
	$output .= drupal_render($form);
	return $output;
}

function phptemplate_menu_local_task($link, $active = FALSE) {
	$disabled_tabs = array('search');
	foreach ($disabled_tabs as $tab) {
		if(strpos($link, 'href="/' . $tab) !== false)
			return '';
	}
	return '<li '. ($active ? 'class="active" ' : '') .'>'. $link ."</li>\n";
}

/*function phptemplate_menu_local_task($mid, $active, $primary) {
     $disabled_tabs = array('search/user' , 'search/node');

	 //Check each tab being rendered for our victim
     $item = menu_get_item($mid);

	 foreach ($disabled_tabs as $tab) {
     	if (substr($item['path'],0,strlen($tab))==$tab) {
             return '';
       	}

	 }
     //The rest is copied from theme_menu_local_task()
     if ($active) {
         return '<li class="active">'. menu_item_link($mid) ."</li>";
     }
     else {
         return '<li>'. menu_item_link($mid) ."</li>";
     }
}*/

function osu_confident_preprocess_page(&$vars) {
  // if this is a panel page, add template suggestions
  if($panel_page = page_manager_get_current_page()) {
    // add a generic suggestion for all panel pages
    $suggestions[] = 'page-panel';
    // add the panel page machine name to the template suggestions
    $suggestions[] = 'page-' . $panel_page['name'];
    // merge the suggestions in to the existing suggestions (as more specific than the existing suggestions)
    $vars['template_files'] = array_merge($vars['template_files'], $suggestions);
  }
  
  //page class in page.tpl.php
  if(in_array('page-taxonomy', $vars['template_files'])){  
	$vars['page_class'] = "taxonomy";
  }
  $post_pages = array('ill_entry_public', 'ill_entry_private', 'rdm_entry_public', 'rdm_entry_private', 'rdm_news');
  if(in_array($vars['node']->type, $post_pages)){
	  $vars['page_class'] = "rdmPost";
  }
  if($vars['is_front'] && $vars['site_name'] == 'RDM'){
	  $vars['head_title'] = "Home | RDM";
  }
}

/**
* Default theme function for all RSS rows.
*/
function phptemplate_preprocess_views_view_row_rss(&$vars) {
	$view = &$vars['view'];
	$options = &$vars['options'];
	$item = &$vars['row'];

	// Use the [id] of the returned results to determine the nid in [results]
	$result = &$vars['view']->result;
	$id = &$vars['id'];
	$node = node_load( $result[$id-1]->nid );

	$vars['title'] = check_plain($item->title);
	$vars['link'] = check_url($item->link);
	$vars['description'] = check_plain($item->description);
	//$vars['description'] = check_plain($node->teaser);
	$vars['node'] = $node;
	$vars['item_elements'] = empty($item->elements) ? '' : format_xml_elements($item->elements);
}

function osu_confident_preprocess_views_exposed_form(&$vars){
	if($vars['form']['#parameters'][1]['view']->name == 'ref_search' || $vars['form']['#parameters'][1]['view']->name == 'ill_search'){
		$vars['form']['submit']['#value'] = t('Search');

		unset($vars['form']['submit']['#printed']);
		$vars['button'] = drupal_render($vars['form']['submit']);
	}
}

function osu_confident_preprocess_user_picture(&$variables) {
	if(arg(0)=='node' && is_numeric(arg(1)) && arg(2)=='submission' && is_numeric(arg(3))) {
		$nid = arg(1); 
		$webform_path = 'internships/undergraduate-application';
		$webform_nid = drupal_lookup_path('source', $webform_path, $path_language = '');
		if (isset($webform_nid)) {
			$cpath = "node/".$nid;
			if ($cpath == $webform_nid) {
				$variables['picture'] = "";
			}
		}		
	} 
	
}
?>
