<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$wwd = $config['what_we_do'];

function wwd_icon(string $name): void
{
    $icons = [
        'bolt' => '<path d="M13 2 4 14h7l-1 8 10-14h-7l0-6z" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linejoin="round"/>',
        'chip' => '<rect x="5" y="7" width="14" height="10" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M9 7V4M12 7V4M15 7V4M9 20v-3M12 20v-3M15 20v-3M5 10H3M5 14H3M21 10h-2M21 14h-2" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'wave' => '<path d="M3 12c2-4 4-4 6 0s4 4 6 0 4-4 6 0" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round"/>',
        'battery' => '<rect x="3" y="8" width="15" height="8" rx="1.5" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M18 11h2v2h-2M6 11h7" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'bluetooth' => '<path d="M7 7l10 5-5 3V4l5 3-10 5" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round"/>',
        'mic' => '<rect x="9" y="3" width="6" height="11" rx="3" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M6 11a6 6 0 0 0 12 0M12 17v4M9 21h6" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'gamepad' => '<rect x="3" y="8" width="18" height="10" rx="4" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M8 13h4M10 11v4M16 12h.01M18 14h.01" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'target' => '<circle cx="12" cy="12" r="8" fill="none" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" fill="none" stroke="currentColor" stroke-width="1.5"/><path d="M12 2v3M12 19v3M2 12h3M19 12h3" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>',
        'diamond' => '<path d="M12 3 20 9l-8 12L4 9l8-6z" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linejoin="round"/><path d="M4 9h16M12 3l-2 6 2 12 2-12-2-6" fill="none" stroke="currentColor" stroke-width="1.3"/>',
    ];

    $path = $icons[$name] ?? $icons['bolt'];
    echo '<svg class="wwd-icon" viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">' . $path . '</svg>';
}
?>
<section class="wwd" id="what-we-do" aria-labelledby="wwd-heading">
    <div class="wwd__inner">
        <div class="wwd__stats-wrap" data-reveal data-reveal-type="up" data-delay="0">
            <div class="wwd__stats tech-frame tech-frame--stats" data-stagger>
                <?php foreach ($wwd['stats'] as $stat): ?>
                    <article class="wwd__stat reveal-child">
                        <div class="wwd__stat-top">
                            <?php wwd_icon($stat['icon']); ?>
                            <span class="wwd__stat-label"><?= e($stat['label']) ?></span>
                        </div>
                        <p class="wwd__stat-value"><?= e($stat['value']) ?></p>
                        <p class="wwd__stat-sub"><?= e($stat['sub']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>

            <div class="wwd__stats-orbit" aria-hidden="true">
                <span class="wwd__stats-dot"></span>
                <span class="wwd__stats-dot wwd__stats-dot--delayed"></span>
            </div>
        </div>

        <div class="wwd__body">
            <figure class="wwd__stage tech-frame tech-frame--stage" data-reveal data-reveal-type="left" data-delay="60" tabindex="0">
                <div class="wwd__stage-shell" aria-hidden="true"></div>
                <span class="wwd__stage-bracket wwd__stage-bracket--tl" aria-hidden="true"></span>
                <span class="wwd__stage-bracket wwd__stage-bracket--tr" aria-hidden="true"></span>
                <span class="wwd__stage-bracket wwd__stage-bracket--bl" aria-hidden="true"></span>
                <span class="wwd__stage-bracket wwd__stage-bracket--br" aria-hidden="true"></span>

                <div class="wwd__stage-mark">
                    <span class="wwd__stage-x" aria-hidden="true">✕</span>
                    <span><?= e($wwd['frame']['code']) ?></span>
                </div>

                <div class="wwd__stage-radar" aria-hidden="true"></div>
                <div class="wwd__stage-dots" aria-hidden="true"></div>

                <div
                    class="wwd__stage-lottie"
                    id="wwd-stage-lottie"
                    data-lottie
                    data-src="<?= e(local_asset(ltrim($wwd['frame']['lottie'], '/'))) ?>"
                    role="img"
                    aria-label="<?= e($wwd['frame']['lottie_alt']) ?>"
                ></div>

                <p class="wwd__stage-tagline"><?= e($wwd['frame']['tagline']) ?></p>
                <div class="wwd__stage-stripes" aria-hidden="true"></div>
            </figure>

            <div class="wwd__content">
                <p class="wwd__eyebrow" data-reveal data-reveal-type="blur" data-delay="80">
                    <?= e($wwd['eyebrow']) ?>
                </p>
                <h2 class="wwd__heading" id="wwd-heading" data-reveal data-reveal-type="up" data-delay="140">
                    <?= e($wwd['heading']) ?>
                </h2>
                <p class="wwd__body-text" data-reveal data-reveal-type="up" data-delay="200">
                    <?= e($wwd['body']) ?>
                </p>

                <ul class="wwd__specs" data-reveal data-reveal-type="up" data-delay="260" data-stagger aria-label="Capabilities">
                    <?php foreach ($wwd['specs'] as $spec): ?>
                        <li class="wwd__spec reveal-child">
                            <span class="wwd__spec-icon"><?php wwd_icon($spec['icon']); ?></span>
                            <span class="wwd__spec-label"><?= e($spec['label']) ?></span>
                            <span class="wwd__spec-copy">
                                <strong><?= e($spec['title']) ?></strong>
                                <span><?= e($spec['detail']) ?></span>
                            </span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>
        </div>

        <div class="wwd__pillars-wrap" data-reveal data-reveal-type="up" data-delay="80">
            <div class="wwd__pillars-orbit" aria-hidden="true">
                <span class="wwd__pillars-line"></span>
                <span class="wwd__pillars-dot"></span>
                <span class="wwd__pillars-dot wwd__pillars-dot--delayed"></span>
            </div>

            <div class="wwd__pillars" data-stagger>
                <?php foreach ($wwd['pillars'] as $pillar): ?>
                    <article class="wwd__pillar reveal-child">
                        <span class="wwd__pillar-icon"><?php wwd_icon($pillar['icon']); ?></span>
                        <p class="wwd__pillar-title"><?= e($pillar['title']) ?></p>
                    </article>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</section>
