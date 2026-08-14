<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$section = $config['testimonials'] ?? null;
$items = $section['items'] ?? [];
if (!$section || $items === []) {
    return;
}
?>
<section class="seo-block seo-block--dark" id="testimonials" aria-labelledby="testimonials-heading">
    <div class="seo-block__inner">
        <p class="seo-block__eyebrow"><?= e($section['eyebrow']) ?></p>
        <h2 class="seo-block__heading" id="testimonials-heading"><?= e($section['heading']) ?></h2>
        <?php if (!empty($section['body'])): ?>
            <p class="seo-block__lead"><?= e($section['body']) ?></p>
        <?php endif; ?>

        <ul class="seo-grid">
            <?php foreach ($items as $item): ?>
                <li class="seo-quote">
                    <blockquote>
                        <p class="seo-quote__text"><?= e($item['quote']) ?></p>
                        <cite class="seo-quote__cite">
                            <?= e($item['name']) ?><?= !empty($item['business']) ? ' · ' . e($item['business']) : '' ?>
                        </cite>
                    </blockquote>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
