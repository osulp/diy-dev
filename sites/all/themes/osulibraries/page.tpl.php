<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" lang="<?php print $language; ?>" xml:lang="<?php print $language; ?>">

<head>
<?php

//If the user has come from the mobile site and is choosing to opt out, set the noredirect cookie
if($_GET['opt_out'] == true){
	setcookie("noredirect", true, time()+7776000, "/", "osulibrary.oregonstate.edu");
}

//Check if the noredirect cookie is set, if not check if the user is on a mobile platform and forward them to the mobile site if they are
if(($is_front)&&($_COOKIE["noredirect"] != true)){
	$mobile_browser = 1;
	$currUA = strtolower($_SERVER['HTTP_USER_AGENT']);

	$agents = array(
	    'windows' ,'macintosh','mac','linux','freebsd','solaris',
	    'bot', 'slurp', 'spider', 'crawl', 'lynx', 'vms', 'openvms', 'ipad');

	foreach($agents as $ua){
		if (strpos($currUA, $ua)>=0) {
		    $mobile_browser = 0;
		    break;
		}
	}

	if ((strpos($currUA, 'iphone')>0)||(strpos($currUA, 'ipod')>0)||(strpos($currUA, 'mobile')>0)) {
	    $mobile_browser = 1;
	}

	if($mobile_browser == 1){
		header( 'Location: http://mobile.library.oregonstate.edu/about.html' );
	}
  }
?>
<title><?php print $head_title; ?></title>
<meta http-equiv="content-type" content="text/html;charset=UTF-8" />
<?php print $head; ?>
<?php print $styles; ?>
<!--[if IE]><link rel="stylesheet" href="<?php print $base_path . $directory; ?>/ie.css" type="text/css">
<?php if ($subtheme_directory && file_exists($subtheme_directory .'/ie.css')): ?>
<link rel="stylesheet" href="<?php print $base_path . $subtheme_directory; ?>/ie.css" type="text/css"><?php endif; ?><![endif]-->
<?php print $altstyles; ?>

<script type="text/javascript" src="/scripts/meebome_lib.js"></script>
<script type="text/javascript" src="/scripts/meebome_cascades.js"></script>
<script type="text/javascript" src="/scripts/meebome_guin.js"></script>
<script type="text/javascript" src="/scripts/meebome_ecampus.js"></script>
<script type="text/javascript" src="/scripts/chat.js"></script>
<?php print $scripts; ?>
</head>

<body class="<?php print $body_classes;
	if(strstr(strtolower($_SERVER['REQUEST_URI']), 'guin'))
        			print ' guin';
        		else if(strstr(strtolower($_SERVER['REQUEST_URI']), 'cascades'))
        			print ' cascades';
        		else
        			print ' library'; ?>
">
  <div id="page"><div id="page-inner">

    <a name="top"></a>
    <div id="skip-to-nav"><a href="#navigation"><?php print t('Skip to Navigation'); ?></a></div>

    <div id="header"><div id="header-inner" class="clear-block">

      <?php if ($header) {print $header;} ?>

    </div></div> <!-- /#header-inner, /#header -->



    <div id="main"><div id="main-inner" class="clear-block<?php if ($search_box || $primary_links || $secondary_links || $navbar) { print ' with-navbar'; } ?>">

      <div id="content"><div id="content-inner">

        <?php if ($mission): ?>
          <div id="mission"><?php print $mission; ?></div>
        <?php endif; ?>

<?php if ($content_top): ?>
          <div id="content-top">
            <?php print $content_top; ?>
          </div> <!-- /#content-top -->
        <?php endif; ?>

<?php if ($top_bar): ?>
          <div id="topBar">
            <?php print $top_bar; ?>
          </div> <!-- /#topBar -->
        <?php endif; ?>

        <?php if ($breadcrumb or $title or $tabs or $help or $messages): ?>
         <div id="content-header">
        <?php print str_replace("deiteria&#039;s blog", "Custom Title", $breadcrumb); ?>
        <?php if(!$is_front) {
          if ($title)
            print '<h1 class="title">' . str_replace("deiteria's blog", "DIY Research", $title) . '</h1>';
        } ?>
        <?php print $messages; ?>
        <?php if ($tabs): ?>
          <div class="tabs"><?php print $tabs; ?></div>
        <?php endif; ?>
        <?php print $help; ?>
      </div> <!-- /#content-header -->
        <?php endif; ?>

        <div id="content-area">

        	<div id="central"><?php print $central;?></div>
          <?php
           if (function_exists('spamspan') && ('admin' != arg(0)))  {
           $larg = arg(-1 + count(explode('/', $_GET['q'])));
           if ('edit' != $larg) {
             $content = spamspan($content);
            }
          }
          print $content; ?>
        </div>


        <?php if ($feed_icons): ?>
          <div class="feed-icons"><?php print $feed_icons; ?></div>
        <?php endif; ?>

        <?php if ($content_bottom): ?>
          <div id="content-bottom">
            <?php print $content_bottom; ?>
          </div> <!-- /#content-bottom -->
        <?php endif; ?>
      </div></div> <!-- /#content-inner, /#content -->

      <?php if ($search_box || $primary_links || $secondary_links || $navbar): ?>
        <div id="navbar"><div id="navbar-inner">

          <a name="navigation" id="navigation"></a>

          <?php if ($search_box): ?>
            <div id="search-box">
              <?php print $search_box; ?>
            </div> <!-- /#search-box -->
          <?php endif; ?>

          <?php if ($primary_links): ?>
            <div id="primary">
              <?php print theme('links', $primary_links); ?>
            </div> <!-- /#primary -->
          <?php endif; ?>

          <?php if ($secondary_links): ?>
            <div id="secondary">
              <?php print theme('links', $secondary_links); ?>
            </div> <!-- /#secondary -->
          <?php endif; ?>

          <?php print $navbar; ?>

        </div></div> <!-- /#navbar-inner, /#navbar -->
      <?php endif; ?>

	<div id="sidebar-left"><div id="sidebar-left-inner">
		<?php
			if((substr($_SERVER['REQUEST_URI'], 0, 5) != "/blog") && (substr($_SERVER['REQUEST_URI'], 0, 13) != "/diytutorials")) {
				global $user;
				if (!$user->uid) {
					if(strstr(strtolower($_SERVER['REQUEST_URI']), 'guin'))
						include 'guin_menu.php';
					else if(strstr(strtolower($_SERVER['REQUEST_URI']), 'cascades'))
						include 'cascade_menu.php';
					else if(strstr(strtolower($_SERVER['REQUEST_URI']), 'intranet_new') || strstr(strtolower($_SERVER['REQUEST_URI']), 'intranet'))
						include 'staff_menu.php';
					else
						include 'menu.php';
				}
			}
			print $sidebar_left;
		?>
	</div></div> <!-- /#sidebar-left-inner, /#sidebar-left -->


 	<?php if($is_front):?>
      <?php if ($sidebar_right): ?>
        <div id="sidebar-right" class="isfrontpage"><div id="sidebar-right-inner">
          <?php print $sidebar_right; ?>
        </div></div> <!-- /#sidebar-right-inner, /#sidebar-right -->
      <?php endif; ?>
    <?php else: ?>
      <?php if ($sidebar_right): ?>
        <div id="sidebar-right" ><div id="sidebar-right-inner">
          <?php print $sidebar_right; ?>
        </div></div> <!-- /#sidebar-right-inner, /#sidebar-right -->
      <?php endif; ?>
     <?php endif; ?>

    </div></div> <!-- /#main-inner, /#main -->

    <div id="footer"><div id="footer-inner">

      <div id="footer-message"><?php print $footer_message; ?></div>

    </div></div> <!-- /#footer-inner, /#footer -->

    <?php if ($closure_region): ?>
      <div id="closure-blocks"><?php print $closure_region; ?></div>
    <?php endif; ?>

    <?php print $closure; ?>

  </div></div> <!-- /#page-inner, /#page -->

</body>
</html>
