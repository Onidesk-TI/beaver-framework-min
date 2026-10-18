(function () {
  'use strict';

  // ─── Dicionários ───
  var T = {
    pt: {
      "home.pageTitle": "beaver-min",
      "home.tag":      "beaver-min",
      "home.title":    "Versão mínima",
      "home.desc":     "Core + 1 plugin de demonstração. Tudo o que precisas para começar, nada mais.",
      "home.cta":      "Testar human-check →",
      "hc.pageTitle":  "Human check — beaver-min",
      "hc.title":      "Verificação humana",
      "hc.sub":        "Prova que não és um bot",
      "hc.label":      "Quanto é {a} + {b}?",
      "hc.btn":        "Confirmar",
      "hc.back":       "← Voltar",
      "hc.ok":         "✓ Verificação passou!",
      "hc.err":        "Resposta errada.",
      "settings.title":       "Beaver Framework",
      "settings.version":     "v0.1.0 · MIT",
      "settings.author":      "Autor",
      "settings.license":     "Licença",
      "settings.repo":        "Repositório",
      "settings.viewOnGithub":"Ver no GitHub →",
      "settings.getInvolved": "Get involved"

    },
    en: {
      "home.pageTitle": "beaver-min",
      "home.tag":      "beaver-min",
      "home.title":    "Minimal version",
      "home.desc":     "Core + 1 demo plugin. Everything you need to start, nothing more.",
      "home.cta":      "Try human-check →",
      "hc.pageTitle":  "Human check — beaver-min",
      "hc.title":      "Human verification",
      "hc.sub":        "Prove you're not a bot",
      "hc.label":      "What is {a} + {b}?",
      "hc.btn":        "Confirm",
      "hc.back":       "← Back",
      "hc.ok":         "✓ Verification passed!",
      "hc.err":        "Wrong answer.",
      "settings.title":       "Beaver Framework",
      "settings.version":     "v0.1.0 · MIT",
      "settings.author":      "Author",
      "settings.license":     "License",
      "settings.repo":        "Repository",
      "settings.viewOnGithub":"View on GitHub →",
      "settings.getInvolved": "Get involved"

    },
    es: {
      "home.pageTitle": "beaver-min",
      "home.tag":      "beaver-min",
      "home.title":    "Versión mínima",
      "home.desc":     "Core + 1 plugin de demostración. Todo lo que necesitas para empezar, nada más.",
      "home.cta":      "Probar human-check →",
      "hc.pageTitle":  "Human check — beaver-min",
      "hc.title":      "Verificación humana",
      "hc.sub":        "Demuestra que no eres un bot",
      "hc.label":      "¿Cuánto es {a} + {b}?",
      "hc.btn":        "Confirmar",
      "hc.back":       "← Volver",
      "hc.ok":         "✓ ¡Verificación superada!",
      "hc.err":        "Respuesta incorrecta.",
      "settings.title":       "Beaver Framework",
      "settings.version":     "v0.1.0 · MIT",
      "settings.author":      "Autor",
      "settings.license":     "Licencia",
      "settings.repo":        "Repositorio",
      "settings.viewOnGithub":"Ver en GitHub →",
      "settings.getInvolved": "Get involved"

    },
    fr: {
      "home.pageTitle": "beaver-min",
      "home.tag":      "beaver-min",
      "home.title":    "Version minimale",
      "home.desc":     "Core + 1 plugin de démo. Tout ce qu'il faut pour commencer, rien de plus.",
      "home.cta":      "Essayer human-check →",
      "hc.pageTitle":  "Human check — beaver-min",
      "hc.title":      "Vérification humaine",
      "hc.sub":        "Prouvez que vous n'êtes pas un bot",
      "hc.label":      "Combien font {a} + {b} ?",
      "hc.btn":        "Confirmer",
      "hc.back":       "← Retour",
      "hc.ok":         "✓ Vérification réussie !",
      "hc.err":        "Réponse incorrecte.",
      "settings.title":       "Beaver Framework",
      "settings.version":     "v0.1.0 · MIT",
      "settings.author":      "Auteur",
      "settings.license":     "Licence",
      "settings.repo":        "Dépôt",
      "settings.viewOnGithub":"Voir sur GitHub →",
      "settings.getInvolved": "Get involved"

    }
  };

  var LANGS = ['pt', 'en', 'es', 'fr'];
  var DEFAULT = 'pt';

  // ─── Detectar idioma ───
  function detectLang() {
    // 1. ?lang=xx
    var q = new URLSearchParams(window.location.search).get('lang');
    if (q && LANGS.indexOf(q) !== -1) return q;

    // 2. localStorage
    try {
      var saved = localStorage.getItem('beaver-lang');
      if (saved && LANGS.indexOf(saved) !== -1) return saved;
    } catch (e) {}

    // 3. Cookie (legado)
    var m = document.cookie.match(/(?:^|;\s*)beaver-lang=([a-z]{2})/);
    if (m && LANGS.indexOf(m[1]) !== -1) return m[1];

    // 4. Browser
    var br = (navigator.language || navigator.userLanguage || '').slice(0, 2).toLowerCase();
    if (LANGS.indexOf(br) !== -1) return br;

    return DEFAULT;
  }

  // ─── Traduzir ───
  function translate(lang) {
    if (LANGS.indexOf(lang) === -1) lang = DEFAULT;

    // <html lang="...">
    document.documentElement.setAttribute('lang', lang);

    // Percorrer todos os elementos com data-i18n
    var nodes = document.querySelectorAll('[data-i18n]');
    for (var i = 0; i < nodes.length; i++) {
      var el  = nodes[i];
      var key = el.getAttribute('data-i18n');
      var dict = T[lang] || {};
      var text = dict[key] || (T[DEFAULT] && T[DEFAULT][key]) || key;

      // Substituir {a}, {b}, {n}, etc.
      var varsAttr = el.getAttribute('data-i18n-vars');
      if (varsAttr) {
        try {
          var vars = JSON.parse(varsAttr);
          for (var k in vars) {
            if (vars.hasOwnProperty(k)) {
              text = text.replace(new RegExp('\\{' + k + '\\}', 'g'), vars[k]);
            }
          }
        } catch (e) {}
      }

      // Se for <title>, tem de ser textContent
      if (el.tagName === 'TITLE') {
        el.textContent = text;
      } else if (el.getAttribute('data-i18n-html') === '1') {
        el.innerHTML = text;
      } else {
        el.textContent = text;
      }
    }

    // Marcar botão activo
    var btns = document.querySelectorAll('[data-lang]');
    for (var j = 0; j < btns.length; j++) {
      btns[j].classList.toggle('active', btns[j].getAttribute('data-lang') === lang);
    }

    // Persistir
    try { localStorage.setItem('beaver-lang', lang); } catch (e) {}
    document.cookie = 'beaver-lang=' + lang + ';path=/;max-age=31536000;SameSite=Lax';

    // Actualizar ?lang= no URL (sem recarregar)
    try {
      var url = new URL(window.location.href);
      url.searchParams.set('lang', lang);
      window.history.replaceState(null, '', url.toString());
    } catch (e) {}
  }

  // ─── Init ───
  function init() {
    // Aplicar idioma inicial
    translate(detectLang());

    // Bind dos botões
    var btns = document.querySelectorAll('[data-lang]');
    for (var i = 0; i < btns.length; i++) {
      btns[i].addEventListener('click', function () {
        translate(this.getAttribute('data-lang'));
      });
    }
  }

  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

  // API pública (opcional, para debug no console)
  window.BeaverI18n = {
    translate: translate,
    current: function () {
      try { return localStorage.getItem('beaver-lang') || DEFAULT; } catch (e) { return DEFAULT; }
    }
  };
})();
