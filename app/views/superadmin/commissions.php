<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">💸 Comisiones por Club</h2>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <?php if (empty($commissions)): ?>
        <div class="p-12 text-center text-gray-400">Sin datos de comisiones</div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Club</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Ingresos Totales</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Comisión (%)</th>
                    <th class="text-right px-4 py-3 font-semibold text-gray-600">Comisión $</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php foreach ($commissions as $c): ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium"><?= htmlspecialchars($c['name']) ?></td>
                    <td class="px-4 py-3 text-right">$<?= number_format($c['total_revenue'] ?? 0, 2) ?></td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="<?= BASE_URL ?>superadmin/updateCommission" class="flex justify-end items-center gap-2">
                            <input type="hidden" name="club_id" value="<?= $c['id'] ?>">
                            <input type="number" name="commission_pct" value="<?= $c['commission_pct'] ?? 10 ?>"
                                min="0" max="100" step="0.5" class="w-20 px-2 py-1 rounded-lg border border-gray-200 text-sm text-center">
                            <button type="submit" class="text-sky-500 hover:underline text-xs">Guardar</button>
                        </form>
                    </td>
                    <td class="px-4 py-3 text-right font-bold text-violet-600">
                        $<?= number_format(($c['total_revenue'] ?? 0) * ($c['commission_pct'] ?? 10) / 100, 2) ?>
                    </td>
                    <td class="px-4 py-3"></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot class="bg-gray-50 border-t border-gray-100">
                <tr>
                    <td class="px-4 py-3 font-bold">Total</td>
                    <td class="px-4 py-3 text-right font-bold">$<?= number_format(array_sum(array_column($commissions, 'total_revenue')), 2) ?></td>
                    <td class="px-4 py-3"></td>
                    <td class="px-4 py-3 text-right font-bold text-violet-600">
                        $<?= number_format(array_sum(array_map(fn($c) => ($c['total_revenue'] ?? 0) * ($c['commission_pct'] ?? 10) / 100, $commissions)), 2) ?>
                    </td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
        <?php endif; ?>
    </div>
</div>
