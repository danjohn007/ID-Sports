<div class="max-w-2xl mx-auto pb-24 lg:pb-6">

    <!-- Hero / Back header -->
    <div class="relative -mx-6 -mt-6 mb-5">
        <div class="h-56 sm:h-72 bg-gradient-to-br from-sky-500 to-violet-600 flex items-center justify-center relative overflow-hidden">
            <?php if (!empty($space['photo'])): ?>
            <img src="<?= htmlspecialchars($space['photo']) ?>" alt="<?= htmlspecialchars($space['name']) ?>"
                 class="absolute inset-0 w-full h-full object-cover">
            <div class="absolute inset-0 bg-black/40"></div>
            <?php else: ?>
            <span class="text-8xl opacity-60">
                <?= $space['sport_type'] === 'football' ? '⚽' : ($space['sport_type'] === 'padel' ? '🎾' : ($space['sport_type'] === 'basketball' ? '🏀' : ($space['sport_type'] === 'swimming' ? '🏊' : ($space['sport_type'] === 'tennis' ? '🎾' : '🏃')))) ?>
            </span>
            <?php endif; ?>
            <!-- Back button -->
            <a href="javascript:history.back()"
               class="absolute top-4 left-4 w-10 h-10 bg-black/40 backdrop-blur rounded-full flex items-center justify-center text-white hover:bg-black/60 transition-all">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M19 12H5M12 5l-7 7 7 7"/></svg>
            </a>
            <!-- Share button -->
            <button onclick="shareSpace()"
               class="absolute top-4 right-4 w-10 h-10 bg-black/40 backdrop-blur rounded-full flex items-center justify-center text-white hover:bg-black/60 transition-all">
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="18" cy="5" r="3"/><circle cx="6" cy="12" r="3"/><circle cx="18" cy="19" r="3"/><line x1="8.59" y1="13.51" x2="15.42" y2="17.49"/><line x1="15.41" y1="6.51" x2="8.59" y2="10.49"/></svg>
            </button>
        </div>
    </div>

    <!-- Info card -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-5 mb-4">
        <div class="flex items-start justify-between gap-4">
            <div class="flex-1 min-w-0">
                <h1 class="text-xl font-bold text-gray-900 dark:text-white jockey-one leading-tight">
                    <?= htmlspecialchars($space['name']) ?>
                </h1>
                <p class="text-sky-600 dark:text-sky-400 font-medium text-sm mt-0.5">
                    <?= htmlspecialchars($space['club_name']) ?>
                </p>
            </div>
            <div class="text-right flex-shrink-0">
                <p class="text-2xl font-bold text-gray-900 dark:text-white">$<?= number_format($space['price_per_hour'], 0) ?></p>
                <p class="text-xs text-gray-400">/hora</p>
            </div>
        </div>

        <!-- Badges -->
        <div class="flex flex-wrap gap-2 mt-3">
            <span class="inline-flex items-center gap-1 bg-sky-50 dark:bg-sky-900/30 text-sky-700 dark:text-sky-300 text-xs font-medium px-3 py-1.5 rounded-full">
                <?= $space['sport_type'] === 'football' ? '⚽' : ($space['sport_type'] === 'padel' ? '🎾' : ($space['sport_type'] === 'basketball' ? '🏀' : '🏃')) ?>
                <?= ucfirst($space['sport_type']) ?>
            </span>
            <span class="inline-flex items-center gap-1 bg-gray-50 dark:bg-gray-700 text-gray-600 dark:text-gray-300 text-xs font-medium px-3 py-1.5 rounded-full">
                👥 <?= $space['capacity'] ?> personas
            </span>
            <?php if ($avgRating > 0): ?>
            <span class="inline-flex items-center gap-1 bg-amber-50 dark:bg-amber-900/30 text-amber-700 dark:text-amber-300 text-xs font-medium px-3 py-1.5 rounded-full">
                ⭐ <?= $avgRating ?> (<?= count($reviews) ?> reseñas)
            </span>
            <?php endif; ?>
        </div>

        <!-- Address + Maps -->
        <div class="mt-4 pt-4 border-t border-gray-100 dark:border-gray-700 flex items-center justify-between">
            <div class="flex items-start gap-2 text-sm text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 mt-0.5 flex-shrink-0 text-sky-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/><path d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
                <span><?= htmlspecialchars($space['club_address'] ?? 'Querétaro, Qro.') ?></span>
            </div>
            <a href="https://maps.google.com/?q=<?= urlencode($space['club_address'] ?? 'Querétaro México') ?>"
               target="_blank" rel="noopener"
               class="flex-shrink-0 flex items-center gap-1.5 text-xs font-medium text-sky-600 dark:text-sky-400 hover:text-sky-700 transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                </svg>
                Google Maps
            </a>
        </div>
    </div>

    <!-- Description -->
    <?php if (!empty($space['description'])): ?>
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-5 mb-4">
        <h2 class="font-semibold text-gray-900 dark:text-white mb-2 flex items-center gap-2">
            <span>📋</span> Descripción
        </h2>
        <p class="text-sm text-gray-600 dark:text-gray-300 leading-relaxed">
            <?= nl2br(htmlspecialchars($space['description'])) ?>
        </p>
    </div>
    <?php endif; ?>

    <!-- Calendar + Time Slots (RF3.3) -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-5 mb-4">
        <h2 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
            <span>📅</span> Elegir día y hora
        </h2>

        <!-- Day picker -->
        <div class="flex gap-2 overflow-x-auto pb-2 -mx-1 px-1 scrollbar-hide" id="dayPicker">
            <?php foreach ($slotsPreview as $date => $slots): ?>
            <?php
                $ts        = strtotime($date);
                $isToday   = $date === date('Y-m-d');
                $dayName   = $isToday ? 'Hoy' : mb_strtoupper(substr(date('D', $ts), 0, 3));
                $dayNum    = date('j', $ts);
                $hasSlots  = count(array_filter($slots, fn($s) => $s['available'])) > 0;
            ?>
            <button onclick="selectDay('<?= $date ?>')"
                    data-date="<?= $date ?>"
                    class="day-btn flex-shrink-0 flex flex-col items-center px-3.5 py-2.5 rounded-2xl border text-sm transition-all
                        <?= $isToday ? 'bg-sky-500 border-sky-500 text-white' : 'bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200' ?>
                        <?= !$hasSlots ? 'opacity-50' : '' ?>">
                <span class="text-xs font-medium opacity-75"><?= $dayName ?></span>
                <span class="text-xl font-bold leading-tight"><?= $dayNum ?></span>
            </button>
            <?php endforeach; ?>
        </div>

        <!-- Slots grid -->
        <div id="slotsContainer" class="mt-4">
            <?php
                $firstDate = array_key_first($slotsPreview);
                $firstSlots = $slotsPreview[$firstDate] ?? [];
            ?>
            <div id="slots-<?= $firstDate ?>">
                <?php if (empty($firstSlots)): ?>
                <p class="text-sm text-gray-400 text-center py-4">Sin horarios disponibles este día</p>
                <?php else: ?>
                <div class="grid grid-cols-4 sm:grid-cols-5 gap-2">
                    <?php foreach ($firstSlots as $slot): ?>
                    <button onclick="selectSlot('<?= $slot['time'] ?>', this)"
                            class="slot-btn py-2 px-1 rounded-xl text-xs font-semibold border transition-all
                                <?= $slot['available']
                                    ? 'border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-sky-400 hover:bg-sky-50 dark:hover:bg-sky-900/30 cursor-pointer'
                                    : 'border-gray-100 dark:border-gray-700 text-gray-300 dark:text-gray-600 bg-gray-50 dark:bg-gray-800/50 cursor-not-allowed' ?>"
                            <?= !$slot['available'] ? 'disabled' : '' ?>>
                        <?= $slot['time'] ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Duration selector (RF3.3.b) -->
        <div id="durationSection" class="mt-4 hidden">
            <p class="text-xs font-semibold text-gray-500 dark:text-gray-400 uppercase tracking-wider mb-2">Duración</p>
            <div class="flex gap-2">
                <?php foreach ([1, 1.5, 2] as $dur): ?>
                <button onclick="selectDuration(<?= $dur ?>, this)"
                        data-duration="<?= $dur ?>"
                        class="duration-btn flex-1 py-2 rounded-xl border text-sm font-medium transition-all
                            <?= $dur == 1 ? 'bg-sky-500 border-sky-500 text-white' : 'border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-sky-400' ?>">
                    <?= $dur == 1 ? '1h' : ($dur == 1.5 ? '1.5h' : '2h') ?>
                </button>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <!-- Amenities (RF3.4) -->
    <?php if (!empty($amenities)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-5 mb-4">
        <h2 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
            <span>🎯</span> Extras disponibles
        </h2>
        <div class="space-y-2" id="amenitiesList">
            <?php foreach ($amenities as $amenity): ?>
            <div class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700/50 rounded-xl">
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium text-gray-900 dark:text-white"><?= htmlspecialchars($amenity['name']) ?></p>
                    <p class="text-xs text-gray-500 dark:text-gray-400">$<?= number_format($amenity['price'], 2) ?> c/u</p>
                </div>
                <div class="flex items-center gap-2 ml-3">
                    <button onclick="changeQty(<?= $amenity['id'] ?>, -1)"
                        class="w-7 h-7 rounded-full bg-gray-200 dark:bg-gray-600 text-gray-600 dark:text-gray-200 font-bold text-sm flex items-center justify-center hover:bg-sky-100 transition-all">−</button>
                    <span id="qty-<?= $amenity['id'] ?>" class="w-6 text-center text-sm font-bold text-gray-900 dark:text-white" data-price="<?= $amenity['price'] ?>">0</span>
                    <button onclick="changeQty(<?= $amenity['id'] ?>, 1)"
                        class="w-7 h-7 rounded-full bg-sky-500 text-white font-bold text-sm flex items-center justify-center hover:bg-sky-600 transition-all">+</button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Reviews -->
    <?php if (!empty($reviews)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-5 mb-4">
        <h2 class="font-semibold text-gray-900 dark:text-white mb-3 flex items-center gap-2">
            <span>⭐</span> Reseñas (<?= count($reviews) ?>)
        </h2>
        <div class="space-y-3">
            <?php foreach (array_slice($reviews, 0, 3) as $review): ?>
            <div class="flex gap-3">
                <div class="w-8 h-8 rounded-full bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center text-white font-bold text-xs flex-shrink-0">
                    <?= strtoupper(substr($review['user_name'] ?? 'U', 0, 1)) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2">
                        <p class="text-xs font-semibold text-gray-900 dark:text-white"><?= htmlspecialchars($review['user_name'] ?? 'Usuario') ?></p>
                        <span class="text-yellow-400 text-xs"><?= str_repeat('★', (int)($review['rating'] ?? 5)) ?></span>
                    </div>
                    <p class="text-xs text-gray-500 dark:text-gray-400 mt-0.5 leading-relaxed"><?= htmlspecialchars($review['comment'] ?? '') ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <?php endif; ?>

    <!-- Spacer for fixed button -->
    <div class="h-24"></div>
</div>

<!-- Fixed Reserve Button -->
<div class="fixed bottom-16 lg:bottom-0 left-0 right-0 lg:left-64 bg-white dark:bg-gray-900 border-t border-gray-100 dark:border-gray-700 p-4 z-20">
    <div class="max-w-2xl mx-auto flex items-center gap-4">
        <div>
            <p class="text-xs text-gray-500 dark:text-gray-400">Total estimado</p>
            <p id="totalPrice" class="text-xl font-bold text-gray-900 dark:text-white">$<?= number_format($space['price_per_hour'], 0) ?></p>
        </div>
        <a id="reserveBtn"
           href="<?= BASE_URL ?>reservations/create/<?= $space['id'] ?>"
           class="flex-1 bg-sky-500 hover:bg-sky-600 text-white font-bold py-3.5 rounded-2xl text-center text-sm transition-all shadow-lg shadow-sky-500/30">
            RESERVAR HORARIO
        </a>
    </div>
</div>

<style>
.jockey-one { font-family: 'Jockey One', sans-serif; }
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>

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
    document.getElementById('durationSection').classList.add('hidden');

    // Update day button styles
    document.querySelectorAll('.day-btn').forEach(btn => {
        const isActive = btn.dataset.date === date;
        btn.className = btn.className
            .replace(/bg-sky-500 border-sky-500 text-white/g, '')
            .replace(/bg-white dark:bg-gray-700 border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200/g, '');
        if (isActive) {
            btn.classList.add('bg-sky-500', 'border-sky-500', 'text-white');
        } else {
            btn.classList.add('bg-white', 'dark:bg-gray-700', 'border-gray-200', 'dark:border-gray-600', 'text-gray-700', 'dark:text-gray-200');
        }
    });

    // Load slots via AJAX
    fetch(`<?= BASE_URL ?>spaces/slots/<?= $space['id'] ?>?date=${date}`)
        .then(r => r.json())
        .then(slots => {
            const container = document.getElementById('slotsContainer');
            if (!slots.length) {
                container.innerHTML = '<p class="text-sm text-gray-400 text-center py-4">Sin horarios disponibles este día</p>';
                return;
            }
            let html = '<div class="grid grid-cols-4 sm:grid-cols-5 gap-2">';
            slots.forEach(s => {
                const avail = s.available;
                html += `<button onclick="selectSlot('${s.time}', this)"
                    class="slot-btn py-2 px-1 rounded-xl text-xs font-semibold border transition-all ${avail
                        ? 'border-gray-200 dark:border-gray-600 text-gray-700 dark:text-gray-200 hover:border-sky-400 hover:bg-sky-50 cursor-pointer'
                        : 'border-gray-100 dark:border-gray-700 text-gray-300 bg-gray-50 cursor-not-allowed'}"
                    ${!avail ? 'disabled' : ''}>${s.time}</button>`;
            });
            html += '</div>';
            container.innerHTML = html;
        });
}

function selectSlot(time, btn) {
    selectedTime = time;
    document.querySelectorAll('.slot-btn').forEach(b => {
        b.classList.remove('bg-sky-500', 'border-sky-500', 'text-white');
    });
    btn.classList.add('bg-sky-500', 'border-sky-500', 'text-white');
    document.getElementById('durationSection').classList.remove('hidden');
    updateReserveBtn();
}

function selectDuration(dur, btn) {
    selectedDuration = dur;
    document.querySelectorAll('.duration-btn').forEach(b => {
        b.classList.remove('bg-sky-500', 'border-sky-500', 'text-white');
        b.classList.add('border-gray-200', 'text-gray-700');
    });
    btn.classList.add('bg-sky-500', 'border-sky-500', 'text-white');
    btn.classList.remove('border-gray-200', 'text-gray-700');
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
        const qty   = parseInt(el.textContent) || 0;
        const price = parseFloat(el.dataset.price) || 0;
        amenityTotal += qty * price;
    });
    updateTotal();
}

function updateTotal() {
    const base  = pricePerHour * selectedDuration;
    const total = base + amenityTotal;
    document.getElementById('totalPrice').textContent = '$' + total.toFixed(0);
    updateReserveBtn();
}

function updateReserveBtn() {
    if (!selectedTime) return;
    const endH = parseFloat(selectedTime.split(':')[0]) + selectedDuration;
    const endTime = Math.floor(endH).toString().padStart(2,'0') + ':' + (endH % 1 === 0.5 ? '30' : '00');
    const url = `<?= BASE_URL ?>reservations/create/${spaceId}?date=${selectedDate}&time=${selectedTime}&end_time=${endTime}`;
    document.getElementById('reserveBtn').href = url;
}

function shareSpace() {
    if (navigator.share) {
        navigator.share({
            title: '<?= htmlspecialchars($space['name']) ?>',
            text: '¡Mira esta cancha en ID Sports!',
            url: window.location.href
        });
    } else {
        navigator.clipboard.writeText(window.location.href);
        alert('Enlace copiado al portapapeles');
    }
}
</script>
