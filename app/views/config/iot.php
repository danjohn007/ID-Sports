<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">🔌 Dispositivos IoT</h2>
        <button onclick="document.getElementById('addIotModal').classList.remove('hidden')"
            class="bg-sky-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-sky-600 transition-all">+ Agregar</button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <?php if (empty($devices)): ?>
        <div class="p-12 text-center text-gray-400">Sin dispositivos registrados</div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Nombre</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Tipo</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">IP / URL</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Club</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($devices as $d): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium"><?= htmlspecialchars($d['name']) ?></td>
                    <td class="px-4 py-3">
                        <span class="bg-gray-100 text-gray-700 text-xs px-2 py-1 rounded-full"><?= htmlspecialchars($d['device_type']) ?></span>
                    </td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-600"><?= htmlspecialchars($d['ip_address'] ?? $d['api_url'] ?? '-') ?></td>
                    <td class="px-4 py-3"><?= htmlspecialchars($d['club_name'] ?? '-') ?></td>
                    <td class="px-4 py-3">
                        <span class="w-2 h-2 rounded-full inline-block mr-1 <?= $d['status'] === 'online' ? 'bg-green-400' : 'bg-gray-300' ?>"></span>
                        <?= $d['status'] === 'online' ? 'Online' : 'Offline' ?>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="<?= BASE_URL ?>config/deleteIot" onsubmit="return confirm('¿Eliminar dispositivo?')">
                            <input type="hidden" name="id" value="<?= $d['id'] ?>">
                            <button type="submit" class="text-red-400 hover:text-red-600 text-xs">✕</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<div id="addIotModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold">Agregar Dispositivo IoT</h3>
            <button onclick="document.getElementById('addIotModal').classList.add('hidden')" class="text-gray-400">✕</button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>config/storeIot" class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre</label>
                <input type="text" name="name" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <select name="device_type" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="hikvision">HikVision</option>
                    <option value="shelly">Shelly</option>
                    <option value="generic">Genérico</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">IP / URL API</label>
                <input type="text" name="ip_address" placeholder="192.168.1.100" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Usuario</label>
                    <input type="text" name="username" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Contraseña</label>
                    <input type="password" name="password" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Club</label>
                <select name="club_id" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">Sin asignar</option>
                    <?php foreach ($clubs ?? [] as $c): ?>
                    <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addIotModal').classList.add('hidden')"
                    class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="flex-1 bg-sky-500 text-white font-semibold py-2.5 rounded-xl text-sm hover:bg-sky-600">Guardar</button>
            </div>
        </form>
    </div>
</div>
