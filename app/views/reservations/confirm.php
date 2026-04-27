<div class="max-w-lg mx-auto">
    <?php if ($error): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="bg-gradient-to-r from-sky-500 to-violet-600 p-6 text-white">
            <h2 class="text-xl font-bold">Confirmar Reservación</h2>
            <p class="text-sky-100 text-sm mt-1">Revisa los detalles antes de confirmar</p>
        </div>
        <div class="p-6 space-y-4">
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Espacio</span>
                    <span class="font-medium"><?= htmlspecialchars($reservation['space_name'] ?? '') ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Club</span>
                    <span class="font-medium"><?= htmlspecialchars($reservation['club_name'] ?? '') ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Fecha</span>
                    <span class="font-medium"><?= date('d/m/Y (l)', strtotime($reservation['date'] ?? 'now')) ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500">Horario</span>
                    <span class="font-medium"><?= substr($reservation['start_time'] ?? '', 0, 5) ?> – <?= substr($reservation['end_time'] ?? '', 0, 5) ?></span>
                </div>
                <?php if (!empty($reservation['discount'])): ?>
                <div class="flex justify-between text-sm text-green-600">
                    <span>Descuento aplicado</span>
                    <span>-$<?= number_format($reservation['discount'], 2) ?></span>
                </div>
                <?php endif; ?>
                <hr class="border-gray-100">
                <div class="flex justify-between font-bold text-gray-900">
                    <span>Total a pagar</span>
                    <span class="text-sky-600 text-lg">$<?= number_format($reservation['total'] ?? 0, 2) ?></span>
                </div>
            </div>

            <div class="bg-amber-50 border border-amber-100 rounded-xl p-3 text-xs text-amber-700">
                ⚠️ Al confirmar, aceptas las políticas de cancelación del club. Las reservaciones deben cancelarse con mínimo 2 horas de anticipación.
            </div>

            <form method="POST">
                <input type="hidden" name="confirmed" value="1">
                <?php foreach ($_POST as $k => $v): ?>
                <input type="hidden" name="<?= htmlspecialchars($k) ?>" value="<?= htmlspecialchars($v) ?>">
                <?php endforeach; ?>
                <div class="flex gap-3">
                    <a href="javascript:history.back()" class="flex-1 border border-gray-200 text-gray-600 font-medium py-2.5 rounded-xl text-center text-sm hover:bg-gray-50 transition-all">
                        ← Volver
                    </a>
                    <button type="submit" class="flex-1 bg-sky-500 hover:bg-sky-600 text-white font-bold py-2.5 rounded-xl transition-all text-sm">
                        ✅ Confirmar y Pagar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
