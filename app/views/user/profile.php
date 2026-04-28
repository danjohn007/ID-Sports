<div class="max-w-2xl mx-auto space-y-6">
    <?php if ($error): ?>
    <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
    <div class="bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-xl text-sm"><?= htmlspecialchars($success) ?></div>
    <?php endif; ?>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">

        <!-- Avatar section -->
        <div class="flex items-start gap-5 mb-6">
            <div class="relative flex-shrink-0">
                <?php $avatarPath = $user['avatar'] ?? ''; ?>
                <?php if ($avatarPath): ?>
                <img src="<?= BASE_URL . htmlspecialchars($avatarPath) ?>?v=<?= time() ?>"
                     alt="Avatar"
                     class="w-20 h-20 rounded-2xl object-cover border-2 border-gray-100">
                <?php else: ?>
                <div class="w-20 h-20 rounded-2xl bg-gradient-to-br from-sky-400 to-violet-500 flex items-center justify-center text-white font-bold text-3xl">
                    <?= strtoupper(substr($user['name'] ?? 'U', 0, 1)) ?>
                </div>
                <?php endif; ?>
                <!-- Upload overlay -->
                <label for="avatarInput" class="absolute inset-0 flex items-center justify-center rounded-2xl bg-black/40 opacity-0 hover:opacity-100 transition-opacity cursor-pointer text-white text-xl">
                    📷
                </label>
            </div>
            <div class="flex-1">
                <h2 class="text-xl font-bold text-gray-900"><?= htmlspecialchars($user['name'] ?? '') ?></h2>
                <p class="text-sm text-gray-500"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                <span class="inline-block bg-sky-100 text-sky-700 text-xs font-medium px-2.5 py-0.5 rounded-full capitalize mt-1"><?= htmlspecialchars($user['role'] ?? 'user') ?></span>
                <!-- Quick avatar upload form -->
                <form method="POST" action="<?= BASE_URL ?>user/upload-avatar" enctype="multipart/form-data" class="mt-3 flex items-center gap-2">
                    <input type="file" id="avatarInput" name="avatar_file"
                           accept="image/jpeg,image/png,image/webp"
                           class="text-xs text-gray-500 file:mr-2 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:bg-sky-50 file:text-sky-600 file:text-xs file:font-medium hover:file:bg-sky-100 cursor-pointer"
                           onchange="this.form.submit()">
                    <span class="text-xs text-gray-400">JPG, PNG o WEBP · máx 2 MB</span>
                </form>
            </div>
        </div>

        <form method="POST" class="space-y-4">
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nombre Completo</label>
                    <input type="text" name="name" required value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">WhatsApp</label>
                    <input type="tel" name="whatsapp" value="<?= htmlspecialchars($user['whatsapp'] ?? '') ?>"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Fecha de Nacimiento</label>
                    <input type="date" name="birth_date" value="<?= htmlspecialchars($user['birth_date'] ?? '') ?>"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                </div>
            </div>

            <hr class="border-gray-100 my-2">
            <p class="text-sm font-semibold text-gray-700">Cambiar Contraseña (opcional)</p>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Contraseña Actual</label>
                    <input type="password" name="current_password"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Nueva Contraseña</label>
                    <input type="password" name="new_password"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1.5">Confirmar Nueva</label>
                    <input type="password" name="new_password_confirm"
                        class="w-full px-4 py-2.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-2 focus:ring-sky-500 text-sm">
                </div>
            </div>

            <button type="submit" class="bg-sky-500 hover:bg-sky-600 text-white font-semibold px-6 py-2.5 rounded-xl transition-all text-sm">
                Guardar Cambios
            </button>
        </form>
    </div>

    <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6">
        <h3 class="font-semibold text-gray-900 mb-3">📊 Información de Cuenta</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div><p class="text-gray-500">Miembro desde</p><p class="font-medium"><?= $user['created_at'] ? date('d/m/Y', strtotime($user['created_at'])) : '-' ?></p></div>
            <div><p class="text-gray-500">Email</p><p class="font-medium"><?= htmlspecialchars($user['email'] ?? '-') ?></p></div>
        </div>
    </div>
</div>
