<div class="space-y-5">
    <?php if ($error): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>

    <form method="POST" class="space-y-4">
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Correo Electrónico</label>
            <input type="email" name="email" required placeholder="tu@email.com"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-gray-900 text-sm transition-all"
                value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
        </div>
        <div>
            <label class="block text-sm font-medium text-gray-700 mb-1.5">Contraseña</label>
            <input type="password" name="password" required placeholder="••••••••"
                class="w-full px-4 py-3 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-gray-900 text-sm transition-all">
        </div>
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-gray-600">
                <input type="checkbox" class="rounded"> Recordarme
            </label>
            <a href="<?= BASE_URL ?>auth/forgot" class="text-sm text-sky-500 hover:text-sky-600 font-medium">¿Olvidaste tu contraseña?</a>
        </div>
        <button type="submit" class="w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-xl transition-all shadow-sm hover:shadow-md">
            Iniciar Sesión
        </button>
    </form>

    <div class="relative">
        <div class="absolute inset-0 flex items-center"><div class="w-full border-t border-gray-200"></div></div>
        <div class="relative flex justify-center text-xs text-gray-400 bg-white px-3">o</div>
    </div>

    <p class="text-center text-sm text-gray-600">
        ¿No tienes cuenta? <a href="<?= BASE_URL ?>auth/register" class="text-sky-500 hover:text-sky-600 font-semibold">Regístrate gratis</a>
    </p>
</div>
