<?php
/* ── Confirm / Ticket view ─────────────────────────────── */
$isConfirmed = !empty($reservation['qr_code']);
$amenities   = $amenities ?? [];
$statusLabels = ['confirmed'=>'Confirmada','in_progress'=>'En Progreso','completed'=>'Completada','cancelled'=>'Cancelada','pending'=>'Pendiente','active'=>'Activa'];
$statusColors = ['confirmed'=>'text-green-500','in_progress'=>'text-sky-400','completed'=>'text-gray-400','cancelled'=>'text-red-400','pending'=>'text-amber-400'];
$curStatus    = $reservation['status'] ?? 'confirmed';
?>
<style>
.jockey-one { font-family: 'Jockey One', sans-serif; }
@keyframes popCheck { 0%{transform:scale(0);opacity:0} 70%{transform:scale(1.15)} 100%{transform:scale(1);opacity:1} }
.check-anim { animation: popCheck 500ms cubic-bezier(0.34,1.56,0.64,1) forwards; }
@media print {
    nav, .nav-wrap, .sidebar, header { display: none !important; }
}
</style>

<div class="max-w-lg mx-auto pb-20 lg:pb-6">

    <!-- Success header -->
    <div class="text-center py-6">
        <div class="w-20 h-20 rounded-full bg-green-100 dark:bg-green-900/30 flex items-center justify-center mx-auto mb-4 check-anim">
            <svg class="w-10 h-10 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/>
            </svg>
        </div>
        <h1 class="jockey-one text-2xl font-bold text-gray-900 dark:text-white mb-1">
            <?php if ($curStatus === 'in_progress'): ?>🏃 Sesión en Progreso<?php elseif ($curStatus === 'confirmed'): ?>¡Reservación Confirmada!<?php else: ?>Reservación<?php endif; ?>
        </h1>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            <span class="<?= $statusColors[$curStatus] ?? 'text-gray-400' ?> font-semibold">
                <?= $statusLabels[$curStatus] ?? ucfirst($curStatus) ?>
            </span>
            &nbsp;·&nbsp; Tu cancha está lista 🎉
        </p>
    </div>

    <!-- Ticket card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl overflow-hidden shadow-xl border border-gray-100 dark:border-gray-700 mb-4">
        <!-- Gradient header -->
        <div style="background:linear-gradient(135deg,var(--primary),var(--secondary))" class="p-5 text-white">
            <p style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:rgba(255,255,255,0.65);margin:0 0 0.25rem">Ticket de Reserva</p>
            <h2 class="jockey-one text-xl font-bold mt-0.5" style="margin:0 0 0.125rem"><?= htmlspecialchars($reservation['space_name'] ?? '') ?></h2>
            <p style="font-size:0.8125rem;color:rgba(255,255,255,0.7);margin:0"><?= htmlspecialchars($reservation['club_name'] ?? '') ?></p>
        </div>

        <!-- Details -->
        <div class="p-5">
            <div class="flex justify-between text-sm mb-3">
                <span class="text-gray-500 dark:text-gray-400">Fecha</span>
                <span class="font-semibold text-gray-900 dark:text-white"><?= date('d/m/Y', strtotime($reservation['date'] ?? 'now')) ?></span>
            </div>
            <div class="flex justify-between text-sm mb-3">
                <span class="text-gray-500 dark:text-gray-400">Horario</span>
                <span class="font-semibold text-gray-900 dark:text-white"><?= substr($reservation['start_time'] ?? '', 0, 5) ?> – <?= substr($reservation['end_time'] ?? '', 0, 5) ?></span>
            </div>
            <?php foreach ($amenities as $a): ?>
            <div class="flex justify-between text-sm mb-2">
                <span class="text-gray-500 dark:text-gray-400"><?= htmlspecialchars($a['name']) ?> ×<?= (int)$a['quantity'] ?></span>
                <span class="font-semibold text-gray-900 dark:text-white">$<?= number_format($a['price'], 2) ?></span>
            </div>
            <?php endforeach; ?>
            <?php if (!empty($reservation['discount']) && $reservation['discount'] > 0): ?>
            <div class="flex justify-between text-sm mb-2 text-green-600 dark:text-green-400">
                <span>Descuento</span>
                <span>-$<?= number_format($reservation['discount'], 2) ?></span>
            </div>
            <?php endif; ?>
            <hr class="border-dashed border-gray-200 dark:border-gray-600 my-3">
            <div class="flex justify-between font-bold">
                <span class="text-gray-900 dark:text-white">Total pagado</span>
                <span style="color:var(--primary);font-size:1.125rem">$<?= number_format($reservation['total'] ?? 0, 2) ?></span>
            </div>
        </div>

        <!-- Punch divider -->
        <div class="relative border-t border-dashed border-gray-200 dark:border-gray-600 mx-4">
            <div class="absolute -left-8 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-gray-50 dark:bg-gray-900"></div>
            <div class="absolute -right-8 top-1/2 -translate-y-1/2 w-7 h-7 rounded-full bg-gray-50 dark:bg-gray-900"></div>
        </div>

        <!-- QR section -->
        <div class="p-5 text-center">
            <p class="text-xs text-gray-500 dark:text-gray-400 mb-3">Muestra este QR en la entrada del club</p>
            <?php if ($isConfirmed): ?>
            <div id="qrTicket" class="bg-white p-3 rounded-2xl inline-block shadow-inner border border-gray-100"></div>
            <p class="text-xs font-mono text-gray-400 mt-2 break-all" style="font-size:0.6rem"><?= htmlspecialchars($reservation['qr_code'] ?? '') ?></p>
            <?php else: ?>
            <p class="text-xs text-amber-500">QR no disponible para esta reservación.</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Action buttons -->
    <div class="grid grid-cols-2 gap-3 mb-3">
        <button onclick="window.print()"
            class="flex items-center justify-center gap-2 border border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 font-medium py-3 rounded-2xl text-sm hover:bg-gray-50 dark:hover:bg-gray-700 transition-all">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
            Imprimir
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

</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
<?php if ($isConfirmed && !empty($reservation['qr_code'])): ?>
(function() {
    var qrCode = <?= json_encode($reservation['qr_code']) ?>;
    var wrap   = document.getElementById('qrTicket');
    if (wrap && qrCode) {
        var canvas = document.createElement('canvas');
        wrap.appendChild(canvas);
        QRCode.toCanvas(canvas, qrCode, {width: 200, margin: 1}, function(){});
    }
})();
<?php endif; ?>

function shareTicket() {
    var spaceName = <?= json_encode($reservation['space_name'] ?? 'ID Sports') ?>;
    if (navigator.share) {
        navigator.share({
            title: '¡Tengo una reserva en ID Sports!',
            text: 'Reserva confirmada en ' + spaceName,
            url: window.location.href
        });
    } else {
        var el = document.createElement('textarea');
        el.value = window.location.href;
        document.body.appendChild(el);
        el.select();
        document.execCommand('copy');
        document.body.removeChild(el);
        alert('Enlace copiado al portapapeles');
    }
}
</script>
