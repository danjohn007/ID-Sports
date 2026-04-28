<?php
// Load Poppins + Jockey One and the dedicated CSS for this page
$cfgPrimary   = htmlspecialchars($config['color_primary']      ?? '#0EA5E9');
$cfgSecondary = htmlspecialchars($config['color_secondary']    ?? '#7C3AED');
$cfgLoginBtn  = htmlspecialchars($config['color_login_button'] ?? $config['color_primary'] ?? '#0EA5E9');
$cfgLoginLink = htmlspecialchars($config['color_login_link']   ?? $config['color_primary'] ?? '#0EA5E9');
$cfgBgImage   = htmlspecialchars($config['auth_bg_image']      ?? '');
?>
<link href="https://fonts.googleapis.com/css2?family=Jockey+One&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>public/css/config-colors.css">

<style>
    /* Override admin layout bg for this page so the dark panel reads correctly */
    .cc-wrapper { max-width: 1100px; }
</style>

<div class="cc-wrapper">
    <?php if ($success ?? false): ?>
    <div style="background:rgba(16,185,129,.12);border:1px solid rgba(16,185,129,.3);color:#6EE7B7;padding:12px 16px;border-radius:12px;font-size:.875rem;margin-bottom:20px;font-family:'Poppins',sans-serif;">
        ✅ Colores actualizados correctamente
    </div>
    <?php endif; ?>

    <form method="POST" id="colorForm">
    <div class="cc-grid">

        <!-- ── Left column: form ──────────────────────── -->
        <div class="cc-form-panel">
            <h2 style="font-family:'Jockey One',sans-serif;font-size:1.25rem;text-transform:uppercase;letter-spacing:.08em;margin-bottom:6px;">🎨 Paleta de Colores</h2>
            <p style="font-family:'Poppins',sans-serif;font-size:.8125rem;font-weight:300;color:#94a3b8;margin-bottom:24px;">Los cambios se reflejan en tiempo real en la vista previa →</p>

            <!-- Primary & Secondary -->
            <div class="cc-section-heading">🌟 Globales</div>

            <?php
            $colorFields = [
                'color_primary'   => ['Color Primario', '#0EA5E9', 'Botones CTA, glow, acento de la marca'],
                'color_secondary' => ['Color Secundario', '#7C3AED', 'Elementos de soporte, badges'],
                'color_success'   => ['Éxito', '#10B981', 'Confirmaciones, estados activos'],
                'color_danger'    => ['Error / Alerta', '#EF4444', 'Mensajes de error, acciones destructivas'],
                'color_warning'   => ['Advertencia', '#F59E0B', 'Alertas, estados pendientes'],
            ];
            foreach ($colorFields as $key => [$label, $default, $hint]):
                $val = $config[$key] ?? $default;
            ?>
            <div class="cc-row">
                <input type="color" name="<?= $key ?>" id="swatch_<?= $key ?>"
                       value="<?= htmlspecialchars($val) ?>" class="cc-swatch"
                       oninput="syncHex(this,'hex_<?= $key ?>')">
                <div class="cc-info">
                    <div class="cc-label"><?= $label ?></div>
                    <input type="text" id="hex_<?= $key ?>" name="<?= $key ?>_hex"
                           value="<?= htmlspecialchars($val) ?>" class="cc-hex-input" maxlength="7"
                           oninput="syncSwatch(this,'swatch_<?= $key ?>')" placeholder="#000000">
                    <div class="cc-hint"><?= $hint ?></div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Login-specific colors -->
            <div class="cc-section-heading">🔐 Pantalla de Login</div>

            <?php
            $loginFields = [
                'color_login_button'  => ['Botón "Entrar"',          '#0EA5E9', 'Fondo del botón principal de login'],
                'color_login_link'    => ['Links / "Regístrate"',     '#0EA5E9', 'Color de los enlaces de navegación'],
            ];
            foreach ($loginFields as $key => [$label, $default, $hint]):
                $val = $config[$key] ?? $default;
            ?>
            <div class="cc-row">
                <input type="color" name="<?= $key ?>" id="swatch_<?= $key ?>"
                       value="<?= htmlspecialchars($val) ?>" class="cc-swatch"
                       oninput="syncHex(this,'hex_<?= $key ?>');updatePreview()">
                <div class="cc-info">
                    <div class="cc-label"><?= $label ?></div>
                    <input type="text" id="hex_<?= $key ?>" name="<?= $key ?>_hex"
                           value="<?= htmlspecialchars($val) ?>" class="cc-hex-input" maxlength="7"
                           oninput="syncSwatch(this,'swatch_<?= $key ?>');updatePreview()" placeholder="#000000">
                    <div class="cc-hint"><?= $hint ?></div>
                </div>
            </div>
            <?php endforeach; ?>

            <!-- Background image -->
            <div class="cc-section-heading">🖼️ Fondo del Login</div>
            <label style="font-family:'Poppins',sans-serif;font-size:.75rem;font-weight:600;text-transform:uppercase;letter-spacing:.04em;color:#94a3b8;display:block;margin-bottom:8px;">URL de imagen de fondo</label>
            <input type="url" name="auth_bg_image" id="bgImageUrl"
                   value="<?= $cfgBgImage ?>"
                   placeholder="https://ejemplo.com/fondo-cancha.jpg"
                   class="cc-url-field"
                   oninput="updateBgPreview(this.value)">
            <p class="cc-hint">Si se deja vacío se usa el gradiente oscuro por defecto. La imagen se superpone sobre el gradiente.</p>

            <!-- Light mode accent -->
            <div class="cc-section-heading" style="margin-top:24px;">☀️ Modo Claro</div>
            <?php
            $lightPrimaryVal = $config['color_light_primary'] ?? $config['color_primary'] ?? '#0EA5E9';
            $lightPrimaryVal = htmlspecialchars($lightPrimaryVal);
            ?>
            <div class="cc-row">
                <input type="color" name="color_light_primary" id="swatch_color_light_primary"
                       value="<?= $lightPrimaryVal ?>" class="cc-swatch"
                       oninput="syncHex(this,'hex_color_light_primary')">
                <div class="cc-info">
                    <div class="cc-label">Acento para Modo Claro</div>
                    <input type="text" id="hex_color_light_primary" name="color_light_primary_hex"
                           value="<?= $lightPrimaryVal ?>" class="cc-hex-input" maxlength="7"
                           oninput="syncSwatch(this,'swatch_color_light_primary')" placeholder="#000000">
                    <div class="cc-hint">Color primario que se aplica cuando el usuario activa el modo claro (☀️). Puede ser diferente al color del modo oscuro.</div>
                </div>
            </div>

            <button type="submit" class="cc-save-btn">💾 Guardar Cambios</button>
        </div>

        <!-- ── Right column: live preview ────────────────── -->
        <div class="cc-preview" id="livePreview">
            <div class="cc-preview-title">Vista previa en tiempo real</div>

            <!-- Mini login screen preview -->
            <div class="cc-preview-screen" id="previewScreen"
                 style="background:linear-gradient(160deg,#060B19 0%,#0D1117 60%,#111827 100%);">
                <div class="cc-preview-screen-top">
                    <div class="cc-preview-screen-name" id="prevName" style="color:<?= $cfgPrimary ?>;text-shadow:0 0 30px <?= $cfgPrimary ?>;">
                        ID SPORTS
                    </div>
                    <div style="font-family:'Poppins',sans-serif;font-size:.65rem;color:#94a3b8;margin-top:4px;font-weight:300;">Tu cancha favorita</div>
                </div>
                <div style="padding:14px 16px 18px;">
                    <div style="background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.1);border-radius:10px;padding:10px 14px;margin-bottom:10px;">
                        <div style="font-family:'Poppins',sans-serif;font-size:.65rem;color:rgba(255,255,255,.25);">tu@email.com</div>
                    </div>
                    <button class="cc-preview-btn" id="prevBtn" style="background:<?= $cfgLoginBtn ?>; box-shadow:0 4px 20px <?= $cfgLoginBtn ?>33;">
                        Entrar
                    </button>
                    <div style="text-align:center;margin-top:8px;">
                        <span style="font-family:'Poppins',sans-serif;font-size:.65rem;color:#94a3b8;font-weight:300;">¿No tienes cuenta? </span>
                        <a class="cc-preview-link" id="prevLink" style="color:<?= $cfgLoginLink ?>;" href="#">Regístrate</a>
                    </div>
                </div>
            </div>

            <!-- Glow bar showing primary color -->
            <div class="cc-preview-glow" id="prevGlow"
                 style="background:linear-gradient(90deg,transparent,<?= $cfgPrimary ?>,transparent);"></div>

            <!-- Accent chip -->
            <div style="margin-top:16px;display:flex;gap:8px;flex-wrap:wrap;">
                <div id="prevChip" style="padding:6px 14px;border-radius:20px;font-family:'Poppins',sans-serif;font-size:.7rem;font-weight:600;color:#fff;background:<?= $cfgPrimary ?>;">
                    Primario
                </div>
                <div style="padding:6px 14px;border-radius:20px;font-family:'Poppins',sans-serif;font-size:.7rem;font-weight:600;color:rgba(255,255,255,.6);background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);">
                    Secundario
                </div>
            </div>

            <p style="font-family:'Poppins',sans-serif;font-size:.65rem;color:#475569;margin-top:14px;font-weight:300;">Los cambios son solo visuales hasta que guardes.</p>
        </div>

    </div>
    </form>
</div>

<script>
// Sync color picker → hex input
function syncHex(picker, hexId) {
    var inp = document.getElementById(hexId);
    if (inp) { inp.value = picker.value; }
    updatePreview();
}
// Sync hex input → color picker
function syncSwatch(hexInput, swatchId) {
    var v = hexInput.value;
    if (/^#[0-9a-fA-F]{6}$/.test(v)) {
        var sw = document.getElementById(swatchId);
        if (sw) sw.value = v;
        updatePreview();
    }
}

// Update live preview from current form values
function updatePreview() {
    var primary  = document.getElementById('swatch_color_primary')       ? document.getElementById('swatch_color_primary').value   : '<?= $cfgPrimary ?>';
    var loginBtn = document.getElementById('swatch_color_login_button')  ? document.getElementById('swatch_color_login_button').value  : '<?= $cfgLoginBtn ?>';
    var loginLnk = document.getElementById('swatch_color_login_link')    ? document.getElementById('swatch_color_login_link').value    : '<?= $cfgLoginLink ?>';

    var btn = document.getElementById('prevBtn');
    if (btn) { btn.style.background = loginBtn; btn.style.boxShadow = '0 4px 20px '+loginBtn+'33'; }

    var lnk = document.getElementById('prevLink');
    if (lnk) lnk.style.color = loginLnk;

    var nm  = document.getElementById('prevName');
    if (nm)  { nm.style.color = primary; nm.style.textShadow = '0 0 30px '+primary; }

    var glow = document.getElementById('prevGlow');
    if (glow) glow.style.background = 'linear-gradient(90deg,transparent,'+primary+',transparent)';

    var chip = document.getElementById('prevChip');
    if (chip) chip.style.background = primary;
}

function updateBgPreview(url) {
    var scr = document.getElementById('previewScreen');
    if (!scr) return;
    if (url && url.length > 8) { /* 8 = min length of 'https://' */
        scr.style.backgroundImage = 'url("'+url+'")';
        scr.style.backgroundSize = 'cover';
        scr.style.backgroundPosition = 'center';
    } else {
        scr.style.backgroundImage = '';
        scr.style.background = 'linear-gradient(160deg,#060B19 0%,#0D1117 60%,#111827 100%)';
    }
}

// Wire up primary swatch to updatePreview too
(function(){
    var sw = document.getElementById('swatch_color_primary');
    if (sw) sw.addEventListener('input', updatePreview);
    // init BG
    updateBgPreview(document.getElementById('bgImageUrl') ? document.getElementById('bgImageUrl').value : '');
})();
</script>
