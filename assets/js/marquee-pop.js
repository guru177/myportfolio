(() => {
  const words = document.querySelectorAll('.marquee-word');
  if (!words.length) return;

  const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
  const DEPTH = prefersReduced ? 3 : 16;
  let activeWord = null;
  let popEl = null;
  let leaveTimer = 0;

  function themeFor(word) {
    return word.closest('.marquee-strip--dark') ? 'dark' : 'accent';
  }

  function stripAngle(word) {
    const strip = word.closest('.marquee-strip');
    if (!strip) return 0;
    const matrix = new DOMMatrix(getComputedStyle(strip).transform);
    return Math.atan2(matrix.m12, matrix.m11) * (180 / Math.PI);
  }

  function placePop(pop, word) {
    const rect = word.getBoundingClientRect();
    pop.style.left = `${rect.left + rect.width / 2}px`;
    pop.style.top = `${rect.top + rect.height / 2}px`;
    pop.style.setProperty('--strip-rot', `${stripAngle(word)}deg`);
  }

  function teardown() {
    if (activeWord) {
      activeWord.classList.remove('is-popped');
      activeWord.closest('.marquee-strip')?.classList.remove('is-paused');
    }
    popEl?.remove();
    popEl = null;
    activeWord = null;
  }

  function clearPop() {
    window.clearTimeout(leaveTimer);
    if (!popEl || !activeWord) {
      teardown();
      return;
    }

    const current = popEl;
    const word = activeWord;
    current.classList.remove('is-out');
    word.classList.remove('is-popped');

    const finish = () => {
      if (popEl !== current) return;
      teardown();
    };

    current.addEventListener('transitionend', finish, { once: true });
    leaveTimer = window.setTimeout(finish, prefersReduced ? 80 : 720);
  }

  function showPop(word) {
    window.clearTimeout(leaveTimer);
    if (activeWord === word && popEl) {
      popEl.classList.add('is-out');
      word.classList.add('is-popped');
      return;
    }

    teardown();

    const rect = word.getBoundingClientRect();
    if (rect.width < 2 || rect.height < 2) return;

    word.closest('.marquee-strip')?.classList.add('is-paused');

    const styles = getComputedStyle(word);
    const pop = document.createElement('div');
    pop.className = `marquee-pop marquee-pop--${themeFor(word)}`;
    pop.setAttribute('aria-hidden', 'true');
    placePop(pop, word);

    const stack = document.createElement('span');
    stack.className = 'marquee-pop__stack';
    stack.style.fontFamily = styles.fontFamily;
    stack.style.fontSize = styles.fontSize;
    stack.style.fontWeight = styles.fontWeight;
    stack.style.letterSpacing = styles.letterSpacing;
    stack.style.lineHeight = styles.lineHeight;

    for (let i = 0; i < DEPTH; i += 1) {
      const layer = document.createElement('span');
      layer.className = i === 0 ? 'marquee-pop__layer marquee-pop__layer--face' : 'marquee-pop__layer';
      layer.textContent = word.dataset.word || word.textContent || '';
      layer.style.setProperty('--depth', String(i));
      stack.appendChild(layer);
    }

    pop.appendChild(stack);
    document.body.appendChild(pop);
    activeWord = word;
    popEl = pop;

    requestAnimationFrame(() => {
      requestAnimationFrame(() => {
        if (popEl !== pop) return;
        word.classList.add('is-popped');
        pop.classList.add('is-out');
      });
    });
  }

  words.forEach((word) => {
    word.addEventListener('mouseenter', () => showPop(word));
    word.addEventListener('mouseleave', clearPop);
    word.addEventListener('focus', () => showPop(word));
    word.addEventListener('blur', clearPop);
  });

  window.addEventListener('scroll', clearPop, { passive: true });
  window.addEventListener('resize', clearPop);
})();
