<?php
/**
 * @file
 * OSU Theme settings
 */

/**
 * Implements hook_form_FORM_ID_alter().
 *
 * @param $form
 *   The form.
 * @param $form_state
 *   The form state.
 */
function doug_fir_form_system_theme_settings_alter(&$form, &$form_state) {
  $themes = list_themes();

  $default_variant = $themes['doug_fir']->info['default_variant'];
  $variants = $themes['doug_fir']->info['variants'];

  $variant_text = 'Select which theme variant you want to use: <br />' .
              '&nbsp;&nbsp;<b>Doug Fir</b>&nbsp;&nbsp;&nbsp;&nbsp; - The new default Drupal 7 theme with a refreshed brand look. <br />' .
              '&nbsp;&nbsp;<b>OSU Standard</b>&nbsp;&nbsp;&nbsp;&nbsp; - Matches the default Drupal 6 theme and OSU\'s home page. <br />' .
              '&nbsp;&nbsp;<b>Marine</b> - Includes blue colors and  marine and space iconography. <br />' .
              '&nbsp;&nbsp;<b>Science</b> - Gray footer, and a slgihtly different menu, this adds a little more gray <br />' .
              '&nbsp;&nbsp;<b>Orange</b> - Orange texture stripe background <br />' .
              '&nbsp;&nbsp;<b>Boxy</b> - Similar to doug fir, but with content and sidebars wrapped in boxes <br />' .
              '&nbsp;&nbsp;<b>Agriculture</b> - For the Agricultural Sciences and affiliated groups who wish to use it <br />';

  $backgrounds = array();
  $bg_images   = array();

  drupal_add_js('./' . drupal_get_path('theme', 'doug_fir') . '/js/variants.js');

  drupal_add_js(array('doug_fir_variants' => $variants), 'setting');

  foreach ($variants as $varname => $vartitle) {
    $variant_path = './' . drupal_get_path('theme', 'doug_fir') . '/css/variants/' . $varname . '/' . $varname . '.inc';
    if (file_exists($variant_path)) {
      require_once $variant_path;
      $backgrounds[$varname] = array();
      $func = 'doug_fir_' . $varname;
      $styles = $func();
      foreach ($styles as $class => $style) {
        $title  = $style['title'];
        $thumb  = $style['bg'];
        $backgrounds[$varname][$class] = $title;
        $bg_images[$class] = '../../../' . drupal_get_path('theme', 'doug_fir') . '/css/variants/' . $varname . '/images/' . $thumb;
      }
    }
  }
  
  // Expose the bg_images array to Javascript
  drupal_add_js(array('doug_fir_bg' => $bg_images), 'setting');

  // Hide the default theme settings
  $form['theme_settings']['#type'] = 'hidden';
  $form['logo']['#type'] = 'hidden';
  $form['favicon']['#type'] = 'hidden';

  // But make sure the site name is enabled
  $form['theme_settings']['toggle_name'] = array(
    '#type'           => 'hidden',
    '#default_value'  => 1,
  );

  // and the favicon
  $form['theme_settings']['toggle_favicon'] = array(
    '#type'           => 'hidden',
    '#default_value'  => 1,
  );

  $form['theme_settings']['favicon']['default_favicon'] = array(
    '#type'           => 'hidden',
    '#default_value'  => 1,
  );

  // Add our theme settings
  $form['doug_fir_options'] = array(
    '#type'  => 'fieldset',
    '#title' => t('OSU Theme options'),
  );




  // Variants
  $form['doug_fir_options']['variant'] = array(
    '#type'          => 'select',
    '#title'         => t('Theme Variant'),
    '#description'   => t($variant_text),
    '#options'       => $variants,
    '#default_value' => theme_get_setting('variant'),
  );

  foreach ($variants as $varname => $vartitle) {
    if (file_exists('./' . drupal_get_path('theme', 'doug_fir') . '/css/variants/' . $varname . '/' . $varname . '.inc')) {
      $form['doug_fir_options'][$varname][$varname . '_class'] = array(
      '#type'          => 'select',
      '#title'         => 'Customize variation with backgrounds and colors',
      '#default_value' => theme_get_setting($varname . '_class'),
      '#options'       => $backgrounds[$varname],
      );
    }
  }


  // Option - Use responsive layout
  $form['doug_fir_options']['responsive'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Use responsive layout.'),
    '#default_value' => theme_get_setting('responsive'),
    '#description'   => t('With this option the theme region widths will adjust based on the screen size. This is useful for mobile devices, but your content may need to be adjusted for it to work properly. Read more about <a href="//oregonstate.edu/cws/drupal/">OSU Responsive Themes"</a> (This page needs to be created)'),
  );

  // Option - Hide Breadcrumbs
  $form['doug_fir_options']['hide_breadcrumbs'] = array(
    '#type'          => 'checkbox',
    '#title'         => t("Don't display breadcrumbs."),
    '#default_value' => theme_get_setting('hide_breadcrumbs'),
    '#description'   => t('Do not display the breadcrumb trail at the top of the content area. Note that they will still show on admin pages.'),
  );

  // Option - Hide Book Navigation
  $form['doug_fir_options']['hide_book_nav'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Hide the book navigation links.'),
    '#default_value' => theme_get_setting('hide_book_nav'),
    '#description'   => t('Hide the prev, top, and next links at the bottom of a book page.'),
  );

  // Option - Hide Book Navigation
  $form['doug_fir_options']['full_screen'] = array(
      '#type'          => 'checkbox',
      '#title'         => t('Enable full screen (Pine)'),
      '#default_value' => theme_get_setting('full_screen'),
      '#description'   => t('Enables full screen mode. Only for Pine variant.'),
  );

  // Option - Hide Book Navigation
  $form['doug_fir_options']['new_top_hat'] = array(
      '#type'          => 'checkbox',
      '#title'         => t('2016 New Homepage Tophat'),
      '#default_value' => theme_get_setting('new_top_hat'),
      '#description'   => t('Enables the latest tophat based on the new homepage'),
  );

  // Option - Hide Taxonomy Terms
  $form['doug_fir_options']['hide_terms'] = array(
    '#type'          => 'checkbox',
    '#title'         => t('Hide Taxonomy Tags.'),
    '#default_value' => theme_get_setting('hide_terms'),
    '#description'   => t('Hide the display of taxonomy tags on all nodes.'),
  );

  // Option - Enter custom Google Analytics tracking code
  $form['doug_fir_options']['custom_ga_code'] = array(
    '#type'           => 'textfield',
    '#title'          => t('Custom Google Analytics Tracking Code'),
    '#default_value'  => theme_get_setting('custom_ga_code'),
    '#description'    => t('Enter a custom Google Analytics Tracking Code, or leave blank to use the default OSU code'),
  );

// Option - Parent site name
  $form['doug_fir_options']['parent_site_name'] = array(
    '#type'             => 'textfield',
    '#title'            => t('Parent Site Name'),
    '#default_value'    => theme_get_setting('parent_site_name'),
    '#description'      => t('Use this to have the parent site name show in the header above the site name.'),
  );

  // Option - Parent site url
  $form['doug_fir_options']['parent_site_url'] = array(
    '#type'             => 'textfield',
    '#title'            => t('Parent Site URL'),
    '#default_value'    => theme_get_setting('parent_site_url'),
    '#field_prefix'     => t('//'),
    '#description'      => t('If you added a parent site name above, use this field to create a link to it.'),
  );


  // Tophat Logos and Links (Cascades, etc...)
  $form['doug_fir_options']['site_logo'] = array(
    '#type'          => 'select',
    '#title'         => t('Alternate OSU Logos'),
    '#description'   => t('Various logos, '),
    '#options'       => drupal_map_assoc(array(t('OSU'), t('Cascades'))),
    '#default_value' => theme_get_setting('site_logo'),
  );

  // Option - Social Media
  $form['doug_fir_social_media'] = array(
    '#type'  => 'fieldset',
    '#title' => t('Social Media Links - Footer'),
  );

  $form['doug_fir_social_media']['facebook'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Facebook'),
    '#default_value' => theme_get_setting('facebook'),
    '#size'          => 60,
    '#maxlength'     => 127,
  );

  $form['doug_fir_social_media']['youtube-play'] = array(
    '#type'          => 'textfield',
    '#title'         => t('YouTube'),
    '#default_value' => theme_get_setting('youtube-play'),
    '#size'          => 60,
    '#maxlength'     => 127,
  );

  $form['doug_fir_social_media']['flickr'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Flickr'),
    '#default_value' => theme_get_setting('flickr'),
    '#size'          => 60,
    '#maxlength'     => 127,
  );

  $form['doug_fir_social_media']['linkedin'] = array(
    '#type'          => 'textfield',
    '#title'         => t('LinkedIn'),
    '#default_value' => theme_get_setting('linkedin'),
    '#size'          => 60,
    '#maxlength'     => 127,
  );

  $form['doug_fir_social_media']['twitter'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Twitter'),
    '#default_value' => theme_get_setting('twitter'),
    '#size'          => 60,
    '#maxlength'     => 127,
  );

  $form['doug_fir_social_media']['google-plus'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Google+'),
    '#default_value' => theme_get_setting('google-plus'),
    '#size'          => 60,
    '#maxlength'     => 127,
  );

  $form['doug_fir_social_media']['instagram'] = array(
    '#type'          => 'textfield',
    '#title'         => t('Instagram'),
    '#default_value' => theme_get_setting('instagram'),
    '#size'          => 60,
    '#maxlength'     => 127,
  );

  global $user;

  if ($user->uid != 1) {
   $form['doug_fir_options']['site_logo']['#disabled'] = true;
  }

  return $form;
}