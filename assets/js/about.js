(() => {
  const slider = document.getElementById('about-slider');
  if (!slider) return;

  const visual = slider.closest('.about__visual');
  const slides = Array.from(slider.querySelectorAll('.about__slide'));
  const pagerBtns = Array.from(document.querySelectorAll('.about__pager-btn'));
  const prevBtn = document.getElementById('about-prev');
  const nextBtn = document.getElementById('about-next');

  if (slides.length < 2) return;

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const AUTO_MS = 4200;

  let index = slides.findIndex((slide) => slide.classList.contains('is-active'));
  if (index < 0) index = 0;

  let timer = null;

  function setSlide(nextIndex) {
    index = (nextIndex + slides.length) % slides.length;

    slides.forEach((slide, i) => {
      slide.classList.toggle('is-active', i === index);
    });

    pagerBtns.forEach((btn, i) => {
      btn.classList.toggle('is-active', i === index);
    });
  }

  function stopAuto() {
    if (timer) {
      clearInterval(timer);
      timer = null;
    }
  }

  function startAuto() {
    if (prefersReduced) return;
    stopAuto();
    timer = window.setInterval(() => setSlide(index + 1), AUTO_MS);
  }

  function goTo(nextIndex) {
    setSlide(nextIndex);
    startAuto();
  }

  prevBtn?.addEventListener('click', () => goTo(index - 1));
  nextBtn?.addEventListener('click', () => goTo(index + 1));

  pagerBtns.forEach((btn) => {
    btn.addEventListener('click', () => {
      const target = Number(btn.dataset.slide);
      if (!Number.isNaN(target)) goTo(target);
    });
  });

  if (visual) {
    visual.addEventListener('mouseenter', stopAuto);
    visual.addEventListener('mouseleave', startAuto);
    visual.addEventListener('focusin', stopAuto);
    visual.addEventListener('focusout', (e) => {
      if (!visual.contains(e.relatedTarget)) startAuto();
    });
  }

  document.addEventListener('visibilitychange', () => {
    if (document.hidden) stopAuto();
    else startAuto();
  });

  startAuto();
})();
