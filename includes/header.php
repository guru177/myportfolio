<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
?>
<header class="hero__nav" data-reveal data-reveal-type="down" data-delay="0">
    <a href="/" class="hero__logo" aria-label="<?= e($config['site_name']) ?> home">
        <span class="hero__logo-mark" aria-hidden="true">
            <span class="hero__logo-orb hero__logo-orb--a"></span>
            <span class="hero__logo-orb hero__logo-orb--b"></span>
        </span>
        <span class="hero__logo-word">
            Guru<span class="hero__logo-dot" aria-hidden="true"></span>
        </span>
    </a>

    <div class="hero__nav-right">
        <nav class="hero__links" aria-label="Primary">
            <?php foreach ($config['nav'] as $i => $item): ?>
                <a href="<?= e($item['href']) ?>" style="--i: <?= (int) $i ?>"><?= e($item['label']) ?></a>
            <?php endforeach; ?>
        </nav>

        <a class="hero__mail" href="<?= e(whatsapp_url('Hi Guruprasad, I found your portfolio.')) ?>" target="_blank" rel="noopener noreferrer">
            WhatsApp
        </a>
    </div>
</header>
