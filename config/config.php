<?php
// Database
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'id_sports');
define('DB_CHARSET', 'utf8mb4');

// Auto-detect BASE_URL (handles direct HTTPS and reverse-proxy setups such as cPanel).
// HTTP_X_FORWARDED_PROTO and HTTP_X_FORWARDED_SSL are set by cPanel's trusted reverse
// proxy. Ensure your web server strips these headers from untrusted client requests.
$isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
    || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
    || (isset($_SERVER['HTTP_X_FORWARDED_SSL']) && $_SERVER['HTTP_X_FORWARDED_SSL'] === 'on');
$protocol = $isHttps ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
$scriptDir = ($scriptDir === '/') ? '' : $scriptDir;
define('BASE_URL', $protocol . '://' . $host . $scriptDir . '/');

// App settings
define('APP_NAME', 'ID Sports');
define('APP_VERSION', '1.0.0');
define('SESSION_NAME', 'id_sports_session');
define('OTP_EXPIRY', 600); // 10 minutes
