<?php
// Shell count image
// Made By Bourd

include("dbc.php");
include("includes/functions.php");

$msg = "There are " . $shellsOnline . " shells online.";

$length = strlen($msg) * 9.3;

$image = imagecreate($length, 30);

$text = imagecolorallocate($image, 51, 51, 51);
$black = imagecolorallocate($image, 255, 255, 255);

imagestring($image, 5,5,1, $msg, $black);

header('Content-type: image/gif');
imagepng($image);
imagedestroy($image);

?>