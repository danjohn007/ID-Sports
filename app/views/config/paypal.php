<div class="max-w-lg mx-auto">
    <?php if ($success ?? false): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-4">Configuración guardada</div>
    <?php endif; ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-2">💳 Configuración PayPal</h2>
        <p class="text-sm text-gray-500 mb-5">Ingresa tus credenciales de la API de PayPal.</p>
        <form method="POST" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Modo</label>
                <select name="paypal_mode" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="sandbox" <?= ($config['paypal_mode'] ?? 'sandbox') === 'sandbox' ? 'selected' : '' ?>>Sandbox (Pruebas)</option>
                    <option value="live" <?= ($config['paypal_mode'] ?? '') === 'live' ? 'selected' : '' ?>>Live (Producción)</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Client ID</label>
                <input type="text" name="paypal_client_id" value="<?= htmlspecialchars($config['paypal_client_id'] ?? '') ?>"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Client Secret</label>
                <input type="password" name="paypal_client_secret" placeholder="••••••••••••"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">Guardar</button>
        </form>
    </div>
</div>
