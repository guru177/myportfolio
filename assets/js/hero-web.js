(() => {
  const hero = document.querySelector('.hero');
  const trigger = document.getElementById('hero-web-trigger');
  const triggerText = trigger?.querySelector('.hero__web-trigger-text');
  if (!hero || !trigger) return;

  const targets = [trigger, triggerText].filter(Boolean);
  const isTouch = window.matchMedia('(hover: none) and (pointer: coarse)').matches;
  const prefersReducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

  function setWebbing(on) {
    hero.classList.toggle('is-web-shoot', on);
  }

  if (isTouch) {
    if (!prefersReducedMotion) {
      const startWeb = () => setWebbing(true);
      window.setTimeout(startWeb, 900);
    }
  } else {
    targets.forEach((el) => {
      el.addEventListener('mouseenter', () => setWebbing(true));
      el.addEventListener('mouseleave', () => setWebbing(false));
      el.addEventListener('focus', () => setWebbing(true));
      el.addEventListener('blur', () => setWebbing(false));
    });
  }
})();
