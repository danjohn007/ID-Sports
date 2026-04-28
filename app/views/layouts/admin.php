<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'Admin') ?> — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <style>body{font-family:'Inter',sans-serif;}</style>
</head>
<body class="bg-gray-50 min-h-screen flex">

<!-- Admin Sidebar -->
<aside id="sidebar" class="w-64 bg-gray-900 text-white flex flex-col fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-200">
    <div class="p-5 border-b border-gray-700">
        <a href="<?= BASE_URL ?>" class="flex items-center gap-3">
            <img src="<?= BASE_URL ?>public/assets/logo.svg" alt="ID Sports" class="h-9 brightness-200">
            <div>
                <p class="font-bold text-white">ID Sports</p>
                <p class="text-xs text-gray-400 capitalize"><?= htmlspecialchars($_SESSION['user_role'] ?? '') ?></p>
            </div>
        </a>
    </div>
    <nav class="flex-1 p-4 space-y-1 overflow-y-auto text-sm">

        <?php if (($_SESSION['user_role'] ?? '') === 'club_admin'): ?>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2 mt-2">Mi Club</p>
        <a href="<?= BASE_URL ?>admin/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">📊 Dashboard</a>
        <a href="<?= BASE_URL ?>admin/spaces" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🏋️ Espacios</a>
        <a href="<?= BASE_URL ?>admin/schedules" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">📅 Horarios</a>
        <a href="<?= BASE_URL ?>admin/amenities" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🎯 Amenidades</a>
        <a href="<?= BASE_URL ?>admin/reservations" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">📖 Reservaciones</a>
        <a href="<?= BASE_URL ?>admin/incidents" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">⚠️ Incidentes</a>
        <?php endif; ?>

        <?php if (($_SESSION['user_role'] ?? '') === 'super_admin'): ?>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2 mt-2">Sistema</p>
        <a href="<?= BASE_URL ?>superadmin/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🌐 Panel Global</a>
        <a href="<?= BASE_URL ?>superadmin/clubs" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🏟️ Clubes</a>
        <a href="<?= BASE_URL ?>superadmin/commissions" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">💰 Comisiones</a>
        <a href="<?= BASE_URL ?>superadmin/promotions" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🎁 Promociones</a>
        <a href="<?= BASE_URL ?>superadmin/leads" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">📣 Leads</a>
        <a href="<?= BASE_URL ?>admin/dashboard" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🏋️ Club Admin</a>
        <p class="text-xs font-semibold text-gray-500 uppercase tracking-wider px-3 mb-2 mt-4">Configuración</p>
        <a href="<?= BASE_URL ?>config/general" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">⚙️ General</a>
        <a href="<?= BASE_URL ?>config/email" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">📧 Email SMTP</a>
        <a href="<?= BASE_URL ?>config/colors" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🎨 Colores</a>
        <a href="<?= BASE_URL ?>config/sports" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="9"/><path d="M12 3v3.5M12 20.5v-3"/></svg>
            Deportes
        </a>
        <a href="<?= BASE_URL ?>config/onboarding" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🎬 Onboarding</a>
        <a href="<?= BASE_URL ?>config/paypal" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">💳 PayPal</a>
        <a href="<?= BASE_URL ?>config/qr" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">📷 API QR</a>
        <a href="<?= BASE_URL ?>config/iot" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">📡 IoT / CCTV</a>
        <a href="<?= BASE_URL ?>config/chatbot" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🤖 Chatbot</a>
        <a href="<?= BASE_URL ?>config/logs" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">📜 Bitácora</a>
        <a href="<?= BASE_URL ?>config/errors" class="flex items-center gap-3 px-3 py-2.5 rounded-lg hover:bg-gray-700 transition-colors text-gray-300 hover:text-white">🔴 Errores</a>
        <?php endif; ?>
    </nav>
    <div class="p-4 border-t border-gray-700">
        <a href="<?= BASE_URL ?>home" class="flex items-center gap-2 px-3 py-2 text-gray-400 hover:text-white hover:bg-gray-700 rounded-lg transition-colors text-sm">🏠 Ir al Portal</a>
        <a href="<?= BASE_URL ?>auth/logout" class="flex items-center gap-2 px-3 py-2 text-red-400 hover:text-red-300 hover:bg-gray-700 rounded-lg transition-colors text-sm mt-1">🚪 Cerrar Sesión</a>
    </div>
</aside>

<div id="overlay" class="fixed inset-0 bg-black/50 z-20 lg:hidden hidden" onclick="toggleSidebar()"></div>

<div class="flex-1 lg:ml-64 flex flex-col min-h-screen">
    <header class="bg-white border-b border-gray-200 sticky top-0 z-10">
        <div class="flex items-center gap-4 px-6 py-3">
            <button onclick="toggleSidebar()" class="lg:hidden text-gray-500 text-xl">☰</button>
            <h2 class="text-lg font-semibold text-gray-900 flex-1"><?= htmlspecialchars($title ?? '') ?></h2>
            <div class="flex items-center gap-3">
                <span class="text-sm text-gray-500"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></span>
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center text-white font-bold text-sm">
                    <?= strtoupper(substr($_SESSION['user_name'] ?? 'A', 0, 1)) ?>
                </div>
            </div>
        </div>
    </header>

    <?php if (!empty($_SESSION['flash'])): ?>
    <div id="flash-msg" class="mx-6 mt-4">
        <div class="rounded-xl p-4 <?= $_SESSION['flash']['type'] === 'success' ? 'bg-green-50 border border-green-200 text-green-800' : 'bg-red-50 border border-red-200 text-red-800' ?> flex items-center gap-3">
            <span><?= $_SESSION['flash']['type'] === 'success' ? '✅' : '❌' ?></span>
            <p class="text-sm font-medium"><?= htmlspecialchars($_SESSION['flash']['message']) ?></p>
            <button onclick="this.closest('#flash-msg').remove()" class="ml-auto text-gray-400">✕</button>
        </div>
    </div>
    <?php unset($_SESSION['flash']); endif; ?>

    <main class="flex-1 p-6">
        <?= $content ?>
    </main>

    <footer class="px-6 py-3 text-center text-xs text-gray-400 border-t border-gray-100">
        © <?= date('Y') ?> <?= APP_NAME ?> — Panel de Administración
    </footer>
</div>

<script>
function toggleSidebar() {
    document.getElementById('sidebar').classList.toggle('-translate-x-full');
    document.getElementById('overlay').classList.toggle('hidden');
}
setTimeout(() => { const f=document.getElementById('flash-msg'); if(f) f.style.display='none'; }, 5000);
</script>
</body>
</html>
