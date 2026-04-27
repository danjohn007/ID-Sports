<div class="space-y-5">
    <h2 class="text-lg font-semibold text-gray-900">⚙️ Configuración del Sistema</h2>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
        <?php $items = [
            ['href' => 'config/general', 'icon' => '🌐', 'label' => 'General', 'desc' => 'Nombre app, descripción, contacto'],
            ['href' => 'config/email', 'icon' => '📧', 'label' => 'Email / SMTP', 'desc' => 'Servidor de correo saliente'],
            ['href' => 'config/colors', 'icon' => '🎨', 'label' => 'Colores', 'desc' => 'Paleta de colores principal'],
            ['href' => 'config/paypal', 'icon' => '💳', 'label' => 'PayPal', 'desc' => 'Credenciales de pago'],
            ['href' => 'config/qr', 'icon' => '📱', 'label' => 'QR / Access', 'desc' => 'Configuración de acceso QR'],
            ['href' => 'config/iot', 'icon' => '🔌', 'label' => 'Dispositivos IoT', 'desc' => 'HikVision, Shelly y otros'],
            ['href' => 'config/logs', 'icon' => '📋', 'label' => 'Bitácora', 'desc' => 'Registro de acciones'],
            ['href' => 'config/errors', 'icon' => '🐞', 'label' => 'Errores', 'desc' => 'Log de errores del sistema'],
            ['href' => 'config/chatbot', 'icon' => '🤖', 'label' => 'Chatbot', 'desc' => 'Configuración del asistente'],
        ]; foreach ($items as $i): ?>
        <a href="<?= BASE_URL ?><?= $i['href'] ?>" class="bg-white border border-gray-100 rounded-2xl p-5 hover:shadow-md hover:border-sky-200 transition-all group">
            <p class="text-3xl mb-3 group-hover:scale-110 transition-transform inline-block"><?= $i['icon'] ?></p>
            <h3 class="font-semibold text-gray-900"><?= $i['label'] ?></h3>
            <p class="text-sm text-gray-500 mt-0.5"><?= $i['desc'] ?></p>
        </a>
        <?php endforeach; ?>
    </div>
</div>
