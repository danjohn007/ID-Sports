<div class="max-w-lg mx-auto space-y-5">
    <?php if ($success ?? false): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">Configuración guardada correctamente</div>
    <?php endif; ?>

    <!-- Logo upload -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-1">🖼️ Logo de la Empresa</h2>
        <p class="text-xs text-gray-400 mb-4">Aparece en la pantalla de login y en el onboarding. Formatos: PNG, JPG, SVG o WEBP · Máx 2 MB.</p>
        <?php
        $logoPath = $config['app_logo_path'] ?? '';
        $logoSrc  = $logoPath ? BASE_URL . htmlspecialchars($logoPath) . '?v=' . time() : BASE_URL . 'public/assets/logo.svg';
        ?>

        <!-- Current logo preview -->
        <div class="flex items-center gap-4 mb-5">
            <div class="w-20 h-20 rounded-2xl bg-gray-100 flex items-center justify-center overflow-hidden border border-gray-200 shrink-0">
                <img src="<?= $logoSrc ?>" alt="Logo actual" id="logoPreviewImg"
                     class="max-w-full max-h-full object-contain">
            </div>
            <div>
                <p class="text-sm font-medium text-gray-700">Logo actual</p>
                <p class="text-xs text-gray-400 mt-0.5"><?= $logoPath ? htmlspecialchars($logoPath) : 'logo.svg (predeterminado)' ?></p>
            </div>
        </div>

        <!-- Upload form -->
        <form method="POST" action="<?= BASE_URL ?>config/upload-logo" enctype="multipart/form-data" id="logoUploadForm">
            <input type="file" name="logo_file" id="logoFileInput"
                   accept="image/png,image/jpeg,image/svg+xml,image/webp"
                   class="hidden">
            <div class="flex flex-wrap gap-3">
                <button type="button" onclick="document.getElementById('logoFileInput').click()"
                        class="flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-50 text-sky-700 border border-sky-200 text-sm font-semibold hover:bg-sky-100 transition-all">
                    📂 Seleccionar archivo
                </button>
                <button type="submit"
                        class="px-5 py-2 rounded-xl bg-sky-500 text-white text-sm font-semibold hover:bg-sky-600 transition-all">
                    ⬆️ Guardar logo
                </button>
                <?php if ($logoPath): ?>
                <form method="POST" action="<?= BASE_URL ?>config/remove-logo"
                      class="contents"
                      onsubmit="return confirm('¿Quitar el logo personalizado y volver al predeterminado?')">
                    <button type="submit"
                            class="px-4 py-2 rounded-xl bg-red-50 text-red-600 border border-red-200 text-sm font-semibold hover:bg-red-100 transition-all">
                        🗑️ Quitar logo
                    </button>
                </form>
                <?php endif; ?>
            </div>
            <p id="logoFileName" class="text-xs text-gray-400 mt-2 hidden"></p>
        </form>

        <script>
        document.getElementById('logoFileInput').addEventListener('change', function(){
            var n = this.files[0] ? this.files[0].name : '';
            var lbl = document.getElementById('logoFileName');
            lbl.textContent = n ? '📄 ' + n : '';
            lbl.classList.toggle('hidden', !n);
        });
        </script>
    </div>

    <!-- General settings -->
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-5">🌐 Configuración General</h2>
        <form method="POST" class="space-y-4">
            <?php
            $fields = ['app_name' => 'Nombre de la Aplicación', 'app_description' => 'Descripción', 'contact_email' => 'Email de Contacto', 'contact_phone' => 'Teléfono de Contacto', 'address' => 'Dirección', 'timezone' => 'Zona Horaria'];
            foreach ($fields as $key => $label):
                $val = $config[$key] ?? '';
            ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5"><?= $label ?></label>
                <input type="text" name="<?= $key ?>" value="<?= htmlspecialchars($val) ?>"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <?php endforeach; ?>
            <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">Guardar</button>
        </form>
    </div>
</div>
