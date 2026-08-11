<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$contact = $config['contact'];
$form = $contact['form'];
$email = $config['email'];
?>
<section class="contact" id="contact" aria-labelledby="contact-heading">
    <div class="contact__inner">
        <header class="contact__header">
            <p class="contact__eyebrow" data-reveal data-reveal-type="blur" data-delay="0">
                <?= e($contact['eyebrow']) ?>
            </p>
            <div class="contact__header-main">
                <h2 class="contact__heading" id="contact-heading">
                    <span class="contact__heading-lead" data-reveal data-reveal-type="up" data-delay="60">
                        <?= e($contact['heading_lead']) ?>
                    </span>
                    <span class="contact__heading-word" data-reveal data-reveal-type="up" data-delay="140">
                        <?= e($contact['heading']) ?>
                    </span>
                </h2>
                <p class="contact__header-copy" data-reveal data-reveal-type="up" data-delay="180">
                    <?= e($contact['body']) ?>
                </p>
            </div>
        </header>

        <div class="contact__layout">
            <div class="contact__info">
                <div class="contact__email-block" data-reveal data-reveal-type="up" data-delay="220">
                    <span class="contact__label"><?= e($contact['email_label']) ?></span>
                    <a class="contact__email" href="mailto:<?= e($email) ?>"><?= e($email) ?></a>
                </div>

                <ul class="contact__details" data-reveal data-reveal-type="up" data-delay="260" data-stagger>
                    <?php foreach ($contact['details'] as $detail): ?>
                        <li class="contact__detail reveal-child">
                            <span class="contact__label"><?= e($detail['label']) ?></span>
                            <span class="contact__value"><?= e($detail['value']) ?></span>
                        </li>
                    <?php endforeach; ?>
                </ul>
            </div>

            <div class="contact__form-wrap" data-reveal data-reveal-type="up" data-delay="200">
                <form
                    class="contact__form"
                    id="contact-form"
                    data-success="<?= e($form['success']) ?>"
                    data-error="<?= e($form['error']) ?>"
                    novalidate
                >
                    <div class="contact__field">
                        <label class="contact__label" for="contact-name"><?= e($form['name_label']) ?></label>
                        <input
                            class="contact__input"
                            type="text"
                            id="contact-name"
                            name="name"
                            autocomplete="name"
                            required
                            maxlength="120"
                            placeholder="<?= e($form['name_placeholder']) ?>"
                        >
                    </div>

                    <div class="contact__field">
                        <label class="contact__label" for="contact-email"><?= e($form['email_label']) ?></label>
                        <input
                            class="contact__input"
                            type="email"
                            id="contact-email"
                            name="email"
                            autocomplete="email"
                            required
                            maxlength="160"
                            placeholder="<?= e($form['email_placeholder']) ?>"
                        >
                    </div>

                    <div class="contact__field">
                        <label class="contact__label" for="contact-message"><?= e($form['message_label']) ?></label>
                        <textarea
                            class="contact__input contact__textarea"
                            id="contact-message"
                            name="message"
                            required
                            maxlength="4000"
                            rows="5"
                            placeholder="<?= e($form['message_placeholder']) ?>"
                        ></textarea>
                    </div>

                    <div class="contact__actions">
                        <button class="contact__submit" type="submit">
                            <?= e($form['submit']) ?>
                            <span aria-hidden="true">→</span>
                        </button>
                        <p class="contact__status" id="contact-status" role="status" aria-live="polite" hidden></p>
                    </div>
                </form>

                <div class="contact__form-orbit" aria-hidden="true">
                    <span class="contact__form-dot"></span>
                    <span class="contact__form-dot contact__form-dot--delayed"></span>
                </div>
            </div>
        </div>

        <div
            class="contact__lottie"
            id="contact-lottie"
            data-lottie
            data-src="<?= e(local_asset(ltrim($contact['lottie'], '/'))) ?>"
            data-reveal
            data-reveal-type="up"
            data-delay="320"
            role="img"
            aria-label="<?= e($contact['lottie_alt']) ?>"
        ></div>
    </div>
</section>
