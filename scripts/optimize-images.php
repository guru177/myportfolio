<?php

declare(strict_types=1);

/**
 * Generates WebP variants and fixed-size SEO assets.
 * Run: php scripts/optimize-images.php
 */

$root = dirname(__DIR__);
$imagesDir = $root . '/assets/images';

function load_image(string $path): ?GdImage
{
    $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

    return match ($ext) {
        'png' => @imagecreatefrompng($path) ?: null,
        'jpg', 'jpeg' => @imagecreatefromjpeg($path) ?: null,
        'webp' => @imagecreatefromwebp($path) ?: null,
        default => null,
    };
}

function save_webp(GdImage $image, string $dest, int $quality = 82): bool
{
    if (!function_exists('imagewebp')) {
        fwrite(STDERR, "WebP support not available.\n");

        return false;
    }

    if (function_exists('imagepalettetotruecolor')) {
        imagepalettetotruecolor($image);
    }
    imagealphablending($image, true);
    imagesavealpha($image, true);

    return imagewebp($image, $dest, $quality);
}

function resize_to_width(GdImage $source, int $targetWidth): GdImage
{
    $srcW = imagesx($source);
    $srcH = imagesy($source);
    $targetWidth = min($targetWidth, $srcW);
    $targetHeight = (int) round($srcH * ($targetWidth / $srcW));

    $dest = imagecreatetruecolor($targetWidth, $targetHeight);
    imagealphablending($dest, false);
    imagesavealpha($dest, true);
    $transparent = imagecolorallocatealpha($dest, 0, 0, 0, 127);
    imagefilledrectangle($dest, 0, 0, $targetWidth, $targetHeight, $transparent);
    imagecopyresampled($dest, $source, 0, 0, 0, 0, $targetWidth, $targetHeight, $srcW, $srcH);

    return $dest;
}

function crop_center(GdImage $source, int $targetW, int $targetH): GdImage
{
    $srcW = imagesx($source);
    $srcH = imagesy($source);
    $srcRatio = $srcW / $srcH;
    $targetRatio = $targetW / $targetH;

    if ($srcRatio > $targetRatio) {
        $cropH = $srcH;
        $cropW = (int) round($srcH * $targetRatio);
        $srcX = (int) round(($srcW - $cropW) / 2);
        $srcY = 0;
    } else {
        $cropW = $srcW;
        $cropH = (int) round($srcW / $targetRatio);
        $srcX = 0;
        $srcY = (int) round(($srcH - $cropH) / 2);
    }

    $dest = imagecreatetruecolor($targetW, $targetH);
    imagealphablending($dest, false);
    imagesavealpha($dest, true);
    imagecopyresampled($dest, $source, 0, 0, $srcX, $srcY, $targetW, $targetH, $cropW, $cropH);

    return $dest;
}

function make_variants(string $sourcePath, array $widths, int $quality = 82): array
{
    $source = load_image($sourcePath);
    if ($source === null) {
        fwrite(STDERR, "Could not load: {$sourcePath}\n");

        return [];
    }

    $base = pathinfo($sourcePath, PATHINFO_FILENAME);
    $dir = pathinfo($sourcePath, PATHINFO_DIRNAME);
    $created = [];

    foreach ($widths as $width) {
        $resized = resize_to_width($source, $width);
        $dest = $dir . '/' . $base . '-' . $width . 'w.webp';
        if (save_webp($resized, $dest, $quality)) {
            $created[] = $dest;
            echo 'Created ' . basename($dest) . ' (' . filesize($dest) . " bytes)\n";
        }
        imagedestroy($resized);
    }

    imagedestroy($source);

    return $created;
}

$jobs = [
    $imagesDir . '/portrait.png' => [280, 420, 560],
    $imagesDir . '/spider-web.png' => [400, 800],
    $imagesDir . '/about-slide-01.png' => [480, 640, 800],
    $imagesDir . '/about-slide-02.png' => [480, 640, 800],
    $imagesDir . '/about-slide-03.png' => [480, 640, 800],
    $imagesDir . '/about-slide-04.png' => [480, 640, 800],
];

foreach ($jobs as $source => $widths) {
    if (!is_file($source)) {
        fwrite(STDERR, "Missing source: {$source}\n");
        continue;
    }
    make_variants($source, $widths);
}

$ogSource = $imagesDir . '/og-share.png';
if (is_file($ogSource)) {
    $source = load_image($ogSource);
    if ($source !== null) {
        $og = crop_center($source, 1200, 630);
        $ogPath = $imagesDir . '/og-share-1200.webp';
        if (save_webp($og, $ogPath, 85)) {
            echo 'Created ' . basename($ogPath) . ' (' . filesize($ogPath) . " bytes)\n";
        }
        imagedestroy($og);
        imagedestroy($source);
    }
}

$portrait = load_image($imagesDir . '/portrait.png');
if ($portrait !== null) {
    $icon = resize_to_width($portrait, 180);
    $iconPath = $imagesDir . '/apple-touch-icon.png';
    imagealphablending($icon, true);
    imagesavealpha($icon, true);
    if (imagepng($icon, $iconPath, 8)) {
        echo 'Created ' . basename($iconPath) . ' (' . filesize($iconPath) . " bytes)\n";
    }
    imagedestroy($icon);
    imagedestroy($portrait);
}

echo "Done.\n";
