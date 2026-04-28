<!DOCTYPE html>
<html lang="es" class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'ID Sports') ?> — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={darkMode:'class'}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Jockey+One&family=Inter:wght@400;500;600;700&family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <?php
    $cfg = [];
    if (class_exists('ConfigModel')) {
        try { $cfg = (new ConfigModel())->getAll(); } catch (Exception $e) { $cfg = []; }
    }
    $primaryColor = $cfg['color_primary'] ?? '#0EA5E9';
    $hex = ltrim($primaryColor, '#');
    if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
    ?>
    <style>
        :root { --primary: <?= htmlspecialchars($primaryColor) ?>; --primary-rgb: <?= $r ?>,<?= $g ?>,<?= $b ?>; }
        body { font-family: 'Inter', sans-serif; }
        .jockey-one { font-family: 'Jockey One', sans-serif; }
        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.75rem;
            padding: 0.625rem 1rem;
            border-radius: 0.75rem;
            color: #4B5563;
            font-size: 0.875rem;
            font-weight: 500;
            transition: all 150ms;
            text-decoration: none;
        }
        .dark .sidebar-link { color: #9CA3AF; }
        .sidebar-link:hover { background-color: #f0f9ff; color: #0284c7; }
        .dark .sidebar-link:hover { background-color: rgba(<?= $r ?>,<?= $g ?>,<?= $b ?>,0.15); color: #38bdf8; }
        .sidebar-link.active { background-color: var(--primary); color: #ffffff; }
        /* Bottom nav */
        .bottom-nav { position: fixed; bottom: 0; left: 0; right: 0; z-index: 40; background: white; border-top: 1px solid #f1f5f9; safe-area-inset-bottom: env(safe-area-inset-bottom); padding-bottom: env(safe-area-inset-bottom); }
        .dark .bottom-nav { background: #1f2937; border-color: #374151; }
        .bottom-nav-link { display: flex; flex-direction: column; align-items: center; gap: 2px; padding: 8px 4px 6px; min-width: 0; flex: 1; cursor: pointer; text-decoration: none; transition: all 150ms; }
        .bottom-nav-link svg, .bottom-nav-link .nav-icon { color: #94A3B8; transition: all 150ms; }
        .bottom-nav-link span { font-size: 10px; color: #94A3B8; font-weight: 500; transition: all 150ms; }
        .bottom-nav-link.active svg, .bottom-nav-link.active .nav-icon { color: var(--primary); }
        .bottom-nav-link.active span { color: var(--primary); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex">

<!-- Sidebar (desktop) -->
<aside id="sidebar" class="w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 flex flex-col fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-200">
    <div class="p-5 border-b border-gray-100 dark:border-gray-700">
        <a href="<?= BASE_URL ?>" class="flex items-center gap-3">
            <img src="<?= BASE_URL ?>public/assets/logo.svg" alt="ID Sports" class="h-9">
            <span class="jockey-one font-bold text-gray-900 dark:text-white text-xl">ID Sports</span>
        </a>
    </div>
    <nav class="flex-1 p-4 overflow-y-auto" style="display:flex;flex-direction:column;gap:0.25rem;">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-2">Principal</p>
        <a href="<?= BASE_URL ?>home" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/home') !== false && strpos($_SERVER['REQUEST_URI'] ?? '', '/home/') === false ? 'active' : '' ?>">🏠 Inicio</a>
        <a href="<?= BASE_URL ?>reservations/search" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/reservations/search') !== false ? 'active' : '' ?>">🔍 Buscar Canchas</a>
        <a href="<?= BASE_URL ?>reservations/history" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/reservations/history') !== false ? 'active' : '' ?>">📋 Historial</a>
        <a href="<?= BASE_URL ?>clubs" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/clubs') !== false ? 'active' : '' ?>">🏟️ Solicitudes</a>

        <?php if (in_array($_SESSION['user_role'] ?? '', ['club_admin', 'super_admin'])): ?>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mt-4 mb-2">Admin Club</p>
        <a href="<?= BASE_URL ?>admin/dashboard" class="sidebar-link">📊 Dashboard</a>
        <a href="<?= BASE_URL ?>admin/spaces" class="sidebar-link">🏋️ Espacios</a>
        <a href="<?= BASE_URL ?>admin/schedules" class="sidebar-link">📅 Horarios</a>
        <a href="<?= BASE_URL ?>admin/amenities" class="sidebar-link">🎯 Amenidades</a>
        <a href="<?= BASE_URL ?>admin/reservations" class="sidebar-link">📖 Reservaciones</a>
        <a href="<?= BASE_URL ?>admin/incidents" class="sidebar-link">⚠️ Incidentes</a>
        <?php endif; ?>

        <?php if (($_SESSION['user_role'] ?? '') === 'super_admin'): ?>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mt-4 mb-2">Super Admin</p>
        <a href="<?= BASE_URL ?>superadmin/dashboard" class="sidebar-link">🌐 Panel Global</a>
        <a href="<?= BASE_URL ?>superadmin/clubs" class="sidebar-link">🏟️ Gestión Clubes</a>
        <a href="<?= BASE_URL ?>superadmin/commissions" class="sidebar-link">💰 Comisiones</a>
        <a href="<?= BASE_URL ?>superadmin/promotions" class="sidebar-link">🎁 Promociones</a>
        <a href="<?= BASE_URL ?>superadmin/leads" class="sidebar-link">📣 Leads</a>
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mt-4 mb-2">Configuración</p>
        <a href="<?= BASE_URL ?>config/general" class="sidebar-link">⚙️ General</a>
        <a href="<?= BASE_URL ?>config/email" class="sidebar-link">📧 Email</a>
        <a href="<?= BASE_URL ?>config/colors" class="sidebar-link">🎨 Colores</a>
        <a href="<?= BASE_URL ?>config/paypal" class="sidebar-link">💳 PayPal</a>
        <a href="<?= BASE_URL ?>config/qr" class="sidebar-link">📷 QR</a>
        <a href="<?= BASE_URL ?>config/iot" class="sidebar-link">📡 IoT</a>
        <a href="<?= BASE_URL ?>config/logs" class="sidebar-link">📜 Bitácora</a>
        <a href="<?= BASE_URL ?>config/errors" class="sidebar-link">🔴 Errores</a>
        <a href="<?= BASE_URL ?>config/chatbot" class="sidebar-link">🤖 Chatbot</a>
        <?php endif; ?>
    </nav>
    <div class="p-4 border-t border-gray-100 dark:border-gray-700">
        <a href="<?= BASE_URL ?>user/profile" class="flex items-center gap-3 px-3 py-2 rounded-xl hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
            <?php if (!empty($_SESSION['user_avatar'])): ?>
            <img src="<?= htmlspecialchars($_SESSION['user_avatar']) ?>" class="w-9 h-9 rounded-full object-cover" alt="Avatar">
            <?php else: ?>
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center text-white font-bold text-sm">
                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
            </div>
            <?php endif; ?>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></p>
                <p class="text-xs text-gray-400 capitalize"><?= htmlspecialchars($_SESSION['user_role'] ?? '') ?></p>
            </div>
        </a>
        <button onclick="toggleDarkMode()" class="mt-1 w-full flex items-center gap-2 px-4 py-2 text-sm text-gray-500 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-700 rounded-xl transition-colors">
            <span id="darkModeIcon"><?= ($_SESSION['dark_mode'] ?? 0) ? '☀️' : '🌙' ?></span>
            <span id="darkModeLabel"><?= ($_SESSION['dark_mode'] ?? 0) ? 'Modo claro' : 'Modo oscuro' ?></span>
        </button>
        <a href="<?= BASE_URL ?>auth/logout" class="mt-1 flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 dark:hover:bg-red-900/20 rounded-xl transition-colors">
            🚪 Cerrar Sesión
        </a>
    </div>
</aside>

<!-- Overlay (mobile sidebar) -->
<div id="overlay" class="fixed inset-0 bg-black/40 z-20 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- Main content -->
<div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
    <!-- Top bar -->
    <header class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-10">
        <div class="flex items-center gap-4 px-4 py-3">
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white text-xl p-1">☰</button>
            <div class="flex-1">
                <h2 class="text-base font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($title ?? '') ?></h2>
            </div>
            <?php if (!empty($unreadNotifications ?? 0)): ?>
            <button onclick="openNotifications()" class="relative p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white transition-colors" title="Notificaciones">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
                <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>
            <?php else: ?>
            <button onclick="openNotifications()" class="p-2 text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-white transition-colors" title="Notificaciones">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
                </svg>
            </button>
            <?php endif; ?>
            <a href="<?= BASE_URL ?>reservations/search" class="hidden sm:flex items-center gap-2 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors" style="background-color:var(--primary)">
                ➕ Nueva Reserva
            </a>
        </div>
    </header>

    <!-- Flash message -->
    <?php if (!empty($_SESSION['flash'])): ?>
    <div id="flash-msg" class="mx-4 mt-3">
        <div class="rounded-2xl p-4 <?= $_SESSION['flash']['type'] === 'success' ? 'bg-green-50 border border-green-200 text-green-800 dark:bg-green-900/20 dark:border-green-800 dark:text-green-300' : 'bg-red-50 border border-red-200 text-red-800 dark:bg-red-900/20 dark:border-red-800 dark:text-red-300' ?> flex items-center gap-3">
            <span><?= $_SESSION['flash']['type'] === 'success' ? '✅' : '❌' ?></span>
            <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['flash']['message']) ?></p>
            <button onclick="this.closest('#flash-msg').remove()" class="ml-auto text-gray-400 hover:text-gray-600">✕</button>
        </div>
    </div>
    <?php unset($_SESSION['flash']); endif; ?>

    <main class="flex-1 p-4 pb-20 lg:pb-6">
        <?= $content ?>
    </main>

    <footer class="hidden lg:block px-6 py-4 text-center text-xs text-gray-400 dark:text-gray-600 border-t border-gray-100 dark:border-gray-800">
        © <?= date('Y') ?> <?= APP_NAME ?> v<?= APP_VERSION ?>
    </footer>
</div>

<!-- Mobile Bottom Navigation (RF2 - shown only on mobile) -->
<nav class="bottom-nav lg:hidden" id="bottomNav">
    <div class="flex items-center max-w-sm mx-auto">
        <?php
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $isHome = preg_match('#/home$|/home\?|^/$#', $uri);
        $isSearch = strpos($uri, '/reservations/search') !== false || strpos($uri, '/spaces') !== false;
        $isHistory = strpos($uri, '/reservations/history') !== false;
        $isClubs = strpos($uri, '/clubs') !== false;
        $isProfile = strpos($uri, '/user/profile') !== false || strpos($uri, '/user/settings') !== false;
        ?>
        <a href="<?= BASE_URL ?>home" class="bottom-nav-link <?= $isHome ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="<?= $isHome ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="2">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span>Home</span>
        </a>
        <a href="<?= BASE_URL ?>reservations/search" class="bottom-nav-link <?= $isSearch ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <span>Buscar</span>
        </a>
        <a href="<?= BASE_URL ?>reservations/history" class="bottom-nav-link <?= $isHistory ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span>Historial</span>
        </a>
        <a href="<?= BASE_URL ?>clubs" class="bottom-nav-link <?= $isClubs ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Solicitudes</span>
        </a>
        <a href="<?= BASE_URL ?>user/profile" class="bottom-nav-link <?= $isProfile ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <span>Perfil</span>
        </a>
    </div>
</nav>

<!-- Notifications Drawer -->
<div id="notifDrawer" class="fixed inset-y-0 right-0 w-80 max-w-full bg-white dark:bg-gray-800 shadow-2xl z-50 transform translate-x-full transition-transform duration-300">
    <div class="flex items-center justify-between p-5 border-b border-gray-100 dark:border-gray-700">
        <h3 class="font-semibold text-gray-900 dark:text-white">Notificaciones</h3>
        <button onclick="closeNotifications()" class="text-gray-400 hover:text-gray-600 dark:hover:text-white transition-colors">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
    <div id="notifList" class="overflow-y-auto h-full pb-20 p-4 space-y-2">
        <p class="text-sm text-gray-400 text-center py-8">Cargando...</p>
    </div>
</div>
<div id="notifOverlay" class="fixed inset-0 bg-black/40 z-40 hidden" onclick="closeNotifications()"></div>

<script>
function toggleSidebar() {
    const sb = document.getElementById('sidebar');
    const ov = document.getElementById('overlay');
    sb.classList.toggle('-translate-x-full');
    ov.classList.toggle('hidden');
}
setTimeout(() => {
    const f = document.getElementById('flash-msg');
    if (f) f.style.display = 'none';
}, 5000);

function toggleDarkMode() {
    fetch('<?= BASE_URL ?>home/toggle-dark', {method:'POST'})
        .then(r => r.json())
        .then(d => {
            if (d.dark_mode) {
                document.documentElement.classList.add('dark');
                document.getElementById('darkModeIcon').textContent = '☀️';
                document.getElementById('darkModeLabel').textContent = 'Modo claro';
            } else {
                document.documentElement.classList.remove('dark');
                document.getElementById('darkModeIcon').textContent = '🌙';
                document.getElementById('darkModeLabel').textContent = 'Modo oscuro';
            }
        });
}

function openNotifications() {
    const drawer = document.getElementById('notifDrawer');
    const overlay = document.getElementById('notifOverlay');
    drawer.classList.remove('translate-x-full');
    overlay.classList.remove('hidden');

    fetch('<?= BASE_URL ?>home/notifications')
        .then(r => r.json())
        .then(data => {
            const list = document.getElementById('notifList');
            if (!data.notifications || !data.notifications.length) {
                list.innerHTML = '<p class="text-sm text-gray-400 text-center py-8">Sin notificaciones</p>';
                return;
            }
            list.innerHTML = data.notifications.map(n => `
                <div class="p-3 rounded-xl ${n.is_read == 0 ? 'bg-sky-50 dark:bg-sky-900/20 border border-sky-100 dark:border-sky-800' : 'bg-gray-50 dark:bg-gray-700/50'} transition-all">
                    <p class="text-sm font-semibold text-gray-900 dark:text-white">${escHtml(n.title)}</p>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5">${escHtml(n.body || '')}</p>
                    <p class="text-xs text-gray-400 mt-1">${n.created_at}</p>
                </div>
            `).join('');
        });
}

function closeNotifications() {
    document.getElementById('notifDrawer').classList.add('translate-x-full');
    document.getElementById('notifOverlay').classList.add('hidden');
}

function escHtml(s) {
    const d = document.createElement('div');
    d.textContent = s;
    return d.innerHTML;
}
</script>
</body>
</html>

