<?php
/**
 * Super Admin — Sport Types Manager
 * Allows uploading a PNG icon per sport and managing the master sport list.
 */
?>
<link href="https://fonts.googleapis.com/css2?family=Jockey+One&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

<style>
.sp-wrap        { max-width:1100px; }
.sp-grid        { display:grid; grid-template-columns:repeat(auto-fill,minmax(220px,1fr)); gap:1rem; margin-top:1.25rem; }
.sp-card        { background:rgba(15,18,30,.85); border:1px solid rgba(255,255,255,.08); border-radius:1rem; padding:1rem; display:flex; flex-direction:column; gap:.625rem; }
.sp-thumb       { width:100%; height:7rem; border-radius:.75rem; display:flex; align-items:center; justify-content:center; overflow:hidden; position:relative; }
.sp-thumb img   { width:100%; height:100%; object-fit:contain; padding:.75rem; }
.sp-badge-on  { background:rgba(16,185,129,.15); color:#34d399; font-size:.65rem; font-weight:700; padding:.15rem .55rem; border-radius:20px; }
.sp-badge-off { background:rgba(245,158,11,.15); color:#fbbf24; font-size:.65rem; font-weight:700; padding:.15rem .55rem; border-radius:20px; }
.sp-name        { font-family:'Jockey One',sans-serif; font-size:.9375rem; color:#fff; }
.sp-slug        { font-size:.7rem; color:#64748b; font-family:monospace; }
.sp-btn         { display:inline-flex; align-items:center; justify-content:center; gap:.3rem; font-size:.75rem; font-weight:600; padding:.4rem .9rem; border-radius:.625rem; cursor:pointer; border:none; transition:all 130ms; }
.sp-btn-img     { background:rgba(var(--primary-rgb),.15); color:var(--primary); }
.sp-btn-img:hover { background:rgba(var(--primary-rgb),.25); }
.sp-btn-tog     { background:rgba(255,255,255,.06); color:#94a3b8; }
.sp-btn-tog:hover { background:rgba(255,255,255,.12); }
.sp-btn-del     { background:rgba(239,68,68,.12); color:#f87171; }
.sp-btn-del:hover { background:rgba(239,68,68,.22); }
.sp-btn-primary { background:var(--primary); color:#fff; box-shadow:0 4px 12px rgba(var(--primary-rgb),.3); }
.sp-btn-primary:hover { filter:brightness(1.1); }

.sp-modal       { position:fixed; inset:0; background:rgba(0,0,0,.75); backdrop-filter:blur(6px); z-index:60; display:none; align-items:center; justify-content:center; padding:1.5rem; }
.sp-modal.open  { display:flex; }
.sp-sheet       { background:#0D1117; border:1px solid rgba(255,255,255,.1); border-radius:1.25rem; padding:1.5rem; width:100%; max-width:440px; }
.sp-field label { font-size:.8125rem; color:#94a3b8; margin-bottom:.3rem; display:block; }
.sp-field input, .sp-field select { width:100%; background:rgba(255,255,255,.06); border:1px solid rgba(255,255,255,.08); border-radius:.625rem; color:#fff; padding:.6rem .875rem; font-size:.875rem; outline:none; }
.sp-field input:focus, .sp-field select:focus { border-color:var(--primary); }
.sp-field input[type="color"] { height:2.5rem; padding:.25rem .4rem; cursor:pointer; }
</style>

<div class="sp-wrap">
    <!-- Flash messages -->
    <?php if (!empty($_SESSION['flash'])): ?>
    <?php $__flash = $_SESSION['flash']; unset($_SESSION['flash']); ?>
    <div style="background:<?= $__flash['type']==='success' ? 'rgba(16,185,129,.12)' : 'rgba(239,68,68,.12)' ?>;border:1px solid <?= $__flash['type']==='success' ? 'rgba(16,185,129,.3)' : 'rgba(239,68,68,.3)' ?>;color:<?= $__flash['type']==='success' ? '#6EE7B7' : '#fca5a5' ?>;padding:12px 16px;border-radius:12px;font-size:.875rem;margin-bottom:1rem;">
        <?= htmlspecialchars($__flash['message']) ?>
    </div>
    <?php endif; ?>

    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;flex-wrap:wrap;gap:.75rem">
        <div>
            <h1 style="font-family:'Jockey One',sans-serif;font-size:1.375rem;color:#fff;margin:0">Deportes del Sistema</h1>
            <p style="font-size:.8125rem;color:#64748b;margin:.25rem 0 0">Gestiona la lista maestra de deportes e iconos PNG para las tarjetas del Home.</p>
        </div>
        <button class="sp-btn sp-btn-primary" onclick="openAddModal()">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
            Nuevo Deporte
        </button>
    </div>

    <!-- Sport cards grid -->
    <div class="sp-grid">
        <?php foreach ($sports as $sport): ?>
        <?php
            $bgFrom = htmlspecialchars($sport['color_from']);
            $bgTo   = htmlspecialchars($sport['color_to']);
        ?>
        <div class="sp-card">
            <!-- Thumbnail / gradient preview -->
            <div class="sp-thumb" style="background:linear-gradient(135deg,<?= $bgFrom ?>,<?= $bgTo ?>)">
                <?php if (!empty($sport['image_path'])): ?>
                <img src="<?= BASE_URL . htmlspecialchars($sport['image_path']) ?>" alt="<?= htmlspecialchars($sport['name']) ?>">
                <?php else: ?>
                <svg viewBox="0 0 24 24" width="48" height="48" fill="none" stroke="rgba(255,255,255,.7)" stroke-width="1.5" xmlns="http://www.w3.org/2000/svg">
                    <circle cx="12" cy="12" r="9"/><path d="M12 3v3.5M12 20.5v-3"/>
                </svg>
                <?php endif; ?>
            </div>

            <!-- Name + slug + status -->
            <div style="display:flex;align-items:center;justify-content:space-between;gap:.5rem">
                <div>
                    <div class="sp-name"><?= htmlspecialchars($sport['name']) ?></div>
                    <div class="sp-slug"><?= htmlspecialchars($sport['slug']) ?></div>
                </div>
                <span class="<?= $sport['is_active'] ? 'sp-badge-on' : 'sp-badge-off' ?>">
                    <?= $sport['is_active'] ? 'Activo' : 'Oculto' ?>
                </span>
            </div>

            <!-- Color swatches -->
            <div style="display:flex;gap:.375rem;align-items:center">
                <span style="width:1.1rem;height:1.1rem;border-radius:.25rem;background:<?= $bgFrom ?>;display:inline-block;border:1px solid rgba(255,255,255,.15)"></span>
                <span style="width:1.1rem;height:1.1rem;border-radius:.25rem;background:<?= $bgTo ?>;display:inline-block;border:1px solid rgba(255,255,255,.15)"></span>
                <span style="font-size:.7rem;color:#64748b">Degradado de tarjeta</span>
            </div>

            <!-- Actions -->
            <div style="display:flex;flex-wrap:wrap;gap:.375rem">
                <!-- Upload image -->
                <form method="POST" action="<?= BASE_URL ?>config/upload-sport-image" enctype="multipart/form-data" style="display:contents">
                    <input type="hidden" name="sport_id" value="<?= (int)$sport['id'] ?>">
                    <label class="sp-btn sp-btn-img" style="cursor:pointer">
                        <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M21 15v4a2 2 0 01-2 2H5a2 2 0 01-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
                        Subir PNG
                        <input type="file" name="sport_image" accept="image/png,image/jpeg,image/webp" style="display:none" onchange="this.form.submit()">
                    </label>
                </form>

                <!-- Edit colors/name -->
                <button class="sp-btn sp-btn-tog"
                        onclick="openEditModal(<?= (int)$sport['id'] ?>,'<?= htmlspecialchars($sport['name'], ENT_QUOTES) ?>','<?= htmlspecialchars($sport['slug'], ENT_QUOTES) ?>','<?= $bgFrom ?>','<?= $bgTo ?>',<?= (int)$sport['sort_order'] ?>)">
                    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 00-2 2v14a2 2 0 002 2h14a2 2 0 002-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    Editar
                </button>

                <!-- Toggle active -->
                <form method="POST" action="<?= BASE_URL ?>config/sports" style="display:contents">
                    <input type="hidden" name="action" value="toggle">
                    <input type="hidden" name="id" value="<?= (int)$sport['id'] ?>">
                    <button type="submit" class="sp-btn sp-btn-tog">
                        <?= $sport['is_active'] ? 'Ocultar' : 'Mostrar' ?>
                    </button>
                </form>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</div>

<!-- ── Add/Edit Sport Modal ──────────────────────────────── -->
<div class="sp-modal" id="sportModal">
    <div class="sp-sheet">
        <h2 style="font-family:'Jockey One',sans-serif;font-size:1.1rem;color:#fff;margin:0 0 1.125rem">
            <span id="modalTitle">Nuevo Deporte</span>
        </h2>
        <form method="POST" action="<?= BASE_URL ?>config/sports" id="sportForm">
            <input type="hidden" name="action" value="save">
            <input type="hidden" name="id" id="sportId" value="">

            <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;margin-bottom:.75rem">
                <div class="sp-field" style="grid-column:1/-1">
                    <label>Nombre del deporte *</label>
                    <input type="text" name="name" id="sportName" required placeholder="Fútbol">
                </div>
                <div class="sp-field" style="grid-column:1/-1">
                    <label>Clave (slug) *</label>
                    <input type="text" name="slug" id="sportSlug" required placeholder="football" pattern="[a-z0-9_]+">
                </div>
                <div class="sp-field">
                    <label>Color inicio (degradado)</label>
                    <input type="color" name="color_from" id="sportColorFrom" value="#10b981">
                </div>
                <div class="sp-field">
                    <label>Color fin (degradado)</label>
                    <input type="color" name="color_to" id="sportColorTo" value="#059669">
                </div>
                <div class="sp-field">
                    <label>Orden de visualización</label>
                    <input type="number" name="sort_order" id="sportOrder" value="0" min="0">
                </div>
            </div>

            <div style="display:flex;gap:.625rem;justify-content:flex-end">
                <button type="button" class="sp-btn sp-btn-tog" onclick="closeModal()">Cancelar</button>
                <button type="submit" class="sp-btn sp-btn-primary">Guardar</button>
            </div>
        </form>
    </div>
</div>

<script>
function openAddModal() {
    document.getElementById('modalTitle').textContent = 'Nuevo Deporte';
    document.getElementById('sportId').value = '';
    document.getElementById('sportName').value = '';
    document.getElementById('sportSlug').value = '';
    document.getElementById('sportColorFrom').value = '#10b981';
    document.getElementById('sportColorTo').value = '#059669';
    document.getElementById('sportOrder').value = '0';
    document.getElementById('sportModal').classList.add('open');
}
function openEditModal(id, name, slug, cf, ct, order) {
    document.getElementById('modalTitle').textContent = 'Editar Deporte';
    document.getElementById('sportId').value = id;
    document.getElementById('sportName').value = name;
    document.getElementById('sportSlug').value = slug;
    document.getElementById('sportColorFrom').value = cf;
    document.getElementById('sportColorTo').value = ct;
    document.getElementById('sportOrder').value = order;
    document.getElementById('sportModal').classList.add('open');
}
function closeModal() {
    document.getElementById('sportModal').classList.remove('open');
}
document.getElementById('sportModal').addEventListener('click', function(e) {
    if (e.target === this) closeModal();
});
// Auto-generate slug from name
document.getElementById('sportName').addEventListener('input', function() {
    if (!document.getElementById('sportId').value) {
        document.getElementById('sportSlug').value = this.value
            .toLowerCase()
            .normalize('NFD').replace(/[\u0300-\u036f]/g, '')
            .replace(/[^a-z0-9]+/g, '_')
            .replace(/^_+|_+$/g, '');
    }
});
</script>
