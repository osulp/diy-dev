<?php
function diy_form_google_appliance_block_form_alter(&$form, &$form_state, $form_id) {
    //dpm($form);
    $form['actions']['submit']['#attributes'] = array('class' => array('icon-search word-hide'));
    $form['search_keys']['#default_value'] = 'Search this site';
    $form['search_keys']['#attributes'] = array('onfocus' => "if(this.value=='" . $form['search_keys']['#default_value'] . "') {value='';};this.style.color='black'");
    return $form;
}

function diy_preprocess_html(&$variables) {
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


// Theme the breadcrumb
function diy_breadcrumb($variables) {
  $breadcrumb = $variables['breadcrumb'];

  if (!empty($breadcrumb)) {
    // Adding the title of the current page to the breadcrumb.
    $breadcrumb[] = drupal_get_title();

    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

     $output .= '<div class="breadcrumb">' . implode(' » ', $breadcrumb) . '</div>';
    return $output;
  }
}

?>
