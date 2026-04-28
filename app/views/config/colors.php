<div class="max-w-lg mx-auto">
    <?php if ($success ?? false): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-4">Colores actualizados</div>
    <?php endif; ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-5">🎨 Paleta de Colores — General</h2>
        <form method="POST" class="space-y-4">
            <?php $colorFields = [
                'color_primary' => ['Primary', '#0EA5E9'],
                'color_secondary' => ['Secondary', '#7C3AED'],
                'color_success' => ['Éxito', '#10B981'],
                'color_danger' => ['Error', '#EF4444'],
                'color_warning' => ['Advertencia', '#F59E0B'],
            ];
            foreach ($colorFields as $key => [$label, $default]):
                $val = $config[$key] ?? $default;
            ?>
            <div class="flex items-center gap-4">
                <input type="color" name="<?= $key ?>" value="<?= htmlspecialchars($val) ?>"
                    class="w-12 h-12 rounded-xl border border-gray-200 cursor-pointer p-1">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700"><?= $label ?></label>
                    <input type="text" name="<?= $key ?>_hex" value="<?= htmlspecialchars($val) ?>"
                        class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
            <?php endforeach; ?>

            <hr class="border-gray-100 my-4">
            <h3 class="font-semibold text-gray-900 mb-3">🔑 Página de Login (/auth/login)</h3>
            <?php $loginColorFields = [
                'color_login_button'  => ['Botón "Iniciar Sesion"', '#0EA5E9'],
                'color_login_link'    => ['Olvidaste tu contrasena y Registrate gratis', '#0EA5E9'],
                'color_login_logo_bg' => ['Fondo del Logo ID Sports', '#0EA5E9'],
            ];
            foreach ($loginColorFields as $key => [$label, $default]):
                $val = $config[$key] ?? $default;
            ?>
            <div class="flex items-center gap-4">
                <input type="color" name="<?= $key ?>" value="<?= htmlspecialchars($val) ?>"
                    class="w-12 h-12 rounded-xl border border-gray-200 cursor-pointer p-1">
                <div class="flex-1">
                    <label class="block text-sm font-medium text-gray-700"><?= $label ?></label>
                    <input type="text" name="<?= $key ?>_hex" value="<?= htmlspecialchars($val) ?>"
                        class="mt-1 w-full px-3 py-2 rounded-lg border border-gray-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-sky-500">
                </div>
            </div>
            <?php endforeach; ?>

            <hr class="border-gray-100 my-4">
            <h3 class="font-semibold text-gray-900 mb-3">🖼️ Imagen de fondo del Login</h3>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">URL de imagen de fondo</label>
                <input type="url" name="auth_bg_image"
                    value="<?= htmlspecialchars($config['auth_bg_image'] ?? '') ?>"
                    placeholder="https://ejemplo.com/fondo-cancha.jpg"
                    class="w-full px-3 py-2 rounded-lg border border-gray-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-sky-500">
                <p class="text-xs text-gray-400 mt-1">Si se deja vacío, se usa un gradiente oscuro por defecto.</p>
            </div>

            <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">Guardar</button>
        </form>
    </div>
</div>
