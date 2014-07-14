<?php

/**
 * @file
 * Default theme implementation to display a node.
 *
 * Available variables:
 * - $title: the (sanitized) title of the node.
 * - $content: An array of node items. Use render($content) to print them all,
 *   or print a subset such as render($content['field_example']). Use
 *   hide($content['field_example']) to temporarily suppress the printing of a
 *   given element.
 * - $user_picture: The node author's picture from user-picture.tpl.php.
 * - $date: Formatted creation date. Preprocess functions can reformat it by
 *   calling format_date() with the desired parameters on the $created variable.
 * - $name: Themed username of node author output from theme_username().
 * - $node_url: Direct URL of the current node.
 * - $display_submitted: Whether submission information should be displayed.
 * - $submitted: Submission information created from $name and $date during
 *   template_preprocess_node().
 * - $classes: String of classes that can be used to style contextually through
 *   CSS. It can be manipulated through the variable $classes_array from
 *   preprocess functions. The default values can be one or more of the
 *   following:
 *   - node: The current template type; for example, "theming hook".
 *   - node-[type]: The current node type. For example, if the node is a
 *     "Blog entry" it would result in "node-blog". Note that the machine
 *     name will often be in a short form of the human readable label.
 *   - node-teaser: Nodes in teaser form.
 *   - node-preview: Nodes in preview mode.
 *   The following are controlled through the node publishing options.
 *   - node-promoted: Nodes promoted to the front page.
 *   - node-sticky: Nodes ordered above other non-sticky nodes in teaser
 *     listings.
 *   - node-unpublished: Unpublished nodes visible only to administrators.
 * - $title_prefix (array): An array containing additional output populated by
 *   modules, intended to be displayed in front of the main title tag that
 *   appears in the template.
 * - $title_suffix (array): An array containing additional output populated by
 *   modules, intended to be displayed after the main title tag that appears in
 *   the template.
 *
 * Other variables:
 * - $node: Full node object. Contains data that may not be safe.
 * - $type: Node type; for example, story, page, blog, etc.
 * - $comment_count: Number of comments attached to the node.
 * - $uid: User ID of the node author.
 * - $created: Time the node was published formatted in Unix timestamp.
 * - $classes_array: Array of html class attribute values. It is flattened
 *   into a string within the variable $classes.
 * - $zebra: Outputs either "even" or "odd". Useful for zebra striping in
 *   teaser listings.
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
 *   main body content.
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
<?php
drupal_add_js('jQuery(document).ready(function(){ jQuery(".node-digital-collection-landing-page .leaf").last().addClass("last-item"); });', 'inline');
?>
<div id="node-<?php print $node->nid; ?>" class="<?php print $classes; ?> clearfix"<?php print $attributes; ?>>

	<div class="row">
		<div class="span6">
			<div class="content">
				<ul class="menu">
				<li class="leaf">
				<?php print render($content['field_browse_link']); ?>
				</li>
				<li class="leaf">
				<?php print render($content['field_advanced_search_link']); ?>
				</li>
				<li class="leaf">
				<?php print render($content['field_my_favorites_link']); ?>
				</li>
				<li class="leaf">
				<?php print render($content['field_preferences_link']); ?>
				</li>
				<li class="leaf">
				<?php print render($content['field_help_link']); ?>
				</li>
				<li class="leaf">
				<?php print render($content['field_about_link']); ?>
				</li>
				</ul>
				<div class="feature_space">
					<?php
					$block = block_load('views', 'feature_story-block_2');
					print render(_block_get_renderable_array(_block_render_blocks(array($block))));
					?>
					<div class="overlay">
						<div class="search">
							<form method="GET" action="http://oregondigital.org/cdm4/results.php">
							<input type="hidden" name="CISOOP1" value="all">
							<input type="hidden" name="CISOFIELD1" value="CISOSEARCHALL">
							<input type="hidden" name="CISORESTMP" value="/cdm4/results.php">
							<input type="hidden" name="CISOVIEWTMP" value="/cdm4/item_viewer.php">
							<input type="hidden" name="CISOMODE" value="grid">
							<input type="hidden" name="CISOGRID" value="thumbnail,A,1;record,A,1;hidden,A,0;journa,A,0;descri,200,0;20;record,none,none,none,none">
							<input type="hidden" name="CISOBIB" value="record,A,1,N;hidden,A,0,N;title,200,0,N;none,A,0,N;none,A,0,N;20;record,none,none,none,none">
							<input type="hidden" name="CISOTHUMB" value="20 (4x5);record,none,none,none,none">
							<input type="hidden" name="CISOTITLE" value="20;record,none,none,none,none">
							<input type="hidden" name="CISOHIERA" value="20;hidden,record,none,none,none">
							<input name="CISOBOX1" value="Search Collection" type="text" onfocus="if(value=='Search Collection'){value=''};" onblur="value='Search Collection';">
							<input type="hidden" name="CISOROOT" value="<?php $path = explode('/',$_SERVER['REQUEST_URI']); print $path[2]; ?>">
							<input type="submit" value="Go" class="button">
							</form>
						</div>
						<?php
						print render($content['field_browse_search_boxes']);
						?>
					</div>
				</div>
			</div>
		</div>
		<div class="span5">
			<div class="content"<?php print $content_attributes; ?>>
			<?php print render($content['body']); ?>
			</div>
		</div>
	</div>
	<div class="row">
		<div class="span11">		
			<?php $block = block_load('views', 'clone_of_feature_story-block_3');
				print render(_block_get_renderable_array(_block_render_blocks(array($block)))); ?>	
		</div>
  </div>
</div>