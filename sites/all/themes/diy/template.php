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
  $breadcrumb_tmp = array();

  //dpm($breadcrumb);

  if (!empty($breadcrumb)) {
    $home_crumb = $breadcrumb[0];
    $breadcrumb_tmp[] = $home_crumb;

    $query_parameters = drupal_get_query_parameters();
    if (!empty($query_parameters['topc'])) {
      if (is_numeric($query_parameters['topc'])) {
          $nodeid = $query_parameters['topc'];
          diy_sitemap_lists_set_session("topc", $nodeid);
          diy_sitemap_lists_reset_session("subc_array",array());
          //dpm("saved topc:");
          //dpm($nodeid);
      }
    }

    if (current_path() === "sitemap") {
      //dpm(current_path());
      diy_sitemap_lists_reset_session("subc_array",array());
    }

    if (!empty($query_parameters['category'])) {
      if (is_numeric($query_parameters['category'])) {
          $nodeid = $query_parameters['category'];

          $sub_categories = diy_sitemap_lists_get_session("subc_array");

          $subc_array = array();

          if (!empty($sub_categories)) {
            $level_count = count($sub_categories);
            $level_count = $level_count + 1;

            $cat_nid = intval($nodeid);
            $cat_node = node_load($cat_nid, NULL, TRUE);
            $cat_node_title = $cat_node->title;

            $nodeid_obj = new stdClass();
            $nodeid_obj->nid = $nodeid;
            $nodeid_obj->level = $level_count;
            $nodeid_obj->title = $cat_node_title;

            $nodeid_array = array($nodeid_obj);

            $nid_found = false;
            foreach ($sub_categories as $cat_item) {
              if (isset($cat_item->nid)) {
                if ($nodeid == $cat_item->nid) {
                  $nid_found = true;
                }
              }
            }

            if (!$nid_found) {
                $subc_array = array_unique(
                array_merge($nodeid_array,$sub_categories), SORT_REGULAR);
            } else {
                $subc_array = $sub_categories;
            }

          } else {
            $level_count = 1;

            $cat_nid = intval($nodeid);
            $cat_node = node_load($cat_nid, NULL, TRUE);
            $cat_node_title = $cat_node->title;

            $nodeid_obj = new stdClass();
            $nodeid_obj->nid = $nodeid;
            $nodeid_obj->level = $level_count;
            $nodeid_obj->title = $cat_node_title;

            $nodeid_array = array($nodeid_obj);

            $subc_array = $nodeid_array;
          }

          diy_sitemap_lists_set_session("subc_array", $subc_array);
          //dpm("saved topc:");
          //dpm($nodeid);
      }
    }

    $top_category = diy_sitemap_lists_get_session("topc");
    $subc_list = diy_sitemap_lists_get_session("subc_array");

    if (!empty($top_category)) {

      //dpm("stored topc:");
      //dpm($top_category);
      $top_cat_nid = intval($top_category);
      $top_node = node_load($top_cat_nid, NULL, TRUE);
      $top_node_title = $top_node->title;
      //dpm($top_node_title);

    } else {
      //dpm("empty");

    }

    $crumb_list = array();

    foreach ($breadcrumb as $link) {
      $result = explode(">", $link);

      if (count($result) == 3) {
        $href_tag = ltrim($result[0],'<a href="');
        $href_tag = rtrim($href_tag,'"');
        $title_tag = rtrim($result[1],"</a");
        //dpm($href_tag);
        //dpm($title_tag);
        $crumb_item = new stdClass();
        $crumb_item->href = $href_tag;
        $crumb_item->title = $title_tag;
        $crumb_list[] = $crumb_item;
      }
    }

    if (!empty($subc_list)) {
      //drupal_set_message('<pre>'. print_r($subc_list, true) .'</pre>');
      //dpm($subc_list);
      $ccount = 0;

      foreach ($crumb_list as $crumb) {
        $found_href = "";

        foreach ($subc_list as $subc) {
          if (isset($subc->title) && isset($crumb->title) && isset($subc->level)) {
              if ($subc->title === $crumb->title && $subc->level == 1) {
                $crumb_list[$ccount]->href = $crumb_list[$ccount]->href."?topc=".$subc->nid;
                $found_href = $crumb_list[$ccount]->href;
                //$breadcrumb_tmp[] = '<a href="'.$crumb_list[$ccount]->href.'">'.$crumb_list[$ccount]->title.'</a>';

              }
              if ($subc->title === $crumb->title && $subc->level > 1) {
                // find parent of parent
                $great_parent_level = $subc->level - 2;
                $great_parent_flag = false;
                $great_parent_obj_tmp = new stdClass();
                $great_parent_obj_tmp->nid = "";

                if ($great_parent_level > 0) {
                  if ($great_parent_level == 1) {
                    $great_parent_obj = _get_crumb_obj_with_session_level($subc_list,$great_parent_level);
                    if (!empty($great_parent_obj)) {
                        $breadcrumb_tmp[] = '<a href="'.$great_parent_obj->href.'?topc='.$great_parent_obj->nid.'">'.$great_parent_obj->title.'</a>';
                        $great_parent_flag = true;
                        $great_parent_obj_tmp = $great_parent_obj;
                    }
                  }

                }

                // find parent
                $parent_level = $subc->level - 1;
                $parent_nid = _get_crumbid_with_session_level($subc_list,$parent_level);
                $parent_obj = _get_crumb_obj_with_session_level($subc_list,$parent_level);

                if ($parent_level == 1) {
                  if (!empty($parent_obj)) {
                      $breadcrumb_tmp[] = '<a href="'.$parent_obj->href.'?topc='.$parent_nid.'">'.$parent_obj->title.'</a>';
                  }
                } else {
                  if ($great_parent_flag == true && isset($great_parent_obj_tmp->nid)) {
                    if (!empty($parent_obj)) {
                        $breadcrumb_tmp[] = '<a href="'.$parent_obj->href.'?category='.$great_parent_obj_tmp->nid.'">'.$parent_obj->title.'</a>';
                    }
                  } else {
                    if (!empty($parent_obj)) {
                        $breadcrumb_tmp[] = '<a href="'.$parent_obj->href.'">'.$parent_obj->title.'</a>';
                    }
                  }

                }


                // update crumb_list
                $crumb_list[$ccount]->href = $crumb_list[$ccount]->href."?category=".$parent_nid;
                $found_href = $crumb_list[$ccount]->href;


              }
          }

        }

        if (!empty($found_href)) {
            $bcount = 0;
            foreach ($breadcrumb as $bc) {
                if (strpos($bc,$crumb->title) !== false) {
                  $breadcrumb[$bcount] = '<a href="'.$found_href.'">'.$crumb->title.'</a>';
                }
                $bcount = $bcount + 1;
            }
        }

        $ccount = $ccount + 1;
      }

      /*
      // add higher level trail from session variables
      $cl_tmp = 0;
      foreach ($subc_list as $sub_c) {

      }*/

    }

    //dpm($crumb_list);

    // add active trail
    $cl_tmp = 0;
    //dpm("breadcrumb_tmp:");
    foreach($crumb_list as $ctmp) {
      if ($cl_tmp > 0) {

          $breadcrumb_tmp[] = '<a href="'.$ctmp->href.'">'.$ctmp->title.'</a>';
      }
      $cl_tmp = $cl_tmp + 1;
    }

    //dpm($breadcrumb_tmp);
    $breadcrumb = $breadcrumb_tmp;

    // Adding the title of the current page to the breadcrumb.
    $breadcrumb[] = drupal_get_title();

    // Provide a navigational heading to give context for breadcrumb links to
    // screen-reader users. Make the heading invisible with .element-invisible.
    $output = '<h2 class="element-invisible">' . t('You are here') . '</h2>';

    //dpm($breadcrumb);




    $output .= '<div class="breadcrumb">' . implode(' » ', $breadcrumb) . '</div>';
    return $output;
  }
}



?>
