<div id="views-bootstrap-tab-<?php print $id ?>" class="<?php print $classes ?>">
  <ul class="nav nav-<?php print $tab_type?>">
    <?php foreach ($tabs as $key => $tab): ?>
     <?php
     /*
     $term_name = $tab;
     if ($vocabulary = taxonomy_vocabulary_machine_name_load("digital_publishing_categories")) {
       $tree = taxonomy_get_tree($vocabulary->vid);
       foreach ($tree as $term) {
         if ($term->name == $term_name) {
           //dpm($term->tid);
           $tid = $term->tid;
         }
       }
     }*/
     ?>
     <li class="<?php if ($key === 0) print 'active'?>">
       <a href="#tab-<?php print "{$id}-{$key}" ?>" data-toggle="tab"><?php print $tab ?></a>
     </li>
    <?php endforeach ?>
  </ul>
  <div class="tab-content">
    <?php foreach ($rows as $key => $row): ?>
    <?php //dpm($row); ?>
    <?php 
				//dpm($column['content']);
				$string = $row;
				@$htmlDom = DOMDocument::loadHTML($string); // Or file, w/e
				if ($htmlDom) {
					$test = simplexml_import_dom($htmlDom);
					$tid = (string)$test->body->div[0]->span;
					//$catid = (string)$test->body->div[1]->span;
					//$catname = (string)$test->body->div[2]->span;
					$termId = 'tid-'.$tid;
					//dpm($nodeid);
					//dpm($catname);
					//dpm($catid);
					//$items = array();
					//$items[] = $nodeid;
					//$items[] = $catid;
					//$items[] = $catname;

					//dpm($thumbnailId);
				}
			?>
      <div class="tab-pane <?php if ($key === 0) print 'active'?>" id="tab-<?php print "{$id}-{$key}" ?>">
        <?php print $row ?>
        <div class="projects-listing" id="<?php print "{$termId}" ?>">
        	<h2>Projects</h2>
        </div>
      </div>
      
    <?php endforeach ?>
  </div>
</div>
