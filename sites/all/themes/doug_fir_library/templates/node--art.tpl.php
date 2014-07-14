<?php
/**
* @file
* Default theme implementation to display a node.
*
* Available variables:
* - $title: the (sanitized) title of the node.
* - $content: An array of node items. Use render($content) to print them all,
* or print a subset such as render($content['field_example']). Use
* hide($content['field_example']) to temporarily suppress the printing of a
* given element.
* - $user_picture: The node author's picture from user-picture.tpl.php.
* - $date: Formatted creation date. Preprocess functions can reformat it by
* calling format_date() with the desired parameters on the $created variable.
* - $name: Themed username of node author output from theme_username().
* - $node_url: Direct URL of the current node.
* - $display_submitted: Whether submission information should be displayed.
* - $submitted: Submission information created from $name and $date during
* template_preprocess_node().
* - $classes: String of classes that can be used to style contextually through
* CSS. It can be manipulated through the variable $classes_array from
* preprocess functions. The default values can be one or more of the
* following:
* - node: The current template type; for example, "theming hook".
* - node-[type]: The current node type. For example, if the node is a
* "Blog entry" it would result in "node-blog". Note that the machine
* name will often be in a short form of the human readable label.
* - node-teaser: Nodes in teaser form.
* - node-preview: Nodes in preview mode.
* The following are controlled through the node publishing options.
* - node-promoted: Nodes promoted to the front page.
* - node-sticky: Nodes ordered above other non-sticky nodes in teaser
* listings.
* - node-unpublished: Unpublished nodes visible only to administrators.
* - $title_prefix (array): An array containing additional output populated by
* modules, intended to be displayed in front of the main title tag that
* appears in the template.
* - $title_suffix (array): An array containing additional output populated by
* modules, intended to be displayed after the main title tag that appears in
* the template.
*
* Other variables:
* - $node: Full node object. Contains data that may not be safe.
* - $type: Node type; for example, story, page, blog, etc.
* - $comment_count: Number of comments attached to the node.
* - $uid: User ID of the node author.
* - $created: Time the node was published formatted in Unix timestamp.
* - $classes_array: Array of html class attribute values. It is flattened
* into a string within the variable $classes.
* - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
* teaser listings.
* - $id: Position of the node. Increments each time it's output.
*
* Node status variables:
* - $view_mode: View mode; for example, "full", "teaser".
* - $teaser: Flag for the teaser state (shortcut for $view_mode == 'teaser').
* - $page: Flag for the full page state.
* - $promote: Flag for front page promotion state.
* - $sticky: Flags for sticky post setting.
* - $status: Flag for published status.
* - $comment: State of comment settings for the node.
* - $readmore: Flags true if the teaser content of the node cannot hold the
* main body content.
* - $is_front: Flags true when presented in the front page.
* - $logged_in: Flags true when the current user is a logged-in member.
* - $is_admin: Flags true when the current user is an administrator.
*
* Field variables: for each field instance attached to the node a corresponding
* variable is defined; for example, $node->body becomes $body. When needing to
* access a field's raw values, developers/themers are strongly encouraged to
* use these variables. Otherwise they will have to explicitly specify the
* desired field language; for example, $node->body['en'], thus overriding any
* language negotiation rule that was previously applied.
*
* @see template_preprocess()
* @see template_preprocess_node()
* @see template_process()
*
* @ingroup themeable
*/
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>
<?php print $user_picture; ?>
<?php print render($title_prefix); ?>
<?php if (!$page): ?>
<h2<?php print $title_attributes; ?>><a href="<?php print $node_url; ?>"><?php print $title; ?></a></h2>
<?php endif; ?>
<?php print render($title_suffix); ?>
<?php if ($display_submitted): ?>
<div class="submitted">
<?php print $submitted; ?>
</div>
<?php endif; ?>
<div class="content"<?php print $content_attributes; ?>>
<!-- node template ends -->


<div id="body" class="nocallout"><div id="border">
<?php

drupal_add_css(drupal_get_path('theme', $GLOBALS['theme']) . '/css/art.css','file');
print '<p><a href="/nwart">Back to NW Art Exhibit homepage</a></p>';

print '<div id="art"><div id="prev_art">';

// previous image (round current loc down because floats are imprecise)
//$result = db_query_range('SELECT n.nid,p.field_photo_fid FROM {content_type_art} n INNER JOIN {content_field_photo} p 
//ON n.nid = p.nid WHERE n.field_loc_value<%f ORDER BY n.field_loc_value DESC', floatval($node->field_loc[0]['view'])-0.05, 0, 1);
$query = db_select('content_type_art', 'n');
$query->join('content_field_photo', 'p', 'p.nid = n.nid');
$query->fields('n', array('nid'));
$query->fields('p', array('field_photo_fid'));
$query->condition('n.field_loc_value', floatval($node->field_loc['und'][0]['value'])-0.05, '<');
$query->orderBy('n.field_loc_value', 'DESC');
$query->range(0,1);
$result = $query->execute();

//$prevnode = db_fetch_object($result);
foreach($result as $r) {
	$prevnode = $r;
}
if (!empty($prevnode)) {
	$prev = node_load($prevnode->nid);
	print '<strong>Previous</strong><br /><a href="/'. drupal_lookup_path('alias',"node/".$prevnode->nid) .'"><img src="/sites/all/themes/doug_fir_library/images/resize.php?w=100&h=75&image=sites/default/files/' . $prev->field_photo['und'][0]['filename'] . '" alt="Thumbnail" /></a><br /><em>' . $prev->title . '</em><br />' . $prev->field_artist_first['und'][0]['value'] . ' ' . $prev->field_artist['und'][0]['value'];
}
else {print "&nbsp;";}

// current image
print '</div><div id="current_art">' . render($content['field_photo']) . '</div><div id="next_art">';

// next image (round current loc up because floats are imprecise)
//$result = db_query_range('SELECT n.nid,p.field_photo_fid FROM {content_type_art} n INNER JOIN {content_field_photo} p ON n.nid = p.nid 
//WHERE n.field_loc_value>%f ORDER BY n.field_loc_value ASC', floatval($node->field_loc[0]['view'])+0.05, 0, 1);
$query = db_select('content_type_art', 'n');
$query->join('content_field_photo', 'p', 'p.nid = n.nid');
$query->fields('n', array('nid'));
$query->fields('p', array('field_photo_fid'));
$query->condition('n.field_loc_value', floatval($node->field_loc['und'][0]['value'])+0.05, '>');
$query->orderBy('n.field_loc_value', 'ASC');
$query->range(0,1);
$result = $query->execute();

//$nextnode = db_fetch_object($result);
foreach ($result as $r) {
	$nextnode = $r;
}
if (!empty($nextnode)) {
	$next = node_load($nextnode->nid);
	print '<strong>Next</strong><br /><a href="/'. drupal_lookup_path('alias',"node/".$nextnode->nid) .'"><img src="/sites/all/themes/doug_fir_library/images/resize.php?w=100&h=75&image=sites/default/files/' . $next->field_photo['und'][0]['filename'] . '" alt="Thumbnail" /></a><br /><em>' . $next->title . '</em><br />' . $next->field_artist_first['und'][0]['value'] . ' ' . $next->field_artist['und'][0]['value'];
} else {print "&nbsp;";}

print '</div><div id="art_desc">' . render($content['body']) . '</div>';




$fullname = $node->field_artist_first['und'][0]['value'] . ' ' . $node->field_artist['und'][0]['value'];

//$result = db_query_range('SELECT n.nid FROM {node_revisions} n WHERE n.title LIKE "%s"', $fullname, 0, 1);
$query = db_select('node_revision', 'n');
$query->fields('n', array('nid'));
$query->condition('n.title', $fullname, 'LIKE');
$query->range(0,1);
$result = $query->execute();

//$bio = db_fetch_object($result);
foreach ($result as $r) {
	$bio = $r;
}

if (!empty($bio)) {
	$artist = drupal_lookup_path('alias','node/'.$bio->nid);
}

print '</div><p><strong>Artist</strong>: ';
if(!empty($artist)) {print '<a href="/' . $artist . '">';}
print $fullname;
if(!empty($artist)) {print '</a>';}
if (!empty($node->field_website['und'][0]['value'])) {print " (".$node->field_website['und'][0]['value'].")";}
print '</p>';


print '<p><strong>Medium:</strong> ' . $node->field_medium['und'][0]['value'];
if (!empty($node->field_medium_specific['und'][0]['value'])) {print ' (' . $node->field_medium_specific['und'][0]['value'] . ')';}
print '</p>';

if (!empty($node->field_dimensions['und'][0]['value'])) {print '<p><strong>Dimensions:</strong> ' . str_replace('x','&times;',$node->field_dimensions['und'][0]['value']) . '</p>';}

print '<p><strong>Location:</strong> ';

//$floor = explode(" ",$node->field_floor['und'][0]['value']);
$floor = $node->field_floor['und'][0]['value'];
//if ($floor[1]=="floor") {
if (!empty($floor)) {
        //$results = db_query(db_rewrite_sql("SELECT n.nid FROM {content_type_floormap} n WHERE (n.field_maptype_value = 'nwart' AND n.field_floornum_value = " . $node->field_floor[0]['value'] . ")"));
         $query = db_select('content_type_floormap', 'f');
         $query->fields('f', array('nid'));
        	$query->condition('field_maptype_value', 'nwart');
        	$query->condition('field_floornum_value', $floor);
        $results = $query->execute();
        //while($nid = db_result($results)) {
        while($nid = $results->fetchField()) {             
             $map = node_load($nid);
             print '<a href="/sites/default/files/floormaps/large/' . $map->field_large_map['und'][0]['filename'] . '">' . $floor . ' floor</a>, #' . $node->field_loc['und'][0]['value'] . ' on the map</p>';
        }
	//print '<a href="http://osulibrary.oregonstate.edu/libraries_and_collections/art/floors/' . strtolower($floor[0]) . '.html">' . $floor[0] . ' floor</a>, #' . $node->field_loc[0]['view'] . ' on the map</p>';
} else {
	print 'This piece is no longer on display.</p>';
}

if (!empty($node->field_series['und'][0]['value'])) {print "<p><strong>Series:</strong> " . $node->field_series['und'][0]['value'] . '</p>';}

?>
</div></div>



<!-- node template -->
</div>

</div> 