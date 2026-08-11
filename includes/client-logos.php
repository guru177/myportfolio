<?php

declare(strict_types=1);

/** @var string $client */
?>
<?php if ($client === 'laravel'): ?>
<svg viewBox="0 0 88 28" class="hero__client-svg" aria-hidden="true">
    <path fill="#9a9a9a" d="M3 22.5 10.5 2.5 14.5 2.5 8.5 18.5 12 18.5 18 2.5 22 2.5 14.5 22.5z"/>
    <text x="28" y="19" font-family="Manrope, sans-serif" font-size="14" font-weight="700" fill="#9a9a9a">Laravel</text>
</svg>
<?php elseif ($client === 'node'): ?>
<svg viewBox="0 0 70 28" class="hero__client-svg" aria-hidden="true">
    <path fill="#9a9a9a" d="M14 3.8 5.8 8.6v9.6L14 23l8.2-4.8V8.6L14 3.8zm0 2.4 5.8 3.4v6.8L14 20.2l-5.8-3.4v-6.8L14 6.2z"/>
    <text x="26" y="19" font-family="Manrope, sans-serif" font-size="14" font-weight="600" fill="#9a9a9a">Node</text>
</svg>
<?php elseif ($client === 'electron'): ?>
<svg viewBox="0 0 92 28" class="hero__client-svg" aria-hidden="true">
    <ellipse cx="14" cy="14" rx="10.5" ry="4.8" fill="none" stroke="#9a9a9a" stroke-width="1.3"/>
    <ellipse cx="14" cy="14" rx="10.5" ry="4.8" fill="none" stroke="#9a9a9a" stroke-width="1.3" transform="rotate(60 14 14)"/>
    <ellipse cx="14" cy="14" rx="10.5" ry="4.8" fill="none" stroke="#9a9a9a" stroke-width="1.3" transform="rotate(120 14 14)"/>
    <circle cx="14" cy="14" r="2.3" fill="#9a9a9a"/>
    <text x="28" y="19" font-family="Manrope, sans-serif" font-size="13" font-weight="700" fill="#9a9a9a">Electron</text>
</svg>
<?php elseif ($client === 'php'): ?>
<svg viewBox="0 0 50 28" class="hero__client-svg" aria-hidden="true">
    <ellipse cx="25" cy="14" rx="23" ry="11.5" fill="none" stroke="#9a9a9a" stroke-width="1.4"/>
    <text x="25" y="18.5" text-anchor="middle" font-family="Manrope, sans-serif" font-size="13" font-weight="800" font-style="italic" fill="#9a9a9a">PHP</text>
</svg>
<?php else: ?>
<svg viewBox="0 0 78 28" class="hero__client-svg" aria-hidden="true">
    <path fill="#9a9a9a" d="M7 3h12l7.5 11L19 25H7l7.5-11L7 3zm2.8 2.8L15.8 14l-6 9.2h8.4l5.8-9.2-5.8-9.2H9.8z"/>
    <text x="30" y="19" font-family="Manrope, sans-serif" font-size="14" font-weight="800" letter-spacing="0.4" fill="#9a9a9a">HTML</text>
</svg>
<?php endif; ?>
