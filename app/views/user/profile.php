<?php
$mexicanStates = [
    'Aguascalientes','Baja California','Baja California Sur','Campeche','Chiapas',
    'Chihuahua','Ciudad de México','Coahuila','Colima','Durango','Estado de México',
    'Guanajuato','Guerrero','Hidalgo','Jalisco','Michoacán','Morelos','Nayarit',
    'Nuevo León','Oaxaca','Puebla','Querétaro','Quintana Roo','San Luis Potosí',
    'Sinaloa','Sonora','Tabasco','Tamaulipas','Tlaxcala','Veracruz','Yucatán','Zacatecas',
];
$avatarPath = $user['avatar'] ?? '';
$userInitial = strtoupper(substr($user['name'] ?? 'U', 0, 1));
?>

<style>
.profile-card {
    background: var(--bg-card);
    border: 1px solid var(--border-gl2);
    border-radius: 1.25rem;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
}
.profile-tab-btn {
    padding: 0.5rem 1.25rem;
    border-radius: 0.75rem;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
    border: none;
    background: transparent;
    color: var(--text-sec);
}
.profile-tab-btn.active {
    background: rgba(var(--primary-rgb), 0.15);
    color: var(--primary);
    font-weight: 600;
}
.profile-field-label {
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.05em;
    color: var(--text-muted);
    margin-bottom: 0.25rem;
}
.profile-field-value {
    font-size: 0.9375rem;
    font-weight: 500;
    color: var(--text-pri);
}
.profile-input {
    width: 100%;
    padding: 0.625rem 1rem;
    border-radius: 0.75rem;
    border: 1px solid var(--border-gl2);
    background: rgba(var(--primary-rgb), 0.04);
    color: var(--text-pri);
    font-size: 0.875rem;
    outline: none;
    transition: border-color 0.2s, box-shadow 0.2s;
}
.profile-input:focus {
    border-color: var(--primary);
    box-shadow: 0 0 0 3px rgba(var(--primary-rgb), 0.12);
}
.profile-input option {
    background: var(--bg-mid);
    color: var(--text-pri);
}
.btn-primary-profile {
    background: var(--primary);
    color: #fff;
    border: none;
    border-radius: 0.75rem;
    padding: 0.625rem 1.5rem;
    font-size: 0.875rem;
    font-weight: 600;
    cursor: pointer;
    transition: opacity 0.2s;
}
.btn-primary-profile:hover { opacity: 0.88; }
.btn-danger-link {
    background: none;
    border: none;
    color: #ef4444;
    font-size: 0.8125rem;
    font-weight: 500;
    cursor: pointer;
    padding: 0;
    text-decoration: underline;
    transition: opacity 0.2s;
}
.btn-danger-link:hover { opacity: 0.75; }
</style>

<div class="max-w-xl mx-auto space-y-5">

    <!-- ── Tab bar ─────────────────────────────────────────────── -->
    <div class="profile-card p-1.5 flex gap-1">
        <button class="profile-tab-btn active flex-1" id="tab-view-btn" onclick="switchTab('view')">
            👤 Mi Perfil
        </button>
        <button class="profile-tab-btn flex-1" id="tab-edit-btn" onclick="switchTab('edit')">
            ✏️ Editar Perfil
        </button>
    </div>

    <!-- ── TAB: Mi Perfil (read-only view) ──────────────────────── -->
    <div id="tab-view" class="profile-card p-6 space-y-5">

        <!-- Avatar + name + role -->
        <div class="flex items-center gap-4">
            <div class="flex-shrink-0">
                <?php if ($avatarPath): ?>
                <img id="profileAvatarImg"
                     src="<?= BASE_URL . htmlspecialchars($avatarPath) ?>?v=<?= time() ?>"
                     alt="Avatar"
                     class="w-20 h-20 rounded-2xl object-cover"
                     style="border:2px solid var(--border-gl2)">
                <?php else: ?>
                <div id="profileAvatarDefault"
                     class="w-20 h-20 rounded-2xl flex items-center justify-center text-white font-bold text-3xl"
                     style="background:var(--primary)">
                    <?= $userInitial ?>
                </div>
                <?php endif; ?>
            </div>
            <div>
                <h2 class="text-xl font-bold" style="color:var(--text-pri)"><?= htmlspecialchars($user['name'] ?? '') ?></h2>
                <p class="text-sm mt-0.5" style="color:var(--text-sec)"><?= htmlspecialchars($user['email'] ?? '') ?></p>
                <span class="inline-block mt-1 px-2.5 py-0.5 rounded-full text-xs font-semibold capitalize"
                      style="background:rgba(var(--primary-rgb),0.14);color:var(--primary)">
                    <?= htmlspecialchars($user['role'] ?? 'user') ?>
                </span>
            </div>
        </div>

        <hr style="border-color:var(--border-gl)">

        <!-- Info grid -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <p class="profile-field-label">WhatsApp</p>
                <p class="profile-field-value"><?= htmlspecialchars($user['whatsapp'] ?? '—') ?></p>
            </div>
            <div>
                <p class="profile-field-label">Estado</p>
                <p class="profile-field-value"><?= htmlspecialchars($user['state'] ?? '—') ?></p>
            </div>
            <div>
                <p class="profile-field-label">Fecha de Nacimiento</p>
                <p class="profile-field-value"><?= $user['birth_date'] ? date('d/m/Y', strtotime($user['birth_date'])) : '—' ?></p>
            </div>
            <div>
                <p class="profile-field-label">Miembro desde</p>
                <p class="profile-field-value"><?= $user['created_at'] ? date('d/m/Y', strtotime($user['created_at'])) : '—' ?></p>
            </div>
        </div>

        <hr style="border-color:var(--border-gl)">

        <button onclick="switchTab('edit')" class="btn-primary-profile w-full">
            ✏️ Editar mi información
        </button>
    </div>

    <!-- ── TAB: Editar Perfil ────────────────────────────────────── -->
    <div id="tab-edit" class="space-y-5 hidden">

        <!-- Avatar upload card -->
        <div class="profile-card p-5">
            <p class="text-sm font-semibold mb-4" style="color:var(--text-pri)">Foto de Perfil</p>
            <div class="flex items-center gap-4">
                <!-- Current avatar preview -->
                <div class="flex-shrink-0">
                    <?php if ($avatarPath): ?>
                    <img id="avatarPreview"
                         src="<?= BASE_URL . htmlspecialchars($avatarPath) ?>?v=<?= time() ?>"
                         alt="Avatar"
                         class="w-16 h-16 rounded-xl object-cover"
                         style="border:2px solid var(--border-gl2)">
                    <?php else: ?>
                    <div id="avatarPreview"
                         class="w-16 h-16 rounded-xl flex items-center justify-center text-white font-bold text-2xl"
                         style="background:var(--primary)">
                        <?= $userInitial ?>
                    </div>
                    <?php endif; ?>
                </div>

                <!-- Upload form -->
                <form method="POST" action="<?= BASE_URL ?>user/upload-avatar"
                      enctype="multipart/form-data" id="avatarUploadForm" class="flex-1 space-y-2">
                    <input type="file" name="avatar_file" id="avatarFileInput"
                           accept="image/jpeg,image/png,image/webp"
                           class="profile-input text-xs py-1.5 cursor-pointer"
                           onchange="previewAvatar(event)">
                    <p class="text-xs" style="color:var(--text-muted)">JPG, PNG o WEBP · máx 2 MB</p>
                    <div class="flex items-center gap-3 flex-wrap">
                        <button type="submit" class="btn-primary-profile text-xs px-4 py-2">
                            ⬆️ Subir imagen
                        </button>
                        <?php if ($avatarPath): ?>
                        <form method="POST" action="<?= BASE_URL ?>user/remove-avatar" id="removeAvatarForm">
                            <button type="submit" class="btn-danger-link" onclick="return confirm('¿Quitar la foto de perfil?')">
                                🗑 Quitar imagen
                            </button>
                        </form>
                        <?php endif; ?>
                    </div>
                </form>
            </div>
        </div>

        <!-- Profile data form -->
        <div class="profile-card p-5">
            <p class="text-sm font-semibold mb-4" style="color:var(--text-pri)">Información Personal</p>

            <?php if (!empty($error)): ?>
            <div class="mb-4 px-4 py-3 rounded-xl text-sm font-medium"
                 style="background:rgba(239,68,68,0.12);color:#ef4444;border:1px solid rgba(239,68,68,0.25)">
                <?= htmlspecialchars($error) ?>
            </div>
            <?php endif; ?>
            <?php if (!empty($success)): ?>
            <div class="mb-4 px-4 py-3 rounded-xl text-sm font-medium"
                 style="background:rgba(34,197,94,0.12);color:#22c55e;border:1px solid rgba(34,197,94,0.25)">
                <?= htmlspecialchars($success) ?>
            </div>
            <?php endif; ?>

            <form method="POST" class="space-y-4">
                <div>
                    <label class="profile-field-label block mb-1">Nombre Completo</label>
                    <input type="text" name="name" required
                           value="<?= htmlspecialchars($user['name'] ?? '') ?>"
                           class="profile-input">
                </div>

                <div>
                    <label class="profile-field-label block mb-1">WhatsApp</label>
                    <input type="tel" name="whatsapp"
                           value="<?= htmlspecialchars($user['whatsapp'] ?? '') ?>"
                           placeholder="+52 442 000 0000"
                           class="profile-input">
                </div>

                <div>
                    <label class="profile-field-label block mb-1">Estado</label>
                    <select name="state" class="profile-input">
                        <option value="">— Selecciona tu estado —</option>
                        <?php foreach ($mexicanStates as $st): ?>
                        <option value="<?= htmlspecialchars($st) ?>"
                            <?= (($user['state'] ?? '') === $st) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($st) ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label class="profile-field-label block mb-1">Fecha de Nacimiento</label>
                    <input type="date" name="birth_date"
                           value="<?= htmlspecialchars($user['birth_date'] ?? '') ?>"
                           class="profile-input">
                </div>

                <button type="submit" class="btn-primary-profile w-full mt-2">
                    💾 Guardar Cambios
                </button>
            </form>
        </div>
    </div>

</div>

<script>
function switchTab(tab) {
    const viewPane = document.getElementById('tab-view');
    const editPane = document.getElementById('tab-edit');
    const viewBtn  = document.getElementById('tab-view-btn');
    const editBtn  = document.getElementById('tab-edit-btn');

    if (tab === 'view') {
        viewPane.classList.remove('hidden');
        editPane.classList.add('hidden');
        viewBtn.classList.add('active');
        editBtn.classList.remove('active');
    } else {
        viewPane.classList.add('hidden');
        editPane.classList.remove('hidden');
        editBtn.classList.add('active');
        viewBtn.classList.remove('active');
    }
}

function previewAvatar(event) {
    const file = event.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = function(e) {
        const preview = document.getElementById('avatarPreview');
        if (preview.tagName === 'IMG') {
            preview.src = e.target.result;
        } else {
            // Replace initials div with an img
            const img = document.createElement('img');
            img.id = 'avatarPreview';
            img.src = e.target.result;
            img.alt = 'Avatar';
            img.className = 'w-16 h-16 rounded-xl object-cover';
            img.style.border = '2px solid var(--border-gl2)';
            preview.replaceWith(img);
        }
    };
    reader.readAsDataURL(file);
}

// Auto-switch to edit tab if there was an error or success on POST
<?php if (!empty($error) || !empty($success)): ?>
switchTab('edit');
<?php endif; ?>
// Auto-switch to edit tab when coming from the "Editar" button on the view tab
<?php if (!empty($_GET['tab']) && $_GET['tab'] === 'edit'): ?>
switchTab('edit');
<?php endif; ?>
</script>
