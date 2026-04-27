<?php
/**
 * ID Sports — Connection & Environment Test
 * Access: /test_connection.php
 * REMOVE THIS FILE IN PRODUCTION
 */

define('ROOT', __DIR__);
require_once ROOT . '/config/config.php';

header('Content-Type: text/html; charset=utf-8');
?>
<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ID Sports — Test</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-50 p-6 font-sans">
<div class="max-w-xl mx-auto space-y-4">
    <div class="bg-sky-500 text-white rounded-2xl px-6 py-4">
        <h1 class="text-xl font-bold">🔧 ID Sports — Diagnóstico</h1>
        <p class="text-sky-100 text-sm">Comprueba que el entorno esté configurado correctamente</p>
    </div>

    <?php
    // PHP version
    $phpOk = version_compare(PHP_VERSION, '7.4', '>=');
    echo card($phpOk ? '✅' : '❌', 'PHP Version', PHP_VERSION . ($phpOk ? '' : ' (requiere ≥ 7.4)'), $phpOk);

    // BASE_URL
    echo card('🌐', 'BASE_URL', BASE_URL, true);

    // DB Connection
    try {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';port=' . DB_PORT . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
        );
        $dbVersion = $pdo->query('SELECT VERSION()')->fetchColumn();
        echo card('✅', 'Conexión MySQL', "Host: " . DB_HOST . " | DB: " . DB_NAME . " | v" . $dbVersion, true);

        // Check tables
        $tables = $pdo->query("SHOW TABLES")->fetchAll(PDO::FETCH_COLUMN);
        $expected = ['users','otp_codes','clubs','spaces','schedules','amenities','reservations','reviews','incidents','promotions','leads','config','iot_devices','action_logs','error_logs'];
        $missing  = array_diff($expected, $tables);
        if (empty($missing)) {
            echo card('✅', 'Tablas', 'Todas las ' . count($expected) . ' tablas encontradas', true);
        } else {
            echo card('⚠️', 'Tablas faltantes', implode(', ', $missing), false);
            echo '<div class="bg-amber-50 border border-amber-200 rounded-xl p-4 text-sm text-amber-700">Ejecuta: <code class="bg-amber-100 px-2 py-0.5 rounded">mysql -u ' . DB_USER . ' -p ' . DB_NAME . ' &lt; database/schema.sql</code></div>';
        }

        // Count seed data
        $userCount = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
        echo card('👥', 'Usuarios en BD', $userCount . ' usuario(s)', true);

    } catch (PDOException $e) {
        echo card('❌', 'Error MySQL', htmlspecialchars($e->getMessage()), false);
    }

    // Extensions
    $exts = ['pdo', 'pdo_mysql', 'json', 'mbstring', 'session'];
    foreach ($exts as $ext) {
        $ok = extension_loaded($ext);
        echo card($ok ? '✅' : '❌', "Extensión PHP: $ext", $ok ? 'Cargada' : 'NO disponible', $ok);
    }

    // Htaccess
    $htOk = file_exists(ROOT . '/.htaccess');
    echo card($htOk ? '✅' : '⚠️', '.htaccess', $htOk ? 'Presente' : 'No encontrado — URL rewriting puede fallar', $htOk);

    function card($icon, $label, $value, $ok) {
        $bg = $ok ? 'bg-white border-gray-100' : 'bg-red-50 border-red-200';
        return '<div class="' . $bg . ' border rounded-2xl px-5 py-3 flex items-center gap-3">
            <span class="text-2xl">' . $icon . '</span>
            <div><p class="font-semibold text-gray-900 text-sm">' . htmlspecialchars($label) . '</p>
            <p class="text-xs text-gray-500 mt-0.5">' . $value . '</p></div></div>';
    }
    ?>

    <div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 text-sm text-amber-700">
        <strong>⚠️ Recuerda eliminar este archivo en producción:</strong>
        <code class="block mt-1 font-mono">rm <?= htmlspecialchars(ROOT) ?>/test_connection.php</code>
    </div>

    <a href="<?= BASE_URL ?>auth/login" class="block w-full bg-sky-500 text-white font-bold text-center py-3 rounded-xl hover:bg-sky-600 transition-all">
        Ir al Login →
    </a>
</div>
</body>
</html>
