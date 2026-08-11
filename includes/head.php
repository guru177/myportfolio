<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
/** @var string $pageTitle */
/** @var string $pageDescription */
/** @var string $canonicalUrl */

$pageTitle = $pageTitle ?? $config['title'];
$pageDescription = $pageDescription ?? $config['description'];
$canonicalUrl = $canonicalUrl ?? $config['site_url'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <meta name="keywords" content="<?= e($config['keywords']) ?>">
    <meta name="author" content="<?= e($config['author']) ?>">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:site_name" content="<?= e($config['site_name']) ?>">
    <meta property="og:locale" content="<?= e($config['locale']) ?>">
    <meta property="og:image" content="<?= e(asset($config['og_image'])) ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($pageTitle) ?>">
    <meta name="twitter:description" content="<?= e($pageDescription) ?>">
    <meta name="twitter:image" content="<?= e(asset($config['og_image'])) ?>">

    <link rel="icon" type="image/svg+xml" href="<?= e(local_asset('assets/favicon.svg')) ?>">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/base.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/hero.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/marquee.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/about.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/what-we-do.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/work.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/contact.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/ai-chat.css')) ?>">

    <script type="application/ld+json">
    <?= json_encode([
        '@context' => 'https://schema.org',
        '@type' => 'Person',
        'name' => $config['author'],
        'url' => $config['site_url'],
        'email' => $config['email'],
        'jobTitle' => 'Full Stack Webdeveloper',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Kochi',
            'addressRegion' => 'Kerala',
            'addressCountry' => 'IN',
        ],
        'image' => asset($config['og_image']),
        'sameAs' => [],
    ], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT) ?>
    </script>
</head>
<body>
