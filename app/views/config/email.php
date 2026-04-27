<div class="max-w-lg mx-auto">
    <?php if ($success ?? false): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-4">Configuración guardada</div>
    <?php endif; ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-6">
        <h2 class="font-semibold text-gray-900 mb-5">📧 Configuración SMTP</h2>
        <form method="POST" class="space-y-4">
            <?php $fields = ['smtp_host' => 'Servidor SMTP', 'smtp_port' => 'Puerto', 'smtp_user' => 'Usuario', 'smtp_password' => 'Contraseña', 'smtp_from' => 'Email remitente', 'smtp_from_name' => 'Nombre remitente'];
            foreach ($fields as $key => $label):
                $val = $config[$key] ?? '';
                $isPass = strpos($key, 'password') !== false;
            ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5"><?= $label ?></label>
                <input type="<?= $isPass ? 'password' : 'text' ?>" name="<?= $key ?>" value="<?= $isPass ? '' : htmlspecialchars($val) ?>"
                    placeholder="<?= $isPass ? '••••••••' : '' ?>"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <?php endforeach; ?>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Encriptación</label>
                <select name="smtp_encryption" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="tls" <?= ($config['smtp_encryption'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS</option>
                    <option value="ssl" <?= ($config['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                    <option value="" <?= empty($config['smtp_encryption']) ? 'selected' : '' ?>>Ninguna</option>
                </select>
            </div>
            <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">Guardar</button>
        </form>
    </div>
</div>
