<?php

/**
 * @file
 * Default simple view template to display a list of rows.
 *
 * @ingroup views_templates
 */
?>
<?php if (!empty($title)): ?>
  <div class="biblio-separator-bar">
  <?php print $title; ?>
  </div>
  <?php //dpm($title); ?>
<?php endif; ?>
<?php foreach ($rows as $id => $row): ?>
  <div class="biblio-entry">
  <div<?php if ($classes_array[$id]) { print ' class="' . $classes_array[$id] .'"';  } ?>>
    <?php print $row; ?>
  </div>
  </div>
<?php endforeach; ?>