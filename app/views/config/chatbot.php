<div class="max-w-lg mx-auto">
    <?php if ($success ?? false): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm mb-4">Configuración guardada</div>
    <?php endif; ?>
    <div class="bg-white rounded-2xl border border-gray-100 p-6 space-y-5">
        <h2 class="font-semibold text-gray-900">🤖 Configuración del Chatbot</h2>
        <form method="POST" class="space-y-4">
            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-xl">
                <div>
                    <p class="font-medium text-sm text-gray-900">Chatbot activado</p>
                    <p class="text-xs text-gray-500">Mostrar asistente virtual en el portal</p>
                </div>
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="chatbot_enabled" class="sr-only peer" <?= ($config['chatbot_enabled'] ?? '0') === '1' ? 'checked' : '' ?>>
                    <div class="w-11 h-6 bg-gray-200 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-sky-500"></div>
                </label>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Proveedor</label>
                <select name="chatbot_provider" class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
                    <option value="openai" <?= ($config['chatbot_provider'] ?? '') === 'openai' ? 'selected' : '' ?>>OpenAI (GPT)</option>
                    <option value="gemini" <?= ($config['chatbot_provider'] ?? '') === 'gemini' ? 'selected' : '' ?>>Google Gemini</option>
                    <option value="custom" <?= ($config['chatbot_provider'] ?? '') === 'custom' ? 'selected' : '' ?>>API personalizada</option>
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">API Key</label>
                <input type="password" name="chatbot_api_key" placeholder="••••••••••••"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Prompt del sistema (contexto)</label>
                <textarea name="chatbot_system_prompt" rows="4"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500 resize-none"
                    placeholder="Eres un asistente de ID Sports, una plataforma de reservaciones deportivas en Querétaro..."><?= htmlspecialchars($config['chatbot_system_prompt'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1.5">Mensaje de bienvenida</label>
                <input type="text" name="chatbot_welcome" value="<?= htmlspecialchars($config['chatbot_welcome'] ?? '¡Hola! ¿En qué puedo ayudarte hoy?') ?>"
                    class="w-full px-3 py-2.5 rounded-xl border border-gray-200 text-sm focus:outline-none focus:ring-2 focus:ring-sky-500">
            </div>
            <button type="submit" class="bg-sky-500 text-white font-semibold px-6 py-2.5 rounded-xl text-sm hover:bg-sky-600 transition-all">Guardar</button>
        </form>
    </div>
</div>
