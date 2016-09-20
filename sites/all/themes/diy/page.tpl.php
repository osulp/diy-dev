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

                    </div><!-- /content-group -->
                    <?php print render($page['sidebar_second']); ?>

                  </div><!-- /main-content-inner -->
                </div><!-- /main-content -->

                <?php print render($page['postscript_top']); ?>

              </div><!-- /main-group-inner -->
            </div><!-- /main-group -->

            <div class="license">
              <div class="license_img">
                <a href="http://creativecommons.org/licenses/by-sa/2.5/"><img src="<?php print drupal_get_path('theme', 'diy'); ?>/images/cc_attribution_sharealike.png" alt="Credits" height="31" width="88" /></a>
              </div>
              <div class="license_credit">
                OSU's Library DIY is adapted from the Library DIY project created by Meredith Farkas, Amy Hofer, Lisa Molinelli and Kimberly Willson-St. Clair at Portland State University Library.
                  Many thanks to them for making the <a href="https://github.com/pdxlibrary/Library-DIY">source code</a> available. </ br>
              </div>
            </div>

          </div><!-- /main-inner -->
          <!-- CUSTOM FOOTER GOES HERE -->
        </div><!-- /main -->
      </div><!-- /main-wrapper -->
      <?php print render($page['postscript_bottom']); ?>

    </div><!-- /page-inner -->
  </div><!-- /page -->
  <!-- Page Footer -->

<!--  <div id='footer-osul'>-->
<!--    <div class='container'>-->
<!--      <div class='row'>-->
<!---->
<!--        <div class="span0 social-media">-->
<!--          <a class="flickr" href="http://www.flickr.com/photos/osuvalleylibrary" title="Flickr">Flickr</a>-->
<!--          <a class="fb" href="http://www.facebook.com/pages/Corvallis-OR/The-Valley-Library/5913513878?ref=ts" title="Facebook">Facebook</a>-->
<!--          <a class="twitter" href="http://www.twitter.com/osuvalleylib" title="Twitter">Twitter</a>-->
<!--        </div>-->
<!---->
<!--        <div class='span9'>-->
<!--          --><?php //print render($page['footer']); ?>
<!--        </div>-->
<!---->
<!---->
<!--      </div>-->
<!--    </div>-->
<!--  </div>-->
<div id='footer'>
  <div class='container-fluid'>
    <div class='row-fluid'>
      <div class='span2 contact'>
        <h2>Contact Info</h2>
        <div class="specific-contact">
          <p>121 The Valley Library<br />Corvallis OR 97331–4501</p><p>Phone: 541-737-3331</p><p><a href="http://answers.library.oregonstate.edu/ask">Contact Us</a></p><p><a href="/accessibility-services">Services for Persons with Disabilities</a></p>            </div>
        <div class="general-contact">
          <a href="http://oregonstate.edu/copyright">Copyright</a>
          &copy;2016              Oregon State University<br />
          <a href="http://oregonstate.edu/disclaimer">Disclaimer</a>
        </div>
        <div class="social-media"><a href="http://www.facebook.com/pages/Corvallis-OR/The-Valley-Library/5913513878?ref=ts" title="Go to our Facebook page"><i class="icon-facebook"></i> Facebook</a><a href="http://www.flickr.com/photos/osuvalleylibrary" title="Go to our Flickr page"><i class="icon-flickr"></i> Flickr</a><a href="http://www.twitter.com/osuvalleylib" title="Go to our Twitter page"><i class="icon-twitter"></i> Twitter</a></div>
      </div>
      <div class='span10'>
        <div class="region region-footer">
          <div id="block-block-381" class="block block-block footer-links">
            <div class="content">
              <div id="osul-footer-left">
                <div class="content">
                  <h2>In The Valley Library</h2>
                  <ul class="menu">
                    <li class="first leaf"><a href="//www.osupress.oregonstate.edu/">Oregon State University Press</a></li>
                    <li class="leaf"><a href="//cdss.library.oregonstate.edu">Center for Digital Scholarship and Services</a></li>
                    <li class="leaf"><a href="//scarc.library.oregonstate.edu">Special Collections and Archives Research Center</a></li>
                    <li class="leaf"><span class="separator"><hr /></span></li>
                    <li class="leaf"><a href="/clc">Collaborative Learning Center</a></li>
                    <li class="leaf"><a href="//oregonstate.edu/is/mediaservices/sms/">Student Multimedia Services</a></li>
                    <li class="leaf"><a href="/nwart">Northwest Art Exhibit</a></li>
                  </ul>
                </div>
              </div>
              <div id="osul-footer-right">
                <div class="content">
                  <h2>Digital Projects</h2>
                  <ul class="menu">
                    <li class="first leaf"><a href="//oregonexplorer.info">Oregon Explorer</a></li>
                    <li class="leaf"><a href="//oregondigital.org">Oregon Digital</a></li>
                    <li class="leaf"><a href="//ir.library.oregonstate.edu">ScholarsArchive@OSU</a></li>
                    <li class="leaf"><a href="//dpi.library.oregonstate.edu">Digital Publishing Initiatives</a></li>
                  </ul>
                </div>
                <div class="content">
                  <h2>Branches</h2>
                  <ul class="menu">
                    <li class="leaf"><a href="//guin.library.oregonstate.edu">Marilyn Potts Guin Library</a></li>
                    <li class="last leaf"><a href="//blogs.oregonstate.edu/cascadeslibrary/">Cascades Campus Library</a></li>
                  </ul>
                </div>
              </div>  </div>
          </div>
          <div id="block-block-378" class="block block-block footer-gift">
            <div class="content">
              <p><a class="gift-btn" href="https://adminlb.imodules.com/s/359/foundation/index.aspx?sid=359&amp;gid=34&amp;pgid=1982&amp;cid=3007" target="_blank"><em class="icon-gift"></em> Make a Gift</a></p>  </div>
          </div>
          <div id="block-block-384" class="block block-block">
            <div class="content">
              <p><img src="/sites/default/files/fdlp-emblem-color.png" alt="FDLP Emblem" width="45" height="40" />  <a href="http://guides.library.oregonstate.edu/subject-guide/286-Government-Information">Federal Depository Library Program</a></p>  </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>