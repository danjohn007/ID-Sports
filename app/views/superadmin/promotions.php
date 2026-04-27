<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">🎁 Promociones y Cupones</h2>
        <button onclick="document.getElementById('addPromoModal').classList.remove('hidden')"
            class="bg-violet-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-violet-600 transition-all">+ Nueva Promo</button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php if (empty($promotions)): ?>
        <div class="col-span-3 bg-white rounded-2xl border border-gray-100 p-12 text-center text-gray-400">Sin promociones</div>
        <?php else: ?>
        <?php foreach ($promotions as $p): ?>
        <div class="bg-white border border-gray-100 rounded-2xl p-5">
            <div class="flex justify-between items-start mb-2">
                <span class="bg-violet-100 text-violet-700 text-xs font-medium px-2.5 py-1 rounded-full">
                    <?= $p['type'] === 'coupon' ? '🏷️ Cupón' : '📢 Promo' ?>
                </span>
                <form method="POST" action="<?= BASE_URL ?>superadmin/deletePromotion" onsubmit="return confirm('¿Eliminar?')">
                    <input type="hidden" name="id" value="<?= $p['id'] ?>">
                    <button type="submit" class="text-red-400 hover:text-red-600 text-sm">✕</button>
                </form>
            </div>
            <h3 class="font-semibold text-gray-900 mt-2"><?= htmlspecialchars($p['title']) ?></h3>
            <p class="text-sm text-gray-500 mt-1"><?= htmlspecialchars($p['description']) ?></p>
            <?php if ($p['discount_percent']): ?>
            <p class="text-violet-600 font-bold text-xl mt-2"><?= $p['discount_percent'] ?>% OFF</p>
            <?php endif; ?>
            <?php if ($p['coupon_code']): ?>
            <div class="bg-violet-50 border border-dashed border-violet-200 rounded-lg px-3 py-2 text-center mt-2">
                <code class="text-violet-600 font-bold tracking-wider"><?= htmlspecialchars($p['coupon_code']) ?></code>
            </div>
            <?php endif; ?>
            <?php if ($p['valid_until']): ?>
            <p class="text-xs text-gray-400 mt-2">Expira: <?= date('d/m/Y', strtotime($p['valid_until'])) ?></p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<!-- Add Promo Modal -->
<div id="addPromoModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-900">Nueva Promoción</h3>
            <button onclick="document.getElementById('addPromoModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>superadmin/storePromotion" class="space-y-3">
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                    <select name="type" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="promotion">Promoción</option>
                        <option value="coupon">Cupón</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descuento %</label>
                    <input type="number" name="discount_percent" min="0" max="100" value="10"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Título *</label>
                <input type="text" name="title" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="2" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none"></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Código Cupón</label>
                <input type="text" name="coupon_code" placeholder="Ej: VERANO20"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 uppercase">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Válido desde</label>
                    <input type="date" name="valid_from" value="<?= date('Y-m-d') ?>"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Válido hasta</label>
                    <input type="date" name="valid_until"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addPromoModal').classList.add('hidden')"
                    class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="flex-1 bg-violet-500 text-white font-semibold py-2.5 rounded-xl text-sm hover:bg-violet-600">Guardar</button>
            </div>
        </form>
    </div>
</div>
