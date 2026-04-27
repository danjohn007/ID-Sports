<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">✨ Amenidades del Club</h2>
        <button onclick="document.getElementById('addAmenityModal').classList.remove('hidden')"
            class="bg-sky-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-sky-600 transition-all">+ Agregar</button>
    </div>

    <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
        <?php if (empty($amenities)): ?>
        <div class="col-span-4 bg-white rounded-2xl border border-gray-100 p-10 text-center">
            <p class="text-gray-400">Sin amenidades registradas</p>
        </div>
        <?php else: ?>
        <?php foreach ($amenities as $a): ?>
        <div class="bg-white border border-gray-100 rounded-2xl p-4 flex items-center justify-between">
            <p class="text-sm font-medium text-gray-800"><?= htmlspecialchars($a['name']) ?></p>
            <form method="POST" action="<?= BASE_URL ?>admin/deleteAmenity" onsubmit="return confirm('¿Eliminar?')">
                <input type="hidden" name="id" value="<?= $a['id'] ?>">
                <button type="submit" class="text-red-400 hover:text-red-600 text-sm">✕</button>
            </form>
        </div>
        <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div id="addAmenityModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-sm p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-900">Nueva Amenidad</h3>
            <button onclick="document.getElementById('addAmenityModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>admin/storeAmenity" class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" required placeholder="Ej: Estacionamiento, Regaderas, Cafetería..."
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addAmenityModal').classList.add('hidden')"
                    class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="flex-1 bg-sky-500 text-white font-semibold py-2.5 rounded-xl text-sm hover:bg-sky-600">Guardar</button>
            </div>
        </form>
    </div>
</div>
