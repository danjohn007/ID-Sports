<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">🏟️ Gestión de Clubes</h2>
        <button onclick="document.getElementById('addClubModal').classList.remove('hidden')"
            class="bg-sky-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-sky-600 transition-all">+ Nuevo Club</button>
    </div>

    <!-- Filter tabs -->
    <div class="flex gap-2">
        <?php foreach (['all' => 'Todos', 'pending' => 'Pendientes', 'active' => 'Activos', 'suspended' => 'Suspendidos'] as $val => $label): ?>
        <a href="?status=<?= $val ?>"
            class="px-4 py-2 rounded-xl text-sm font-medium transition-all <?= ($statusFilter ?? 'all') === $val ? 'bg-sky-500 text-white' : 'bg-white border border-gray-200 text-gray-600 hover:border-sky-300' ?>">
            <?= $label ?>
        </a>
        <?php endforeach; ?>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <?php if (empty($clubs)): ?>
        <div class="p-12 text-center text-gray-400">Sin clubes</div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Club</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Propietario</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Registro</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($clubs as $c):
                $statusColor = $c['status'] === 'active' ? 'bg-green-100 text-green-700' : ($c['status'] === 'pending' ? 'bg-amber-100 text-amber-700' : 'bg-red-100 text-red-700');
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <p class="font-medium"><?= htmlspecialchars($c['name']) ?></p>
                        <p class="text-xs text-gray-400">📍 <?= htmlspecialchars(substr($c['address'] ?? '', 0, 40)) ?></p>
                    </td>
                    <td class="px-4 py-3">
                        <p><?= htmlspecialchars($c['owner_name'] ?? '-') ?></p>
                        <p class="text-xs text-gray-400"><?= htmlspecialchars($c['owner_email'] ?? '') ?></p>
                    </td>
                    <td class="px-4 py-3 text-gray-500"><?= date('d/m/Y', strtotime($c['created_at'])) ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium <?= $statusColor ?>">
                            <?= ucfirst($c['status']) ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <?php if ($c['status'] === 'pending'): ?>
                        <form method="POST" action="<?= BASE_URL ?>superadmin/approveClub" class="inline">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <button type="submit" class="text-green-600 hover:underline text-xs mr-2">Aprobar</button>
                        </form>
                        <?php elseif ($c['status'] === 'active'): ?>
                        <form method="POST" action="<?= BASE_URL ?>superadmin/suspendClub" class="inline">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <button type="submit" class="text-red-500 hover:underline text-xs mr-2">Suspender</button>
                        </form>
                        <?php else: ?>
                        <form method="POST" action="<?= BASE_URL ?>superadmin/approveClub" class="inline">
                            <input type="hidden" name="id" value="<?= $c['id'] ?>">
                            <button type="submit" class="text-green-600 hover:underline text-xs mr-2">Reactivar</button>
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

<!-- Add Club Modal -->
<div id="addClubModal" class="hidden fixed inset-0 bg-black/50 z-50 flex items-center justify-center p-4">
    <div class="bg-white rounded-2xl w-full max-w-md p-6 max-h-[90vh] overflow-y-auto">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-900">Nuevo Club</h3>
            <button onclick="document.getElementById('addClubModal').classList.add('hidden')" class="text-gray-400 hover:text-gray-600">✕</button>
        </div>
        <form method="POST" action="<?= BASE_URL ?>superadmin/storeClub" class="space-y-3">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Nombre del Club *</label>
                <input type="text" name="name" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Email del Admin *</label>
                <input type="email" name="owner_email" required class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Dirección</label>
                <input type="text" name="address" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">WhatsApp</label>
                <input type="tel" name="whatsapp" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Comisión (%)</label>
                <input type="number" name="commission_pct" value="10" min="0" max="100" step="0.5"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div class="flex gap-3">
                <button type="button" onclick="document.getElementById('addClubModal').classList.add('hidden')"
                    class="flex-1 border border-gray-200 text-gray-600 py-2.5 rounded-xl text-sm hover:bg-gray-50">Cancelar</button>
                <button type="submit" class="flex-1 bg-sky-500 text-white font-semibold py-2.5 rounded-xl text-sm hover:bg-sky-600">Crear Club</button>
            </div>
        </form>
    </div>
</div>
