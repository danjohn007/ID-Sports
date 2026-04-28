<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'ID Sports') ?> — <?= APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Jockey+One&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/auth.css">
    <?php
    $cfg = [];
    if (class_exists('ConfigModel')) {
        try { $cfg = (new ConfigModel())->getAll(); } catch (Exception $e) { $cfg = []; }
    }
    $primaryColor = $cfg['color_primary']      ?? '#0EA5E9';
    $btnColor     = $cfg['color_login_button'] ?? $primaryColor;
    $authBgImage  = $cfg['auth_bg_image']      ?? '';
    ?>
    <style>
        :root {
            --primary:   <?= htmlspecialchars($primaryColor) ?>;
            --btn-color: <?= htmlspecialchars($btnColor) ?>;
        }
    </style>
    <?php if (($currentPage ?? '') === 'login'): ?>
    <script>
        // Redirect to onboarding if not yet seen
        if (!localStorage.getItem('ids_onboarding_seen')) {
            document.documentElement.style.visibility = 'hidden';
            window.location.replace('<?= BASE_URL ?>auth/onboarding');
        }
    </script>
    <?php endif; ?>
</head>
<body class="auth-page">

<!-- ── Background ─────────────────────────────────────── -->
<div class="auth-bg" <?php if ($authBgImage): ?>style="background-image:url('<?= htmlspecialchars($authBgImage) ?>')"<?php endif; ?>>
    <?php if (!$authBgImage): ?><div class="auth-bg-default"></div><?php endif; ?>
</div>

<!-- ── Logo ───────────────────────────────────────────── -->
<div class="auth-logo">
    <a href="<?= BASE_URL ?>" class="auth-logo-icon">
        <img src="<?= BASE_URL ?>public/assets/logo.svg" alt="ID Sports">
        <span>ID SPORTS</span>
    </a>
</div>

<!-- ── Flash message ──────────────────────────────────── -->
<?php if (!empty($_SESSION['flash'])): ?>
<div id="auth-flash" class="auth-flash <?= $_SESSION['flash']['type'] === 'success' ? 'success' : 'error' ?>">
    <span><?= $_SESSION['flash']['type'] === 'success' ? '✅' : '❌' ?></span>
    <p><?= htmlspecialchars($_SESSION['flash']['message']) ?></p>
    <button class="auth-flash-close" onclick="this.closest('.auth-flash').remove()">✕</button>
</div>
<?php unset($_SESSION['flash']); endif; ?>

<!-- ── Bottom Sheet ───────────────────────────────────── -->
<div class="auth-sheet">
    <div class="auth-sheet-inner">
        <div class="auth-sheet-handle"></div>
        <?= $content ?>
        <p class="text-center" style="font-size:.75rem;color:#444;margin-top:24px;">
            © <?= date('Y') ?> <?= APP_NAME ?> v<?= APP_VERSION ?>
        </p>
    </div>
</div>

<script>
    document.documentElement.style.visibility = 'visible';
    // Auto-dismiss flash after 5 s
    (function () {
        var f = document.getElementById('auth-flash');
        if (!f) return;
        setTimeout(function () {
            f.style.opacity = '0';
            f.style.transition = 'opacity .5s';
            setTimeout(function () { if (f) f.remove(); }, 500);
        }, 5000);
    }());
</script>
</body>
</html>
