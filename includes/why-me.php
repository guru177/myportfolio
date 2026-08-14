<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$section = $config['why_me'] ?? null;
if (!$section) {
    return;
}
?>
<section class="seo-block seo-block--why" id="why-me" aria-labelledby="why-me-heading">
    <div class="seo-block__inner">
        <header class="seo-block__header seo-block__header--split">
            <div class="seo-block__intro">
                <p class="seo-block__eyebrow" data-reveal data-reveal-type="blur" data-delay="0">
                    <?= e($section['eyebrow']) ?>
                </p>
                <h2 class="seo-block__heading" id="why-me-heading" data-reveal data-reveal-type="up" data-delay="60">
                    <?= e($section['heading']) ?>
                </h2>
                <p class="seo-block__lead" data-reveal data-reveal-type="up" data-delay="120">
                    <?= e($section['body']) ?>
                </p>
            </div>

            <div
                class="why-me__visual"
                data-reveal
                data-reveal-type="scale"
                data-delay="140"
                aria-hidden="true"
            >
                <div
                    class="why-me__lottie"
                    id="why-me-lottie"
                    data-lottie
                    data-src="<?= e(local_asset('assets/lottie/why-me-dev.json')) ?>"
                ></div>
            </div>
        </header>

        <ul class="seo-grid" data-reveal data-reveal-type="up" data-delay="160" data-stagger>
            <?php foreach ($section['points'] as $i => $point): ?>
                <li class="seo-card reveal-child" style="--i: <?= (int) $i ?>">
                    <span class="seo-card__index" aria-hidden="true"><?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                    <h3 class="seo-card__title"><?= e($point['title']) ?></h3>
                    <p class="seo-card__copy"><?= e($point['copy']) ?></p>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</section>
