<div class="space-y-6">
    <!-- Stats -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <?php
        $stats = [
            ['label' => 'Clubes Activos', 'value' => $totalClubs ?? 0, 'icon' => '🏟️'],
            ['label' => 'Usuarios Totales', 'value' => $totalUsers ?? 0, 'icon' => '👥'],
            ['label' => 'Reservaciones Hoy', 'value' => $todayReservations ?? 0, 'icon' => '📅'],
            ['label' => 'Ingresos del Mes', 'value' => '$' . number_format($monthRevenue ?? 0, 2), 'icon' => '💰'],
        ];
        foreach ($stats as $s):
        ?>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <p class="text-2xl mb-2"><?= $s['icon'] ?></p>
            <p class="text-2xl font-bold text-gray-900"><?= $s['value'] ?></p>
            <p class="text-xs text-gray-500 mt-0.5"><?= $s['label'] ?></p>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Charts -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-5">
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Ingresos por Mes</h3>
            <canvas id="monthlyChart" height="180"></canvas>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 p-5">
            <h3 class="font-semibold text-gray-900 mb-4">Reservaciones por Deporte</h3>
            <canvas id="sportChart" height="180"></canvas>
        </div>
    </div>

    <!-- Recent clubs -->
    <div class="bg-white rounded-2xl border border-gray-100 p-5">
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-semibold text-gray-900">Clubes Recientes</h3>
            <a href="<?= BASE_URL ?>superadmin/clubs" class="text-sky-500 text-sm hover:underline">Ver todos →</a>
        </div>
        <div class="space-y-2">
            <?php foreach (array_slice($recentClubs ?? [], 0, 5) as $c): ?>
            <div class="flex items-center gap-3 py-2 border-b border-gray-50 last:border-0 text-sm">
                <div class="w-8 h-8 rounded-lg bg-violet-100 flex items-center justify-center text-sm font-bold text-violet-600">
                    <?= strtoupper(substr($c['name'], 0, 1)) ?>
                </div>
                <div class="flex-1">
                    <p class="font-medium"><?= htmlspecialchars($c['name']) ?></p>
                    <p class="text-xs text-gray-400"><?= htmlspecialchars($c['owner_name'] ?? '') ?></p>
                </div>
                <span class="px-2 py-1 rounded-full text-xs font-medium <?= $c['status'] === 'active' ? 'bg-green-100 text-green-700' : 'bg-amber-100 text-amber-700' ?>">
                    <?= $c['status'] === 'active' ? 'Activo' : ucfirst($c['status']) ?>
                </span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- Quick nav -->
    <div class="grid grid-cols-2 sm:grid-cols-5 gap-4">
        <?php $links = [
            ['href' => 'superadmin/clubs', 'icon' => '🏟️', 'label' => 'Clubes'],
            ['href' => 'superadmin/commissions', 'icon' => '💸', 'label' => 'Comisiones'],
            ['href' => 'superadmin/promotions', 'icon' => '🎁', 'label' => 'Promociones'],
            ['href' => 'superadmin/leads', 'icon' => '📊', 'label' => 'Leads'],
            ['href' => 'config', 'icon' => '⚙️', 'label' => 'Config'],
        ]; foreach ($links as $l): ?>
        <a href="<?= BASE_URL ?><?= $l['href'] ?>" class="bg-white border border-gray-100 rounded-2xl p-4 text-center hover:shadow-md transition-all">
            <p class="text-3xl mb-2"><?= $l['icon'] ?></p>
            <p class="text-sm font-medium text-gray-700"><?= $l['label'] ?></p>
        </a>
        <?php endforeach; ?>
    </div>
</div>

<script>
const mCtx = document.getElementById('monthlyChart');
if (mCtx) {
    new Chart(mCtx, {
        type: 'line',
        data: {
            labels: <?= json_encode($monthLabels ?? []) ?>,
            datasets: [{ label: 'Ingresos $', data: <?= json_encode($monthData ?? []) ?>, borderColor: '#0EA5E9', backgroundColor: 'rgba(14,165,233,0.1)', tension: 0.4, fill: true }]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { y: { beginAtZero: true } } }
    });
}
const sCtx = document.getElementById('sportChart');
if (sCtx) {
    new Chart(sCtx, {
        type: 'doughnut',
        data: {
            labels: <?= json_encode($sportLabels ?? []) ?>,
            datasets: [{ data: <?= json_encode($sportData ?? []) ?>, backgroundColor: ['#0EA5E9','#7C3AED','#10B981','#F59E0B','#EF4444'] }]
        },
        options: { responsive: true, maintainAspectRatio: false }
    });
}
</script>
