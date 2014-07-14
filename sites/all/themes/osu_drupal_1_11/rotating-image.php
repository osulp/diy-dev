<?php

	/**
	 * 
	 * 	@author paynez, harking
	 * 
	 * Rotating image component for the OSU Drupal Base Theme
	 * 
	 * First created by harking to use a CCK type, modified by paynez to use all .jpg files within
	 * a specified directory.
	 * 
	 * Further modified to allow for configuration via the theme configuration page.
	 * 
	 * 
	 */
	//

	$interval = ($is_front)? theme_get_setting('osu_rotating_header_interval') : theme_get_setting('osu_second_rotating_header_interval');
	
	
    if (empty($rotating_div)) $rotating_div = '#hd';
	if (empty($interval)) $interval = 4;
	$slide_delay = $interval * 1000;
	$slide_fade_out = 2000;
	$zindex_offset = 100;
	
	$path = osu_drupal_1_11_get_rotating_header_path();
	
	$images = glob($path['abs'].'*.jpg');
	shuffle($images);
	
	$output = '';
	
	if($images) {
	  if (sizeof($images) > 0) {
	  	for ($i = 0; $i < count($images); $i++) {
	    	$output .= '<div class="slide" style="z-index: '.(count($images)-$i).';';
	   		$output .= ($i == 0)? '' : ' display: none;';
	   		$output .= '">'."\n";
				
	   		$img_src = $path['rel'].basename($images[$i]);
	   		
	   		$output .= "\t".'<img src="'.$img_src.'" alt="banner image" />'."\n";
				$output .= '</div>'."\n";
			}
			echo $output;
		}
	} //end if($result)
?>

 <script type="text/javascript">
  //<![CDATA[
  var slides = [];
  var nl = $('<?php echo $rotating_div;?> .slide');
  for (var i = 0; i < nl.length; i++) {
    slides.push(nl[i]);
  }

  current = 0;
  zindex_offset = <?php echo $zindex_offset; ?>;
  for (var i = 0; i < this.slides.length; i++) {
    $(slides[i]).css('z-index', slides.length - i + zindex_offset);
  }

  setInterval(nextImage, <?php echo $slide_delay; ?>);

  function nextImage() {
    for (var i = 0; i < slides.length; i++) {
      var slide = $(slides[(current + i) % slides.length]);
      slide.css('z-index', slides.length - i + zindex_offset);
      slide.show();
    }

    $(slides[current]).fadeOut(<?php echo $slide_fade_out; ?>);
    
    current = (current + 1) % slides.length;
  }
  //]]>
 </script>
