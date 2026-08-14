<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
/** @var string $pageTitle */
/** @var string $pageDescription */
/** @var string $canonicalUrl */

$pageTitle = $pageTitle ?? $config['title'];
$pageDescription = $pageDescription ?? $config['description'];
$canonicalUrl = $canonicalUrl ?? $config['site_url'];
$ogImage = asset($config['og_image']);
$ogImageAlt = $config['og_image_alt'] ?? ($config['author'] . ' — full stack webdeveloper in Kochi, Kerala');
$ogImageWidth = (int) ($config['og_image_width'] ?? 1200);
$ogImageHeight = (int) ($config['og_image_height'] ?? 630);
$ogImageType = $config['og_image_type'] ?? 'image/png';
$portraitImage = asset('/assets/images/portrait.png');
$lcpPreload = lcp_preload_href('assets/images/portrait.png', [280, 420, 560], 420);
$siteBase = rtrim($config['site_url'], '/');

$genericSocialRoots = [
    'https://github.com',
    'https://www.github.com',
    'https://linkedin.com',
    'https://www.linkedin.com',
];

$sameAs = array_values(array_filter(
    $config['same_as'] ?? [],
    static fn (string $url): bool => $url !== '' && !in_array(rtrim($url, '/'), $genericSocialRoots, true)
));

if (!empty($config['google_business_url'])) {
    $sameAs[] = (string) $config['google_business_url'];
}

$whatsappDigits = preg_replace('/\D+/', '', (string) ($config['whatsapp'] ?? ''));
$hasWhatsApp = $whatsappDigits !== '' && $whatsappDigits !== '919999999999';

$personSchema = [
    '@type' => 'Person',
    '@id' => $siteBase . '/#person',
    'name' => $config['author'],
    'url' => $config['site_url'],
    'email' => 'mailto:' . $config['email'],
    'image' => [
        '@type' => 'ImageObject',
        'url' => $portraitImage,
        'width' => 690,
        'height' => 712,
        'caption' => $config['author'] . ' — freelance web developer in Kochi, Kerala',
    ],
    'jobTitle' => 'Web Developer',
    'description' => $pageDescription,
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Kochi',
        'addressRegion' => 'Kerala',
        'addressCountry' => 'IN',
    ],
    'knowsAbout' => $config['services'] ?? [
        'Web Development',
        'Web Design',
        'Ecommerce',
        'API Development',
    ],
];

if ($sameAs !== []) {
    $personSchema['sameAs'] = $sameAs;
}

if ($hasWhatsApp) {
    $personSchema['telephone'] = '+' . $whatsappDigits;
}

$serviceSchema = [
    '@type' => 'ProfessionalService',
    '@id' => $siteBase . '/#business',
    'name' => $config['site_name'] . ' — Full Stack Web Development',
    'image' => $ogImage,
    'url' => $config['site_url'],
    'email' => $config['email'],
    'description' => $pageDescription,
    'priceRange' => '$$',
    'currenciesAccepted' => 'INR, USD',
    'paymentAccepted' => 'Bank Transfer, UPI, PayPal',
    'areaServed' => array_map(
        static fn (string $area): array => [
            '@type' => 'Place',
            'name' => $area,
        ],
        $config['service_areas'] ?? ['Kochi', 'Kerala', 'India']
    ),
    'address' => [
        '@type' => 'PostalAddress',
        'addressLocality' => 'Kochi',
        'addressRegion' => 'Kerala',
        'addressCountry' => 'IN',
    ],
    'geo' => [
        '@type' => 'GeoCoordinates',
        'latitude' => 9.9312,
        'longitude' => 76.2673,
    ],
    'founder' => ['@id' => $siteBase . '/#person'],
    'employee' => ['@id' => $siteBase . '/#person'],
    'knowsAbout' => $config['services'] ?? [],
    'hasOfferCatalog' => [
        '@type' => 'OfferCatalog',
        'name' => 'Web development services in Kerala',
        'itemListElement' => array_map(
            static fn (string $service): array => [
                '@type' => 'Offer',
                'itemOffered' => [
                    '@type' => 'Service',
                    'name' => $service,
                    'areaServed' => 'Kerala, India',
                ],
            ],
            $config['services'] ?? []
        ),
    ],
];

$websiteSchema = [
    '@type' => 'WebSite',
    '@id' => $siteBase . '/#website',
    'url' => $config['site_url'],
    'name' => $config['site_name'],
    'description' => $pageDescription,
    'publisher' => ['@id' => $siteBase . '/#person'],
    'inLanguage' => 'en-IN',
];

$webpageSchema = [
    '@type' => 'WebPage',
    '@id' => rtrim($canonicalUrl, '/') . '/#webpage',
    'url' => $canonicalUrl,
    'name' => $pageTitle,
    'description' => $pageDescription,
    'isPartOf' => ['@id' => $siteBase . '/#website'],
    'about' => ['@id' => $siteBase . '/#person'],
    'primaryImageOfPage' => [
        '@type' => 'ImageObject',
        'url' => $ogImage,
        'width' => $ogImageWidth,
        'height' => $ogImageHeight,
        'caption' => $ogImageAlt,
    ],
    'inLanguage' => 'en-IN',
    'speakable' => [
        '@type' => 'SpeakableSpecification',
        'cssSelector' => ['#faq-heading', '.seo-faq__item:first-of-type .seo-faq__answer p'],
    ],
];

$breadcrumbSchema = [
    '@type' => 'BreadcrumbList',
    '@id' => $siteBase . '/#breadcrumb',
    'itemListElement' => [
        [
            '@type' => 'ListItem',
            'position' => 1,
            'name' => 'Home',
            'item' => $config['site_url'],
        ],
        [
            '@type' => 'ListItem',
            'position' => 2,
            'name' => 'Services',
            'item' => $siteBase . '/#services',
        ],
        [
            '@type' => 'ListItem',
            'position' => 3,
            'name' => 'Contact',
            'item' => $siteBase . '/#contact',
        ],
    ],
];

$faqEntities = [];
foreach ($config['faq'] ?? [] as $item) {
    $faqEntities[] = [
        '@type' => 'Question',
        'name' => $item['q'],
        'acceptedAnswer' => [
            '@type' => 'Answer',
            'text' => $item['a'],
        ],
    ];
}

$faqSchema = [
    '@type' => 'FAQPage',
    '@id' => $siteBase . '/#faq',
    'mainEntity' => $faqEntities,
];

$jsonLd = [
    '@context' => 'https://schema.org',
    '@graph' => array_values(array_filter([
        $personSchema,
        $serviceSchema,
        $websiteSchema,
        $webpageSchema,
        $breadcrumbSchema,
        $faqEntities ? $faqSchema : null,
    ])),
];

$htmlLang = $config['language'] ?? 'en-IN';
?>
<!DOCTYPE html>
<html lang="<?= e($htmlLang) ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title><?= e($pageTitle) ?></title>
    <meta name="description" content="<?= e($pageDescription) ?>">
    <?php if (!empty($config['keywords'])): ?>
    <meta name="keywords" content="<?= e($config['keywords']) ?>">
    <?php endif; ?>
    <meta name="author" content="<?= e($config['author']) ?>">
    <meta name="creator" content="<?= e($config['author']) ?>">
    <meta name="publisher" content="<?= e($config['site_name']) ?>">
    <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
    <meta name="googlebot" content="index, follow">
    <meta name="bingbot" content="index, follow">
    <meta name="theme-color" content="#0a0a0a">
    <meta name="format-detection" content="telephone=no">
    <meta name="referrer" content="strict-origin-when-cross-origin">
    <link rel="canonical" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" hreflang="en-IN" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" hreflang="en" href="<?= e($canonicalUrl) ?>">
    <link rel="alternate" hreflang="x-default" href="<?= e($canonicalUrl) ?>">

    <?php $geo = $config['geo'] ?? []; ?>
    <?php if (!empty($geo['region'])): ?>
    <meta name="geo.region" content="<?= e($geo['region']) ?>">
    <?php endif; ?>
    <?php if (!empty($geo['placename'])): ?>
    <meta name="geo.placename" content="<?= e($geo['placename']) ?>">
    <?php endif; ?>
    <?php if (!empty($geo['position'])): ?>
    <meta name="geo.position" content="<?= e($geo['position']) ?>">
    <?php endif; ?>
    <?php if (!empty($geo['icbm'])): ?>
    <meta name="ICBM" content="<?= e($geo['icbm']) ?>">
    <?php endif; ?>

    <meta property="og:type" content="website">
    <meta property="og:title" content="<?= e($pageTitle) ?>">
    <meta property="og:description" content="<?= e($pageDescription) ?>">
    <meta property="og:url" content="<?= e($canonicalUrl) ?>">
    <meta property="og:site_name" content="<?= e($config['site_name']) ?>">
    <meta property="og:locale" content="<?= e($config['locale']) ?>">
    <meta property="og:image" content="<?= e($ogImage) ?>">
    <meta property="og:image:alt" content="<?= e($ogImageAlt) ?>">
    <meta property="og:image:width" content="<?= e((string) $ogImageWidth) ?>">
    <meta property="og:image:height" content="<?= e((string) $ogImageHeight) ?>">
    <meta property="og:image:type" content="<?= e($ogImageType) ?>">

    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="<?= e($pageTitle) ?>">
    <meta name="twitter:description" content="<?= e($pageDescription) ?>">
    <meta name="twitter:image" content="<?= e($ogImage) ?>">
    <meta name="twitter:image:alt" content="<?= e($ogImageAlt) ?>">
    <?php if (!empty($config['twitter_handle'])): ?>
    <meta name="twitter:site" content="<?= e($config['twitter_handle']) ?>">
    <meta name="twitter:creator" content="<?= e($config['twitter_handle']) ?>">
    <?php endif; ?>

    <link rel="icon" type="image/svg+xml" href="<?= e(local_asset('assets/favicon.svg')) ?>">
    <link rel="apple-touch-icon" href="<?= e(local_asset('assets/images/apple-touch-icon.png')) ?>" sizes="180x180">
    <link rel="manifest" href="<?= e(local_asset('site.webmanifest')) ?>">
    <link rel="preload" as="image" type="image/webp" href="<?= e($lcpPreload) ?>" fetchpriority="high">
    <link rel="sitemap" type="application/xml" title="Sitemap" href="<?= e($siteBase . '/sitemap.xml') ?>">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="dns-prefetch" href="https://cdnjs.cloudflare.com">
    <link href="https://fonts.googleapis.com/css2?family=Barlow+Semi+Condensed:wght@700;800;900&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/base.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/hero.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/marquee.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/about.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/what-we-do.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/work.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/contact.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/ai-chat.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/seo.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/seo-sections.css')) ?>">
    <link rel="stylesheet" href="<?= e(local_asset('assets/css/watch.css')) ?>">

    <script type="application/ld+json">
    <?= json_encode($jsonLd, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) ?>
    </script>
</head>
<body>
<a class="skip-link" href="#about">Skip to content</a>
