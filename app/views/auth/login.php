<h1 class="auth-title">Ingresa a<br>ID Sports</h1>
<p class="auth-subtitle">Tu cancha favorita, a un toque de distancia</p>

<?php if ($error): ?>
<div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<form method="POST" class="auth-form" id="loginForm" novalidate>
    <div class="auth-input-group">
        <label class="auth-label" for="loginEmail">Correo Electrónico</label>
        <input type="email" id="loginEmail" name="email" class="auth-input"
            placeholder="tu@email.com"
            value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"
            required autocomplete="email">
    </div>
    <div class="auth-input-group">
        <label class="auth-label" for="loginPwd">Contraseña</label>
        <div class="auth-pwd-wrap">
            <input type="password" id="loginPwd" name="password" class="auth-input"
                placeholder="••••••••"
                required autocomplete="current-password"
                style="padding-right:50px;">
            <button type="button" class="auth-pwd-toggle" onclick="authTogglePwd('loginPwd')" title="Mostrar/ocultar contraseña">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="auth-remember-row">
        <label class="auth-checkbox-label">
            <input type="checkbox" name="remember"> Recordarme
        </label>
        <a href="<?= BASE_URL ?>auth/forgot" class="auth-link" style="font-size:.8125rem;">¿Olvidaste tu contraseña?</a>
    </div>
    <button type="submit" class="auth-btn-primary">Entrar</button>
</form>

<div class="auth-divider">O continúa con</div>

<div class="auth-social-row">
    <button type="button" class="auth-social-btn" onclick="alert('Google Login: próximamente disponible')">
        <svg width="18" height="18" viewBox="0 0 48 48" aria-hidden="true">
            <path fill="#EA4335" d="M24 9.5c3.5 0 6.6 1.2 9.1 3.2l6.8-6.8C35.8 2.2 30.2 0 24 0 14.7 0 6.8 5.4 3 13.3l7.9 6.1C12.8 13.2 17.9 9.5 24 9.5z"/>
            <path fill="#4285F4" d="M46.5 24.5c0-1.6-.1-3.1-.4-4.5H24v8.6h12.8c-.6 3-2.3 5.5-4.8 7.2l7.4 5.7c4.3-4 6.8-9.9 7.1-17z"/>
            <path fill="#FBBC05" d="M10.9 28.7A14.5 14.5 0 0 1 9.5 24c0-1.6.3-3.2.8-4.6l-7.9-6.1A23.5 23.5 0 0 0 .5 24c0 3.8.9 7.4 2.5 10.6l7.9-5.9z"/>
            <path fill="#34A853" d="M24 48c6.3 0 11.6-2.1 15.5-5.7l-7.4-5.7c-2.1 1.4-4.7 2.2-8.1 2.2-6.1 0-11.2-3.8-13-9l-7.9 5.9C6.8 42.6 14.7 48 24 48z"/>
        </svg>
        Google
    </button>
    <button type="button" class="auth-social-btn" onclick="alert('Apple Login: próximamente disponible')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
            <path d="M17.05 20.28c-.98.95-2.05.8-3.08.35-1.09-.46-2.09-.48-3.24 0-1.44.62-2.2.44-3.06-.35C2.79 15.25 3.51 7.7 9.05 7.42c1.39.07 2.35.74 3.17.8.96-.19 1.88-.88 3.04-.84 2.07.09 3.62 1.04 4.28 2.9-3.96 2.41-3.32 7.96.51 9.99zM12.03 7.25c-.21-2.69 2.05-4.9 4.56-5.25.37 2.74-2.49 5.05-4.56 5.25z"/>
        </svg>
        Apple
    </button>
    <button type="button" class="auth-social-btn" onclick="alert('Facebook Login: próximamente disponible')">
        <svg width="18" height="18" viewBox="0 0 24 24" fill="#1877F2" aria-hidden="true">
            <path d="M24 12.07C24 5.41 18.63 0 12 0S0 5.41 0 12.07C0 18.1 4.39 23.1 10.13 24v-8.44H7.08v-3.49h3.04V9.41c0-3.02 1.8-4.7 4.54-4.7 1.31 0 2.68.24 2.68.24v2.97h-1.5c-1.49 0-1.96.93-1.96 1.89v2.26h3.32l-.53 3.49h-2.79V24C19.61 23.1 24 18.1 24 12.07z"/>
        </svg>
        Facebook
    </button>
</div>

<p class="auth-footer-text">
    ¿No tienes cuenta? <a href="<?= BASE_URL ?>auth/register" class="auth-link">Regístrate gratis</a>
</p>

<script>
function authTogglePwd(id) {
    var f = document.getElementById(id);
    f.type = f.type === 'password' ? 'text' : 'password';
}
</script>
