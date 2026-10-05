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
  const LOADED_KEY = 'tsumugu-loaded';
  // 同じタブで 2 ページ目以降はローディングを出さない（head のインラインスクリプトで判定済み）
  const skipLoading = document.documentElement.classList.contains('is-loadingSkip');
  let booted = false;

  const reveal = () => {
    document.body.classList.remove('fadeIn');
    const loading = document.querySelector('.js-loading');
    try {
      sessionStorage.setItem(LOADED_KEY, '1');
    } catch (e) {}
    if (loading && skipLoading) {
      loading.remove();
    } else if (loading) {
      // カバーは 1 秒かけて開く。透けてから is-loaded が付くまでの間、
      // キャッチやナビの完成形が見えてしまうので、その間だけ伏せておく
      document.body.classList.add('is-fvHold');
      loading.classList.add('is-opening', 'is-opened');
      const page = loading.querySelector('.c-loading__page--right');
      const done = () => loading.remove();
      if (page) {
        page.addEventListener('transitionend', done, { once: true });
      }
      setTimeout(done, 1300); // フォールバック
    }
    // ノートが開き始めてから少し遅れて、ナビ順次出現＋FV キャッチの演出を開始
    // ローディングを出さないときも、初期状態が 1 度描画されてから合図を出す
    // （同じフレームで付けると transition が走らず、アニメーションが飛んでしまう）
    // requestAnimationFrame は非アクティブなタブでは止まるため使わない。
    // 代わりに一度レイアウトを読み出して初期状態を確定させてから合図を出す
    const markLoaded = () => {
      void document.body.offsetHeight;
      document.body.classList.remove('is-fvHold');
      document.body.classList.add('is-loaded');
    };
    // ノートが開く演出（1 秒）が終わってから始める。開いている最中だとカバーに隠れて
    // キャッチのせり上がりが見えない
    setTimeout(markLoaded, skipLoading ? 60 : 1150);
    // 保険: 何かで演出が始まらなくても、キャッチが見えないまま残らないようにする
    setTimeout(markLoaded, 6000);
  };

  // ローディングは最低 MIN_LOADING_MS 表示してから退場（一瞬で消えないように）
  const bootReveal = () => {
    if (booted) return;
    booted = true;
    const wait = skipLoading ? 0 : Math.max(0, MIN_LOADING_MS - performance.now());
    setTimeout(reveal, wait);
  };

  /*-------------------------------------------------------------------
  FV キャッチの傍点: 「だけ」「伴走型」の各文字を span に分けて丸を載せる
  （CSS だけでは 1 文字ごとに丸を置けないため）
  --------------------------------------------------------------------*/
  const splitDots = () => {
    document.querySelectorAll('.js-fvDots').forEach((el) => {
      if (el.dataset.split === 'done') return;
      const chars = [...el.textContent];
      el.textContent = '';
      chars.forEach((ch) => {
        const span = document.createElement('span');
        span.className = 'p-fv__dot';
        span.textContent = ch;
        el.appendChild(span);
      });
      el.dataset.split = 'done';
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

    // .js-draw は透明にせず、表示時に線を「書く」演出だけを付けるフック
    const items = document.querySelectorAll('.js-reveal, .js-draw');
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
  制作実績カードのデモ動画（PC: hover / フォーカスで再生、タッチ端末: 画面内で再生）
  --------------------------------------------------------------------*/
  const initHoverVideo = () => {
    const cards = [...document.querySelectorAll('.js-hoverVideoCard')];
    if (!cards.length || window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
    const play = (video) => {
      const p = video.play();
      if (p && p.catch) p.catch(() => {});
    };
    const stop = (video) => {
      video.pause();
      video.classList.remove('is-playing');
    };
    const pairs = cards.map((card) => [card, card.querySelector('.js-hoverVideo')]).filter(([, v]) => v);
    pairs.forEach(([, video]) => {
      video.addEventListener('playing', () => video.classList.add('is-playing'));
    });

    if (window.matchMedia('(any-hover: hover)').matches) {
      pairs.forEach(([card, video]) => {
        card.addEventListener('mouseenter', () => play(video));
        card.addEventListener('focus', () => play(video));
        card.addEventListener('mouseleave', () => stop(video));
        card.addEventListener('blur', () => stop(video));
      });
      return;
    }
    if (!('IntersectionObserver' in window)) return;
    const io = new IntersectionObserver((entries) => {
      entries.forEach((entry) => {
        const video = entry.target.querySelector('.js-hoverVideo');
        entry.isIntersecting ? play(video) : stop(video);
      });
    }, { threshold: 0.6 });
    pairs.forEach(([card]) => io.observe(card));
  };

  /*-------------------------------------------------------------------
  SP のハンバーガーメニュー（開閉・Esc で閉じる・リンクで閉じる）
  --------------------------------------------------------------------*/
  const initNavToggle = () => {
    const toggle = document.querySelector('.js-navToggle');
    const list = document.querySelector('.js-navList');
    const overlay = document.querySelector('.js-navOverlay');
    if (!toggle || !list) return;

    const setOpen = (open) => {
      document.body.classList.toggle('is-navOpen', open);
      toggle.setAttribute('aria-expanded', String(open));
      toggle.setAttribute('aria-label', open ? 'メニューを閉じる' : 'メニューを開く');
    };

    toggle.addEventListener('click', () => setOpen(!document.body.classList.contains('is-navOpen')));
    if (overlay) overlay.addEventListener('click', () => setOpen(false));
    list.addEventListener('click', (e) => {
      if (e.target.closest('a')) setOpen(false);
    });
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape' && document.body.classList.contains('is-navOpen')) {
        setOpen(false);
        toggle.focus();
      }
    });
    // PC 幅に戻したときに開いたままにしない
    window.matchMedia('(min-width: 1024px)').addEventListener('change', (e) => {
      if (e.matches) setOpen(false);
    });
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
    splitDots();
    initReveal();
    initParallax();
    initHoverVideo();
    initNavToggle();
    initSmoothScroll();
    initTotop();
  });
  if (skipLoading) {
    // ローディングを出さないときは画像の読み込み完了（load）を待たずに本編を開始
    document.addEventListener('DOMContentLoaded', bootReveal);
  } else {
    window.addEventListener('load', bootReveal);
  }
  // load が発火しない/遅い場合の安全弁（最大 4s で必ず本編へ）
  setTimeout(bootReveal, 4000);
})();
