<style>
/* Hide native scrollbars but keep scroll functionality */
.carousel-track::-webkit-scrollbar { display: none; }
.carousel-track { -ms-overflow-style: none; scrollbar-width: none; }

/* Carousel arrow buttons */
.carousel-btn {
    display: flex; align-items: center; justify-content: center;
    width: 2rem; height: 2rem; border-radius: 50%;
    background: #fff; border: 1px solid #e5e7eb;
    box-shadow: 0 1px 4px rgba(0,0,0,.08);
    cursor: pointer; flex-shrink: 0; transition: all .15s;
    font-size: 1rem; color: #374151;
}
.carousel-btn:hover { background: #0EA5E9; color: #fff; border-color: #0EA5E9; }

/* Reservation ticket hover */
.ticket-row { transition: box-shadow .2s, transform .2s; }
.ticket-row:hover { box-shadow: 0 4px 20px rgba(14,165,233,.15); transform: translateY(-1px); }
</style>

<div class="space-y-5">

    <!-- Welcome banner -->
    <div class="bg-gradient-to-r from-sky-500 to-violet-600 rounded-3xl p-6 text-white">
        <h1 class="text-2xl font-bold">¡Hola, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?>! 👋</h1>
        <p class="text-sky-100 mt-1 text-base">Bienvenido a ID Sports — tu plataforma de reservaciones deportivas</p>
        <a href="<?= BASE_URL ?>reservations/search" class="mt-4 inline-flex items-center gap-2 bg-white text-sky-600 font-semibold px-5 py-2.5 rounded-xl hover:bg-sky-50 transition-all">
            🔍 Buscar Canchas Disponibles
        </a>
    </div>

    <!-- Promotions -->
    <?php if (!empty($promotions)): ?>
    <div>
        <h2 class="text-xl font-bold text-gray-900 mb-3">🎁 Promociones Activas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($promotions as $promo): ?>
            <div class="bg-gradient-to-br from-violet-50 to-sky-50 border border-violet-100 rounded-2xl p-4">
                <span class="inline-block bg-violet-100 text-violet-700 text-sm font-semibold px-2.5 py-1 rounded-full mb-2">
                    <?= $promo['type'] === 'coupon' ? '🏷️ Cupón' : '📢 Promoción' ?>
                </span>
                <h3 class="font-bold text-gray-900"><?= htmlspecialchars($promo['title']) ?></h3>
                <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($promo['description']) ?></p>
                <?php if ($promo['discount_percent'] > 0): ?>
                <p class="text-violet-600 font-bold text-xl mt-2"><?= $promo['discount_percent'] ?>% OFF</p>
                <?php endif; ?>
                <?php if ($promo['coupon_code']): ?>
                <div class="mt-2 bg-white border border-dashed border-violet-300 rounded-lg px-3 py-1.5 text-center">
                    <code class="text-violet-600 font-bold tracking-wider"><?= htmlspecialchars($promo['coupon_code']) ?></code>
                </div>
                <?php endif; ?>
                <?php if ($promo['valid_until']): ?>
                <p class="text-sm text-gray-400 mt-2">Válido hasta: <?= date('d/m/Y', strtotime($promo['valid_until'])) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- ======================================================
         ROW 1: Dates (left) + Sports (right) — 50/50
         ====================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- LEFT: Date carousel -->
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <h2 class="text-xl font-bold text-gray-900 mb-4">🗓️ Anticipa tu jugada</h2>
            <div class="flex items-center gap-2">
                <button class="carousel-btn" onclick="scrollCarousel('days-track', -1)" aria-label="Anterior">‹</button>
                <div id="days-track" class="carousel-track flex gap-3 overflow-x-auto flex-1 py-1">
                    <?php foreach ($days as $d): ?>
                    <a href="<?= BASE_URL ?>reservations/search?date=<?= $d['date'] ?>"
                       class="carousel-item flex-shrink-0 flex flex-col items-center justify-center rounded-2xl border-2 w-20 h-24 transition-all
                              <?= $d['is_today'] ? 'border-sky-500 bg-sky-500 text-white shadow-md' : 'border-gray-200 bg-gray-50 hover:border-sky-400 hover:bg-sky-50 text-gray-700' ?>">
                        <span class="text-xs font-semibold uppercase tracking-wide <?= $d['is_today'] ? 'text-sky-100' : 'text-gray-400' ?>"><?= $d['day_name'] ?></span>
                        <span class="text-3xl font-bold leading-none mt-1"><?= $d['day_num'] ?></span>
                        <span class="text-xs mt-1 <?= $d['is_today'] ? 'text-sky-100' : 'text-gray-400' ?>"><?= $d['month'] ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn" onclick="scrollCarousel('days-track', 1)" aria-label="Siguiente">›</button>
            </div>
        </div>

        <!-- RIGHT: Sports carousel -->
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <h2 class="text-xl font-bold text-gray-900 mb-4">🏅 Deportes</h2>
            <div class="flex items-center gap-2">
                <button class="carousel-btn" onclick="scrollCarousel('sports-track', -1)" aria-label="Anterior">‹</button>
                <div id="sports-track" class="carousel-track flex gap-3 overflow-x-auto flex-1 py-1">
                    <?php foreach ($sports as $sport): ?>
                    <a href="<?= BASE_URL ?>reservations/search?sport=<?= urlencode($sport['sport']) ?>"
                       class="carousel-item flex-shrink-0 flex flex-col items-center justify-center rounded-2xl border-2 border-gray-200 bg-gray-50
                              hover:border-sky-400 hover:bg-sky-50 transition-all w-24 h-24 group">
                        <span class="text-4xl group-hover:scale-110 transition-transform"><?= $sport['icon'] ?></span>
                        <span class="text-sm font-semibold text-gray-700 mt-2 text-center leading-tight"><?= $sport['name'] ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn" onclick="scrollCarousel('sports-track', 1)" aria-label="Siguiente">›</button>
            </div>
        </div>

    </div><!-- /ROW 1 -->

    <!-- ======================================================
         ROW 2: Followed Clubs (left) + Nearby (right) — 50/50
         ====================================================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">

        <!-- LEFT: Clubes seguidos -->
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">🏟️ Clubes seguidos</h2>
                <a href="<?= BASE_URL ?>clubs" class="text-sm text-sky-500 hover:text-sky-600 font-medium">Ver todos →</a>
            </div>
            <?php if (empty($followedClubs)): ?>
            <p class="text-gray-400 text-sm py-4 text-center">No hay clubes disponibles aún.</p>
            <?php else: ?>
            <div class="flex items-center gap-2">
                <button class="carousel-btn" onclick="scrollCarousel('clubs-track', -1)" aria-label="Anterior">‹</button>
                <div id="clubs-track" class="carousel-track flex gap-3 overflow-x-auto flex-1 py-1">
                    <?php foreach ($followedClubs as $club): ?>
                    <a href="<?= BASE_URL ?>clubs/detail/<?= $club['id'] ?>"
                       class="carousel-item flex-shrink-0 w-44 rounded-2xl border border-gray-200 overflow-hidden hover:shadow-md hover:border-sky-300 transition-all group block">
                        <div class="h-24 bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center">
                            <span class="text-4xl">🏟️</span>
                        </div>
                        <div class="p-3">
                            <p class="font-bold text-gray-900 text-sm truncate group-hover:text-sky-600 transition-colors"><?= htmlspecialchars($club['name']) ?></p>
                            <p class="text-xs text-gray-400 mt-0.5 truncate">📍 <?= htmlspecialchars($club['address'] ?? 'Querétaro') ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn" onclick="scrollCarousel('clubs-track', 1)" aria-label="Siguiente">›</button>
            </div>
            <?php endif; ?>
        </div>

        <!-- RIGHT: Cerca de ti -->
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-xl font-bold text-gray-900">📍 Cerca de ti</h2>
                <a href="<?= BASE_URL ?>clubs" class="text-sm text-sky-500 hover:text-sky-600 font-medium">Explorar →</a>
            </div>
            <?php if (empty($nearbyClubs)): ?>
            <p class="text-gray-400 text-sm py-4 text-center">No hay lugares cercanos disponibles.</p>
            <?php else: ?>
            <div class="flex items-center gap-2">
                <button class="carousel-btn" onclick="scrollCarousel('nearby-track', -1)" aria-label="Anterior">‹</button>
                <div id="nearby-track" class="carousel-track flex gap-3 overflow-x-auto flex-1 py-1">
                    <?php foreach ($nearbyClubs as $club): ?>
                    <a href="<?= BASE_URL ?>clubs/detail/<?= $club['id'] ?>"
                       class="carousel-item flex-shrink-0 w-44 rounded-2xl border border-gray-200 overflow-hidden hover:shadow-md hover:border-violet-300 transition-all group block">
                        <div class="h-24 bg-gradient-to-br from-violet-400 to-sky-500 flex items-center justify-center">
                            <span class="text-4xl">🏋️</span>
                        </div>
                        <div class="p-3">
                            <p class="font-bold text-gray-900 text-sm truncate group-hover:text-violet-600 transition-colors"><?= htmlspecialchars($club['name']) ?></p>
                            <p class="text-xs text-gray-400 mt-0.5 truncate">📍 <?= htmlspecialchars($club['address'] ?? 'Querétaro') ?></p>
                        </div>
                    </a>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn" onclick="scrollCarousel('nearby-track', 1)" aria-label="Siguiente">›</button>
            </div>
            <?php endif; ?>
        </div>

    </div><!-- /ROW 2 -->

    <!-- ======================================================
         ROW 3: Mis Reservaciones — full width, ticket design
         ====================================================== -->
    <div>
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-2xl font-bold text-gray-900">🎟️ Mis Reservaciones</h2>
            <a href="<?= BASE_URL ?>reservations/history" class="text-sm text-sky-500 hover:text-sky-600 font-medium">Ver todas →</a>
        </div>

        <?php if (empty($activeReservations)): ?>
        <div class="bg-white border border-gray-100 rounded-2xl p-10 text-center">
            <p class="text-5xl mb-4">📭</p>
            <p class="text-gray-500 font-semibold text-lg">No tienes reservaciones activas</p>
            <p class="text-gray-400 text-sm mt-1 mb-5">¡Reserva una cancha y empieza a jugar!</p>
            <a href="<?= BASE_URL ?>reservations/search" class="inline-flex items-center gap-2 bg-sky-500 text-white px-6 py-3 rounded-xl font-semibold hover:bg-sky-600 transition-colors">
                🔍 Buscar canchas disponibles
            </a>
        </div>
        <?php else: ?>
        <div class="space-y-4">
            <?php
            $sportIcons = [
                'football'   => '⚽',
                'padel'      => '🎾',
                'tennis'     => '🎾',
                'basketball' => '🏀',
                'volleyball' => '🏐',
                'running'    => '🏃',
            ];
            $statusLabels = [
                'active'    => ['label' => 'Confirmada', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                'confirmed' => ['label' => 'Confirmada', 'bg' => 'bg-green-100', 'text' => 'text-green-700'],
                'pending'   => ['label' => 'Pendiente',  'bg' => 'bg-yellow-100','text' => 'text-yellow-700'],
                'cancelled' => ['label' => 'Cancelada',  'bg' => 'bg-red-100',   'text' => 'text-red-700'],
                'completed' => ['label' => 'Completada', 'bg' => 'bg-gray-100',  'text' => 'text-gray-600'],
            ];
            foreach ($activeReservations as $res):
                $icon   = $sportIcons[$res['sport_type']] ?? '🏃';
                $status = $res['status'] ?? 'active';
                $badge  = $statusLabels[$status] ?? $statusLabels['active'];
            ?>
            <div class="ticket-row bg-white border border-gray-100 rounded-2xl p-5 flex items-center gap-5 cursor-pointer"
                 onclick="window.location='<?= BASE_URL ?>reservations/history'">

                <!-- Sport icon -->
                <div class="w-16 h-16 rounded-2xl bg-sky-100 flex items-center justify-center text-4xl flex-shrink-0">
                    <?= $icon ?>
                </div>

                <!-- Main info -->
                <div class="flex-1 min-w-0">
                    <p class="font-bold text-gray-900 text-lg leading-tight truncate"><?= htmlspecialchars($res['space_name']) ?></p>
                    <p class="text-base text-gray-500 mt-0.5"><?= htmlspecialchars($res['club_name']) ?></p>
                    <div class="flex items-center gap-4 mt-2 text-sm text-gray-500">
                        <span>📅 <?= date('d/m/Y', strtotime($res['date'])) ?></span>
                        <span>🕐 <?= substr($res['start_time'], 0, 5) ?> – <?= substr($res['end_time'], 0, 5) ?></span>
                    </div>
                </div>

                <!-- Price + status -->
                <div class="text-right flex-shrink-0 flex flex-col items-end gap-2">
                    <p class="text-2xl font-bold text-gray-900">$<?= number_format($res['total'], 2) ?></p>
                    <span class="inline-block <?= $badge['bg'] ?> <?= $badge['text'] ?> text-sm font-semibold px-3 py-1 rounded-full">
                        <?= $badge['label'] ?>
                    </span>
                </div>

            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div><!-- /ROW 3 -->

</div><!-- /space-y-5 -->

<script>
function scrollCarousel(trackId, direction) {
    const track = document.getElementById(trackId);
    if (!track) return;
    const item = track.querySelector('.carousel-item');
    const cardWidth = item ? item.offsetWidth + 12 : 200;
    track.scrollBy({ left: direction * cardWidth * 2, behavior: 'smooth' });
}
</script>
