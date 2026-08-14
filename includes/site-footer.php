<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$footer = $config['footer'];
$year = (int) date('Y');
?>
<footer class="site-footer" id="site-footer">
    <div class="site-footer__inner">
        <div class="site-footer__top">
            <div class="site-footer__brand">
                <a class="site-footer__logo" href="<?= e(local_asset('/')) ?>"><?= e($config['site_name']) ?></a>
                <p class="site-footer__tagline"><?= e($footer['tagline']) ?></p>
            </div>

            <nav class="site-footer__nav" aria-label="Footer">
                <?php foreach ($footer['nav'] as $item): ?>
                    <a href="<?= e($item['href']) ?>"><?= e($item['label']) ?></a>
                <?php endforeach; ?>
            </nav>

            <ul class="site-footer__social">
                <?php foreach ($footer['social'] as $item): ?>
                    <?php
                    $href = $item['href'];
                    if ($href === 'whatsapp') {
                        $href = whatsapp_url('Hi Guruprasad, I found your portfolio.');
                    }
                    $isExternal = str_starts_with($href, 'http');
                    ?>
                    <li>
                        <a
                            href="<?= e($href) ?>"
                            <?= $isExternal ? 'target="_blank" rel="noopener noreferrer me"' : '' ?>
                        ><?= e($item['label']) ?></a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>

        <div class="site-footer__bottom">
            <p class="site-footer__note"><?= e($footer['note']) ?></p>
            <p class="site-footer__copy">&copy; <?= $year ?> <?= e($config['author']) ?>. All rights reserved.</p>
        </div>
    </div>
</footer>
