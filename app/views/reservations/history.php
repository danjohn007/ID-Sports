<?php
/* ── Sport SVG helper (same as home) ─────────────────── */
if (!function_exists('sportSvgHist')) {
function sportSvgHist(string $type): string {
    $icons = [
        'football'      => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3v3.5M12 20.5v-3m-5-11l2.5 3M16.5 6l-2.5 3M4.5 15l3-1.5m9 0l3 1.5" stroke="currentColor" stroke-width="1.4"/>',
        'football_sala' => '<rect x="3" y="3" width="18" height="18" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.4"/>',
        'futbol_7'      => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M10 8h3l-1.5 3H13l-3 5" stroke="currentColor" stroke-width="1.4" fill="none"/>',
        'futbol_rapido' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M9 8l6 4-6 4V8z" fill="currentColor"/>',
        'padel'         => '<rect x="4" y="8" width="11" height="14" rx="3" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M15 11h2a2 2 0 012 2v0a2 2 0 01-2 2h-2" stroke="currentColor" stroke-width="1.8"/>',
        'tennis'        => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M3 12c0-3.3 2-6 4.5-6" stroke="currentColor" stroke-width="1.4"/><path d="M21 12c0 3.3-2 6-4.5 6" stroke="currentColor" stroke-width="1.4"/>',
        'basketball'    => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><line x1="12" y1="3" x2="12" y2="21" stroke="currentColor" stroke-width="1.4"/><line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.4"/>',
        'volleyball'    => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3c0 5 3 8 9 9" stroke="currentColor" stroke-width="1.4"/>',
        'swimming'      => '<path d="M3 17c1.5 0 3-1 4.5-1s3 1 4.5 1 3-1 4.5-1 3 1 4.5 1" stroke="currentColor" stroke-width="1.8" fill="none"/><circle cx="19" cy="5" r="2" fill="none" stroke="currentColor" stroke-width="1.8"/>',
        'gym'           => '<path d="M6 4v16M18 4v16M3 8h18M3 16h18" stroke="currentColor" stroke-width="1.8"/>',
        'other'         => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" fill="currentColor" opacity=".5"/>',
    ];
    return '<svg viewBox="0 0 24 24" width="22" height="22" xmlns="http://www.w3.org/2000/svg">' . ($icons[$type] ?? $icons['other']) . '</svg>';
}
}
?>

<style>
/* ── History page ─────────────────────────────────────── */
.hist-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 1.375rem;
}
.hist-title {
    font-family: 'Jockey One', sans-serif;
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--text-pri);
    margin: 0;
}

/* ── Two-box side-by-side grid ───────────────────────── */
.hist-boxes-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    height: 75vh;
}
.hist-box {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.25rem;
    overflow: hidden;
    display: flex;
    flex-direction: column;
    height: 100%;
    min-height: 200px;
    padding-bottom: 1.5rem;
}
.hist-box-active {
    border-color: rgba(var(--primary-rgb), 0.3);
}
.hist-box-header {
    padding: 1rem 1rem 0;
    flex-shrink: 0;
}
.hist-box-filters {
    padding: 0 1rem 0.75rem;
    flex-shrink: 0;
    border-bottom: 1px solid rgba(255,255,255,0.06);
}
.hist-box-scroll {
    flex: 1;
    min-height: 0;      /* critical: lets flex child shrink so overflow-y activates */
    overflow-y: auto;
    overflow-x: hidden;
    padding: 0.875rem 1rem;
    display: flex;
    flex-direction: column;
    gap: 0.75rem;
    scrollbar-width: thin;
    scrollbar-color: rgba(var(--primary-rgb),0.25) transparent;
}
.hist-box-scroll::-webkit-scrollbar { width: 4px; }
.hist-box-scroll::-webkit-scrollbar-track { background: transparent; }
.hist-box-scroll::-webkit-scrollbar-thumb { background: rgba(var(--primary-rgb),0.3); border-radius: 4px; }
/* Mobile: stack vertically, remove fixed height */
@media (max-width: 767px) {
    .hist-boxes-grid { grid-template-columns: 1fr; gap: 0.875rem; height: auto; }
    .hist-box { height: auto; max-height: none; }
    .hist-box-scroll { max-height: 70vh; }
}
/* Filter row inside each box */
.hist-box-filter-row {
    display: flex;
    flex-wrap: wrap;
    gap: 0.4rem;
    margin-top: 0.625rem;
}
.hist-box-filter-input {
    background: var(--bg-mid);
    border: 1px solid var(--border-gl);
    border-radius: 0.75rem;
    padding: 0.45rem 0.7rem 0.45rem 2rem;
    font-size: 0.78rem;
    color: var(--text-pri);
    outline: none;
    width: 100%;
    box-sizing: border-box;
}
.hist-box-filter-date,
.hist-box-filter-select {
    background: var(--bg-mid);
    border: 1px solid var(--border-gl);
    border-radius: 0.75rem;
    padding: 0.45rem 0.7rem;
    font-size: 0.78rem;
    color: var(--text-pri);
    outline: none;
    cursor: pointer;
    flex-shrink: 0;
}
.hist-badge {
    display: inline-flex;
    align-items: center;
    gap: 0.3rem;
    font-size: 0.7rem;
    font-weight: 700;
    padding: 0.2rem 0.6rem;
    border-radius: 20px;
    white-space: nowrap;
}
.hist-badge-confirmed      { background: rgba(16,185,129,0.15);  color: #10b981; }
.hist-badge-active         { background: rgba(16,185,129,0.15);  color: #10b981; }
.hist-badge-in_progress    { background: rgba(14,165,233,0.15);  color: #38bdf8; }
.hist-badge-pending        { background: rgba(245,158,11,0.15);  color: #f59e0b; }
.hist-badge-cancelled      { background: rgba(239,68,68,0.15);   color: #f87171; }
.hist-badge-completed      { background: rgba(148,163,184,0.12); color: #94a3b8; }
.hist-badge-refund_pending { background: rgba(245,158,11,0.18);  color: #fbbf24; }

/* Glassmorphism reservation card */
.hist-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.25rem;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    overflow: hidden;
    transition: all 180ms ease;
    margin-bottom: 0.75rem;
    flex-shrink: 0;  /* prevent flex from squishing cards when many are present */
}
.hist-card:hover {
    background: var(--bg-card-hover);
    border-color: rgba(var(--primary-rgb), 0.35);
    transform: translateY(-2px);
    box-shadow: 0 10px 28px rgba(0,0,0,0.28);
}
.hist-card-body {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.9375rem 1rem;
}
.hist-icon {
    flex-shrink: 0;
    width: 2.875rem;
    height: 2.875rem;
    border-radius: 0.875rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}
.hist-info { flex: 1; min-width: 0; }
.hist-info-name {
    font-weight: 600;
    font-size: 0.9375rem;
    color: var(--text-pri);
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
    margin: 0;
}
.hist-info-sub {
    font-size: 0.75rem;
    color: var(--text-sec);
    margin: 0.15rem 0 0;
}
.hist-info-date {
    font-size: 0.72rem;
    color: var(--text-muted);
    margin: 0.125rem 0 0;
}
.hist-right { text-align: right; flex-shrink: 0; }
.hist-total {
    font-weight: 800;
    font-size: 1rem;
    color: var(--text-pri);
    margin: 0 0 0.3rem;
}
.hist-action-bar {
    display: flex;
    gap: 0.5rem;
    padding: 0 1rem 0.875rem;
    justify-content: flex-end;
}
.hist-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.35rem;
    font-size: 0.78rem;
    font-weight: 600;
    padding: 0.375rem 0.875rem;
    border-radius: 0.625rem;
    border: 1px solid var(--border-gl2);
    background: rgba(var(--primary-rgb), 0.08);
    color: var(--primary);
    cursor: pointer;
    text-decoration: none;
    transition: all 140ms;
}
.hist-btn:hover { background: rgba(var(--primary-rgb), 0.18); border-color: rgba(var(--primary-rgb), 0.5); }
.hist-btn-cancel {
    background: rgba(239,68,68,0.08);
    color: #f87171;
    border-color: rgba(239,68,68,0.2);
}
.hist-btn-cancel:hover { background: rgba(239,68,68,0.18); border-color: rgba(239,68,68,0.4); }

/* ── Ticket Modal (centered) ─────────────────────────── */
.hist-modal-backdrop {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,0.72);
    backdrop-filter: blur(6px);
    -webkit-backdrop-filter: blur(6px);
    z-index: 9000;
    align-items: center;
    justify-content: center;
    padding: 1rem;
}
.hist-modal-sheet {
    background: var(--bg-mid);
    border-radius: 1.5rem;
    padding: 1.375rem 1.25rem 2rem;
    width: 100%;
    max-width: 420px;
    max-height: 92vh;
    overflow-y: auto;
    position: relative;
    animation: popIn 220ms ease;
}
@keyframes popIn {
    from { transform: scale(0.92); opacity: 0; }
    to   { transform: scale(1);    opacity: 1; }
}
.hist-ticket-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl2);
    border-radius: 1.25rem;
    overflow: hidden;
    box-shadow: 0 12px 40px rgba(0,0,0,0.4);
}
.hist-ticket-head {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    padding: 1.125rem 1.25rem;
    color: #fff;
}
.hist-ticket-body {
    padding: 1rem 1.25rem;
}
.hist-ticket-row {
    display: flex;
    justify-content: space-between;
    align-items: center;
    font-size: 0.8125rem;
    margin-bottom: 0.45rem;
}
.hist-ticket-label { color: var(--text-muted); }
.hist-ticket-value { font-weight: 600; color: var(--text-pri); }
.hist-ticket-dashed { border: none; border-top: 1px dashed rgba(255,255,255,0.12); margin: 0.625rem 0; }
.hist-ticket-punch {
    position: relative;
    border-top: 1.5px dashed rgba(255,255,255,0.1);
    margin: 0.5rem -1.25rem;
}
.hist-ticket-punch::before { content:''; position:absolute; left:-0.75rem; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; border-radius:50%; background:var(--bg-mid); }
.hist-ticket-punch::after  { content:''; position:absolute; right:-0.75rem; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; border-radius:50%; background:var(--bg-mid); }
.hist-ticket-qr { text-align: center; padding: 0.875rem 1.25rem 1.125rem; }

/* Empty state */
.hist-empty {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.25rem;
    padding: 3rem 1.5rem;
    text-align: center;
}
/* 2-col grid on medium+ screens */
@media (min-width: 768px) {
    .hist-grid { grid-template-columns: repeat(2, 1fr) !important; }
}
</style>

<div class="space-y-5">
    <!-- Header -->
    <div class="hist-header">
        <h2 class="hist-title">Historial de Reservaciones</h2>
        <a href="<?= BASE_URL ?>reservations/search"
           style="display:inline-flex;align-items:center;gap:0.375rem;font-size:0.8125rem;font-weight:600;color:var(--primary);text-decoration:none;background:rgba(var(--primary-rgb),0.1);border:1px solid rgba(var(--primary-rgb),0.25);padding:0.4rem 0.875rem;border-radius:0.625rem;transition:all 140ms"
           onmouseover="this.style.background='rgba(var(--primary-rgb),0.2)'"
           onmouseout="this.style.background='rgba(var(--primary-rgb),0.1)'">
            <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            Buscar canchas
        </a>
    </div>

    <!-- Stats row -->
    <?php if (!empty($monthlyStats)): ?>
    <div style="display:grid;grid-template-columns:repeat(3,1fr);gap:0.625rem;margin-bottom:0.25rem">
        <?php
        $totalSpent = array_sum(array_column($monthlyStats, 'total'));
        $totalCount = array_sum(array_column($monthlyStats, 'count'));
        $thisMonth  = !empty($monthlyStats[0]) ? $monthlyStats[0] : ['total'=>0,'count'=>0];
        ?>
        <div style="background:var(--bg-card);border:1px solid var(--border-gl);border-radius:1rem;padding:0.75rem;text-align:center">
            <p style="font-family:'Jockey One',sans-serif;font-size:1.375rem;color:var(--primary);margin:0"><?= $totalCount ?></p>
            <p style="font-size:0.68rem;color:var(--text-muted);margin:0.2rem 0 0">Total reservas</p>
        </div>
        <div style="background:var(--bg-card);border:1px solid var(--border-gl);border-radius:1rem;padding:0.75rem;text-align:center">
            <p style="font-family:'Jockey One',sans-serif;font-size:1.25rem;color:var(--primary);margin:0">$<?= number_format($totalSpent,0) ?></p>
            <p style="font-size:0.68rem;color:var(--text-muted);margin:0.2rem 0 0">Total gastado</p>
        </div>
        <div style="background:var(--bg-card);border:1px solid var(--border-gl);border-radius:1rem;padding:0.75rem;text-align:center">
            <p style="font-family:'Jockey One',sans-serif;font-size:1.25rem;color:var(--primary);margin:0"><?= (int)$thisMonth['count'] ?></p>
            <p style="font-size:0.68rem;color:var(--text-muted);margin:0.2rem 0 0">Este mes</p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Reservation list -->
    <?php if (empty($reservations)): ?>
    <div class="hist-empty">
        <svg width="44" height="44" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.2" style="margin-bottom:0.875rem">
            <rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/>
        </svg>
        <p style="font-family:'Jockey One',sans-serif;font-size:1.0625rem;color:var(--text-pri);margin:0 0 0.375rem">Sin reservaciones aún</p>
        <p style="font-size:0.8125rem;color:var(--text-sec);margin:0 0 1.25rem">Encuentra la cancha perfecta y empieza a jugar</p>
        <a href="<?= BASE_URL ?>reservations/search"
           style="display:inline-flex;align-items:center;gap:0.5rem;background:var(--primary);color:#fff;font-weight:700;font-size:0.8125rem;padding:0.6rem 1.25rem;border-radius:0.875rem;text-decoration:none">
            Buscar Canchas
        </a>
    </div>
    <?php else:
    $statusLabels = [
        'pending'        => ['label'=>'Pendiente',            'class'=>'hist-badge-pending'],
        'confirmed'      => ['label'=>'Confirmada',           'class'=>'hist-badge-confirmed'],
        'in_progress'    => ['label'=>'En curso',             'class'=>'hist-badge-in_progress'],
        'cancelled'      => ['label'=>'Cancelada',            'class'=>'hist-badge-cancelled'],
        'completed'      => ['label'=>'Completada',           'class'=>'hist-badge-completed'],
        'active'         => ['label'=>'Activa',               'class'=>'hist-badge-active'],
        'refund_pending' => ['label'=>'Reembolso pendiente',  'class'=>'hist-badge-refund_pending'],
    ];
    $activeStatuses   = ['confirmed','pending','in_progress','active'];
    $finishedStatuses = ['completed','cancelled','refund_pending'];
    $today   = date('Y-m-d');
    $nowTime = date('H:i:s');
    // Box A: active status AND (future date OR today with time still remaining)
    $resActive = array_values(array_filter($reservations, function($r) use ($activeStatuses, $today, $nowTime) {
        if (!in_array($r['status'] ?? '', $activeStatuses)) return false;
        $d = $r['date'] ?? '';
        return $d > $today || ($d === $today && ($r['end_time'] ?? '00:00:00') > $nowTime);
    }));
    // Box B: everything else (finished statuses + past-dated "active" ones)
    $activeIds   = array_map('intval', array_column($resActive, 'id'));
    $resFinished = array_values(array_filter($reservations, fn($r) => !in_array((int)$r['id'], $activeIds)));

    ?>

    <?php
    /* Helper to render a single history card */
    function renderHistCard(array $r, array $statusLabels): void {
        $status    = $r['status'] ?? 'pending';

        // Compute visual display status based on actual date/time
        $today     = date('Y-m-d');
        $nowTime   = date('H:i:s');
        $d         = $r['date'] ?? '';
        $startTime = $r['start_time'] ?? '00:00:00';
        $endTime   = $r['end_time']   ?? '00:00:00';

        $visualStatus = $status;
        if (in_array($status, ['confirmed', 'active', 'pending', 'in_progress'])) {
            if ($d > $today) {
                $visualStatus = 'confirmed';      // future → Confirmada
            } elseif ($d === $today && $nowTime >= $startTime && $nowTime < $endTime) {
                $visualStatus = 'in_progress';    // currently happening → En curso
            } elseif ($d < $today || ($d === $today && $endTime <= $nowTime)) {
                $visualStatus = 'completed';      // already over → Completada
            }
        }

        $badge     = $statusLabels[$visualStatus] ?? $statusLabels[$status] ?? ['label'=>ucfirst($status),'class'=>'hist-badge-completed'];
        $rid       = (int)$r['id'];
        $spaceCost = (float)($r['subtotal'] ?? 0);
        $iva       = (float)($r['service_fee'] ?? 0);
        $total     = (float)($r['total'] ?? 0);
        $qrData    = htmlspecialchars($r['qr_code'] ?? ('RES-'.$rid), ENT_QUOTES);
        $amenDetails = htmlspecialchars(json_encode($r['amenities_details'] ?? [], JSON_UNESCAPED_UNICODE), ENT_QUOTES);
        $searchAttr  = strtolower(
            htmlspecialchars(($r['space_name'] ?? ''), ENT_QUOTES) . ' ' .
            htmlspecialchars(($r['sport_type']  ?? ''), ENT_QUOTES) . ' ' .
            htmlspecialchars(($r['club_name']   ?? ''), ENT_QUOTES)
        );
        $resDate = date('d/m/Y', strtotime($r['date']));
        $openTicketCall = "openHistTicket({$rid},'".htmlspecialchars($r['space_name'],ENT_QUOTES)."','".htmlspecialchars($r['club_name']??'',ENT_QUOTES)."','{$resDate}','".substr($r['start_time'],0,5).' – '.substr($r['end_time'],0,5)."',{$spaceCost},{$iva},{$total},'{$qrData}',{$amenDetails})";
        ?>
        <div class="hist-card" style="margin-bottom:0"
             data-search="<?= $searchAttr ?>"
             data-status="<?= htmlspecialchars($status, ENT_QUOTES) ?>"
             data-date="<?= htmlspecialchars($r['date'], ENT_QUOTES) ?>">
            <div class="hist-card-body">
                <div class="hist-icon"><?= sportSvgHist($r['sport_type'] ?? 'football') ?></div>
                <div class="hist-info">
                    <p class="hist-info-name"><?= htmlspecialchars($r['space_name'] ?? '') ?></p>
                    <p class="hist-info-sub"><?= htmlspecialchars($r['club_name'] ?? '') ?></p>
                    <p class="hist-info-date">
                        <?= $resDate ?> &middot; <?= substr($r['start_time'],0,5) ?> – <?= substr($r['end_time'],0,5) ?>
                    </p>
                </div>
                <div class="hist-right">
                    <span class="hist-badge <?= $badge['class'] ?>"><?= $badge['label'] ?></span>
                    <p class="hist-total" style="margin-top:0.375rem">$<?= number_format($total, 2) ?></p>
                </div>
            </div>
            <div class="hist-action-bar">
                <button class="hist-btn" onclick="<?= $openTicketCall ?>">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                    Ver ticket
                </button>
                <?php if (in_array($status, ['confirmed','pending'])): ?>
                <button class="hist-btn hist-btn-cancel" onclick="openCancelModal(<?= $rid ?>, '<?= htmlspecialchars($r['space_name'],ENT_QUOTES) ?>')">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Cancelar
                </button>
                <?php endif; ?>
            </div>
        </div>
        <?php
    }
    ?>

    <!-- ── Side-by-side grid wrapper ───────────────────── -->
    <div class="hist-boxes-grid">

    <!-- BOX A: Reservas Activas -->
    <div class="hist-box hist-box-active">
        <div class="hist-box-header">
            <div style="display:flex;align-items:center;gap:0.5rem">
                <span style="width:0.5rem;height:0.5rem;border-radius:50%;background:#10b981;display:inline-block;box-shadow:0 0 6px #10b981"></span>
                <h3 style="font-family:'Jockey One',sans-serif;font-size:0.9375rem;color:var(--text-pri);margin:0">Reservas Activas</h3>
                <span style="font-size:0.68rem;font-weight:700;background:rgba(16,185,129,0.15);color:#10b981;padding:0.12rem 0.45rem;border-radius:20px;margin-left:auto"><?= count($resActive) ?></span>
            </div>
        </div>
        <div class="hist-box-filters">
            <div class="hist-box-filter-row">
                <div style="flex:1;min-width:0;position:relative">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute;left:0.625rem;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchBoxA" placeholder="Buscar cancha…" oninput="filterBox('A')" class="hist-box-filter-input">
                </div>
                <input type="date" id="dateBoxA" onchange="filterBox('A')" class="hist-box-filter-date">
                <select id="statusBoxA" onchange="filterBox('A')" class="hist-box-filter-select">
                    <option value="">Estado</option>
                    <option value="confirmed">Confirmada</option>
                    <option value="pending">Pendiente</option>
                    <option value="in_progress">En curso</option>
                    <option value="active">Activa</option>
                </select>
            </div>
        </div>
        <div class="hist-box-scroll" id="gridBoxA">
            <?php if (empty($resActive)): ?>
            <p style="font-size:0.8rem;color:var(--text-muted);text-align:center;padding:2rem 0">No hay reservas activas</p>
            <?php else: foreach ($resActive as $r): renderHistCard($r, $statusLabels); endforeach; endif; ?>
        </div>
    </div>

    <!-- BOX B: Finalizadas / Canceladas -->
    <div class="hist-box">
        <div class="hist-box-header">
            <div style="display:flex;align-items:center;gap:0.5rem">
                <span style="width:0.5rem;height:0.5rem;border-radius:50%;background:#94a3b8;display:inline-block"></span>
                <h3 style="font-family:'Jockey One',sans-serif;font-size:0.9375rem;color:var(--text-pri);margin:0">Finalizadas / Canceladas</h3>
                <span style="font-size:0.68rem;font-weight:700;background:rgba(148,163,184,0.15);color:#94a3b8;padding:0.12rem 0.45rem;border-radius:20px;margin-left:auto"><?= count($resFinished) ?></span>
            </div>
        </div>
        <div class="hist-box-filters">
            <div class="hist-box-filter-row">
                <div style="flex:1;min-width:0;position:relative">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="position:absolute;left:0.625rem;top:50%;transform:translateY(-50%);color:var(--text-muted);pointer-events:none"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" id="searchBoxB" placeholder="Buscar cancha…" oninput="filterBox('B')" class="hist-box-filter-input">
                </div>
                <input type="date" id="dateBoxB" onchange="filterBox('B')" class="hist-box-filter-date">
                <select id="statusBoxB" onchange="filterBox('B')" class="hist-box-filter-select">
                    <option value="">Estado</option>
                    <option value="completed">Completada</option>
                    <option value="cancelled">Cancelada</option>
                    <option value="refund_pending">Reembolso pend.</option>
                </select>
            </div>
        </div>
        <div class="hist-box-scroll" id="gridBoxB">
            <?php if (empty($resFinished)): ?>
            <p style="font-size:0.8rem;color:var(--text-muted);text-align:center;padding:2rem 0">Sin reservas finalizadas</p>
            <?php else: foreach ($resFinished as $r): renderHistCard($r, $statusLabels); endforeach; endif; ?>
        </div>
    </div>

    </div><!-- /.hist-boxes-grid -->

    <?php endif; ?>
</div>

<!-- ── Cancel Reason Modal ───────────────────────────────────── -->
<div id="cancelModal" style="display:none;position:fixed;inset:0;background:rgba(0,0,0,0.75);backdrop-filter:blur(6px);-webkit-backdrop-filter:blur(6px);z-index:70;align-items:center;justify-content:center;padding:1.25rem" onclick="closeCancelModal()">
    <div style="background:var(--bg-mid);border:1px solid var(--border-gl2);border-radius:1.25rem;padding:1.375rem;max-width:340px;width:100%;position:relative;box-shadow:0 24px 60px rgba(0,0,0,0.6)" onclick="event.stopPropagation()">
        <button onclick="closeCancelModal()" style="position:absolute;top:1rem;right:1rem;background:var(--bg-card);border:1px solid var(--border-gl2);border-radius:0.5rem;width:2rem;height:2rem;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-sec)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <div style="display:flex;align-items:center;gap:0.625rem;margin-bottom:0.875rem">
            <span style="width:2.25rem;height:2.25rem;background:rgba(245,158,11,0.15);border-radius:0.75rem;display:flex;align-items:center;justify-content:center;color:#f59e0b;flex-shrink:0">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/><line x1="12" y1="9" x2="12" y2="13"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>
            </span>
            <div>
                <h3 style="font-family:'Jockey One',sans-serif;font-size:1rem;color:var(--text-pri);margin:0">Solicitar Cancelación</h3>
                <p id="cancelSpaceName" style="font-size:0.75rem;color:var(--text-muted);margin:0"></p>
            </div>
        </div>
        <p style="font-size:0.8rem;color:var(--text-sec);margin:0 0 1rem;line-height:1.5">Esta solicitud será enviada al administrador del club para revisión y aprobación del reembolso.</p>
        <label style="font-size:0.8rem;font-weight:600;color:var(--text-pri);display:block;margin-bottom:0.375rem">Motivo de cancelación <span style="color:#f87171">*</span></label>
        <textarea id="cancelReason" rows="3" placeholder="Describe el motivo de tu cancelación..."
                  style="width:100%;box-sizing:border-box;background:var(--bg-card);border:1px solid var(--border-gl);border-radius:0.875rem;padding:0.75rem;font-size:0.85rem;color:var(--text-pri);outline:none;resize:vertical;transition:border-color 140ms;font-family:inherit"
                  onfocus="this.style.borderColor='rgba(var(--primary-rgb),0.5)'"
                  onblur="this.style.borderColor='var(--border-gl)'"></textarea>
        <p id="cancelReasonErr" style="color:#f87171;font-size:0.75rem;margin:0.25rem 0 0;display:none">El motivo es obligatorio.</p>
        <form id="cancelForm" method="POST" action="<?= BASE_URL ?>reservations/cancel" style="margin-top:0.875rem;display:grid;grid-template-columns:1fr 1fr;gap:0.5rem">
            <input type="hidden" id="cancelResId" name="id" value="">
            <input type="hidden" id="cancelReasonHidden" name="cancel_reason" value="">
            <button type="button" onclick="closeCancelModal()" style="font-size:0.8125rem;font-weight:600;color:var(--text-sec);background:var(--bg-card);border:1px solid var(--border-gl2);padding:0.625rem;border-radius:0.75rem;cursor:pointer">Mantener</button>
            <button type="button" onclick="submitCancelReason()" style="font-size:0.8125rem;font-weight:700;color:#fff;background:#ef4444;border:none;padding:0.625rem;border-radius:0.75rem;cursor:pointer;transition:background 140ms" onmouseover="this.style.background='#dc2626'" onmouseout="this.style.background='#ef4444'">
                Solicitar cancelación
            </button>
        </form>
    </div>
</div>

<!-- ── Ticket Modal ─────────────────────────────────────── -->
<div id="histModal" class="hist-modal-backdrop" onclick="closeHistTicket()">
    <div class="hist-modal-sheet" onclick="event.stopPropagation()">
        <button onclick="closeHistTicket()"
                style="position:absolute;top:1rem;right:1rem;background:var(--bg-card);border:1px solid var(--border-gl2);border-radius:0.5rem;width:2rem;height:2rem;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--text-sec)">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
        </button>
        <h3 style="font-family:'Jockey One',sans-serif;font-size:1.125rem;color:var(--text-pri);margin:0 0 1.125rem">Ticket de Reserva</h3>

        <div class="hist-ticket-card">
            <!-- Gradient head -->
            <div class="hist-ticket-head">
                <p style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:rgba(255,255,255,0.65);margin:0 0 0.25rem">Ticket de Reserva</p>
                <h3 id="hTicketSpace" style="font-family:'Jockey One',sans-serif;font-size:1.25rem;color:#fff;margin:0 0 0.125rem"></h3>
                <p id="hTicketClub" style="font-size:0.8rem;color:rgba(255,255,255,0.65);margin:0"></p>
            </div>
            <!-- Body -->
            <div class="hist-ticket-body">
                <div class="hist-ticket-row">
                    <span class="hist-ticket-label">Fecha</span>
                    <span class="hist-ticket-value" id="hTicketDate"></span>
                </div>
                <div class="hist-ticket-row">
                    <span class="hist-ticket-label">Horario</span>
                    <span class="hist-ticket-value" id="hTicketTime"></span>
                </div>
                <hr class="hist-ticket-dashed">
                <p style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin:0 0 0.5rem">Desglose de Pago</p>
                <div class="hist-ticket-row">
                    <span class="hist-ticket-label">Cancha</span>
                    <span class="hist-ticket-value" id="hTicketCancha"></span>
                </div>
                <!-- Per-amenity rows rendered by JS -->
                <div id="hTicketAmenContainer"></div>
                <div class="hist-ticket-row">
                    <span class="hist-ticket-label" style="font-weight:600;color:var(--text-pri)">Subtotal</span>
                    <span class="hist-ticket-value" id="hTicketSubtotal"></span>
                </div>
                <div class="hist-ticket-row">
                    <span class="hist-ticket-label">IVA (16%)</span>
                    <span class="hist-ticket-value" id="hTicketIva"></span>
                </div>
                <hr class="hist-ticket-dashed">
                <div style="display:flex;justify-content:space-between;align-items:baseline;margin-top:0.25rem">
                    <span style="font-size:0.875rem;font-weight:700;color:var(--text-pri)">Total Pagado</span>
                    <span id="hTicketTotal" style="font-size:1.375rem;font-weight:800;color:#10b981"></span>
                </div>
            </div>
            <!-- Punch hole -->
            <div class="hist-ticket-punch"></div>
            <!-- QR -->
            <div class="hist-ticket-qr">
                <p style="font-size:0.72rem;color:var(--text-muted);margin:0 0 0.625rem">Muestra este QR en la entrada del club</p>
                <div style="background:#fff;border-radius:0.75rem;padding:0.5rem;display:inline-block" id="hTicketQrCanvas"></div>
                <p id="hTicketQrCode" style="font-family:monospace;font-size:0.6rem;color:var(--text-muted);word-break:break-all;margin-top:0.375rem"></p>
            </div>
        </div>

        <!-- Actions -->
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:0.625rem;margin-top:0.875rem">
            <button onclick="window.print()" style="display:flex;align-items:center;justify-content:center;gap:0.375rem;font-size:0.8125rem;font-weight:600;color:var(--text-sec);background:var(--bg-card);border:1px solid var(--border-gl2);padding:0.625rem;border-radius:0.75rem;cursor:pointer;transition:all 140ms" onmouseover="this.style.borderColor='rgba(var(--primary-rgb),0.4)'" onmouseout="this.style.borderColor='var(--border-gl2)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Imprimir
            </button>
            <button id="hShareBtn" style="display:flex;align-items:center;justify-content:center;gap:0.375rem;font-size:0.8125rem;font-weight:600;color:var(--primary);background:rgba(var(--primary-rgb),0.1);border:1px solid rgba(var(--primary-rgb),0.25);padding:0.625rem;border-radius:0.75rem;cursor:pointer;transition:all 140ms" onmouseover="this.style.background='rgba(var(--primary-rgb),0.2)'" onmouseout="this.style.background='rgba(var(--primary-rgb),0.1)'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                Compartir
            </button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
var _fmt = new Intl.NumberFormat('es-MX', {style:'currency', currency:'MXN'});

function openHistTicket(id, spaceName, clubName, dateLabel, timeLabel, spaceCost, iva, total, qrCode, amenitiesDetails) {
    document.getElementById('hTicketSpace').textContent = spaceName;
    document.getElementById('hTicketClub').textContent  = clubName;
    document.getElementById('hTicketDate').textContent  = dateLabel;
    document.getElementById('hTicketTime').textContent  = timeLabel;
    document.getElementById('hTicketCancha').textContent = _fmt.format(spaceCost);

    // Render per-amenity rows (safe DOM, no innerHTML)
    var amenContainer = document.getElementById('hTicketAmenContainer');
    amenContainer.innerHTML = '';
    var amenTotal = 0;
    if (amenitiesDetails && amenitiesDetails.length > 0) {
        amenitiesDetails.forEach(function(a) {
            var sub = parseFloat(a.subtotal);
            amenTotal += sub;
            var row = document.createElement('div');
            row.className = 'hist-ticket-row';
            var s1 = document.createElement('span');
            s1.className = 'hist-ticket-label';
            s1.style.cssText = 'padding-left:0.75rem;color:var(--text-sec)';
            s1.textContent = a.name + ' \u00d7' + a.quantity;
            var s2 = document.createElement('span');
            s2.className = 'hist-ticket-value';
            s2.textContent = _fmt.format(sub);
            row.appendChild(s1); row.appendChild(s2);
            amenContainer.appendChild(row);
        });
    }

    var subT = spaceCost + amenTotal;
    document.getElementById('hTicketSubtotal').textContent = _fmt.format(subT);
    document.getElementById('hTicketIva').textContent      = _fmt.format(iva);
    document.getElementById('hTicketTotal').textContent    = _fmt.format(total);
    document.getElementById('hTicketQrCode').textContent   = qrCode;

    var wrap = document.getElementById('hTicketQrCanvas');
    wrap.innerHTML = '';
    if (qrCode) {
        var canvas = document.createElement('canvas');
        wrap.appendChild(canvas);
        QRCode.toCanvas(canvas, qrCode, {width:160, margin:1, color:{dark:'#000',light:'#fff'}}, function(){});
    }

    document.getElementById('hShareBtn').onclick = function() {
        var text = '¡Reserva confirmada!\n' + spaceName + ' (' + clubName + ')\n' + dateLabel + ' ' + timeLabel + '\nTotal: ' + _fmt.format(total);
        if (navigator.share) { navigator.share({title:'Ticket ID Sports', text:text}); }
        else if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function() { alert('Información copiada al portapapeles'); });
        }
    };

    var modal = document.getElementById('histModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}

function closeHistTicket() {
    document.getElementById('histModal').style.display = 'none';
    document.getElementById('hTicketQrCanvas').innerHTML = '';
    document.body.style.overflow = '';
}

/* ── Cancel Reason Modal ──────────────────────────────── */
function openCancelModal(reservationId, spaceName) {
    document.getElementById('cancelResId').value    = reservationId;
    document.getElementById('cancelSpaceName').textContent = spaceName;
    document.getElementById('cancelReason').value   = '';
    document.getElementById('cancelReasonErr').style.display = 'none';
    var modal = document.getElementById('cancelModal');
    modal.style.display = 'flex';
    document.body.style.overflow = 'hidden';
}
function closeCancelModal() {
    document.getElementById('cancelModal').style.display = 'none';
    document.body.style.overflow = '';
}
function submitCancelReason() {
    var reason = document.getElementById('cancelReason').value.trim();
    var errEl  = document.getElementById('cancelReasonErr');
    if (!reason) { errEl.style.display = 'block'; return; }
    errEl.style.display = 'none';
    document.getElementById('cancelReasonHidden').value = reason;
    document.getElementById('cancelForm').submit();
}

/* ── Box filters ─────────────────────────────────────── */
function filterBox(box) {
    var q      = (document.getElementById('searchBox' + box).value || '').toLowerCase().trim();
    var date   = (document.getElementById('dateBox'   + box).value || '').trim();
    var status = (document.getElementById('statusBox' + box).value || '').trim();
    var grid   = document.getElementById('gridBox' + box);
    if (!grid) return;
    grid.querySelectorAll('.hist-card').forEach(function(card) {
        var matchQ   = !q      || (card.getAttribute('data-search') || '').indexOf(q) !== -1;
        var matchD   = !date   || card.getAttribute('data-date') === date;
        var matchS   = !status || card.getAttribute('data-status') === status;
        card.style.display = (matchQ && matchD && matchS) ? '' : 'none';
        card.style.transition = 'opacity 200ms';
        card.style.opacity = (matchQ && matchD && matchS) ? '1' : '0';
    });
}

/* ── Auto-complete polling (every 60 s) ──────────────── */
function autoCompletePolling() {
    fetch('<?= BASE_URL ?>reservations/autoComplete')
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data && data.success && data.completed > 0) {
                location.reload();
            }
        })
        .catch(function() {});
}
setInterval(autoCompletePolling, 60000);
</script>
