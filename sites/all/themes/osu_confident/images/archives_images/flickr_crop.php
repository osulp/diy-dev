<?php

set_time_limit(10000);
error_reporting(E_ALL ^ E_NOTICE);

// size to fetch from flickr
$suffix = '_m';

do {
	$old_image = filter_var($_GET['image'], FILTER_VALIDATE_URL) . $suffix . '.jpg';
	if (!@ImageCreateFromJPEG($old_image)) {exit('Operation failed.');}
	$loop = FALSE;
	$suffix = '';

	list($width, $height) = GetImageSize($old_image);

	$crop_x = 0;
	$crop_y = 0;
	$new_width = 175;
	$new_height = 132;

	if ($width >= 175) 
		$crop_x = ($width-175)/2;
	else
		$loop = TRUE;

	if ($height >= 128)
		$crop_y = ($height-128)/2;
	else
		$loop = TRUE;

} while ($loop == TRUE);
	
$new_image = ImageCreateTrueColor($new_width, $new_height);
$old_image = ImageCreateFromJPEG($old_image);
ImageCopyResampled($new_image, $old_image, 0, 0, $crop_x, $crop_y, $new_width, $new_height, $new_width, $new_height);

// output image
header("Content-type: image/jpeg");
ImageJPEG($new_image, NULL, 95);

?>