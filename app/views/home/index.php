<?php
/* ── Sport SVG icon helper ──────────────────────────────── */
function sportSvg(string $type): string {
    $icons = [
        'football'   => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3v3.5M12 20.5v-3m-5-11l2.5 3M16.5 6l-2.5 3M4.5 15l3-1.5m9 0l3 1.5" stroke="currentColor" stroke-width="1.4"/>',
        'padel'      => '<rect x="4" y="8" width="11" height="14" rx="3" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M15 11h2a2 2 0 012 2v0a2 2 0 01-2 2h-2" stroke="currentColor" stroke-width="1.8"/><line x1="8" y1="2" x2="11" y2="5" stroke="currentColor" stroke-width="1.8"/>',
        'tennis'     => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M3 12c0-3.3 2-6 4.5-6" stroke="currentColor" stroke-width="1.4"/><path d="M21 12c0 3.3-2 6-4.5 6" stroke="currentColor" stroke-width="1.4"/>',
        'basketball' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><line x1="12" y1="3" x2="12" y2="21" stroke="currentColor" stroke-width="1.4"/><line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.4"/><path d="M5 5.5A12 12 0 0119 18.5" stroke="currentColor" stroke-width="1.4"/>',
        'swimming'   => '<path d="M3 17c1.5 0 3-1 4.5-1s3 1 4.5 1 3-1 4.5-1 3 1 4.5 1" stroke="currentColor" stroke-width="1.8" fill="none"/><path d="M3 12c1.5 0 3-1 4.5-1s3 1 4.5 1 3-1 4.5-1 3 1 4.5 1" stroke="currentColor" stroke-width="1.8" fill="none"/><circle cx="19" cy="5" r="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M15 7l-4 4" stroke="currentColor" stroke-width="1.8"/>',
        'volleyball' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3c0 5 3 8 9 9" stroke="currentColor" stroke-width="1.4"/><path d="M12 21c0-5-3-8-9-9" stroke="currentColor" stroke-width="1.4"/><path d="M3.5 8.5c5 1 8 4 8.5 10.5" stroke="currentColor" stroke-width="1.4"/>',
    ];
    return '<svg viewBox="0 0 24 24" width="28" height="28" xmlns="http://www.w3.org/2000/svg">' . ($icons[$type] ?? $icons['football']) . '</svg>';
}

/* ── Sport accent-color map (uses --primary as base) ─────── */
$sportAccents = [
    'football'   => ['from'=>'#10b981','to'=>'#059669'],
    'padel'      => ['from'=>'#3b82f6','to'=>'#1d4ed8'],
    'tennis'     => ['from'=>'#f59e0b','to'=>'#d97706'],
    'basketball' => ['from'=>'#f97316','to'=>'#ea580c'],
    'swimming'   => ['from'=>'#06b6d4','to'=>'#0891b2'],
    'volleyball' => ['from'=>'#8b5cf6','to'=>'#7c3aed'],
];
?>

<style>
/* ── Home layout CSS (inherits design system from main.php) ── */

/* Full-width sections */
.home-section { margin-bottom: 1.75rem; }
.home-section-header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-bottom: 0.875rem;
}
.home-section-title {
    font-family: 'Jockey One', sans-serif;
    font-size: 1.0625rem;
    color: var(--text-pri);
    letter-spacing: 0.01em;
}
.home-section-link {
    font-size: 0.75rem;
    font-weight: 600;
    color: var(--primary);
    text-decoration: none;
    transition: opacity 120ms;
}
.home-section-link:hover { opacity: 0.75; }

/* Glassmorphism card */
.glass-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1rem;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    transition: all 160ms ease;
}
.glass-card:hover {
    background: var(--bg-card-hover);
    border-color: var(--border-gl2);
}

/* ── Today widget ──────────────────────────────────────── */
.today-card {
    position: relative;
    border-radius: 1.25rem;
    padding: 1.25rem 1.375rem;
    color: #fff;
    overflow: hidden;
    background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
    box-shadow: 0 8px 28px rgba(var(--primary-rgb), 0.35);
}
.today-card::before {
    content: '';
    position: absolute;
    top: -40%; right: -15%;
    width: 55%; padding-bottom: 55%;
    border-radius: 50%;
    background: rgba(255,255,255,0.09);
    pointer-events: none;
}
.today-card::after {
    content: '';
    position: absolute;
    bottom: -50%; left: -10%;
    width: 65%; padding-bottom: 65%;
    border-radius: 50%;
    background: rgba(255,255,255,0.06);
    pointer-events: none;
}

/* ── Day pills ─────────────────────────────────────────── */
.day-pill {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 0.875rem 1.125rem;
    border-radius: 1rem;
    border: 1px solid var(--border-gl);
    background: var(--bg-card);
    text-decoration: none;
    min-width: 88px;
    transition: all 140ms;
    box-shadow: 0 2px 8px rgba(0,0,0,0.2);
}
.day-pill:hover {
    border-color: rgba(var(--primary-rgb), 0.5);
    transform: translateY(-2px);
    box-shadow: 0 6px 18px rgba(var(--primary-rgb),0.18);
}
.day-pill.active {
    background: var(--primary);
    border-color: var(--primary);
    box-shadow: 0 6px 22px rgba(var(--primary-rgb), 0.5);
    transform: translateY(-2px);
}
.day-pill .day-label { font-size: 0.72rem; font-weight: 700; color: var(--text-muted); letter-spacing: 0.05em; text-transform: uppercase; }
.day-pill.active .day-label { color: rgba(255,255,255,0.8); }
.day-pill .day-num { font-family: 'Jockey One', sans-serif; font-size: 1.875rem; color: var(--text-pri); line-height: 1.1; margin: 0.1rem 0; }
.day-pill.active .day-num { color: #fff; }
.day-pill .day-avail { font-size: 0.7rem; font-weight: 600; color: var(--text-muted); margin-top: 3px; }
.day-pill.active .day-avail { color: rgba(255,255,255,0.75); }

/* ── Sport cards ───────────────────────────────────────── */
.sport-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.5rem;
    padding: 0.75rem 0.5rem;
    border-radius: 0.875rem;
    text-decoration: none;
    border: 1px solid var(--border-gl);
    background: var(--bg-card);
    transition: all 150ms ease;
}
.sport-card:hover {
    border-color: rgba(var(--primary-rgb), 0.45);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(var(--primary-rgb), 0.18);
}
.sport-icon-wrap {
    width: 2.75rem; height: 2.75rem;
    border-radius: 0.75rem;
    display: flex; align-items: center; justify-content: center;
    transition: transform 150ms;
}
.sport-card:hover .sport-icon-wrap { transform: scale(1.1); }
.sport-card span {
    font-family: 'Jockey One', sans-serif;
    font-size: 0.75rem;
    text-align: center;
    color: var(--text-sec);
    line-height: 1.2;
}

/* ── Club cards ─────────────────────────────────────────── */
.club-card {
    display: block;
    border-radius: 1rem;
    overflow: hidden;
    text-decoration: none;
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    transition: all 160ms ease;
}
.club-card:hover {
    border-color: rgba(var(--primary-rgb), 0.4);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(var(--primary-rgb), 0.15);
}
.club-cover { height: 7rem; position: relative; overflow: hidden; }
.club-cover-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--primary) 0%, #6366f1 100%);
    display: flex; align-items: center; justify-content: center;
    opacity: 0.7;
}
.club-dist-badge {
    position: absolute; top: 0.5rem; right: 0.5rem;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.15);
    color: #fff;
    font-size: 0.68rem; font-weight: 700;
    padding: 0.2rem 0.5rem; border-radius: 20px;
    display: flex; align-items: center; gap: 0.25rem;
}
.club-info { padding: 0.75rem; }
.club-name {
    font-family: 'Jockey One', sans-serif;
    font-size: 0.875rem;
    color: var(--text-pri);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 0.2rem;
}
.club-city { font-size: 0.7rem; color: var(--text-sec); display: flex; align-items: center; gap: 0.25rem; }
.club-cta { font-size: 0.7rem; font-weight: 600; color: var(--primary); margin-top: 0.4rem; }

/* ── Active reservation rows ───────────────────────────── */
.res-row {
    display: flex; align-items: center; gap: 0.875rem;
    padding: 0.875rem;
    border-radius: 0.875rem;
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    transition: all 140ms;
    cursor: pointer;
}
.res-row:hover { border-color: rgba(var(--primary-rgb), 0.4); background: var(--bg-card-hover); transform: translateY(-1px); box-shadow: 0 4px 16px rgba(var(--primary-rgb),0.12); }
.res-icon {
    width: 2.625rem; height: 2.625rem;
    border-radius: 0.625rem;
    display: flex; align-items: center; justify-content: center;
    flex-shrink: 0;
    background: rgba(var(--primary-rgb), 0.12);
    color: var(--primary);
}
/* status badges */
.res-badge-now    { font-size:0.65rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:20px;background:rgba(16,185,129,0.18);color:#34d399;display:inline-block;margin-top:0.2rem; }
.res-badge-soon   { font-size:0.65rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:20px;background:rgba(var(--primary-rgb),0.18);color:var(--primary);display:inline-block;margin-top:0.2rem; }
.res-badge-pend   { font-size:0.65rem;font-weight:700;padding:0.15rem 0.5rem;border-radius:20px;background:rgba(245,158,11,0.18);color:#fbbf24;display:inline-block;margin-top:0.2rem; }

/* ── Empty state ───────────────────────────────────────── */
.empty-cta {
    text-align: center;
    padding: 2.5rem 1.5rem;
    border-radius: 1.25rem;
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
}
.empty-cta-icon {
    width: 3.5rem; height: 3.5rem;
    border-radius: 1rem;
    margin: 0 auto 1rem;
    display: flex; align-items: center; justify-content: center;
    background: rgba(var(--primary-rgb), 0.12);
    color: var(--primary);
}
.home-cta-btn {
    display: inline-flex; align-items: center; gap: 0.4rem;
    background: var(--primary);
    color: #fff;
    font-weight: 700;
    font-size: 0.875rem;
    padding: 0.625rem 1.5rem;
    border-radius: 0.75rem;
    text-decoration: none;
    transition: all 140ms;
    box-shadow: 0 4px 14px rgba(var(--primary-rgb), 0.35);
}
.home-cta-btn:hover { filter: brightness(1.1); transform: translateY(-1px); }

/* ── QR Modal ──────────────────────────────────────────── */
.qr-backdrop {
    position: fixed; inset: 0;
    background: rgba(0,0,0,0.8);
    backdrop-filter: blur(6px);
    z-index: 60;
    display: flex; align-items: center; justify-content: center;
    padding: 1.5rem;
}
.qr-sheet {
    background: var(--bg-mid);
    border: 1px solid var(--border-gl2);
    border-radius: 1.375rem;
    padding: 1.5rem;
    max-width: 320px;
    width: 100%;
    text-align: center;
    box-shadow: 0 24px 60px rgba(0,0,0,0.6);
    position: relative;
}
.qr-canvas-wrap {
    background: #fff;
    border-radius: 0.875rem;
    padding: 0.75rem;
    display: inline-block;
    margin: 1rem 0;
}

/* ── Scrollbar ─────────────────────────────────────────── */
.no-scroll::-webkit-scrollbar { display: none; }
.no-scroll { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<!-- ── HOME CONTENT ─────────────────────────────────────────── -->
<div style="max-width:100%">

    <!-- RF2.1 – Header: Avatar + Greeting + Bell -->
    <div class="home-section" style="display:flex;align-items:center;gap:0.875rem;padding-top:0.25rem;padding-bottom:0.25rem;">
        <a href="<?= BASE_URL ?>user/profile" style="flex-shrink:0">
            <?php if (!empty($_SESSION['user_avatar'])): ?>
            <img src="<?= htmlspecialchars($_SESSION['user_avatar']) ?>"
                 style="width:3rem;height:3rem;border-radius:50%;object-fit:cover;border:2px solid var(--primary)" alt="Avatar">
            <?php else: ?>
            <div style="width:3rem;height:3rem;border-radius:50%;background:var(--primary);display:flex;align-items:center;justify-content:center;color:#fff;font-family:'Jockey One',sans-serif;font-size:1.25rem;border:2px solid rgba(var(--primary-rgb),0.4)">
                <?= strtoupper(substr($_SESSION['user_name'] ?? 'U', 0, 1)) ?>
            </div>
            <?php endif; ?>
        </a>
        <div style="flex:1;min-width:0">
            <p style="font-size:0.7rem;color:var(--text-muted);margin-bottom:1px">Buenos días</p>
            <h1 class="home-section-title" style="font-size:1.375rem;margin:0;overflow:hidden;text-overflow:ellipsis;white-space:nowrap">
                Hola, <?= htmlspecialchars(explode(' ', $_SESSION['user_name'] ?? 'Usuario')[0]) ?>
            </h1>
        </div>
        <button onclick="openNotifications()"
                style="position:relative;width:2.5rem;height:2.5rem;border-radius:0.75rem;background:var(--bg-card);border:1px solid var(--border-gl);display:flex;align-items:center;justify-content:center;cursor:pointer;flex-shrink:0;transition:all 140ms"
                onmouseover="this.style.borderColor='rgba(var(--primary-rgb),0.5)'"
                onmouseout="this.style.borderColor='var(--border-gl)'">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" style="color:var(--text-sec)">
                <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9"/><path d="M13.73 21a2 2 0 01-3.46 0"/>
            </svg>
            <?php if (!empty($unreadNotifications) && $unreadNotifications > 0): ?>
            <span style="position:absolute;top:0.3rem;right:0.3rem;width:0.5rem;height:0.5rem;border-radius:50%;background:var(--primary)"></span>
            <?php endif; ?>
        </button>
    </div>

    <!-- RF2.2 – Today's Reservation Widget -->
    <?php if (!empty($todayReservation)): ?>
    <?php
        $res = $todayReservation;
        $nowTs   = time();
        $startTs = strtotime(date('Y-m-d') . ' ' . $res['start_time']);
        $diffH   = ($startTs - $nowTs) / 3600;
        if ($diffH <= 0)       $diffMsg = 'ahora mismo';
        elseif ($diffH < 1)    $diffMsg = 'en ' . round($diffH * 60) . ' min';
        elseif ($diffH < 2)    $diffMsg = 'en 1 hora';
        else                   $diffMsg = 'en ' . round($diffH) . ' horas';
    ?>
    <div class="home-section today-card">
        <div style="position:relative;z-index:1">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.75rem">
                <div style="flex:1;min-width:0">
                    <p style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:rgba(255,255,255,0.7);margin-bottom:0.375rem">
                        Reserva de hoy
                    </p>
                    <h3 style="font-family:'Jockey One',sans-serif;font-size:1.25rem;color:#fff;line-height:1.2;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
                        <?= htmlspecialchars($res['space_name']) ?>
                    </h3>
                    <p style="font-size:0.8rem;color:rgba(255,255,255,0.65);margin-top:0.2rem"><?= htmlspecialchars($res['club_name'] ?? '') ?></p>
                </div>
                <div style="flex-shrink:0;width:3rem;height:3rem;border-radius:0.875rem;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#fff">
                    <?= sportSvg($res['sport_type'] ?? 'football') ?>
                </div>
            </div>
            <p style="margin-top:0.75rem;font-size:0.8125rem;color:rgba(255,255,255,0.75)">
                Tienes un partido <strong style="color:#fff"><?= $diffMsg ?></strong>
                &nbsp;&middot;&nbsp;
                <?= substr($res['start_time'], 0, 5) ?> – <?= substr($res['end_time'], 0, 5) ?>
            </p>
            <button onclick="openQrModal('<?= htmlspecialchars($res['qr_code'] ?? 'RES-' . $res['id'], ENT_QUOTES) ?>','<?= htmlspecialchars($res['space_name'], ENT_QUOTES) ?>','<?= htmlspecialchars($res['club_name'] ?? '', ENT_QUOTES) ?>','<?= htmlspecialchars(date('d/m/Y'), ENT_QUOTES) ?>','<?= htmlspecialchars(substr($res['start_time'],0,5).' – '.substr($res['end_time'],0,5), ENT_QUOTES) ?>','')"
                    style="margin-top:1rem;display:inline-flex;align-items:center;gap:0.5rem;background:#fff;color:var(--primary);font-weight:700;font-size:0.8125rem;padding:0.55rem 1.1rem;border-radius:0.75rem;border:none;cursor:pointer;box-shadow:0 4px 12px rgba(0,0,0,0.2);transition:all 140ms"
                    onmouseover="this.style.filter='brightness(0.95)'"
                    onmouseout="this.style.filter='none'">
                <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/>
                    <rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/>
                </svg>
                Ver QR de Acceso
            </button>
        </div>
    </div>
    <?php endif; ?>

    <!-- RF2.3 – 5-Day Quick Booking -->
    <div class="home-section">
        <div class="home-section-header">
            <h2 class="home-section-title">Reservar por Día</h2>
            <a href="<?= BASE_URL ?>reservations/search" class="home-section-link">Ver todo &rarr;</a>
        </div>
        <div style="display:flex;gap:0.5rem;overflow-x:auto;padding-bottom:4px" class="no-scroll">
            <?php foreach ($upcomingDays as $idx => $day): ?>
            <a href="<?= BASE_URL ?>reservations/search?date=<?= $day['date'] ?>"
               class="day-pill <?= $idx === 0 ? 'active' : '' ?>">
                <span class="day-label"><?= $day['label'] ?></span>
                <span class="day-num"><?= $day['day_num'] ?></span>
                <span class="day-avail"><?= $day['available'] ?> libre<?= $day['available'] != 1 ? 's' : '' ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- RF2.4 – Sport Categories -->
    <div class="home-section">
        <h2 class="home-section-title" style="margin-bottom:0.875rem">Deportes</h2>
        <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:0.625rem">
            <?php
            $sports = [
                ['key'=>'football',   'label'=>'Fútbol'],
                ['key'=>'padel',      'label'=>'Pádel'],
                ['key'=>'tennis',     'label'=>'Tenis'],
                ['key'=>'basketball', 'label'=>'Basketball'],
                ['key'=>'swimming',   'label'=>'Natación'],
                ['key'=>'volleyball', 'label'=>'Voleibol'],
            ];
            ?>
            <?php foreach ($sports as $sport):
                $acc = $sportAccents[$sport['key']] ?? ['from'=>'var(--primary)','to'=>'#6366f1'];
            ?>
            <a href="<?= BASE_URL ?>reservations/search?sport=<?= $sport['key'] ?>" class="sport-card">
                <div class="sport-icon-wrap"
                     style="background:linear-gradient(135deg,<?= $acc['from'] ?>,<?= $acc['to'] ?>);color:#fff">
                    <?= sportSvg($sport['key']) ?>
                </div>
                <span><?= $sport['label'] ?></span>
            </a>
            <?php endforeach; ?>
        </div>
    </div>

    <!-- RF2.5 – Clubes Seguidos -->
    <div class="home-section">
        <div class="home-section-header">
            <h2 class="home-section-title">Clubes seguidos</h2>
            <a href="<?= BASE_URL ?>clubs" class="home-section-link">Explorar &rarr;</a>
        </div>
        <?php if (!empty($followedClubs)): ?>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:0.75rem">
            <?php foreach ($followedClubs as $club): ?>
            <a href="<?= BASE_URL ?>clubs/detail/<?= (int)$club['club_id'] ?>" class="club-card">
                <div class="club-cover">
                    <?php if (!empty($club['cover_image'])): ?>
                    <img src="<?= htmlspecialchars($club['cover_image']) ?>" style="width:100%;height:100%;object-fit:cover" alt="">
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.5),transparent)"></div>
                    <?php elseif (!empty($club['logo'])): ?>
                    <div class="club-cover-placeholder" style="opacity:1">
                        <img src="<?= htmlspecialchars($club['logo']) ?>" style="width:3rem;height:3rem;object-fit:contain;border-radius:0.5rem" alt="">
                    </div>
                    <?php else: ?>
                    <div class="club-cover-placeholder">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="1.5">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <span class="club-dist-badge" style="background:rgba(var(--primary-rgb),0.5);border-color:rgba(var(--primary-rgb),0.3)">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                        Siguiendo
                    </span>
                </div>
                <div class="club-info">
                    <div class="club-name"><?= htmlspecialchars($club['club_name']) ?></div>
                    <div class="club-city">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 10-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                        <?= htmlspecialchars($club['city'] ?? 'Querétaro') ?>
                    </div>
                    <div class="club-cta">Ver canchas &rarr;</div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
        <?php else: ?>
        <div class="empty-cta" style="padding:1.5rem;text-align:center">
            <div class="empty-cta-icon" style="margin-bottom:0.75rem">
                <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                    <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <p style="font-size:0.8125rem;color:var(--text-sec);margin:0 0 0.875rem">Aún no sigues ningún club</p>
            <a href="<?= BASE_URL ?>clubs" class="home-cta-btn" style="font-size:0.8125rem;padding:0.5rem 1.25rem">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                    <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                </svg>
                Explorar clubes
            </a>
        </div>
        <?php endif; ?>
    </div>

    <!-- RF2.6 – Nearby Clubs -->
    <?php if (!empty($nearbyClubs)): ?>
    <div class="home-section">
        <div class="home-section-header">
            <h2 class="home-section-title">Cerca de ti</h2>
            <button onclick="requestLocation()"
                    style="display:flex;align-items:center;gap:0.3rem;font-size:0.75rem;font-weight:600;color:var(--primary);background:none;border:none;cursor:pointer;padding:0">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                    <line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/>
                    <line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/>
                </svg>
                Actualizar
            </button>
        </div>
        <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:0.75rem">
            <?php foreach ($nearbyClubs as $club): ?>
            <a href="<?= BASE_URL ?>clubs/detail/<?= $club['id'] ?>" class="club-card">
                <div class="club-cover">
                    <?php if (!empty($club['cover_image'])): ?>
                    <img src="<?= htmlspecialchars($club['cover_image']) ?>" style="width:100%;height:100%;object-fit:cover" alt="">
                    <div style="position:absolute;inset:0;background:linear-gradient(to top,rgba(0,0,0,0.5),transparent)"></div>
                    <?php else: ?>
                    <div class="club-cover-placeholder">
                        <svg width="36" height="36" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.6)" stroke-width="1.5">
                            <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                        </svg>
                    </div>
                    <?php endif; ?>
                    <?php if (!empty($club['distance_km'])): ?>
                    <span class="club-dist-badge">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 10-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                        <?= number_format($club['distance_km'], 1) ?> km
                    </span>
                    <?php endif; ?>
                </div>
                <div class="club-info">
                    <div class="club-name"><?= htmlspecialchars($club['name']) ?></div>
                    <div class="club-city">
                        <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 10-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                        <?= htmlspecialchars($club['city'] ?? 'Querétaro') ?>
                    </div>
                    <div class="club-cta">Ver canchas &rarr;</div>
                </div>
            </a>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Active Reservations -->
    <?php if (!empty($activeReservations)): ?>
    <div class="home-section">
        <div class="home-section-header">
            <h2 class="home-section-title">Mis Reservaciones</h2>
            <a href="<?= BASE_URL ?>reservations/history" class="home-section-link">Ver historial &rarr;</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.5rem">
            <?php foreach (array_slice($activeReservations, 0, 5) as $res):
                $nowTs   = time();
                $resDate = $res['date'];
                $startTs = strtotime($resDate . ' ' . $res['start_time']);
                $endTs   = strtotime($resDate . ' ' . $res['end_time']);
                $isNow   = $nowTs >= $startTs && $nowTs < $endTs;
                $isSoon  = !$isNow && $startTs > $nowTs && ($startTs - $nowTs) < 7200;
                if ($isNow)        { $badgeClass = 'res-badge-now';  $badgeText = 'En curso'; }
                elseif ($isSoon)   { $badgeClass = 'res-badge-soon'; $badgeText = 'Próxima'; }
                elseif ($res['status'] === 'pending') { $badgeClass = 'res-badge-pend'; $badgeText = 'Pendiente'; }
                else               { $badgeClass = 'res-badge-soon'; $badgeText = 'Confirmada'; }
                $qrData = htmlspecialchars($res['qr_code'] ?? ('RES-' . $res['id']), ENT_QUOTES);
                $spaceName = htmlspecialchars($res['space_name'], ENT_QUOTES);
                $clubName  = htmlspecialchars($res['club_name'] ?? '', ENT_QUOTES);
                $dateLabel = htmlspecialchars(date('d/m/Y', strtotime($resDate)), ENT_QUOTES);
                $timeLabel = htmlspecialchars(substr($res['start_time'],0,5).' – '.substr($res['end_time'],0,5), ENT_QUOTES);
                $total     = htmlspecialchars('$'.number_format($res['total'],0), ENT_QUOTES);
            ?>
            <div class="res-row"
                 onclick="openResModal('<?= $qrData ?>','<?= $spaceName ?>','<?= $clubName ?>','<?= $dateLabel ?>','<?= $timeLabel ?>','<?= $total ?>')">
                <div class="res-icon">
                    <?= sportSvg($res['sport_type'] ?? 'football') ?>
                </div>
                <div style="flex:1;min-width:0">
                    <p style="font-weight:600;font-size:0.875rem;color:var(--text-pri);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin:0"><?= htmlspecialchars($res['space_name']) ?></p>
                    <p style="font-size:0.7rem;color:var(--text-muted);margin:1px 0 0"><?= htmlspecialchars($res['club_name'] ?? '') ?></p>
                    <span class="<?= $badgeClass ?>"><?= $badgeText ?></span>
                </div>
                <div style="text-align:right;flex-shrink:0">
                    <p style="font-weight:700;font-size:0.875rem;color:var(--text-pri);margin:0">$<?= number_format($res['total'],0) ?></p>
                    <p style="font-size:0.68rem;color:var(--text-muted);margin:2px 0 0"><?= date('d/m', strtotime($res['date'])) ?> · <?= substr($res['start_time'],0,5) ?></p>
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="var(--primary)" stroke-width="2" style="margin-top:4px"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/></svg>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <!-- Empty state CTA -->
    <div class="home-section empty-cta">
        <div class="empty-cta-icon">
            <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
            </svg>
        </div>
        <h3 style="font-family:'Jockey One',sans-serif;font-size:1.0625rem;color:var(--text-pri);margin:0 0 0.375rem">Tu primera reserva</h3>
        <p style="font-size:0.8125rem;color:var(--text-sec);margin:0 0 1.25rem">Encuentra la cancha perfecta y empieza a jugar</p>
        <a href="<?= BASE_URL ?>reservations/search" class="home-cta-btn">
            <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
            </svg>
            Buscar Canchas
        </a>
    </div>
    <?php endif; ?>

</div>

<!-- ── QR Modal (RF2.2) ──────────────────────────────────────── -->
<div id="qrModal" style="display:none" class="qr-backdrop" onclick="closeQrModal()">
    <div class="qr-sheet" onclick="event.stopPropagation()">
        <button onclick="closeQrModal()"
                style="position:absolute;top:0.875rem;right:0.875rem;background:none;border:none;cursor:pointer;color:var(--text-sec)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                <line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/>
            </svg>
        </button>
        <h3 style="font-family:'Jockey One',sans-serif;font-size:1.125rem;color:var(--text-pri);margin:0">QR de Acceso</h3>
        <p id="qrSpaceName" style="font-size:0.75rem;color:var(--text-muted);margin:0.25rem 0 0"></p>
        <!-- Reservation detail rows -->
        <div id="qrResInfo" style="background:rgba(var(--primary-rgb),0.07);border:1px solid rgba(var(--primary-rgb),0.15);border-radius:0.75rem;padding:0.625rem 0.875rem;margin:0.75rem 0;text-align:left;font-size:0.78rem;display:none">
        </div>
        <div class="qr-canvas-wrap">
            <div id="qrcode"></div>
        </div>
        <p id="qrCodeText" style="font-family:monospace;font-size:0.68rem;color:var(--text-muted);word-break:break-all;margin-bottom:0.75rem"></p>
        <p style="font-size:0.7rem;color:var(--text-muted)">Muestra este código en la entrada del club</p>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
/* ── GPS for nearby clubs (RF2.6) ─────────────────────── */
function requestLocation() {
    if (!navigator.geolocation) return;
    navigator.geolocation.getCurrentPosition(function(pos) {
        fetch('<?= BASE_URL ?>home/save-location', {
            method: 'POST',
            headers: {'Content-Type': 'application/x-www-form-urlencoded'},
            body: 'lat=' + pos.coords.latitude + '&lng=' + pos.coords.longitude
        }).then(function() { window.location.reload(); });
    });
}

// Quiet auto-request on first page load
if (!sessionStorage.getItem('ids_loc')) {
    sessionStorage.setItem('ids_loc', '1');
    if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(function(pos) {
            fetch('<?= BASE_URL ?>home/save-location', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'lat=' + pos.coords.latitude + '&lng=' + pos.coords.longitude
            });
        }, function(){});
    }
}

/* ── QR Modal ─────────────────────────────────────────── */
function openQrModal(code, spaceName, clubName, dateLabel, timeLabel, total) {
    document.getElementById('qrSpaceName').textContent = spaceName;
    document.getElementById('qrCodeText').textContent  = code;
    var info = document.getElementById('qrResInfo');
    if (clubName || dateLabel || timeLabel || total) {
        info.style.display = 'block';
        var rows = '';
        if (clubName)  rows += '<div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="color:var(--text-muted)">Club</span><span style="color:var(--text-pri);font-weight:600">' + clubName + '</span></div>';
        if (dateLabel) rows += '<div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="color:var(--text-muted)">Fecha</span><span style="color:var(--text-pri);font-weight:600">' + dateLabel + '</span></div>';
        if (timeLabel) rows += '<div style="display:flex;justify-content:space-between;margin-bottom:3px"><span style="color:var(--text-muted)">Horario</span><span style="color:var(--text-pri);font-weight:600">' + timeLabel + '</span></div>';
        if (total)     rows += '<div style="display:flex;justify-content:space-between"><span style="color:var(--text-muted)">Total</span><span style="color:var(--primary);font-weight:700">' + total + '</span></div>';
        info.innerHTML = rows;
    } else {
        info.style.display = 'none';
    }
    var wrap = document.getElementById('qrcode');
    wrap.innerHTML = '';
    var canvas = document.createElement('canvas');
    wrap.appendChild(canvas);
    QRCode.toCanvas(canvas, code, {width: 196, margin: 1, color:{dark:'#000',light:'#fff'}}, function(){});
    document.getElementById('qrModal').style.display = 'flex';
    try {
        if (window.screen && window.screen.brightness !== undefined) screen.brightness = 1;
    } catch(e) {}
}
function openResModal(code, spaceName, clubName, dateLabel, timeLabel, total) {
    openQrModal(code, spaceName, clubName, dateLabel, timeLabel, total);
}
function closeQrModal() {
    document.getElementById('qrModal').style.display = 'none';
    document.getElementById('qrcode').innerHTML = '';
}

/* ── Apply coupon ─────────────────────────────────────── */
</script>
