<?php
?>
<!-- Top-Hat -->
<div class = "osu-top-hat-render">
<?php
  if (function_exists('osu_top_hat_render')) {
    print osu_top_hat_render();
  }
  $site_name = variable_get('site_name');
  $base_path= variable_get('base_path');
?>
</div>

<div id="mobile-icon-menu">
  <a href='#' id="toggle-mobile-menu" class="m-icon-link"><i class="icon-reorder"></i></a>
  <a href='<?php echo $base_path; ?>search/osul' id="mobile-search-link" class="m-icon-link"><i class="icon-search"></i></a>
</div>

  <div id="page" class="page container">

    <?php
    /*
        //$audience_menu = menu_tree_all_data('audience-menu', '', 2);
        $main_menu = menu_tree_all_data('menu-menu-osul', '', 2);
        $tophat_menu = menu_tree_all_data('osu-top-hat', '', 1);
        if ( !empty($main_menu) || !empty($tophat_menu) ) {
          echo '<ul id="mobile-menu">';
            if (!empty($main_menu) ) {
              echo '<li id="mobile-main-menu">';
              $output = menu_tree_output($main_menu);
                print render($output);
              echo '</li>';
            }

           echo '</ul>';
          }
          */
     ?>


    <h1><a href='http://osulibrary.oregonstate.edu/<?php //print $base_path; ?>'><?php print $site_name; ?></a></h1>

    <div id="page-inner" class="page-inner">
      <?php print render($page['header_top']); ?>

      <!-- header-group region: width = grid_width -->
      <div id="header-group-wrapper" class="header-group-wrapper full-width clearfix">
        <div id="header-group" class="header-group region <?php print $grid_width; ?>">
          <div id="header-group-inner" class="header-group-inner inner clearfix">
		    <!-- CUSTOM HEADER GOES HERE -->
            <?php print render($page['header']); ?>
          </div><!-- /header-group-inner -->
        </div><!-- /header-group -->
      </div><!-- /header-group-wrapper -->

      <?php print render($page['main_menu']); ?>
      <?php print render($page['preface_top']); ?>

      <!-- main region: width = grid_width -->
      <div id="main-wrapper" class="main-wrapper full-width clearfix">
        <div id="main" class="main region <?php print $grid_width; ?>">
          <div id="main-inner" class="main-inner inner clearfix">
            <?php if ($is_front == TRUE): ?>
              <div id="breadcrumbs" class="breadcrumbs block">
                <div id="breadcrumbs-inner" class="breadcrumbs-inner gutter">
                  <h2 class="element-invisible">You are here</h2>
                </div><!-- /breadcrumbs-inner -->
              </div>
            <?php else: ?>
              <?php print theme('grid_block', array('content' => $breadcrumb, 'id' => 'breadcrumbs')); ?>
            <?php endif; ?>
            <?php print render($page['sidebar_first']); ?>

            <!-- main group: width = grid_width - sidebar_first_width -->
            <div id="main-group" class="main-group region nested <?php print $main_group_width; ?>">
              <div id="main-group-inner" class="main-group-inner inner">
                <?php print render($page['preface_bottom']); ?>

                <div id="main-content" class="main-content region nested">
                  <div id="main-content-inner" class="main-content-inner inner">
                    <!-- content group: width = grid_width - sidebar_first_width - sidebar_second_width -->
                    <div id="content-group" class="content-group region nested <?php print $content_group_width; ?>">
                      <div id="content-group-inner" class="content-group-inner inner">
                        <?php print theme('grid_block', array('content' => $messages, 'id' => 'content-messages')); ?>

                        <div id="content-region" class="content-region region nested">
                          <div id="content-region-inner" class="content-region-inner inner">
                            <a id="main-content-area"></a>
                            <?php print theme('grid_block', array('content' => render($tabs), 'id' => 'content-tabs')); ?>
                            <?php print render($page['help']); ?>
                            <?php print render($title_prefix); ?>
                            <?php if ($title): ?>
                            <h1 class="title gutter"><?php print $title; ?></h1>
                            <?php endif; ?>
                            <?php print render($title_suffix); ?>
                            <?php if ($action_links): ?>
                            <ul class="action-links"><?php print render($action_links); ?></ul>
                            <?php endif; ?>
                            <?php if ($page['content']): ?>
                              <?php print render($page['content']); ?>
                            <?php endif; ?>
                          </div><!-- /content-region-inner -->
                        </div><!-- /content-region -->

                      </div><!-- /content-group-inner -->
                      <div class="license">
                        OSU's Library DIY is adapted from the Library DIY project created by Meredith Farkas, Amy Hofer, Lisa Molinelli and Kimberly Willson-St. Clair at Portland State University Library.
                        Many thanks to them for making the <a href="https://github.com/pdxlibrary/Library-DIY">source code</a> available. </ br>

                        <a href="http://creativecommons.org/licenses/by-sa/2.5/">Creative Commons Attribution - Sharealike license</a>
                      </div>
                    </div><!-- /content-group -->
                    <?php print render($page['sidebar_second']); ?>

                  </div><!-- /main-content-inner -->
                </div><!-- /main-content -->

                <?php print render($page['postscript_top']); ?>

              </div><!-- /main-group-inner -->
            </div><!-- /main-group -->



          </div><!-- /main-inner -->
          <!-- CUSTOM FOOTER GOES HERE -->
        </div><!-- /main -->
      </div><!-- /main-wrapper -->
      <?php print render($page['postscript_bottom']); ?>

    </div><!-- /page-inner -->
  </div><!-- /page -->
  <!-- Page Footer -->

  <div id='footer-osul'>
    <div class='container'>
      <div class='row'>

        <div class="span0 social-media">
          <a class="flickr" href="http://www.flickr.com/photos/osuvalleylibrary" title="Flickr">Flickr</a>
          <a class="fb" href="http://www.facebook.com/pages/Corvallis-OR/The-Valley-Library/5913513878?ref=ts" title="Facebook">Facebook</a>
          <a class="twitter" href="http://www.twitter.com/osuvalleylib" title="Twitter">Twitter</a>
        </div>

        <div class='span9'>
          <?php print render($page['footer']); ?>
        </div>


      </div>
    </div>
  </div>
