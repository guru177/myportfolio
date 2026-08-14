<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$section = $config['locations_section'] ?? null;
if (!$section) {
    return;
}

$cities = $section['cities'] ?? [];
$hub = $cities[0] ?? 'Kochi';
$cityLoop = array_merge($cities, $cities);
?>
<section class="locations" id="locations" aria-labelledby="locations-heading">
    <div class="locations__inner">
        <div class="locations__top">
            <div class="locations__intro">
                <p class="locations__eyebrow" data-reveal data-reveal-type="blur" data-delay="0">
                    <?= e($section['eyebrow']) ?>
                </p>
                <h2 class="locations__heading" id="locations-heading" data-reveal data-reveal-type="up" data-delay="60">
                    <?= e($section['heading']) ?>
                </h2>
            </div>
            <p class="locations__lead" data-reveal data-reveal-type="up" data-delay="120">
                <?= e($section['body']) ?>
            </p>
        </div>

        <div class="locations__hub" data-reveal data-reveal-type="up" data-delay="160">
            <span class="locations__hub-pulse" aria-hidden="true"></span>
            <div class="locations__hub-copy">
                <p class="locations__hub-label">Base</p>
                <p class="locations__hub-city"><?= e($hub) ?>, Kerala</p>
            </div>
            <p class="locations__hub-note">Local context · remote-ready · pan-India clients welcome</p>
        </div>
    </div>

    <div class="locations__rails" aria-label="Cities served across Kerala" data-reveal data-reveal-type="up" data-delay="200">
        <div class="locations__rail locations__rail--ltr">
            <div class="locations__track">
                <?php foreach ($cityLoop as $i => $city): ?>
                    <span class="locations__chip<?= $city === $hub ? ' locations__chip--hub' : '' ?>">
                        <?= e($city) ?>
                    </span>
                    <span class="locations__dot" aria-hidden="true"></span>
                <?php endforeach; ?>
            </div>
        </div>
        <div class="locations__rail locations__rail--rtl">
            <div class="locations__track">
                <?php foreach (array_reverse($cityLoop) as $city): ?>
                    <span class="locations__chip<?= $city === $hub ? ' locations__chip--hub' : '' ?>">
                        <?= e($city) ?>
                    </span>
                    <span class="locations__dot" aria-hidden="true"></span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

</section>
