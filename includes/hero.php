<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
?>
<section class="hero" aria-label="Introduction">
    <?php require __DIR__ . '/header.php'; ?>

    <div class="hero__stage">
        <p class="hero__intro" data-reveal data-reveal-type="blur" data-delay="100">
            <span class="hero__wave" aria-hidden="true">👋</span>,
            <?= e($config['intro']) ?>
        </p>

        <div class="hero__compose">
            <p class="hero__outline hero__photographer" aria-hidden="true" data-reveal data-reveal-type="scale" data-delay="350">
                <?= e($config['role_secondary']) ?>
            </p>

            <div class="hero__portrait-wrap" aria-hidden="true" data-reveal data-reveal-type="reveal-bottom" data-delay="320">
                <img
                    class="hero__portrait"
                    src="<?= e(local_asset('assets/images/portrait.png')) ?>"
                    alt="<?= e($config['author']) ?> — freelance full stack webdeveloper"
                    width="560"
                    height="720"
                    loading="eager"
                    fetchpriority="high"
                >
            </div>

            <h1 class="hero__solid">
                <span data-split-words><?= e($config['role_primary']) ?></span>
                <span class="hero__photographer hero__photographer--sr">
                    <?= e(' ' . $config['role_secondary']) ?>
                </span>
            </h1>
        </div>

        <div class="hero__meta" data-reveal data-reveal-type="up" data-delay="500">
            <p class="hero__location">based in <?= e($config['location']) ?>.</p>
            <ul class="hero__clients" aria-label="Tech stack" data-stagger>
                <?php foreach ($config['clients'] as $client): ?>
                    <li class="hero__client hero__client--<?= e($client) ?> reveal-child">
                        <?php require __DIR__ . '/client-logos.php'; ?>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="hero__ctas" data-reveal data-reveal-type="up" data-delay="600">
            <a href="<?= e($config['cta_primary']['href']) ?>" class="hero__cta hero__cta--fill">
                <?= e($config['cta_primary']['label']) ?>
            </a>
            <a href="<?= e($config['cta_secondary']['href']) ?>" class="hero__cta hero__cta--ghost">
                <?= e($config['cta_secondary']['label']) ?>
            </a>
        </div>

        <?php require __DIR__ . '/ai-chat.php'; ?>
    </div>
</section>
