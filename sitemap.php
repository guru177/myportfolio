<?php

declare(strict_types=1);

require __DIR__ . '/config.php';

header('Content-Type: application/xml; charset=utf-8');

$urls = [
    [
        'loc' => $config['site_url'],
        'lastmod' => date('Y-m-d'),
        'changefreq' => 'monthly',
        'priority' => '1.0',
    ],
];

echo '<?xml version="1.0" encoding="UTF-8"?>' . PHP_EOL;
?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
<?php foreach ($urls as $url): ?>
    <url>
        <loc><?= e($url['loc']) ?></loc>
        <lastmod><?= e($url['lastmod']) ?></lastmod>
        <changefreq><?= e($url['changefreq']) ?></changefreq>
        <priority><?= e($url['priority']) ?></priority>
    </url>
<?php endforeach; ?>
</urlset>
