<?php if (!empty($title)): ?>
  <h3><?php print $title ?></h3>
<?php endif ?>

<div id="views-bootstrap-accordion-<?php print $id ?>" class="<?php print $classes ?>">
  <?php foreach ($rows as $key => $row): ?>
    <?php if (isset($titles[$key])): ?>
      <div class="accordion-group">
        <div class="accordion-heading">
          <a class="accordion-toggle"
            data-toggle="collapse"
            data-parent="#views-bootstrap-accordion-<?php print $id ?>"
            href="#collapse-<?php print $id . '-' . $key ?>">
            <?php print $titles[$key] ?>
          </a>
        </div>
  
        <div id="collapse-<?php print $id . '-' . $key ?>" class="accordion-body collapse">
          <div class="accordion-inner">
            <?php print $row ?>
          </div>
        </div>
      </div>
    <?php endif ?>
  <?php endforeach ?>
</div>
