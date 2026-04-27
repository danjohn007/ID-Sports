<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">📋 Reservaciones del Club</h2>
    </div>

    <!-- Filter -->
    <form method="GET" class="bg-white rounded-2xl border border-gray-100 p-4 flex flex-wrap gap-3 items-end">
        <div>
            <label class="block text-xs text-gray-600 mb-1">Fecha desde</label>
            <input type="date" name="date_from" value="<?= htmlspecialchars($_GET['date_from'] ?? date('Y-m-01')) ?>"
                class="px-3 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
        </div>
        <div>
            <label class="block text-xs text-gray-600 mb-1">Fecha hasta</label>
            <input type="date" name="date_to" value="<?= htmlspecialchars($_GET['date_to'] ?? date('Y-m-t')) ?>"
                class="px-3 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
        </div>
        <div>
            <label class="block text-xs text-gray-600 mb-1">Estado</label>
            <select name="status" class="px-3 py-2 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                <option value="">Todos</option>
                <option value="pending" <?= ($_GET['status'] ?? '') === 'pending' ? 'selected' : '' ?>>Pendiente</option>
                <option value="confirmed" <?= ($_GET['status'] ?? '') === 'confirmed' ? 'selected' : '' ?>>Confirmada</option>
                <option value="cancelled" <?= ($_GET['status'] ?? '') === 'cancelled' ? 'selected' : '' ?>>Cancelada</option>
                <option value="completed" <?= ($_GET['status'] ?? '') === 'completed' ? 'selected' : '' ?>>Completada</option>
            </select>
        </div>
        <button type="submit" class="bg-sky-500 text-white px-4 py-2 rounded-xl text-sm hover:bg-sky-600 transition-all">Filtrar</button>
    </form>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <?php if (empty($reservations)): ?>
        <div class="p-12 text-center text-gray-400">Sin reservaciones en este período</div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Usuario</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Espacio</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Fecha y Hora</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Total</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php
                $statusColors = ['pending' => 'bg-amber-100 text-amber-700', 'confirmed' => 'bg-green-100 text-green-700', 'cancelled' => 'bg-red-100 text-red-700', 'completed' => 'bg-gray-100 text-gray-600'];
                $statusLabels = ['pending' => 'Pendiente', 'confirmed' => 'Confirmada', 'cancelled' => 'Cancelada', 'completed' => 'Completada'];
                foreach ($reservations as $r):
                $st = $r['status'] ?? 'pending';
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <p class="font-medium"><?= htmlspecialchars($r['user_name'] ?? '') ?></p>
                        <p class="text-xs text-gray-400"><?= htmlspecialchars($r['whatsapp'] ?? '') ?></p>
                    </td>
                    <td class="px-4 py-3"><?= htmlspecialchars($r['space_name'] ?? '') ?></td>
                    <td class="px-4 py-3">
                        <p><?= date('d/m/Y', strtotime($r['date'])) ?></p>
                        <p class="text-xs text-gray-400"><?= substr($r['start_time'], 0, 5) ?> – <?= substr($r['end_time'], 0, 5) ?></p>
                    </td>
                    <td class="px-4 py-3 text-right font-medium">$<?= number_format($r['total'], 2) ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium <?= $statusColors[$st] ?? 'bg-gray-100 text-gray-600' ?>">
                            <?= $statusLabels[$st] ?? ucfirst($st) ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <?php if ($st === 'pending'): ?>
                        <form method="POST" action="<?= BASE_URL ?>admin/confirmReservation" class="inline">
                            <input type="hidden" name="id" value="<?= $r['id'] ?>">
                            <button type="submit" class="text-green-600 hover:underline text-xs mr-2">Confirmar</button>
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
