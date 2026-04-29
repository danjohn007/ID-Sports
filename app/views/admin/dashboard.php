<div class="space-y-6">
    <?php if (!empty($refundPendingCount) && $refundPendingCount > 0): ?>
    <div class="flex items-center gap-3 bg-orange-50 border border-orange-200 rounded-2xl px-4 py-3">
        <span class="text-xl">⚠️</span>
        <div class="flex-1">
            <p class="font-semibold text-orange-800 text-sm">
                <?= $refundPendingCount ?> solicitud<?= $refundPendingCount > 1 ? 'es' : '' ?> de reembolso pendiente<?= $refundPendingCount > 1 ? 's' : '' ?> de revisión
            </p>
            <p class="text-xs text-orange-600 mt-0.5">Un cliente ha solicitado cancelar su reserva. Revisa y aprueba o rechaza desde Reservaciones.</p>
        </div>
        <a href="<?= BASE_URL ?>admin/reservations?status=refund_pending"
           class="text-xs font-bold text-orange-700 bg-orange-100 border border-orange-300 rounded-xl px-3 py-1.5 hover:bg-orange-200 transition-all whitespace-nowrap">
            Ver ahora
        </a>
    </div>
    <?php endif; ?>

    <!-- Stats row -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <?php
        $stats = [
            ['label' => 'Reservaciones Hoy', 'value' => $todayReservations ?? 0, 'icon' => '📅', 'color' => 'sky'],
            ['label' => 'Ingresos del Mes', 'value' => '$' . number_format($monthRevenue ?? 0, 2), 'icon' => '💰', 'color' => 'green'],
            ['label' => 'Espacios Activos', 'value' => $activeSpaces ?? 0, 'icon' => '🏟️', 'color' => 'violet'],
            ['label' => 'Incidencias Abiertas', 'value' => $openIncidents ?? 0, 'icon' => '⚠️', 'color' => 'amber'],
        ];
        foreach ($stats as $s):
        ?>
        <div class="bg-white rounded-2xl border border-gray-100 p-4">
            <p class="text-2xl mb-2"><?= $s['icon'] ?></p>
            <p class="text-2xl font-bold text-gray-900"><?= $s['value'] ?></p>
            <p class="text-xs text-gray-500 mt-0.5"><?= $s['label'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Chart + recent reservations -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Ingresos (últimos 7 días)</h3>
            <canvas id="revenueChart" height="180"></canvas>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Próximas Reservaciones</h3>
            <?php if (empty($upcomingReservations)): ?>
            <p class="text-gray-400 text-sm text-center py-8">Sin reservaciones próximas</p>
            <?php else: ?>
            <div class="space-y-2">
                <?php foreach (array_slice($upcomingReservations, 0, 5) as $r): ?>
                <div class="flex items-center gap-3 text-sm py-2 border-b border-gray-50 last:border-0">
                    <div class="w-8 h-8 rounded-lg bg-sky-50 flex items-center justify-center text-sm">
                        <?= substr($r['user_name'] ?? 'U', 0, 1) ?>
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="font-medium text-gray-900 truncate"><?= htmlspecialchars($r['user_name'] ?? '') ?></p>
                        <p class="text-xs text-gray-500"><?= htmlspecialchars($r['space_name'] ?? '') ?> · <?= substr($r['start_time'], 0, 5) ?></p>
                    </div>
                    <span class="font-medium text-sky-600">$<?= number_format($r['total'], 2) ?></span>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Quick links -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <a href="<?= BASE_URL ?>admin/spaces" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:shadow-md transition-all">
            <p class="text-3xl mb-2">🏃</p><p class="text-sm font-medium text-gray-700">Espacios</p>
        </a>
        <a href="<?= BASE_URL ?>admin/reservations" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:shadow-md transition-all">
            <p class="text-3xl mb-2">📋</p><p class="text-sm font-medium text-gray-700">Reservaciones</p>
        </a>
        <a href="<?= BASE_URL ?>admin/amenities" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:shadow-md transition-all">
            <p class="text-3xl mb-2">✨</p><p class="text-sm font-medium text-gray-700">Amenidades</p>
        </a>
        <a href="<?= BASE_URL ?>admin/incidents" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:shadow-md transition-all">
            <p class="text-3xl mb-2">⚠️</p><p class="text-sm font-medium text-gray-700">Incidencias</p>
        </a>
    </div>
</div>

<script>
const revenueCtx = document.getElementById('revenueChart');
if (revenueCtx) {
    new Chart(revenueCtx, {
        type: 'bar',
        data: {
            labels: <?= json_encode($chartLabels ?? []) ?>,
            datasets: [{
                label: 'Ingresos $',
                data: <?= json_encode($chartData ?? []) ?>,
                backgroundColor: 'rgba(14,165,233,0.2)',
                borderColor: '#0EA5E9',
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false,
            plugins: { legend: { display: false } },
            scales: { y: { beginAtZero: true } }
        }
    });
}
</script>
