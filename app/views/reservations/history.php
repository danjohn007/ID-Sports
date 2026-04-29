<div class="space-y-5">
    <div class="flex items-center justify-between">
        <h2 class="text-lg font-semibold text-gray-900">📋 Historial de Reservaciones</h2>
        <a href="<?= BASE_URL ?>reservations/search" class="bg-sky-500 text-white text-sm px-4 py-2 rounded-xl hover:bg-sky-600 transition-all">+ Nueva</a>
    </div>

    <?php if (empty($reservations)): ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-12 text-center">
        <p class="text-5xl mb-4">📭</p>
        <p class="text-gray-500">No tienes reservaciones aún</p>
        <a href="<?= BASE_URL ?>reservations/search" class="mt-4 inline-block bg-sky-500 text-white px-5 py-2 rounded-xl text-sm hover:bg-sky-600 transition-all">Buscar Canchas</a>
    </div>
    <?php else: ?>
    <div class="space-y-3">
        <?php foreach ($reservations as $r): ?>
        <div class="bg-white border border-gray-100 rounded-2xl p-4 flex items-start gap-4 hover:shadow-sm transition-all">
            <div class="w-12 h-12 rounded-xl bg-sky-50 flex items-center justify-center text-2xl flex-shrink-0">
                <?= in_array($r['sport_type'] ?? '', ['football']) ? '⚽' : ($r['sport_type'] === 'padel' ? '🎾' : '🏃') ?>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <p class="font-semibold text-gray-900 text-sm"><?= htmlspecialchars($r['space_name'] ?? '') ?></p>
                        <p class="text-xs text-gray-500"><?= htmlspecialchars($r['club_name'] ?? '') ?></p>
                    </div>
                    <?php
                    $statusColors = [
                        'pending'     => 'bg-amber-100 text-amber-700',
                        'confirmed'   => 'bg-green-100 text-green-700',
                        'in_progress' => 'bg-sky-100 text-sky-700',
                        'cancelled'   => 'bg-red-100 text-red-700',
                        'completed'   => 'bg-gray-100 text-gray-600',
                        'active'      => 'bg-green-100 text-green-700',
                    ];
                    $statusLabels = [
                        'pending'     => 'Pendiente',
                        'confirmed'   => 'Confirmada',
                        'in_progress' => 'En Progreso',
                        'cancelled'   => 'Cancelada',
                        'completed'   => 'Completada',
                        'active'      => 'Activa',
                    ];
                    $status = $r['status'] ?? 'pending';
                    ?>
                    <span class="flex-shrink-0 text-xs font-medium px-2.5 py-1 rounded-full <?= $statusColors[$status] ?? 'bg-gray-100 text-gray-600' ?>">
                        <?= $statusLabels[$status] ?? ucfirst($status) ?>
                    </span>
                </div>
                <p class="text-xs text-gray-400 mt-1.5">
                    📅 <?= date('d/m/Y', strtotime($r['date'])) ?> &nbsp; 
                    🕐 <?= substr($r['start_time'], 0, 5) ?> – <?= substr($r['end_time'], 0, 5) ?>
                </p>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="font-bold text-gray-900">$<?= number_format($r['total'], 2) ?></p>
                <?php if ($status === 'confirmed' || $status === 'pending'): ?>
                <div style="display:flex;gap:0.5rem;margin-top:0.375rem">
                    <a href="<?= BASE_URL ?>reservations/confirm?id=<?= (int)$r['id'] ?>"
                       class="text-xs text-sky-500 hover:underline">Ver ticket</a>
                    <form method="POST" action="<?= BASE_URL ?>reservations/cancel"
                        onsubmit="return confirm('¿Cancelar esta reservación?')">
                        <input type="hidden" name="id" value="<?= $r['id'] ?>">
                        <button type="submit" class="text-xs text-red-500 hover:underline">Cancelar</button>
                    </form>
                </div>
                <?php endif; ?>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>
</div>
