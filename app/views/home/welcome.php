<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienvenido — <?= APP_NAME ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; }
        .slide { display: none; }
        .slide.active { display: flex; }
        .dot { width: 8px; height: 8px; border-radius: 50%; background: #cbd5e1; transition: background 0.3s; cursor: pointer; }
        .dot.active { background: #0EA5E9; width: 24px; border-radius: 4px; }
    </style>
</head>
<body class="min-h-screen bg-gradient-to-br from-sky-50 via-white to-violet-50 flex flex-col">

<!-- Top bar with skip -->
<div class="flex items-center justify-between px-6 py-4 max-w-5xl mx-auto w-full">
    <a href="<?= BASE_URL ?>" class="flex items-center gap-2">
        <img src="<?= BASE_URL ?>public/assets/logo.svg" alt="ID Sports" class="h-8">
        <span class="font-bold text-gray-900 text-lg">ID Sports</span>
    </a>
    <a href="<?= BASE_URL ?>home" class="text-sm text-gray-400 hover:text-gray-600 font-medium">Saltar →</a>
</div>

<!-- Slides container -->
<div class="flex-1 flex flex-col items-center justify-center px-4 py-6">
    <div class="w-full max-w-4xl">

        <!-- Slide 1 -->
        <div class="slide active flex-col items-center text-center" id="slide-1">
            <div class="mb-2 text-xs font-semibold text-sky-500 uppercase tracking-widest">❖ Proceso de Introducción 1</div>
            <div class="w-full max-w-2xl bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="relative bg-gradient-to-br from-sky-800 to-sky-600" style="height:260px;">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <div class="text-7xl mb-4">🏟️</div>
                            <div class="text-lg font-semibold opacity-80">Reserva tu espacio deportivo</div>
                        </div>
                    </div>
                    <!-- Decorative overlay -->
                    <div class="absolute bottom-4 right-4 bg-white/20 backdrop-blur rounded-xl px-4 py-2 text-white text-sm font-medium">
                        📱 En tu móvil o PC
                    </div>
                </div>
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Acceso y control total</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        Dentro de una misma aplicación encuentra servicios, lugares, horarios y todo lo que necesitas para disfrutar tu deporte favorito: canchas, luces, red, cerraduras y más — todo desde aquí.
                    </p>
                    <button onclick="goToSlide(2)" class="mt-6 w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                        ➕ Iniciar Ahora
                    </button>
                </div>
            </div>
        </div>

        <!-- Slide 2 -->
        <div class="slide flex-col items-center text-center" id="slide-2">
            <div class="mb-2 text-xs font-semibold text-sky-500 uppercase tracking-widest">❖ Proceso de Introducción 2</div>
            <div class="w-full max-w-2xl bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="relative bg-gradient-to-br from-orange-700 to-amber-500" style="height:260px;">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <div class="text-7xl mb-4">⚡</div>
                            <div class="text-lg font-semibold opacity-80">Sistema inteligente y automático</div>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 bg-white/20 backdrop-blur rounded-xl px-4 py-2 text-white text-sm font-medium">
                        💡 Smart &nbsp; 🔊 Sonido
                    </div>
                </div>
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Optimización automática</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        El sistema ajusta automáticamente la iluminación, el sonido y los recursos del espacio para cada partido. Menos preocupaciones, más juego: la tecnología trabaja por ti para que cada sesión sea perfecta.
                    </p>
                    <button onclick="goToSlide(3)" class="mt-6 w-full bg-sky-500 hover:bg-sky-600 text-white font-semibold py-3 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                        Siguiente →
                    </button>
                </div>
            </div>
        </div>

        <!-- Slide 3 -->
        <div class="slide flex-col items-center text-center" id="slide-3">
            <div class="mb-2 text-xs font-semibold text-sky-500 uppercase tracking-widest">❖ Proceso de Introducción 3</div>
            <div class="w-full max-w-2xl bg-white rounded-3xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="relative bg-gradient-to-br from-teal-600 to-emerald-500" style="height:260px;">
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center text-white">
                            <div class="text-7xl mb-4">🎯</div>
                            <div class="text-lg font-semibold opacity-80">Hecha a tu medida</div>
                        </div>
                    </div>
                    <div class="absolute bottom-4 right-4 bg-white/20 backdrop-blur rounded-xl px-4 py-2 text-white text-sm font-medium">
                        🎵 Rock 80s &nbsp; ✨ Personalizado
                    </div>
                </div>
                <div class="p-8">
                    <h2 class="text-2xl font-bold text-gray-900 mb-3">Experiencia personalizada</h2>
                    <p class="text-gray-500 text-sm leading-relaxed">
                        A tus necesidades. Configura tus preferencias de deporte, horarios favoritos, música de ambiente y más. ID Sports aprende de ti para ofrecerte siempre la mejor experiencia que se ajusta a tu estilo de juego.
                    </p>
                    <a href="<?= BASE_URL ?>home" class="mt-6 w-full bg-emerald-500 hover:bg-emerald-600 text-white font-semibold py-3 rounded-xl transition-all shadow-sm flex items-center justify-center gap-2">
                        Ir al inicio →
                    </a>
                </div>
            </div>
        </div>

        <!-- Dots navigation -->
        <div class="flex items-center justify-center gap-2 mt-6" id="dots">
            <div class="dot active" onclick="goToSlide(1)" id="dot-1"></div>
            <div class="dot" onclick="goToSlide(2)" id="dot-2"></div>
            <div class="dot" onclick="goToSlide(3)" id="dot-3"></div>
        </div>

    </div>
</div>

<script>
function goToSlide(n) {
    document.querySelectorAll('.slide').forEach(s => s.classList.remove('active'));
    document.querySelectorAll('.dot').forEach(d => d.classList.remove('active'));
    document.getElementById('slide-' + n).classList.add('active');
    document.getElementById('dot-' + n).classList.add('active');
}
</script>
</body>
</html>
