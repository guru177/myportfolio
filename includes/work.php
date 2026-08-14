<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$work = $config['work'];
$projects = $work['projects'];
$more = $work['more'];
$count = str_pad((string) count($projects), 2, '0', STR_PAD_LEFT);
?>
<section class="work" id="portfolio" aria-labelledby="work-heading">
    <span id="projects" hidden></span>
    <div class="work__inner">
        <header class="work__header">
            <div class="work__header-top" data-reveal data-reveal-type="up" data-delay="0">
                <p class="work__eyebrow"><?= e($work['eyebrow']) ?></p>
                <p class="work__count" aria-hidden="true">
                    <span><?= e($count) ?></span>
                    <span>Projects</span>
                </p>
            </div>

            <div class="work__header-main">
                <h2 class="work__heading" id="work-heading" data-reveal data-reveal-type="up" data-delay="80">
                    <?= e($work['heading']) ?>
                </h2>
                <p class="work__body" data-reveal data-reveal-type="up" data-delay="140">
                    <?= e($work['body']) ?>
                </p>
            </div>
        </header>

        <div class="work__grid" data-reveal data-reveal-type="up" data-delay="80" data-stagger>
            <?php foreach ($projects as $project): ?>
                <article class="work__item reveal-child">
                    <a class="work__card" href="<?= e($project['href']) ?>">
                        <span class="work__media">
                            <?php render_responsive_image([
                                'src' => ltrim($project['image'], '/'),
                                'alt' => $project['image_alt'],
                                'class' => 'work__image',
                                'widths' => [480, 640],
                                'sizes' => '(max-width: 768px) 100vw, (max-width: 1200px) 50vw, 33vw',
                                'width' => 640,
                                'height' => 480,
                                'loading' => 'lazy',
                                'decoding' => 'async',
                            ]); ?>
                            <span class="work__code"><?= e($project['code']) ?></span>
                        </span>

                        <span class="work__content">
                            <span class="work__meta">
                                <span class="work__category"><?= e($project['category']) ?></span>
                                <span class="work__year"><?= e($project['year']) ?></span>
                            </span>
                            <span class="work__title"><?= e($project['title']) ?></span>
                            <span class="work__stack">
                                <?= e(implode(' · ', $project['stack'])) ?>
                            </span>
                        </span>
                    </a>
                </article>
            <?php endforeach; ?>
        </div>

        <div class="work__more" data-reveal data-reveal-type="up" data-delay="120">
            <div class="work__more-copy">
                <p class="work__more-label"><?= e($more['label']) ?></p>
                <p class="work__more-body"><?= e($more['body']) ?></p>
            </div>
            <a class="work__more-btn" href="<?= e($more['href']) ?>">
                <span class="work__more-ink" aria-hidden="true"></span>
                <span class="work__more-label-btn"><?= e($more['button']) ?></span>
                <span class="work__more-arrow" aria-hidden="true">→</span>
            </a>
        </div>
    </div>
</section>
