<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <div class="h-48 bg-gradient-to-br from-sky-400 to-violet-600 flex items-center justify-center">
            <span class="text-8xl">🏟️</span>
        </div>
        <div class="p-6">
            <h1 class="text-2xl font-bold text-gray-900"><?= htmlspecialchars($club['name']) ?></h1>
            <p class="text-gray-500 mt-1">📍 <?= htmlspecialchars($club['address'] ?? 'Querétaro, Qro.') ?></p>
            <?php if (!empty($club['whatsapp'])): ?>
            <a href="https://wa.me/<?= preg_replace('/\D/', '', $club['whatsapp']) ?>" target="_blank"
                class="inline-flex items-center gap-2 mt-3 bg-green-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-green-600 transition-all">
                💬 WhatsApp
            </a>
            <?php endif; ?>
        </div>
    </div>

    <!-- Spaces -->
    <?php if (!empty($spaces)): ?>
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-3">🏃 Espacios Disponibles</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <?php foreach ($spaces as $s): ?>
            <div class="bg-white border border-gray-100 rounded-2xl p-4 flex items-center gap-4">
                <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center text-2xl flex-shrink-0">
                    <?= $s['sport_type'] === 'football' ? '⚽' : ($s['sport_type'] === 'padel' ? '🎾' : '🏃') ?>
                </div>
                <div class="flex-1">
                    <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($s['name']) ?></p>
                    <p class="text-sky-600 font-bold">$<?= number_format($s['price_per_hour'], 2) ?>/hr</p>
                </div>
                <a href="<?= BASE_URL ?>reservations/create/<?= $s['id'] ?>"
                    class="bg-sky-500 text-white text-xs font-semibold px-3 py-2 rounded-xl hover:bg-sky-600 transition-all">
                    Reservar
                </a>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Amenities -->
    <?php if (!empty($amenities)): ?>
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-3">✨ Amenidades</h2>
        <div class="flex flex-wrap gap-2">
            <?php foreach ($amenities as $a): ?>
            <span class="bg-violet-50 border border-violet-100 text-violet-700 text-sm px-3 py-1.5 rounded-full">
                <?= htmlspecialchars($a['name']) ?>
            </span>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Reviews -->
    <?php if (!empty($reviews)): ?>
    <div>
        <h2 class="text-lg font-semibold text-gray-900 mb-3">⭐ Reseñas</h2>
        <div class="space-y-3">
            <?php foreach ($reviews as $rev): ?>
            <div class="bg-white border border-gray-100 rounded-2xl p-4">
                <div class="flex items-center gap-2 mb-1">
                    <div class="w-8 h-8 rounded-full bg-sky-100 flex items-center justify-center text-sm font-bold text-sky-600">
                        <?= strtoupper(substr($rev['user_name'], 0, 1)) ?>
                    </div>
                    <p class="font-medium text-sm text-gray-900"><?= htmlspecialchars($rev['user_name']) ?></p>
                    <div class="ml-auto text-yellow-400 text-sm">
                        <?= str_repeat('★', (int)$rev['rating']) ?><?= str_repeat('☆', 5 - (int)$rev['rating']) ?>
                    </div>
                </div>
                <?php if ($rev['comment']): ?>
                <p class="text-sm text-gray-600 pl-10"><?= htmlspecialchars($rev['comment']) ?></p>
                <?php endif; ?>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>
</div>
