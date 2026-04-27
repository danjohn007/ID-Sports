<div class="space-y-6">
    <!-- Filters -->
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h2 class="font-semibold text-gray-900 mb-4">🔍 Buscar Espacios Deportivos</h2>
        <form method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Deporte</label>
                <select name="sport" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">Todos</option>
                    <option value="football" <?= ($sport ?? '') === 'football' ? 'selected' : '' ?>>⚽ Fútbol</option>
                    <option value="padel" <?= ($sport ?? '') === 'padel' ? 'selected' : '' ?>>🎾 Pádel</option>
                    <option value="tennis" <?= ($sport ?? '') === 'tennis' ? 'selected' : '' ?>>🎾 Tenis</option>
                    <option value="basketball" <?= ($sport ?? '') === 'basketball' ? 'selected' : '' ?>>🏀 Básquetbol</option>
                    <option value="volleyball" <?= ($sport ?? '') === 'volleyball' ? 'selected' : '' ?>>🏐 Voleibol</option>
                    <option value="swimming" <?= ($sport ?? '') === 'swimming' ? 'selected' : '' ?>>🏊 Natación</option>
                </select>
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Fecha</label>
                <input type="date" name="date" value="<?= htmlspecialchars($date ?? '') ?>" min="<?= date('Y-m-d') ?>"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-xs font-medium text-gray-600 mb-1">Hora</label>
                <input type="time" name="time" value="<?= htmlspecialchars($time ?? '') ?>"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div class="flex items-end">
                <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold px-4 py-2.5 rounded-xl text-sm transition-all">
                    Buscar
                </button>
            </div>
        </form>
    </div>

    <!-- Results -->
    <?php if (!empty($spaces)): ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($spaces as $space): ?>
        <div class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-md transition-all group">
            <div class="h-40 bg-gradient-to-br from-sky-100 to-violet-100 flex items-center justify-center text-6xl">
                <?= $space['sport_type'] === 'football' ? '⚽' : ($space['sport_type'] === 'padel' ? '🎾' : ($space['sport_type'] === 'basketball' ? '🏀' : '🏃')) ?>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900"><?= htmlspecialchars($space['name']) ?></h3>
                <p class="text-sm text-gray-500 mt-0.5"><?= htmlspecialchars($space['club_name']) ?></p>
                <p class="text-xs text-gray-400">📍 <?= htmlspecialchars($space['address'] ?? 'Querétaro, Qro.') ?></p>

                <?php if ($space['avg_rating'] > 0): ?>
                <div class="flex items-center gap-1 mt-2">
                    <span class="text-yellow-400">★</span>
                    <span class="text-sm font-medium"><?= number_format($space['avg_rating'], 1) ?></span>
                    <span class="text-xs text-gray-400">(<?= $space['review_count'] ?? 0 ?> reseñas)</span>
                </div>
                <?php endif; ?>

                <div class="flex items-center justify-between mt-3">
                    <div>
                        <span class="text-xs text-gray-500">Desde</span>
                        <p class="text-sky-600 font-bold">$<?= number_format($space['price_per_hour'], 2) ?>/hr</p>
                    </div>
                    <a href="<?= BASE_URL ?>reservations/create/<?= $space['id'] ?>?date=<?= urlencode($date ?? '') ?>&time=<?= urlencode($time ?? '') ?>"
                        class="bg-sky-500 hover:bg-sky-600 text-white text-sm font-semibold px-4 py-2 rounded-xl transition-all">
                        Reservar
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php elseif (isset($sport) || isset($date)): ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
        <p class="text-5xl mb-4">🏟️</p>
        <h3 class="text-lg font-semibold text-gray-700">Sin resultados</h3>
        <p class="text-gray-500 text-sm mt-1">Prueba con otros filtros o fechas</p>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
        <p class="text-5xl mb-4">🔍</p>
        <h3 class="text-lg font-semibold text-gray-700">Usa los filtros para buscar</h3>
        <p class="text-gray-500 text-sm mt-1">Selecciona deporte, fecha y hora para ver disponibilidad</p>
    </div>
    <?php endif; ?>
</div>
