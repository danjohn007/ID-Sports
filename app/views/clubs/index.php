<?php
$q           = $q           ?? '';
$stateFilter = $stateFilter ?? '';
$cityFilter  = $cityFilter  ?? '';
$states      = $states      ?? [];
$cities      = $cities      ?? [];
?>
<style>
/* ── Discover Page ──────────────────────────────────── */
.disc-title {
    font-family:'Jockey One',sans-serif;
    font-size:1.375rem;
    font-weight:700;
    color:var(--text-pri);
    margin:0 0 1.125rem;
}
/* Filter bar */
.disc-filter-bar {
    background: rgba(var(--bg-card-rgb, 255,255,255), 0.06);
    border: 1px solid var(--border-gl);
    border-radius: 1.25rem;
    backdrop-filter: blur(14px);
    -webkit-backdrop-filter: blur(14px);
    padding: 0.875rem 1rem;
    display: flex;
    flex-wrap: wrap;
    gap: 0.625rem;
    margin-bottom: 1.375rem;
    align-items: center;
}
.disc-search-wrap {
    flex: 1;
    min-width: 160px;
    position: relative;
}
.disc-search-wrap svg {
    position:absolute;
    left:0.75rem;
    top:50%;
    transform:translateY(-50%);
    color:var(--text-muted);
    pointer-events:none;
}
.disc-input {
    width: 100%;
    box-sizing: border-box;
    background: var(--bg-mid);
    border: 1px solid var(--border-gl);
    border-radius: 0.875rem;
    padding: 0.55rem 0.75rem 0.55rem 2.25rem;
    font-size: 0.84rem;
    color: var(--text-pri);
    outline: none;
    transition: border-color 140ms;
}
.disc-input:focus { border-color: rgba(var(--primary-rgb),0.5); }
.disc-select {
    background: var(--bg-mid);
    border: 1px solid var(--border-gl);
    border-radius: 0.875rem;
    padding: 0.55rem 0.875rem;
    font-size: 0.84rem;
    color: var(--text-pri);
    outline: none;
    cursor: pointer;
    transition: border-color 140ms;
    flex-shrink: 0;
}
.disc-select:focus { border-color: rgba(var(--primary-rgb),0.5); }

/* Club card grid */
.disc-grid {
    display: grid;
    grid-template-columns: 1fr;
    gap: 1.125rem;
}
@media (min-width: 560px) {
    .disc-grid { grid-template-columns: repeat(2, 1fr); }
}
@media (min-width: 900px) {
    .disc-grid { grid-template-columns: repeat(3, 1fr); }
}
@media (min-width: 1280px) {
    .disc-grid { grid-template-columns: repeat(4, 1fr); }
}

/* Club card */
.disc-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.375rem;
    overflow: visible;
    transition: transform 180ms ease, box-shadow 180ms ease, border-color 180ms;
    position: relative;
    display: flex;
    flex-direction: column;
}
.disc-card:hover {
    transform: translateY(-4px);
    box-shadow: 0 16px 42px rgba(0,0,0,0.35);
    border-color: rgba(var(--primary-rgb),0.35);
}
.disc-cover {
    height: 140px;
    background: linear-gradient(135deg, var(--primary), var(--secondary));
    position: relative;
    flex-shrink: 0;
    overflow: hidden;
    border-radius: 1.375rem 1.375rem 0 0;
}
.disc-cover img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.disc-cover-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    opacity: 0.55;
}
.disc-logo-wrap {
    position: absolute;
    top: calc(140px - 1.4375rem);   /* cover height minus half logo height */
    left: 1rem;
    width: 2.875rem;
    height: 2.875rem;
    border-radius: 50%;
    border: 3px solid var(--bg-card);
    background: var(--bg-mid);
    overflow: hidden;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.125rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.3);
    flex-shrink: 0;
    z-index: 3;
}
.disc-logo-wrap img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}
.disc-body {
    padding: 2rem 1rem 1rem;
    flex: 1;
    display: flex;
    flex-direction: column;
}
.disc-name {
    font-family: 'Jockey One', sans-serif;
    font-size: 1rem;
    color: var(--text-pri);
    margin: 0 0 0.2rem;
    overflow: hidden;
    text-overflow: ellipsis;
    white-space: nowrap;
}
.disc-location {
    font-size: 0.75rem;
    color: var(--text-muted);
    display: flex;
    align-items: center;
    gap: 0.3rem;
    margin-bottom: 0.625rem;
}
.disc-footer {
    display: flex;
    align-items: center;
    justify-content: space-between;
    margin-top: auto;
    padding-top: 0.625rem;
}
.disc-spaces-badge {
    font-size: 0.72rem;
    color: var(--text-muted);
}
.disc-follow-btn {
    font-size: 0.78rem;
    font-weight: 700;
    padding: 0.35rem 0.875rem;
    border-radius: 20px;
    border: 1.5px solid var(--primary);
    background: var(--primary);
    color: #fff;
    cursor: pointer;
    transition: all 140ms;
    text-decoration: none;
}
.disc-follow-btn:hover { opacity: 0.85; }
.disc-follow-btn.following {
    background: transparent;
    color: var(--primary);
}
.disc-follow-btn.following:hover {
    background: rgba(var(--primary-rgb),0.1);
    opacity: 1;
}

/* Empty state */
.disc-empty {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.25rem;
    padding: 3rem 1.5rem;
    text-align: center;
    grid-column: 1 / -1;
}
</style>

<div class="space-y-0">
    <h2 class="disc-title">Encuentra tu próximo club</h2>

    <!-- Filter Bar -->
    <div class="disc-filter-bar">
        <div class="disc-search-wrap">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
            <input type="text" id="discSearch" class="disc-input" placeholder="Buscar club por nombre…" value="<?= htmlspecialchars($q, ENT_QUOTES) ?>" oninput="discFilter()">
        </div>
        <?php if (!empty($states)): ?>
        <select id="discState" class="disc-select" onchange="discFilter()">
            <option value="">Estado</option>
            <?php foreach ($states as $s): ?>
            <option value="<?= htmlspecialchars($s, ENT_QUOTES) ?>" <?= $stateFilter === $s ? 'selected' : '' ?>><?= htmlspecialchars($s) ?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>
        <?php if (!empty($cities)): ?>
        <select id="discCity" class="disc-select" onchange="discFilter()">
            <option value="">Municipio</option>
            <?php foreach ($cities as $c): ?>
            <option value="<?= htmlspecialchars($c, ENT_QUOTES) ?>" <?= $cityFilter === $c ? 'selected' : '' ?>><?= htmlspecialchars($c) ?></option>
            <?php endforeach; ?>
        </select>
        <?php endif; ?>
    </div>

    <!-- Club Grid -->
    <div class="disc-grid" id="discGrid">
        <?php if (empty($clubs)): ?>
        <div class="disc-empty">
            <p style="font-size:2.5rem;margin:0 0 0.625rem">🏟️</p>
            <p style="font-family:'Jockey One',sans-serif;font-size:1rem;color:var(--text-pri);margin:0 0 0.3rem">Sin clubes disponibles</p>
            <p style="font-size:0.8125rem;color:var(--text-muted);margin:0">Prueba ajustando los filtros de búsqueda</p>
        </div>
        <?php else: foreach ($clubs as $club):
            $clubId      = (int)$club['id'];
            $isFollowing = !empty($club['is_following']);
            $location    = trim(($club['city'] ?? '') . ($club['state'] && $club['city'] ? ', ' : '') . ($club['state'] ?? ''));
            if (!$location) $location = $club['address'] ?? '';
        ?>
        <div class="disc-card" data-name="<?= htmlspecialchars(strtolower($club['name']), ENT_QUOTES) ?>" data-state="<?= htmlspecialchars(strtolower($club['state'] ?? ''), ENT_QUOTES) ?>" data-city="<?= htmlspecialchars(strtolower($club['city'] ?? ''), ENT_QUOTES) ?>">
            <!-- Cover -->
            <a href="<?= BASE_URL ?>clubs/detail/<?= $clubId ?>" class="disc-cover" style="display:block">
                <?php if (!empty($club['cover_image'])): ?>
                <img src="<?= htmlspecialchars($club['cover_image']) ?>" alt="<?= htmlspecialchars($club['name']) ?>">
                <?php else: ?>
                <div class="disc-cover-placeholder">🏟️</div>
                <?php endif; ?>
            </a>
            <!-- Floating logo (outside cover so overflow:hidden doesn't clip it) -->
            <div class="disc-logo-wrap">
                <?php if (!empty($club['logo'])): ?>
                <img src="<?= htmlspecialchars($club['logo']) ?>" alt="Logo">
                <?php else: ?>
                <span style="font-weight:800;font-size:1rem;color:var(--primary)"><?= strtoupper(substr($club['name'],0,1)) ?></span>
                <?php endif; ?>
            </div>
            <!-- Body -->
            <div class="disc-body">
                <a href="<?= BASE_URL ?>clubs/detail/<?= $clubId ?>" style="text-decoration:none">
                    <h3 class="disc-name"><?= htmlspecialchars($club['name']) ?></h3>
                </a>
                <?php if ($location): ?>
                <p class="disc-location">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="#f87171" stroke-width="2.5"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0118 0z"/><circle cx="12" cy="10" r="3"/></svg>
                    <?= htmlspecialchars($location) ?>
                </p>
                <?php endif; ?>
                <div class="disc-footer">
                    <span class="disc-spaces-badge"><?= (int)($club['space_count'] ?? 0) ?> espacio(s)</span>
                    <button
                        class="disc-follow-btn <?= $isFollowing ? 'following' : '' ?>"
                        data-club-id="<?= $clubId ?>"
                        onclick="toggleDiscFollow(this, <?= $clubId ?>)">
                        <?= $isFollowing ? 'Siguiendo' : 'Seguir' ?>
                    </button>
                </div>
            </div>
        </div>
        <?php endforeach; endif; ?>
    </div>
</div>

<script>
function discFilter() {
    var q     = (document.getElementById('discSearch')?.value || '').toLowerCase().trim();
    var state = (document.getElementById('discState')?.value  || '').toLowerCase().trim();
    var city  = (document.getElementById('discCity')?.value   || '').toLowerCase().trim();
    document.querySelectorAll('#discGrid .disc-card').forEach(function(card) {
        var nameMatch  = !q     || (card.getAttribute('data-name')  || '').indexOf(q)     !== -1;
        var stateMatch = !state || (card.getAttribute('data-state') || '').indexOf(state) !== -1;
        var cityMatch  = !city  || (card.getAttribute('data-city')  || '').indexOf(city)  !== -1;
        var show = nameMatch && stateMatch && cityMatch;
        card.style.display   = show ? '' : 'none';
        card.style.opacity   = show ? '1' : '0';
        card.style.transition = 'opacity 200ms';
    });
}

function toggleDiscFollow(btn, clubId) {
    btn.disabled = true;
    fetch('<?= BASE_URL ?>clubs/toggle-follow/' + clubId, {method: 'POST'})
        .then(function(r){ return r.json(); })
        .then(function(data) {
            btn.disabled = false;
            if (data.following) {
                btn.textContent = 'Siguiendo';
                btn.classList.add('following');
            } else {
                btn.textContent = 'Seguir';
                btn.classList.remove('following');
            }
        }).catch(function(){ btn.disabled = false; });
}
</script>
