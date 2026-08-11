(() => {
  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  if (prefersReduced) {
    document.querySelectorAll('[data-reveal]').forEach((el) => el.classList.add('is-visible'));
    document.querySelectorAll('[data-stagger]').forEach((el) => el.classList.add('is-visible'));
    return;
  }

  const typeMap = {
    up: 'reveal--up',
    down: 'reveal--down',
    left: 'reveal--left',
    right: 'reveal--right',
    scale: 'reveal--scale',
    blur: 'reveal--blur',
    'clip-right': 'reveal--clip-right',
    'reveal-bottom': 'reveal--reveal-bottom',
  };

  function setupReveal(el) {
    const type = el.getAttribute('data-reveal-type') || 'up';
    el.classList.add('reveal', typeMap[type] || typeMap.up);

    const delay = Number(el.getAttribute('data-delay') || '0');
    if (delay > 0) el.style.transitionDelay = `${delay}ms`;
  }

  function activateStagger(root) {
    const staggerTargets = [];

    if (root.hasAttribute('data-stagger')) staggerTargets.push(root);
    root.querySelectorAll('[data-stagger]').forEach((el) => staggerTargets.push(el));

    staggerTargets.forEach((stagger) => {
      stagger.classList.add('is-visible');
      stagger.querySelectorAll('.reveal-child').forEach((child, i) => {
        child.style.transitionDelay = `${i * 90}ms`;
      });
    });
  }

  function show(el) {
    el.classList.add('is-visible');
    activateStagger(el);
  }

  /* Hero loads in viewport — stagger on page load */
  const heroEls = Array.from(document.querySelectorAll('.hero [data-reveal]'));
  heroEls.forEach(setupReveal);

  requestAnimationFrame(() => {
    heroEls.forEach((el, i) => {
      const extra = Number(el.getAttribute('data-delay') || '0');
      setTimeout(() => show(el), 120 + i * 100 + extra);
    });
  });

  /* Sections below fold — reveal on scroll into viewport */
  const scrollEls = Array.from(document.querySelectorAll('section:not(.hero) [data-reveal]'));
  scrollEls.forEach(setupReveal);

  if (scrollEls.length > 0 && 'IntersectionObserver' in window) {
    const observer = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (!entry.isIntersecting) return;
          show(entry.target);
          observer.unobserve(entry.target);
        });
      },
      { threshold: 0.08, rootMargin: '0px 0px -6% 0px' }
    );

    scrollEls.forEach((el) => observer.observe(el));
  } else {
    scrollEls.forEach((el) => show(el));
  }

  /* Word-by-word headline */
  document.querySelectorAll('[data-split-words]').forEach((el) => {
    const text = el.textContent.trim();
    el.textContent = '';
    text.split(/\s+/).forEach((word, i) => {
      const span = document.createElement('span');
      span.className = 'hero__word';
      span.textContent = word;
      span.style.animationDelay = `${200 + i * 120}ms`;
      el.appendChild(span);
      if (i < text.split(/\s+/).length - 1) {
        el.appendChild(document.createTextNode(' '));
      }
    });
  });

  /* Subtle portrait parallax (after pop-in) */
  const portrait = document.querySelector('.hero__portrait-wrap');
  if (portrait && !prefersReduced) {
    let targetX = 0;
    let targetY = 0;
    let currentX = 0;
    let currentY = 0;
    let parallaxReady = false;

    setTimeout(() => {
      parallaxReady = true;
    }, 1800);

    document.addEventListener('mousemove', (e) => {
      if (!parallaxReady) return;
      const cx = window.innerWidth / 2;
      const cy = window.innerHeight / 2;
      targetX = ((e.clientX - cx) / cx) * 6;
      targetY = ((e.clientY - cy) / cy) * 4;
    });

    function tick() {
      if (parallaxReady) {
        currentX += (targetX - currentX) * 0.06;
        currentY += (targetY - currentY) * 0.06;
        portrait.style.transform = `translate(calc(-50% + ${currentX}px), ${currentY}px)`;
      }
      requestAnimationFrame(tick);
    }
    tick();
  }

  /* Nav link hover underline */
  document.querySelectorAll('.hero__links a').forEach((link) => {
    link.addEventListener('mouseenter', () => link.classList.add('is-hover'));
    link.addEventListener('mouseleave', () => link.classList.remove('is-hover'));
  });
})();
