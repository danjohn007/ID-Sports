<style>
/* Space detail uses the global design-system variables from main.php */
.detail-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl);
    border-radius: 1.125rem;
    margin-bottom: 0.875rem;
    overflow: hidden;
}
.detail-card-body { padding: 1.125rem; }
.detail-section-title {
    font-weight: 600;
    font-size: 0.9375rem;
    color: var(--text-pri);
    display: flex; align-items: center; gap: 0.5rem;
    margin-bottom: 0.875rem;
}
.detail-section-icon { color: var(--primary); flex-shrink: 0; }
.badge-pill {
    display: inline-flex; align-items: center; gap: 0.3rem;
    background: rgba(var(--primary-rgb), 0.1);
    border: 1px solid rgba(var(--primary-rgb), 0.2);
    color: var(--primary);
    font-size: 0.75rem; font-weight: 600;
    padding: 0.25rem 0.75rem; border-radius: 20px;
}
.day-btn-det {
    flex-shrink: 0;
    display: flex; flex-direction: column; align-items: center;
    padding: 0.5rem 0.875rem; border-radius: 0.875rem;
    border: 1px solid var(--border-gl2);
    background: var(--bg-card);
    cursor: pointer; transition: all 140ms;
    min-width: 60px;
}
.day-btn-det:hover { border-color: rgba(var(--primary-rgb), 0.5); }
.day-btn-det.active-day { background: var(--primary); border-color: var(--primary); box-shadow: 0 4px 14px rgba(var(--primary-rgb), 0.35); }
.day-btn-det .d-label { font-size: 0.65rem; font-weight: 700; letter-spacing: 0.04em; color: var(--text-muted); }
.day-btn-det.active-day .d-label { color: rgba(255,255,255,0.75); }
.day-btn-det .d-num { font-family: 'Jockey One', sans-serif; font-size: 1.375rem; color: var(--text-pri); line-height: 1.1; }
.day-btn-det.active-day .d-num { color: #fff; }
.slot-btn-det {
    padding: 0.5rem 0.25rem; border-radius: 0.625rem;
    border: 1px solid var(--border-gl2);
    background: var(--bg-card);
    color: var(--text-sec); font-size: 0.78rem; font-weight: 600;
    cursor: pointer; transition: all 140ms; text-align: center;
}
.slot-btn-det:hover:not([disabled]) { border-color: rgba(var(--primary-rgb), 0.5); color: var(--primary); }
.slot-btn-det.active-slot { background: var(--primary); border-color: var(--primary); color: #fff; box-shadow: 0 3px 10px rgba(var(--primary-rgb), 0.3); }
.slot-btn-det:disabled { opacity: 0.35; cursor: not-allowed; }
.duration-btn-det {
    flex: 1; padding: 0.5rem; border-radius: 0.625rem;
    border: 1px solid var(--border-gl2); background: var(--bg-card);
    color: var(--text-sec); font-size: 0.8125rem; font-weight: 600;
    cursor: pointer; transition: all 140ms;
}
.duration-btn-det:hover { border-color: rgba(var(--primary-rgb), 0.5); color: var(--primary); }
.duration-btn-det.active-dur { background: var(--primary); border-color: var(--primary); color: #fff; }
.amenity-row {
    display: flex; align-items: center; justify-content: space-between;
    padding: 0.75rem;
    background: rgba(var(--primary-rgb), 0.05);
    border: 1px solid var(--border-gl); border-radius: 0.75rem;
    margin-bottom: 0.5rem;
}
.qty-btn {
    width: 1.75rem; height: 1.75rem; border-radius: 50%;
    border: none; cursor: pointer; font-weight: 700; font-size: 1rem;
    display: flex; align-items: center; justify-content: center;
    transition: all 140ms;
}
.qty-dec { background: rgba(255,255,255,0.08); color: var(--text-sec); }
.qty-dec:hover { background: rgba(var(--primary-rgb), 0.15); color: var(--primary); }
.qty-inc { background: var(--primary); color: #fff; }
.qty-inc:hover { filter: brightness(1.1); }
.review-avatar {
    width: 2rem; height: 2rem; border-radius: 50%;
    background: var(--primary); color: #fff;
    display: flex; align-items: center; justify-content: center;
    font-weight: 700; font-size: 0.78rem; flex-shrink: 0;
}
/* Follow button */
.follow-btn {
    display: inline-flex; align-items: center; gap: 0.4rem;
    padding: 0.3rem 0.875rem; border-radius: 20px;
    font-size: 0.78rem; font-weight: 700; cursor: pointer;
    border: 1px solid rgba(var(--primary-rgb), 0.45);
    background: rgba(var(--primary-rgb), 0.1); color: var(--primary);
    transition: all 140ms;
}
.follow-btn.following {
    background: var(--primary); border-color: var(--primary); color: #fff;
}
.follow-btn:hover { filter: brightness(1.1); }
/* Fixed bottom bar */
.reserve-bar {
    position: fixed; bottom: 60px; left: 0; right: 0;
    background: var(--bg-mid); border-top: 1px solid var(--border-gl);
    padding: 0.875rem 1rem; z-index: 20;
    display: flex; align-items: center; gap: 1rem;
}
@media(min-width:1024px){
    .reserve-bar { left: 256px; bottom: 0; }
}
.reserve-btn {
    flex: 1; padding: 0.875rem;
    background: var(--primary); color: #fff;
    border: none; border-radius: 0.875rem;
    font-weight: 700; font-size: 0.9375rem;
    cursor: pointer; text-align: center; text-decoration: none;
    display: block; transition: filter 140ms;
    box-shadow: 0 4px 16px rgba(var(--primary-rgb), 0.35);
}
.reserve-btn:hover { filter: brightness(1.1); }
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
.jockey-one { font-family: 'Jockey One', sans-serif; }
</style>

<?php
$sportAccentsDet = [
    'football'   => ['a'=>'#10b981','b'=>'#059669'],
    'padel'      => ['a'=>'#3b82f6','b'=>'#1d4ed8'],
    'tennis'     => ['a'=>'#f59e0b','b'=>'#d97706'],
    'basketball' => ['a'=>'#f97316','b'=>'#ea580c'],
    'swimming'   => ['a'=>'#06b6d4','b'=>'#0891b2'],
    'volleyball' => ['a'=>'#8b5cf6','b'=>'#7c3aed'],
];
$acc = $sportAccentsDet[$space['sport_type'] ?? 'football'] ?? ['a'=>'var(--primary)','b'=>'#6366f1'];

function detSportSvg(string $type, int $size = 80): string {
    $icons = [
        'football'   => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M12 3v3.5M12 20.5v-3m-5-11l2.5 3M16.5 6l-2.5 3M4.5 15l3-1.5m9 0l3 1.5" stroke="currentColor" stroke-width="1.2"/>',
        'padel'      => '<rect x="4" y="8" width="11" height="14" rx="3" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M15 11h2a2 2 0 012 2v0a2 2 0 01-2 2h-2" stroke="currentColor" stroke-width="1.4"/>',
        'tennis'     => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M3 12c0-3.3 2-6 4.5-6" stroke="currentColor" stroke-width="1.2"/><path d="M21 12c0 3.3-2 6-4.5 6" stroke="currentColor" stroke-width="1.2"/>',
        'basketball' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.4"/><line x1="12" y1="3" x2="12" y2="21" stroke="currentColor" stroke-width="1.2"/><line x1="3" y1="12" x2="21" y2="12" stroke="currentColor" stroke-width="1.2"/>',
        'swimming'   => '<path d="M3 17c1.5 0 3-1 4.5-1s3 1 4.5 1 3-1 4.5-1 3 1 4.5 1" stroke="currentColor" stroke-width="1.4" fill="none"/><circle cx="19" cy="5" r="2" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M15 7l-4 4" stroke="currentColor" stroke-width="1.4"/>',
        'volleyball' => '<circle cx="12" cy="12" r="9" fill="none" stroke="currentColor" stroke-width="1.4"/><path d="M12 3c0 5 3 8 9 9" stroke="currentColor" stroke-width="1.2"/><path d="M12 21c0-5-3-8-9-9" stroke="currentColor" stroke-width="1.2"/>',
    ];
    return '<svg viewBox="0 0 24 24" width="'.$size.'" height="'.$size.'" xmlns="http://www.w3.org/2000/svg">' . ($icons[$type] ?? $icons['football']) . '</svg>';
}
?>

<div style="max-width:100%;padding-bottom:6rem">

    <!-- Hero image / banner -->
    <div style="position:relative;height:14rem;border-radius:1.25rem;overflow:hidden;margin-bottom:1rem;background:linear-gradient(135deg,<?= $acc['a'] ?>,<?= $acc['b'] ?>);display:flex;align-items:center;justify-content:center">
        <?php if (!empty($space['photo'])): ?>
        <img src="<?= htmlspecialchars($space['photo']) ?>" style="position:absolute;inset:0;width:100%;height:100%;object-fit:cover" alt="">
        <div style="position:absolute;inset:0;background:rgba(0,0,0,0.3)"></div>
        <?php else: ?>
        <div style="color:rgba(255,255,255,0.45)"><?= detSportSvg($space['sport_type'] ?? 'football', 90) ?></div>
        <?php endif; ?>
        <!-- Back -->
        <a href="javascript:history.back()"
           style="position:absolute;top:0.875rem;left:0.875rem;width:2.5rem;height:2.5rem;border-radius:50%;background:rgba(0,0,0,0.4);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;color:#fff;text-decoration:none;border:1px solid rgba(255,255,255,0.15)">
            <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
        </a>
        <!-- Share -->
        <button onclick="shareSpace()"
                style="position:absolute;top:0.875rem;right:0.875rem;width:2.5rem;height:2.5rem;border-radius:50%;background:rgba(0,0,0,0.4);backdrop-filter:blur(6px);display:flex;align-items:center;justify-content:center;color:#fff;border:1px solid rgba(255,255,255,0.15);cursor:pointer">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
        </button>
    </div>

    <!-- Info card -->
    <div class="detail-card">
        <div class="detail-card-body">
            <div style="display:flex;align-items:flex-start;justify-content:space-between;gap:0.875rem">
                <div style="flex:1;min-width:0">
                    <h1 class="jockey-one" style="font-size:1.375rem;color:var(--text-pri);line-height:1.2;margin:0 0 0.25rem">
                        <?= htmlspecialchars($space['name']) ?>
                    </h1>
                    <div style="display:flex;align-items:center;gap:0.5rem;flex-wrap:wrap">
                        <a href="<?= BASE_URL ?>clubs/detail/<?= (int)($space['club_id'] ?? 0) ?>"
                           style="font-size:0.8125rem;font-weight:600;color:var(--primary);text-decoration:none"
                           onmouseover="this.style.textDecoration='underline'" onmouseout="this.style.textDecoration='none'">
                            <?= htmlspecialchars($space['club_name'] ?? '') ?>
                        </a>
                        <button id="followBtn" onclick="toggleFollow(<?= (int)($space['club_id'] ?? 0) ?>)"
                                class="follow-btn <?= !empty($isFollowing) ? 'following' : '' ?>">
                            <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5">
                                <?php if (!empty($isFollowing)): ?>
                                <polyline points="20 6 9 17 4 12"/>
                                <?php else: ?>
                                <line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/>
                                <?php endif; ?>
                            </svg>
                            <span id="followLabel"><?= !empty($isFollowing) ? 'Siguiendo' : 'Seguir' ?></span>
                        </button>
                    </div>
                </div>
                <div style="text-align:right;flex-shrink:0">
                    <p style="font-family:'Jockey One',sans-serif;font-size:1.5rem;color:var(--text-pri);margin:0;line-height:1">$<?= number_format($space['price_per_hour'], 0) ?></p>
                    <p style="font-size:0.7rem;color:var(--text-muted)">/hora</p>
                </div>
            </div>

            <!-- Badges -->
            <div style="display:flex;flex-wrap:wrap;gap:0.5rem;margin-top:0.875rem">
                <span class="badge-pill">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.59 13.41l-7.17 7.17a2 2 0 01-2.83 0L2 12V2h10l8.59 8.59a2 2 0 010 2.82z"/></svg>
                    <?= ucfirst(htmlspecialchars($space['sport_type'] ?? '')) ?>
                </span>
                <span class="badge-pill">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M17 21v-2a4 4 0 00-4-4H5a4 4 0 00-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    <?= (int)($space['capacity'] ?? 2) ?> personas
                </span>
                <?php if ($avgRating > 0): ?>
                <span class="badge-pill">
                    <svg width="11" height="11" viewBox="0 0 24 24" fill="currentColor" style="color:#fbbf24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                    <?= $avgRating ?> (<?= count($reviews) ?> reseña<?= count($reviews) !== 1 ? 's' : '' ?>)
                </span>
                <?php endif; ?>
            </div>

            <!-- Address -->
            <div style="display:flex;align-items:center;justify-content:space-between;margin-top:0.875rem;padding-top:0.875rem;border-top:1px solid var(--border-gl)">
                <div style="display:flex;align-items:center;gap:0.5rem;font-size:0.8125rem;color:var(--text-sec)">
                    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" style="color:var(--primary);flex-shrink:0"><circle cx="12" cy="10" r="3"/><path d="M12 21.7C17.3 17 20 13 20 10a8 8 0 10-16 0c0 3 2.7 6.9 8 11.7z"/></svg>
                    <span><?= htmlspecialchars($space['club_address'] ?? ($space['club_city'] ?? 'Querétaro, Qro.')) ?></span>
                </div>
                <a href="https://maps.google.com/?q=<?= urlencode($space['club_address'] ?? 'Querétaro México') ?>"
                   target="_blank" rel="noopener"
                   style="flex-shrink:0;display:flex;align-items:center;gap:0.3rem;font-size:0.75rem;font-weight:600;color:var(--primary);text-decoration:none">
                    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    Maps
                </a>
            </div>
        </div>
    </div>

    <!-- Description -->
    <?php if (!empty($space['description'])): ?>
    <div class="detail-card">
        <div class="detail-card-body">
            <h2 class="detail-section-title">
                <span class="detail-section-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 00-2 2v16a2 2 0 002 2h12a2 2 0 002-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg></span>
                Descripción
            </h2>
            <p style="font-size:0.8125rem;color:var(--text-sec);line-height:1.7;margin:0">
                <?= nl2br(htmlspecialchars($space['description'])) ?>
            </p>
        </div>
    </div>
    <?php endif; ?>

    <!-- Calendar + Time Slots -->
    <div class="detail-card">
        <div class="detail-card-body">
            <h2 class="detail-section-title">
                <span class="detail-section-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg></span>
                Elegir día y hora
            </h2>

            <!-- Day picker -->
            <div style="display:flex;gap:0.5rem;overflow-x:auto;padding-bottom:4px" class="scrollbar-hide" id="dayPicker">
                <?php foreach ($slotsPreview as $date => $slots): ?>
                <?php
                    $ts       = strtotime($date);
                    $isToday  = $date === date('Y-m-d');
                    $days_es  = ['Dom','Lun','Mar','Mié','Jue','Vie','Sáb'];
                    $dayLabel = $isToday ? 'Hoy' : strtoupper($days_es[(int)date('w', $ts)]);
                    $dayNum   = date('j', $ts);
                    $hasSlots = count(array_filter($slots, fn($s) => $s['available'])) > 0;
                ?>
                <button onclick="selectDay('<?= $date ?>')"
                        data-date="<?= $date ?>"
                        class="day-btn-det <?= $isToday ? 'active-day' : '' ?> <?= !$hasSlots ? '' : '' ?>"
                        style="<?= !$hasSlots ? 'opacity:0.45' : '' ?>">
                    <span class="d-label"><?= $dayLabel ?></span>
                    <span class="d-num"><?= $dayNum ?></span>
                </button>
                <?php endforeach; ?>
            </div>

            <!-- Slots grid -->
            <div id="slotsContainer" style="margin-top:1rem">
                <?php $firstDate = array_key_first($slotsPreview); $firstSlots = $slotsPreview[$firstDate] ?? []; ?>
                <?php if (empty($firstSlots)): ?>
                <p style="font-size:0.8125rem;color:var(--text-muted);text-align:center;padding:1rem 0">Sin horarios disponibles este día</p>
                <?php else: ?>
                <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0.5rem">
                    <?php foreach ($firstSlots as $slot): ?>
                    <button onclick="selectSlot('<?= $slot['time'] ?>', this)"
                            class="slot-btn-det <?= !$slot['available'] ? '' : '' ?>"
                            <?= !$slot['available'] ? 'disabled' : '' ?>>
                        <?= $slot['time'] ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>

            <!-- Duration -->
            <div id="durationSection" style="display:none;margin-top:1rem">
                <p style="font-size:0.7rem;font-weight:700;text-transform:uppercase;letter-spacing:0.06em;color:var(--text-muted);margin-bottom:0.5rem">Duración</p>
                <div style="display:flex;gap:0.5rem">
                    <?php foreach ([1, 1.5, 2] as $dur): ?>
                    <button onclick="selectDuration(<?= $dur ?>, this)"
                            data-duration="<?= $dur ?>"
                            class="duration-btn-det <?= $dur == 1 ? 'active-dur' : '' ?>">
                        <?= $dur == 1 ? '1h' : ($dur == 1.5 ? '1.5h' : '2h') ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Amenities -->
    <?php if (!empty($amenities)): ?>
    <div class="detail-card">
        <div class="detail-card-body">
            <h2 class="detail-section-title">
                <span class="detail-section-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="6"/><path d="M15.477 12.89L17 22l-5-3-5 3 1.523-9.11"/></svg></span>
                Extras disponibles
            </h2>
            <div id="amenitiesList">
                <?php foreach ($amenities as $amenity): ?>
                <div class="amenity-row">
                    <div style="flex:1;min-width:0">
                        <p style="font-size:0.875rem;font-weight:600;color:var(--text-pri);margin:0"><?= htmlspecialchars($amenity['name']) ?></p>
                        <p style="font-size:0.72rem;color:var(--text-muted);margin:2px 0 0">$<?= number_format($amenity['price'], 2) ?> c/u</p>
                    </div>
                    <div style="display:flex;align-items:center;gap:0.5rem;margin-left:0.75rem">
                        <button onclick="changeQty(<?= $amenity['id'] ?>, -1)" class="qty-btn qty-dec">−</button>
                        <span id="qty-<?= $amenity['id'] ?>" data-price="<?= $amenity['price'] ?>"
                              style="min-width:1.25rem;text-align:center;font-weight:700;font-size:0.875rem;color:var(--text-pri)">0</span>
                        <button onclick="changeQty(<?= $amenity['id'] ?>, 1)" class="qty-btn qty-inc">+</button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <?php endif; ?>

    <!-- Reviews -->
    <?php if (!empty($reviews)): ?>
    <div class="detail-card">
        <div class="detail-card-body">
            <h2 class="detail-section-title">
                <span class="detail-section-icon"><svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor" style="color:#fbbf24"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg></span>
                Reseñas (<?= count($reviews) ?>)
            </h2>
            <div style="display:flex;flex-direction:column;gap:0.875rem">
                <?php foreach (array_slice($reviews, 0, 5) as $rev): ?>
                <div style="display:flex;gap:0.75rem;align-items:flex-start">
                    <div class="review-avatar">
                        <?= strtoupper(substr($rev['user_name'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div style="flex:1;min-width:0">
                        <div style="display:flex;align-items:center;gap:0.5rem;margin-bottom:0.2rem">
                            <span style="font-size:0.8125rem;font-weight:600;color:var(--text-pri)"><?= htmlspecialchars($rev['user_name'] ?? 'Usuario') ?></span>
                            <span style="color:#fbbf24;font-size:0.75rem"><?= str_repeat('★', (int)($rev['rating'] ?? 5)) ?></span>
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

<!-- Fixed Reserve Bar -->
<div class="reserve-bar">
    <div>
        <p style="font-size:0.7rem;color:var(--text-muted);margin:0">Total estimado</p>
        <p id="totalPrice" style="font-family:'Jockey One',sans-serif;font-size:1.25rem;color:var(--text-pri);margin:0">$<?= number_format($space['price_per_hour'], 0) ?></p>
    </div>
    <a id="reserveBtn"
       href="<?= BASE_URL ?>reservations/create/<?= (int)$space['id'] ?>"
       class="reserve-btn">
        RESERVAR HORARIO
    </a>
</div>

<script src="https://cdn.jsdelivr.net/npm/qrcode/build/qrcode.min.js"></script>
<script>
const pricePerHour = <?= (float)($space['price_per_hour'] ?? 0) ?>;
const spaceId = <?= (int)$space['id'] ?>;
let selectedDate = '<?= $firstDate ?>';
let selectedTime = null;
let selectedDuration = 1;
let amenityTotal = 0;

function selectDay(date) {
    selectedDate = date;
    selectedTime = null;
    document.getElementById('durationSection').style.display = 'none';
    document.querySelectorAll('.day-btn-det').forEach(btn => {
        const active = btn.dataset.date === date;
        btn.classList.toggle('active-day', active);
    });
    fetch(`<?= BASE_URL ?>spaces/slots/<?= (int)$space['id'] ?>?date=${date}`)
        .then(r => r.json())
        .then(slots => {
            const c = document.getElementById('slotsContainer');
            if (!slots.length) {
                c.innerHTML = '<p style="font-size:0.8125rem;color:var(--text-muted);text-align:center;padding:1rem 0">Sin horarios disponibles</p>';
                return;
            }
            let html = '<div style="display:grid;grid-template-columns:repeat(4,1fr);gap:0.5rem">';
            slots.forEach(s => {
                html += `<button onclick="selectSlot('${s.time}',this)" class="slot-btn-det" ${!s.available?'disabled':''}>${s.time}</button>`;
            });
            html += '</div>';
            c.innerHTML = html;
        });
}

function selectSlot(time, btn) {
    selectedTime = time;
    document.querySelectorAll('.slot-btn-det').forEach(b => b.classList.remove('active-slot'));
    btn.classList.add('active-slot');
    document.getElementById('durationSection').style.display = 'block';
    updateReserveBtn();
}

function selectDuration(dur, btn) {
    selectedDuration = dur;
    document.querySelectorAll('.duration-btn-det').forEach(b => b.classList.remove('active-dur'));
    btn.classList.add('active-dur');
    updateTotal();
}

function changeQty(id, delta) {
    const el = document.getElementById('qty-' + id);
    let qty = parseInt(el.textContent) + delta;
    if (qty < 0) qty = 0;
    el.textContent = qty;
    updateAmenityTotal();
}

function updateAmenityTotal() {
    amenityTotal = 0;
    document.querySelectorAll('[id^="qty-"]').forEach(el => {
        amenityTotal += (parseInt(el.textContent)||0) * (parseFloat(el.dataset.price)||0);
    });
    updateTotal();
}

function updateTotal() {
    const total = pricePerHour * selectedDuration + amenityTotal;
    document.getElementById('totalPrice').textContent = '$' + total.toFixed(0);
    updateReserveBtn();
}

function updateReserveBtn() {
    if (!selectedTime) return;
    const endH = parseFloat(selectedTime.split(':')[0]) + selectedDuration;
    const endTime = Math.floor(endH).toString().padStart(2,'0') + ':' + (endH % 1 === 0.5 ? '30' : '00');
    document.getElementById('reserveBtn').href =
        `<?= BASE_URL ?>reservations/create/${spaceId}?date=${selectedDate}&time=${selectedTime}&end_time=${endTime}`;
}

function shareSpace() {
    if (navigator.share) {
        navigator.share({ title: '<?= htmlspecialchars($space['name'], ENT_QUOTES) ?>', url: window.location.href });
    } else {
        navigator.clipboard.writeText(window.location.href);
    }
}

function toggleFollow(clubId) {
    if (!clubId) return;
    fetch('<?= BASE_URL ?>clubs/toggle-follow/' + clubId, { method: 'POST' })
        .then(r => r.json())
        .then(data => {
            const btn = document.getElementById('followBtn');
            if (data.following) {
                btn.classList.add('following');
                btn.innerHTML = '<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg><span id="followLabel">Siguiendo</span>';
            } else {
                btn.classList.remove('following');
                btn.innerHTML = '<svg width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg><span id="followLabel">Seguir</span>';
            }
        });
}
</script>
