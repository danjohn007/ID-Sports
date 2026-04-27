<div class="space-y-6">
    <!-- Welcome banner -->
    <div class="bg-gradient-to-r from-sky-500 to-violet-600 rounded-3xl p-6 text-white">
        <h1 class="text-2xl font-bold">¡Hola, <?= htmlspecialchars($_SESSION['user_name'] ?? 'Usuario') ?>! 👋</h1>
        <p class="text-sky-100 mt-1">Bienvenido a ID Sports — tu plataforma de reservaciones deportivas</p>
        <a href="<?= BASE_URL ?>reservations/search" class="mt-4 inline-flex items-center gap-2 bg-white text-sky-600 font-semibold px-5 py-2.5 rounded-xl hover:bg-sky-50 transition-all text-sm">
            🔍 Buscar Canchas Disponibles
        </a>
    </div>

    <!-- Promotions -->
    <?php if (!empty($promotions)): ?>
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-3">🎁 Promociones Activas</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            <?php foreach ($promotions as $promo): ?>
            <div class="bg-gradient-to-br from-violet-50 to-sky-50 border border-violet-100 rounded-2xl p-4">
                <span class="inline-block bg-violet-100 text-violet-700 text-xs font-semibold px-2.5 py-1 rounded-full mb-2">
                    <?= $promo['type'] === 'coupon' ? '🏷️ Cupón' : '📢 Promoción' ?>
                </span>
                <h3 class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($promo['title']) ?></h3>
                <p class="text-xs text-gray-500 mt-1"><?= htmlspecialchars($promo['description']) ?></p>
                <?php if ($promo['discount_percent'] > 0): ?>
                <p class="text-violet-600 font-bold text-lg mt-2"><?= $promo['discount_percent'] ?>% OFF</p>
                <?php endif; ?>
                <?php if ($promo['coupon_code']): ?>
                <div class="mt-2 bg-white border border-dashed border-violet-300 rounded-lg px-3 py-1.5 text-center">
                    <code class="text-violet-600 font-bold tracking-wider text-sm"><?= htmlspecialchars($promo['coupon_code']) ?></code>
                </div>
                <?php endif; ?>
                <?php if ($promo['valid_until']): ?>
                <p class="text-xs text-gray-400 mt-2">Válido hasta: <?= date('d/m/Y', strtotime($promo['valid_until'])) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Quick actions -->
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-3">⚡ Acciones Rápidas</h2>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="<?= BASE_URL ?>reservations/search" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:border-sky-200 hover:shadow-md transition-all group">
                <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">⚽</div>
                <p class="text-sm font-medium text-gray-700">Fútbol</p>
            </a>
            <a href="<?= BASE_URL ?>reservations/search?sport=padel" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:border-sky-200 hover:shadow-md transition-all group">
                <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">🎾</div>
                <p class="text-sm font-medium text-gray-700">Pádel</p>
            </a>
            <a href="<?= BASE_URL ?>reservations/search?sport=tennis" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:border-sky-200 hover:shadow-md transition-all group">
                <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">🎾</div>
                <p class="text-sm font-medium text-gray-700">Tenis</p>
            </a>
            <a href="<?= BASE_URL ?>reservations/search?sport=basketball" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:border-sky-200 hover:shadow-md transition-all group">
                <div class="text-3xl mb-2 group-hover:scale-110 transition-transform">🏀</div>
                <p class="text-sm font-medium text-gray-700">Básquetbol</p>
            </a>
        </div>
    </div>

    <!-- Active reservations -->
    <div>
        <div class="flex items-center justify-between mb-3">
            <h2 class="text-lg font-semibold text-gray-900">📋 Mis Reservaciones Activas</h2>
            <a href="<?= BASE_URL ?>reservations/history" class="text-sm text-sky-500 hover:text-sky-600 font-medium">Ver todas →</a>
        </div>
        <?php if (empty($activeReservations)): ?>
        <div class="bg-white border border-gray-100 rounded-2xl p-8 text-center">
            <p class="text-4xl mb-3">📭</p>
            <p class="text-gray-500 font-medium">No tienes reservaciones activas</p>
            <a href="<?= BASE_URL ?>reservations/search" class="mt-4 inline-block bg-sky-500 text-white px-5 py-2 rounded-xl text-sm font-medium hover:bg-sky-600 transition-colors">
                Hacer una reservación
            </a>
        </div>
        <?php else: ?>
        <div class="space-y-3">
            <?php foreach ($activeReservations as $res): ?>
            <div class="bg-white border border-gray-100 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-sky-100 flex items-center justify-center text-2xl flex-shrink-0">
                    <?= $res['sport_type'] === 'football' ? '⚽' : ($res['sport_type'] === 'padel' ? '🎾' : '🏃') ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="font-semibold text-gray-900 text-sm truncate"><?= htmlspecialchars($res['space_name']) ?></p>
                    <p class="text-xs text-gray-500"><?= htmlspecialchars($res['club_name']) ?></p>
                    <p class="text-xs text-gray-400 mt-0.5">
                        📅 <?= date('d/m/Y', strtotime($res['date'])) ?> &nbsp; 🕐 <?= substr($res['start_time'], 0, 5) ?> - <?= substr($res['end_time'], 0, 5) ?>
                    </p>
                </div>
                <div class="text-right">
                    <p class="font-bold text-gray-900">$<?= number_format($res['total'], 2) ?></p>
                    <span class="inline-block bg-green-100 text-green-700 text-xs font-medium px-2 py-0.5 rounded-full">Activa</span>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <?php endif; ?>
    </div>
</div>
