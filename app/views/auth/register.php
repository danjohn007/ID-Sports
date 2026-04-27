<div class="space-y-5">
    <?php if ($error): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nombre Completo *</label>
            <input type="text" name="name" required placeholder="Juan Pérez"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                value="<?= htmlspecialchars($_POST['name'] ?? '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Correo Electrónico *</label>
            <input type="email" name="email" required placeholder="tu@email.com"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">WhatsApp</label>
            <input type="tel" name="whatsapp" placeholder="+52 442 123 4567"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm"
                value="<?= htmlspecialchars($_POST['whatsapp'] ?? '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Contraseña *</label>
            <input type="password" name="password" required placeholder="Mínimo 6 caracteres"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirmar Contraseña *</label>
            <input type="password" name="password_confirm" required placeholder="Repite tu contraseña"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
        </div>
        <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-xl transition-all">
            Crear Cuenta
        </button>
    </form>

    <p class="text-center text-sm text-gray-600">
        ¿Ya tienes cuenta? <a href="<?= BASE_URL ?>auth/login" class="text-sky-500 hover:text-sky-600 font-semibold">Iniciar Sesión</a>
    </p>
</div>
