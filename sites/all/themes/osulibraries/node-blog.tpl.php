<?php drupal_add_css("sites/all/themes/osulibraries/blog.css"); ?>
		
<div class="node <?php print $node_classes ?>" id="node-<?php print $node->nid; ?>"><div class="node-inner">

<?php if ($page == 0): ?>
	<h2 class="title">
		<a href="<?php print $node_url; ?>"><?php print str_replace("deiteria's blog", "DIY Research", $title); ?></a>
	</h2>
<?php endif; ?>

<div class="meta">

	<?php print format_date($node->created, 'custom', 'j F Y'); ?>

	| 

	<?php
	if ($terms) {
			if (arg(0) == 'node' && is_numeric(arg(1)) && is_null(arg(2))) {
			$result = db_query('SELECT uid FROM {node} WHERE nid = %d ORDER BY uid DESC', arg(1)); // search node author in full view mode
			$user = db_fetch_object($result);
			$uid = $user->uid;
			$nid = (int)arg(1);
		} else {
			$result = db_query('SELECT uid FROM {node} WHERE nid = %d ORDER BY uid DESC', $node->nid); // search node author when you are in the blog home (/blog/6)
			$user = db_fetch_object($result);
			$uid = $user->uid;
			$nid = $node->nid;
		}
	}

	$terms = taxonomy_node_get_terms($nid);
	$output = '';
	foreach($terms as $term) {
		$output .= "<a href=\"/blogterms/". $uid . "/". $term->tid . "\">". $term->name . "</a>, ";
	}
	$output = rtrim($output, ', ');
	print t('Filed under: ') . $output;
	?>

	<?php if ($links) {print str_replace(">deiteria&#039;s blog<", ">DIY Research<", $links);} ?>
</div>


<?php if ($picture) print $picture; ?>

<?php
	/* if ($submitted): ?>
		<div class="submitted">
			< ?php print $submitted; ?>
		</div>
	<?php endif; */
?>


<div class="content">
	<?php print $content; ?>
</div>

</div></div> <!-- /node-inner, /node -->