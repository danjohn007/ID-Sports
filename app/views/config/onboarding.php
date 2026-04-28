<div class="max-w-2xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-1">🎬 Pantallas de Onboarding</h2>
        <p class="text-sm text-gray-500 mb-6">
            Configura los textos e imágenes que verán los usuarios al abrir la app por primera vez.<br>
            Las imágenes deben ser URLs públicas (ej. <code>https://…/cancha.jpg</code>). Si se dejan vacías, se usa un fondo de gradiente por defecto.
        </p>

        <form method="POST" class="space-y-8">

            <?php
            $slideDefs = [
                1 => ['icon' => '🏟️', 'label' => 'Slide 1 — Encuentro de cancha'],
                2 => ['icon' => '📲', 'label' => 'Slide 2 — Reserva con QR'],
                3 => ['icon' => '🤝', 'label' => 'Slide 3 — Comunidad'],
            ];
            foreach ($slideDefs as $n => [$icon, $label]):
                $title = $config["onboarding_slide{$n}_title"] ?? '';
                $desc  = $config["onboarding_slide{$n}_desc"]  ?? '';
                $img   = $config["onboarding_slide{$n}_image"] ?? '';
            ?>
            <div class="border border-gray-100 rounded-xl p-5">
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
                        <label class="block text-sm font-medium text-gray-700 mb-1">URL de imagen de fondo</label>
                        <input type="url" name="onboarding_slide<?= $n ?>_image"
                            value="<?= htmlspecialchars($img) ?>"
                            placeholder="https://ejemplo.com/imagen.jpg"
                            class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                        <?php if ($img): ?>
                        <div class="mt-2">
                            <img src="<?= htmlspecialchars($img) ?>" alt="Preview"
                                class="h-24 w-full object-cover rounded-xl opacity-80"
                                onerror="this.style.display='none'">
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>

            <button type="submit"
                class="bg-sky-500 text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">
                Guardar cambios
            </button>
        </form>
    </div>

    <div class="mt-6 bg-amber-50 border border-amber-200 rounded-2xl p-5">
        <h3 class="font-semibold text-amber-800 mb-2">ℹ️ ¿Cómo funciona el onboarding?</h3>
        <ul class="text-sm text-amber-700 space-y-1 list-disc list-inside">
            <li>Los usuarios nuevos ven estas 3 pantallas la primera vez que visitan la app.</li>
            <li>Una vez que presionan "Comenzar" u "Omitir", el sistema recuerda que ya lo vieron y no lo muestra de nuevo.</li>
            <li>El color del botón "Siguiente / Comenzar" usa el <strong>Color Primario</strong> configurado en Colores.</li>
            <li>Si no hay imagen configurada, se usa un fondo de gradiente oscuro por defecto.</li>
        </ul>
    </div>
</div>
