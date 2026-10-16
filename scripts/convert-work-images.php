<?php

declare(strict_types=1);

$dir = dirname(__DIR__) . '/assets/images/work';
$map = [
    'champions-eduhub.webp' => 'champions-eduhub.jpg',
    'raintech-software.webp' => 'raintech-software.jpg',
];

foreach ($map as $from => $to) {
    $srcPath = $dir . '/' . $from;
    if (!is_file($srcPath)) {
        fwrite(STDERR, "Missing {$from}\n");
        continue;
    }

    $src = imagecreatefromwebp($srcPath);
    if ($src === false) {
        fwrite(STDERR, "Failed to read {$from}\n");
        continue;
    }

    $w = imagesx($src);
    $h = imagesy($src);
    $max = 1600;
    if ($w > $max) {
        $nw = $max;
        $nh = (int) round($h * $max / $w);
        $dst = imagecreatetruecolor($nw, $nh);
        imagecopyresampled($dst, $src, 0, 0, 0, 0, $nw, $nh, $w, $h);
        imagedestroy($src);
        $src = $dst;
    }

    $destPath = $dir . '/' . $to;
    imagejpeg($src, $destPath, 85);
    imagedestroy($src);
    unlink($srcPath);
    echo $to . ' ' . filesize($destPath) . PHP_EOL;
}
