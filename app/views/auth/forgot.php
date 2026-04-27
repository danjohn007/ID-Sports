<div class="space-y-5">
    <?php if ($error): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm"><?= $success ?></div>
    <a href="<?= BASE_URL ?>auth/reset" class="block w-full bg-violet-500 hover:bg-violet-600 text-white font-semibold py-3 rounded-xl text-center transition-all">
        Ingresar Código OTP →
    </a>
    <?php else: ?>
    <p class="text-sm text-gray-600 text-center">Ingresa tu email y te enviaremos un código OTP para restablecer tu contraseña.</p>
    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Correo Electrónico</label>
            <input type="email" name="email" required placeholder="tu@email.com"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
        </div>
        <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-xl transition-all">
            Enviar Código
        </button>
    </form>
    <?php endif; ?>
    <p class="text-center text-sm">
        <a href="<?= BASE_URL ?>auth/login" class="text-sky-500 hover:text-sky-600 font-medium">← Volver al login</a>
    </p>
</div>
