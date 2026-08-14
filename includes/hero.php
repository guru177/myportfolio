<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */

if (!function_exists('render_cta_label')) {
    function render_cta_label(string $label): void
    {
        echo '<span class="hero__cta-ink" aria-hidden="true"></span>';
        echo '<span class="hero__cta-text">';
        $index = 0;
        $chars = preg_split('//u', $label, -1, PREG_SPLIT_NO_EMPTY) ?: [];
        foreach ($chars as $char) {
            if ($char === ' ') {
                echo '<span class="hero__cta-char hero__cta-char--space">&nbsp;</span>';
                continue;
            }
            echo '<span class="hero__cta-char" style="--i:' . $index . '">' . e($char) . '</span>';
            $index++;
        }
        echo '</span>';
    }
}

$heroSeo = $config['hero_seo'] ?? [];
$quoteCta = $heroSeo['cta_quote'] ?? $config['cta_primary'];
$waLabel = $heroSeo['cta_whatsapp']['label'] ?? 'WhatsApp';
?>
<section class="hero" aria-label="Introduction">
    <?php require __DIR__ . '/header.php'; ?>

    <div class="hero__stage">
        <p class="hero__intro" data-reveal data-reveal-type="blur" data-delay="100">
            <span class="hero__wave" aria-hidden="true">👋</span>,
            <?= e($config['intro']) ?>
            <span class="hero__intro-role"> <?= e($config['role_secondary']) ?></span>
        </p>

        <h1 class="hero__seo-h1" data-reveal data-reveal-type="up" data-delay="120">
            <?= e($heroSeo['h1'] ?? 'Best Web Developer in Kerala') ?>
        </h1>

        <?php if (!empty($heroSeo['value_prop'])): ?>
        <p class="hero__seo-value" data-reveal data-reveal-type="up" data-delay="140">
            <?= e($heroSeo['value_prop']) ?>
        </p>
        <?php endif; ?>

        <?php if (!empty($heroSeo['services_line'])): ?>
        <p class="hero__seo-services" data-reveal data-reveal-type="up" data-delay="160">
            <?= e($heroSeo['services_line']) ?>
        </p>
        <?php endif; ?>

        <div class="hero__web-fx" id="hero-web-fx" aria-hidden="true">
            <div class="hero__web-burst" id="hero-web-burst">
                <?php render_responsive_image([
                    'src' => 'assets/images/spider-web.png',
                    'alt' => '',
                    'class' => 'hero__web-image',
                    'widths' => [400, 800],
                    'sizes' => 'min(440px, 38vw)',
                    'width' => 800,
                    'height' => 800,
                    'loading' => 'lazy',
                    'decoding' => 'async',
                ]); ?>
                <span class="hero__web-shot-node"></span>
                <span class="hero__web-shot-line"></span>
            </div>
        </div>

        <div class="hero__compose" aria-hidden="true">
            <p
                class="hero__outline hero__photographer"
                id="hero-web-trigger"
                tabindex="0"
                data-reveal
                data-reveal-type="scale"
                data-delay="350"
            >
                <span class="hero__web-trigger-text"><?= e($config['role_secondary']) ?></span>
            </p>

            <div class="hero__portrait-wrap" aria-hidden="true" data-reveal data-reveal-type="reveal-bottom" data-delay="320">
                <?php render_responsive_image([
                    'src' => 'assets/images/portrait.png',
                    'alt' => $config['author'] . ' — best web developer in Kochi, Kerala',
                    'class' => 'hero__portrait',
                    'widths' => [280, 420, 560],
                    'sizes' => '(max-width: 984px) 46vw, 40vw',
                    'width' => 690,
                    'height' => 712,
                    'loading' => 'eager',
                    'fetchpriority' => 'high',
                    'decoding' => 'async',
                ]); ?>
            </div>

            <p class="hero__solid">
                <span data-split-words><?= e($config['role_primary']) ?></span>
            </p>
        </div>

        <div class="hero__meta" data-reveal data-reveal-type="up" data-delay="500">
            <p class="hero__location">based in <?= e($config['location']) ?>.</p>
            <ul class="hero__clients" aria-label="Tech stack" data-stagger>
                <?php foreach ($config['clients'] as $client): ?>
                    <li class="hero__client hero__client--<?= e($client) ?> reveal-child" tabindex="0">
                        <?php require __DIR__ . '/client-logos.php'; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="hero__ctas" data-reveal data-reveal-type="up" data-delay="600">
            <a href="<?= e($quoteCta['href'] ?? '#contact') ?>" class="hero__cta hero__cta--fill">
                <?php render_cta_label((string) ($quoteCta['label'] ?? 'Get a Quote')); ?>
            </a>
            <a
                href="<?= e(whatsapp_url('Hi Guruprasad, I need a website quote.')) ?>"
                class="hero__cta hero__cta--ghost"
                target="_blank"
                rel="noopener noreferrer"
            >
                <?php render_cta_label((string) $waLabel); ?>
            </a>
        </div>

        <?php require __DIR__ . '/ai-chat.php'; ?>
    </div>
</section>
