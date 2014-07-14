<?php
 /**
  * This template is used to print a single field in a view. It is not
  * actually used in default Views, as this is registered as a theme
  * function which has better performance. For single overrides, the
  * template is perfectly okay.
  *
  * Variables available:
  * - $view: The view object
  * - $field: The field handler object that can process the input
  * - $row: The raw SQL result that can be used
  * - $output: The processed output that will normally be used.
  *
  * When fetching output from the $row, copy and paste the following snippet:
  * $data = $row->{$field->field_alias}
  *
  * The above will guarantee that you'll always get the correct data,
  * regardless of any changes in the aliasing that might happen if
  * the view is modified.
  */
?>
<?php

global $user;
$node = node_load($row->nid);

if(user_is_logged_in()) {
	if ($node->type == 'rdm_entry_private') {
		if (in_array('super-user', array_values($user->roles)) ||
			in_array('rdm', array_values($user->roles)) ||
			in_array('rdm_menu_admin', array_values($user->roles))) {
			print $output;
		} else {
			print '[private content]';
		}
	} else {
		print $output;
	}
		
} else {
	if ($node->type == 'rdm_entry_public') {
		print $output;
	} else {
		print '[please log in to view]';
	}
}

?>