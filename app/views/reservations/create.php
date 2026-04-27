<div class="max-w-xl mx-auto space-y-5">
    <?php if ($error): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-5">
        <h2 class="font-semibold text-gray-900 mb-1">Nueva Reservación</h2>
        <p class="text-sm text-gray-500 mb-4">
            <strong><?= htmlspecialchars($space['name']) ?></strong> — <?= htmlspecialchars($space['club_name']) ?>
        </p>

        <form method="POST" id="reservationForm" class="space-y-4">
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Fecha</label>
                    <input type="date" name="date" required min="<?= date('Y-m-d') ?>"
                        value="<?= htmlspecialchars($_GET['date'] ?? date('Y-m-d')) ?>"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                        onchange="updateTotal()">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Hora Inicio</label>
                    <select name="start_time" required
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                        onchange="updateTotal()">
                        <?php
                        $start = isset($space['open_time']) ? (int)$space['open_time'] : 6;
                        $end = isset($space['close_time']) ? (int)$space['close_time'] : 22;
                        for ($h = $start; $h < $end; $h++):
                            $val = sprintf('%02d:00', $h);
                            $label = date('g:i a', strtotime($val));
                        ?>
                        <option value="<?= $val ?>" <?= ($val === ($_GET['time'] ?? '')) ? 'selected' : '' ?>>
                            <?= $label ?>
                        </option>
                        <?php endfor; ?>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Duración</label>
                <select name="duration" required
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500"
                    onchange="updateTotal()">
                    <option value="1">1 hora</option>
                    <option value="1.5">1.5 horas</option>
                    <option value="2">2 horas</option>
                    <option value="3">3 horas</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Código de descuento (opcional)</label>
                <input type="text" name="coupon_code" placeholder="Ej: PROMO20"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Notas</label>
                <textarea name="notes" rows="2" placeholder="Algo que debamos saber..."
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none"></textarea>
            </div>

            <!-- Price summary -->
            <div class="bg-sky-50 border border-sky-100 rounded-xl p-4">
                <div class="flex justify-between text-sm mb-1">
                    <span class="text-gray-600">Precio por hora</span>
                    <span>$<?= number_format($space['price_per_hour'], 2) ?></span>
                </div>
                <div class="flex justify-between text-sm mb-1" id="durationRow">
                    <span class="text-gray-600">Duración</span>
                    <span id="durationDisplay">1 hora</span>
                </div>
                <hr class="border-sky-100 my-2">
                <div class="flex justify-between font-bold text-gray-900">
                    <span>Total</span>
                    <span id="totalDisplay">$<?= number_format($space['price_per_hour'], 2) ?></span>
                </div>
            </div>

            <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-bold py-3 rounded-xl transition-all">
                Continuar al Pago →
            </button>
        </form>
    </div>
</div>

<script>
const pricePerHour = <?= (float)($space['price_per_hour'] ?? 0) ?>;
function updateTotal() {
    const dur = parseFloat(document.querySelector('[name=duration]').value);
    const total = pricePerHour * dur;
    document.getElementById('durationDisplay').textContent = dur + (dur === 1 ? ' hora' : ' horas');
    document.getElementById('totalDisplay').textContent = '$' + total.toFixed(2);
}
</script>
