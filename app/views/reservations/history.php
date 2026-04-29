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

/* Status badge */
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
.hist-badge-confirmed   { background: rgba(16,185,129,0.15);  color: #10b981; }
.hist-badge-active      { background: rgba(16,185,129,0.15);  color: #10b981; }
.hist-badge-in_progress { background: rgba(14,165,233,0.15);  color: #38bdf8; }
.hist-badge-pending     { background: rgba(245,158,11,0.15);  color: #f59e0b; }
.hist-badge-cancelled   { background: rgba(239,68,68,0.15);   color: #f87171; }
.hist-badge-completed   { background: rgba(148,163,184,0.12); color: #94a3b8; }

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
    <?php else: ?>

    <?php
    $statusLabels = [
        'pending'     => ['label'=>'Pendiente',   'class'=>'hist-badge-pending'],
        'confirmed'   => ['label'=>'Confirmada',  'class'=>'hist-badge-confirmed'],
        'in_progress' => ['label'=>'En curso',    'class'=>'hist-badge-in_progress'],
        'cancelled'   => ['label'=>'Cancelada',   'class'=>'hist-badge-cancelled'],
        'completed'   => ['label'=>'Completada',  'class'=>'hist-badge-completed'],
        'active'      => ['label'=>'Activa',      'class'=>'hist-badge-active'],
    ];
    ?>
    <div class="hist-grid" style="display:grid;grid-template-columns:repeat(1,1fr);gap:1rem">
    <?php foreach ($reservations as $r):
        $status = $r['status'] ?? 'pending';
        $badge  = $statusLabels[$status] ?? ['label'=>ucfirst($status),'class'=>'hist-badge-completed'];
        $rid    = (int)$r['id'];
        $spaceCost = (float)($r['subtotal'] ?? 0);
        $amenCost  = (float)($r['amenities_total'] ?? 0);
        $iva       = (float)($r['service_fee'] ?? 0);
        $total     = (float)($r['total'] ?? 0);
        $qrData    = htmlspecialchars($r['qr_code'] ?? ('RES-'.$rid), ENT_QUOTES);
        $hasQr     = in_array($status, ['confirmed','active','in_progress','pending']);
        $amenDetails = json_encode($r['amenities_details'] ?? [], JSON_UNESCAPED_UNICODE);
    ?>
    <div class="hist-card" style="margin-bottom:0">
        <div class="hist-card-body">
            <div class="hist-icon">
                <?= sportSvgHist($r['sport_type'] ?? 'football') ?>
            </div>
            <div class="hist-info">
                <p class="hist-info-name"><?= htmlspecialchars($r['space_name'] ?? '') ?></p>
                <p class="hist-info-sub"><?= htmlspecialchars($r['club_name'] ?? '') ?></p>
                <p class="hist-info-date">
                    <?= date('d/m/Y', strtotime($r['date'])) ?>
                    &middot;
                    <?= substr($r['start_time'],0,5) ?> – <?= substr($r['end_time'],0,5) ?>
                </p>
            </div>
            <div class="hist-right">
                <span class="hist-badge <?= $badge['class'] ?>"><?= $badge['label'] ?></span>
                <p class="hist-total" style="margin-top:0.375rem">$<?= number_format($total, 2) ?></p>
            </div>
        </div>

        <!-- Action bar -->
        <div class="hist-action-bar">
            <?php if ($hasQr): ?>
            <button class="hist-btn" onclick="openHistTicket(<?= $rid ?>, '<?= htmlspecialchars($r['space_name'],ENT_QUOTES) ?>', '<?= htmlspecialchars($r['club_name']??'',ENT_QUOTES) ?>', '<?= date('d/m/Y',strtotime($r['date'])) ?>', '<?= substr($r['start_time'],0,5).' – '.substr($r['end_time'],0,5) ?>', <?= $spaceCost ?>, <?= $iva ?>, <?= $total ?>, '<?= $qrData ?>', <?= htmlspecialchars($amenDetails, ENT_QUOTES) ?>)">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                Ver ticket
            </button>
            <?php endif; ?>
            <?php if (in_array($status, ['confirmed','pending'])): ?>
            <form method="POST" action="<?= BASE_URL ?>reservations/cancel" onsubmit="return confirm('¿Cancelar esta reservación?')" style="margin:0">
                <input type="hidden" name="id" value="<?= $rid ?>">
                <button type="submit" class="hist-btn hist-btn-cancel">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                    Cancelar
                </button>
            </form>
            <?php endif; ?>
        </div>
    </div>
    <?php endforeach; ?>
    </div>
    <?php endif; ?>
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

    // Render per-amenity rows
    var amenContainer = document.getElementById('hTicketAmenContainer');
    amenContainer.innerHTML = '';
    var amenTotal = 0;
    if (amenitiesDetails && amenitiesDetails.length > 0) {
        amenitiesDetails.forEach(function(a) {
            var sub = parseFloat(a.subtotal) || (parseFloat(a.quantity) * parseFloat(a.price));
            amenTotal += sub;
            var row = document.createElement('div');
            row.className = 'hist-ticket-row';
            row.innerHTML = '<span class="hist-ticket-label" style="padding-left:0.75rem;color:var(--text-sec)">'
                + a.name + ' &times;' + a.quantity
                + '</span><span class="hist-ticket-value">' + _fmt.format(sub) + '</span>';
            amenContainer.appendChild(row);
        });
    }

    var subT = spaceCost + amenTotal;
    document.getElementById('hTicketSubtotal').textContent = _fmt.format(subT);
    document.getElementById('hTicketIva').textContent      = _fmt.format(iva);
    document.getElementById('hTicketTotal').textContent    = _fmt.format(total);
    document.getElementById('hTicketQrCode').textContent   = qrCode;

    // QR
    var wrap = document.getElementById('hTicketQrCanvas');
    wrap.innerHTML = '';
    var canvas = document.createElement('canvas');
    wrap.appendChild(canvas);
    QRCode.toCanvas(canvas, qrCode, {width:160, margin:1, color:{dark:'#000',light:'#fff'}}, function(){});

    // Share button
    document.getElementById('hShareBtn').onclick = function() {
        var text = '¡Reserva confirmada!\n' + spaceName + ' (' + clubName + ')\n' + dateLabel + ' ' + timeLabel + '\nTotal: ' + _fmt.format(total);
        if (navigator.share) { navigator.share({title:'Ticket ID Sports', text:text}); }
        else if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(function() { alert('Información copiada al portapapeles'); });
        } else {
            var el = document.createElement('textarea');
            el.value = text; el.style.position = 'fixed'; el.style.opacity = '0';
            document.body.appendChild(el); el.focus(); el.select();
            try { document.execCommand('copy'); alert('Información copiada al portapapeles'); } catch(e) {}
            document.body.removeChild(el);
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
</script>
