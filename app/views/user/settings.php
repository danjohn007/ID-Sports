<div class="max-w-lg mx-auto">
    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 space-y-5">
        <h2 class="text-lg font-semibold text-gray-900">⚙️ Preferencias</h2>
        <form method="POST">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div>
                    <p class="font-medium text-gray-900 text-sm">Modo Oscuro</p>
                    <p class="text-xs text-gray-500">Cambia el tema de la interfaz</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="dark_mode" class="sr-only peer" <?= ($user['dark_mode'] ?? 0) ? 'checked' : '' ?> onchange="this.form.submit()">
                    <div class="w-11 h-6 bg-gray-200 peer-focus:outline-none rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                </label>
            </div>
        </form>
        <div class="p-4 bg-gray-50 rounded-xl">
            <p class="font-medium text-gray-900 text-sm mb-1">Notificaciones WhatsApp</p>
            <p class="text-xs text-gray-500">Número registrado: <strong><?= htmlspecialchars($user['whatsapp'] ?? 'No registrado') ?></strong></p>
            <a href="<?= BASE_URL ?>user/profile" class="text-xs text-sky-500 hover:underline">Actualizar número →</a>
        </div>
    </div>
</div>
