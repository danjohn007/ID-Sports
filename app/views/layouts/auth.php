<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'ID Sports') ?> — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <?php
    // Load login color config
    $loginColors = [];
    if (class_exists('ConfigModel')) {
        try {
            $cfgModel = new ConfigModel();
            $loginColors = $cfgModel->getAll();
        } catch (Exception $e) {
            $loginColors = [];
        }
    }
    $loginBtnColor   = $loginColors['color_login_button']  ?? '#0EA5E9';
    $loginLinkColor  = $loginColors['color_login_link']    ?? '#0EA5E9';
    $loginLogoBg     = $loginColors['color_login_logo_bg'] ?? '#0EA5E9';
    ?>
    <style>
        body { font-family: 'Inter', sans-serif; }
        :root {
            --login-btn-color:  <?= htmlspecialchars($loginBtnColor) ?>;
            --login-link-color: <?= htmlspecialchars($loginLinkColor) ?>;
            --login-logo-bg:    <?= htmlspecialchars($loginLogoBg) ?>;
        }
        .login-logo-bg { background-color: var(--login-logo-bg); }
        .login-btn {
            background-color: var(--login-btn-color);
            color: #ffffff;
            width: 100%;
            font-weight: 600;
            padding: 0.75rem 1rem;
            border-radius: 0.75rem;
            transition: filter 150ms;
            border: none;
            cursor: pointer;
            font-size: 1rem;
        }
        .login-btn:hover { filter: brightness(0.9); }
        .login-link { color: var(--login-link-color); font-weight: 600; }
        .login-link:hover { filter: brightness(0.8); }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-violet-50 flex items-center justify-center p-4">

<?php if (!empty($_SESSION['flash'])): ?>
<div id="flash-msg" class="fixed top-4 right-4 z-50 max-w-sm w-full">
    <div class="rounded-2xl p-4 shadow-lg <?= $_SESSION['flash']['type'] === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' ?> flex items-center gap-3">
        <span class="text-xl"><?= $_SESSION['flash']['type'] === 'success' ? '✅' : '❌' ?></span>
        <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['flash']['message']) ?></p>
        <button onclick="this.closest('#flash-msg').remove()" class="ml-auto text-gray-400 hover:text-gray-600">✕</button>
    </div>
</div>
<?php unset($_SESSION['flash']); endif; ?>

<div class="w-full max-w-md">
    <div class="text-center mb-8">
        <a href="<?= BASE_URL ?>">
            <span class="login-logo-bg inline-flex items-center gap-3 px-6 py-3 rounded-2xl mx-auto mb-4">
                <img src="<?= BASE_URL ?>public/assets/logo.svg" alt="ID Sports" class="h-9" style="filter:brightness(0) invert(1);">
                <span class="text-white font-bold text-lg tracking-wide">ID SPORTS</span>
            </span>
        </a>
        <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($title ?? '') ?></h1>
    </div>

    <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-8">
        <?= $content ?>
    </div>

    <p class="text-center text-xs text-gray-400 mt-6">© <?= date('Y') ?> <?= APP_NAME ?> v<?= APP_VERSION ?></p>
</div>

<script>
    setTimeout(() => {
        const f = document.getElementById('flash-msg');
        if (f) f.remove();
    }, 5000);
</script>
</body>
</html>
