<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$marquee = $config['marquee'];

function render_marquee_sequence(array $items, int $repeat = 2): void
{
    for ($r = 0; $r < $repeat; $r++) {
        foreach ($items as $item) {
            $phrase = trim((string) $item);
            echo '<span class="marquee-strip__item marquee-word" data-word="' . e($phrase) . '" tabindex="0">' . e($phrase) . '</span>';
            echo '<span class="marquee-strip__sep" aria-hidden="true">✦</span>';
        }
    }
}
?>
<section class="marquee-strips" aria-label="Highlights">
    <div class="marquee-strip marquee-strip--ltr marquee-strip--dark">
        <div class="marquee-strip__track">
            <?php render_marquee_sequence($marquee['strip_one'], 2); ?>
        </div>
    </div>

    <div class="marquee-strip marquee-strip--rtl marquee-strip--accent">
        <div class="marquee-strip__track">
            <?php render_marquee_sequence($marquee['strip_two'], 2); ?>
        </div>
    </div>
</section>
