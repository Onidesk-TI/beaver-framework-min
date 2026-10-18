<!DOCTYPE html>
<html lang="pt">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title data-i18n="hc.pageTitle">Human check</title>
<link rel="stylesheet" href="/assets/css/i18n.css">
<link rel="stylesheet" href="/assets/css/settings.css">
<style>
  *{box-sizing:border-box;margin:0;padding:0}
  body{font-family:Inter,system-ui,sans-serif;background:#F4F5F7;min-height:100vh;display:grid;place-items:center;padding:24px 24px 96px;color:#2B2F36}
  .card{background:#fff;border:1px solid #E4E6EA;border-radius:16px;padding:32px;max-width:420px;width:100%;box-shadow:0 30px 60px -30px rgba(0,0,0,.15)}
  .head{display:flex;align-items:center;gap:12px;margin-bottom:20px}
  .head-icon{width:44px;height:44px;border-radius:12px;background:linear-gradient(150deg,#FFD79A,#FFC46B 55%,#FF9A3C);display:grid;place-items:center;flex:none;border:1.5px solid rgba(138,74,0,.35)}
  .head-icon svg{width:32px;height:32px;display:block}
  h1{font-size:1.15rem;margin:0}
  p.sub{color:#5F656D;font-size:.88rem;margin:0}
  label{display:block;font-size:.78rem;font-weight:600;color:#5F656D;margin:16px 0 6px;text-transform:uppercase;letter-spacing:.04em}
  input[type=number]{width:100%;padding:12px;border:1.5px solid #E4E6EA;border-radius:10px;font-size:1.3rem;text-align:center;font-family:inherit;background:#FDFBF7}
  input:focus{outline:none;border-color:#F5A623;box-shadow:0 0 0 3px rgba(245,166,35,.18);background:#fff}
  button{width:100%;margin-top:16px;padding:13px;background:linear-gradient(150deg,#FFC46B,#E07800);border:0;border-radius:10px;color:#fff;font-weight:700;font-size:.95rem;cursor:pointer;font-family:inherit}
  button:hover{transform:translateY(-1px)}
  .alert{padding:10px 14px;border-radius:8px;font-size:.85rem;margin-bottom:16px}
  .alert.ok{background:#ECFDF5;color:#065F46;border:1px solid #A7F3D0}
  .alert.err{background:#FEF2F2;color:#991B1B;border:1px solid #FECACA}
  a.back{display:block;text-align:center;margin-top:16px;font-size:.85rem;color:#E07800;text-decoration:none}
</style>
</head>
<body>

<?php require dirname(__DIR__, 4) . '/app/views/partials/svg-sprite.php'; ?>

<form class="card" method="post" action="/human-check">
  <div class="head">
    <div class="head-icon">
      <svg viewBox="0 0 64 64"><use href="#beaver"/></svg>
    </div>
    <div>
      <h1 data-i18n="hc.title">Verificação humana</h1>
      <p class="sub" data-i18n="hc.sub">Prova que não és um bot</p>
    </div>
  </div>

  <?php if (!empty($_SESSION['flash_ok'])): ?>
    <div class="alert ok" data-i18n="<?= htmlspecialchars($_SESSION['flash_ok']) ?>"></div>
    <?php unset($_SESSION['flash_ok']); ?>
  <?php endif; ?>

  <?php if (!empty($_SESSION['flash_erro'])): ?>
    <div class="alert err" data-i18n="<?= htmlspecialchars($_SESSION['flash_erro']) ?>"></div>
    <?php unset($_SESSION['flash_erro']); ?>
  <?php endif; ?>

  <label data-i18n="hc.label"
         data-i18n-vars='{"a":<?= (int)$a ?>,"b":<?= (int)$b ?>}'>Quanto é <?= (int)$a ?> + <?= (int)$b ?>?</label>
  <input type="number" name="answer" required autofocus inputmode="numeric">

  <button type="submit" data-i18n="hc.btn">Confirmar</button>
  <a href="/" class="back" data-i18n="hc.back">← Voltar</a>
</form>

<div class="lang-switcher" role="group" aria-label="Language">
  <button type="button" data-lang="pt"><span class="flag">🇵🇹</span><span class="label">PT</span></button>
  <button type="button" data-lang="en"><span class="flag">🇬🇧</span><span class="label">EN</span></button>
  <button type="button" data-lang="es"><span class="flag">🇪🇸</span><span class="label">ES</span></button>
  <button type="button" data-lang="fr"><span class="flag">🇫🇷</span><span class="label">FR</span></button>
</div>

<?php require dirname(__DIR__, 4) . '/app/views/partials/settings-modal.php'; ?>

<script src="/assets/js/i18n.js"></script>
<script src="/assets/js/settings.js"></script>
</body>
</html>
