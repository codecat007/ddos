<?php

include("config.php");

header('Content-type: image/png');

$im = imagecreatetruecolor(400, 25);
imagesavealpha($im, true);

$trans_colour = imagecolorallocatealpha($im, 0, 0, 0, 127);
imagefill($im, 0, 0, $trans_colour);

$yellow = imagecolorallocate($im, 255, 255, 0);
$blue = imagecolorallocate($im, 65, 105, 255);
$red = imagecolorallocate($im, 255, 0, 0);
$green = imagecolorallocate($im, 173, 255, 47);

$width = 400;
$height = 25;

$font = 4;

$text = "There are currently " . getOnlineShells() . " shell(s) online.";

$leftTextPos = ($width - imagefontwidth($font) * strlen($text)) / 2;
imagestring($im, $font, $leftTextPos + 1, $height - 20, $text, $black);
imagestring($im, $font, $leftTextPos, $height - 20, $text, $green);

imagepng($im);

imagedestroy($im);

?>