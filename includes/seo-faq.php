<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$faq = $config['faq'] ?? [];
if ($faq === []) {
    return;
}
?>
<section class="seo-faq" id="faq" aria-labelledby="faq-heading">
    <div class="seo-faq__inner">
        <header class="seo-faq__header">
            <div class="seo-faq__intro">
                <p class="seo-faq__eyebrow" data-reveal data-reveal-type="blur" data-delay="0">
                    FAQ · Kerala Web Developer
                </p>
                <h2 class="seo-faq__heading" id="faq-heading" data-reveal data-reveal-type="up" data-delay="60">
                    Website development FAQs for Kerala businesses
                </h2>
            </div>
            <p class="seo-faq__lead" data-reveal data-reveal-type="up" data-delay="120">
                Practical answers on cost, timelines, ecommerce, maintenance, and working beyond Kerala.
            </p>
        </header>

        <div class="seo-faq__list" data-reveal data-reveal-type="up" data-delay="160" data-stagger>
            <?php foreach ($faq as $i => $item): ?>
                <details class="seo-faq__item reveal-child" style="--i: <?= (int) $i ?>"<?= $i === 0 ? ' open' : '' ?>>
                    <summary class="seo-faq__question">
                        <span class="seo-faq__index" aria-hidden="true"><?= e(str_pad((string) ($i + 1), 2, '0', STR_PAD_LEFT)) ?></span>
                        <span class="seo-faq__q-text"><?= e($item['q']) ?></span>
                        <span class="seo-faq__toggle" aria-hidden="true"></span>
                    </summary>
                    <div class="seo-faq__answer">
                        <p><?= e($item['a']) ?></p>
                    </div>
                </details>
            <?php endforeach; ?>
        </div>

        <aside class="seo-faq__areas" aria-label="Service areas in Kerala" data-reveal data-reveal-type="up" data-delay="220">
            <div class="seo-faq__areas-main">
                <h3 class="seo-faq__areas-title">Serving Kochi &amp; Kerala</h3>
                <ul class="seo-faq__areas-list">
                    <?php foreach ($config['service_areas'] ?? [] as $area): ?>
                        <li><?= e($area) ?></li>
                    <?php endforeach; ?>
                </ul>
                <p class="seo-faq__areas-copy">
                    Hire a web developer based in <?= e($config['location']) ?> for websites, web apps, ecommerce, and ongoing maintenance.
                </p>
            </div>

            <div
                class="seo-faq__visual"
                aria-hidden="true"
            >
                <div
                    class="seo-faq__lottie"
                    id="faq-lottie"
                    data-lottie
                    data-src="<?= e(local_asset('assets/lottie/faq-web.json')) ?>"
                ></div>
            </div>
        </aside>
    </div>
</section>
