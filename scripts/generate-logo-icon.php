<?php

declare(strict_types=1);

$dest = dirname(__DIR__) . '/assets/images/apple-touch-icon.png';
$size = 180;

$icon = imagecreatetruecolor($size, $size);
$white = imagecolorallocate($icon, 255, 255, 255);
$black = imagecolorallocate($icon, 10, 10, 10);
$gray = imagecolorallocate($icon, 102, 102, 102);

imagefilledrectangle($icon, 0, 0, $size, $size, $white);
imagefilledellipse($icon, 108, 48, 52, 52, $black);
imagefilledellipse($icon, 132, 48, 52, 52, $gray);
imagefilledrectangle($icon, 142, 132, 154, 144, $black);

$font = 'C:/Windows/Fonts/arialbd.ttf';
if (is_file($font)) {
    imagettftext($icon, 34, 0, 22, 118, $black, $font, 'Guru');
} else {
    imagestring($icon, 5, 24, 100, 'Guru', $black);
}

imagepng($icon, $dest, 8);
imagedestroy($icon);

echo "Created {$dest}\n";
