<?php
// $Id: page.tpl.php,v 1.14.2.6 2009/02/13 16:28:33 johnalbin Exp $

/**
 * @file page.tpl.php
 *
 * Theme implementation to display a single Drupal page.
 *
 * Available variables:
 *
 * General utility variables:
 * - $base_path: The base URL path of the Drupal installation. At the very
 *   least, this will always default to /.
 * - $css: An array of CSS files for the current page.
 * - $directory: The directory the theme is located in, e.g. themes/garland or
 *   themes/garland/minelli.
 * - $is_front: TRUE if the current page is the front page. Used to toggle the mission statement.
 * - $logged_in: TRUE if the user is registered and signed in.
 * - $is_admin: TRUE if the user has permission to access administration pages.
 *
 * Page metadata:
 * - $language: (object) The language the site is being displayed in.
 *   $language->language contains its textual representation.
 *   $language->dir contains the language direction. It will either be 'ltr' or 'rtl'.
 * - $head_title: A modified version of the page title, for use in the TITLE tag.
 * - $head: Markup for the HEAD section (including meta tags, keyword tags, and
 *   so on).
 * - $styles: Style tags necessary to import all CSS files for the page.
 * - $scripts: Script tags necessary to load the JavaScript files and settings
 *   for the page.
 * - $body_classes: A set of CSS classes for the BODY tag. This contains flags
 *   indicating the current layout (multiple columns, single column), the current
 *   path, whether the user is logged in, and so on.
 * - $body_classes_array: An array of the body classes. This is easier to
 *   manipulate then the string in $body_classes.
 *
 * Site identity:
 * - $front_page: The URL of the front page. Use this instead of $base_path,
 *   when linking to the front page. This includes the language domain or prefix.
 * - $site_name: The name of the site, empty when display has been disabled
 *   in theme settings.
 *   in theme settings.
 * - $mission: The text of the site mission, empty when display has been disabled
 *   in theme settings.
 *
 * Navigation:
 * - $search_box: HTML to display the search box, empty if search has been disabled.
 * - $primary_links (array): An array containing primary navigation links for the
 *   site, if they have been configured.
 * - $secondary_links (array): An array containing secondary navigation links for
 *   the site, if they have been configured.
 *
 * Page content (in order of occurrance in the default page.tpl.php):
 * - $left: The HTML for the left sidebar.
 *
 * - $breadcrumb: The breadcrumb trail for the current page.
 * - $title: The page title, for use in the actual HTML content.
 * - $help: Dynamic help text, mostly for admin pages.
 * - $messages: HTML for status and error messages. Should be displayed prominently.
 * - $tabs: Tabs linking to any sub-pages beneath the current page (e.g., the view
 *   and edit tabs when displaying a node).
 *
 * - $content: The main content of the current Drupal page.
 *
 * - $right: The HTML for the right sidebar.
 *
 * Footer/closing data:
 * - $feed_icons: A string of all feed icons for the current page.
 * - $footer_message: The footer message as defined in the admin settings.
 * - $footer : The footer region.
 * - $closure: Final closing markup from any modules that have altered the page.
 *   This variable should always be output last, after all other dynamic content.
 *
 * @see template_preprocess()
 * @see template_preprocess_page()
 */
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?php print $language->language; ?>" lang="<?php print $language->language; ?>" dir="<?php print $language->dir; ?>">

<head>
  <title><?php print $head_title; ?> | Oregon State University</title>
 <?php print $head; ?>
  <link type="text/css" rel="stylesheet" media="all" href="http://oregonstate.edu/tools/css/yui/2.7.0/reset-fonts-grids.css" />
  <link type="text/css" rel="stylesheet" media="all" href="http://oregonstate.edu/tools/css/osu-base/0.2-beta/osu-base.css" />
  <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css"/>

  <?php
	// Top Hat CSS
	include ('http://oregonstate.edu/u_central/top-hat/osu-standard.php?secure=1&domain=osulibrary.oregonstate.edu&site_name=OSU%20Libraries&render=css');
  ?>
  <?php echo drupal_get_css($css); ?>
    <!-- iepngfix to fix png images in IE -->
    <!-- MUST ALSO CHANGE PATH in iepngfix/iepngfix.htc TO FIX BROKEN IMGs -->
    <!-- style type="text/css">
		 { behavior: url(<?php echo base_path().path_to_theme() ?>/iepngfix/iepngfix.htc) }
    </style-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js" type="text/javascript"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js" type="text/javascript"></script>
<script type="text/javascript">
  var jq = jQuery.noConflict();
</script>

  <?php
	// Top Hat JS
	print $scripts;
    //include ('http://oregonstate.edu/u_central/top-hat/osu-standard.php?secure=1&domain=osulibrary.oregonstate.edu&site_name=OSU%20Libraries%20University&render=js&jquery=1');
  ?>

 <script type="text/javascript">
		Drupal.behaviors.myModuleBehavior = function (context) {
			$('#header li').hover(function() {
				$(this).addClass('ie-hover');
			}, function() {
				$(this).removeClass('ie-hover');
			});
		};
	</script>

</head>
<body class="<?php print $body_classes; ?>">
<!--[if IE 6]>
<div id="ie6" class="iefix">
<![endif]-->
<!--[if IE 7]>
<div id="ie7" class="iefix">
<![endif]-->

	<!-- START DRUPAL NAV LINK -->
	<div><a name="top" id="navigation-top"></a></div>
    <div id="skip-to-nav">
        <a href="#navigation">
            <?php print t('Skip to Navigation'); ?>
        </a>
    </div>
	<!-- END DRUPAL NAV LINK -->

	<?php
		// Top Hat Display
		// print osu_new_top_hat()
		include ('http://oregonstate.edu/u_central/top-hat/osu-standard.php?secure=1&domain=osulibrary.oregonstate.edu&site_name=OSU%20Libraries&search_box=0&border_color=561f4b&render=hat');
		print $top_hat;
	?>

	<div id="top-bg" <?php print osu_confident_background();?>>
	<!-- START YUI GRID DOCUMENT TYPE DEFINITION - checks for left content, if there is, adds the defnition for YUI document class t2 -->
	<div id="doc4"<?php if($left) print ' class="yui-t2"' ?>>
	<!-- END YUI GRID DOCUMENT TYPE DEFINITION -->

		<div id="page">
			<div id="page-inner">

				<div id="hd">

					<!-- START DRUPAL HEADER -->
						<div id="header">
							<div id="header-inner" class="clear-block">

				      			<?php if ($site_name && theme_get_setting('osu_confident_hide_site_name') == 0): ?>
			        				<div id="title">
					              		<h1 id="site-name" class="<?php print $site_name; ?>"><a href="<?php print $front_page; ?>" title="<?php print t('Home'); ?>" rel="home"><?php print $site_name; ?></a></h1>

		        					</div>
			      				<?php endif; ?>

								<?php if ($header): ?>
									<div id="header-blocks" class="region region-header">
                                        <a name="navigation" id="navigation"></a>

										<?php print $header; ?>
									</div> <!-- /#header-blocks -->
								<?php endif; ?>
		    				</div> <!-- /#header-inner -->
		   				</div> <!-- /#header -->
					<!-- END DRUPAL HEADER -->

				</div> <!-- /hd -->

				<div id="bd">

					<!-- START DRUPAL TOP HORIZONTAL BAR -->
					<?php if ($breadcrumb): ?>
						<div id="top-horizontal-bar">
							<div id="top-horizontal-bar-inner" class="clear-block">

								<?php print $breadcrumb; ?>

							</div> <!-- /#top-horizontal-bar-inner  -->
						</div> <!-- /#top-horizontal-bar -->
					<?php endif; ?>
					<!-- END DRUPAL TOP HORIZONTAL BAR -->

					<div id="yui-main">
						<div class="yui-b">

							<!-- START CHECK FOR RIGHT COL - if there is right content, open a grid holder and unit for main content -->
							<?php if ($right || $social_media): ?>
								<div class="yui-ge">
									<div class="yui-u first">
							<?php endif; ?>
							<!--  END CHECK FOR RIGHT COL -->

										<div class="interior">

											<!-- START DRUPAL MAIN -->
											<div id="main">
												<div id="main-inner" class="clear-block<?php if ($primary_links || $secondary_links || $top_horizontal_bar) { print ' with-navbar'; } ?>">

													<div id="content">
														<div id="content-inner">

															<?php if ($mission): ?>
																<div id="mission">
																	<?php print $mission; ?>
																</div>
															<?php endif; ?>

															<?php if ($pre_content || $is_front || theme_get_setting('osu_second_header_type') != 'short'): ?>
																<div id="pre-content" class="region region-pre_content">
																<?php if ($is_front || theme_get_setting('osu_second_header_type') != 'short'): ?>
																	<?php
																		//modification: check to see if this is the primary domain before adding the rotating header
																		$domain = domain_get_domain();
																		if ($domain['domain_id'] == 0):
																		?>
																		<div id="rotating-image">
                                                                        	<div class="image-border">
                                                                            	<?php  echo osu_drupal_1_11_rotating_header($is_front, '#rotating-image'); ?>
                                                                         	</div>
                                                                    	</div>
																<?php endif;
																	//modification: added a second endif to close the if added above
																	endif;
																	?>

																	<?php print $pre_content; ?>
																</div> <!-- /#pre-content -->
															<?php endif; ?>

															<?php if ($title || $tabs || $help || $messages): ?>
																<div id="content-header">

																	<?php if ($title): ?>
																		<h2 class="title">
																			<?php print $title; ?>
									              						</h2>
									            					<?php endif; ?>

																	<?php print $messages; ?>

																	<?php if ($tabs): ?>
																		<div class="tabs">
																			<?php print $tabs; ?>
																		</div>
																	<?php endif; ?>

																	<?php print $help; ?>
																</div> <!-- /#content-header -->
															<?php endif; ?>

															<div id="content-area" class="region region-content">
																<?php print $content; ?>
															</div>

															<?php if ($post_content): ?>
																<div id="post-content" class="region region-post_content">
																	<?php print $post_content; ?>
																</div> <!-- /#post_content -->
															<?php endif; ?>

														</div> <!-- /#content-inner -->
													</div> <!-- /#content -->

												</div> <!-- /#main-inner -->
											</div> <!-- /#main -->
											<!-- END DRUPAL MAIN -->

										</div> <!-- interior -->

							<!-- START CHECK FOR RIGHT COL - if there is a content, end the main content's grid unit, open the right content's grid unit -->
							<?php if ($right || $social_media): ?>
									</div> <!-- /yui-u -->

									<div class="yui-u" id="right-side">
										<div class="interior">

											<!-- START DRUPAL RIGHT -->
											<div id="sidebar-right">
												<div id="sidebar-right-inner" class="region region-right">
													<?php if ($social_media): ?>
                                                    <div id="social-media" class="region region-social-media">
                                                        <?php print $social_media; ?>
                                                    </div>
                                                     <?php endif; ?>

													<?php print $right; ?>
												</div> <!-- /#sidebar-right-inner -->
											</div> <!-- /#sidebar-right -->
											<!-- END DRUPAL RIGHT -->

										</div> <!-- /interior -->
									</div> <!-- yui-u -->
								</div> <!-- yui-ge -->
							<?php endif; ?>
							<!-- END CHECK FOR RIGHT COL - grid unit and holder closed -->

						</div> <!-- /yui-b -->
					</div> <!-- /yui-main -->

					<!-- START CHECK FOR LEFT COL -->
			    	<?php if ($left): ?>
						<div class="yui-b">
							<div class="interior">

								<!-- START DRUPAL LEFT - if there is left content, open a yui-b column and print it-->
						        <div id="sidebar-left">
						        	<div id="sidebar-left-inner" class="region region-left">
						          	<?php print $left; ?>
						        	</div> <!-- /#sidebar-left-inner -->
					        	</div> <!-- /#sidebar-left -->
								<!-- END DRUPAL LEFT -->

							</div> <!-- /interior -->
						</div>
					<?php endif; ?>
					<!--  END CHECK FOR LEFT COL -->

				</div> <!-- /#bd -->

			</div> <!-- /#page-inner -->
		</div> <!-- /#page -->

	</div> <!-- /doc -->
    </div> <!-- top-bg -->

    <div id="ft" class="yui-t2">
    	<div id="ft-inner">

        <!-- START CONTACT -->
        <div class="yui-b">
            <div class="interior">
                <div id="contact">
                    <div id="contact-inner" class="region region-contact">
                        <?php if ($footer_message): ?>
                            <div id="footer-message" class="osu-footer-text content"><?php print $footer_message; ?></div>
                        <?php endif; ?>

                        <?php print $contact; ?>

				<!--  START DEFAULT OSU FOOTER TEXT -->
				<p class="osu-footer-text content">
					<a href="http://oregonstate.edu/about/copyright">Copyright</a> &#169; <?php echo date('Y'); ?><br />
					Oregon State University<br />
					<a href="http://oregonstate.edu/about/disclaimer">Disclaimer</a>
				</p>
				<!--  END START DEFAULT OSU FOOTER TEXT -->

                    </div> <!-- /#contact-inner -->
                </div> <!-- /#contact -->
            </div> <!-- /interior -->
        </div>
        <!-- END CONTACT -->

        <div class="yui-b first">
            <div class="interior">
            <!-- START FOOTER -->
            <?php if ($footer): ?>
            <div id="footer">
                <div id="footer-inner" class="region region-footer">

                    <?php print $footer; ?>

                </div> <!-- /#footer-inner -->
            </div> <!-- /#footer -->
            <?php endif; ?>
            </div> <!-- /interior -->
        </div>

        <?php if ($closure_region): ?>
            <div id="closure-blocks" class="region region-closure">
                <?php print $closure_region; ?>
            </div>
        <?php endif; ?>

        <?php print $closure; ?>
        <!-- END FOOTER -->
    	</div> <!-- /ft-inner -->
    </div> <!-- /ft -->
<?php // include("/www/httpd-docs/tools/stats/u5ga/UA-4834799-1.js"); ?>
<!--[if IE 6]>
</div>
<![endif]-->
<!--[if IE 7]>
</div>
<![endif]-->

<!-- TEST -->
</body>
</html>
