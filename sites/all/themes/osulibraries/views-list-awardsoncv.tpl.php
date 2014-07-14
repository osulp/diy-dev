<?php
/**
 * views template to output one 'row' of a view.
 * This code was generated by the views theming wizard
 * Date: Wed, 01/30/2008 - 16:26
 * View: awardsoncv
 *
 * Variables available:
 * $view -- the entire view object. Important parts of this object are
 *   awardsoncv, .
 * $view_type -- The type of the view. Probably 'page' or 'block' but could
 *   also be 'embed' or other string passed in from a custom view creator.
 * $node -- the raw data. This is not a real node object, but will contain
 *   the nid as well as other support fields that might be necessary.
 * $count -- the current row in the view (not TOTAL but for this page) starting
 *   from 0.
 * $stripe -- 'odd' or 'even', alternating. * $field_year_value --
 * $field_year_value_label -- The assigned label for $field_year_value
 * $title -- Display the title of the node.
 * $title_label -- The assigned label for $title
 * $field_award_sponsor_value --
 * $field_award_sponsor_value_label -- The assigned label for $field_award_sponsor_value
 *
 * This function goes in your views-list-awardsoncv.tpl.php file
 */

 //now we add the stylesheet...
  //drupal_add_css(path_to_theme() .'/views-list-awardsoncv.css');
  ?>

  <?php if($field_year_value) print $field_year_value . ", ";
      print $title?>

<div class="view-field-field-award-sponsor-value">
  <?php if($field_award_sponsor_value) print $field_award_sponsor_value_label . " "; ?>
</div>
<div class="view-field view-data-field-award-sponsor-value">
  <?php print " " . $field_award_sponsor_value?>
</div>

