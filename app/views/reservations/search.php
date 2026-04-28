<div class="max-w-4xl mx-auto space-y-5">

    <!-- Filter chips + search bar (RF3.1) -->
    <div class="bg-white dark:bg-gray-800 rounded-3xl shadow-sm border border-gray-100 dark:border-gray-700 p-4">
        <form method="GET" id="searchForm">
            <!-- Search bar -->
            <div class="flex gap-2 mb-3">
                <div class="flex-1 relative">
                    <svg class="absolute left-3 top-1/2 -translate-y-1/2 w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/>
                    </svg>
                    <input type="text" name="q" value="<?= htmlspecialchars($query ?? '') ?>"
                        placeholder="Buscar canchas, clubs..."
                        class="w-full pl-9 pr-4 py-2.5 rounded-2xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm text-gray-900 dark:text-white placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-sky-500 focus:border-transparent">
                </div>
                <button type="submit" class="px-4 py-2.5 rounded-2xl text-white text-sm font-semibold transition-colors" style="background:var(--primary)">
                    Buscar
                </button>
            </div>

            <!-- Sport chips (RF3.1) -->
            <div class="flex gap-2 overflow-x-auto pb-1 scrollbar-hide -mx-1 px-1">
                <?php
                $chips = [
                    ['val'=>'', 'label'=>'Todos', 'icon'=>'🏃'],
                    ['val'=>'football', 'label'=>'Fútbol', 'icon'=>'⚽'],
                    ['val'=>'padel', 'label'=>'Pádel', 'icon'=>'🎾'],
                    ['val'=>'tennis', 'label'=>'Tenis', 'icon'=>'🏸'],
                    ['val'=>'basketball', 'label'=>'Basketball', 'icon'=>'🏀'],
                    ['val'=>'swimming', 'label'=>'Natación', 'icon'=>'🏊'],
                    ['val'=>'volleyball', 'label'=>'Voleibol', 'icon'=>'🏐'],
                ];
                foreach ($chips as $chip):
                    $isActive = ($sportType ?? '') === $chip['val'];
                ?>
                <a href="?sport=<?= $chip['val'] ?><?= !empty($date) ? '&date='.urlencode($date) : '' ?><?= !empty($query) ? '&q='.urlencode($query) : '' ?>"
                   class="flex-shrink-0 flex items-center gap-1.5 px-3.5 py-1.5 rounded-full text-sm font-medium transition-all
                       <?= $isActive ? 'text-white shadow-md' : 'bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 hover:bg-gray-200 dark:hover:bg-gray-600' ?>"
                   <?= $isActive ? 'style="background:var(--primary)"' : '' ?>>
                    <?= $chip['icon'] ?> <?= $chip['label'] ?>
                </a>
                <?php endforeach; ?>
            </div>

            <!-- Date + Sort row -->
            <div class="flex gap-2 mt-3">
                <input type="date" name="date" value="<?= htmlspecialchars($date ?? '') ?>" min="<?= date('Y-m-d') ?>"
                    class="flex-1 px-3 py-2 rounded-2xl border border-gray-200 dark:border-gray-600 bg-gray-50 dark:bg-gray-700 text-sm text-gray-700 dark:text-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500"
                    onchange="this.form.submit()">
                <input type="hidden" name="sport" value="<?= htmlspecialchars($sportType ?? '') ?>">
            </div>
        </form>
    </div>

    <!-- Results (RF3.1 – glassmorphism cards) -->
    <?php if (!empty($spaces)): ?>
    <p class="text-xs text-gray-500 dark:text-gray-400 px-1"><?= count($spaces) ?> cancha<?= count($spaces) !== 1 ? 's' : '' ?> disponible<?= count($spaces) !== 1 ? 's' : '' ?></p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($spaces as $space): ?>
        <?php
        $sportIcons = ['football'=>'⚽','padel'=>'🎾','tennis'=>'🏸','basketball'=>'🏀','swimming'=>'🏊','volleyball'=>'🏐'];
        $sportColors = [
            'football'   => 'from-emerald-400 to-green-600',
            'padel'      => 'from-sky-400 to-blue-600',
            'tennis'     => 'from-yellow-400 to-orange-500',
            'basketball' => 'from-orange-400 to-red-500',
            'swimming'   => 'from-cyan-400 to-teal-500',
            'volleyball' => 'from-violet-400 to-purple-600',
        ];
        $icon  = $sportIcons[$space['sport_type']] ?? '🏃';
        $grad  = $sportColors[$space['sport_type']] ?? 'from-sky-400 to-violet-600';
        ?>
        <div class="group bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
            <!-- Hero area -->
            <div class="h-36 bg-gradient-to-br <?= $grad ?> flex items-center justify-center relative overflow-hidden">
                <?php if (!empty($space['photo'])): ?>
                <img src="<?= htmlspecialchars($space['photo']) ?>" class="absolute inset-0 w-full h-full object-cover" alt="">
                <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                <?php else: ?>
                <span class="text-6xl opacity-60 group-hover:scale-110 transition-transform duration-300"><?= $icon ?></span>
                <?php endif; ?>
                <!-- Price badge -->
                <div class="absolute top-3 right-3 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                    $<?= number_format($space['price_per_hour'], 0) ?>/hr
                </div>
                <?php if (!empty($space['avg_rating']) && $space['avg_rating'] > 0): ?>
                <div class="absolute bottom-3 left-3 bg-black/30 backdrop-blur-md text-white text-xs font-medium px-2 py-1 rounded-full flex items-center gap-1">
                    ⭐ <?= number_format($space['avg_rating'], 1) ?>
                    <span class="opacity-70">(<?= $space['review_count'] ?>)</span>
                </div>
                <?php endif; ?>
            </div>
            <!-- Card body -->
            <div class="p-4">
                <h3 class="jockey-one text-base font-bold text-gray-900 dark:text-white leading-tight"><?= htmlspecialchars($space['name']) ?></h3>
                <p class="text-xs text-sky-600 dark:text-sky-400 font-medium mt-0.5"><?= htmlspecialchars($space['club_name']) ?></p>
                <p class="text-xs text-gray-400 dark:text-gray-500 mt-0.5 truncate">📍 <?= htmlspecialchars($space['address'] ?? 'Querétaro, Qro.') ?></p>

                <div class="flex items-center gap-2 mt-3">
                    <a href="<?= BASE_URL ?>spaces/detail/<?= $space['id'] ?><?= !empty($date) ? '?date='.urlencode($date) : '' ?>"
                       class="flex-1 border text-center text-xs font-semibold py-2 rounded-xl transition-all dark:border-gray-600 dark:text-gray-300 hover:border-sky-400 hover:text-sky-500 border-gray-200 text-gray-600">
                        Ver detalle
                    </a>
                    <a href="<?= BASE_URL ?>reservations/create/<?= $space['id'] ?><?= !empty($date) ? '?date='.urlencode($date) : '' ?>"
                       class="flex-1 text-white text-xs font-bold py-2 rounded-xl text-center transition-all shadow-sm"
                       style="background:var(--primary)">
                        Reservar
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <?php elseif (isset($sportType) && $sportType !== '' || !empty($date) || !empty($query)): ?>
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-12 text-center">
        <p class="text-5xl mb-4">🏟️</p>
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Sin resultados</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Prueba con otros filtros o fechas</p>
    </div>

    <?php else: ?>
    <!-- Default: show all spaces -->
    <?php
    $allSpaces = (new SpaceModel())->search('', '');
    if (!empty($allSpaces)):
    ?>
    <p class="text-xs text-gray-500 dark:text-gray-400 px-1">Todas las canchas disponibles</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php foreach ($allSpaces as $space):
            $sportIcons = ['football'=>'⚽','padel'=>'🎾','tennis'=>'🏸','basketball'=>'🏀','swimming'=>'🏊','volleyball'=>'🏐'];
            $sportColors = ['football'=>'from-emerald-400 to-green-600','padel'=>'from-sky-400 to-blue-600','tennis'=>'from-yellow-400 to-orange-500','basketball'=>'from-orange-400 to-red-500','swimming'=>'from-cyan-400 to-teal-500','volleyball'=>'from-violet-400 to-purple-600'];
            $icon = $sportIcons[$space['sport_type']] ?? '🏃';
            $grad = $sportColors[$space['sport_type']] ?? 'from-sky-400 to-violet-600';
        ?>
        <div class="group bg-white dark:bg-gray-800 border border-gray-100 dark:border-gray-700 rounded-3xl overflow-hidden hover:shadow-xl hover:-translate-y-1 transition-all duration-200">
            <div class="h-36 bg-gradient-to-br <?= $grad ?> flex items-center justify-center relative overflow-hidden">
                <span class="text-6xl opacity-60 group-hover:scale-110 transition-transform duration-300"><?= $icon ?></span>
                <div class="absolute top-3 right-3 bg-white/20 backdrop-blur-md border border-white/30 text-white text-xs font-bold px-2.5 py-1 rounded-full">
                    $<?= number_format($space['price_per_hour'], 0) ?>/hr
                </div>
                <?php if (!empty($space['avg_rating']) && $space['avg_rating'] > 0): ?>
                <div class="absolute bottom-3 left-3 bg-black/30 backdrop-blur-md text-white text-xs font-medium px-2 py-1 rounded-full">
                    ⭐ <?= number_format($space['avg_rating'], 1) ?>
                </div>
                <?php endif; ?>
            </div>
            <div class="p-4">
                <h3 class="jockey-one text-base font-bold text-gray-900 dark:text-white leading-tight"><?= htmlspecialchars($space['name']) ?></h3>
                <p class="text-xs text-sky-600 dark:text-sky-400 font-medium mt-0.5"><?= htmlspecialchars($space['club_name']) ?></p>
                <p class="text-xs text-gray-400 mt-0.5 truncate">📍 <?= htmlspecialchars($space['address'] ?? 'Querétaro, Qro.') ?></p>
                <div class="flex items-center gap-2 mt-3">
                    <a href="<?= BASE_URL ?>spaces/detail/<?= $space['id'] ?>"
                       class="flex-1 border border-gray-200 dark:border-gray-600 text-gray-600 dark:text-gray-300 text-center text-xs font-semibold py-2 rounded-xl hover:border-sky-400 hover:text-sky-500 transition-all">
                        Ver detalle
                    </a>
                    <a href="<?= BASE_URL ?>reservations/create/<?= $space['id'] ?>"
                       class="flex-1 text-white text-xs font-bold py-2 rounded-xl text-center transition-all"
                       style="background:var(--primary)">
                        Reservar
                    </a>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div class="bg-white dark:bg-gray-800 rounded-3xl border border-gray-100 dark:border-gray-700 p-12 text-center">
        <p class="text-5xl mb-4">🔍</p>
        <h3 class="text-lg font-semibold text-gray-700 dark:text-gray-300">Usa los filtros para buscar</h3>
        <p class="text-gray-500 dark:text-gray-400 text-sm mt-1">Selecciona deporte, fecha y hora para ver disponibilidad</p>
    </div>
    <?php endif; ?>
    <?php endif; ?>
</div>

<style>
.jockey-one { font-family: 'Jockey One', sans-serif; }
.scrollbar-hide::-webkit-scrollbar { display: none; }
.scrollbar-hide { -ms-overflow-style: none; scrollbar-width: none; }
</style>
