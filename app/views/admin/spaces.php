<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">🏃 Espacios del Club</h2>
        <button onclick="document.getElementById('addSpaceModal').classList.remove('hidden')"
            class="bg-sky-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-sky-600 transition-all">+ Agregar Espacio</button>
    </div>

    <?php if (empty($spaces)): ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
        <p class="text-5xl mb-4">🏟️</p>
        <p class="text-gray-500">Sin espacios registrados</p>
    </div>
    <?php else: ?>
    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Nombre</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Deporte</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Precio/hr</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($spaces as $s): ?>
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-4 py-3 font-medium"><?= htmlspecialchars($s['name']) ?></td>
                    <td class="px-4 py-3 capitalize text-gray-600"><?= htmlspecialchars($s['sport_type']) ?></td>
                    <td class="px-4 py-3 text-right font-medium text-sky-600">$<?= number_format($s['price_per_hour'], 2) ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2.5 py-1 rounded-full text-xs font-medium <?= $s['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' ?>">
                            <?= $s['status'] === 'active' ? 'Activo' : 'Inactivo' ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="<?= BASE_URL ?>admin/schedules/<?= $s['id'] ?>" class="text-violet-500 hover:underline text-xs mr-3">Horarios</a>
                        <a href="<?= BASE_URL ?>admin/editSpace/<?= $s['id'] ?>" class="text-sky-500 hover:underline text-xs">Editar</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php endif; ?>
</div>

<!-- Add Space Modal -->
<div id="addSpaceModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-900">Agregar Espacio</h3>
            <button onclick="document.getElementById('addSpaceModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>admin/storeSpace" class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre *</label>
                <input type="text" name="name" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deporte</label>
                    <select name="sport_type" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <?php
                        try {
                            $__sportTypes = (new SportTypeModel())->getAll();
                        } catch (Exception $__e) {
                            $__sportTypes = [
                                ['slug'=>'football','name'=>'Fútbol'],
                                ['slug'=>'padel','name'=>'Pádel'],
                                ['slug'=>'tennis','name'=>'Tenis'],
                                ['slug'=>'basketball','name'=>'Basketball'],
                                ['slug'=>'volleyball','name'=>'Voleibol'],
                                ['slug'=>'swimming','name'=>'Natación'],
                                ['slug'=>'other','name'=>'Otro'],
                            ];
                        }
                        foreach ($__sportTypes as $__st):
                        ?>
                        <option value="<?= htmlspecialchars($__st['slug']) ?>"><?= htmlspecialchars($__st['name']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio/hr *</label>
                    <input type="number" name="price_per_hour" required step="0.01" min="0"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Capacidad (personas)</label>
                    <input type="number" name="capacity" min="1" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Estado</label>
                    <select name="status" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <option value="active">Activo</option>
                        <option value="inactive">Inactivo</option>
                    </select>
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                <textarea name="description" rows="2" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none"></textarea>
            </div>
            <div class="flex gap-3 pt-2">
                <button type="button" onclick="document.getElementById('addSpaceModal').classList.add('hidden')"
                    class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm hover:bg-gray-50 transition-all">Cancelar</button>
                <button type="submit" class="flex-1 bg-sky-500 text-white font-semibold py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">Guardar</button>
            </div>
        </form>
    </div>
</div>
