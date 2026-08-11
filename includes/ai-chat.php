<?php

declare(strict_types=1);

/** @var array<string, mixed> $config */
$chat = $config['ai_chat'];
?>
<div
    class="ai-chat-host"
    id="ai-chat-host"
    data-api="<?= e(local_asset('api/chat.php')) ?>"
    data-greeting="<?= e($chat['greeting']) ?>"
    data-reveal
    data-reveal-type="scale"
    data-delay="480"
>
    <button
        type="button"
        class="hero__robot ai-chat-trigger"
        id="ai-chat-trigger"
        aria-label="Open AI assistant chat"
        aria-expanded="false"
        aria-controls="ai-chat-panel"
    >
        <span class="hero__robot-lottie" id="hero-robot-lottie" data-lottie data-src="<?= e(local_asset('assets/lottie/ai-robot.json')) ?>"></span>
        <span class="ai-chat-hint">Ask AI</span>
    </button>

    <div
        class="ai-chat-panel"
        id="ai-chat-panel"
        role="dialog"
        aria-label="AI assistant"
        aria-hidden="true"
    >
        <header class="ai-chat-header">
            <div class="ai-chat-header__meta">
                <span class="ai-chat-header__dot" aria-hidden="true"></span>
                <div>
                    <p class="ai-chat-header__title"><?= e($chat['title']) ?></p>
                    <p class="ai-chat-header__status">Online</p>
                </div>
            </div>
            <button type="button" class="ai-chat-close" id="ai-chat-close" aria-label="Close chat">×</button>
        </header>

        <div class="ai-chat-messages" id="ai-chat-messages" aria-live="polite"></div>

        <form class="ai-chat-form" id="ai-chat-form">
            <label class="ai-chat-form__label" for="ai-chat-input">Message</label>
            <div class="ai-chat-form__row">
                <input
                    type="text"
                    id="ai-chat-input"
                    class="ai-chat-input"
                    placeholder="<?= e($chat['placeholder']) ?>"
                    autocomplete="off"
                    maxlength="500"
                    required
                >
                <button type="submit" class="ai-chat-send" aria-label="Send message">
                    <svg viewBox="0 0 24 24" width="18" height="18" aria-hidden="true">
                        <path d="M3.4 20.6 21 12 3.4 3.4l2.8 7.2L17 12l-10.8 1.4-2.8 7.2z" fill="currentColor"/>
                    </svg>
                </button>
            </div>
        </form>
    </div>
</div>
