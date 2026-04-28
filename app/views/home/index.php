<?php
// Build sport icon helper
function sportIcon($type) {
    $icons = ['football'=>'⚽','padel'=>'🎾','tennis'=>'🎾','basketball'=>'🏀','swimming'=>'🏊','volleyball'=>'🏐'];
    return $icons[$type] ?? '🏃';
}
?>
<div class="max-w-2xl mx-auto space-y-5">

    <!-- RF2.1 – Header: Avatar + Greeting + Bell -->
    <div class="flex items-center gap-3 pt-1 pb-2">
        <a href="<?= BASE_URL ?>user/profile" class="flex-shrink-0">
            <?php if (!empty($_SESSION['user_avatar'])): ?>
            <img src="<?= htmlspecialchars($_SESSION['user_avatar']) ?>" class="w-12 h-12 rounded-full object-cover ring-2 ring-sky-200 dark:ring-sky-700" alt="Avatar">
            <?php else: ?>
            <div class="w-12 h-12 rounded-full bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center text-white font-bold text-lg">
                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
            </div>
            <?php endif; ?>
        </a>
        <div class="flex-1 min-w-0">
            <p class="text-xs text-gray-500 dark:text-gray-400">Buenos días 👋</p>
            <h1 class="jockey-one text-xl font-bold text-gray-900 dark:text-white leading-tight truncate">
                Hola, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'Usuario')[0]) ?>
            </h1>
        </div>
        <button onclick="openNotifications()" class="relative w-10 h-10 rounded-2xl bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 flex items-center justify-center shadow-sm hover:shadow-md transition-all">
            <svg class="w-5 h-5 text-gray-600 dark:text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/>
            </svg>
            <?php if (!empty($unreadNotifications) && $unreadNotifications > 0): ?>
            <span class="absolute -top-0.5 -right-0.5 w-4 h-4 bg-red-500 rounded-full text-white text-xs flex items-center justify-center font-bold"><?= min($unreadNotifications, 9) ?></span>
            <?php endif; ?>
        </button>
    </div>

    <!-- RF2.2 – Today's Reservation Widget -->
    <?php if (!empty($todayReservation)): ?>
    <?php
        $res = $todayReservation;
        $nowTs   = time();
        $startTs = strtotime(date('Y-m-d') . ' ' . $res['start_time']);
        $diffH   = round(($startTs - $nowTs) / 3600, 1);
        $diffMsg = $diffH > 0
            ? ($diffH < 1
                ? 'en ' . round($diffH * 60) . ' minutos'
                : 'en ' . round($diffH) . ' hora' . ($diffH >= 2 ? 's' : ''))
            : 'ahora mismo';
    ?>
    <div class="relative bg-gradient-to-r from-sky-500 via-sky-600 to-violet-600 rounded-3xl p-5 text-white overflow-hidden shadow-lg shadow-sky-500/30">
        <div class="absolute inset-0 opacity-10">
            <div class="absolute -top-4 -right-4 w-32 h-32 rounded-full bg-white"></div>
            <div class="absolute -bottom-8 -left-8 w-48 h-48 rounded-full bg-white"></div>
        </div>
        <div class="relative">
            <div class="flex items-start justify-between gap-3">
                <div class="flex-1 min-w-0">
                    <p class="text-sky-200 text-xs font-medium uppercase tracking-wider">⚡ Reserva de hoy</p>
                    <h3 class="jockey-one text-xl font-bold mt-1 leading-tight"><?= htmlspecialchars($res['space_name']) ?></h3>
                    <p class="text-sky-100 text-sm mt-0.5"><?= htmlspecialchars($res['club_name']) ?></p>
                </div>
                <div class="flex-shrink-0 text-4xl"><?= sportIcon($res['sport_type']) ?></div>
            </div>
            <p class="mt-3 text-sky-100 text-sm">
                Tienes un partido <strong class="text-white"><?= $diffMsg ?></strong>
                &nbsp;·&nbsp; <?= substr($res['start_time'], 0, 5) ?> - <?= substr($res['end_time'], 0, 5) ?>
            </p>
            <button onclick="openQrModal('<?= htmlspecialchars($res['qr_code'] ?? 'RES-' . $res['id']) ?>', '<?= htmlspecialchars($res['space_name']) ?>')"
                class="mt-4 inline-flex items-center gap-2 bg-white text-sky-600 font-bold text-sm px-5 py-2.5 rounded-2xl hover:bg-sky-50 transition-all shadow-md">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
                </svg>
                Ver QR de Acceso
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- RF2.3 – 5-Day Quick Booking -->
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="jockey-one text-lg font-bold text-gray-900 dark:text-white">Reservar por Día</h2>
            <a href="<?= BASE_URL ?>reservations/search" class="text-xs text-sky-500 font-medium hover:text-sky-600 transition-colors">Ver todo →</a>
        </div>
        <div class="flex gap-2 overflow-x-auto pb-1 -mx-1 px-1 scrollbar-hide">
            <?php foreach ($upcomingDays as $idx => $day): ?>
            <a href="<?= BASE_URL ?>reservations/search?date=<?= $day['date'] ?>"
               class="flex-shrink-0 flex flex-col items-center px-4 py-3 rounded-2xl border text-center transition-all min-w-[68px]
                   <?= $idx === 0
                       ? 'border-sky-500 text-white shadow-md shadow-sky-500/30'
                       : 'bg-white dark:bg-gray-800 border-gray-200 dark:border-gray-700 text-gray-700 dark:text-gray-200 hover:border-sky-300 hover:shadow-sm' ?>"
               <?= $idx === 0 ? 'style="background:var(--primary)"' : '' ?>>
                <span class="text-xs font-medium <?= $idx === 0 ? 'text-sky-100' : 'text-gray-400 dark:text-gray-500' ?>">
                    <?= $day['label'] ?>
                </span>
                <span class="text-2xl font-bold leading-tight <?= $idx === 0 ? 'text-white' : '' ?>">
                    <?= $day['day_num'] ?>
                </span>
                <span class="mt-1 text-xs <?= $idx === 0 ? 'text-sky-200' : 'text-gray-400 dark:text-gray-500' ?>">
                    <?= $day['available'] ?> libre<?= $day['available'] !== 1 ? 's' : '' ?>
                </span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- RF2.4 – Sport Categories -->
    <div>
        <h2 class="jockey-one text-lg font-bold text-gray-900 dark:text-white mb-3">Deportes</h2>
        <div class="grid grid-cols-3 sm:grid-cols-6 gap-3">
            <?php
            $sports = [
                ['key'=>'football',   'label'=>'Fútbol',      'icon'=>'⚽', 'color'=>'from-green-400 to-emerald-500'],
                ['key'=>'padel',      'label'=>'Pádel',       'icon'=>'🎾', 'color'=>'from-sky-400 to-blue-500'],
                ['key'=>'tennis',     'label'=>'Tenis',       'icon'=>'🏸', 'color'=>'from-yellow-400 to-orange-400'],
                ['key'=>'basketball', 'label'=>'Basketball',  'icon'=>'🏀', 'color'=>'from-orange-400 to-red-400'],
                ['key'=>'swimming',   'label'=>'Natación',    'icon'=>'🏊', 'color'=>'from-cyan-400 to-teal-400'],
                ['key'=>'volleyball', 'label'=>'Voleibol',    'icon'=>'🏐', 'color'=>'from-violet-400 to-purple-500'],
            ];
            ?>
            <?php foreach ($sports as $sport): ?>
            <a href="<?= BASE_URL ?>reservations/search?sport=<?= $sport['key'] ?>"
               class="flex flex-col items-center gap-1.5 p-3 bg-white dark:bg-gray-800 rounded-2xl border border-gray-100 dark:border-gray-700 hover:shadow-md hover:-translate-y-0.5 transition-all group">
                <div class="w-12 h-12 rounded-xl bg-gradient-to-br <?= $sport['color'] ?> flex items-center justify-center text-2xl shadow-sm group-hover:scale-110 transition-transform">
                    <?= $sport['icon'] ?>
                </div>
                <span class="jockey-one text-xs font-medium text-gray-700 dark:text-gray-300 text-center leading-tight"><?= $sport['label'] ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- RF2.5 – Social Feed: Promotions -->
    <?php if (!empty($socialFeed)): ?>
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="jockey-one text-lg font-bold text-gray-900 dark:text-white">🎁 Ofertas para ti</h2>
        </div>
        <div class="flex gap-3 overflow-x-auto pb-2 -mx-1 px-1 scrollbar-hide">
            <?php foreach ($socialFeed as $promo): ?>
            <div class="flex-shrink-0 w-64 rounded-3xl overflow-hidden bg-gradient-to-br
                <?= $promo['type'] === 'coupon' ? 'from-violet-500 to-purple-700' : ($promo['type'] === 'news' ? 'from-emerald-500 to-teal-600' : 'from-sky-500 to-blue-700') ?>
                text-white shadow-lg relative">
                <div class="absolute inset-0 opacity-10">
                    <div class="absolute top-0 right-0 w-24 h-24 rounded-full bg-white -translate-y-6 translate-x-6"></div>
                </div>
                <div class="relative p-4">
                    <span class="inline-block bg-white/20 backdrop-blur-sm text-white text-xs font-semibold px-2.5 py-1 rounded-full mb-2">
                        <?= $promo['type'] === 'coupon' ? '🏷️ Cupón' : ($promo['type'] === 'news' ? '📰 Noticia' : '📢 Promo') ?>
                    </span>
                    <?php if (!empty($promo['club_name'])): ?>
                    <p class="text-white/70 text-xs font-medium"><?= htmlspecialchars($promo['club_name']) ?></p>
                    <?php endif; ?>
                    <h3 class="font-bold text-sm mt-1 leading-snug"><?= htmlspecialchars($promo['title']) ?></h3>
                    <?php if ($promo['discount_percent'] > 0): ?>
                    <p class="text-3xl font-black mt-2 leading-none"><?= (int)$promo['discount_percent'] ?>%<span class="text-base font-bold"> OFF</span></p>
                    <?php endif; ?>
                    <?php if (!empty($promo['coupon_code'])): ?>
                    <div class="mt-3 bg-white/20 border border-dashed border-white/40 rounded-xl px-3 py-2 text-center">
                        <code class="font-black tracking-widest text-sm"><?= htmlspecialchars($promo['coupon_code']) ?></code>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($promo['valid_until'])): ?>
                    <p class="text-white/60 text-xs mt-2">Hasta <?= date('d/m/Y', strtotime($promo['valid_until'])) ?></p>
                    <?php endif; ?>
                    <button onclick="applyCoupon('<?= htmlspecialchars($promo['coupon_code'] ?? '') ?>')"
                        class="mt-3 w-full bg-white/20 hover:bg-white/30 border border-white/30 text-white text-xs font-semibold py-2 rounded-xl transition-all">
                        Aplicar descuento →
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- RF2.6 – Nearby Clubs / Explorar Canchas -->
    <?php if (!empty($nearbyClubs)): ?>
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="jockey-one text-lg font-bold text-gray-900 dark:text-white">📍 Cerca de ti</h2>
            <button onclick="requestLocation()" class="text-xs text-sky-500 font-medium hover:text-sky-600 transition-colors flex items-center gap-1">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                    <line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/>
                    <line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/>
                </svg>
                Actualizar
            </button>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
            <?php foreach ($nearbyClubs as $club): ?>
            <a href="<?= BASE_URL ?>clubs/detail/<?= $club['id'] ?>"
               class="group relative rounded-3xl overflow-hidden bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 hover:shadow-lg transition-all">
                <!-- Glassmorphism card -->
                <div class="h-28 bg-gradient-to-br from-sky-400 via-sky-500 to-violet-600 flex items-center justify-center relative overflow-hidden">
                    <?php if (!empty($club['cover_image'])): ?>
                    <img src="<?= htmlspecialchars($club['cover_image']) ?>" class="absolute inset-0 w-full h-full object-cover" alt="">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 to-transparent"></div>
                    <?php else: ?>
                    <span class="text-5xl opacity-40">🏟️</span>
                    <?php endif; ?>
                    <?php if (!empty($club['distance_km'])): ?>
                    <span class="absolute top-2 right-2 bg-white/20 backdrop-blur-md text-white text-xs font-semibold px-2.5 py-1 rounded-full border border-white/20">
                        📍 <?= number_format($club['distance_km'], 1) ?> km
                    </span>
                    <?php endif; ?>
                </div>
                <div class="p-3">
                    <h3 class="jockey-one text-sm font-bold text-gray-900 dark:text-white leading-tight"><?= htmlspecialchars($club['name']) ?></h3>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 truncate">📍 <?= htmlspecialchars($club['city'] ?? 'Querétaro') ?></p>
                    <div class="flex items-center justify-between mt-2">
                        <span class="text-xs text-sky-600 dark:text-sky-400 font-medium">Ver canchas →</span>
                    </div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Active Reservations -->
    <?php if (!empty($activeReservations)): ?>
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="jockey-one text-lg font-bold text-gray-900 dark:text-white">📋 Mis Reservaciones</h2>
            <a href="<?= BASE_URL ?>reservations/history" class="text-xs text-sky-500 hover:text-sky-600 font-medium">Ver todas →</a>
        </div>
        <div class="space-y-2">
            <?php foreach (array_slice($activeReservations, 0, 3) as $res): ?>
            <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-2xl p-4 flex items-center gap-3 hover:shadow-sm transition-all">
                <div class="w-11 h-11 rounded-xl flex items-center justify-center text-2xl flex-shrink-0" style="background:rgba(var(--primary-rgb),0.1)">
                    <?= sportIcon($res['sport_type']) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 dark:text-white text-sm truncate"><?= htmlspecialchars($res['space_name']) ?></p>
                    <p class="text-xs text-gray-400 dark:text-gray-500"><?= htmlspecialchars($res['club_name']) ?></p>
                    <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5">
                        <?= date('d/m/Y', strtotime($res['date'])) ?> · <?= substr($res['start_time'], 0, 5) ?> - <?= substr($res['end_time'], 0, 5) ?>
                    </p>
                </div>
                <div class="text-right flex-shrink-0">
                    <p class="font-bold text-gray-900 dark:text-white text-sm">$<?= number_format($res['total'], 0) ?></p>
                    <span class="inline-block bg-green-100 dark:bg-green-900/30 text-green-700 dark:text-green-400 text-xs font-medium px-2 py-0.5 rounded-full mt-0.5">Activa</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <!-- Empty state CTA -->
    <div class="bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl p-8 text-center">
        <p class="text-5xl mb-3">🏟️</p>
        <h3 class="jockey-one text-lg font-bold text-gray-900 dark:text-white">¡Tu primera reserva!</h3>
        <p class="text-sm text-gray-500 dark:text-gray-400 mt-1 mb-4">Encuentra la cancha perfecta y empieza a jugar</p>
        <a href="<?= BASE_URL ?>reservations/search"
           class="inline-flex items-center gap-2 text-white font-bold px-6 py-3 rounded-2xl transition-all shadow-lg"
           style="background:var(--primary)">
            🔍 Buscar Canchas
        </a>
    </div>
    <?php endif; ?>

</div>

<!-- QR Modal (RF2.2) -->
<div id="qrModal" class="fixed inset-0 bg-black/70 z-50 hidden flex items-center justify-center p-4" onclick="closeQrModal()">
    <div class="bg-white dark:bg-gray-800 rounded-3xl p-6 max-w-xs w-full text-center relative shadow-2xl" onclick="event.stopPropagation()">
        <button onclick="closeQrModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 dark:hover:text-white">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
        <h3 class="jockey-one text-xl font-bold text-gray-900 dark:text-white mb-1">QR de Acceso</h3>
        <p id="qrSpaceName" class="text-xs text-gray-500 dark:text-gray-400 mb-4">—</p>
        <div id="qrcode" class="flex items-center justify-center mx-auto mb-4 bg-white p-3 rounded-2xl inline-block"></div>
        <p id="qrCodeText" class="text-xs font-mono text-gray-400 dark:text-gray-500 break-all"></p>
        <p class="text-xs text-gray-400 mt-3">Muestra este código en la entrada del club</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
// GPS for nearby clubs (RF2.6)
function requestLocation() {
    if (!navigator.geolocation) return;
    navigator.geolocation.getCurrentPosition(pos => {
        fetch('<?= BASE_URL ?>home/save-location', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: `lat=${pos.coords.latitude}&lng=${pos.coords.longitude}`
        }).then(() => window.location.reload());
    });
}

// Auto-request on first load (quietly)
if (!sessionStorage.getItem('ids_location_asked')) {
    sessionStorage.setItem('ids_location_asked', '1');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(pos => {
            fetch('<?= BASE_URL ?>home/save-location', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: `lat=${pos.coords.latitude}&lng=${pos.coords.longitude}`
            });
        }, () => {});
    }
}

// QR modal
function openQrModal(code, spaceName) {
    document.getElementById('qrSpaceName').textContent = spaceName;
    document.getElementById('qrCodeText').textContent = code;
    const canvas = document.getElementById('qrcode');
    canvas.innerHTML = '';
    QRCode.toCanvas ? null : null; // safety
    // Use QRCode library
    QRCode.toCanvas ? null : null;
    const c = document.createElement('canvas');
    canvas.appendChild(c);
    QRCode.toCanvas(c, code, {width: 200, margin: 1}, function(err){});
    document.getElementById('qrModal').classList.remove('hidden');
    // Maximize brightness
    if (screen.orientation && 'lock' in screen.orientation) {
        try { screen.orientation.lock('portrait'); } catch(e){}
    }
}
function closeQrModal() {
    document.getElementById('qrModal').classList.add('hidden');
}

// Apply coupon
function applyCoupon(code) {
    if (!code) return;
    sessionStorage.setItem('ids_coupon', code);
    window.location.href = '<?= BASE_URL ?>reservations/search';
}
</script>

