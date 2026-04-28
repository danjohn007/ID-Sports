<h1 class="auth-title">Crea tu cuenta</h1>
<p class="auth-subtitle">Únete a la comunidad deportiva</p>

<?php if ($error): ?>
<div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="auth-form" novalidate>
    <div class="auth-input-group">
        <label class="auth-label" for="regName">Nombre Completo *</label>
        <input type="text" id="regName" name="name" class="auth-input"
            placeholder="Juan Pérez"
            value="<?= htmlspecialchars($_POST['name'] ?? '') ?>"
            required autocomplete="name">
    </div>
    <div class="auth-input-group">
        <label class="auth-label" for="regEmail">Correo Electrónico *</label>
        <input type="email" id="regEmail" name="email" class="auth-input"
            placeholder="tu@email.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            required autocomplete="email">
    </div>
    <div class="auth-input-group">
        <label class="auth-label" for="regPhone">Celular (WhatsApp)</label>
        <input type="tel" id="regPhone" name="whatsapp" class="auth-input"
            placeholder="+52 442 123 4567"
            value="<?= htmlspecialchars($_POST['whatsapp'] ?? '') ?>"
            autocomplete="tel">
    </div>
    <div class="auth-input-group">
        <label class="auth-label" for="regState">Estado / Provincia</label>
        <input type="text" id="regState" name="state" class="auth-input"
            placeholder="ej. Querétaro, CDMX…"
            value="<?= htmlspecialchars($_POST['state'] ?? '') ?>"
            autocomplete="address-level1">
    </div>
    <div class="auth-input-group">
        <label class="auth-label" for="regPwd">Contraseña *</label>
        <div class="auth-pwd-wrap">
            <input type="password" id="regPwd" name="password" class="auth-input"
                placeholder="Mínimo 8 caracteres"
                required autocomplete="new-password"
                style="padding-right:50px;">
            <button type="button" class="auth-pwd-toggle" onclick="authTogglePwd('regPwd')" title="Mostrar/ocultar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="auth-input-group">
        <label class="auth-label" for="regPwdConf">Confirmar Contraseña *</label>
        <div class="auth-pwd-wrap">
            <input type="password" id="regPwdConf" name="password_confirm" class="auth-input"
                placeholder="Repite tu contraseña"
                required autocomplete="new-password"
                style="padding-right:50px;">
            <button type="button" class="auth-pwd-toggle" onclick="authTogglePwd('regPwdConf')" title="Mostrar/ocultar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
        </div>
    </div>
    <button type="submit" class="auth-btn-primary">Registrarme</button>
</form>

<p class="auth-footer-text">
    ¿Ya tienes cuenta? <a href="<?= BASE_URL ?>auth/login" class="auth-link">Iniciar Sesión</a>
</p>

<script>
function authTogglePwd(id) {
    var f = document.getElementById(id);
    f.type = f.type === 'password' ? 'text' : 'password';
}
</script>
