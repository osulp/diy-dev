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
  $variants = $themes['doug_fir']->info['variants'];

  $variant_text = 'Select which theme variant you want to use: <br />' .
                  '&nbsp;&nbsp;<b>Doug Fir</b>&nbsp;&nbsp;&nbsp;&nbsp; - The new default Drupal 7 theme with a refreshed brand look. <br />' .
                  '&nbsp;&nbsp;<b>OSU Standard</b>&nbsp;&nbsp;&nbsp;&nbsp; - Matches the default Drupal 6 theme and OSU\'s home page. <br />' .
                  // '&nbsp;&nbsp;<b>Marine Sciences</b> - Includes blue colors and  marine iconography. <br />' .
                  '&nbsp;&nbsp;<b>College of Science</b> - For the College of Science and affiliated groups who wish to use it <br />' .
                  '&nbsp;&nbsp;<b>Honors College</b> - For the Honors College and affiliated groups who wish to use it <br />';

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

  // Option - Use responsive layout
  $form['doug_fir_options']['responsive'] = array(
      '#type'          => 'checkbox',
      '#title'         => t('Use responsive layout.'),
      '#default_value' => theme_get_setting('responsive'),
      '#description'   => t('With this option the theme region widths will adjust based on the screen size. This is useful for mobile devices, but your content may need to be adjusted for it to work properly. Read more about <a href="http://oregonstate.edu/cws/drupal/">OSU Responsive Themes"</a> (This page needs to be created)'),
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
    '#field_prefix'     => t('http://'),
    '#description'      => t('If you added a parent site name above, use this field to create a link to it.'),
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
  $form['doug_fir_social_media']['youtube'] = array(
      '#type'          => 'textfield',
      '#title'         => t('YouTube'),
      '#default_value' => theme_get_setting('youtube'),
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
  $form['doug_fir_social_media']['google'] = array(
      '#type'          => 'textfield',
      '#title'         => t('Google+'),
      '#default_value' => theme_get_setting('google'),
      '#size'          => 60,
      '#maxlength'     => 127,
      );


  return $form;
}
