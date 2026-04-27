<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">📋 Bitácora de Acciones</h2>
        <form method="POST" action="<?= BASE_URL ?>config/clearLogs" onsubmit="return confirm('¿Limpiar bitácora?')">
            <button type="submit" class="text-red-500 text-sm hover:underline">Limpiar todo</button>
        </form>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <?php if (empty($logs)): ?>
        <div class="p-12 text-center text-gray-400">Sin registros</div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Fecha</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Usuario</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Acción</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">IP</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($logs as $log): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-gray-500 whitespace-nowrap"><?= date('d/m/Y H:i', strtotime($log['created_at'])) ?></td>
                    <td class="px-4 py-3"><?= htmlspecialchars($log['user_name'] ?? 'Sistema') ?></td>
                    <td class="px-4 py-3"><?= htmlspecialchars($log['action']) ?></td>
                    <td class="px-4 py-3 font-mono text-xs text-gray-400"><?= htmlspecialchars($log['ip_address'] ?? '') ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
