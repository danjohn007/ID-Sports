<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">⚠️ Incidencias</h2>
        <button onclick="document.getElementById('addIncidentModal').classList.remove('hidden')"
            class="bg-amber-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-amber-600 transition-all">+ Reportar</button>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <?php if (empty($incidents)): ?>
        <div class="p-12 text-center text-gray-400">Sin incidencias reportadas</div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Descripción</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Espacio</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Fecha</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($incidents as $inc): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 max-w-xs">
                        <p class="font-medium"><?= htmlspecialchars(substr($inc['description'], 0, 60)) ?><?= strlen($inc['description']) > 60 ? '...' : '' ?></p>
                        <?php if ($inc['type']): ?>
                        <p class="text-xs text-gray-400 capitalize"><?= htmlspecialchars($inc['type']) ?></p>
                        <?php endif; ?>
                    </td>
                    <td class="px-4 py-3"><?= htmlspecialchars($inc['space_name'] ?? 'N/A') ?></td>
                    <td class="px-4 py-3 text-gray-500"><?= date('d/m/Y', strtotime($inc['created_at'])) ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium <?= $inc['status'] === 'open' ? 'bg-red-100 text-red-700' : ($inc['status'] === 'in_progress' ? 'bg-amber-100 text-amber-700' : 'bg-green-100 text-green-700') ?>">
                            <?= $inc['status'] === 'open' ? 'Abierta' : ($inc['status'] === 'in_progress' ? 'En proceso' : 'Resuelta') ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <?php if ($inc['status'] !== 'resolved'): ?>
                        <form method="POST" action="<?= BASE_URL ?>admin/resolveIncident" class="inline">
                            <input type="hidden" name="id" value="<?= $inc['id'] ?>">
                            <button type="submit" class="text-green-600 hover:underline text-xs">Resolver</button>
                        </form>
                        <?php endif; ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>

<div id="addIncidentModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-900">Reportar Incidencia</h3>
            <button onclick="document.getElementById('addIncidentModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>admin/storeIncident" class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Espacio</label>
                <select name="space_id" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="">General</option>
                    <?php foreach ($spaces ?? [] as $sp): ?>
                    <option value="<?= $sp['id'] ?>"><?= htmlspecialchars($sp['name']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Tipo</label>
                <select name="type" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="maintenance">Mantenimiento</option>
                    <option value="security">Seguridad</option>
                    <option value="complaint">Queja</option>
                    <option value="other">Otro</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Descripción *</label>
                <textarea name="description" required rows="3" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none"></textarea>
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addIncidentModal').classList.add('hidden')"
                    class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="flex-1 bg-amber-500 text-white font-semibold py-2.5 rounded-xl text-sm hover:bg-amber-600">Reportar</button>
            </div>
        </form>
    </div>
</div>
