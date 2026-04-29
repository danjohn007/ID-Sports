<div class="max-w-lg mx-auto pb-20 lg:pb-6">
    <?php if ($error ?? false): ?>
    <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 text-red-700 dark:text-red-300 px-4 py-3 rounded-2xl text-sm mb-4"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <?php
    $isConfirmed = !empty($reservation['qr_code']);
    ?>

    <?php if ($isConfirmed): ?>
    <!-- SUCCESS screen (RF3.6) -->
    <div class="text-center py-6">
        <!-- Animated check -->
        <div class="w-24 h-24 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mx-auto mb-4 animate-bounce">
            <svg class="w-12 h-12 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="jockey-one text-2xl font-bold text-gray-900 dark:text-white">¡Reservación Confirmada!</h1>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Tu cancha está lista 🎉</p>
    </div>

    <!-- Ticket card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-xl border border-gray-100 dark:border-gray-700 mb-4">
        <!-- Gradient header -->
        <div class="bg-gradient-to-r from-sky-500 to-violet-600 p-5 text-white">
            <p class="text-sky-200 text-xs font-medium uppercase tracking-wider">Ticket de reserva</p>
            <h2 class="jockey-one text-xl font-bold mt-0.5"><?= htmlspecialchars($reservation['space_name'] ?? '') ?></h2>
            <p class="text-sky-100 text-sm"><?= htmlspecialchars($reservation['club_name'] ?? '') ?></p>
        </div>
        <!-- Details -->
        <div class="p-5 space-y-3">
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Fecha</span>
                <span class="font-medium text-gray-900 dark:text-white"><?= date('d/m/Y (l)', strtotime($reservation['date'] ?? 'now')) ?></span>
            </div>
            <div class="flex justify-between text-sm">
                <span class="text-gray-500 dark:text-gray-400">Horario</span>
                <span class="font-medium text-gray-900 dark:text-white"><?= substr($reservation['start_time'] ?? '', 0, 5) ?> – <?= substr($reservation['end_time'] ?? '', 0, 5) ?></span>
            </div>
            <?php if (!empty($reservation['discount']) && $reservation['discount'] > 0): ?>
            <div class="flex justify-between text-sm text-green-600 dark:text-green-400">
                <span>Descuento</span>
                <span>-$<?= number_format($reservation['discount'], 2) ?></span>
            </div>
            <?php endif; ?>
            <div class="border-t border-dashed border-gray-200 dark:border-gray-600 pt-3 flex justify-between font-bold">
                <span class="text-gray-900 dark:text-white">Total pagado</span>
                <span class="text-sky-600 text-xl">$<?= number_format($reservation['total'] ?? 0, 2) ?></span>
            </div>
        </div>

        <!-- Dashed divider (ticket punch) -->
        <div class="relative border-t border-dashed border-gray-200 dark:border-gray-600 mx-4">
            <div class="absolute -left-8 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-900 border-r border-dashed border-gray-200 dark:border-gray-600"></div>
            <div class="absolute -right-8 top-1/2 -translate-y-1/2 w-8 h-8 rounded-full bg-gray-50 dark:bg-gray-900 border-l border-dashed border-gray-200 dark:border-gray-600"></div>
        </div>

        <!-- QR Code section -->
        <div class="p-5 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Muestra este QR en la entrada del club</p>
            <div id="qrTicket" class="flex items-center justify-center mx-auto bg-white p-3 rounded-2xl inline-block shadow-inner border border-gray-100"></div>
            <p class="text-xs font-mono text-gray-400 mt-2 break-all"><?= htmlspecialchars($reservation['qr_code'] ?? '') ?></p>
        </div>
    </div>

    <!-- Action buttons -->
    <div class="grid grid-cols-2 gap-3 mb-3">
        <button onclick="downloadTicket()"
            class="flex items-center justify-center gap-2 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-medium py-3 rounded-2xl text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Descargar
        </button>
        <button onclick="shareTicket()"
            class="flex items-center justify-center gap-2 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-medium py-3 rounded-2xl text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            Compartir
        </button>
    </div>
    <a href="<?= BASE_URL ?>home" class="w-full block text-center text-white font-bold py-3.5 rounded-2xl transition-all" style="background:var(--primary)">
        ← Volver al Inicio
    </a>

    <?php else: ?>
    <!-- CONFIRMATION screen (pre-payment) -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 overflow-hidden">
        <div class="bg-gradient-to-r from-sky-500 to-violet-600 p-6 text-white">
            <h2 class="jockey-one text-xl font-bold">Confirmar Reservación</h2>
            <p class="text-sky-100 text-sm mt-1">Revisa los detalles antes de confirmar</p>
        </div>
        <div class="p-6 space-y-4">
            <div class="space-y-3">
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Espacio</span>
                    <span class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($reservation['space_name'] ?? '') ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Club</span>
                    <span class="font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($reservation['club_name'] ?? '') ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Fecha</span>
                    <span class="font-medium text-gray-900 dark:text-white"><?= date('d/m/Y (l)', strtotime($reservation['date'] ?? 'now')) ?></span>
                </div>
                <div class="flex justify-between text-sm">
                    <span class="text-gray-500 dark:text-gray-400">Horario</span>
                    <span class="font-medium text-gray-900 dark:text-white"><?= substr($reservation['start_time'] ?? '', 0, 5) ?> – <?= substr($reservation['end_time'] ?? '', 0, 5) ?></span>
                </div>
                <?php if (!empty($reservation['discount']) && $reservation['discount'] > 0): ?>
                <div class="flex justify-between text-sm text-green-600 dark:text-green-400">
                    <span>Descuento aplicado</span>
                    <span>-$<?= number_format($reservation['discount'], 2) ?></span>
                </div>
                <?php endif; ?>
                <hr class="border-gray-100 dark:border-gray-700">
                <div class="flex justify-between font-bold text-gray-900 dark:text-white">
                    <span>Total a pagar</span>
                    <span class="text-sky-600 text-lg">$<?= number_format($reservation['total'] ?? 0, 2) ?></span>
                </div>
            </div>

            <div class="bg-amber-50 dark:bg-amber-900/20 border border-amber-100 dark:border-amber-800 rounded-2xl p-3 text-xs text-amber-700 dark:text-amber-300">
                ⚠️ Al confirmar, aceptas las políticas de cancelación del club. Las reservaciones deben cancelarse con mínimo 2 horas de anticipación.
            </div>

            <form method="POST">
                <input type="hidden" name="confirmed" value="1">
                <?php
                $allowedFields = ['space_id', 'date', 'start_time', 'end_time', 'num_people', 'coupon', 'notes', 'payment_method'];
                foreach ($allowedFields as $field):
                    if (!isset($_POST[$field])) continue;
                    $v = is_array($_POST[$field]) ? implode(',', array_map('htmlspecialchars', $_POST[$field])) : htmlspecialchars($_POST[$field]);
                ?>
                <input type="hidden" name="<?= htmlspecialchars($field) ?>" value="<?= $v ?>">
                <?php endforeach; ?>
                <div class="flex gap-3">
                    <a href="javascript:history.back()" class="flex-1 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 font-medium py-3 rounded-2xl text-center text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
                        ← Volver
                    </a>
                    <button type="submit" class="flex-1 text-white font-bold py-3 rounded-2xl transition-all text-sm shadow-lg" style="background:var(--primary)">
                        ✅ Confirmar y Pagar
                    </button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>
</div>

<style>
.jockey-one { font-family: 'Jockey One', sans-serif; }
@keyframes bounce { 0%,100%{transform:translateY(-10%)} 50%{transform:none} }
.animate-bounce { animation: bounce 1s ease-in-out 3; }
</style>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
<?php if ($isConfirmed && !empty($reservation['qr_code'])): ?>
// Render QR on ticket
const qrCode = <?= json_encode($reservation['qr_code']) ?>;
const canvas = document.createElement('canvas');
document.getElementById('qrTicket').appendChild(canvas);
QRCode.toCanvas(canvas, qrCode, {width: 200, margin: 1}, function(err){});
<?php endif; ?>

function downloadTicket() {
    window.print();
}

function shareTicket() {
    if (navigator.share) {
        navigator.share({
            title: '¡Tengo una reserva en ID Sports!',
            text: 'Reserva confirmada en <?= htmlspecialchars($reservation['space_name'] ?? 'ID Sports') ?>',
            url: window.location.href
        });
    } else {
        alert('Comparte este enlace: ' + window.location.href);
    }
}
</script>
