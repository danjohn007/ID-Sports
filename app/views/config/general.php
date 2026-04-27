<div class="max-w-lg mx-auto space-y-5">
    <?php if ($success ?? false): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm">Configuración guardada correctamente</div>
    <?php endif; ?>
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
