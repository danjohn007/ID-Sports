<h1 class="auth-title">Código de verificación</h1>
<p class="auth-subtitle">Revisa tu correo e ingresa los 6 dígitos</p>

<?php if ($error): ?>
<div class="auth-error">⚠️ <?= htmlspecialchars($error) ?></div>
<?php endif; ?>

<?php if ($email): ?>
<div class="auth-info">📧 Código enviado a <strong><?= htmlspecialchars($email) ?></strong></div>
<?php endif; ?>

<form method="POST" class="auth-form" id="otpForm" novalidate>
    <?php if ($email): ?>
    <input type="hidden" name="email" value="<?= htmlspecialchars($email) ?>">
    <?php else: ?>
    <div class="auth-input-group">
        <label class="auth-label" for="otpEmail">Correo Electrónico</label>
        <input type="email" id="otpEmail" name="email" class="auth-input"
            placeholder="tu@email.com" required autocomplete="email">
    </div>
    <?php endif; ?>

    <!-- 6 individual OTP digit boxes -->
    <label class="auth-label" style="text-align:center;margin-bottom:10px;">Código OTP</label>
    <div class="otp-container" id="otpContainer">
        <input class="otp-box" type="text" inputmode="numeric" pattern="[0-9]" maxlength="1" autocomplete="one-time-code">
        <input class="otp-box" type="text" inputmode="numeric" pattern="[0-9]" maxlength="1">
        <input class="otp-box" type="text" inputmode="numeric" pattern="[0-9]" maxlength="1">
        <input class="otp-box" type="text" inputmode="numeric" pattern="[0-9]" maxlength="1">
        <input class="otp-box" type="text" inputmode="numeric" pattern="[0-9]" maxlength="1">
        <input class="otp-box" type="text" inputmode="numeric" pattern="[0-9]" maxlength="1">
    </div>
    <!-- Hidden field holding the assembled code -->
    <input type="hidden" name="code" id="otpHidden">

    <div class="auth-input-group" style="margin-top:16px;">
        <label class="auth-label" for="newPwd">Nueva Contraseña</label>
        <div class="auth-pwd-wrap">
            <input type="password" id="newPwd" name="password" class="auth-input"
                placeholder="Mínimo 8 caracteres" required autocomplete="new-password"
                style="padding-right:50px;">
            <button type="button" class="auth-pwd-toggle" onclick="authTogglePwd('newPwd')" title="Mostrar/ocultar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
        </div>
    </div>
    <div class="auth-input-group">
        <label class="auth-label" for="confPwd">Confirmar Contraseña</label>
        <div class="auth-pwd-wrap">
            <input type="password" id="confPwd" name="password_confirm" class="auth-input"
                placeholder="Repite tu contraseña" required autocomplete="new-password"
                style="padding-right:50px;">
            <button type="button" class="auth-pwd-toggle" onclick="authTogglePwd('confPwd')" title="Mostrar/ocultar">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                    <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
            </button>
        </div>
    </div>
    <button type="submit" class="auth-btn-primary">Restablecer Contraseña</button>
</form>

<p class="auth-footer-text">
    <a href="<?= BASE_URL ?>auth/forgot" class="auth-link">← Solicitar nuevo código</a>
</p>

<script>
(function () {
    var boxes   = document.querySelectorAll('#otpContainer .otp-box');
    var hidden  = document.getElementById('otpHidden');
    var form    = document.getElementById('otpForm');

    function syncHidden() {
        var val = '';
        boxes.forEach(function (b) { val += b.value; });
        hidden.value = val;
    }

    boxes.forEach(function (box, i) {
        box.addEventListener('input', function () {
            // Keep only last typed digit
            box.value = box.value.replace(/[^0-9]/g, '').slice(-1);
            box.classList.toggle('otp-filled', box.value !== '');
            syncHidden();
            if (box.value && i < boxes.length - 1) { boxes[i + 1].focus(); }
        });
        box.addEventListener('keydown', function (e) {
            if (e.key === 'Backspace' && !box.value && i > 0) { boxes[i - 1].focus(); }
        });
        box.addEventListener('paste', function (e) {
            e.preventDefault();
            var pasted = (e.clipboardData || window.clipboardData).getData('text').replace(/[^0-9]/g, '');
            boxes.forEach(function (b, j) {
                b.value = pasted[j] || '';
                b.classList.toggle('otp-filled', !!b.value);
            });
            syncHidden();
            var next = Math.min(pasted.length, boxes.length - 1);
            boxes[next].focus();
        });
    });

    form.addEventListener('submit', function () { syncHidden(); });
}());

function authTogglePwd(id) {
    var f = document.getElementById(id);
    f.type = f.type === 'password' ? 'text' : 'password';
}
</script>
