<div class="max-w-lg mx-auto">
    <?php if ($success ?? false): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-4">Configuración guardada</div>
    <?php endif; ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-2">📱 Acceso por QR</h2>
        <p class="text-sm text-gray-500 mb-5">Configura el sistema de acceso con códigos QR.</p>
        <form method="POST" class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div>
                    <p class="font-medium text-sm text-gray-900">Acceso por QR activado</p>
                    <p class="text-xs text-gray-500">Los usuarios podrán mostrar su QR en la entrada</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="qr_enabled" class="sr-only peer" <?= ($config['qr_enabled'] ?? '0') === '1' ? 'checked' : '' ?>>
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Expiración del QR (minutos)</label>
                <input type="number" name="qr_expiry_minutes" value="<?= htmlspecialchars($config['qr_expiry_minutes'] ?? '30') ?>" min="5"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Secret Key QR</label>
                <input type="text" name="qr_secret" value="<?= htmlspecialchars($config['qr_secret'] ?? '') ?>" placeholder="Clave secreta para firmar QR"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">Guardar</button>
        </form>
    </div>
</div>
