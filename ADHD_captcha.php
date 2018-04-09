<?php
	header('Content-type: image/jpeg');

	$width = 45;
	$height = 29;

	$my_image = imagecreatetruecolor($width, $height);

	imagefill($my_image, 0, 0, 0x405764);

	// add noise
	for ($c = 0; $c < 65; $c++){
		$x = rand(0,$width-1);
		$y = rand(0,$height-1);
		imagesetpixel($my_image, $x, $y, 0x96c2f4);
		}

	$x = rand(1,10);
	$y = rand(1,10);

	$rand_string = rand(1000,9999);
	imagestring($my_image, 5, $x, $y, $rand_string, 0xFFFFFF);

	setcookie('conmes',(md5($rand_string).'5i9p'));

	imagejpeg($my_image);
	imagedestroy($my_image);
?>