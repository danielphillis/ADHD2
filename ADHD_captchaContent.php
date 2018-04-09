<?php
	//header('Content-type: image/jpeg');

	$widthVer = 215;
	$heightVer = 29;

	$verfImage = imagecreatetruecolor($widthVer, $heightVer);

	imagefill($verfImage, 0, 0, 0x405764);

	// add noise
	for ($c = 0; $c < 350; $c++){
		$xSize = rand(0,$widthVer-1);
		$ySize = rand(0,$heightVer-1);
		imagesetpixel($verfImage, $xSize, $ySize, 0x96c2f4);
		}

	$xSize = rand(75,150);
	$ySize = rand(1,10);

	$rand_verf_string = rand(1000,9999);
	imagestring($verfImage, 5, $xSize, $ySize, $rand_verf_string, 0xFFFFFF);

	setcookie('imgcap',(md5($rand_verf_string).'8cq3'));

	imagejpeg($verfImage);
	imagedestroy($verfImage);
?>