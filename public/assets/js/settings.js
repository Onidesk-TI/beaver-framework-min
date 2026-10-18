(function () {
  'use strict';

  function init() {
    var btn      = document.getElementById('gearBtn');
    var popover  = document.getElementById('settingsPopover');
    var backdrop = document.getElementById('settingsBackdrop');
    if (!btn || !popover) return;

    var closeBtn = document.getElementById('settingsClose');

    function open() {
      popover.classList.add('open');
      btn.classList.add('active');
      if (backdrop) backdrop.classList.add('open');
      btn.setAttribute('aria-expanded', 'true');
    }

    function close() {
      popover.classList.remove('open');
      btn.classList.remove('active');
      if (backdrop) backdrop.classList.remove('open');
      btn.setAttribute('aria-expanded', 'false');
    }

    function toggle() {
      if (popover.classList.contains('open')) close();
      else open();
    }

    btn.addEventListener('click', function (e) {
      e.stopPropagation();
      toggle();
    });

    if (closeBtn) {
      closeBtn.addEventListener('click', close);
    }

    if (backdrop) {
      backdrop.addEventListener('click', close);
    }

    document.addEventListener('keydown', function (e) {
      if (e.key === 'Escape' && popover.classList.contains('open')) {
        close();
      }
    });

    // Fechar ao clicar fora do popover
    document.addEventListener('click', function (e) {
      if (!popover.classList.contains('open')) return;
      if (popover.contains(e.target)) return;
      if (btn.contains(e.target)) return;
      close();
    });
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }
})();
