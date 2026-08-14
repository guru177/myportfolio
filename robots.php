<?php

declare(strict_types=1);

require __DIR__ . '/config.php';

header('Content-Type: text/plain; charset=utf-8');

$base = rtrim($config['site_url'], '/');

echo "User-agent: *\n";
echo "Allow: /\n";
echo "Disallow: /includes/\n";
echo "Disallow: /api/\n";
echo "Disallow: /config.php\n";
echo "\n";
echo "User-agent: Googlebot\n";
echo "Allow: /\n";
echo "\n";
echo "User-agent: Bingbot\n";
echo "Allow: /\n";
echo "\n";
echo 'Sitemap: ' . $base . "/sitemap.xml\n";
echo 'Host: ' . $base . "\n";
