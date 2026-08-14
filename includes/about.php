<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$about = $config['about'];
$slides = $about['slides'];
$activeSlide = (int) ($about['active_slide'] ?? 0);
?>
<section class="about" id="about" aria-labelledby="about-heading">
    <div class="about__grid-lines" aria-hidden="true"></div>

    <div class="about__layout">
        <aside class="about__side" aria-label="Section navigation" data-reveal data-reveal-type="left" data-delay="0">
            <p class="about__side-brand">Guru.</p>
            <nav class="about__side-nav" data-stagger>
                <?php foreach ($about['side_nav'] as $item): ?>
                    <a class="reveal-child" href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a>
                <?php endforeach; ?>
            </nav>
        </aside>

        <div class="about__main">
            <article class="about__copy">
                <p class="about__eyebrow" data-reveal data-reveal-type="blur" data-delay="40">
                    <?= e($about['eyebrow']) ?>
                </p>

                <h2 class="about__title" id="about-heading">
                    <span class="about__title-lead" data-reveal data-reveal-type="up" data-delay="80">
                        <?= e($about['title_lead']) ?>
                    </span>
                    <span class="about__title-word" data-reveal data-reveal-type="up" data-delay="180">
                        <?= e($about['title']) ?>
                    </span>
                </h2>

                <p class="about__body" data-reveal data-reveal-type="up" data-delay="260">
                    <?= e($about['body']) ?>
                </p>

                <div class="about__meta" aria-label="Quick details" data-reveal data-reveal-type="up" data-delay="320" data-stagger>
                    <?php foreach ($about['meta'] as $meta): ?>
                        <div class="about__meta-item reveal-child">
                            <span class="about__meta-label"><?= e($meta['label']) ?></span>
                            <span class="about__meta-value"><?= e($meta['value']) ?></span>
                        </div>
                    <?php endforeach; ?>
                </div>

                <div class="about__actions" data-reveal data-reveal-type="up" data-delay="400" data-stagger>
                    <a href="<?= e($about['cta_primary']['href']) ?>" class="about__btn about__btn--fill reveal-child">
                        <span class="about__btn-ink" aria-hidden="true"></span>
                        <span class="about__btn-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16">
                                <path fill="currentColor" d="M20 6h-3V4a2 2 0 0 0-2-2h-6a2 2 0 0 0-2 2v2H4a2 2 0 0 0-2 2v11a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2V8a2 2 0 0 0-2-2zM9 4h6v2H9V4z"/>
                            </svg>
                        </span>
                        <span class="about__btn-label"><?= e($about['cta_primary']['label']) ?></span>
                    </a>
                    <a href="<?= e($about['cta_secondary']['href']) ?>" class="about__btn about__btn--ghost reveal-child">
                        <span class="about__btn-ink" aria-hidden="true"></span>
                        <span class="about__btn-icon" aria-hidden="true">
                            <svg viewBox="0 0 24 24" width="16" height="16">
                                <path fill="currentColor" d="M8 5v14l11-7L8 5z"/>
                            </svg>
                        </span>
                        <span class="about__btn-label"><?= e($about['cta_secondary']['label']) ?></span>
                    </a>
                </div>
            </article>

            <div class="about__info" id="about-info" data-reveal data-reveal-type="up" data-delay="80">
                <p class="about__info-label">Info</p>
                <ul class="about__info-cols" aria-label="Capabilities" data-stagger>
                    <?php foreach ($about['features'] as $feature): ?>
                        <li class="about__info-col reveal-child">
                            <span><?= e($feature) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <figure class="about__visual" data-reveal data-reveal-type="right" data-delay="120">
            <div class="about__slider" id="about-slider">
                <?php foreach ($slides as $i => $slide): ?>
                    <?php
                    $isActive = $i === $activeSlide;
                    render_responsive_image([
                        'src' => ltrim($slide['src'], '/'),
                        'alt' => $slide['alt'],
                        'class' => 'about__slide' . ($isActive ? ' is-active' : ''),
                        'widths' => [480, 640, 800],
                        'sizes' => '(max-width: 768px) 90vw, (max-width: 1200px) 45vw, 560px',
                        'width' => (int) ($slide['width'] ?? 1024),
                        'height' => (int) ($slide['height'] ?? 1536),
                        'loading' => $isActive ? 'eager' : 'lazy',
                        'fetchpriority' => $isActive ? 'high' : null,
                        'decoding' => 'async',
                        'lazy_src' => !$isActive,
                        'attrs' => [
                            'data-index' => (string) $i,
                        ],
                    ]);
                    ?>
                <?php endforeach; ?>
            </div>

            <div class="about__pager" aria-label="Slide pagination" data-reveal data-reveal-type="right" data-delay="420">
                <?php foreach ($slides as $i => $slide): ?>
                    <button
                        type="button"
                        class="about__pager-btn<?= $i === $activeSlide ? ' is-active' : '' ?>"
                        data-slide="<?= (int) $i ?>"
                        aria-label="Show slide <?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?>"
                    >
                        <?= str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT) ?>
                    </button>
                <?php endforeach; ?>
            </div>

            <div class="about__nav-controls" data-reveal data-reveal-type="up" data-delay="500">
                <button type="button" class="about__nav-btn" id="about-prev" aria-label="Previous slide">←</button>
                <button type="button" class="about__nav-btn" id="about-next" aria-label="Next slide">→</button>
            </div>
            <figcaption class="about__visual-caption visually-hidden">
                <?= e($slides[$activeSlide]['alt'] ?? 'About Guruprasad — web developer in Kochi, Kerala') ?>
            </figcaption>
        </figure>
    </div>
</section>
