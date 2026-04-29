<?php
/* ── Sport SVG icon helper ──────────────────────────────── */
if (!function_exists('sportSvg')) {
function sportSvg(string $type): string {
    $icons = [
        'football'      => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3v3.5M12 20.5v-3m-5-11l2.5 3M16.5 6l-2.5 3M4.5 15l3-1.5m9 0l3 1.5" stroke="currentColor" stroke-width="1.4"/>',
        'football_sala' => '<rect x="3" y="3" width="18" height="18" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="4" fill="none" stroke="currentColor" stroke-width="1.4"/><line x1="3" y1="12" x2="8" y2="12" stroke="currentColor" stroke-width="1.4"/><line x1="16" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.4"/>',
        'futbol_7'      => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M10 8h3l-1.5 3H13l-3 5" stroke="currentColor" stroke-width="1.4" fill="none"/>',
        'futbol_rapido' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M9 8l6 4-6 4V8z" fill="currentColor"/>',
        'padel'         => '<rect x="4" y="8" width="11" height="14" rx="3" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M15 11h2a2 2 0 012 2v0a2 2 0 01-2 2h-2" stroke="currentColor" stroke-width="1.8"/><line x1="8" y1="2" x2="11" y2="5" stroke="currentColor" stroke-width="1.8"/>',
        'tennis'        => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M3 12c0-3.3 2-6 4.5-6" stroke="currentColor" stroke-width="1.4"/><path d="M21 12c0 3.3-2 6-4.5 6" stroke="currentColor" stroke-width="1.4"/>',
        'basketball'    => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><line x1="12" y1="3" x2="12" y2="21" stroke="currentColor" stroke-width="1.4"/><line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.4"/><path d="M5 5.5A12 12 0 0119 18.5" stroke="currentColor" stroke-width="1.4"/>',
        'volleyball'    => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3c0 5 3 8 9 9" stroke="currentColor" stroke-width="1.4"/><path d="M12 21c0-5-3-8-9-9" stroke="currentColor" stroke-width="1.4"/>',
        'swimming'      => '<path d="M3 17c1.5 0 3-1 4.5-1s3 1 4.5 1 3-1 4.5-1 3 1 4.5 1" stroke="currentColor" stroke-width="1.8" fill="none"/><circle cx="19" cy="5" r="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M15 7l-4 4" stroke="currentColor" stroke-width="1.8"/>',
        'baseball'      => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M9 3.6C10 8 10 16 9 20.4M15 3.6C14 8 14 16 15 20.4" stroke="currentColor" stroke-width="1.2"/>',
        'squash'        => '<rect x="4" y="10" width="9" height="12" rx="2" fill="none" stroke="currentColor" stroke-width="1.8"/><line x1="11" y1="4" x2="8" y2="8" stroke="currentColor" stroke-width="1.8"/><circle cx="14" cy="9" r="2" fill="none" stroke="currentColor" stroke-width="1.4"/>',
        'badminton'     => '<line x1="4" y1="20" x2="12" y2="8" stroke="currentColor" stroke-width="1.8"/><path d="M12 8c2-3 6-6 6-6s-1 4-4 6" stroke="currentColor" stroke-width="1.4" fill="none"/>',
        'gym'           => '<path d="M6 4v16M18 4v16M3 8h18M3 16h18" stroke="currentColor" stroke-width="1.8"/>',
        'yoga'          => '<circle cx="12" cy="5" r="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 7v6m-4 4s1-4 4-4 4 4 4 4" stroke="currentColor" stroke-width="1.8"/>',
        'cycling'       => '<circle cx="7" cy="16" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="17" cy="16" r="4" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M7 16l5-8 5 8" stroke="currentColor" stroke-width="1.4" fill="none"/>',
        'handball'      => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/>',
        'rugby'         => '<ellipse cx="12" cy="12" rx="9" ry="6" fill="none" stroke="currentColor" stroke-width="1.8"/>',
        'other'         => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><circle cx="12" cy="12" r="3" fill="currentColor" opacity=".5"/>',
    ];
    return '<svg viewBox="0 0 24 24" width="26" height="26" xmlns="http://www.w3.org/2000/svg">' . ($icons[$type] ?? $icons['other']) . '</svg>';
}
}

/* ── Default sport accents (fallback pre-migration) ─────── */
$sportAccentsFallback = [
    'football'=>['from'=>'#10b981','to'=>'#059669'],'football_sala'=>['from'=>'#16a34a','to'=>'#15803d'],
    'futbol_7'=>['from'=>'#22c55e','to'=>'#16a34a'],'futbol_rapido'=>['from'=>'#4ade80','to'=>'#22c55e'],
    'padel'=>['from'=>'#3b82f6','to'=>'#1d4ed8'],'tennis'=>['from'=>'#f59e0b','to'=>'#d97706'],
    'basketball'=>['from'=>'#f97316','to'=>'#ea580c'],'volleyball'=>['from'=>'#8b5cf6','to'=>'#7c3aed'],
    'swimming'=>['from'=>'#06b6d4','to'=>'#0891b2'],'baseball'=>['from'=>'#ef4444','to'=>'#dc2626'],
    'squash'=>['from'=>'#a78bfa','to'=>'#7c3aed'],'badminton'=>['from'=>'#fb923c','to'=>'#f97316'],
    'gym'=>['from'=>'#64748b','to'=>'#475569'],'yoga'=>['from'=>'#ec4899','to'=>'#db2777'],
    'cycling'=>['from'=>'#0ea5e9','to'=>'#0284c7'],'other'=>['from'=>'#94a3b8','to'=>'#64748b'],
];

/* ── Build home sport list from DB or fallback ──────────── */
$sportMap = !empty($sportTypeMap) ? $sportTypeMap : [];
if (empty($sportMap)) {
    $lblFallback = ['football'=>'Fútbol','football_sala'=>'Fútbol Sala','futbol_7'=>'Fútbol 7',
                    'futbol_rapido'=>'Fútbol Rápido','padel'=>'Pádel','tennis'=>'Tenis',
                    'basketball'=>'Basketball','volleyball'=>'Voleibol','swimming'=>'Natación',
                    'baseball'=>'Béisbol','squash'=>'Squash','badminton'=>'Badminton',
                    'gym'=>'Gimnasio','yoga'=>'Yoga','cycling'=>'Ciclismo','other'=>'Otro'];
    foreach ($sportAccentsFallback as $s => $acc) {
        $sportMap[$s] = ['slug'=>$s,'name'=>$lblFallback[$s] ?? ucfirst($s),
                          'color_from'=>$acc['from'],'color_to'=>$acc['to'],'image_path'=>null];
    }
}
$homeSports = array_values(array_slice($sportMap, 0, 8, true));
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
    font-size: 1.375rem;
    font-weight: 700;
    color: var(--text-pri);
    letter-spacing: 0.01em;
}
.home-section-link {
    font-size: 0.8125rem;
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

/* ── Today Ticket Card ──────────────────────────────────── */
.today-ticket-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl2);
    border-radius: 1.375rem;
    overflow: hidden;
    box-shadow: 0 10px 36px rgba(0,0,0,0.4);
}
.today-ticket-head {
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    padding: 1.125rem 1.25rem;
}
.today-ticket-body {
    padding: 1rem 1.25rem;
}

/* ── Recent reservation Glassmorphism card ──────────────── */
.recent-res-card {
    display: flex;
    align-items: center;
    gap: 0.875rem;
    padding: 0.875rem 1rem;
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.125rem;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    text-decoration: none;
    transition: all 180ms ease;
}
.recent-res-card:hover {
    background: var(--bg-card-hover);
    border-color: rgba(var(--primary-rgb), 0.4);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(0,0,0,0.25);
}
.recent-res-icon {
    flex-shrink: 0;
    width: 2.75rem;
    height: 2.75rem;
    border-radius: 0.75rem;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    display: flex;
    align-items: center;
    justify-content: center;
    color: #fff;
}

/* ── Today widget ──────────────────────────────────────── */
.today-card {
    position: relative;
    border-radius: 1.25rem;
    padding: 1.25rem 1.375rem;
    color: #fff;
    overflow: hidden;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
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

/* ── Side-by-side grid: Reservar por Día + Deportes ─────── */
.days-sports-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    align-items: start;
    margin-bottom: 1.75rem;
}
.days-sports-grid > .home-section { margin-bottom: 0; min-width: 0; }
@media (max-width: 767px) {
    .days-sports-grid { grid-template-columns: 1fr; }
}

/* ── Side-by-side grid: Clubes seguidos + Cerca de ti ────── */
.clubs-nearby-grid {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 1rem;
    align-items: start;
    margin-bottom: 1.75rem;
}
.clubs-nearby-grid > .home-section { margin-bottom: 0; min-width: 0; }
@media (max-width: 767px) {
    .clubs-nearby-grid { grid-template-columns: 1fr; }
}

/* ── Day pills ─────────────────────────────────────────── */
.day-pill {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 1.25rem 1rem;
    border-radius: 1.25rem;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    text-decoration: none;
    min-width: 108px;
    transition: all 300ms ease;
    box-shadow: 0 2px 12px rgba(0,0,0,0.25);
    transform-origin: center;
}
.day-pill:hover {
    background: rgba(255,255,255,0.09);
    border-color: rgba(var(--primary-rgb), 0.55);
    transform: scale(1.05);
    box-shadow: 0 8px 24px rgba(var(--primary-rgb),0.25);
}
.day-pill.active {
    background: var(--primary);
    border-color: var(--primary);
    box-shadow: 0 6px 22px rgba(var(--primary-rgb), 0.5);
    transform: scale(1.04);
}
.day-pill .day-label { font-size: 0.75rem; font-weight: 700; color: var(--text-muted); letter-spacing: 0.05em; text-transform: uppercase; }
.day-pill.active .day-label { color: rgba(255,255,255,0.8); }
.day-pill .day-num { font-family: 'Jockey One', sans-serif; font-size: 2.5rem; color: var(--text-pri); line-height: 1.05; margin: 0.15rem 0; }
.day-pill.active .day-num { color: #fff; }
.day-pill .day-avail { font-size: 0.72rem; font-weight: 600; color: var(--text-muted); margin-top: 4px; }
.day-pill.active .day-avail { color: rgba(255,255,255,0.75); }

/* ── Carousel wrapper ──────────────────────────────────── */
.carousel-wrap {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0;
    min-width: 0;
}
.carousel-track {
    display: flex;
    gap: 0.5rem;
    overflow-x: auto;
    scroll-snap-type: x mandatory;
    scroll-behavior: smooth;
    padding: 4px 0 8px;
    flex: 1;
    min-width: 0;
}
.carousel-track > * { scroll-snap-align: start; }
.carousel-track::-webkit-scrollbar { display: none; }
.carousel-track { -ms-overflow-style: none; scrollbar-width: none; }
.carousel-btn {
    flex-shrink: 0;
    width: 2.125rem; height: 2.125rem;
    border-radius: 50%;
    background: var(--bg-card);
    border: 1px solid var(--border-gl2);
    display: flex; align-items: center; justify-content: center;
    cursor: pointer;
    color: var(--text-sec);
    transition: all 130ms;
    z-index: 2;
}
.carousel-btn:hover { background: var(--bg-card-hover); color: var(--primary); border-color: rgba(var(--primary-rgb),0.4); }
.carousel-btn.left  { margin-right: 0.375rem; }
.carousel-btn.right { margin-left: 0.375rem; }

/* ── Sport cards ───────────────────────────────────────── */
.sport-card {
    flex-shrink: 0;
    display: flex;
    flex-direction: column;
    align-items: center;
    gap: 0.6rem;
    padding: 1rem 0.75rem;
    border-radius: 1rem;
    text-decoration: none;
    border: 1px solid rgba(255,255,255,0.1);
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    transition: all 300ms ease;
    min-width: 108px;
    max-width: 128px;
    box-shadow: 0 2px 12px rgba(0,0,0,0.2);
    transform-origin: center;
}
.sport-card:hover {
    background: rgba(255,255,255,0.10);
    border-color: rgba(var(--primary-rgb), 0.55);
    transform: scale(1.05);
    box-shadow: 0 8px 28px rgba(var(--primary-rgb), 0.25);
}
.sport-icon-wrap {
    width: 3.5rem; height: 3.5rem;
    border-radius: 1rem;
    display: flex; align-items: center; justify-content: center;
    transition: transform 150ms;
    overflow: hidden;
}
.sport-icon-wrap svg { width: 30px; height: 30px; }
.sport-icon-wrap img { width: 100%; height: 100%; object-fit: contain; padding: 4px; }
.sport-card:hover .sport-icon-wrap { transform: scale(1.08); }
.sport-card span {
    font-family: 'Jockey One', sans-serif;
    font-size: 0.8rem;
    text-align: center;
    color: var(--text-sec);
    line-height: 1.2;
    word-break: break-word;
    max-width: 110px;
}

/* ── Club cards ─────────────────────────────────────────── */
.club-card {
    display: block;
    border-radius: 1rem;
    overflow: hidden;
    text-decoration: none;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 300ms ease;
    flex-shrink: 0;
    min-width: 220px;
    max-width: 280px;
    box-shadow: 0 2px 16px rgba(0,0,0,0.25);
    transform-origin: center;
}
.club-card:hover {
    background: rgba(255,255,255,0.09);
    border-color: rgba(var(--primary-rgb), 0.5);
    transform: scale(1.03);
    box-shadow: 0 10px 30px rgba(var(--primary-rgb), 0.2);
}
.club-cover { height: 9rem; position: relative; overflow: hidden; }
.club-cover-placeholder {
    width: 100%; height: 100%;
    background: linear-gradient(135deg, var(--primary) 0%, var(--secondary) 100%);
    display: flex; align-items: center; justify-content: center;
    opacity: 0.7;
}
.club-dist-badge {
    position: absolute; top: 0.5rem; right: 0.5rem;
    background: rgba(0,0,0,0.45);
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.15);
    color: #fff;
    font-size: 0.72rem; font-weight: 700;
    padding: 0.25rem 0.6rem; border-radius: 20px;
    display: flex; align-items: center; gap: 0.25rem;
}
.club-info { padding: 0.875rem; }
.club-name {
    font-family: 'Jockey One', sans-serif;
    font-size: 1rem;
    color: var(--text-pri);
    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
    margin-bottom: 0.25rem;
}
.club-city { font-size: 0.78rem; color: var(--text-sec); display: flex; align-items: center; gap: 0.25rem; }
.club-cta { font-size: 0.78rem; font-weight: 600; color: var(--primary); margin-top: 0.5rem; }

/* ── Active reservation rows ───────────────────────────── */
.res-row {
    display: flex; align-items: center; gap: 0.875rem;
    padding: 0.875rem;
    border-radius: 0.875rem;
    background: rgba(255,255,255,0.05);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
    transition: all 300ms ease;
    cursor: pointer;
    transform-origin: center;
}
.res-row:hover { border-color: rgba(var(--primary-rgb), 0.5); background: rgba(255,255,255,0.09); transform: scale(1.01); box-shadow: 0 6px 20px rgba(var(--primary-rgb),0.18); }
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
    background: rgba(255,255,255,0.04);
    backdrop-filter: blur(10px);
    -webkit-backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,0.1);
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
<div style="max-width:100%;overflow-x:hidden">

    <!-- RF2.1 – Header: Avatar + Greeting + Bell -->
    <div class="home-section" style="display:flex;align-items:center;gap:0.875rem;padding-top:0.25rem;padding-bottom:0.25rem;">
        <a href="<?= BASE_URL ?>user/profile" style="flex-shrink:0">
            <?php
            $__homeAvatarRaw = $_SESSION['user_avatar'] ?? '';
            $__homeAvatarSrc = (!empty($__homeAvatarRaw) && !preg_match('#^https?://#', $__homeAvatarRaw))
                               ? BASE_URL . ltrim($__homeAvatarRaw, '/')
                               : $__homeAvatarRaw;
            ?>
            <?php if (!empty($__homeAvatarSrc)): ?>
            <img src="<?= htmlspecialchars($__homeAvatarSrc) ?>"
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

    <!-- RF2.2 – Today's Tickets Carousel -->
    <?php if (!empty($todayReservations)): ?>
    <div class="home-section" id="todayTicketsSection">
        <div class="home-section-header">
            <h2 class="home-section-title">🎫 Tickets de Hoy</h2>
            <?php if (count($todayReservations) > 1): ?>
            <span style="font-size:0.8rem;color:var(--text-muted)"><?= count($todayReservations) ?> reservas</span>
            <?php endif; ?>
        </div>
        <?php if (count($todayReservations) > 1): ?>
        <div class="carousel-wrap">
            <button class="carousel-btn left" onclick="scrollCarousel('todayTrack',-1)" aria-label="Anterior">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
            </button>
            <div class="carousel-track" id="todayTrack" style="gap:0.875rem">
        <?php else: ?>
        <div style="display:flex" id="todayTrack">
        <?php endif; ?>

        <?php foreach ($todayReservations as $res):
            $nowTs   = time();
            $startTs = strtotime(date('Y-m-d') . ' ' . $res['start_time']);
            $diffH   = ($startTs - $nowTs) / 3600;
            if ($diffH <= 0)       $diffMsg = 'Ahora mismo';
            elseif ($diffH < 1)    $diffMsg = 'En ' . round($diffH * 60) . ' min';
            elseif ($diffH < 2)    $diffMsg = 'En 1 hora';
            else                   $diffMsg = 'En ' . round($diffH) . ' horas';

            $qrData    = $res['qr_code'] ?? ('RES-' . $res['id']);
            $spaceCost = (float)($res['subtotal'] ?? 0);
            $amenCost  = (float)($res['amenities_total'] ?? 0);
            $subT      = $spaceCost + $amenCost;
            $iva       = (float)($res['service_fee'] ?? 0);
            $total     = (float)($res['total'] ?? 0);

            $statusLabels = [
                'confirmed'   => 'Confirmada',
                'active'      => 'Activa',
                'in_progress' => 'En curso',
                'pending'     => 'Pendiente',
            ];
            $status = $res['status'] ?? 'confirmed';
        ?>
        <div class="today-ticket-card" style="flex-shrink:0;<?= count($todayReservations) > 1 ? 'min-width:min(88vw,340px)' : 'width:100%' ?>">
            <!-- Card Header (gradient) -->
            <div class="today-ticket-head">
                <div style="display:flex;justify-content:space-between;align-items:flex-start">
                    <div style="flex:1;min-width:0">
                        <p style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:rgba(255,255,255,0.7);margin:0 0 0.25rem">Ticket de Reserva</p>
                        <h3 style="font-family:'Jockey One',sans-serif;font-size:1.25rem;color:#fff;margin:0;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= htmlspecialchars($res['space_name']) ?></h3>
                        <p style="font-size:0.8rem;color:rgba(255,255,255,0.65);margin:0.15rem 0 0"><?= htmlspecialchars($res['club_name'] ?? '') ?></p>
                    </div>
                    <div style="flex-shrink:0;width:3rem;height:3rem;border-radius:0.875rem;background:rgba(255,255,255,0.15);display:flex;align-items:center;justify-content:center;color:#fff">
                        <?= sportSvg($res['sport_type'] ?? 'football') ?>
                    </div>
                </div>
                <div style="display:flex;align-items:center;gap:0.5rem;margin-top:0.75rem">
                    <span style="font-size:0.72rem;font-weight:700;background:rgba(255,255,255,0.2);color:#fff;padding:0.2rem 0.6rem;border-radius:20px">
                        <?= $statusLabels[$status] ?? ucfirst($status) ?>
                    </span>
                    <span style="font-size:0.78rem;color:rgba(255,255,255,0.75)"><?= $diffMsg ?> &middot; <?= substr($res['start_time'],0,5) ?> – <?= substr($res['end_time'],0,5) ?></span>
                </div>
            </div>
            <!-- Ticket Body: desglose -->
            <div class="today-ticket-body">
                <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.4rem">
                    <span style="color:var(--text-muted)">Fecha</span>
                    <span style="color:var(--text-pri);font-weight:600"><?= date('d/m/Y') ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.625rem">
                    <span style="color:var(--text-muted)">Horario</span>
                    <span style="color:var(--text-pri);font-weight:600"><?= substr($res['start_time'],0,5) ?> – <?= substr($res['end_time'],0,5) ?></span>
                </div>
                <hr style="border:none;border-top:1px dashed rgba(255,255,255,0.12);margin:0.5rem 0">
                <p style="font-size:0.68rem;font-weight:700;text-transform:uppercase;letter-spacing:0.08em;color:var(--text-muted);margin:0 0 0.5rem">Desglose de Pago</p>
                <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.375rem">
                    <span style="color:var(--text-muted)">Cancha</span>
                    <span style="color:var(--text-pri);font-weight:600">$<?= number_format($spaceCost,2) ?></span>
                </div>
                <?php if ($amenCost > 0): ?>
                <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.375rem">
                    <span style="color:var(--text-muted)">Amenidades</span>
                    <span style="color:var(--text-pri);font-weight:600">$<?= number_format($amenCost,2) ?></span>
                </div>
                <?php endif; ?>
                <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.375rem">
                    <span style="color:var(--text-muted);font-weight:600">Subtotal</span>
                    <span style="color:var(--text-pri);font-weight:600">$<?= number_format($subT,2) ?></span>
                </div>
                <div style="display:flex;justify-content:space-between;font-size:0.8rem;margin-bottom:0.375rem">
                    <span style="color:var(--text-muted)">IVA (16%)</span>
                    <span style="color:var(--text-pri);font-weight:600">$<?= number_format($iva,2) ?></span>
                </div>
                <hr style="border:none;border-top:1px dashed rgba(255,255,255,0.12);margin:0.5rem 0">
                <div style="display:flex;justify-content:space-between;align-items:baseline">
                    <span style="font-size:0.875rem;font-weight:700;color:var(--text-pri)">Total Pagado</span>
                    <span style="font-size:1.25rem;font-weight:800;color:#10b981">$<?= number_format($total,2) ?></span>
                </div>
            </div>
            <!-- Punch hole divider -->
            <div style="position:relative;margin:0;border-top:1.5px dashed rgba(255,255,255,0.1)">
                <div style="position:absolute;left:-0.75rem;top:50%;transform:translateY(-50%);width:1.25rem;height:1.25rem;border-radius:50%;background:var(--bg-mid)"></div>
                <div style="position:absolute;right:-0.75rem;top:50%;transform:translateY(-50%);width:1.25rem;height:1.25rem;border-radius:50%;background:var(--bg-mid)"></div>
            </div>
            <!-- QR -->
            <div style="text-align:center;padding:0.875rem 1.25rem 1.125rem">
                <p style="font-size:0.72rem;color:var(--text-muted);margin:0 0 0.625rem">Muestra este QR en la entrada del club</p>
                <div style="background:#fff;border-radius:0.75rem;padding:0.5rem;display:inline-block" class="today-qr-canvas" data-qr="<?= htmlspecialchars($qrData) ?>"></div>
                <p style="font-family:monospace;font-size:0.6rem;color:var(--text-muted);word-break:break-all;margin-top:0.375rem"><?= htmlspecialchars($qrData) ?></p>
            </div>
        </div>
        <?php endforeach; ?>

        <?php if (count($todayReservations) > 1): ?>
            </div><!-- /.carousel-track -->
            <button class="carousel-btn right" onclick="scrollCarousel('todayTrack',1)" aria-label="Siguiente">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
            </button>
        </div><!-- /.carousel-wrap -->
        <?php else: ?>
        </div>
        <?php endif; ?>
    </div>
    <?php endif; ?>

    <!-- RF2.3 + RF2.4 – Side-by-side: Reservar por Día | Deportes -->
    <div class="days-sports-grid">

        <!-- RF2.3 – 15-Day Quick Booking (Carousel) -->
        <div class="home-section">
            <div class="home-section-header">
                <h2 class="home-section-title">Anticipa tu jugada</h2>
                <a href="<?= BASE_URL ?>reservations/search" class="home-section-link">Ver todo &rarr;</a>
            </div>
            <div class="carousel-wrap">
                <button class="carousel-btn left" onclick="scrollCarousel('dayTrack',-1)" aria-label="Anterior">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="carousel-track" id="dayTrack">
                    <?php foreach ($upcomingDays as $idx => $day): ?>
                    <a href="<?= BASE_URL ?>reservations/search?date=<?= $day['date'] ?>"
                       class="day-pill <?= $idx === 0 ? 'active' : '' ?>">
                        <span class="day-label"><?= $day['label'] ?></span>
                        <span class="day-num"><?= $day['day_num'] ?></span>
                        <span class="day-avail"><?= $day['available'] ?> libre<?= $day['available'] != 1 ? 's' : '' ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn right" onclick="scrollCarousel('dayTrack',1)" aria-label="Siguiente">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>

        <!-- RF2.4 – Sport Categories (Carousel) -->
        <div class="home-section">
            <div class="home-section-header">
                <h2 class="home-section-title">Deportes</h2>
                <a href="<?= BASE_URL ?>reservations/search" class="home-section-link">Ver todos &rarr;</a>
            </div>
            <div class="carousel-wrap">
                <button class="carousel-btn left" onclick="scrollCarousel('sportTrack',-1)" aria-label="Anterior">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="carousel-track" id="sportTrack">
                    <?php foreach ($homeSports as $sport):
                        $from = htmlspecialchars($sport['color_from'] ?? 'var(--primary)');
                        $to   = htmlspecialchars($sport['color_to']   ?? 'var(--secondary)');
                        $slug = htmlspecialchars($sport['slug']);
                        $name = htmlspecialchars($sport['name']);
                    ?>
                    <a href="<?= BASE_URL ?>reservations/search?sport=<?= $slug ?>" class="sport-card">
                        <div class="sport-icon-wrap"
                             style="background:linear-gradient(135deg,<?= $from ?>,<?= $to ?>);color:#fff">
                            <?php if (!empty($sport['image_path'])): ?>
                            <img src="<?= BASE_URL . htmlspecialchars($sport['image_path']) ?>" alt="<?= $name ?>">
                            <?php else: ?>
                            <?= sportSvg($sport['slug']) ?>
                            <?php endif; ?>
                        </div>
                        <span><?= $name ?></span>
                    </a>
                    <?php endforeach; ?>
                </div>
                <button class="carousel-btn right" onclick="scrollCarousel('sportTrack',1)" aria-label="Siguiente">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
        </div>

    </div><!-- /.days-sports-grid -->
    <!-- RF2.5 + RF2.6 – Side-by-side: Clubes Seguidos | Cerca de ti -->
    <div class="clubs-nearby-grid">

        <!-- RF2.5 – Clubes Seguidos (Carousel) -->
        <div class="home-section">
            <div class="home-section-header">
                <h2 class="home-section-title">Clubes seguidos</h2>
                <a href="<?= BASE_URL ?>clubs" class="home-section-link">Explorar &rarr;</a>
            </div>
            <?php if (!empty($followedClubs)): ?>
            <div class="carousel-wrap">
                <button class="carousel-btn left" onclick="scrollCarousel('clubTrack',-1)" aria-label="Anterior">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="carousel-track" id="clubTrack">
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
                <button class="carousel-btn right" onclick="scrollCarousel('clubTrack',1)" aria-label="Siguiente">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
            <?php else: ?>
            <div class="empty-cta" style="padding:1.5rem;text-align:center">
                <div class="empty-cta-icon" style="margin-bottom:0.75rem">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <p style="font-size:0.875rem;color:var(--text-sec);margin:0 0 0.875rem">Aún no sigues ningún club</p>
                <a href="<?= BASE_URL ?>clubs" class="home-cta-btn" style="font-size:0.875rem;padding:0.55rem 1.25rem">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    Explorar clubes
                </a>
            </div>
            <?php endif; ?>
        </div>

        <!-- RF2.6 – Cerca de ti (Carousel) -->
        <div class="home-section">
            <div class="home-section-header">
                <h2 class="home-section-title">Cerca de ti</h2>
                <button onclick="requestLocation()"
                        style="display:flex;align-items:center;gap:0.3rem;font-size:0.8125rem;font-weight:600;color:var(--primary);background:none;border:none;cursor:pointer;padding:0">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                        <line x1="12" y1="2" x2="12" y2="5"/><line x1="12" y1="19" x2="12" y2="22"/>
                        <line x1="2" y1="12" x2="5" y2="12"/><line x1="19" y1="12" x2="22" y2="12"/>
                    </svg>
                    Actualizar
                </button>
            </div>
            <?php if (!empty($nearbyClubs)): ?>
            <div class="carousel-wrap">
                <button class="carousel-btn left" onclick="scrollCarousel('nearbyTrack',-1)" aria-label="Anterior">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="15 18 9 12 15 6"/></svg>
                </button>
                <div class="carousel-track" id="nearbyTrack">
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
                <button class="carousel-btn right" onclick="scrollCarousel('nearbyTrack',1)" aria-label="Siguiente">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="9 18 15 12 9 6"/></svg>
                </button>
            </div>
            <?php else: ?>
            <div class="empty-cta" style="padding:1.5rem;text-align:center">
                <div class="empty-cta-icon" style="margin-bottom:0.75rem">
                    <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6">
                        <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                </div>
                <p style="font-size:0.875rem;color:var(--text-sec);margin:0 0 0.875rem">Activa tu ubicación para ver clubes cercanos</p>
                <button onclick="requestLocation()" class="home-cta-btn" style="font-size:0.875rem;padding:0.55rem 1.25rem;border:none;cursor:pointer">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                        <circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="3"/>
                    </svg>
                    Activar ubicación
                </button>
            </div>
            <?php endif; ?>
        </div>

    </div><!-- /.clubs-nearby-grid -->

    <!-- Historial Reciente: last 3 reservations (Glassmorphism cards) -->
    <?php $displayReservations = !empty($recentReservations) ? $recentReservations : (!empty($activeReservations) ? array_slice($activeReservations, 0, 3) : []); ?>
    <?php if (!empty($displayReservations)): ?>
    <div class="home-section">
        <div class="home-section-header">
            <h2 class="home-section-title">Mis Reservaciones</h2>
            <a href="<?= BASE_URL ?>reservations/history" class="home-section-link">Ver historial &rarr;</a>
        </div>
        <div style="display:flex;flex-direction:column;gap:0.625rem">
            <?php foreach (array_slice($displayReservations, 0, 3) as $res):
                $status = $res['status'] ?? 'pending';
                $statusBadges = [
                    'confirmed'   => ['bg' => 'rgba(16,185,129,0.18)', 'color' => '#10b981', 'label' => 'Confirmada'],
                    'active'      => ['bg' => 'rgba(16,185,129,0.18)', 'color' => '#10b981', 'label' => 'Activa'],
                    'in_progress' => ['bg' => 'rgba(14,165,233,0.18)', 'color' => '#0ea5e9', 'label' => 'En curso'],
                    'pending'     => ['bg' => 'rgba(245,158,11,0.18)', 'color' => '#f59e0b', 'label' => 'Pendiente'],
                    'cancelled'   => ['bg' => 'rgba(239,68,68,0.18)',  'color' => '#ef4444', 'label' => 'Cancelada'],
                    'completed'   => ['bg' => 'rgba(148,163,184,0.15)','color' => '#94a3b8', 'label' => 'Completada'],
                ];
                $badge = $statusBadges[$status] ?? $statusBadges['pending'];
                $resId = (int)$res['id'];
            ?>
            <a class="recent-res-card" href="<?= BASE_URL ?>reservations/confirm?id=<?= $resId ?>">
                <div class="recent-res-icon">
                    <?= sportSvg($res['sport_type'] ?? 'football') ?>
                </div>
                <div style="flex:1;min-width:0">
                    <p style="font-weight:600;font-size:0.875rem;color:var(--text-pri);overflow:hidden;text-overflow:ellipsis;white-space:nowrap;margin:0"><?= htmlspecialchars($res['space_name'] ?? '') ?></p>
                    <p style="font-size:0.72rem;color:var(--text-muted);margin:0.125rem 0 0"><?= htmlspecialchars($res['club_name'] ?? '') ?></p>
                    <p style="font-size:0.72rem;color:var(--text-muted);margin:0.1rem 0 0">
                        <?= date('d/m/Y', strtotime($res['date'])) ?> &middot; <?= substr($res['start_time'],0,5) ?>–<?= substr($res['end_time'],0,5) ?>
                    </p>
                </div>
                <div style="text-align:right;flex-shrink:0">
                    <span style="font-size:0.7rem;font-weight:700;background:<?= $badge['bg'] ?>;color:<?= $badge['color'] ?>;padding:0.2rem 0.55rem;border-radius:20px;display:inline-block;margin-bottom:0.375rem"><?= $badge['label'] ?></span>
                    <p style="font-weight:700;font-size:0.9375rem;color:var(--text-pri);margin:0">$<?= number_format($res['total'],0) ?></p>
                </div>
            </a>
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

/* ── Carousel scroll helper ──────────────────────────── */
function scrollCarousel(trackId, dir) {
    var track = document.getElementById(trackId);
    if (!track) return;
    var itemW = track.firstElementChild ? track.firstElementChild.offsetWidth + 8 : 100;
    track.scrollBy({ left: dir * itemW, behavior: 'smooth' });
}

/* ── Generate QR codes for today's ticket cards ──────── */
document.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('.today-qr-canvas[data-qr]').forEach(function(el) {
        var code = el.getAttribute('data-qr');
        if (!code) return;
        var canvas = document.createElement('canvas');
        el.appendChild(canvas);
        QRCode.toCanvas(canvas, code, {width:140, margin:1, color:{dark:'#000',light:'#fff'}}, function(){});
    });
});
</script>
