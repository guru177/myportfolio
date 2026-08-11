(() => {
  const form = document.getElementById('contact-form');
  const status = document.getElementById('contact-status');
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
})();
