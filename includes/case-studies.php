<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$section = $config['case_studies'] ?? null;
if (!$section) {
    return;
}
?>
<section class="seo-block seo-block--dark" id="case-studies" aria-labelledby="case-studies-heading">
    <div class="seo-block__inner">
        <p class="seo-block__eyebrow" data-reveal data-reveal-type="blur" data-delay="0">
            <?= e($section['eyebrow']) ?>
        </p>
        <h2 class="seo-block__heading" id="case-studies-heading" data-reveal data-reveal-type="up" data-delay="60">
            <?= e($section['heading']) ?>
        </h2>
        <p class="seo-block__lead" data-reveal data-reveal-type="up" data-delay="120">
            <?= e($section['body']) ?>
        </p>

        <ul class="seo-grid" data-reveal data-reveal-type="up" data-delay="160" data-stagger>
            <?php foreach ($section['items'] as $i => $item): ?>
                <li class="seo-card seo-card--case reveal-child" style="--i: <?= (int) $i ?>">
                    <span class="seo-card__index" aria-hidden="true"><?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <h3 class="seo-card__title"><?= e($item['title']) ?></h3>
                    <p class="seo-card__copy"><strong>Problem:</strong> <?= e($item['problem']) ?></p>
                    <p class="seo-card__copy seo-card__copy--gap"><strong>Solution:</strong> <?= e($item['solution']) ?></p>
                    <p class="seo-card__meta"><?= e(implode(' · ', $item['stack'] ?? [])) ?></p>
                    <p class="seo-card__copy seo-card__copy--gap"><strong>Outcome:</strong> <?= e($item['outcome']) ?></p>
                    <?php if (!empty($item['href'])): ?>
                        <a class="seo-card__link" href="<?= e($item['href']) ?>">Discuss a similar project →</a>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
