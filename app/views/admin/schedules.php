<div class="space-y-5">
    <div class="flex items-center justify-between">
        <div>
            <h2 class="text-lg font-semibold text-gray-900">🕐 Horarios: <?= htmlspecialchars($space['name'] ?? '') ?></h2>
            <p class="text-sm text-gray-500 mt-0.5">Define los bloques horarios disponibles para reservaciones</p>
        </div>
        <a href="<?= BASE_URL ?>admin/spaces" class="text-sky-500 text-sm hover:underline">← Volver a Espacios</a>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <!-- Current schedules -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Horarios Configurados</h3>
            <?php
            $days = ['monday' => 'Lunes', 'tuesday' => 'Martes', 'wednesday' => 'Miércoles', 'thursday' => 'Jueves', 'friday' => 'Viernes', 'saturday' => 'Sábado', 'sunday' => 'Domingo'];
            if (empty($schedules)):
            ?>
            <p class="text-gray-400 text-sm text-center py-6">Sin horarios configurados</p>
            <?php else: ?>
            <div class="space-y-2">
                <?php foreach ($schedules as $sch): ?>
                <div class="flex items-center justify-between py-2 border-b border-gray-50 last:border-0 text-sm">
                    <span class="font-medium text-gray-800"><?= $days[$sch['day_of_week']] ?? ucfirst($sch['day_of_week']) ?></span>
                    <span class="text-gray-600"><?= substr($sch['open_time'], 0, 5) ?> – <?= substr($sch['close_time'], 0, 5) ?></span>
                    <span class="text-sky-600 font-medium">$<?= number_format($sch['price_override'] ?? $space['price_per_hour'] ?? 0, 2) ?></span>
                    <form method="POST" action="<?= BASE_URL ?>admin/deleteSchedule">
                        <input type="hidden" name="id" value="<?= $sch['id'] ?>">
                        <input type="hidden" name="space_id" value="<?= $space['id'] ?>">
                        <button type="submit" class="text-red-400 hover:text-red-600 text-xs">✕</button>
                    </form>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>

        <!-- Add schedule form -->
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Agregar Horario</h3>
            <form method="POST" action="<?= BASE_URL ?>admin/storeSchedule" class="space-y-3">
                <input type="hidden" name="space_id" value="<?= $space['id'] ?? '' ?>">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Día</label>
                    <select name="day_of_week" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <?php foreach ($days as $val => $label): ?>
                        <option value="<?= $val ?>"><?= $label ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Apertura</label>
                        <input type="time" name="open_time" value="07:00" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Cierre</label>
                        <input type="time" name="close_time" value="22:00" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Precio especial (dejar vacío para precio base)</label>
                    <input type="number" name="price_override" step="0.01" min="0" placeholder="Ej: 350.00"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <button type="submit" class="w-full bg-sky-500 text-white font-semibold py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">
                    Guardar Horario
                </button>
            </form>
        </div>
    </div>
</div>
