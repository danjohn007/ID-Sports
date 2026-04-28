<h1 class="auth-title">Recuperar acceso</h1>
<p class="auth-subtitle">Te enviaremos un código a tu correo</p>

<?php if ($error): ?>
<div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($success): ?>
    <div class="auth-success">✅ <?= htmlspecialchars($success) ?></div>
    <a href="<?= BASE_URL ?>auth/reset" class="auth-btn-primary" style="display:block;text-align:center;text-decoration:none;padding:15px;margin-top:0;">
        Ingresar Código OTP →
    </a>
<?php else: ?>
    <p style="font-size:.875rem;color:#9CA3AF;text-align:center;margin-bottom:24px;">
        Ingresa tu correo y te enviaremos un código de 6 dígitos para restablecer tu contraseña.
    </p>
    <form method="POST" class="auth-form">
        <div class="auth-input-group">
            <label class="auth-label" for="forgotEmail">Correo Electrónico</label>
            <input type="email" id="forgotEmail" name="email" class="auth-input"
                placeholder="tu@email.com" required autocomplete="email">
        </div>
        <button type="submit" class="auth-btn-primary">Enviar Código</button>
    </form>
<?php endif; ?>

<p class="auth-footer-text">
    <a href="<?= BASE_URL ?>auth/login" class="auth-link">← Volver al login</a>
</p>
