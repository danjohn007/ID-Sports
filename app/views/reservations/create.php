<?php
/* ── Data preparation ────────────────────────────────────── */
$closedDays  = $closedDays ?? [];
$amenities   = $amenities  ?? [];
$preDate     = $preDate    ?? date('Y-m-d');
$pricePerHour = (float)($space['price_per_hour'] ?? 0);
?>
<style>
/* ── Booking Grid Layout ─────────────────────────────────── */
.booking-header {
    display: flex; align-items: center; gap: 0.75rem;
    margin-bottom: 1.25rem;
}
.booking-back {
    display: flex; align-items: center; justify-content: center;
    width: 2.25rem; height: 2.25rem; border-radius: 0.75rem;
    background: var(--bg-card); border: 1px solid var(--border-gl2);
    color: var(--text-sec); text-decoration: none; transition: all 140ms;
    flex-shrink: 0;
}
.booking-back:hover { border-color: rgba(var(--primary-rgb),0.5); color: var(--primary); }
.booking-title {
    font-family: 'Jockey One', sans-serif;
    font-size: 1.25rem; color: var(--text-pri); margin: 0;
}
.booking-subtitle { font-size: 0.78rem; color: var(--text-muted); margin: 0; }

.booking-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    grid-template-rows: auto auto;
    gap: 0.875rem;
    margin-bottom: 1rem;
}
@media (max-width: 767px) {
    .booking-grid { grid-template-columns: 1fr; }
}

.b-cell {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.125rem;
    overflow: hidden;
    transition: border-color 160ms;
}
.b-cell:focus-within { border-color: rgba(var(--primary-rgb), 0.4); }
.b-cell-header {
    display: flex; align-items: center; gap: 0.5rem;
    padding: 0.875rem 1rem 0.625rem;
    border-bottom: 1px solid var(--border-gl);
}
.b-cell-icon {
    width: 1.75rem; height: 1.75rem; border-radius: 0.5rem;
    background: rgba(var(--primary-rgb), 0.12);
    color: var(--primary);
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
}
.b-cell-title { font-size: 0.875rem; font-weight: 600; color: var(--text-pri); }
.b-cell-body { padding: 0.875rem 1rem; }

/* ── Calendar ────────────────────────────────────────────── */
.cal-nav {
    display: flex; align-items: center; justify-content: space-between;
    margin-bottom: 0.75rem;
}
.cal-nav-btn {
    width: 1.875rem; height: 1.875rem; border-radius: 0.5rem;
    background: var(--bg-mid); border: 1px solid var(--border-gl2);
    color: var(--text-sec); cursor: pointer; display: flex;
    align-items: center; justify-content: center; transition: all 130ms;
}
.cal-nav-btn:hover { border-color: rgba(var(--primary-rgb),0.5); color: var(--primary); }
.cal-month-label {
    font-family: 'Jockey One', sans-serif;
    font-size: 0.9375rem; color: var(--text-pri);
}
.cal-grid {
    display: grid;
    grid-template-columns: repeat(7, 1fr);
    gap: 3px;
    transition: opacity 200ms, transform 200ms;
}
.cal-grid.transitioning { opacity: 0; transform: translateX(8px); }
.cal-day-name {
    text-align: center; font-size: 0.65rem; font-weight: 700;
    color: var(--text-muted); text-transform: uppercase;
    letter-spacing: 0.04em; padding: 0.25rem 0;
}
.cal-day {
    aspect-ratio: 1;
    display: flex; align-items: center; justify-content: center;
    border-radius: 0.5rem;
    font-size: 0.8125rem; font-weight: 600;
    cursor: pointer; transition: all 130ms;
    color: var(--text-sec);
    border: 1px solid transparent;
}
.cal-day:hover:not(.disabled):not(.selected) {
    background: rgba(var(--primary-rgb), 0.12);
    color: var(--primary);
    border-color: rgba(var(--primary-rgb), 0.25);
}
.cal-day.today { color: var(--primary); border-color: rgba(var(--primary-rgb), 0.35); }
.cal-day.selected {
    background: var(--primary); color: #fff;
    border-color: var(--primary);
    box-shadow: 0 3px 10px rgba(var(--primary-rgb), 0.4);
}
.cal-day.disabled {
    opacity: 0.25; cursor: not-allowed;
    text-decoration: line-through;
}
.cal-day.past { opacity: 0.2; cursor: not-allowed; }
.cal-day.empty { background: none; border: none; cursor: default; }

/* ── Time Slots ──────────────────────────────────────────── */
.slot-loading {
    text-align: center; padding: 1.5rem;
    color: var(--text-muted); font-size: 0.8125rem;
}
.slot-grid {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 0.375rem;
}
.slot-btn {
    padding: 0.4rem 0.25rem;
    border-radius: 0.5rem;
    border: 1px solid var(--border-gl2);
    background: var(--bg-mid);
    color: var(--text-sec);
    font-size: 0.75rem; font-weight: 600;
    cursor: pointer; transition: all 130ms;
    text-align: center;
    line-height: 1.2;
}
.slot-btn:hover:not(.slot-busy):not(.slot-selected) {
    border-color: rgba(var(--primary-rgb), 0.5);
    color: var(--primary);
}
.slot-btn.slot-selected {
    background: var(--primary); border-color: var(--primary);
    color: #fff; box-shadow: 0 2px 8px rgba(var(--primary-rgb), 0.35);
}
.slot-btn.slot-busy {
    opacity: 0.35; cursor: not-allowed;
    text-decoration: line-through;
}
.slot-empty { text-align: center; padding: 1.5rem; color: var(--text-muted); font-size: 0.8125rem; }

/* ── Amenities ───────────────────────────────────────────── */
.amenity-search {
    width: 100%;
    padding: 0.5rem 0.875rem;
    border-radius: 0.75rem;
    border: 1px solid var(--border-gl2);
    background: var(--bg-mid);
    color: var(--text-pri);
    font-size: 0.8125rem;
    outline: none; transition: border-color 140ms;
    margin-bottom: 0.75rem;
    font-family: 'Poppins', sans-serif;
}
.amenity-search:focus { border-color: rgba(var(--primary-rgb), 0.5); }
.amenity-search::placeholder { color: var(--text-muted); }
.amenity-list { display: flex; flex-direction: column; gap: 0.375rem; max-height: 220px; overflow-y: auto; }
.amenity-list::-webkit-scrollbar { width: 4px; }
.amenity-list::-webkit-scrollbar-thumb { background: rgba(var(--primary-rgb), 0.3); border-radius: 2px; }
.amenity-row {
    display: flex; align-items: center; gap: 0.625rem;
    padding: 0.5rem 0.625rem;
    background: rgba(var(--primary-rgb), 0.06);
    border: 1px solid var(--border-gl);
    border-radius: 0.75rem;
    transition: all 130ms;
}
.amenity-row.hidden-item { display: none; }
.amenity-thumb {
    width: 2.25rem; height: 2.25rem; border-radius: 0.5rem;
    object-fit: cover; flex-shrink: 0;
    background: rgba(var(--primary-rgb), 0.12);
    display: flex; align-items: center; justify-content: center;
    font-size: 1.125rem; color: var(--primary);
}
.amenity-thumb img { width: 100%; height: 100%; object-fit: cover; border-radius: 0.5rem; }
.amenity-name { font-size: 0.8125rem; font-weight: 600; color: var(--text-pri); flex: 1; min-width: 0; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.amenity-price { font-size: 0.75rem; color: var(--primary); font-weight: 700; margin-right: 0.375rem; white-space: nowrap; }
.amenity-stock-badge { font-size: 0.65rem; color: var(--text-muted); white-space: nowrap; }
.amenity-qty {
    display: flex; align-items: center; gap: 0.25rem; flex-shrink: 0;
}
.qty-btn {
    width: 1.5rem; height: 1.5rem; border-radius: 50%;
    border: none; cursor: pointer; font-weight: 700; font-size: 0.9rem;
    display: flex; align-items: center; justify-content: center;
    transition: all 120ms;
}
.qty-dec { background: rgba(255,255,255,0.08); color: var(--text-sec); }
.qty-dec:hover { background: rgba(var(--primary-rgb), 0.15); color: var(--primary); }
.qty-inc { background: var(--primary); color: #fff; }
.qty-inc:hover { filter: brightness(1.1); }
.qty-val { font-size: 0.8125rem; font-weight: 700; color: var(--text-pri); min-width: 1.25rem; text-align: center; }
.sold-out { font-size: 0.7rem; font-weight: 700; color: #ef4444; padding: 0.25rem 0.5rem; background: rgba(239,68,68,0.12); border-radius: 20px; white-space: nowrap; }

/* ── Summary Cell ────────────────────────────────────────── */
.summary-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.8125rem; margin-bottom: 0.5rem; }
.summary-label { color: var(--text-muted); }
.summary-value { font-weight: 600; color: var(--text-pri); }
.summary-divider { border: none; border-top: 1px dashed rgba(255,255,255,0.12); margin: 0.75rem 0; }
.summary-total-row { display: flex; justify-content: space-between; align-items: center; }
.summary-total-label { font-weight: 700; font-size: 1rem; color: var(--text-pri); }
.summary-total-value { font-family: 'Jockey One', sans-serif; font-size: 1.5rem; color: var(--primary); }
.coupon-row { display: flex; gap: 0.375rem; margin-top: 0.625rem; }
.coupon-input {
    flex: 1; padding: 0.45rem 0.75rem; border-radius: 0.75rem;
    border: 1px solid var(--border-gl2); background: var(--bg-mid);
    color: var(--text-pri); font-size: 0.8rem; outline: none;
    font-family: 'Poppins', sans-serif;
    transition: border-color 140ms;
}
.coupon-input:focus { border-color: rgba(var(--primary-rgb),0.5); }
.coupon-input::placeholder { color: var(--text-muted); }
.coupon-btn {
    padding: 0.45rem 0.875rem; border-radius: 0.75rem;
    background: rgba(var(--primary-rgb), 0.15);
    border: 1px solid rgba(var(--primary-rgb), 0.25);
    color: var(--primary); font-size: 0.8rem; font-weight: 600;
    cursor: pointer; transition: all 130ms; white-space: nowrap;
}
.coupon-btn:hover { background: var(--primary); color: #fff; }
.proceed-btn {
    width: 100%; padding: 0.875rem;
    border-radius: 1rem; border: none; cursor: pointer;
    background: var(--primary); color: #fff;
    font-family: 'Jockey One', sans-serif;
    font-size: 1.0625rem; font-weight: 700;
    margin-top: 0.875rem;
    transition: all 160ms;
    box-shadow: 0 6px 20px rgba(var(--primary-rgb), 0.4);
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
}
.proceed-btn:hover:not(:disabled) { filter: brightness(1.1); transform: translateY(-1px); box-shadow: 0 10px 28px rgba(var(--primary-rgb), 0.5); }
.proceed-btn:disabled { opacity: 0.45; cursor: not-allowed; transform: none; box-shadow: none; }
.validation-hint { font-size: 0.75rem; color: var(--text-muted); text-align: center; margin-top: 0.375rem; }

/* ── Payment Modal ───────────────────────────────────────── */
.pay-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.85);
    backdrop-filter: blur(8px);
    z-index: 80;
    display: none;
    align-items: center; justify-content: center;
    padding: 1.5rem;
}
.pay-backdrop.open { display: flex; animation: fadeIn 180ms ease; }
@keyframes fadeIn { from { opacity: 0; } to { opacity: 1; } }
.pay-sheet {
    background: var(--bg-mid);
    border: 1px solid var(--border-gl2);
    border-radius: 1.5rem;
    padding: 2rem 1.75rem;
    max-width: 360px; width: 100%;
    text-align: center;
    box-shadow: 0 30px 80px rgba(0,0,0,0.7);
    position: relative;
    animation: slideUp 220ms ease;
}
@keyframes slideUp { from { opacity:0; transform: translateY(24px); } to { opacity:1; transform: none; } }
.pay-logo { width: 4rem; height: 4rem; border-radius: 1.25rem; background: linear-gradient(135deg, var(--primary), var(--secondary)); display: flex; align-items: center; justify-content: center; margin: 0 auto 1.125rem; }
.pay-title { font-family: 'Jockey One', sans-serif; font-size: 1.375rem; color: var(--text-pri); margin: 0 0 0.25rem; }
.pay-subtitle { font-size: 0.8125rem; color: var(--text-muted); margin: 0 0 1.25rem; }
.pay-summary { background: rgba(var(--primary-rgb), 0.08); border: 1px solid rgba(var(--primary-rgb), 0.18); border-radius: 1rem; padding: 0.875rem 1rem; margin-bottom: 1.25rem; text-align: left; }
.pay-amount { font-family: 'Jockey One', sans-serif; font-size: 2rem; color: var(--primary); text-align: center; margin-bottom: 0.25rem; }
.pay-desc { font-size: 0.78rem; color: var(--text-muted); text-align: center; }
.pay-loader { display: none; flex-direction: column; align-items: center; gap: 0.875rem; padding: 1rem 0; }
.pay-spinner { width: 3rem; height: 3rem; border-radius: 50%; border: 3px solid rgba(var(--primary-rgb), 0.2); border-top-color: var(--primary); animation: spin 700ms linear infinite; }
@keyframes spin { to { transform: rotate(360deg); } }
.pay-loader-text { font-size: 0.8125rem; color: var(--text-sec); }
.pay-simulate-btn {
    width: 100%; padding: 0.875rem;
    border-radius: 1rem; border: none; cursor: pointer;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    color: #fff;
    font-family: 'Jockey One', sans-serif; font-size: 1rem; font-weight: 700;
    transition: all 160ms;
    box-shadow: 0 6px 20px rgba(var(--primary-rgb), 0.4);
    display: flex; align-items: center; justify-content: center; gap: 0.5rem;
}
.pay-simulate-btn:hover { filter: brightness(1.1); }
.pay-cancel-link { margin-top: 0.875rem; font-size: 0.8125rem; color: var(--text-muted); cursor: pointer; text-decoration: underline; display: block; }
.pay-cancel-link:hover { color: var(--text-sec); }

/* ── Ticket (in-page) ────────────────────────────────────── */
#ticketSection { display: none; }
.ticket-wrap { max-width: 420px; margin: 0 auto; }
.ticket-success-anim { text-align: center; margin-bottom: 1.5rem; }
.tick-circle { width: 5rem; height: 5rem; border-radius: 50%; background: rgba(16,185,129,0.15); display: flex; align-items: center; justify-content: center; margin: 0 auto 0.875rem; animation: popIn 400ms cubic-bezier(0.34,1.56,0.64,1); }
@keyframes popIn { from { transform: scale(0); opacity: 0; } to { transform: scale(1); opacity: 1; } }
.ticket-card { background: var(--bg-card); border: 1px solid var(--border-gl2); border-radius: 1.5rem; overflow: hidden; box-shadow: 0 12px 40px rgba(0,0,0,0.5); margin-bottom: 1rem; }
.ticket-card-head { background: linear-gradient(135deg, var(--primary), var(--secondary)); padding: 1.25rem 1.375rem; color: #fff; }
.ticket-eyebrow { font-size: 0.7rem; font-weight: 700; text-transform: uppercase; letter-spacing: 0.08em; color: rgba(255,255,255,0.65); margin: 0 0 0.25rem; }
.ticket-space-name { font-family: 'Jockey One', sans-serif; font-size: 1.375rem; margin: 0 0 0.125rem; color: #fff; }
.ticket-club-name { font-size: 0.8125rem; color: rgba(255,255,255,0.7); margin: 0; }
.ticket-body { padding: 1.125rem 1.375rem; }
.ticket-row { display: flex; justify-content: space-between; align-items: center; font-size: 0.8125rem; margin-bottom: 0.5rem; }
.ticket-row-label { color: var(--text-muted); }
.ticket-row-value { font-weight: 600; color: var(--text-pri); }
.ticket-punch { position: relative; margin: 0.75rem -1.375rem; border-top: 1.5px dashed rgba(255,255,255,0.1); }
.ticket-punch::before { content:''; position:absolute; left:-0.75rem; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; border-radius:50%; background:var(--bg-mid); }
.ticket-punch::after  { content:''; position:absolute; right:-0.75rem; top:50%; transform:translateY(-50%); width:1.25rem; height:1.25rem; border-radius:50%; background:var(--bg-mid); }
.ticket-qr { text-align: center; padding: 1rem 1.375rem 1.375rem; }
.ticket-qr-hint { font-size: 0.72rem; color: var(--text-muted); margin: 0 0 0.75rem; }
.ticket-qr-canvas { background: #fff; border-radius: 0.875rem; padding: 0.625rem; display: inline-block; }
.ticket-qr-code { font-family: monospace; font-size: 0.6rem; color: var(--text-muted); word-break: break-all; margin-top: 0.5rem; }
.ticket-actions { display: grid; grid-template-columns: 1fr 1fr; gap: 0.625rem; margin-bottom: 0.625rem; }
.ticket-action-btn {
    display: flex; align-items: center; justify-content: center; gap: 0.375rem;
    padding: 0.75rem; border-radius: 0.875rem;
    border: 1px solid var(--border-gl2);
    background: var(--bg-card);
    color: var(--text-sec); font-size: 0.8125rem; font-weight: 600;
    cursor: pointer; transition: all 130ms; text-decoration: none;
}
.ticket-action-btn:hover { border-color: rgba(var(--primary-rgb),0.4); color: var(--primary); }
.ticket-home-btn {
    width: 100%; padding: 0.875rem; border-radius: 1rem;
    background: var(--primary); color: #fff;
    font-family: 'Jockey One', sans-serif; font-size: 1rem;
    border: none; cursor: pointer; transition: all 140ms;
    text-decoration: none; display: block; text-align: center;
}
.ticket-home-btn:hover { filter: brightness(1.1); }
</style>

<!-- ── Header ─────────────────────────────────────────────── -->
<div class="booking-header">
    <a href="javascript:history.back()" class="booking-back">
        <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
    </a>
    <div>
        <h1 class="booking-title"><?= htmlspecialchars($space['name']) ?></h1>
        <p class="booking-subtitle"><?= htmlspecialchars($space['club_name'] ?? '') ?></p>
    </div>
</div>

<!-- ── Main 2×2 Grid ──────────────────────────────────────── -->
<div class="booking-grid" id="bookingGrid">

    <!-- Cell 1: Smart Calendar -->
    <div class="b-cell">
        <div class="b-cell-header">
            <div class="b-cell-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            </div>
            <span class="b-cell-title">Selecciona la Fecha</span>
        </div>
        <div class="b-cell-body">
            <div class="cal-nav">
                <button class="cal-nav-btn" onclick="calPrev()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <span class="cal-month-label" id="calMonthLabel"></span>
                <button class="cal-nav-btn" onclick="calNext()">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
            <div class="cal-grid" id="calGrid"></div>
        </div>
    </div>

    <!-- Cell 2: Time Slots — 2-step start / end flow -->
    <div class="b-cell">
        <div class="b-cell-header">
            <div class="b-cell-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            </div>
            <span class="b-cell-title" id="slotsCellTitle">Horarios Disponibles</span>
        </div>
        <!-- step pill indicator -->
        <div style="padding:0.5rem 1rem 0;display:flex;gap:0.375rem;align-items:center" id="stepPills">
            <span id="stepPill1" style="font-size:0.7rem;font-weight:700;padding:0.2rem 0.65rem;border-radius:20px;background:rgba(var(--primary-rgb),0.12);color:var(--primary);border:1px solid rgba(var(--primary-rgb),0.25)">1 Inicio</span>
            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            <span id="stepPill2" style="font-size:0.7rem;font-weight:700;padding:0.2rem 0.65rem;border-radius:20px;background:transparent;color:var(--text-muted);border:1px solid var(--border-gl2)">2 Fin</span>
        </div>
        <div class="b-cell-body" id="slotsBody">
            <div class="slot-empty">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto 0.5rem; display: block; opacity: 0.3"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
                Selecciona una fecha primero
            </div>
        </div>
    </div>

    <!-- Cell 3: Amenities -->
    <div class="b-cell">
        <div class="b-cell-header">
            <div class="b-cell-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
            </div>
            <span class="b-cell-title">Amenidades Extra</span>
        </div>
        <div class="b-cell-body">
            <?php if (empty($amenities)): ?>
            <div class="slot-empty" style="padding: 1.25rem 0">No hay amenidades disponibles</div>
            <?php else: ?>
            <input type="text" class="amenity-search" placeholder="🔍 Buscar amenidades…" oninput="filterAmenities(this.value)" id="amenitySearch">
            <div class="amenity-list" id="amenityList">
                <?php foreach ($amenities as $am):
                    $hasPhoto = !empty($am['photo']);
                    $outOfStock = ((int)($am['stock'] ?? 0)) <= 0;
                ?>
                <div class="amenity-row" data-amenity-id="<?= (int)$am['id'] ?>"
                     data-amenity-name="<?= htmlspecialchars(strtolower($am['name'])) ?>"
                     data-price="<?= (float)$am['price'] ?>"
                     data-stock="<?= (int)($am['stock'] ?? 0) ?>"
                     data-qty="0">
                    <div class="amenity-thumb">
                        <?php if ($hasPhoto): ?>
                        <img src="<?= htmlspecialchars($am['photo']) ?>" alt="<?= htmlspecialchars($am['name']) ?>">
                        <?php else: ?>
                        🏃
                        <?php endif; ?>
                    </div>
                    <div style="flex:1;min-width:0">
                        <div class="amenity-name"><?= htmlspecialchars($am['name']) ?></div>
                        <div style="display:flex;align-items:center;gap:0.375rem;margin-top:1px">
                            <span class="amenity-price">$<?= number_format($am['price'], 0) ?></span>
                            <span class="amenity-stock-badge">
                                <?php if ($outOfStock): ?>
                                <span class="sold-out">Agotado</span>
                                <?php else: ?>
                                Stock: <?= (int)$am['stock'] ?>
                                <?php endif; ?>
                            </span>
                        </div>
                    </div>
                    <?php if ($outOfStock): ?>
                    <span class="sold-out">Agotado</span>
                    <?php else: ?>
                    <div class="amenity-qty">
                        <button class="qty-btn qty-dec" onclick="changeQty(this, -1)" data-id="<?= (int)$am['id'] ?>" disabled>−</button>
                        <span class="qty-val">0</span>
                        <button class="qty-btn qty-inc" onclick="changeQty(this, 1)" data-id="<?= (int)$am['id'] ?>">+</button>
                    </div>
                    <?php endif; ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- Cell 4: Summary & Checkout -->
    <div class="b-cell">
        <div class="b-cell-header">
            <div class="b-cell-icon">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 000 7h5a3.5 3.5 0 010 7H6"/></svg>
            </div>
            <span class="b-cell-title">Resumen y Pago</span>
        </div>
        <div class="b-cell-body">
            <div class="summary-row">
                <span class="summary-label">Fecha</span>
                <span class="summary-value" id="sumDate">—</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Horario</span>
                <span class="summary-value" id="sumTime">—</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Duración</span>
                <span class="summary-value" id="sumDuration">—</span>
            </div>
            <div class="summary-row">
                <span class="summary-label">Cancha</span>
                <span class="summary-value" id="sumSubtotal">$0.00</span>
            </div>
            <div class="summary-row" id="sumAmenRow" style="display:none">
                <span class="summary-label">Amenidades</span>
                <span class="summary-value" id="sumAmenities">$0.00</span>
            </div>
            <div class="summary-row" id="sumFeeRow">
                <span class="summary-label">Cargo de servicio (5%)</span>
                <span class="summary-value" id="sumFee">$0.00</span>
            </div>
            <div class="summary-row" id="sumDiscRow" style="display:none">
                <span class="summary-label">Descuento</span>
                <span class="summary-value" style="color: #34d399" id="sumDiscount">−$0.00</span>
            </div>
            <hr class="summary-divider">
            <div class="summary-total-row">
                <span class="summary-total-label">Total</span>
                <span class="summary-total-value" id="sumTotal">$0.00</span>
            </div>

            <!-- Coupon -->
            <div class="coupon-row">
                <input type="text" class="coupon-input" id="couponInput" placeholder="Código de descuento">
                <button class="coupon-btn" onclick="applyCoupon()">Aplicar</button>
            </div>

            <button class="proceed-btn" id="proceedBtn" disabled onclick="openPayModal()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Proceder al Pago
            </button>
            <p class="validation-hint" id="validHint">Selecciona fecha, hora de inicio y hora de fin</p>
        </div>
    </div>

</div><!-- /.booking-grid -->

<!-- ── Payment Modal ──────────────────────────────────────── -->
<div class="pay-backdrop" id="payBackdrop">
    <div class="pay-sheet">
        <div class="pay-logo">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        </div>
        <h2 class="pay-title">Pasarela de Pago</h2>
        <p class="pay-subtitle">ID Sports — Pago Simulado Seguro</p>

        <div class="pay-amount" id="payAmount">$0.00</div>
        <p class="pay-desc" id="payDesc">Cancha · Amenidades</p>

        <div class="pay-summary" id="payDetails" style="margin-top: 0.875rem;"></div>

        <div id="payActions">
            <button class="pay-simulate-btn" onclick="simulatePayment()">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                Simular Pago Exitoso
            </button>
            <span class="pay-cancel-link" onclick="closePayModal()">Cancelar</span>
        </div>

        <div class="pay-loader" id="payLoader">
            <div class="pay-spinner"></div>
            <span class="pay-loader-text" id="payLoaderText">Procesando pago…</span>
        </div>
    </div>
</div>

<!-- ── In-page Ticket ─────────────────────────────────────── -->
<div id="ticketSection">
    <div class="ticket-wrap">
        <div class="ticket-success-anim">
            <div class="tick-circle">
                <svg width="40" height="40" viewBox="0 0 24 24" fill="none" stroke="#10b981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
            </div>
            <h2 style="font-family:'Jockey One',sans-serif;font-size:1.5rem;color:var(--text-pri);margin:0 0 0.25rem">¡Reserva Confirmada!</h2>
            <p style="font-size:0.875rem;color:var(--text-muted);margin:0">Tu cancha está lista 🎉</p>
        </div>
        <div class="ticket-card">
            <div class="ticket-card-head">
                <p class="ticket-eyebrow">Ticket de Reserva</p>
                <h3 class="ticket-space-name" id="ticketSpaceName"></h3>
                <p class="ticket-club-name" id="ticketClubName"></p>
            </div>
            <div class="ticket-body">
                <div class="ticket-row"><span class="ticket-row-label">Fecha</span><span class="ticket-row-value" id="ticketDate"></span></div>
                <div class="ticket-row"><span class="ticket-row-label">Horario</span><span class="ticket-row-value" id="ticketTime"></span></div>
                <div class="ticket-row"><span class="ticket-row-label">Total pagado</span><span class="ticket-row-value" id="ticketTotal" style="color:var(--primary);font-size:1.0625rem"></span></div>
                <div id="ticketAmenRows"></div>
            </div>
            <div class="ticket-punch"></div>
            <div class="ticket-qr">
                <p class="ticket-qr-hint">Muestra este QR en la entrada del club</p>
                <div class="ticket-qr-canvas"><div id="ticketQrCanvas"></div></div>
                <p class="ticket-qr-code" id="ticketQrCodeText"></p>
            </div>
        </div>
        <div class="ticket-actions">
            <button class="ticket-action-btn" onclick="window.print()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="6 9 6 2 18 2 18 9"/><path d="M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2"/><rect x="6" y="14" width="12" height="8"/></svg>
                Imprimir
            </button>
            <button class="ticket-action-btn" onclick="shareTicket()">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
                Compartir
            </button>
        </div>
        <a href="<?= BASE_URL ?>home" class="ticket-home-btn">← Volver al Inicio</a>
        <a href="<?= BASE_URL ?>reservations/history" class="ticket-home-btn" style="margin-top:0.5rem;background:rgba(var(--primary-rgb),0.12);color:var(--primary);border:1px solid rgba(var(--primary-rgb),0.25);display:block;text-align:center">📋 Ver mis reservas</a>
    </div>
</div>

<!-- Libraries -->
<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.9.3/dist/confetti.browser.min.js"></script>

<script>
/* ── State ─────────────────────────────────────────────── */
const SPACE_ID           = <?= (int)$space['id'] ?>;
const PRICE_PER_HR       = <?= (float)$space['price_per_hour'] ?>;
const CLOSED_DAYS        = <?= json_encode(array_map('intval', $closedDays)) ?>;
const BASE_URL           = '<?= BASE_URL ?>';
const MAX_DURATION_SLOTS = <?= (int)(($space['max_booking_hours'] ?? 4) * 2) ?>; // × 30 min slots

let calYear  = new Date().getFullYear();
let calMonth = new Date().getMonth(); // 0-indexed
let selectedDate = null;
let allSlots     = [];   // [{time, available}, ...]  — raw from API
let startTime    = null; // 'HH:MM'
let endTime      = null; // 'HH:MM'
let amenityQtys  = {};   // { amenityId: qty }
let discount     = 0;
let couponCode   = '';
let isSuccess    = false;

/* ── Calendar ─────────────────────────────────────────── */
const MONTHS_ES  = ['Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre'];
const DAYS_SHORT = ['Do','Lu','Ma','Mi','Ju','Vi','Sa'];

function renderCalendar() {
    var grid  = document.getElementById('calGrid');
    var label = document.getElementById('calMonthLabel');
    label.textContent = MONTHS_ES[calMonth] + ' ' + calYear;

    var today = new Date(); today.setHours(0,0,0,0);
    var first = new Date(calYear, calMonth, 1);
    var last  = new Date(calYear, calMonth + 1, 0);
    var startDow = first.getDay();

    grid.classList.add('transitioning');
    setTimeout(function() {
        grid.innerHTML = '';
        DAYS_SHORT.forEach(function(d) {
            var el = document.createElement('div');
            el.className = 'cal-day-name'; el.textContent = d; grid.appendChild(el);
        });
        for (var i = 0; i < startDow; i++) {
            var el = document.createElement('div'); el.className = 'cal-day empty'; grid.appendChild(el);
        }
        for (var d = 1; d <= last.getDate(); d++) {
            (function(day) {
                var dt  = new Date(calYear, calMonth, day);
                var dow = dt.getDay();
                var dateStr = formatDate(calYear, calMonth, day);
                var el = document.createElement('div');
                el.className = 'cal-day'; el.textContent = day;
                var isPast   = dt < today;
                var isClosed = CLOSED_DAYS.includes(dow);
                var isToday  = dt.toDateString() === today.toDateString();
                var isSel    = dateStr === selectedDate;
                if (isPast)       el.classList.add('past');
                else if (isClosed) el.classList.add('disabled');
                else {
                    el.addEventListener('click', function() { selectDate(dateStr); });
                    if (isToday) el.classList.add('today');
                    if (isSel)   el.classList.add('selected');
                }
                grid.appendChild(el);
            })(d);
        }
        grid.classList.remove('transitioning');
    }, 180);
}

function formatDate(y, m, d) {
    return y + '-' + String(m + 1).padStart(2, '0') + '-' + String(d).padStart(2, '0');
}

function calPrev() {
    if (calMonth === 0) { calMonth = 11; calYear--; } else { calMonth--; }
    renderCalendar();
}
function calNext() {
    if (calMonth === 11) { calMonth = 0; calYear++; } else { calMonth++; }
    renderCalendar();
}

function selectDate(dateStr) {
    selectedDate = dateStr;
    startTime    = null;
    endTime      = null;
    allSlots     = [];
    renderCalendar();
    loadSlots(dateStr);
    updateSummary();
    setStepPill(1);
}

/* ── Slots — 2-step start/end ──────────────────────────── */
function setStepPill(step) {
    var p1 = document.getElementById('stepPill1');
    var p2 = document.getElementById('stepPill2');
    if (!p1) return;
    if (step === 1) {
        p1.style.background = 'rgba(var(--primary-rgb),0.12)';
        p1.style.color = 'var(--primary)';
        p1.style.borderColor = 'rgba(var(--primary-rgb),0.25)';
        p2.style.background = 'transparent';
        p2.style.color = 'var(--text-muted)';
        p2.style.borderColor = 'var(--border-gl2)';
    } else {
        p1.style.background = 'rgba(16,185,129,0.12)';
        p1.style.color = '#10b981';
        p1.style.borderColor = 'rgba(16,185,129,0.25)';
        p2.style.background = 'rgba(var(--primary-rgb),0.12)';
        p2.style.color = 'var(--primary)';
        p2.style.borderColor = 'rgba(var(--primary-rgb),0.25)';
    }
}

function loadSlots(date) {
    var body = document.getElementById('slotsBody');
    body.innerHTML = '<div class="slot-loading"><div style="display:inline-block;width:1.5rem;height:1.5rem;border-radius:50%;border:2px solid rgba(var(--primary-rgb),0.2);border-top-color:var(--primary);animation:spin 700ms linear infinite"></div><br>Cargando…</div>';

    fetch(BASE_URL + 'reservations/slots?space_id=' + SPACE_ID + '&date=' + date)
        .then(function(r) { return r.json(); })
        .then(function(slots) { allSlots = slots; renderStartSlots(); })
        .catch(function() { body.innerHTML = '<div class="slot-empty">Error al cargar horarios</div>'; });
}

/** STEP 1: show all available slots for start-time selection */
function renderStartSlots() {
    var body = document.getElementById('slotsBody');
    if (!allSlots || allSlots.length === 0) {
        body.innerHTML = '<div class="slot-empty">Sin horarios disponibles para este día</div>';
        return;
    }

    var heading = document.createElement('p');
    heading.style.cssText = 'font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin:0 0 0.5rem';
    heading.textContent = 'Selecciona hora de inicio';

    var grid = document.createElement('div');
    grid.className = 'slot-grid';
    allSlots.forEach(function(slot) {
        var btn = document.createElement('button');
        btn.className = 'slot-btn' + (!slot.available ? ' slot-busy' : '');
        btn.textContent = slot.time;
        btn.dataset.time = slot.time;
        if (!slot.available) { btn.disabled = true; }
        else {
            btn.addEventListener('click', function() { pickStartTime(slot.time); });
        }
        grid.appendChild(btn);
    });
    body.innerHTML = '';
    body.appendChild(heading);
    body.appendChild(grid);
}

/** STEP 2: user picked startTime → show end-time options */
function pickStartTime(time) {
    startTime = time;
    endTime   = null;
    updateSummary();
    setStepPill(2);
    renderEndSlots();
}

function formatDuration(minutes) {
    if (minutes < 60) return minutes + 'min';
    var h = minutes / 60;
    return h % 1 === 0 ? h + 'h' : h.toFixed(1) + 'h';
}

/** Compute which end-time slots are valid from the current startTime */
function getValidEndSlots() {
    if (!startTime || !allSlots.length) return [];
    var startIdx = allSlots.findIndex(function(s) { return s.time === startTime; });
    if (startIdx < 0) return [];
    // Scan forward from startIdx:
    //  - stop when we hit a BUSY slot (cannot jump over reserved blocks)
    //  - stop after MAX_DURATION_SLOTS consecutive slots
    var valid = [];
    for (var i = startIdx + 1; i < allSlots.length && i <= startIdx + MAX_DURATION_SLOTS; i++) {
        if (!allSlots[i].available) break; // stop at first busy slot
        // end time = allSlots[i].time
        valid.push(allSlots[i].time);
    }
    return valid;
}

function renderEndSlots() {
    var body = document.getElementById('slotsBody');
    var validEnds = getValidEndSlots();

    var backBtn = document.createElement('button');
    backBtn.style.cssText = 'display:flex;align-items:center;gap:0.25rem;background:none;border:none;color:var(--text-sec);font-size:0.75rem;cursor:pointer;padding:0;margin-bottom:0.5rem';
    backBtn.innerHTML = '<svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg> Inicio: <strong style="color:var(--primary);margin-left:3px">' + startTime + '</strong>';
    backBtn.addEventListener('click', function() { startTime = null; endTime = null; renderStartSlots(); setStepPill(1); updateSummary(); });

    var heading = document.createElement('p');
    heading.style.cssText = 'font-size:0.72rem;font-weight:700;text-transform:uppercase;letter-spacing:0.05em;color:var(--text-muted);margin:0 0 0.5rem';
    heading.textContent = 'Selecciona hora de fin';

    if (validEnds.length === 0) {
        body.innerHTML = '';
        body.appendChild(backBtn);
        var msg = document.createElement('div');
        msg.className = 'slot-empty'; msg.textContent = 'No hay duración disponible desde este horario';
        body.appendChild(msg);
        return;
    }

    var grid = document.createElement('div');
    grid.className = 'slot-grid';
    validEnds.forEach(function(eTime, idx) {
        var durationMins = (idx + 1) * 30;
        var durLabel = formatDuration(durationMins);
        var btn = document.createElement('button');
        btn.className = 'slot-btn' + (eTime === endTime ? ' slot-selected' : '');
        btn.innerHTML = '<span style="display:block;font-size:0.8rem">' + eTime + '</span><span style="display:block;font-size:0.6rem;color:' + (eTime === endTime ? 'rgba(255,255,255,0.75)' : 'var(--text-muted)') + ';margin-top:1px">+' + durLabel + '</span>';
        btn.dataset.time = eTime;
        btn.addEventListener('click', function() { pickEndTime(eTime); });
        grid.appendChild(btn);
    });

    body.innerHTML = '';
    body.appendChild(backBtn);
    body.appendChild(heading);
    body.appendChild(grid);
}

function pickEndTime(time) {
    endTime = time;
    updateSummary();
    renderEndSlots(); // re-render to highlight selection
}

/* ── Amenities ─────────────────────────────────────────── */
function filterAmenities(q) {
    document.querySelectorAll('#amenityList .amenity-row').forEach(function(row) {
        var name = row.dataset.amenityName || '';
        row.classList.toggle('hidden-item', q.length > 0 && !name.includes(q.toLowerCase()));
    });
}

function changeQty(btn, delta) {
    var row   = btn.closest('.amenity-row');
    var id    = parseInt(row.dataset.amenityId);
    var stock = parseInt(row.dataset.stock);
    var qtyEl = row.querySelector('.qty-val');
    var decBtn = row.querySelector('.qty-dec');
    var incBtn = row.querySelector('.qty-inc');
    var qty = parseInt(row.dataset.qty) || 0;
    qty = Math.max(0, Math.min(stock, qty + delta));
    row.dataset.qty = qty;
    qtyEl.textContent = qty;
    amenityQtys[id] = qty;
    decBtn.disabled = qty <= 0;
    incBtn.disabled = qty >= stock;
    updateSummary();
}

/* ── Summary ───────────────────────────────────────────── */
function updateSummary() {
    var hasDate  = !!selectedDate;
    var hasStart = !!startTime;
    var hasEnd   = !!endTime;
    var valid    = hasDate && hasStart && hasEnd;

    // Calculate hours
    var hours = 0;
    if (hasStart && hasEnd) {
        var sm = timeToMin(startTime), em = timeToMin(endTime);
        hours = Math.max(0, (em - sm) / 60);
    }

    document.getElementById('sumDate').textContent     = hasDate  ? formatDisplayDate(selectedDate) : '—';
    document.getElementById('sumTime').textContent     = (hasStart && hasEnd) ? (startTime + ' – ' + endTime) : (hasStart ? (startTime + ' – ?') : '—');
    document.getElementById('sumDuration').textContent = hours > 0 ? (hours % 1 === 0 ? hours + (hours === 1 ? ' hora' : ' horas') : hours.toFixed(1) + ' horas') : '—';

    var subtotal = Math.round(PRICE_PER_HR * hours * 100) / 100;
    var fee      = Math.round(subtotal * 0.05 * 100) / 100;

    var amenTotal = 0;
    Object.entries(amenityQtys).forEach(function(pair) {
        var id = pair[0], qty = pair[1];
        if (qty > 0) {
            var row = document.querySelector('[data-amenity-id="' + id + '"]');
            if (row) amenTotal += parseFloat(row.dataset.price) * qty;
        }
    });
    amenTotal = Math.round(amenTotal * 100) / 100;

    var total = subtotal + fee + amenTotal - discount;

    document.getElementById('sumSubtotal').textContent  = '$' + subtotal.toFixed(2);
    document.getElementById('sumFee').textContent       = '$' + fee.toFixed(2);
    document.getElementById('sumAmenities').textContent = '$' + amenTotal.toFixed(2);
    document.getElementById('sumAmenRow').style.display = amenTotal > 0 ? '' : 'none';
    document.getElementById('sumTotal').textContent     = '$' + Math.max(0, total).toFixed(2);

    if (discount > 0) {
        document.getElementById('sumDiscRow').style.display = '';
        document.getElementById('sumDiscount').textContent  = '−$' + discount.toFixed(2);
    } else {
        document.getElementById('sumDiscRow').style.display = 'none';
    }

    var btn  = document.getElementById('proceedBtn');
    var hint = document.getElementById('validHint');
    btn.disabled = !valid;
    if (!hasDate)        hint.textContent = 'Selecciona una fecha';
    else if (!hasStart)  hint.textContent = 'Selecciona la hora de inicio';
    else if (!hasEnd)    hint.textContent = 'Selecciona la hora de fin';
    else                 hint.textContent = '';
}

function timeToMin(t) {
    var parts = t.split(':');
    return parseInt(parts[0]) * 60 + parseInt(parts[1]);
}

function formatDisplayDate(ds) {
    var parts = ds.split('-').map(Number);
    var dt = new Date(parts[0], parts[1] - 1, parts[2]);
    return dt.toLocaleDateString('es-MX', {weekday:'short', day:'numeric', month:'short', year:'numeric'});
}

/* ── Coupon ────────────────────────────────────────────── */
function applyCoupon() {
    couponCode = document.getElementById('couponInput').value.trim();
    if (!couponCode) return;
    var existing = document.getElementById('couponFeedback');
    if (existing) existing.remove();
    var msg = document.createElement('p');
    msg.id = 'couponFeedback';
    msg.style.cssText = 'font-size:0.75rem;color:var(--primary);margin-top:0.375rem;text-align:center';
    msg.textContent = 'El cupón será validado al procesar el pago.';
    document.getElementById('couponInput').parentNode.after(msg);
}

/* ── Payment Modal ─────────────────────────────────────── */
function openPayModal() {
    if (!startTime || !endTime || !selectedDate) return;
    var total = parseFloat(document.getElementById('sumTotal').textContent.replace('$',''));
    document.getElementById('payAmount').textContent = '$' + total.toFixed(2);
    document.getElementById('payDesc').textContent   = '<?= htmlspecialchars($space['name']) ?> · ' + startTime + '–' + endTime;

    document.getElementById('payDetails').innerHTML =
        '<div style="font-size:0.78rem;color:var(--text-muted);line-height:1.8">' +
        '<div style="display:flex;justify-content:space-between"><span>Fecha</span><span style="color:var(--text-pri);font-weight:600">' + formatDisplayDate(selectedDate) + '</span></div>' +
        '<div style="display:flex;justify-content:space-between"><span>Horario</span><span style="color:var(--text-pri);font-weight:600">' + startTime + ' – ' + endTime + '</span></div>' +
        '</div>';

    document.getElementById('payLoader').style.display  = 'none';
    document.getElementById('payActions').style.display = '';
    document.getElementById('payBackdrop').classList.add('open');
}

function closePayModal() {
    document.getElementById('payBackdrop').classList.remove('open');
}

/* ── Payment simulation ────────────────────────────────── */
function simulatePayment() {
    document.getElementById('payActions').style.display = 'none';
    document.getElementById('payLoader').style.display  = 'flex';

    var amenitiesPayload = [];
    Object.entries(amenityQtys).forEach(function(pair) {
        var id = pair[0], qty = pair[1];
        if (qty > 0) amenitiesPayload.push({id: parseInt(id), qty: qty});
    });

    var body = new URLSearchParams({
        space_id:   SPACE_ID,
        date:       selectedDate,
        start_time: startTime,
        end_time:   endTime,
        coupon:     couponCode,
        amenities:  JSON.stringify(amenitiesPayload),
    });

    setTimeout(function() {
        document.getElementById('payLoaderText').textContent = 'Confirmando reserva…';
        fetch(BASE_URL + 'reservations/pay', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: body.toString()
        })
        .then(function(r) { return r.json(); })
        .then(function(data) {
            if (data.success) {
                closePayModal();
                setSuccess(data.reservation, data.qr_code, data.amenities);
            } else {
                closePayModal();
                var errMsg = document.createElement('p');
                errMsg.style.cssText = 'color:#ef4444;font-size:0.8rem;text-align:center;margin-top:0.5rem';
                errMsg.textContent = data.error || 'Ocurrió un problema. Intenta de nuevo.';
                document.getElementById('payActions').parentNode.appendChild(errMsg);
                document.getElementById('payActions').style.display = '';
                document.getElementById('payLoader').style.display  = 'none';
                document.getElementById('payBackdrop').classList.add('open');
            }
        })
        .catch(function() {
            closePayModal();
            alert('Error de conexión. Intenta de nuevo.');
        });
    }, 1500);
}

/* ── isSuccess state ───────────────────────────────────── */
function setSuccess(res, qrCode, amenities) {
    isSuccess = true;
    // Phase 4: Single elegant confetti burst
    confetti({ particleCount: 100, spread: 70, origin: { y: 0.6 } });
    // Hide booking grid & header
    document.getElementById('bookingGrid').style.transition = 'opacity 300ms';
    document.getElementById('bookingGrid').style.opacity = '0';
    setTimeout(function() {
        document.getElementById('bookingGrid').style.display = 'none';
        var header = document.querySelector('.booking-header');
        if (header) header.style.display = 'none';
        // Populate and show ticket
        populateTicket(res, qrCode, amenities);
        var sec = document.getElementById('ticketSection');
        sec.style.display = '';
        sec.style.opacity = '0';
        sec.style.transition = 'opacity 400ms';
        setTimeout(function() { sec.style.opacity = '1'; }, 30);
        sec.scrollIntoView({behavior: 'smooth'});
    }, 320);
}

function populateTicket(res, qrCode, amenities) {
    document.getElementById('ticketSpaceName').textContent = res.space_name || '<?= htmlspecialchars($space['name']) ?>';
    document.getElementById('ticketClubName').textContent  = res.club_name  || '<?= htmlspecialchars($space['club_name'] ?? '') ?>';

    var dt = new Date((res.date || '') + 'T12:00:00');
    document.getElementById('ticketDate').textContent  = dt.toLocaleDateString('es-MX', {weekday:'long',day:'numeric',month:'long',year:'numeric'});
    document.getElementById('ticketTime').textContent  = (res.start_time||'').substring(0,5) + ' – ' + (res.end_time||'').substring(0,5);
    document.getElementById('ticketTotal').textContent = '$' + parseFloat(res.total).toFixed(2);

    if (amenities && amenities.length > 0) {
        var html = '<hr style="border-color:rgba(255,255,255,0.07);margin:0.5rem 0">';
        amenities.forEach(function(a) {
            html += '<div class="ticket-row"><span class="ticket-row-label">' + a.name + ' ×' + a.quantity + '</span><span class="ticket-row-value">$' + parseFloat(a.price).toFixed(2) + '</span></div>';
        });
        document.getElementById('ticketAmenRows').innerHTML = html;
    }

    // QR
    document.getElementById('ticketQrCodeText').textContent = qrCode;
    var canvas = document.createElement('canvas');
    document.getElementById('ticketQrCanvas').innerHTML = '';
    document.getElementById('ticketQrCanvas').appendChild(canvas);
    QRCode.toCanvas(canvas, qrCode, {width: 180, margin: 1}, function(){});
}

function shareTicket() {
    var qr = document.getElementById('ticketQrCodeText').textContent;
    if (navigator.share) {
        navigator.share({ title: '¡Reserva en ID Sports!', text: 'Mi reserva: ' + qr, url: window.location.href });
    } else {
        var url = window.location.href;
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(url).then(function() {
                alert('Enlace copiado al portapapeles');
            }).catch(function() {
                fallbackCopy(url);
            });
        } else {
            fallbackCopy(url);
        }
    }
}

function fallbackCopy(text) {
    var el = document.createElement('textarea');
    el.value = text; el.style.position = 'fixed'; el.style.opacity = '0';
    document.body.appendChild(el); el.focus(); el.select();
    try { document.execCommand('copy'); alert('Enlace copiado al portapapeles'); } catch(e) {}
    document.body.removeChild(el);
    }
}

/* ── Init ──────────────────────────────────────────────── */
(function() {
    var preDate = <?= json_encode($preDate) ?>;
    var today = new Date(); today.setHours(0,0,0,0);
    if (preDate) {
        var pd = new Date(preDate + 'T12:00:00');
        calYear  = pd.getFullYear();
        calMonth = pd.getMonth();
    }
    renderCalendar();
    if (preDate) {
        var pd2 = new Date(preDate + 'T12:00:00');
        if (pd2 >= today && !CLOSED_DAYS.includes(pd2.getDay())) {
            selectDate(preDate);
        }
    }
    updateSummary();
})();
</script>

