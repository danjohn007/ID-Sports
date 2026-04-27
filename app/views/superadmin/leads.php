<div class="space-y-5">
    <h2 class="text-lg font-semibold text-gray-900">📊 Leads / Solicitudes de Club</h2>

    <div class="bg-white rounded-2xl border border-gray-100 overflow-hidden">
        <?php if (empty($leads)): ?>
        <div class="p-12 text-center text-gray-400">Sin leads registrados</div>
        <?php else: ?>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b border-gray-100">
                <tr>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Nombre</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Contacto</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Mensaje</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Fecha</th>
                    <th class="text-left px-4 py-3 font-semibold text-gray-600">Estado</th>
                    <th class="px-4 py-3"></th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                <?php
                $stColors = ['new' => 'bg-blue-100 text-blue-700', 'contacted' => 'bg-amber-100 text-amber-700', 'converted' => 'bg-green-100 text-green-700', 'closed' => 'bg-gray-100 text-gray-500'];
                $stLabels = ['new' => 'Nuevo', 'contacted' => 'Contactado', 'converted' => 'Convertido', 'closed' => 'Cerrado'];
                foreach ($leads as $l):
                $st = $l['status'] ?? 'new';
                ?>
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-medium"><?= htmlspecialchars($l['name']) ?></td>
                    <td class="px-4 py-3">
                        <p><?= htmlspecialchars($l['email'] ?? '') ?></p>
                        <p class="text-gray-400 text-xs"><?= htmlspecialchars($l['phone'] ?? '') ?></p>
                    </td>
                    <td class="px-4 py-3 max-w-xs">
                        <p class="text-gray-600 truncate"><?= htmlspecialchars(substr($l['message'] ?? '', 0, 60)) ?></p>
                    </td>
                    <td class="px-4 py-3 text-gray-500"><?= date('d/m/Y', strtotime($l['created_at'])) ?></td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-medium <?= $stColors[$st] ?? 'bg-gray-100 text-gray-500' ?>">
                            <?= $stLabels[$st] ?? ucfirst($st) ?>
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <form method="POST" action="<?= BASE_URL ?>superadmin/updateLead" class="flex justify-end gap-1">
                            <input type="hidden" name="id" value="<?= $l['id'] ?>">
                            <select name="status" class="text-xs px-2 py-1 rounded-lg border border-gray-200 focus:outline-none">
                                <?php foreach ($stLabels as $val => $lbl): ?>
                                <option value="<?= $val ?>" <?= $st === $val ? 'selected' : '' ?>><?= $lbl ?></option>
                                <?php endforeach; ?>
                            </select>
                            <button type="submit" class="text-sky-500 hover:underline text-xs">OK</button>
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php endif; ?>
    </div>
</div>
