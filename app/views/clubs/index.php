<div class="space-y-6">
    <div class="flex items-center justify-between">
        <h2 class="text-xl font-bold text-gray-900">🏟️ Clubes Deportivos en Querétaro</h2>
    </div>

    <!-- Search bar -->
    <form method="GET" class="bg-white rounded-2xl border border-gray-100 p-4 flex gap-3">
        <input type="text" name="q" value="<?= htmlspecialchars($q ?? '') ?>" placeholder="Buscar club por nombre o colonia..."
            class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
        <button type="submit" class="bg-sky-500 text-white px-5 py-2.5 rounded-xl text-sm font-semibold hover:bg-sky-600 transition-all">
            Buscar
        </button>
    </form>

    <?php if (empty($clubs)): ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
        <p class="text-5xl mb-4">🏟️</p>
        <p class="text-gray-600 font-medium">No se encontraron clubes</p>
    </div>
    <?php else: ?>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">
        <?php foreach ($clubs as $club): ?>
        <a href="<?= BASE_URL ?>clubs/detail/<?= $club['id'] ?>" class="bg-white border border-gray-100 rounded-2xl overflow-hidden hover:shadow-md transition-all group block">
            <div class="h-36 bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center">
                <span class="text-5xl">🏟️</span>
            </div>
            <div class="p-4">
                <h3 class="font-semibold text-gray-900 group-hover:text-sky-500 transition-colors"><?= htmlspecialchars($club['name']) ?></h3>
                <p class="text-xs text-gray-500 mt-0.5">📍 <?= htmlspecialchars($club['address'] ?? 'Querétaro, Qro.') ?></p>
                <?php if (!empty($club['description'])): ?>
                <p class="text-sm text-gray-600 mt-2 line-clamp-2"><?= htmlspecialchars($club['description']) ?></p>
                <?php endif; ?>
                <div class="flex items-center justify-between mt-3">
                    <?php if ($club['space_count'] ?? 0): ?>
                    <span class="text-xs text-gray-400"><?= $club['space_count'] ?> espacio(s)</span>
                    <?php endif; ?>
                    <span class="text-sky-500 text-sm font-medium">Ver más →</span>
                </div>
            </div>
        </a>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
