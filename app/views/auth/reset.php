<div class="space-y-5">
    <?php if ($error): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <p class="text-sm text-gray-600 text-center">Ingresa el código OTP y tu nueva contraseña.</p>
    <form method="POST" class="space-y-4">
        <?php if ($email): ?>
        <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
        <div class="bg-sky-50 border border-sky-200 rounded-xl px-4 py-2 text-sm text-sky-700">
            Código enviado a: <strong><?= htmlspecialchars($email) ?></strong>
        </div>
        <?php else: ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Email</label>
            <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
        </div>
        <?php endif; ?>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Código OTP (6 dígitos)</label>
            <input type="text" name="code" required maxlength="6" placeholder="123456"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm text-center text-2xl tracking-widest">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Nueva Contraseña</label>
            <input type="password" name="password" required placeholder="Mínimo 6 caracteres"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirmar Contraseña</label>
            <input type="password" name="password_confirm" required placeholder="Repite tu contraseña"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
        </div>
        <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-xl transition-all">
            Restablecer Contraseña
        </button>
    </form>
    <p class="text-center text-sm">
        <a href="<?= BASE_URL ?>auth/forgot" class="text-sky-500 font-medium">← Solicitar nuevo código</a>
    </p>
</div>
