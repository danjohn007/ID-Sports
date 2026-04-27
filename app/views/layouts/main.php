<!DOCTYPE html>
<html lang="es" class="<?= ($_SESSION['dark_mode'] ?? 0) ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'ID Sports') ?> — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={darkMode:'class'}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        .sidebar-link { @apply flex items-center gap-3 px-4 py-2.5 rounded-xl text-gray-600 hover:bg-sky-50 hover:text-sky-600 transition-all text-sm font-medium; }
        .sidebar-link.active { @apply bg-sky-500 text-white; }
    </style>
</head>
<body class="bg-gray-50 dark:bg-gray-900 min-h-screen flex">

<!-- Sidebar -->
<aside id="sidebar" class="w-64 bg-white dark:bg-gray-800 border-r border-gray-100 dark:border-gray-700 flex flex-col fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-200">
    <div class="p-5 border-b border-gray-100 dark:border-gray-700">
        <a href="<?= BASE_URL ?>" class="flex items-center gap-3">
            <img src="<?= BASE_URL ?>public/assets/logo.svg" alt="ID Sports" class="h-9">
            <span class="font-bold text-gray-900 dark:text-white text-lg">ID Sports</span>
        </a>
    </div>
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto">
        <p class="text-xs font-semibold text-gray-400 uppercase tracking-wider px-4 mb-2">Principal</p>
        <a href="<?= BASE_URL ?>home" class="sidebar-link <?= strpos($_SERVER['REQUEST_URI'] ?? '', '/home') !== false ? 'active' : '' ?>">🏠 Inicio</a>
        <a href="<?= BASE_URL ?>reservations/search" class="sidebar-link">🔍 Buscar Canchas</a>
        <a href="<?= BASE_URL ?>reservations/history" class="sidebar-link">📋 Mis Reservaciones</a>
        <a href="<?= BASE_URL ?>clubs" class="sidebar-link">🏟️ Clubes</a>

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
            <div class="w-9 h-9 rounded-full bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center text-white font-bold text-sm">
                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-gray-900 dark:text-white truncate"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></p>
                <p class="text-xs text-gray-400 capitalize"><?= htmlspecialchars($_SESSION['user_role'] ?? '') ?></p>
            </div>
        </a>
        <a href="<?= BASE_URL ?>auth/logout" class="mt-2 flex items-center gap-2 px-4 py-2 text-sm text-red-500 hover:bg-red-50 rounded-xl transition-colors">
            🚪 Cerrar Sesión
        </a>
    </div>
</aside>

<!-- Overlay -->
<div id="overlay" class="fixed inset-0 bg-black/40 z-20 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- Main content -->
<div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
    <!-- Top bar -->
    <header class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700 sticky top-0 z-10">
        <div class="flex items-center gap-4 px-6 py-3">
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 hover:text-gray-700 text-xl">☰</button>
            <div class="flex-1">
                <h2 class="text-lg font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($title ?? '') ?></h2>
            </div>
            <a href="<?= BASE_URL ?>reservations/search" class="hidden sm:flex items-center gap-2 bg-sky-500 hover:bg-sky-600 text-white px-4 py-2 rounded-xl text-sm font-medium transition-colors">
                ➕ Nueva Reserva
            </a>
        </div>
    </header>

    <!-- Flash message -->
    <?php if (!empty($_SESSION['flash'])): ?>
    <div id="flash-msg" class="mx-6 mt-4">
        <div class="rounded-2xl p-4 <?= $_SESSION['flash']['type'] === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' ?> flex items-center gap-3">
            <span><?= $_SESSION['flash']['type'] === 'success' ? '✅' : '❌' ?></span>
            <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['flash']['message']) ?></p>
            <button onclick="this.closest('#flash-msg').remove()" class="ml-auto text-gray-400 hover:text-gray-600">✕</button>
        </div>
    </div>
    <?php unset($_SESSION['flash']); endif; ?>

    <main class="flex-1 p-6">
        <?= $content ?>
    </main>

    <footer class="px-6 py-4 text-center text-xs text-gray-400 border-t border-gray-100">
        © <?= date('Y') ?> <?= APP_NAME ?> v<?= APP_VERSION ?>
    </footer>
</div>

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
</script>
</body>
</html>
