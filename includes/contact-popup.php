<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$contact = $config['contact'];
$form = $contact['form'];
?>
<div
    class="contact-popup"
    id="contact-popup"
    hidden
    aria-hidden="true"
>
    <div class="contact-popup__backdrop" data-contact-popup-close tabindex="-1"></div>
    <div
        class="contact-popup__dialog"
        role="dialog"
        aria-modal="true"
        aria-labelledby="contact-popup-title"
        aria-describedby="contact-popup-desc"
    >
        <button
            type="button"
            class="contact-popup__close"
            data-contact-popup-close
            aria-label="Close contact form"
        >
            <span aria-hidden="true">×</span>
        </button>

        <header class="contact-popup__header">
            <p class="contact-popup__eyebrow"><?= e($contact['eyebrow']) ?></p>
            <h2 class="contact-popup__title" id="contact-popup-title">
                <span class="contact-popup__title-lead"><?= e($contact['heading_lead']) ?></span>
                <span class="contact-popup__title-word"><?= e($contact['heading']) ?></span>
            </h2>
            <p class="contact-popup__desc" id="contact-popup-desc">
                <?= e($contact['body']) ?>
            </p>
        </header>

        <form
            class="contact-popup__form"
            id="contact-popup-form"
            data-success="<?= e($form['success']) ?>"
            data-error="<?= e($form['error']) ?>"
            novalidate
        >
            <div class="contact__field">
                <label class="contact__label" for="contact-popup-name"><?= e($form['name_label']) ?></label>
                <input
                    class="contact__input"
                    type="text"
                    id="contact-popup-name"
                    name="name"
                    autocomplete="name"
                    required
                    maxlength="120"
                    placeholder="<?= e($form['name_placeholder']) ?>"
                >
            </div>

            <div class="contact__field">
                <label class="contact__label" for="contact-popup-email"><?= e($form['email_label']) ?></label>
                <input
                    class="contact__input"
                    type="email"
                    id="contact-popup-email"
                    name="email"
                    autocomplete="email"
                    required
                    maxlength="160"
                    placeholder="<?= e($form['email_placeholder']) ?>"
                >
            </div>

            <div class="contact__field">
                <label class="contact__label" for="contact-popup-message"><?= e($form['message_label']) ?></label>
                <textarea
                    class="contact__input contact__textarea contact-popup__textarea"
                    id="contact-popup-message"
                    name="message"
                    required
                    maxlength="4000"
                    rows="4"
                    placeholder="<?= e($form['message_placeholder']) ?>"
                ></textarea>
            </div>

            <div class="contact__actions contact-popup__actions">
                <button class="contact__submit" type="submit">
                    <?= e($form['submit']) ?>
                    <span aria-hidden="true">→</span>
                </button>
                <p class="contact__status" id="contact-popup-status" role="status" aria-live="polite" hidden></p>
            </div>
        </form>
    </div>
</div>
