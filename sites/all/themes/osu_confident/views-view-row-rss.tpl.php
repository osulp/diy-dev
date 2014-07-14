<?php
/**
* @file views-view-row-rss.tpl.php
* Default view template to display a item in an RSS feed.
*
* @ingroup views_templates
*/
?>
<item>
<title><?php print $title; ?></title>
<link><?php print $link; ?></link>
<description>
<![CDATA[
<?php
$desc = $node->teaser ? $node->teaser : $node->content['body']['#value'];
print nl2br(check_markup(trim(strip_tags($desc, '<p><br><a><b><i><u>'))));
?>
]]>
</description>
<?php print $item_elements; ?>
</item>
