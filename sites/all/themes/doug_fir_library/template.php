<?php

function doug_fir_library_form_google_appliance_block_form_alter(&$form, &$form_state, $form_id) {
    $form['actions']['submit']['#attributes'] = array('class' => array('icon-search word-hide'));
    $form['search_keys']['#default_value'] = 'Search this site';
		$form['search_keys']['#attributes'] = array('onfocus' => "if(this.value=='" . $form['search_keys']['#default_value'] . "') {value='';};this.style.color='black'");
  	return $form;
}
/*function osu_confident_google_appliance_search_form($form) {
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
}*/

function doug_fir_library_preprocess_html(&$variables) {
  $lpath = drupal_get_path('theme', 'doug_fir_library');
  // Include responsive stylesheets
  if (theme_get_setting('responsive')) {
    // Need these options to get these stylesheets to load last
    $options = array(
      'group'  =>  CSS_THEME,
      'weight' => 500,
    );
    drupal_add_css($lpath . '/css/resp.css', $options);

  }

  // Include stylesheets for theme variants
  $variant = theme_get_setting('variant');
  switch ($variant) {
    case 'rdm' :
      drupal_add_css($lpath . '/css/rdm.css');
      break;
    case 'guin' :
      drupal_add_css($lpath . '/css/guin.css', array('group' => CSS_THEME));
      break;
    case 'cascades' :
      drupal_add_css($lpath . '/css/cascades.css', array('group' => CSS_THEME));
      break;
    case 'default' :
      break;
  }
}

//template changes for Digital Collection landing pages, going down the pages
function doug_fir_library_preprocess_page(&$variables) {
	if($variables['node']->type && $variables['node']->type == 'digital_collection_landing_page') {
	 //hide the utility menu
		//$settings = variable_get('osu_top_hat_settings', array());
		//$settings['hide_utility'] = 1;
		//variable_set('osu_top_hat_settings', $settings);
		$variables['parent']['name'] = 'OSU Libraries';
		$variables['parent']['url'] = 'osulibrary.oregonstate.edu';
		$variables['site_name'] = $variables['node']->title;
		unset($variables['page']['nav']);
		$variables['breadcrumb'] = FALSE;
		$variables['title'] = FALSE;
	} else {
		  if (!empty($variables['page']['content']['system_main']['biblio_page']['content'])) {
    //dpm ("biblio pages");
    //dpm ($variables['page']['content']['system_main']['biblio_page']['content']['section_1'][0]['entry']['#markup']);

    $biblio_sections = $variables['page']['content']['system_main']['biblio_page']['content'];
    //dpm($biblio_sections);

    foreach ($biblio_sections as $key => $section) {
        //  Check type
        if (is_array($section) && !empty($section['#prefix'])){
          //dpm($section);

          //  Scan through outer loop
          foreach ($section as $key2 => $entry) {
              //  Check type
              if (is_array($entry) && !empty($entry['entry'])){
                  $markup = $entry['entry']['#markup'];
                  $exp_links_markup = $entry['export_links']['#markup'];
                  #dpm($markup);
                  #$node_substr = strstr($markup, '/node/');
                  $node_substr = strstr($exp_links_markup, '/bibtex/');
                  $node_path = strstr($node_substr, '"', true); // As of PHP 5.3.0
                  #$entry_id = substr($node_path,6);
                  $entry_id = substr($node_path,8);

                  #dpm($entry_id);

                  $osuAuthors = db_query('SELECT b.cid, a.lastname, a.firstname, a.affiliation
                    FROM {biblio_contributor} b
                    INNER JOIN {biblio_contributor_data} a
                    ON b.cid = a.cid
                    WHERE b.nid = :nid
                    AND a.affiliation LIKE :org', array(':nid' => $entry_id, ':org' =>  '%'.db_like('Oregon State University').'%'));

                  //foreach ($osuAuthors as $record) {
                    //dpm($record->affiliation);
                  //}

                  if (!empty($osuAuthors)) {
                      // Format entry
                      $tabs = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';

                      $osu_authors_prefix = '<br>'.$tabs.'OSU Authors: ';
                      $osu_authors = '';
                      foreach ($osuAuthors as $author) {
                        $osu_authors = $osu_authors.$author->lastname.', ';
                      }
                      $osu_authors = trim(trim($osu_authors), ",");
                      $custom_entry = $markup.$osu_authors_prefix.$osu_authors.'<br>';

                      if (is_string($key)) {
                          $variables['page']['content']['system_main']['biblio_page']['content'][$key][$key2]['entry']['#markup'] = $custom_entry;
                      }
                  }
              }
          }
        }
      }
    }


	}
}

function doug_fir_library_form_alter(&$form, &$form_state, $form_id) {
  if ($form_id == 'biblio_search_form') {
    $form['search_form']['#title'] = t('Search');
    //$form['search_form']['#collapsible'] = FALSE;  //Search form
    //$form['search_form']['#collapsed'] = FALSE;  //Search form
	//dpm($form);
    //$form['search_form']['filterform']['filters']['#title'] = t('Limit to');
    $form['search_form']['filterform']['filters']['#collapsible'] = TRUE;  //Filter form fields
    $form['search_form']['filterform']['filters']['#collapsed'] = FALSE;  //Filter form fields
    //$form['search_form']['searchform']['biblio_search']['submit']['#value'] = t('Find');
    //$form['search_form']['filterform']['filters']['status']['filters']['type']['#access'] = FALSE;  //Hide type filter
    //$form['search_form']['filterform']['filters']['status']['filters']['year']['#access'] = FALSE;  //Hide year filter
    //$form['search_form']['filterform']['filters']['status']['filters']['author']['#access'] = FALSE;  //Hide author filter
    //$form['search_form']['filterform']['filters']['status']['filters']['keyword']['#access'] = FALSE;  //Hide keyword
  }
}
