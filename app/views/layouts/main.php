<!DOCTYPE html>
<html lang="es" class="<?= ($_SESSION['dark_mode'] ?? 1) ? 'dark' : '' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($title ?? 'ID Sports') ?> — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>tailwind.config={darkMode:'class'}</script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Jockey+One&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
    <?php
    $cfg = [];
    if (class_exists('ConfigModel')) {
        try { $cfg = (new ConfigModel())->getAll(); } catch (Exception $e) { $cfg = []; }
    }
    $primaryColor      = $cfg['color_primary']      ?? '#0EA5E9';
    $secondaryColor    = $cfg['color_secondary']    ?? '#6366f1';
    $lightPrimaryColor = $cfg['color_light_primary'] ?? $primaryColor;
    $logoPath = $cfg['app_logo_path'] ?? '';
    $logoSrc  = $logoPath ? BASE_URL . htmlspecialchars($logoPath) : BASE_URL . 'public/assets/logo.svg';
    $appName  = defined('APP_NAME') ? APP_NAME : 'ID Sports';

    $hex = ltrim($primaryColor, '#');
    if (strlen($hex) === 3) $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
    $r = hexdec(substr($hex,0,2)); $g = hexdec(substr($hex,2,2)); $b = hexdec(substr($hex,4,2));
    $primaryGlow  = "rgba($r,$g,$b,0.22)";
    $primaryGlow5 = "rgba($r,$g,$b,0.09)";

    $shex = ltrim($secondaryColor, '#');
    if (strlen($shex) === 3) $shex = $shex[0].$shex[0].$shex[1].$shex[1].$shex[2].$shex[2];
    $sr = hexdec(substr($shex,0,2)); $sg = hexdec(substr($shex,2,2)); $sb = hexdec(substr($shex,4,2));

    $lhex = ltrim($lightPrimaryColor, '#');
    if (strlen($lhex) === 3) $lhex = $lhex[0].$lhex[0].$lhex[1].$lhex[1].$lhex[2].$lhex[2];
    $lr = hexdec(substr($lhex,0,2)); $lg = hexdec(substr($lhex,2,2)); $lb = hexdec(substr($lhex,4,2));
    ?>
    <style>
        /* ── Design System — mirrors auth.css palette ────────── */
        :root {
            --primary:        <?= htmlspecialchars($primaryColor) ?>;
            --primary-rgb:    <?= $r ?>,<?= $g ?>,<?= $b ?>;
            --primary-glow:   <?= $primaryGlow ?>;
            --primary-glow5:  <?= $primaryGlow5 ?>;
            --secondary:      <?= htmlspecialchars($secondaryColor) ?>;
            --secondary-rgb:  <?= $sr ?>,<?= $sg ?>,<?= $sb ?>;
            --bg-deep:        #060B19;
            --bg-mid:         #0D1117;
            --bg-card:        rgba(15, 18, 30, 0.85);
            --bg-card-hover:  rgba(20, 24, 40, 0.92);
            --border-gl:      rgba(255,255,255,0.07);
            --border-gl2:     rgba(255,255,255,0.12);
            --text-pri:       #FFFFFF;
            --text-sec:       #94a3b8;
            --text-muted:     #4b5563;
        }
        html[data-theme="light"] {
            --primary:        <?= htmlspecialchars($lightPrimaryColor) ?>;
            --primary-rgb:    <?= $lr ?>,<?= $lg ?>,<?= $lb ?>;
            --bg-deep:        #f0f4f8;
            --bg-mid:         #f8fafc;
            --bg-card:        rgba(255,255,255,0.92);
            --bg-card-hover:  rgba(255,255,255,0.98);
            --border-gl:      rgba(0,0,0,0.07);
            --border-gl2:     rgba(0,0,0,0.12);
            --text-pri:       #0f172a;
            --text-sec:       #475569;
            --text-muted:     #94a3b8;
        }

        *, *::before, *::after { box-sizing: border-box; }
        html, body { height: 100%; }

        body {
            font-family: 'Poppins', sans-serif;
            background: var(--bg-deep);
            color: var(--text-pri);
            min-height: 100vh;
            display: flex;
        }

        .jockey-one { font-family: 'Jockey One', sans-serif; }

        /* ── Sidebar ─────────────────────────────────────────── */
        #sidebar {
            background: var(--bg-mid);
            border-right: 1px solid var(--border-gl);
        }
        .sidebar-logo-text { color: var(--text-pri); }

        .nav-section-label {
            font-size: 0.65rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.1em;
            color: var(--text-muted);
            padding: 0 1rem;
            margin-bottom: 0.25rem;
            margin-top: 1rem;
        }

        .sidebar-link {
            display: flex;
            align-items: center;
            gap: 0.625rem;
            padding: 0.55rem 0.875rem;
            border-radius: 0.625rem;
            color: var(--text-sec);
            font-size: 0.8125rem;
            font-weight: 500;
            transition: all 140ms ease;
            text-decoration: none;
        }
        .sidebar-link svg { flex-shrink: 0; opacity: 0.7; transition: opacity 140ms; }
        .sidebar-link:hover {
            background: rgba(var(--primary-rgb), 0.12);
            color: var(--primary);
        }
        .sidebar-link:hover svg { opacity: 1; }
        .sidebar-link.active {
            background: var(--primary);
            color: #fff;
            box-shadow: 0 4px 14px rgba(var(--primary-rgb), 0.35);
        }
        .sidebar-link.active svg { opacity: 1; }

        /* ── Main area ──────────────────────────────────────── */
        #main-wrapper {
            background: var(--bg-deep);
        }

        /* ── Topbar ─────────────────────────────────────────── */
        #topbar {
            background: var(--bg-mid);
            border-bottom: 1px solid var(--border-gl);
        }

        /* ── Flash ──────────────────────────────────────────── */
        .flash-success {
            background: rgba(16,185,129,0.12);
            border: 1px solid rgba(16,185,129,0.3);
            color: #34d399;
        }
        .flash-error {
            background: rgba(239,68,68,0.12);
            border: 1px solid rgba(239,68,68,0.3);
            color: #f87171;
        }

        /* ── Bottom nav ─────────────────────────────────────── */
        #bottomNav {
            background: var(--bg-mid);
            border-top: 1px solid var(--border-gl);
            position: fixed;
            bottom: 0; left: 0; right: 0;
            z-index: 40;
            padding-bottom: env(safe-area-inset-bottom, 0);
        }
        .bottom-nav-link {
            display: flex; flex-direction: column; align-items: center;
            gap: 3px; padding: 8px 4px 6px;
            flex: 1; text-decoration: none; transition: all 140ms;
        }
        .bottom-nav-link svg { color: var(--text-muted); transition: all 140ms; }
        .bottom-nav-link span { font-size: 10px; color: var(--text-muted); font-weight: 500; transition: all 140ms; }
        .bottom-nav-link.active svg { color: var(--primary); }
        .bottom-nav-link.active span { color: var(--primary); }

        /* ── Notifications drawer ────────────────────────────── */
        #notifDrawer {
            background: var(--bg-mid);
            border-left: 1px solid var(--border-gl);
        }

        /* ── Scrollbar ───────────────────────────────────────── */
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        .scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
        ::-webkit-scrollbar { width: 4px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: var(--border-gl2); border-radius: 2px; }
    </style>
    <!-- Apply theme immediately -->
    <script>
        (function(){
            var dm = <?= ($_SESSION['dark_mode'] ?? 1) ? 'true' : 'false' ?>;
            if (!dm) document.documentElement.setAttribute('data-theme','light');
        }());
    </script>
</head>
<body>

<!-- ── Sidebar (desktop) ──────────────────────────────────── -->
<aside id="sidebar" class="w-64 flex flex-col fixed inset-y-0 left-0 z-30 transform -translate-x-full lg:translate-x-0 transition-transform duration-200">

    <!-- Logo -->
    <div class="p-5 flex items-center gap-3" style="border-bottom:1px solid var(--border-gl)">
        <a href="<?= BASE_URL ?>" class="flex items-center gap-2.5">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0"
                 style="background:rgba(var(--primary-rgb),0.15);border:1px solid rgba(var(--primary-rgb),0.3)">
                <img src="<?= $logoSrc ?>" alt="<?= htmlspecialchars($appName) ?>" class="w-6 h-6 object-contain">
            </div>
            <span class="jockey-one text-xl sidebar-logo-text"><?= htmlspecialchars($appName) ?></span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 p-3 overflow-y-auto space-y-0.5">
        <p class="nav-section-label">Principal</p>

        <?php
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $isHome    = preg_match('#/home$|/home\?#', $uri);
        $isSearch  = strpos($uri, '/reservations/search') !== false || strpos($uri, '/spaces/') !== false;
        $isHistory = strpos($uri, '/reservations/history') !== false;
        $isClubs   = strpos($uri, '/clubs') !== false && strpos($uri, '/superadmin/clubs') === false && strpos($uri, '/admin') === false;
        ?>

        <a href="<?= BASE_URL ?>home" class="sidebar-link <?= $isHome ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor"><path d="M10 20v-6h4v6h5v-8h3L12 3 2 12h3v8z"/></svg>
            Inicio
        </a>
        <a href="<?= BASE_URL ?>reservations/search" class="sidebar-link <?= $isSearch ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Buscar Canchas
        </a>
        <a href="<?= BASE_URL ?>reservations/history" class="sidebar-link <?= $isHistory ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Historial
        </a>
        <a href="<?= BASE_URL ?>clubs" class="sidebar-link <?= $isClubs ? 'active' : '' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/></svg>
            Descubrir
        </a>

        <?php if (in_array($_SESSION['user_role'] ?? '', ['club_admin', 'super_admin'])): ?>
        <p class="nav-section-label">Admin Club</p>
        <a href="<?= BASE_URL ?>admin/dashboard" class="sidebar-link <?= strpos($uri,'/admin/dashboard')!==false?'active':'' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
            Dashboard
        </a>
        <a href="<?= BASE_URL ?>admin/spaces" class="sidebar-link <?= strpos($uri,'/admin/spaces')!==false?'active':'' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            Espacios
        </a>
        <a href="<?= BASE_URL ?>admin/schedules" class="sidebar-link <?= strpos($uri,'/admin/schedules')!==false?'active':'' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            Horarios
        </a>
        <a href="<?= BASE_URL ?>admin/amenities" class="sidebar-link <?= strpos($uri,'/admin/amenities')!==false?'active':'' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg>
            Amenidades
        </a>
        <a href="<?= BASE_URL ?>admin/reservations" class="sidebar-link <?= strpos($uri,'/admin/reservations')!==false?'active':'' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            Reservaciones
        </a>
        <a href="<?= BASE_URL ?>admin/incidents" class="sidebar-link <?= strpos($uri,'/admin/incidents')!==false?'active':'' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            Incidentes
        </a>
        <?php endif; ?>

        <?php if (($_SESSION['user_role'] ?? '') === 'super_admin'): ?>
        <p class="nav-section-label">Super Admin</p>
        <a href="<?= BASE_URL ?>superadmin/dashboard" class="sidebar-link <?= strpos($uri,'/superadmin/dashboard')!==false?'active':'' ?>">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="20" x2="18" y2="10"/><line x1="12" y1="20" x2="12" y2="4"/><line x1="6" y1="20" x2="6" y2="14"/></svg>
            Panel Global
        </a>
        <a href="<?= BASE_URL ?>superadmin/clubs" class="sidebar-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
            Gestión Clubes
        </a>
        <a href="<?= BASE_URL ?>superadmin/commissions" class="sidebar-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            Comisiones
        </a>
        <a href="<?= BASE_URL ?>superadmin/promotions" class="sidebar-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
            Promociones
        </a>
        <a href="<?= BASE_URL ?>superadmin/leads" class="sidebar-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 00-3-3.87m-4-12a4 4 0 010 7.75"/></svg>
            Leads
        </a>
        <p class="nav-section-label">Configuración</p>
        <a href="<?= BASE_URL ?>config/general" class="sidebar-link">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 00.33 1.82l.06.06a2 2 0 010 2.83 2 2 0 01-2.83 0l-.06-.06a1.65 1.65 0 00-1.82-.33 1.65 1.65 0 00-1 1.51V21a2 2 0 01-4 0v-.09A1.65 1.65 0 009 19.4a1.65 1.65 0 00-1.82.33l-.06.06a2 2 0 01-2.83-2.83l.06-.06A1.65 1.65 0 004.68 15a1.65 1.65 0 00-1.51-1H3a2 2 0 010-4h.09A1.65 1.65 0 004.6 9a1.65 1.65 0 00-.33-1.82l-.06-.06a2 2 0 012.83-2.83l.06.06A1.65 1.65 0 009 4.68a1.65 1.65 0 001-1.51V3a2 2 0 014 0v.09a1.65 1.65 0 001 1.51 1.65 1.65 0 001.82-.33l.06-.06a2 2 0 012.83 2.83l-.06.06A1.65 1.65 0 0019.4 9a1.65 1.65 0 001.51 1H21a2 2 0 010 4h-.09a1.65 1.65 0 00-1.51 1z"/></svg>
            Configuración
        </a>
        <?php endif; ?>
    </nav>

    <!-- User footer -->
    <div class="p-3" style="border-top:1px solid var(--border-gl)">
        <a href="<?= BASE_URL ?>user/profile"
           class="flex items-center gap-2.5 p-2.5 rounded-xl transition-all"
           style="hover:background:var(--bg-card)">
            <?php
            $__avatarRaw = $_SESSION['user_avatar'] ?? '';
            $__avatarSrc = (!empty($__avatarRaw) && !preg_match('#^https?://#', $__avatarRaw))
                           ? BASE_URL . ltrim($__avatarRaw, '/')
                           : $__avatarRaw;
            ?>
            <?php if (!empty($__avatarSrc)): ?>
            <img src="<?= htmlspecialchars($__avatarSrc) ?>" class="w-8 h-8 rounded-full object-cover ring-1 ring-white/10" alt="Avatar">
            <?php else: ?>
            <div class="w-8 h-8 rounded-full flex items-center justify-center text-white font-bold text-sm flex-shrink-0"
                 style="background:var(--primary)">
                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
            </div>
            <?php endif; ?>
            <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold truncate" style="color:var(--text-pri)"><?= htmlspecialchars($_SESSION['user_name'] ?? '') ?></p>
                <p class="text-xs capitalize" style="color:var(--text-sec)"><?= htmlspecialchars($_SESSION['user_role'] ?? '') ?></p>
            </div>
        </a>
        <button onclick="toggleDarkMode()"
                class="mt-1 w-full flex items-center gap-2 px-3 py-2 text-xs rounded-xl transition-all"
                style="color:var(--text-sec)"
                onmouseover="this.style.background='rgba(var(--primary-rgb),0.10)'"
                onmouseout="this.style.background='transparent'">
            <svg id="darkModeIcon" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <?php if ($_SESSION['dark_mode'] ?? 1): ?>
                <circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>
                <?php else: ?>
                <path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>
                <?php endif; ?>
            </svg>
            <span id="darkModeLabel"><?= ($_SESSION['dark_mode'] ?? 1) ? 'Modo claro' : 'Modo oscuro' ?></span>
        </button>
        <a href="<?= BASE_URL ?>auth/logout"
           class="flex items-center gap-2 px-3 py-2 text-xs rounded-xl transition-all"
           style="color:#ef4444"
           onmouseover="this.style.background='rgba(239,68,68,0.10)'"
           onmouseout="this.style.background='transparent'">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <path d="M9 21H5a2 2 0 01-2-2V5a2 2 0 012-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/>
            </svg>
            Cerrar Sesión
        </a>
    </div>
</aside>

<!-- Overlay (mobile) -->
<div id="overlay" class="fixed inset-0 bg-black/60 z-20 lg:hidden hidden" onclick="toggleSidebar()"></div>

<!-- ── Main content ─────────────────────────────────────────── -->
<div id="main-wrapper" class="flex-1 lg:ml-64 flex flex-col min-h-screen">

    <!-- Topbar -->
    <header id="topbar" class="sticky top-0 z-10">
        <div class="flex items-center gap-3 px-4 py-3">
            <button onclick="toggleSidebar()"
                    class="lg:hidden p-1.5 rounded-lg transition-all"
                    style="color:var(--text-sec)"
                    onmouseover="this.style.background='rgba(var(--primary-rgb),0.12)'"
                    onmouseout="this.style.background='transparent'">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="18" x2="21" y2="18"/>
                </svg>
            </button>
            <div class="flex-1">
                <?php if (!$isHome): ?>
                <h2 class="text-sm font-semibold" style="color:var(--text-pri)"><?= htmlspecialchars($title ?? '') ?></h2>
                <?php endif; ?>
            </div>
            <!-- Bell — hidden on home page (home view has its own header with bell) -->
            <?php if (!$isHome): ?>
            <button onclick="openNotifications()"
                    class="relative p-2 rounded-xl transition-all"
                    style="color:var(--text-sec)"
                    onmouseover="this.style.background='rgba(var(--primary-rgb),0.12)'"
                    onmouseout="this.style.background='transparent'">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
                </svg>
                <?php if (!empty($unreadNotifications ?? 0) && ($unreadNotifications ?? 0) > 0): ?>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 rounded-full"
                      style="background:var(--primary)"></span>
                <?php endif; ?>
            </button>
            <?php endif; ?>
        </div>
    </header>

    <!-- Flash message -->
    <?php if (!empty($_SESSION['flash'])): ?>
    <div id="flash-msg" class="mx-4 mt-3">
        <div class="rounded-xl px-4 py-3 <?= $_SESSION['flash']['type'] === 'success' ? 'flash-success' : 'flash-error' ?> flex items-center gap-3 text-sm">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <?php if ($_SESSION['flash']['type'] === 'success'): ?>
                <polyline points="20 6 9 17 4 12"/>
                <?php else: ?>
                <circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/>
                <?php endif; ?>
            </svg>
            <p class="font-medium"><?= htmlspecialchars($_SESSION['flash']['message']) ?></p>
            <button onclick="document.getElementById('flash-msg').remove()" class="ml-auto opacity-60 hover:opacity-100">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
            </button>
        </div>
    </div>
    <?php unset($_SESSION['flash']); endif; ?>

    <!-- Page content -->
    <main class="flex-1 p-4 pb-20 lg:pb-6">
        <?= $content ?>
    </main>

    <footer class="hidden lg:block px-6 py-3 text-center text-xs" style="color:var(--text-muted);border-top:1px solid var(--border-gl)">
        © <?= date('Y') ?> <?= htmlspecialchars($appName) ?> v<?= APP_VERSION ?>
    </footer>
</div>

<!-- ── Mobile Bottom Navigation ─────────────────────────────── -->
<nav id="bottomNav" class="lg:hidden">
    <div class="flex items-center max-w-sm mx-auto">
        <?php
        $isHome2    = preg_match('#/home$|/home\?|^/$#', $uri);
        $isSearch2  = strpos($uri, '/reservations/search') !== false || strpos($uri, '/spaces/') !== false;
        $isHistory2 = strpos($uri, '/reservations/history') !== false;
        $isClubs2   = strpos($uri, '/clubs') !== false && strpos($uri, '/admin') === false && strpos($uri, '/superadmin') === false;
        $isProfile2 = strpos($uri, '/user/profile') !== false || strpos($uri, '/user/settings') !== false;
        ?>
        <a href="<?= BASE_URL ?>home" class="bottom-nav-link <?= $isHome2 ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="<?= $isHome2 ? 'currentColor' : 'none' ?>" stroke="currentColor" stroke-width="1.8">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/><polyline points="9 22 9 12 15 12 15 22"/>
            </svg>
            <span>Home</span>
        </a>
        <a href="<?= BASE_URL ?>reservations/search" class="bottom-nav-link <?= $isSearch2 ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            <span>Buscar</span>
        </a>
        <a href="<?= BASE_URL ?>reservations/history" class="bottom-nav-link <?= $isHistory2 ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
            </svg>
            <span>Historial</span>
        </a>
        <a href="<?= BASE_URL ?>clubs" class="bottom-nav-link <?= $isClubs2 ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <circle cx="12" cy="12" r="10"/><polygon points="16.24 7.76 14.12 14.12 7.76 16.24 9.88 9.88 16.24 7.76"/>
            </svg>
            <span>Descubrir</span>
        </a>
        <a href="<?= BASE_URL ?>user/profile" class="bottom-nav-link <?= $isProfile2 ? 'active' : '' ?>">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/>
            </svg>
            <span>Perfil</span>
        </a>
    </div>
</nav>

<!-- ── Notifications Drawer ───────────────────────────────────── -->
<div id="notifDrawer" class="fixed inset-y-0 right-0 w-80 max-w-full z-50 transform translate-x-full transition-transform duration-300">
    <div class="flex items-center justify-between p-4" style="border-bottom:1px solid var(--border-gl)">
        <h3 class="font-semibold text-sm" style="color:var(--text-pri)">Notificaciones</h3>
        <button onclick="closeNotifications()" style="color:var(--text-sec)">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
    </div>
    <div id="notifList" class="overflow-y-auto p-3 space-y-2" style="height:calc(100% - 52px)">
        <p class="text-xs text-center py-8" style="color:var(--text-muted)">Cargando...</p>
    </div>
</div>
<div id="notifOverlay" class="fixed inset-0 bg-black/50 z-40 hidden" onclick="closeNotifications()"></div>

<script>
function toggleSidebar() {
    const sb = document.getElementById('sidebar');
    const ov = document.getElementById('overlay');
    sb.classList.toggle('-translate-x-full');
    ov.classList.toggle('hidden');
}

setTimeout(function() {
    const f = document.getElementById('flash-msg');
    if (f) { f.style.opacity='0'; f.style.transition='opacity .4s'; setTimeout(()=>f.remove(),400); }
}, 5000);

function toggleDarkMode() {
    fetch('<?= BASE_URL ?>home/toggle-dark', {method:'POST'})
        .then(r => r.json())
        .then(d => {
            if (d.dark_mode) {
                document.documentElement.classList.add('dark');
                document.documentElement.removeAttribute('data-theme');
            } else {
                document.documentElement.classList.remove('dark');
                document.documentElement.setAttribute('data-theme','light');
            }
            // Swap icon
            const icon = document.getElementById('darkModeIcon');
            const label = document.getElementById('darkModeLabel');
            if (d.dark_mode) {
                icon.innerHTML = '<circle cx="12" cy="12" r="5"/><line x1="12" y1="1" x2="12" y2="3"/><line x1="12" y1="21" x2="12" y2="23"/><line x1="4.22" y1="4.22" x2="5.64" y2="5.64"/><line x1="18.36" y1="18.36" x2="19.78" y2="19.78"/><line x1="1" y1="12" x2="3" y2="12"/><line x1="21" y1="12" x2="23" y2="12"/><line x1="4.22" y1="19.78" x2="5.64" y2="18.36"/><line x1="18.36" y1="5.64" x2="19.78" y2="4.22"/>';
                label.textContent = 'Modo claro';
            } else {
                icon.innerHTML = '<path d="M21 12.79A9 9 0 1111.21 3 7 7 0 0021 12.79z"/>';
                label.textContent = 'Modo oscuro';
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
                list.innerHTML = '<p class="text-xs text-center py-8" style="color:var(--text-muted)">Sin notificaciones</p>';
                return;
            }
            const typeIcons = {
                reservation: '<path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01"/>',
                promo:       '<path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/>',
                club:        '<path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>',
                system:      '<circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/>',
            };
            list.innerHTML = data.notifications.map(n => `
                <div class="p-3 rounded-xl text-xs transition-all" style="background:${n.is_read==0?'rgba(var(--primary-rgb),0.08);border:1px solid rgba(var(--primary-rgb),0.2)':'var(--bg-card);border:1px solid var(--border-gl)'}">
                    <div class="flex items-start gap-2">
                        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" class="flex-shrink-0 mt-0.5" style="color:var(--primary)">${typeIcons[n.type]||typeIcons.system}</svg>
                        <div>
                            <p class="font-semibold" style="color:var(--text-pri)">${escH(n.title)}</p>
                            <p class="mt-0.5 leading-relaxed" style="color:var(--text-sec)">${escH(n.body||'')}</p>
                            <p class="mt-1" style="color:var(--text-muted)">${n.created_at}</p>
                        </div>
                    </div>
                </div>
            `).join('');
        });
}
function closeNotifications() {
    document.getElementById('notifDrawer').classList.add('translate-x-full');
    document.getElementById('notifOverlay').classList.add('hidden');
}
function escH(s) { const d=document.createElement('div');d.textContent=s;return d.innerHTML; }
</script>
</body>
</html>
