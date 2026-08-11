(() => {
  function setupOrbit(container, dots, buildPath) {
    if (!container || dots.length === 0) return;

    function update() {
      const pathValue = buildPath(container);
      if (!pathValue) return;
      dots.forEach((dot) => {
        dot.style.offsetPath = pathValue;
      });
    }

    update();

    if (typeof ResizeObserver !== 'undefined') {
      new ResizeObserver(update).observe(container);
    } else {
      window.addEventListener('resize', update);
    }
  }

  /* Stats frame orbit */
  setupOrbit(
    document.querySelector('.wwd__stats'),
    document.querySelectorAll('.wwd__stats-dot'),
    (stats) => {
      const w = stats.offsetWidth;
      const h = stats.offsetHeight;
      if (w < 40 || h < 40) return null;

      const n = Math.min(16, w * 0.08, h * 0.35);
      const m = 0.75;

      const d = [
        `M ${n} ${m}`,
        `L ${w - m} ${m}`,
        `L ${w - m} ${h - n}`,
        `L ${w - n} ${h - m}`,
        `L ${m} ${h - m}`,
        `L ${m} ${n}`,
        `Z`,
      ].join(' ');

      return `path('${d}')`;
    }
  );

  /* Pillars connector orbit — horizontal midline */
  const pillarsOrbit = document.querySelector('.wwd__pillars-orbit');
  setupOrbit(
    pillarsOrbit,
    document.querySelectorAll('.wwd__pillars-dot'),
    (orbit) => {
      const w = orbit.offsetWidth;
      const h = orbit.offsetHeight;
      if (w < 40 || h < 10) return null;

      const y = h / 2;
      return `path('M 0 ${y} L ${w} ${y}')`;
    }
  );

  /* Contact form frame orbit */
  setupOrbit(
    document.querySelector('.contact__form'),
    document.querySelectorAll('.contact__form-dot'),
    (form) => {
      const w = form.offsetWidth;
      const h = form.offsetHeight;
      if (w < 40 || h < 40) return null;

      const n = Math.min(16, w * 0.08, h * 0.2);
      const m = 0.75;

      const d = [
        `M ${n} ${m}`,
        `L ${w - m} ${m}`,
        `L ${w - m} ${h - n}`,
        `L ${w - n} ${h - m}`,
        `L ${m} ${h - m}`,
        `L ${m} ${n}`,
        `Z`,
      ].join(' ');

      return `path('${d}')`;
    }
  );
})();
