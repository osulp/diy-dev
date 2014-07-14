<?php
/**
 * views template to output one 'row' of a view.
 * This code was generated by the views theming wizard
 * Date: Wed, 01/30/2008 - 20:48
 * View: staff_contact_for
 *
 * Variables available:
 * $view -- the entire view object. Important parts of this object are
 *   staff_contact_for, .
 * $view_type -- The type of the view. Probably 'page' or 'block' but could
 *   also be 'embed' or other string passed in from a custom view creator.
 * $node -- the raw data. This is not a real node object, but will contain
 *   the nid as well as other support fields that might be necessary.
 * $count -- the current row in the view (not TOTAL but for this page) starting
 *   from 0.
 * $stripe -- 'odd' or 'even', alternating. * $field_contact_me_value --
 * $field_contact_me_value_label -- The assigned label for $field_contact_me_value
 *
 * This function goes in your views-list-staff_contact_for.tpl.php file
 */


 //now we add the stylesheet...
  //drupal_add_css(path_to_theme() .'/views-list-staff_contact_for.css');

  ?>
<div class="view-label view-field-field-contact-me-value">
  <?php if($field_contact_me_value) print $field_contact_me_value_label ?>
</div>
<div class="view-field view-data-field-contact-me-value">
  <?php print $field_contact_me_value?>
</div>
