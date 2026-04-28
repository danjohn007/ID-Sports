<style>
/* Club detail — dark-theme design system variables from main.php */
.club-detail-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.125rem;
    margin-bottom: 0.875rem;
    overflow: hidden;
}
.club-section-title {
    font-weight: 600;
    font-size: 0.9375rem;
    color: var(--text-pri);
    display: flex; align-items: center; gap: 0.5rem;
    margin-bottom: 0.875rem;
}
.club-section-icon { color: var(--primary); flex-shrink: 0; }
/* Space card in club detail */
.cspace-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1rem;
    overflow: hidden;
    transition: all 150ms ease;
    display: block; text-decoration: none;
}
.cspace-card:hover {
    border-color: rgba(var(--primary-rgb), 0.4);
    transform: translateY(-2px);
    box-shadow: 0 6px 20px rgba(var(--primary-rgb), 0.15);
}
.cspace-hero {
    height: 7rem; position: relative;
    display: flex; align-items: center; justify-content: center;
    overflow: hidden;
}
.cspace-hero img { position: absolute; inset: 0; width: 100%; height: 100%; object-fit: cover; }
.cspace-hero-ov { position: absolute; inset: 0; background: linear-gradient(to top, rgba(0,0,0,0.55), transparent); }
.cspace-price {
    position: absolute; top: 0.5rem; right: 0.5rem;
    background: rgba(0,0,0,0.45); backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.15);
    color: #fff; font-size: 0.72rem; font-weight: 700;
    padding: 0.2rem 0.5rem; border-radius: 20px;
}
.cspace-body { padding: 0.75rem; }
.cspace-name { font-family: 'Jockey One', sans-serif; font-size: 0.9rem; color: var(--text-pri); margin: 0 0 0.25rem; }
.cspace-detail-btn {
    display: block; width: 100%; margin-top: 0.625rem;
    padding: 0.5rem; border-radius: 0.625rem;
    border: 1px solid rgba(var(--primary-rgb), 0.4);
    background: rgba(var(--primary-rgb), 0.08);
    color: var(--primary);
    font-size: 0.78rem; font-weight: 700;
    text-align: center; text-decoration: none;
    transition: all 140ms;
}
.cspace-detail-btn:hover { background: var(--primary); color: #fff; border-color: var(--primary); }
/* Follow */
.club-follow-btn {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.5rem 1.25rem; border-radius: 20px;
    font-size: 0.8125rem; font-weight: 700; cursor: pointer;
    border: 1px solid rgba(var(--primary-rgb), 0.5);
    background: rgba(var(--primary-rgb), 0.1); color: var(--primary);
    transition: all 140ms;
}
.club-follow-btn.following {
    background: var(--primary); border-color: var(--primary); color: #fff;
}
.club-follow-btn:hover { filter: brightness(1.1); }
.amenity-tag {
    display: inline-flex; align-items: center; gap: 0.3rem;
    background: rgba(var(--primary-rgb), 0.08);
    border: 1px solid rgba(var(--primary-rgb), 0.15);
    color: var(--text-sec); font-size: 0.78rem; font-weight: 500;
    padding: 0.35rem 0.75rem; border-radius: 20px;
}
.star-full { color: #fbbf24; }
.review-avatar {
    width: 2rem; height: 2rem; border-radius: 50%;
    background: var(--primary); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.78rem; flex-shrink: 0;
}
.jockey-one { font-family: 'Jockey One', sans-serif; }
.no-scroll::-webkit-scrollbar { display: none; }
.no-scroll { -ms-overflow-style: none; scrollbar-width: none; }
</style>

<?php
$sportAccentsClub = [
    'football'   => ['a'=>'#10b981','b'=>'#059669'],
    'padel'      => ['a'=>'#3b82f6','b'=>'#1d4ed8'],
    'tennis'     => ['a'=>'#f59e0b','b'=>'#d97706'],
    'basketball' => ['a'=>'#f97316','b'=>'#ea580c'],
    'swimming'   => ['a'=>'#06b6d4','b'=>'#0891b2'],
    'volleyball' => ['a'=>'#8b5cf6','b'=>'#7c3aed'],
];
function clubSportSvg(string $type, int $size = 32): string {
    $icons = [
        'football'   => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3v3.5M12 20.5v-3m-5-11l2.5 3M16.5 6l-2.5 3M4.5 15l3-1.5m9 0l3 1.5" stroke="currentColor" stroke-width="1.4"/>',
        'padel'      => '<rect x="4" y="8" width="11" height="14" rx="3" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M15 11h2a2 2 0 012 2v0a2 2 0 01-2 2h-2" stroke="currentColor" stroke-width="1.8"/>',
        'tennis'     => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M3 12c0-3.3 2-6 4.5-6" stroke="currentColor" stroke-width="1.4"/><path d="M21 12c0 3.3-2 6-4.5 6" stroke="currentColor" stroke-width="1.4"/>',
        'basketball' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><line x1="12" y1="3" x2="12" y2="21" stroke="currentColor" stroke-width="1.4"/><line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.4"/>',
        'swimming'   => '<path d="M3 17c1.5 0 3-1 4.5-1s3 1 4.5 1 3-1 4.5-1 3 1 4.5 1" stroke="currentColor" stroke-width="1.8" fill="none"/><circle cx="19" cy="5" r="2" fill="none" stroke="currentColor" stroke-width="1.8"/>',
        'volleyball' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.8"/><path d="M12 3c0 5 3 8 9 9" stroke="currentColor" stroke-width="1.4"/><path d="M12 21c0-5-3-8-9-9" stroke="currentColor" stroke-width="1.4"/>',
    ];
    return '<svg viewBox="0 0 24 24" width="'.$size.'" height="'.$size.'" xmlns="http://www.w3.org/2000/svg">'.($icons[$type]??$icons['football']).'</svg>';
}
?>

<div style="max-width:100%">

    <!-- Hero / Cover -->
    <div style="position:relative;height:13rem;border-radius:1.25rem;overflow:hidden;margin-bottom:1rem;background:linear-gradient(135deg,var(--primary),#6366f1);display:flex;align-items:center;justify-content:center">
        <?php if (!empty($club['cover_image'])): ?>
        <img src="<?= htmlspecialchars($club['cover_image']) ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover" alt="">
        <div style="position:absolute;inset:0;background:rgba(0,0,0,0.35)"></div>
        <?php elseif (!empty($club['logo'])): ?>
        <img src="<?= htmlspecialchars($club['logo']) ?>" style="width:5rem;height:5rem;object-fit:contain;border-radius:1rem;position:relative;z-index:1" alt="">
        <?php else: ?>
        <svg width="70" height="70" viewBox="0 0 24 24" fill="none" stroke="rgba(255,255,255,0.4)" stroke-width="1.2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
        <?php endif; ?>
        <!-- Back -->
        <a href="javascript:history.back()"
           style="position:absolute;top:0.875rem;left:0.875rem;width:2.5rem;height:2.5rem;border-radius:50%;background:rgba(0,0,0,0.4);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;border:1px solid rgba(255,255,255,0.15)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        </a>
    </div>

    <!-- Club Info -->
    <div class="club-detail-card">
        <div style="padding:1.125rem">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.875rem;flex-wrap:wrap">
                <div style="flex:1;min-width:0">
                    <h1 class="jockey-one" style="font-size:1.5rem;color:var(--text-pri);margin:0 0 0.25rem;line-height:1.2">
                        <?= htmlspecialchars($club['name']) ?>
                    </h1>
                    <div style="display:flex;align-items:center;gap:0.375rem;font-size:0.8rem;color:var(--text-muted)">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 10-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                        <?= htmlspecialchars(($club['address'] ?? '') . (($club['city'] ?? '') ? ', ' . $club['city'] : '')) ?>
                    </div>
                </div>
                <button id="clubFollowBtn" onclick="toggleClubFollow(<?= (int)$club['id'] ?>)"
                        class="club-follow-btn <?= !empty($isFollowing) ? 'following' : '' ?>">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" id="followIcon">
                        <?php if (!empty($isFollowing)): ?>
                        <polyline points="20 6 9 17 4 12"/>
                        <?php else: ?>
                        <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>
                        <?php endif; ?>
                    </svg>
                    <span id="clubFollowLabel"><?= !empty($isFollowing) ? 'Siguiendo' : 'Seguir' ?></span>
                </button>
            </div>

            <?php if (!empty($club['description'])): ?>
            <p style="font-size:0.8125rem;color:var(--text-sec);margin:0.875rem 0 0;line-height:1.7">
                <?= nl2br(htmlspecialchars($club['description'])) ?>
            </p>
            <?php endif; ?>

            <!-- Contact actions -->
            <div style="display:flex;gap:0.5rem;flex-wrap:wrap;margin-top:0.875rem;padding-top:0.875rem;border-top:1px solid var(--border-gl)">
                <?php if (!empty($club['whatsapp'])): ?>
                <a href="https://wa.me/<?= preg_replace('/\D/', '', $club['whatsapp']) ?>" target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.5rem 1rem;border-radius:20px;background:#25d366;color:#fff;font-size:0.78rem;font-weight:700;text-decoration:none">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.890-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    WhatsApp
                </a>
                <?php endif; ?>
                <?php if (!empty($club['address'])): ?>
                <a href="https://maps.google.com/?q=<?= urlencode($club['address']) ?>" target="_blank" rel="noopener"
                   style="display:inline-flex;align-items:center;gap:0.4rem;padding:0.5rem 1rem;border-radius:20px;background:rgba(var(--primary-rgb),0.1);color:var(--primary);font-size:0.78rem;font-weight:700;text-decoration:none;border:1px solid rgba(var(--primary-rgb),0.25)">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 10-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                    Ver en Mapa
                </a>
                <?php endif; ?>
            </div>
        </div>
    </div>

    <!-- Spaces by sport type -->
    <?php if (!empty($spaces)):
        $byType = [];
        foreach ($spaces as $s) {
            $byType[$s['sport_type']][] = $s;
        }
        $sportLabels = ['football'=>'Fútbol','padel'=>'Pádel','tennis'=>'Tenis','basketball'=>'Basketball','swimming'=>'Natación','volleyball'=>'Voleibol','other'=>'Otras canchas'];
    ?>
    <div class="club-detail-card">
        <div style="padding:1.125rem">
            <h2 class="club-section-title">
                <span class="club-section-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg></span>
                Canchas disponibles
            </h2>
            <?php foreach ($byType as $sportType => $sportSpaces): ?>
            <?php $acc = $sportAccentsClub[$sportType] ?? ['a'=>'var(--primary)','b'=>'#6366f1']; ?>
            <div style="margin-bottom:1.25rem">
                <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.625rem">
                    <div style="width:2rem;height:2rem;border-radius:0.5rem;background:linear-gradient(135deg,<?= $acc['a'] ?>,<?= $acc['b'] ?>);display:flex;align-items:center;justify-content:center;color:#fff;flex-shrink:0">
                        <?= clubSportSvg($sportType, 16) ?>
                    </div>
                    <span style="font-weight:700;font-size:0.875rem;color:var(--text-pri)"><?= htmlspecialchars($sportLabels[$sportType] ?? ucfirst($sportType)) ?></span>
                    <span style="font-size:0.72rem;color:var(--text-muted)"><?= count($sportSpaces) ?> cancha<?= count($sportSpaces) !== 1 ? 's' : '' ?></span>
                </div>
                <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:0.625rem">
                    <?php foreach ($sportSpaces as $s): ?>
                    <div class="cspace-card">
                        <div class="cspace-hero" style="background:linear-gradient(135deg,<?= $acc['a'] ?>,<?= $acc['b'] ?>)">
                            <?php if (!empty($s['photo'])): ?>
                            <img src="<?= htmlspecialchars($s['photo']) ?>" alt="">
                            <div class="cspace-hero-ov"></div>
                            <?php else: ?>
                            <div style="color:rgba(255,255,255,0.45)"><?= clubSportSvg($sportType, 36) ?></div>
                            <?php endif; ?>
                            <span class="cspace-price">$<?= number_format($s['price_per_hour'], 0) ?>/hr</span>
                        </div>
                        <div class="cspace-body">
                            <p class="cspace-name"><?= htmlspecialchars($s['name']) ?></p>
                            <p style="font-size:0.72rem;color:var(--text-muted);margin:0"><?= (int)($s['capacity'] ?? 2) ?> personas</p>
                            <a href="<?= BASE_URL ?>spaces/detail/<?= (int)$s['id'] ?>" class="cspace-detail-btn">
                                Ver detalle
                            </a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php else: ?>
    <div class="club-detail-card" style="padding:1.5rem;text-align:center">
        <svg width="28" height="28" viewBox="0 0 24 24" fill="none" stroke="var(--text-muted)" stroke-width="1.5" style="margin:0 auto 0.5rem"><path d="M3 9l9-7 9 7v11a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
        <p style="font-size:0.8125rem;color:var(--text-muted);margin:0">Sin canchas disponibles</p>
    </div>
    <?php endif; ?>

    <!-- Amenities -->
    <?php if (!empty($amenities)): ?>
    <div class="club-detail-card">
        <div style="padding:1.125rem">
            <h2 class="club-section-title">
                <span class="club-section-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></span>
                Amenidades
            </h2>
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem">
                <?php foreach ($amenities as $a): ?>
                <span class="amenity-tag">
                    <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
                    <?= htmlspecialchars($a['name']) ?>
                    <span style="color:var(--primary);font-weight:700;margin-left:0.2rem">$<?= number_format($a['price'], 0) ?></span>
                </span>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Reviews -->
    <?php if (!empty($reviews)): ?>
    <div class="club-detail-card">
        <div style="padding:1.125rem">
            <h2 class="club-section-title">
                <span class="club-section-icon">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#fbbf24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </span>
                Reseñas (<?= count($reviews) ?>)
            </h2>
            <div style="display:flex;flex-direction:column;gap:0.875rem">
                <?php foreach (array_slice($reviews, 0, 5) as $rev): ?>
                <div style="display:flex;gap:0.75rem;align-items:flex-start">
                    <div class="review-avatar"><?= strtoupper(substr($rev['user_name'] ?? 'U', 0, 1)) ?></div>
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.2rem">
                            <span style="font-size:0.8125rem;font-weight:600;color:var(--text-pri)"><?= htmlspecialchars($rev['user_name'] ?? 'Usuario') ?></span>
                            <?php if (!empty($rev['space_name'])): ?>
                            <span style="font-size:0.68rem;color:var(--text-muted)">&middot; <?= htmlspecialchars($rev['space_name']) ?></span>
                            <?php endif; ?>
                            <span class="star-full" style="margin-left:auto;font-size:0.75rem"><?= str_repeat('★', (int)($rev['rating'] ?? 5)) ?></span>
                        </div>
                        <?php if (!empty($rev['comment'])): ?>
                        <p style="font-size:0.78rem;color:var(--text-sec);margin:0;line-height:1.5"><?= htmlspecialchars($rev['comment']) ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

</div>

<script>
function toggleClubFollow(clubId) {
    fetch('<?= BASE_URL ?>clubs/toggle-follow/' + clubId, { method: 'POST' })
        .then(r => r.json())
        .then(data => {
            const btn = document.getElementById('clubFollowBtn');
            const lbl = document.getElementById('clubFollowLabel');
            if (data.following) {
                btn.classList.add('following');
                document.getElementById('followIcon').innerHTML = '<polyline points="20 6 9 17 4 12"/>';
                lbl.textContent = 'Siguiendo';
            } else {
                btn.classList.remove('following');
                document.getElementById('followIcon').innerHTML = '<path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/>';
                lbl.textContent = 'Seguir';
            }
        });
}
</script>
