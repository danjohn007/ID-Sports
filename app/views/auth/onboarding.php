<?php
/* Onboarding — standalone page (no layout wrapper).
   Config values are injected by AuthController::onboarding().
   Variables available: $slides (array), $btnColor (string), $baseUrl (string). */
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido — ID Sports</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Jockey+One&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= htmlspecialchars($baseUrl) ?>public/css/onboarding.css">
    <style>:root { --primary-color: <?= htmlspecialchars($btnColor) ?>; }</style>
    <script>
        // If user already saw onboarding, jump straight to login
        if (localStorage.getItem('ids_onboarding_seen')) {
            window.location.replace('<?= htmlspecialchars($baseUrl) ?>auth/login');
        }
    </script>
</head>
<body>
<div class="ob-wrapper" id="obWrapper">

    <!-- Logo -->
    <a href="<?= htmlspecialchars($baseUrl) ?>" class="ob-logo">
        <img src="<?= htmlspecialchars($baseUrl) ?>public/assets/logo.svg" alt="ID Sports">
        <span>ID SPORTS</span>
    </a>

    <!-- Slides -->
    <div class="ob-slides" id="obSlides">
        <?php foreach ($slides as $i => $slide): ?>
        <div class="ob-slide">
            <div class="ob-slide-bg ob-slide-bg-<?= $i + 1 ?>"
                 <?php if (!empty($slide['image'])): ?>style="background-image:url('<?= htmlspecialchars($slide['image']) ?>')"<?php endif; ?>>
            </div>
            <div class="ob-slide-content">
                <span class="ob-slide-icon"><?= $slide['icon'] ?></span>
                <h2 class="ob-slide-title"><?= htmlspecialchars($slide['title']) ?></h2>
                <p class="ob-slide-desc"><?= htmlspecialchars($slide['desc']) ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>

    <!-- Controls -->
    <div class="ob-controls">
        <div class="ob-dots" id="obDots">
            <?php for ($i = 0; $i < count($slides); $i++): ?>
            <div class="ob-dot <?= $i === 0 ? 'active' : '' ?>" onclick="obGoTo(<?= $i ?>)"></div>
            <?php endfor; ?>
        </div>
        <button class="ob-btn" id="obNextBtn" onclick="obNext()">Siguiente</button>
        <a class="ob-skip" href="#" onclick="obComplete(event)">Omitir</a>
    </div>

</div><!-- /.ob-wrapper -->

<script>
(function () {
    var current  = 0;
    var total    = <?= count($slides) ?>;
    var loginUrl = '<?= htmlspecialchars($baseUrl) ?>auth/login';
    var slidesEl = document.getElementById('obSlides');
    var dots     = document.querySelectorAll('.ob-dot');
    var nextBtn  = document.getElementById('obNextBtn');

    function goTo(n) {
        current = n;
        slidesEl.style.transform = 'translateX(-' + (current * 33.3333) + '%)';
        dots.forEach(function (d, i) { d.classList.toggle('active', i === current); });
        nextBtn.textContent = current === total - 1 ? 'Comenzar' : 'Siguiente';
    }

    function complete() {
        localStorage.setItem('ids_onboarding_seen', '1');
        window.location.href = loginUrl;
    }

    // Expose to inline handlers
    window.obGoTo = goTo;
    window.obNext = function () {
        if (current < total - 1) { goTo(current + 1); } else { complete(); }
    };
    window.obComplete = function (e) { if (e) e.preventDefault(); complete(); };

    // Touch / swipe support
    var startX = 0;
    var wrapper = document.getElementById('obWrapper');
    wrapper.addEventListener('touchstart', function (e) {
        startX = e.touches[0].clientX;
    }, { passive: true });
    wrapper.addEventListener('touchend', function (e) {
        var diff = startX - e.changedTouches[0].clientX;
        if (Math.abs(diff) > 50) {
            if (diff > 0 && current < total - 1) { goTo(current + 1); }
            else if (diff < 0 && current > 0)    { goTo(current - 1); }
        }
    }, { passive: true });

    // Keyboard arrow support
    document.addEventListener('keydown', function (e) {
        if (e.key === 'ArrowRight') window.obNext();
        if (e.key === 'ArrowLeft' && current > 0) goTo(current - 1);
    });
}());
</script>
</body>
</html>
