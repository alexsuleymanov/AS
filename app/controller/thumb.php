<?php
/**
 * Example /thumb?src=pic/cat/320.jpg&width=120&height=120&crop=1
 */

use ASweb\Image\Imageresizer;

$ftypes = array(1 => "gif", 2 => "jpg", 3 => "png", 4 => "swf", 5 => "psd", 6 => "bmp");
$ims = getimagesize($path."/".$url->g['src']);
$ftype = $ftypes[$ims[2]];

header("Expires: ".date("D, d M Y H:i:s", time()+30+86400));
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
header("Cache-control: public");
header('Pragma: public');

if($ftype == "jpg") {
	header("Content-type: image/jpeg");
} elseif($ftype == "gif") {
	header("Content-type: image/gif");
} elseif($ftype == "png") {
	header("Content-type: image/png");
}

if (!$OutputCache->start("thumb_".str_replace(array(".", "/", "\\"), "_", $url->g["src"])."_".$url->g["width"]."_".$url->g["height"])) {
	$width = 0 + $url->g['width'];
	$height = 0 + $url->g['height'];
	$crop = 0 + $url->g['crop'];

	$ir = new Imageresizer();
	$ir->src = $path."/".$url->g['src'];
	$ir->type = $ir->outtype = $ftype;
	$sz = getimagesize($ir->src);

	if ($width && $height && $crop == 1) {
		$ir->dstimgw = $width;
		$ir->dstimgh = $height;

		if (round($sz[1] * $width / $sz[0]) < $height) {
			$ratio = $sz[1] / $height;
			$ir->srcx = round(($sz[0] - $width * $ratio)/2);
			$ir->srcw = $sz[0] - 2 * $ir->srcx;
			$ir->srch = $sz[1];
			$ir->srcy = 0;
		} else {
			$ratio = $sz[0] / $width;
			$ir->srcx = 0;
			$ir->srcy = round(($sz[1] - $height * $ratio)/2);
			$ir->srcw = $sz[0];
			$ir->srch = $sz[1] - 2 * $ir->srcy;
		}
	} elseif($width && $height && $crop == 0) {
		$ir->dstimgw = $width;
		$ir->dstimgh = $height;

		if (round($sz[1] * $width / $sz[0]) < $height) {	// картинка горизонтальная
			$ratio = $sz[0] / $width;
			$ir->dstw = $width;
			$ir->dsth = $sz[1] / $ratio;
			$ir->srcx = 0;
			$ir->srcw = $sz[0];
			$ir->srch = $sz[1];
			$ir->srcy = 0;
			$ir->dsty = round(($ir->dstimgh - $ir->dsth)/2);
			$ir->dstx = 0;
		} else {											// картинка вертикальная
			$ratio = $sz[1] / $height;
			$ir->dstw = $sz[0] / $ratio;
			$ir->dsth = $height;
			$ir->srcx = 0;
			$ir->srcw = $sz[0];
			$ir->srch = $sz[1];
			$ir->srcy = 0;
			$ir->dsty = 0;
			$ir->dstx = round(($ir->dstimgw - $ir->dstw)/2);
		}
	} elseif($width && $height == 0) {
		$ir->dstimgw = min($width, $sz[0]);
		$ir->dstimgh = round($sz[1] * $ir->dstimgw / $sz[0]);
	} elseif($height && $width == 0) {
		$ir->dstimgh = min($height, $sz[1]);
		$ir->dstimgw = round($sz[0] * $ir->dstimgh / $sz[1]);
	} elseif($height == 0 && $width == 0) {
		$ir->dstimgw = $sz[0];
		$ir->dstimgh = $sz[1];
	}

	$ir->dst = '';
	$ir->resize();

  	$OutputCache->end(array(str_replace(array("/", "."), "_", str_replace("../", "", $url->g["src"]))));
}