<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'ID Sports') ?> — <?= APP_NAME ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Jockey+One&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= BASE_URL ?>public/css/auth.css">
    <?php
    $cfg = [];
    if (class_exists('ConfigModel')) {
        try { $cfg = (new ConfigModel())->getAll(); } catch (Exception $e) { $cfg = []; }
    }
    $primaryColor = $cfg['color_primary']      ?? '#0EA5E9';
    $btnColor     = $cfg['color_login_button'] ?? $primaryColor;
    $authBgImage  = $cfg['auth_bg_image']      ?? '';
    $logoPath     = $cfg['app_logo_path']       ?? '';
    $logoSrc      = $logoPath ? BASE_URL . htmlspecialchars($logoPath) : BASE_URL . 'public/assets/logo.svg';
    $appName      = defined('APP_NAME') ? APP_NAME : 'ID Sports';

    // Compute primary-color rgba variants for CSS variables (so gradient reacts to admin color)
    $hex = ltrim($primaryColor, '#');
    if (strlen($hex) === 3) { $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2]; }
    $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
    $primaryGlow  = "rgba($r,$g,$b,0.22)";
    $primaryGlowLight = "rgba($r,$g,$b,0.09)";
    ?>
    <style>
        :root {
            --primary:        <?= htmlspecialchars($primaryColor) ?>;
            --btn-color:      <?= htmlspecialchars($btnColor) ?>;
            --primary-glow:   <?= $primaryGlow ?>;
            --primary-glow5:  <?= $primaryGlowLight ?>;
        }
    </style>
    <?php if (($currentPage ?? '') === 'login'): ?>
    <script>
        // Redirect to onboarding if not yet seen (hide flash to prevent layout flash)
        if (!localStorage.getItem('ids_onboarding_seen')) {
            document.documentElement.style.visibility = 'hidden';
            window.location.replace('<?= BASE_URL ?>auth/onboarding');
        }
    </script>
    <?php endif; ?>
    <!-- Apply theme immediately to avoid flash -->
    <script>
        (function(){
            var t = localStorage.getItem('auth_theme');
            if (t === 'light') document.documentElement.setAttribute('data-theme','light');
        }());
    </script>
</head>
<body class="auth-page">

<!-- ── Background ─────────────────────────────────────── -->
<div class="auth-bg" <?php if ($authBgImage): ?>style="background-image:url('<?= htmlspecialchars($authBgImage) ?>')"<?php endif; ?>>
    <?php if (!$authBgImage): ?><div class="auth-bg-default"></div><?php endif; ?>
    <!-- Giant "ID SPORTS" watermark — Jockey One, primary color glow, breathing pulse -->
    <div class="auth-bg-title"><?= htmlspecialchars($appName) ?></div>
</div>

<!-- ── Logo ───────────────────────────────────────────── -->
<div class="auth-logo">
    <a href="<?= BASE_URL ?>" class="auth-logo-icon">
        <img src="<?= $logoSrc ?>" alt="<?= htmlspecialchars($appName) ?>">
        <span><?= htmlspecialchars($appName) ?></span>
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
        <p class="auth-copyright">
            © <?= date('Y') ?> <?= htmlspecialchars($appName) ?> v<?= APP_VERSION ?>
        </p>
    </div>
</div>

<!-- ── Theme toggle button ─────────────────────────────── -->
<button class="auth-theme-toggle" id="authThemeToggle" title="Cambiar tema claro/oscuro">🌙</button>

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

    /* ── Theme toggle ──────────────────────────────────── */
    (function () {
        var btn  = document.getElementById('authThemeToggle');
        var html = document.documentElement;
        function applyTheme(t) {
            if (t === 'light') {
                html.setAttribute('data-theme', 'light');
                btn.textContent = '☀️';
            } else {
                html.removeAttribute('data-theme');
                btn.textContent = '🌙';
            }
        }
        // Init from stored preference
        applyTheme(localStorage.getItem('auth_theme') || 'dark');

        btn.addEventListener('click', function () {
            var current = html.getAttribute('data-theme') === 'light' ? 'light' : 'dark';
            var next    = current === 'light' ? 'dark' : 'light';
            localStorage.setItem('auth_theme', next);
            applyTheme(next);
        });
    }());

    /* ── JS-generated starfield + sport particles ──────── */
    (function createStarfield() {
        var bg = document.querySelector('.auth-bg');
        if (!bg) return;

        var container = document.createElement('div');
        container.className = 'auth-starfield';

        var sportEmojis = ['⚽','🏀','🎾','🏊','🏋️','🎯','🏐','🥊','🏆','⚡',
                           '🥅','🏈','🏒','🥋','🎱','🏓','🏸','🤿','🛹','🏄'];
        var driftDurations = [18,22,20,25,19,23,21,17,24,20,
                               16,26,18,22,20,24,19,21,23,17];
        var driftDelays    = [0,2,5,1,7,3,9,4,6,11,
                               1,8,3,10,5,2,7,4,9,6];

        // 55 tiny star dots — pure CSS animation, no JS loop
        for (var i = 0; i < 55; i++) {
            var star = document.createElement('span');
            star.className = 'auth-star';
            var size = 1 + Math.random() * 2.8;
            star.style.cssText = [
                'left:'               + (Math.random() * 100) + '%',
                'top:'                + (Math.random() * 100) + '%',
                'width:'              + size.toFixed(2) + 'px',
                'height:'             + size.toFixed(2) + 'px',
                'animation-delay:'    + (Math.random() * 14).toFixed(2) + 's',
                'animation-duration:' + (3 + Math.random() * 8).toFixed(2) + 's',
            ].join(';');
            container.appendChild(star);
        }

        // 20 sport emoji particles — positioned randomly like a starfield
        for (var j = 0; j < 20; j++) {
            var p = document.createElement('span');
            p.className = 'auth-particle';
            p.textContent = sportEmojis[j];
            var driftN = (j % 10) + 1;
            p.style.cssText = [
                'position:absolute',
                'left:'               + (2 + Math.random() * 90).toFixed(1) + '%',
                'top:'                + (2 + Math.random() * 88).toFixed(1) + '%',
                'animation:drift-'    + driftN + ' ' + driftDurations[j] + 's ease-in-out infinite ' + driftDelays[j] + 's',
            ].join(';');
            container.appendChild(p);
        }

        // Insert starfield as first child of .auth-bg
        bg.insertBefore(container, bg.firstChild);
    }());
</script>
</body>
</html>
