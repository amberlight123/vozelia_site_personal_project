/* Vozelia - UI behaviors (vanilla JS)
   - Tema claro/oscuro (data-theme)
   - Menú móvil
   - Tabs (tarifas)
   - Filtro de tabla (numeración)
   - Contadores (home)
*/

(function () {
  const doc = document.documentElement;

  // ---------------- Theme ----------------
  function getPreferredTheme() {
    const stored = localStorage.getItem('theme');
    if (stored === 'dark' || stored === 'light') return stored;
    return window.matchMedia && window.matchMedia('(prefers-color-scheme: dark)').matches
      ? 'dark'
      : 'light';
  }

  function setTheme(theme) {
    doc.setAttribute('data-theme', theme);
    localStorage.setItem('theme', theme);
  }

  function initTheme() {
    setTheme(getPreferredTheme());
    const toggle = document.querySelector('[data-theme-toggle]');
    if (!toggle) return;
    toggle.addEventListener('click', () => {
      const current = doc.getAttribute('data-theme') || 'light';
      setTheme(current === 'dark' ? 'light' : 'dark');
    });
  }

  // ---------------- Header scroll ----------------
  function initHeaderScroll() {
    const header = document.querySelector('[data-site-header]');
    if (!header) return;
    const onScroll = () => {
      if (window.scrollY > 6) header.classList.add('is-scrolled');
      else header.classList.remove('is-scrolled');
    };
    onScroll();
    window.addEventListener('scroll', onScroll, { passive: true });
  }

  // ---------------- Mobile nav ----------------
  function initMobileNav() {
    const btn = document.querySelector('[data-nav-toggle]');
    const panel = document.querySelector('[data-mobile-nav]');
    if (!btn || !panel) return;

    const open = () => {
      panel.classList.add('is-open');
      btn.setAttribute('aria-expanded', 'true');
    };

    const close = () => {
      panel.classList.remove('is-open');
      btn.setAttribute('aria-expanded', 'false');
    };

    btn.addEventListener('click', () => {
      panel.classList.contains('is-open') ? close() : open();
    });

    panel.addEventListener('click', (e) => {
      const t = e.target;
      if (t && t.tagName === 'A') close();
    });

    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') close();
    });
  }

  // ---------------- Tabs (Tarifas) ----------------
  function initTabs() {
    const root = document.querySelector('[data-tabs]');
    if (!root) return;
    const buttons = Array.from(root.querySelectorAll('[data-tab]'));
    const panels = Array.from(document.querySelectorAll('[data-tab-panel]'));

    function activate(id) {
      buttons.forEach((b) => b.classList.toggle('is-active', b.getAttribute('data-tab') === id));
      panels.forEach((p) => p.classList.toggle('is-active', p.getAttribute('data-tab-panel') === id));
    }

    buttons.forEach((b) => {
      b.addEventListener('click', () => activate(b.getAttribute('data-tab')));
    });
  }

  // ---------------- Table filter ----------------
  function initTableFilter() {
    const input = document.querySelector('[data-filter-table]');
    if (!input) return;
    const id = input.getAttribute('data-filter-table');
    const table = document.getElementById(id);
    if (!table) return;
    const rows = Array.from(table.querySelectorAll('tbody tr'));

    input.addEventListener('input', () => {
      const q = (input.value || '').toLowerCase().trim();
      rows.forEach((r) => {
        const text = r.innerText.toLowerCase();
        r.style.display = text.includes(q) ? '' : 'none';
      });
    });
  }

  // ---------------- Count up (Home stats) ----------------
  function initCountUp() {
    const els = Array.from(document.querySelectorAll('[data-countup]'));
    if (!els.length) return;

    const animate = (el) => {
      const raw = el.getAttribute('data-value');
      const suffix = el.getAttribute('data-suffix') || '';
      const target = Number(raw);
      if (!Number.isFinite(target)) return;

      const isDecimal = String(raw).includes('.');
      const duration = 900;
      const start = performance.now();

      const step = (t) => {
        const p = Math.min(1, (t - start) / duration);
        const eased = 1 - Math.pow(1 - p, 3);
        const val = target * eased;
        el.textContent = (isDecimal ? val.toFixed(1) : Math.round(val).toString()) + suffix;
        if (p < 1) requestAnimationFrame(step);
      };
      requestAnimationFrame(step);
    };

    const seen = new WeakSet();
    const io = new IntersectionObserver(
      (entries) => {
        entries.forEach((entry) => {
          if (entry.isIntersecting && !seen.has(entry.target)) {
            seen.add(entry.target);
            animate(entry.target);
          }
        });
      },
      { threshold: 0.35 }
    );

    els.forEach((el) => io.observe(el));
  }

  // ---------------- Boot ----------------
  document.addEventListener('DOMContentLoaded', () => {
    initTheme();
    initHeaderScroll();
    initMobileNav();
    initTabs();
    initTableFilter();
    initCountUp();
  });
})();
