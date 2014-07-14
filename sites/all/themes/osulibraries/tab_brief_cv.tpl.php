<?php
/**
 * views template to output one 'row' of a view.
 * This code was generated by the views theming wizard
 * Date: Fri, 01/25/2008 - 21:46
 * View: tab_brief_cv
 *
 * Variables available:
 * $view -- the entire view object. Important parts of this object are
 *   tab_brief_cv, .
 * $view_type -- The type of the view. Probably 'page' or 'block' but could
 *   also be 'embed' or other string passed in from a custom view creator.
 * $node -- the raw data. This is not a real node object, but will contain
 *   the nid as well as other support fields that might be necessary.
 * $count -- the current row in the view (not TOTAL but for this page) starting
 *   from 0.
 * $stripe -- 'odd' or 'even', alternating. * $field_education_value --
 * $field_education_value_label -- The assigned label for $field_education_value
 * $field_research_interests_value --
 * $field_research_interests_value_label -- The assigned label for $field_research_interests_value
 * $field_works_in_progress_value --
 * $field_works_in_progress_value_label -- The assigned label for $field_works_in_progress_value
 * $type -- The Node Type field will display the type of a node (for example, 'blog entry', 'forum post', 'story', etc)
 * $type_label -- The assigned label for $type
 * $link -- This will create a link to the node; fill the option field with the text for the link. If you want titles that link to the node, use Node: Title instead.
 * $link_label -- The assigned label for $link
 * $field_full_cv_fid --
 * $field_full_cv_fid_label -- The assigned label for $field_full_cv_fid
 *
 * This function goes in your views-list-tab_brief_cv.tpl.php file
 */

  ?>
<?php if($field_education_value) {
  print '<div class="view-label view-field-field-education-value">';
  print $field_education_value_label;
  print '</div><div class="view-field view-data-field-education-value">';
  print $field_education_value;
  print '</div>';
}
if($field_research_interests_value) {
  print '<div class="view-label view-field-field-research-interests-value">';
  print $field_research_interests_value_label;
  print '</div><div class="view-field view-data-field-research-interests-value">';
  print $field_research_interests_value;
  print '</div>';
}
if($field_works_in_progress_value) {
  print '<div class="view-label view-field-field-works-in-progress-value">';
  print $field_works_in_progress_value_label;
  print '</div><div class="view-field view-data-field-works-in-progress-value">';
  print $field_works_in_progress_value;
  print '</div>';
}

    $view = views_get_view('awardsoncv');
    $awards = views_build_view('block', $view, $args = array(arg(1)));
    if($awards) print '<div class="view-label">Awards</div>' . $awards;


if($icap_value) {
  print '<div class="view-label view-field-field-icaps">';
  print $icap_label;
  print '</div><div class="view-field view-data-link">';
  print '<ul>'.$icap_value.'</ul>';
  print '</div>';
}

if($field_full_cv_fid != '<div class="field-item"></div>') {
  print '<div class="view-label view-field-field-full-cv-fid">';
  print $field_full_cv_fid_label;
  print '</div><div class="view-field view-data-field-full-cv-fid">';
  print $field_full_cv_fid;
  print '</div>';
}