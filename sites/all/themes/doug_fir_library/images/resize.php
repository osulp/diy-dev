<?php

set_time_limit(10000);
error_reporting(E_ALL ^ E_NOTICE);

if ($_GET['r']==1) // image hosted externally
	$old_image = filter_input(INPUT_GET, 'image', FILTER_SANITIZE_URL);
else
  //$old_image = '/var/www/html/' . filter_input(INPUT_GET, 'image', FILTER_SANITIZE_URL);
	$old_image = '/var/www/drupal/' . filter_input(INPUT_GET, 'image', FILTER_SANITIZE_URL);

$new_width = (int)$_GET['w'];
$new_height = (int)$_GET['h'];

$info = GetImageSize($old_image);
$width = $info[0];
$height = $info[1];
$mime = $info['mime'];

$crop_width = $width;
$crop_height = $height;
$crop_x = 0;
$crop_y = 0;

if (($new_width > $width) || ($new_height > $height)) { // new dimensions larger than old; don't change size
	$new_width = $width;
	$new_height = $height;
} elseif($new_width && $new_height) {		 			// both width and height are set; crop to their ratio
	$new_ratio = $new_width / $new_height;
	$ratio = $width / $height;		
	if ($new_ratio >= $ratio) { 						// input too narrow; adjust crop height and y-coordinate
		$crop_height = $width / $new_ratio;
		$crop_y = ($height - $crop_height) / 2;
	} else { 											// input too wide; adjust crop width and x-coordinate
		$crop_width = $height * $new_ratio;
		$crop_x = ($width - $crop_width) / 2;		
	}
} elseif ($new_width) {									// only width set; scale height to match
	$new_height = $new_width / $width * $height;
} elseif ($new_height) {								// only height set; scale width to match
	$new_width = $new_height / $height * $width;
} else {												// nothing set; don't change size
	$new_width = $width;
	$new_height = $height;
}

// use mime type to get corresponding functions
switch ($mime) {
	case 'image/png':
		$image_create_func = 'ImageCreateFromPNG';
		$image_save_func = 'ImagePNG';
		break;
	case 'image/gif':
		$image_create_func = 'ImageCreateFromGIF';
		$image_save_func = 'ImageGIF';
		break;
	default:
		$image_create_func = 'ImageCreateFromJPEG';
		$image_save_func = 'ImageJPEG';
}

// create new image
$new_image = ImageCreateTrueColor($new_width, $new_height);
$old_image = @$image_create_func($old_image);

if (!$old_image)
	exit('Operation failed.');
else { // output image
	ImageCopyResampled($new_image, $old_image, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $crop_width, $crop_height);
	header("Content-Type: " . $mime);
	$image_save_func($new_image, NULL, 90);
}

?>
