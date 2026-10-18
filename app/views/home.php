<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title data-i18n="home.pageTitle">beaver-min</title>
<link rel="stylesheet" href="/assets/css/i18n.css">
<link rel="stylesheet" href="/assets/css/settings.css">
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:Inter,system-ui,sans-serif;background:#F4F5F7;min-height:100vh;display:grid;place-items:center;padding:24px 24px 96px;color:#2B2F36}
  .card{background:#fff;border:1px solid #E4E6EA;border-radius:20px;padding:48px 40px;max-width:520px;width:100%;text-align:center;box-shadow:0 30px 60px -30px rgba(0,0,0,.15)}
  .logo{width:96px;height:96px;border-radius:24px;background:linear-gradient(150deg,#FFD79A,#FFC46B 55%,#FF9A3C);border:1.5px solid rgba(138,74,0,.35);display:grid;place-items:center;margin:0 auto 20px;box-shadow:0 16px 32px -16px rgba(224,120,0,.6)}
  .logo svg{width:72px;height:72px;display:block}
  .tag{display:inline-block;font-size:.7rem;font-weight:700;padding:4px 12px;background:rgba(245,166,35,.15);color:#7A3F00;border-radius:100px;margin-bottom:16px;letter-spacing:.08em;text-transform:uppercase}
  h1{font-size:2rem;letter-spacing:-.03em;margin-bottom:12px}
  p{color:#5F656D;font-size:1rem;line-height:1.6;margin-bottom:28px}
  a.btn{display:inline-block;padding:14px 28px;background:linear-gradient(150deg,#FFC46B,#E07800);color:#fff;text-decoration:none;border-radius:12px;font-weight:700;box-shadow:0 10px 24px -12px rgba(224,120,0,.6);transition:transform .15s}
  a.btn:hover{transform:translateY(-2px)}
</style>
</head>
<body>

<?php require __DIR__ . '/partials/svg-sprite.php'; ?>

<div class="card">
  <div class="logo">
    <svg viewBox="0 0 64 64"><use href="#beaver"/></svg>
  </div>
  <span class="tag" data-i18n="home.tag">beaver-min</span>
  <h1 data-i18n="home.title">Versão mínima</h1>
  <p data-i18n="home.desc">Core + 1 plugin de demonstração. Tudo o que precisas para começar, nada mais.</p>
  <a class="btn" href="/human-check" data-i18n="home.cta">Testar human-check →</a>
</div>

<div class="lang-switcher" role="group" aria-label="Language">
  <button type="button" data-lang="pt"><span class="flag">🇵🇹</span><span class="label">PT</span></button>
  <button type="button" data-lang="en"><span class="flag">🇬🇧</span><span class="label">EN</span></button>
  <button type="button" data-lang="es"><span class="flag">🇪🇸</span><span class="label">ES</span></button>
  <button type="button" data-lang="fr"><span class="flag">🇫🇷</span><span class="label">FR</span></button>
</div>

<?php require __DIR__ . '/partials/settings-modal.php'; ?>

<script src="/assets/js/i18n.js"></script>
<script src="/assets/js/settings.js"></script>
</body>
</html>
