<?php
/*print_r($_REQUEST);


echo md5(base64_encode('ram_123+dsfd@gmail.com'));*/

$im = imagecreatetruecolor(1, 1);
imagefilledrectangle($im, 0, 0, 0, 0, 0xFb6b6F);
header('Content-Type: image/jpeg');
imagegif($im);
imagedestroy($im);
//echo $im;
?>