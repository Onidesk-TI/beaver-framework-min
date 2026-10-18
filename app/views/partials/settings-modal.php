<!-- ─── Settings gear (topo direito) ─── -->
<button type="button" class="gear-btn" id="gearBtn" aria-label="Sobre o Beaver" aria-expanded="false" aria-controls="settingsPopover" title="Sobre">
  <svg viewBox="0 0 24 24">
    <circle cx="12" cy="12" r="3"/>
    <path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/>
  </svg>
</button>

<!-- ─── Backdrop invisível (fecha ao clicar fora) ─── -->
<div class="settings-backdrop" id="settingsBackdrop"></div>

<!-- ─── Popover (colado à roda) ─── -->
<div class="settings-popover" id="settingsPopover" role="dialog" aria-labelledby="settingsTitle">
  <div class="settings-card">
    <button type="button" class="settings-close" id="settingsClose" aria-label="Fechar">×</button>

    <div class="settings-head">
      <div class="settings-logo">
        <svg viewBox="0 0 64 64"><use href="#beaver"/></svg>
      </div>
      <div>
        <h2 class="settings-title" id="settingsTitle" data-i18n="settings.title">Beaver Framework</h2>
        <div class="settings-version" data-i18n="settings.version">v0.1.0 · MIT</div>
      </div>
    </div>

    <div class="settings-row">
      <span class="label" data-i18n="settings.author">Autor</span>
      <span class="value">Franco · <a href="https://github.com/Onidesk-TI" target="_blank" rel="noopener">Onidesk</a></span>
    </div>

    <div class="settings-row">
      <span class="label" data-i18n="settings.license">Licença</span>
      <span class="value">MIT</span>
    </div>

    <div class="settings-row">
      <span class="label" data-i18n="settings.repo">Repositório</span>
      <a href="https://github.com/Onidesk-TI/beaver-framework" target="_blank" rel="noopener" data-i18n="settings.viewOnGithub">Ver no GitHub →</a>
    </div>

    <div class="settings-cta">
      <h3 data-i18n="settings.getInvolved">Get involved</h3>
      <div class="settings-links">
        <a href="https://github.com/Onidesk-TI/beaver-framework" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24"><path d="M12 .5C5.7.5.5 5.7.5 12c0 5.1 3.3 9.4 7.9 10.9.6.1.8-.2.8-.6v-2c-3.2.7-3.9-1.5-3.9-1.5-.5-1.3-1.3-1.7-1.3-1.7-1.1-.7.1-.7.1-.7 1.2.1 1.8 1.2 1.8 1.2 1 1.8 2.7 1.3 3.4 1 .1-.8.4-1.3.7-1.6-2.6-.3-5.3-1.3-5.3-5.8 0-1.3.5-2.3 1.2-3.1-.1-.3-.5-1.5.1-3.1 0 0 1-.3 3.3 1.2a11.5 11.5 0 016 0C17.6 4.7 18.6 5 18.6 5c.6 1.6.2 2.8.1 3.1.8.8 1.2 1.8 1.2 3.1 0 4.5-2.7 5.5-5.3 5.8.4.4.8 1.1.8 2.2v3.3c0 .3.2.7.8.6 4.6-1.5 7.9-5.8 7.9-10.9C23.5 5.7 18.3.5 12 .5z"/></svg>
          GitHub
        </a>
        <a href="https://github.com/Onidesk-TI/beaver-framework/issues" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm0 18c-4.4 0-8-3.6-8-8s3.6-8 8-8 8 3.6 8 8-3.6 8-8 8zm1-13h-2v6l5.2 3.2.8-1.3-4-2.4V7z"/></svg>
          Issues
        </a>
        <a href="https://github.com/Onidesk-TI/beaver-framework/blob/main/CONTRIBUTING.md" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24"><path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10 10-4.5 10-10S17.5 2 12 2zm-2 15l-5-5 1.4-1.4L10 14.2l7.6-7.6L19 8l-9 9z"/></svg>
          Contribuir
        </a>
        <a href="https://github.com/Onidesk-TI/beaver-framework/discussions" target="_blank" rel="noopener">
          <svg viewBox="0 0 24 24"><path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2z"/></svg>
          Discussões
        </a>
      </div>
    </div>
  </div>
</div>
