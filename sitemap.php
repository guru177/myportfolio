<?php

declare(strict_types=1);

require __DIR__ . '/config.php';

header('Content-Type: application/xml; charset=utf-8');

$base = rtrim($config['site_url'], '/');
$today = date('Y-m-d');

$urls = [
    [
        'loc' => $base . '/',
        'lastmod' => $today,
        'changefreq' => 'weekly',
        'priority' => '1.0',
        'images' => sitemap_images_from_config($config),
    ],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset
    xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
    xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
>
<?php foreach ($urls as $url): ?>
    <url>
        <loc><?= e($url['loc']) ?></loc>
        <lastmod><?= e($url['lastmod']) ?></lastmod>
        <changefreq><?= e($url['changefreq']) ?></changefreq>
        <priority><?= e($url['priority']) ?></priority>
<?php foreach ($url['images'] ?? [] as $image): ?>
        <image:image>
            <image:loc><?= e($image['loc']) ?></image:loc>
            <image:title><?= e($image['title']) ?></image:title>
<?php if (!empty($image['caption'])): ?>
            <image:caption><?= e($image['caption']) ?></image:caption>
<?php endif; ?>
        </image:image>
<?php endforeach; ?>
    </url>
<?php endforeach; ?>
</urlset>
