(() => {
  const FIRST_DELAY_MS = 6000;
  const REPEAT_DELAY_MS = 5 * 60 * 1000;

  function bindForm(form, status) {
    if (!form || !status) return;

    const successText = form.dataset.success || 'Thanks — I will get back to you soon.';
    const errorText = form.dataset.error || 'Something went wrong. Please email me directly.';

    function setStatus(message, type) {
      status.hidden = false;
      status.textContent = message;
      status.classList.remove('is-success', 'is-error');
      if (type) status.classList.add(type);
    }

    form.addEventListener('submit', async (event) => {
      event.preventDefault();

      const name = String(new FormData(form).get('name') || '').trim();
      const email = String(new FormData(form).get('email') || '').trim();
      const message = String(new FormData(form).get('message') || '').trim();

      if (!name || !email || !message) {
        setStatus('Please fill in all fields.', 'is-error');
        return;
      }

      const submit = form.querySelector('.contact__submit');
      if (submit) submit.disabled = true;
      setStatus('Sending…', '');

      try {
        const res = await fetch('/api/contact.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ name, email, message }),
        });

        const data = await res.json().catch(() => ({}));

        if (!res.ok || data.error) {
          throw new Error(data.error || 'Request failed');
        }

        form.reset();
        setStatus(form.dataset.success || successText, 'is-success');
      } catch (err) {
        setStatus(form.dataset.error || errorText, 'is-error');
      } finally {
        if (submit) submit.disabled = false;
      }
    });
  }

  bindForm(
    document.getElementById('contact-form'),
    document.getElementById('contact-status')
  );
  bindForm(
    document.getElementById('contact-popup-form'),
    document.getElementById('contact-popup-status')
  );

  const popup = document.getElementById('contact-popup');
  if (!popup) return;

  const dialog = popup.querySelector('.contact-popup__dialog');
  const closeTriggers = popup.querySelectorAll('[data-contact-popup-close]');
  const firstField = popup.querySelector('#contact-popup-name');
  let openTimer = 0;
  let lastFocus = null;

  function isOpen() {
    return popup.classList.contains('is-open');
  }

  function openPopup() {
    if (isOpen()) return;

    lastFocus = document.activeElement;
    popup.hidden = false;
    popup.setAttribute('aria-hidden', 'false');

    requestAnimationFrame(() => {
      popup.classList.add('is-open');
      document.body.classList.add('contact-popup-open');
      if (firstField) firstField.focus({ preventScroll: true });
    });
  }

  function closePopup() {
    if (!isOpen() && popup.hidden) return;

    popup.classList.remove('is-open');
    popup.setAttribute('aria-hidden', 'true');
    document.body.classList.remove('contact-popup-open');

    window.setTimeout(() => {
      if (!isOpen()) popup.hidden = true;
    }, 350);

    if (lastFocus && typeof lastFocus.focus === 'function') {
      lastFocus.focus({ preventScroll: true });
    }
  }

  function scheduleOpen(delay) {
    window.clearTimeout(openTimer);
    openTimer = window.setTimeout(() => {
      openPopup();
      scheduleOpen(REPEAT_DELAY_MS);
    }, delay);
  }

  closeTriggers.forEach((el) => {
    el.addEventListener('click', (event) => {
      event.preventDefault();
      closePopup();
    });
  });

  document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape' && isOpen()) {
      event.preventDefault();
      closePopup();
    }
  });

  if (dialog) {
    dialog.addEventListener('click', (event) => {
      event.stopPropagation();
    });
  }

  scheduleOpen(FIRST_DELAY_MS);
})();
