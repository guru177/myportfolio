(() => {
  function initLotties() {
    if (typeof lottie === 'undefined') return;

    const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const hosts = document.querySelectorAll('[data-lottie]');

    hosts.forEach((container) => {
      if (container.dataset.lottieReady === '1') return;
      container.dataset.lottieReady = '1';

      lottie.loadAnimation({
        container,
        renderer: 'svg',
        loop: !prefersReduced,
        autoplay: !prefersReduced,
        path: container.dataset.src || '',
      });
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', initLotties);
  } else {
    initLotties();
  }
})();
