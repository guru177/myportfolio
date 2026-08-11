(() => {
  const host = document.getElementById('ai-chat-host');
  if (!host) return;

  const trigger = document.getElementById('ai-chat-trigger');
  const panel = document.getElementById('ai-chat-panel');
  const closeBtn = document.getElementById('ai-chat-close');
  const form = document.getElementById('ai-chat-form');
  const input = document.getElementById('ai-chat-input');
  const messagesEl = document.getElementById('ai-chat-messages');

  const apiUrl = host.dataset.api || '/api/chat.php';
  const greeting = host.dataset.greeting || 'Hi! I am Guru\'s AI assistant. Ask me about projects, stack, or hiring.';
  const history = [];
  let greeted = false;
  let busy = false;
  let hoverCloseTimer = null;

  function setOpen(open) {
    host.classList.toggle('is-open', open);
    trigger?.setAttribute('aria-expanded', open ? 'true' : 'false');
    panel?.setAttribute('aria-hidden', open ? 'false' : 'true');

    if (open) {
      ensureGreeting();
    } else {
      input?.blur();
    }
  }

  function ensureGreeting() {
    if (greeted || !messagesEl) return;
    greeted = true;
    appendMessage('bot', greeting);
  }

  function appendMessage(role, text) {
    if (!messagesEl) return;

    const bubble = document.createElement('div');
    bubble.className = `ai-chat-msg ai-chat-msg--${role}`;
    bubble.textContent = text;
    messagesEl.appendChild(bubble);
    messagesEl.scrollTop = messagesEl.scrollHeight;
    return bubble;
  }

  function setTyping(on) {
    const existing = messagesEl?.querySelector('.ai-chat-msg--typing');
    if (existing) existing.remove();
    if (on) appendMessage('typing', 'Thinking...');
  }

  async function sendMessage(text) {
    if (busy || !text.trim()) return;
    busy = true;

    appendMessage('user', text.trim());
    history.push({ role: 'user', content: text.trim() });
    form?.querySelector('button')?.setAttribute('disabled', 'true');
    setTyping(true);

    try {
      const res = await fetch(apiUrl, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ messages: history }),
      });

      const data = await res.json();
      if (!res.ok || !data.reply) {
        throw new Error(data.error || 'Request failed');
      }

      setTyping(false);
      appendMessage('bot', data.reply);
      history.push({ role: 'assistant', content: data.reply });
    } catch {
      setTyping(false);
      appendMessage(
        'bot',
        'Sorry, I could not reach the server. Email Guruprasad at hello@guru.dev for a direct reply.'
      );
    } finally {
      busy = false;
      form?.querySelector('button')?.removeAttribute('disabled');
    }
  }

  host.addEventListener('mouseenter', () => {
    if (hoverCloseTimer) {
      clearTimeout(hoverCloseTimer);
      hoverCloseTimer = null;
    }
    setOpen(true);
  });

  host.addEventListener('mouseleave', (e) => {
    if (window.matchMedia('(hover: none)').matches) return;

    const related = e.relatedTarget;
    if (related instanceof Node && host.contains(related)) return;

    if (hoverCloseTimer) clearTimeout(hoverCloseTimer);
    setOpen(false);
  });

  trigger?.addEventListener('click', (e) => {
    if (window.matchMedia('(hover: none)').matches) {
      e.preventDefault();
      setOpen(!host.classList.contains('is-open'));
    }
  });

  closeBtn?.addEventListener('click', () => setOpen(false));

  document.addEventListener('keydown', (e) => {
    if (e.key === 'Escape' && host.classList.contains('is-open')) {
      setOpen(false);
    }
  });

  form?.addEventListener('submit', (e) => {
    e.preventDefault();
    const text = input?.value || '';
    if (input) input.value = '';
    sendMessage(text);
  });
})();
