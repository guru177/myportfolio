<?php

declare(strict_types=1);

/**
 * Responsive image helpers for SEO and performance.
 */

function image_base_path(string $publicPath): string
{
    $clean = ltrim($publicPath, '/');
    $root = dirname(__DIR__);

    return $root . '/' . $clean;
}

function image_variant_paths(string $publicPath, array $widths): array
{
    $abs = image_base_path($publicPath);
    $dir = pathinfo($abs, PATHINFO_DIRNAME);
    $base = pathinfo($abs, PATHINFO_FILENAME);
    $variants = [];

    foreach ($widths as $width) {
        $webp = $dir . DIRECTORY_SEPARATOR . $base . '-' . $width . 'w.webp';
        if (is_file($webp)) {
            $relative = str_replace('\\', '/', ltrim($publicPath, '/'));
            $dirPublic = str_replace('\\', '/', dirname($relative));
            $variants[$width] = '/' . ($dirPublic !== '.' ? $dirPublic . '/' : '') . $base . '-' . $width . 'w.webp';
        }
    }

    return $variants;
}

function image_srcset(array $variants): string
{
    $parts = [];
    foreach ($variants as $width => $path) {
        $parts[] = local_asset(ltrim($path, '/')) . ' ' . $width . 'w';
    }

    return implode(', ', $parts);
}

function image_dimensions(string $publicPath): array
{
    $abs = image_base_path($publicPath);
    if (!is_file($abs)) {
        return ['width' => 0, 'height' => 0];
    }

    $info = @getimagesize($abs);
    if ($info === false) {
        return ['width' => 0, 'height' => 0];
    }

    return ['width' => (int) $info[0], 'height' => (int) $info[1]];
}

/**
 * @param array{
 *   src: string,
 *   alt: string,
 *   class?: string,
 *   widths?: int[],
 *   sizes?: string,
 *   width?: int,
 *   height?: int,
 *   loading?: string,
 *   fetchpriority?: string,
 *   decoding?: string,
 *   lazy_src?: bool,
 *   attrs?: array<string, string|int|bool>
 * } $options
 */
function render_responsive_image(array $options): void
{
    $src = ltrim($options['src'], '/');
    $alt = $options['alt'];
    $class = $options['class'] ?? '';
    $widths = $options['widths'] ?? [];
    $sizes = $options['sizes'] ?? '100vw';
    $loading = $options['loading'] ?? 'lazy';
    $fetchpriority = $options['fetchpriority'] ?? null;
    $decoding = $options['decoding'] ?? 'async';
    $lazySrc = (bool) ($options['lazy_src'] ?? false);
    $extraAttrs = $options['attrs'] ?? [];

    $dims = image_dimensions($src);
    $width = $options['width'] ?? $dims['width'];
    $height = $options['height'] ?? $dims['height'];
    $variants = image_variant_paths($src, $widths);
    $webpSrcset = $variants !== [] ? image_srcset($variants) : '';
    $fallbackSrc = local_asset($src);

    $imgAttrs = [
        'class' => $class,
        'alt' => $alt,
        'width' => $width,
        'height' => $height,
        'decoding' => $decoding,
        'loading' => $loading,
    ];

    if ($fetchpriority !== null && $fetchpriority !== '') {
        $imgAttrs['fetchpriority'] = $fetchpriority;
    }

    if ($lazySrc) {
        $imgAttrs['src'] = 'data:image/gif;base64,R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7';
        $imgAttrs['data-src'] = $fallbackSrc;
        if ($webpSrcset !== '') {
            $imgAttrs['data-srcset'] = $webpSrcset;
        }
    } else {
        $imgAttrs['src'] = $fallbackSrc;
        if ($webpSrcset !== '') {
            $imgAttrs['srcset'] = $webpSrcset;
            $imgAttrs['sizes'] = $sizes;
        }
    }

    foreach ($extraAttrs as $key => $value) {
        $imgAttrs[$key] = $value;
    }

    echo '<img';
    foreach ($imgAttrs as $key => $value) {
        if ($key === 'alt' || ($value !== '' && $value !== false)) {
            echo ' ' . $key . '="' . e((string) $value) . '"';
        }
    }
    echo '>';

}

function lcp_preload_href(string $publicPath, array $widths, int $preferredWidth = 0): ?string
{
    $variants = image_variant_paths($publicPath, $widths);
    if ($variants === []) {
        return local_asset(ltrim($publicPath, '/'));
    }

    if ($preferredWidth > 0 && isset($variants[$preferredWidth])) {
        return local_asset(ltrim($variants[$preferredWidth], '/'));
    }

    $max = max(array_keys($variants));

    return local_asset(ltrim($variants[$max], '/'));
}

function sitemap_images_from_config(array $config): array
{
    $images = [
        [
            'loc' => asset($config['og_image']),
            'title' => $config['og_image_alt'] ?? $config['author'],
            'caption' => $config['og_image_alt'] ?? '',
        ],
        [
            'loc' => asset('/assets/images/portrait.png'),
            'title' => $config['author'] . ' — web developer in Kochi, Kerala',
            'caption' => 'Portrait of ' . $config['author'] . ', freelance full stack web developer in Kochi',
        ],
    ];

    foreach ($config['about']['slides'] ?? [] as $slide) {
        $images[] = [
            'loc' => asset($slide['src']),
            'title' => $slide['alt'] ?? $config['author'],
            'caption' => $slide['alt'] ?? '',
        ];
    }

    $seen = [];
    foreach ($config['work']['projects'] ?? [] as $project) {
        $path = $project['image'] ?? '';
        if ($path === '' || isset($seen[$path])) {
            continue;
        }
        $seen[$path] = true;
        $images[] = [
            'loc' => asset($path),
            'title' => $project['image_alt'] ?? $project['title'] ?? '',
            'caption' => $project['image_alt'] ?? '',
        ];
    }

    return $images;
}
