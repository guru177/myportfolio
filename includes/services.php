<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$section = $config['services_section'] ?? null;
if (!$section) {
    return;
}
?>
<section class="seo-block seo-block--services" id="services" aria-labelledby="services-heading">
    <div class="seo-block__inner">
        <header class="seo-block__header">
            <p class="seo-block__eyebrow" data-reveal data-reveal-type="blur" data-delay="0">
                <?= e($section['eyebrow']) ?>
            </p>
            <h2 class="seo-block__heading" id="services-heading" data-reveal data-reveal-type="up" data-delay="60">
                <?= e($section['heading']) ?>
            </h2>
            <p class="seo-block__lead" data-reveal data-reveal-type="up" data-delay="120">
                <?= e($section['body']) ?>
            </p>
        </header>

        <ul class="seo-grid seo-grid--services" data-reveal data-reveal-type="up" data-delay="160" data-stagger>
            <?php foreach ($section['items'] as $i => $item): ?>
                <li class="seo-card seo-card--service reveal-child" style="--i: <?= (int) $i ?>">
                    <span class="seo-card__index" aria-hidden="true"><?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <div class="seo-card__body">
                        <h3 class="seo-card__title"><?= e($item['title']) ?></h3>
                        <p class="seo-card__copy"><?= e($item['copy']) ?></p>
                    </div>
                    <a class="seo-card__cta" href="#contact">
                        Get a quote
                        <span aria-hidden="true">→</span>
                    </a>
                    <span class="seo-card__ink" aria-hidden="true"></span>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
