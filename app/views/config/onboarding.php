<div class="max-w-2xl mx-auto space-y-5">
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-1">🎬 Pantallas de Onboarding</h2>
        <p class="text-sm text-gray-500 mb-6">
            Configura los textos e imagen de fondo de cada pantalla de bienvenida.<br>
            Cada slide guarda de forma independiente.
        </p>

        <?php
        $slideDefs = [
            1 => ['icon' => '🏟️', 'label' => 'Slide 1 — Encuentro de cancha'],
            2 => ['icon' => '📲', 'label' => 'Slide 2 — Reserva con QR'],
            3 => ['icon' => '🤝', 'label' => 'Slide 3 — Comunidad'],
        ];
        foreach ($slideDefs as $n => $def):
            $icon  = $def['icon'];
            $label = $def['label'];
            $title = $config["onboarding_slide{$n}_title"] ?? '';
            $desc  = $config["onboarding_slide{$n}_desc"]  ?? '';
            $img   = $config["onboarding_slide{$n}_image"] ?? '';
        ?>
        <!-- Each slide is a standalone form with enctype multipart — no nesting -->
        <form method="POST"
              action="<?= BASE_URL ?>config/upload-slide-image"
              enctype="multipart/form-data"
              class="border border-gray-100 rounded-xl p-5 <?= $n < 3 ? 'mb-5' : '' ?>">
            <input type="hidden" name="slide_num" value="<?= $n ?>">
            <h3 class="font-semibold text-gray-800 mb-4"><?= $icon ?> <?= htmlspecialchars($label) ?></h3>

            <div class="space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Título</label>
                    <input type="text" name="onboarding_slide<?= $n ?>_title"
                        value="<?= htmlspecialchars($title) ?>"
                        placeholder="ej. Encuentra tu cancha ideal"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción</label>
                    <textarea name="onboarding_slide<?= $n ?>_desc" rows="2"
                        placeholder="Breve descripción del beneficio…"
                        class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none"><?= htmlspecialchars($desc) ?></textarea>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Imagen de fondo</label>
                    <!-- Current image preview -->
                    <?php if ($img): ?>
                    <div class="mb-3">
                        <img src="<?= htmlspecialchars($img) ?>" alt="Preview Slide <?= $n ?>"
                            class="h-28 w-full object-cover rounded-xl"
                            onerror="this.parentElement.style.display='none'">
                    </div>
                    <?php endif; ?>
                    <!-- File upload buttons -->
                    <div class="flex flex-wrap items-center gap-2">
                        <input type="file" name="slide_image" id="slideFile<?= $n ?>"
                               accept="image/png,image/jpeg,image/webp,image/gif"
                               class="hidden"
                               onchange="document.getElementById('slideFileName<?= $n ?>').textContent=this.files[0]?'📄 '+this.files[0].name:''">
                        <button type="button"
                                onclick="document.getElementById('slideFile<?= $n ?>').click()"
                                class="flex items-center gap-1.5 px-3 py-2 bg-indigo-50 text-indigo-700 border border-indigo-200 rounded-lg text-xs font-semibold hover:bg-indigo-100 transition-all">
                            📂 Subir archivo
                        </button>
                        <?php if ($img): ?>
                        <a href="<?= BASE_URL ?>config/remove-slide-image?n=<?= $n ?>"
                           onclick="return confirm('¿Quitar la imagen del slide <?= $n ?>?')"
                           class="flex items-center gap-1 px-3 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg text-xs font-semibold hover:bg-red-100 transition-all">
                            🗑️ Quitar foto
                        </a>
                        <?php endif; ?>
                        <span id="slideFileName<?= $n ?>" class="text-xs text-gray-400"></span>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                <button type="submit"
                        class="px-5 py-2 bg-sky-500 text-white text-sm font-semibold rounded-xl hover:bg-sky-600 transition-all">
                    💾 Guardar slide <?= $n ?>
                </button>
            </div>
        </form>
        <?php endforeach; ?>
    </div>

    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5">
        <h3 class="font-semibold text-amber-800 mb-2">ℹ️ ¿Cómo funciona el onboarding?</h3>
        <ul class="text-sm text-amber-700 space-y-1 list-disc list-inside">
            <li>Los usuarios nuevos ven estas 3 pantallas la primera vez que visitan la app.</li>
            <li>Una vez que presionan "Comenzar" u "Omitir", el sistema recuerda que ya lo vieron.</li>
            <li>El color del botón "Siguiente / Comenzar" usa el <strong>Color Primario</strong> configurado en Colores.</li>
            <li>Si no hay imagen, se usa un fondo de gradiente oscuro por defecto.</li>
        </ul>
    </div>
</div>
