<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">🕐 Horarios por Espacio</h2>
            <p class="text-sm text-gray-500 mt-0.5">Define los días y bloques horarios disponibles para reservaciones</p>
        </div>
    </div>

    <?php
    // day_of_week: 0=Domingo, 1=Lunes, ..., 6=Sábado
    $dayNames = [0 => 'Domingo', 1 => 'Lunes', 2 => 'Martes', 3 => 'Miércoles', 4 => 'Jueves', 5 => 'Viernes', 6 => 'Sábado'];
    ?>

    <?php foreach ($spaces as $sp): ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <h3 class="font-semibold text-gray-900 mb-4">🏟️ <?= htmlspecialchars($sp['name']) ?></h3>

        <!-- Current schedules for this space -->
        <?php
        $spaceScheds = $schedulesBySpace[$sp['id']] ?? [];
        $schedByDay = [];
        foreach ($spaceScheds as $s) { $schedByDay[$s['day_of_week']] = $s; }
        ?>
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="border-b border-gray-100">
                        <th class="text-left py-2 pr-4 font-medium text-gray-500">Día</th>
                        <th class="text-left py-2 pr-4 font-medium text-gray-500">Apertura</th>
                        <th class="text-left py-2 pr-4 font-medium text-gray-500">Cierre</th>
                        <th class="text-left py-2 font-medium text-gray-500">Estado</th>
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($dayNames as $num => $name): ?>
                <tr class="border-b border-gray-50 last:border-0">
                    <td class="py-2 pr-4 font-medium text-gray-800"><?= $name ?></td>
                    <?php if (isset($schedByDay[$num])): ?>
                    <td class="py-2 pr-4 text-gray-600"><?= substr($schedByDay[$num]['open_time'], 0, 5) ?></td>
                    <td class="py-2 pr-4 text-gray-600"><?= substr($schedByDay[$num]['close_time'], 0, 5) ?></td>
                    <td class="py-2"><span class="bg-green-100 text-green-700 text-xs font-medium px-2 py-0.5 rounded-full">Abierto</span></td>
                    <?php else: ?>
                    <td class="py-2 pr-4 text-gray-300">—</td>
                    <td class="py-2 pr-4 text-gray-300">—</td>
                    <td class="py-2"><span class="bg-gray-100 text-gray-400 text-xs font-medium px-2 py-0.5 rounded-full">Cerrado</span></td>
                    <?php endif; ?>
                </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <!-- Add schedule form -->
        <details class="mt-4">
            <summary class="text-sky-500 text-sm font-medium cursor-pointer hover:text-sky-600">+ Agregar / Editar Horario</summary>
            <form method="POST" action="<?= BASE_URL ?>admin/schedules" class="mt-3 grid grid-cols-2 sm:grid-cols-4 gap-3">
                <input type="hidden" name="space_id" value="<?= $sp['id'] ?>">
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Día</label>
                    <select name="day_of_week" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <?php foreach ($dayNames as $num => $name): ?>
                        <option value="<?= $num ?>"><?= $name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Apertura</label>
                    <input type="time" name="open_time" value="07:00" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-xs font-medium text-gray-600 mb-1">Cierre</label>
                    <input type="time" name="close_time" value="22:00" class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div class="flex items-end">
                    <button type="submit" class="w-full bg-sky-500 text-white font-semibold py-2 rounded-lg text-sm hover:bg-sky-600 transition-all">
                        Guardar
                    </button>
                </div>
            </form>
        </details>
    </div>
    <?php endforeach; ?>
</div>
