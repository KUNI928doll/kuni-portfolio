/*-------------------------------------------------------------------
Tsumugu LP — main
--------------------------------------------------------------------*/
(() => {
  'use strict';

  /*-------------------------------------------------------------------
  ビューポート幅を CSS 変数へ（foundation の流体ルート用）
  --------------------------------------------------------------------*/
  const setVwUnitless = () => {
    document.documentElement.style.setProperty('--vw-unitless', String(window.innerWidth));
  };
  setVwUnitless();
  window.addEventListener('resize', setVwUnitless);

  /*-------------------------------------------------------------------
  ローディング → 本体フェードイン → FV 演出開始
  --------------------------------------------------------------------*/
  const MIN_LOADING_MS = 2500;
  let booted = false;

  const reveal = () => {
    document.body.classList.remove('fadeIn');
    const loading = document.querySelector('.js-loading');
    if (loading) {
      loading.classList.add('is-opening', 'is-opened');
      const page = loading.querySelector('.c-loading__page--right');
      const done = () => loading.remove();
      if (page) {
        page.addEventListener('transitionend', done, { once: true });
      }
      setTimeout(done, 1300); // フォールバック
    }
    // ノートが開き始めてから少し遅れて、ナビ順次出現＋FV の 1 字ずつを開始
    setTimeout(() => {
      document.body.classList.add('is-loaded');
      startTyping();
    }, 450);
  };

  // ローディングは最低 MIN_LOADING_MS 表示してから退場（一瞬で消えないように）
  const bootReveal = () => {
    if (booted) return;
    booted = true;
    const wait = Math.max(0, MIN_LOADING_MS - performance.now());
    setTimeout(reveal, wait);
  };

  /*-------------------------------------------------------------------
  FV キャッチ: 1 文字ずつ表示（.js-typing 内の文字を span 化）
  --------------------------------------------------------------------*/
  const splitToChars = (el) => {
    const walk = (node) => {
      const frag = document.createDocumentFragment();
      node.childNodes.forEach((child) => {
        if (child.nodeType === Node.TEXT_NODE) {
          [...child.textContent].forEach((ch) => {
            const span = document.createElement('span');
            span.className = 'js-typing__char';
            span.textContent = ch;
            if (ch === ' ' || ch === '　') span.style.whiteSpace = 'pre';
            frag.appendChild(span);
          });
        } else if (child.nodeName === 'BR') {
          frag.appendChild(child.cloneNode());
        } else {
          const clone = child.cloneNode(false);
          clone.appendChild(walk(child));
          frag.appendChild(clone);
        }
      });
      return frag;
    };
    const built = walk(el);
    el.textContent = '';
    el.appendChild(built);
    return el.querySelectorAll('.js-typing__char');
  };

  const startTyping = () => {
    const targets = document.querySelectorAll('.js-typing');
    targets.forEach((el) => {
      const chars = splitToChars(el);
      const step = Number(el.dataset.typingStep || 70);
      chars.forEach((ch, i) => {
        setTimeout(() => ch.classList.add('is-shown'), i * step);
      });
      const total = chars.length * step;
      // 副文などキャッチ完了後に一括表示する要素
      const after = document.querySelectorAll('.js-afterTyping');
      after.forEach((a) => setTimeout(() => a.classList.add('is-shown'), total + 200));
    });
  };

  /*-------------------------------------------------------------------
  スクロールで出現（.js-reveal → .is-shown）
  data-reveal-delay(ms) で個別ディレイ・ステガー
  --------------------------------------------------------------------*/
  const initReveal = () => {
    // グループ: 子 .js-reveal に自動ステガー用の --i を付与
    document.querySelectorAll('.js-revealGroup').forEach((group) => {
      const kids = group.querySelectorAll('.js-reveal');
      kids.forEach((el, i) => {
        if (!el.dataset.revealDelay) el.style.setProperty('--i', String(i));
      });
    });

    const items = document.querySelectorAll('.js-reveal');
    if (!('IntersectionObserver' in window) || !items.length) {
      items.forEach((el) => el.classList.add('is-shown'));
      return;
    }
    const io = new IntersectionObserver((entries, obs) => {
      entries.forEach((entry) => {
        if (!entry.isIntersecting) return;
        const el = entry.target;
        const delay = Number(el.dataset.revealDelay || 0);
        if (delay) el.style.transitionDelay = `${delay}ms`;
        el.classList.add('is-shown');
        obs.unobserve(el);
      });
    }, { rootMargin: '0px 0px -12% 0px', threshold: 0.12 });
    items.forEach((el) => io.observe(el));
  };

  /*-------------------------------------------------------------------
  スクロール連動パララックス（data-parallax="係数" 例 0.15）
  --------------------------------------------------------------------*/
  const initParallax = () => {
    const els = [...document.querySelectorAll('[data-parallax]')];
    if (!els.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    let ticking = false;
    const update = () => {
      const vh = window.innerHeight;
      els.forEach((el) => {
        const factor = parseFloat(el.dataset.parallax) || 0.12;
        const rect = el.getBoundingClientRect();
        // 要素が画面中央に来たときを 0 とした相対量
        const progress = (rect.top + rect.height / 2 - vh / 2) / vh;
        el.style.setProperty('--parallax-y', `${(progress * factor * -100).toFixed(1)}px`);
      });
      ticking = false;
    };
    const onScroll = () => {
      if (!ticking) {
        ticking = true;
        requestAnimationFrame(update);
      }
    };
    update();
    window.addEventListener('scroll', onScroll, { passive: true });
    window.addEventListener('resize', onScroll, { passive: true });
  };

  /*-------------------------------------------------------------------
  アンカーへのスムーススクロール
  --------------------------------------------------------------------*/
  const initSmoothScroll = () => {
    document.querySelectorAll('a[href^="#"]').forEach((a) => {
      a.addEventListener('click', (e) => {
        const id = a.getAttribute('href');
        if (id === '#' || id.length < 2) return;
        const target = document.querySelector(id);
        if (!target) return;
        e.preventDefault();
        target.scrollIntoView({ behavior: 'smooth', block: 'start' });
      });
    });
  };

  /*-------------------------------------------------------------------
  TOP へ戻る（スクロールで出現）
  --------------------------------------------------------------------*/
  const initTotop = () => {
    const totop = document.querySelector('.js-totop');
    if (!totop) return;
    const onScroll = () => {
      totop.classList.toggle('is-shown', window.scrollY > window.innerHeight * 0.5);
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
    totop.addEventListener('click', (e) => {
      e.preventDefault();
      window.scrollTo({ top: 0, behavior: 'smooth' });
    });
  };

  /*-------------------------------------------------------------------
  init
  --------------------------------------------------------------------*/
  document.addEventListener('DOMContentLoaded', () => {
    initReveal();
    initParallax();
    initSmoothScroll();
    initTotop();
  });
  window.addEventListener('load', bootReveal);
  // load が発火しない/遅い場合の安全弁（最大 4s で必ず本編へ）
  setTimeout(bootReveal, 4000);
})();
