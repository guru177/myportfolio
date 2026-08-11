<?php

declare(strict_types=1);

require __DIR__ . '/config.php';

$pageTitle = $config['title'];
$pageDescription = $config['description'];
$canonicalUrl = $config['site_url'];

require __DIR__ . '/includes/head.php';
?>
<main>
    <?php require __DIR__ . '/includes/hero.php'; ?>
    <?php require __DIR__ . '/includes/marquee-strips.php'; ?>
    <?php require __DIR__ . '/includes/about.php'; ?>
    <?php require __DIR__ . '/includes/what-we-do.php'; ?>
    <?php require __DIR__ . '/includes/work.php'; ?>
    <?php require __DIR__ . '/includes/contact.php'; ?>
</main>
<?php require __DIR__ . '/includes/footer.php'; ?>
