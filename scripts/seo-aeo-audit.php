<?php

declare(strict_types=1);

/**
 * SEO & AEO audit for the portfolio site.
 * Run: php scripts/seo-aeo-audit.php
 */

$root = dirname(__DIR__);

function check(string $level, string $id, string $message): void
{
    global $results;
    $results[$level][] = ['id' => $id, 'message' => $message];
}

function capture_php_output(string $file): string
{
    $cmd = 'php ' . escapeshellarg($file);
    $output = shell_exec($cmd);
    return is_string($output) ? $output : '';
}

function load_config(string $root): array
{
    /** @var array<string, mixed> $config */
    include $root . '/config.php';

    return $config;
}

$config = load_config($root);

function get_meta(string $html, string $name, string $attr = 'name'): ?string
{
    $pattern = '/<' . ($attr === 'property' ? 'meta\\s+property' : 'meta\\s+name') .
        '="' . preg_quote($name, '/') . '"\\s+content="([^"]*)"/i';
    return preg_match($pattern, $html, $m) ? html_entity_decode($m[1]) : null;
}

function get_link_rel(string $html, string $rel): ?string
{
    return preg_match('/<link[^>]+rel="' . preg_quote($rel, '/') . '"[^>]+href="([^"]*)"/i', $html, $m)
        ? $m[1] : null;
}

function extract_json_ld(string $html): ?array
{
    if (!preg_match('/<script type="application\/ld\+json">\s*(.*?)\s*<\/script>/s', $html, $m)) {
        return null;
    }
    $data = json_decode(trim($m[1]), true);
    return is_array($data) ? $data : null;
}

function count_tags(string $html, string $tag): int
{
    return preg_match_all('/<' . $tag . '[\s>]/i', $html) ?: 0;
}

function img_missing_alt(string $html): int
{
    preg_match_all('/<img\b[^>]*>/i', $html, $matches);
    $missing = 0;
    foreach ($matches[0] as $tag) {
        if (!preg_match('/\balt="/i', $tag)) {
            $missing++;
        }
    }
    return $missing;
}

$results = ['pass' => [], 'warn' => [], 'fail' => []];

// ── Render homepage ──
$html = capture_php_output($root . '/index.php');

// ── SEO: Meta basics ──
$title = preg_match('/<title>(.*?)<\/title>/s', $html, $tm) ? trim(strip_tags($tm[1])) : '';
$desc = get_meta($html, 'description');
$canonical = get_link_rel($html, 'canonical');

if ($title !== '' && mb_strlen($title) <= 60) {
    check('pass', 'title-length', "Title present ({$title}) — " . mb_strlen($title) . ' chars');
} elseif ($title !== '') {
    check('warn', 'title-length', 'Title is ' . mb_strlen($title) . ' chars (ideal ≤60): ' . $title);
} else {
    check('fail', 'title-length', 'Missing <title>');
}

if ($desc !== null && mb_strlen($desc) >= 120 && mb_strlen($desc) <= 160) {
    check('pass', 'meta-desc', 'Meta description length OK (' . mb_strlen($desc) . ' chars)');
} elseif ($desc !== null) {
    check('warn', 'meta-desc', 'Meta description is ' . mb_strlen($desc) . ' chars (ideal 120–160)');
} else {
    check('fail', 'meta-desc', 'Missing meta description');
}

if ($canonical === $config['site_url']) {
    check('pass', 'canonical', 'Canonical URL matches site_url');
} else {
    check('warn', 'canonical', "Canonical ({$canonical}) vs site_url ({$config['site_url']})");
}

if (get_meta($html, 'keywords') !== null) {
    check('pass', 'keywords', 'Keywords meta tag present');
} else {
    check('warn', 'keywords', 'Keywords meta tag missing');
}

if (preg_match('/<html lang="([^"]+)"/', $html, $lm)) {
    check('pass', 'html-lang', 'HTML lang="' . $lm[1] . '"');
} else {
    check('fail', 'html-lang', 'Missing html lang attribute');
}

// ── SEO: Open Graph & Twitter ──
foreach (['og:title', 'og:description', 'og:url', 'og:image', 'og:image:width', 'og:image:height', 'og:image:type'] as $og) {
    if (get_meta($html, $og, 'property') !== null) {
        check('pass', 'og-' . str_replace(':', '-', $og), "{$og} present");
    } else {
        check('fail', 'og-' . str_replace(':', '-', $og), "Missing {$og}");
    }
}

foreach (['twitter:card', 'twitter:title', 'twitter:description', 'twitter:image'] as $tw) {
    if (get_meta($html, $tw) !== null) {
        check('pass', 'tw-' . str_replace(':', '-', $tw), "{$tw} present");
    } else {
        check('fail', 'tw-' . str_replace(':', '-', $tw), "Missing {$tw}");
    }
}

$ogImagePath = $root . parse_url($config['og_image'], PHP_URL_PATH);
if (is_file($ogImagePath)) {
    check('pass', 'og-image-file', 'OG image file exists on disk');
} else {
    check('fail', 'og-image-file', 'OG image file missing: ' . $config['og_image']);
}

// ── SEO: Geo & hreflang ──
foreach (['geo.region', 'geo.placename'] as $geo) {
    if (get_meta($html, $geo) !== null) {
        check('pass', $geo, "{$geo} present");
    } else {
        check('warn', $geo, "Missing {$geo}");
    }
}

if (preg_match_all('/hreflang="/', $html) >= 3) {
    check('pass', 'hreflang', 'hreflang alternates present (en-IN, en, x-default)');
} else {
    check('warn', 'hreflang', 'Incomplete hreflang tags');
}

// ── SEO: Headings ──
$h1 = count_tags($html, 'h1');
$h2 = count_tags($html, 'h2');
if ($h1 === 1) {
    check('pass', 'h1-single', 'Exactly one H1 on page');
} else {
    check('fail', 'h1-single', "Found {$h1} H1 tags (should be 1)");
}

if ($h2 >= 4) {
    check('pass', 'h2-sections', "{$h2} H2 section headings found");
} else {
    check('warn', 'h2-sections', "Only {$h2} H2 tags — add more section headings");
}

if (preg_match('/<h1[^>]*class="hero__seo-h1"/', $html)) {
    check('pass', 'h1-keyword', 'H1 contains primary SEO keyword');
} else {
    check('warn', 'h1-keyword', 'H1 may not contain target keyword');
}

// ── SEO: Images ──
$missingAlt = img_missing_alt($html);
if ($missingAlt === 0) {
    check('pass', 'img-alt', 'All images have alt attributes (or decorative alt="")');
} else {
    check('warn', 'img-alt', "{$missingAlt} images missing alt attribute");
}

if (preg_match('/fetchpriority="high"/', $html)) {
    check('pass', 'lcp-preload', 'LCP image fetchpriority + preload configured');
} else {
    check('warn', 'lcp-preload', 'Missing LCP fetchpriority/preload');
}

if (preg_match('/srcset=/', $html)) {
    check('pass', 'responsive-images', 'Responsive srcset images present');
} else {
    check('warn', 'responsive-images', 'No srcset found on images');
}

// ── SEO: Structured data ──
$jsonLd = extract_json_ld($html);
if ($jsonLd === null) {
    check('fail', 'json-ld', 'JSON-LD block missing or invalid');
} else {
    check('pass', 'json-ld', 'Valid JSON-LD block found');
    $types = [];
    foreach ($jsonLd['@graph'] ?? [] as $node) {
        $types[] = $node['@type'] ?? 'unknown';
    }
    foreach (['Person', 'ProfessionalService', 'WebSite', 'WebPage', 'BreadcrumbList', 'FAQPage'] as $expected) {
        if (in_array($expected, $types, true)) {
            check('pass', 'schema-' . strtolower($expected), "{$expected} schema present");
        } else {
            check('fail', 'schema-' . strtolower($expected), "Missing {$expected} schema");
        }
    }

    foreach ($jsonLd['@graph'] ?? [] as $node) {
        if (($node['@type'] ?? '') === 'FAQPage') {
            $count = count($node['mainEntity'] ?? []);
            if ($count >= 5) {
                check('pass', 'faq-schema-count', "FAQPage schema has {$count} questions");
            } else {
                check('warn', 'faq-schema-count', "FAQPage only has {$count} questions");
            }
        }
        if (($node['@type'] ?? '') === 'WebPage' && isset($node['speakable'])) {
            check('pass', 'speakable', 'WebPage speakable specification present (AEO/voice)');
        }
    }
}

// ── SEO: Semantic & accessibility ──
if (preg_match('/class="skip-link"/', $html)) {
    check('pass', 'skip-link', 'Skip-to-content link present');
} else {
    check('warn', 'skip-link', 'Missing skip link');
}

if (preg_match('/<main>/', $html)) {
    check('pass', 'main-landmark', '<main> landmark present');
} else {
    check('fail', 'main-landmark', 'Missing <main> element');
}

// ── AEO: Answer-engine optimization ──
$llmsPath = $root . '/llms.txt';
if (is_file($llmsPath)) {
    $llms = file_get_contents($llmsPath);
    check('pass', 'llms-txt', 'llms.txt exists for AI crawlers');
    foreach (['## About', '## Services', '## FAQ highlights', '## Contact'] as $section) {
        if (str_contains($llms, $section)) {
            check('pass', 'llms-' . strtolower(str_replace(['## ', ' '], ['', '-'], $section)), "llms.txt has {$section}");
        } else {
            check('warn', 'llms-section', "llms.txt missing {$section}");
        }
    }
} else {
    check('fail', 'llms-txt', 'llms.txt missing — critical for AEO');
}

if (preg_match('/<section class="seo-faq"/', $html) && preg_match('/<details/', $html)) {
    check('pass', 'faq-html', 'FAQ section with native <details> Q&A markup');
} else {
    check('fail', 'faq-html', 'FAQ section missing or not using details/summary');
}

$faqCount = count($config['faq'] ?? []);
if ($faqCount >= 6) {
    check('pass', 'faq-count', "{$faqCount} FAQ items in config");
} else {
    check('warn', 'faq-count', "Only {$faqCount} FAQ items");
}

// Check FAQ answers are direct/concise (AEO best practice)
$longAnswers = 0;
foreach ($config['faq'] ?? [] as $item) {
    if (mb_strlen($item['a']) > 300) {
        $longAnswers++;
    }
}
if ($longAnswers === 0) {
    check('pass', 'faq-concise', 'FAQ answers are concise (≤300 chars) — good for AI snippets');
} else {
    check('warn', 'faq-concise', "{$longAnswers} FAQ answers exceed 300 chars");
}

if (preg_match('/id="faq-heading"/', $html)) {
    check('pass', 'faq-heading-id', 'FAQ heading has stable ID for speakable schema');
} else {
    check('warn', 'faq-heading-id', 'FAQ heading ID missing');
}

// AI chat widget (AEO engagement)
if (preg_match('/ai-chat|Guru AI/', $html)) {
    check('pass', 'ai-chat', 'AI assistant widget present for user Q&A');
} else {
    check('warn', 'ai-chat', 'No AI chat widget detected');
}

// ── Sitemap & robots ──
$sitemap = capture_php_output($root . '/sitemap.php');
if (str_contains($sitemap, '<urlset') && str_contains($sitemap, '<loc>')) {
    check('pass', 'sitemap-xml', 'sitemap.xml renders valid XML');
    $imageCount = substr_count($sitemap, '<image:image>');
    if ($imageCount >= 5) {
        check('pass', 'sitemap-images', "Sitemap lists {$imageCount} images");
    } else {
        check('warn', 'sitemap-images', "Sitemap only has {$imageCount} images");
    }
} else {
    check('fail', 'sitemap-xml', 'Sitemap output invalid');
}

$robots = capture_php_output($root . '/robots.php');
if (str_contains($robots, 'Sitemap:') && str_contains($robots, 'Allow: /')) {
    check('pass', 'robots-txt', 'robots.txt allows crawling + sitemap reference');
} else {
    check('fail', 'robots-txt', 'robots.txt misconfigured');
}

if (str_contains($robots, 'Disallow: /includes/')) {
    check('pass', 'robots-protect', 'Sensitive paths blocked in robots.txt');
} else {
    check('warn', 'robots-protect', 'includes/ not disallowed in robots');
}

// ── Config gaps ──
if (!empty($config['whatsapp'])) {
    check('pass', 'whatsapp-config', 'WhatsApp number configured');
} else {
    check('warn', 'whatsapp-config', 'WhatsApp empty — schema telephone + CTAs degraded');
}

if (!empty($config['twitter_handle'])) {
    check('pass', 'twitter-handle', 'Twitter handle configured');
} else {
    check('warn', 'twitter-handle', 'twitter_handle empty — no twitter:site meta');
}

$sameAs = $config['same_as'] ?? [];
$realProfiles = array_filter($sameAs, fn ($u) => !in_array(rtrim($u, '/'), ['https://github.com', 'https://linkedin.com'], true));
if (count($realProfiles) >= 1) {
    check('pass', 'same-as', 'Real sameAs social profiles linked in schema');
} else {
    check('warn', 'same-as', 'sameAs uses placeholder GitHub/LinkedIn roots only');
}

if (empty($config['testimonials']['items'] ?? [])) {
    check('warn', 'testimonials', 'No testimonials — add social proof for trust signals');
}

// ── Output report ──
$pass = count($results['pass']);
$warn = count($results['warn']);
$fail = count($results['fail']);
$total = $pass + $warn + $fail;
$score = $total > 0 ? (int) round((($pass + $warn * 0.5) / $total) * 100) : 0;

echo "\n";
echo "══════════════════════════════════════════════════\n";
echo "  SEO & AEO AUDIT — {$config['site_url']}\n";
echo "══════════════════════════════════════════════════\n\n";
echo "Score: {$score}/100  ({$pass} pass · {$warn} warn · {$fail} fail)\n\n";

foreach (['fail' => 'FAIL', 'warn' => 'WARN', 'pass' => 'PASS'] as $level => $label) {
    if ($results[$level] === []) {
        continue;
    }
    echo "── {$label} ──────────────────────────────────────\n";
    foreach ($results[$level] as $item) {
        echo "  [{$label}] {$item['message']}\n";
    }
    echo "\n";
}

echo "Run external validation after deploy:\n";
echo "  • Google Rich Results: https://search.google.com/test/rich-results\n";
echo "  • Schema Validator:    https://validator.schema.org/\n";
echo "  • PageSpeed Insights:  https://pagespeed.web.dev/\n";
echo "\n";

exit($fail > 0 ? 1 : 0);
