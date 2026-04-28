<?php
/* ── Sport SVG icon helper (mirrors home/index.php) ─────── */
if (!function_exists('searchSportSvg')) {
    function searchSportSvg(string $type): string {
        $icons = [
            'football'   => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3v3.5M12 20.5v-3m-5-11l2.5 3M16.5 6l-2.5 3M4.5 15l3-1.5m9 0l3 1.5" stroke="currentColor" stroke-width="1.4"/>',
            'padel'      => '<rect x="4" y="8" width="11" height="14" rx="3" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M15 11h2a2 2 0 012 2v0a2 2 0 01-2 2h-2" stroke="currentColor" stroke-width="1.8"/><line x1="8" y1="2" x2="11" y2="5" stroke="currentColor" stroke-width="1.8"/>',
            'tennis'     => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M3 12c0-3.3 2-6 4.5-6" stroke="currentColor" stroke-width="1.4"/><path d="M21 12c0 3.3-2 6-4.5 6" stroke="currentColor" stroke-width="1.4"/>',
            'basketball' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><line x1="12" y1="3" x2="12" y2="21" stroke="currentColor" stroke-width="1.4"/><line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.4"/>',
            'swimming'   => '<path d="M3 17c1.5 0 3-1 4.5-1s3 1 4.5 1 3-1 4.5-1 3 1 4.5 1" stroke="currentColor" stroke-width="1.8" fill="none"/><circle cx="19" cy="5" r="2" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M15 7l-4 4" stroke="currentColor" stroke-width="1.8"/>',
            'volleyball' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3c0 5 3 8 9 9" stroke="currentColor" stroke-width="1.4"/><path d="M12 21c0-5-3-8-9-9" stroke="currentColor" stroke-width="1.4"/>',
        ];
        $inner = $icons[$type] ?? $icons['football'];
        return '<svg viewBox="0 0 24 24" width="40" height="40" xmlns="http://www.w3.org/2000/svg">' . $inner . '</svg>';
    }
}

$sportAccents = [
    'football'   => ['a'=>'#10b981','b'=>'#059669'],
    'padel'      => ['a'=>'#3b82f6','b'=>'#1d4ed8'],
    'tennis'     => ['a'=>'#f59e0b','b'=>'#d97706'],
    'basketball' => ['a'=>'#f97316','b'=>'#ea580c'],
    'swimming'   => ['a'=>'#06b6d4','b'=>'#0891b2'],
    'volleyball' => ['a'=>'#8b5cf6','b'=>'#7c3aed'],
];
?>
<style>
.search-wrap { max-width: 100%; }
/* Filter panel */
.search-panel {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.25rem;
    padding: 1rem;
    margin-bottom: 1.25rem;
    backdrop-filter: blur(12px);
}
.search-input-wrap { position: relative; flex: 1; }
.search-input-wrap svg { position: absolute; left: 0.75rem; top: 50%; transform: translateY(-50%); pointer-events: none; color: var(--text-muted); }
.search-input {
    width: 100%;
    padding: 0.625rem 1rem 0.625rem 2.25rem;
    border-radius: 0.875rem;
    border: 1px solid var(--border-gl2);
    background: var(--bg-mid);
    color: var(--text-pri);
    font-size: 0.8125rem;
    font-family: 'Poppins', sans-serif;
    outline: none;
    transition: border-color 140ms;
}
.search-input:focus { border-color: rgba(var(--primary-rgb), 0.6); }
.search-input::placeholder { color: var(--text-muted); }
.search-btn {
    padding: 0.625rem 1.125rem;
    border-radius: 0.875rem;
    background: var(--primary);
    color: #fff;
    font-size: 0.8125rem;
    font-weight: 600;
    border: none;
    cursor: pointer;
    transition: filter 140ms;
    box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.35);
}
.search-btn:hover { filter: brightness(1.1); }
.date-input {
    flex: 1;
    padding: 0.5rem 0.75rem;
    border-radius: 0.875rem;
    border: 1px solid var(--border-gl2);
    background: var(--bg-mid);
    color: var(--text-pri);
    font-size: 0.8125rem;
    outline: none;
    transition: border-color 140ms;
    -webkit-appearance: none;
}
.date-input:focus { border-color: rgba(var(--primary-rgb), 0.6); }

/* Sport chips */
.chip-row { display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 4px; }
.chip-row::-webkit-scrollbar { display: none; }
.chip-row { -ms-overflow-style: none; scrollbar-width: none; }
.sport-chip {
    flex-shrink: 0;
    display: flex; align-items: center; gap: 0.375rem;
    padding: 0.375rem 0.875rem;
    border-radius: 20px;
    font-size: 0.78rem;
    font-weight: 600;
    text-decoration: none;
    border: 1px solid var(--border-gl);
    background: var(--bg-card);
    color: var(--text-sec);
    transition: all 140ms;
}
.sport-chip:hover { border-color: rgba(var(--primary-rgb), 0.5); color: var(--primary); }
.sport-chip.active { background: var(--primary); border-color: var(--primary); color: #fff; box-shadow: 0 3px 10px rgba(var(--primary-rgb), 0.35); }
.chip-dot { width: 6px; height: 6px; border-radius: 50%; background: currentColor; opacity: 0.6; }

/* Result grid */
.space-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(260px, 1fr)); gap: 0.875rem; }
.space-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1rem;
    overflow: hidden;
    transition: all 160ms ease;
    text-decoration: none;
    display: block;
}
.space-card:hover {
    border-color: rgba(var(--primary-rgb), 0.35);
    transform: translateY(-2px);
    box-shadow: 0 8px 24px rgba(var(--primary-rgb), 0.14);
}
.space-hero { height: 9rem; position: relative; overflow: hidden; display: flex; align-items: center; justify-content: center; }
.space-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.space-hero-overlay { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.55), transparent); }
.price-badge {
    position: absolute; top: 0.625rem; right: 0.625rem;
    background: rgba(0,0,0,0.45); backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.18);
    color: #fff; font-size: 0.75rem; font-weight: 700;
    padding: 0.2rem 0.55rem; border-radius: 20px;
}
.rating-badge {
    position: absolute; bottom: 0.625rem; left: 0.625rem;
    background: rgba(0,0,0,0.4); backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.15);
    color: #fff; font-size: 0.7rem; font-weight: 600;
    padding: 0.2rem 0.5rem; border-radius: 20px;
    display: flex; align-items: center; gap: 0.3rem;
}
.star-icon { color: #fbbf24; }
.space-body { padding: 0.875rem; }
.space-name { font-family: 'Jockey One', sans-serif; font-size: 0.9375rem; color: var(--text-pri); margin: 0 0 0.2rem; line-height: 1.25; }
.club-link { font-size: 0.75rem; font-weight: 600; color: var(--primary); text-decoration: none; }
.club-link:hover { text-decoration: underline; }
.addr-line { font-size: 0.7rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.3rem; margin-top: 0.25rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
.detail-btn {
    display: block; width: 100%;
    margin-top: 0.75rem;
    padding: 0.55rem;
    border-radius: 0.75rem;
    border: 1px solid rgba(var(--primary-rgb), 0.4);
    background: rgba(var(--primary-rgb), 0.08);
    color: var(--primary);
    font-size: 0.8125rem; font-weight: 700;
    text-align: center; text-decoration: none;
    transition: all 140ms;
}
.detail-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); box-shadow: 0 4px 12px rgba(var(--primary-rgb), 0.3); }

/* Count label */
.count-label { font-size: 0.75rem; color: var(--text-muted); margin-bottom: 0.5rem; }

/* Empty state */
.empty-state {
    text-align: center; padding: 3.5rem 1.5rem;
    background: var(--bg-card); border: 1px solid var(--border-gl); border-radius: 1.25rem;
}
.empty-icon {
    width: 3.5rem; height: 3.5rem; border-radius: 1rem;
    background: rgba(var(--primary-rgb), 0.12); color: var(--primary);
    margin: 0 auto 1rem; display: flex; align-items: center; justify-content: center;
}
.jockey-one { font-family: 'Jockey One', sans-serif; }
</style>

<div class="search-wrap">

    <!-- Filter panel -->
    <div class="search-panel">
        <form method="GET" id="searchForm">
            <div style="display:flex;gap:0.5rem;margin-bottom:0.75rem">
                <div class="search-input-wrap">
                    <svg width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                    <input type="text" name="q" value="<?= htmlspecialchars($query ?? '') ?>"
                        placeholder="Buscar canchas, clubs..." class="search-input">
                </div>
                <button type="submit" class="search-btn">Buscar</button>
            </div>

            <!-- Sport chips -->
            <div class="chip-row" style="margin-bottom:0.625rem">
                <?php
                $chips = [
                    ['val'=>'',           'label'=>'Todos'],
                    ['val'=>'football',   'label'=>'Fútbol'],
                    ['val'=>'padel',      'label'=>'Pádel'],
                    ['val'=>'tennis',     'label'=>'Tenis'],
                    ['val'=>'basketball', 'label'=>'Basketball'],
                    ['val'=>'swimming',   'label'=>'Natación'],
                    ['val'=>'volleyball', 'label'=>'Voleibol'],
                ];
                foreach ($chips as $chip):
                    $isActive = ($sportType ?? '') === $chip['val'];
                ?>
                <a href="?sport=<?= $chip['val'] ?><?= !empty($date) ? '&date='.urlencode($date) : '' ?><?= !empty($query) ? '&q='.urlencode($query) : '' ?>"
                   class="sport-chip <?= $isActive ? 'active' : '' ?>">
                    <span class="chip-dot"></span>
                    <?= htmlspecialchars($chip['label']) ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Date -->
            <div style="display:flex;gap:0.5rem">
                <input type="date" name="date" value="<?= htmlspecialchars($date ?? '') ?>"
                    min="<?= date('Y-m-d') ?>" class="date-input" onchange="this.form.submit()">
                <input type="hidden" name="sport" value="<?= htmlspecialchars($sportType ?? '') ?>">
                <input type="hidden" name="q" value="<?= htmlspecialchars($query ?? '') ?>">
            </div>
        </form>
    </div>

    <!-- Results -->
    <?php
    /* Build the list to render */
    if (!empty($spaces)) {
        $list      = $spaces;
        $listLabel = count($spaces) . ' cancha' . (count($spaces) !== 1 ? 's' : '') . ' disponible' . (count($spaces) !== 1 ? 's' : '');
    } elseif (!isset($sportType) || ($sportType === '' && empty($date) && empty($query))) {
        $list      = (new SpaceModel())->search('', '');
        $listLabel = 'Todas las canchas';
    } else {
        $list = [];
        $listLabel = '';
    }
    ?>

    <?php if (!empty($list)): ?>
    <p class="count-label"><?= htmlspecialchars($listLabel) ?></p>
    <div class="space-grid">
        <?php foreach ($list as $space):
            $acc = $sportAccents[$space['sport_type']] ?? ['a'=>'var(--primary)','b'=>'var(--secondary)'];
        ?>
        <div class="space-card">
            <div class="space-hero" style="background:linear-gradient(135deg,<?= $acc['a'] ?>,<?= $acc['b'] ?>)">
                <?php if (!empty($space['photo'])): ?>
                <img src="<?= htmlspecialchars($space['photo']) ?>" alt="">
                <div class="space-hero-overlay"></div>
                <?php else: ?>
                <div style="color:#fff;opacity:0.55"><?= searchSportSvg($space['sport_type'] ?? 'football') ?></div>
                <?php endif; ?>
                <span class="price-badge">$<?= number_format($space['price_per_hour'], 0) ?>/hr</span>
                <?php if (!empty($space['avg_rating']) && $space['avg_rating'] > 0): ?>
                <span class="rating-badge">
                    <svg class="star-icon" width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <?= number_format($space['avg_rating'], 1) ?>
                    <span style="opacity:0.65">(<?= (int)($space['review_count'] ?? 0) ?>)</span>
                </span>
                <?php endif; ?>
            </div>
            <div class="space-body">
                <p class="space-name"><?= htmlspecialchars($space['name']) ?></p>
                <a href="<?= BASE_URL ?>clubs/detail/<?= (int)($space['club_id'] ?? 0) ?>" class="club-link" onclick="event.stopPropagation()">
                    <?= htmlspecialchars($space['club_name'] ?? '') ?>
                </a>
                <p class="addr-line">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 10-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                    <?= htmlspecialchars($space['address'] ?? ($space['city'] ?? 'Querétaro, Qro.')) ?>
                </p>
                <a href="<?= BASE_URL ?>spaces/detail/<?= (int)$space['id'] ?><?= !empty($date) ? '?date='.urlencode($date) : '' ?>"
                   class="detail-btn">
                    Ver detalle
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php elseif ((isset($sportType) && $sportType !== '') || !empty($date) || !empty($query)): ?>
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <h3 class="jockey-one" style="font-size:1.0625rem;color:var(--text-pri);margin:0 0 0.375rem">Sin resultados</h3>
        <p style="font-size:0.8125rem;color:var(--text-sec);margin:0">Prueba con otros filtros o fechas</p>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">
            <svg width="26" height="26" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
        </div>
        <h3 class="jockey-one" style="font-size:1.0625rem;color:var(--text-pri);margin:0 0 0.375rem">Busca tu cancha ideal</h3>
        <p style="font-size:0.8125rem;color:var(--text-sec);margin:0">Usa los filtros para ver canchas disponibles</p>
    </div>
    <?php endif; ?>

</div>
