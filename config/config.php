<?php
// ─── Database ─────────────────────────────────────────────────────────────────
// cPanel users: replace these with your actual cPanel database credentials.
// DB_HOST  → usually 'localhost'
// DB_USER  → typically 'cpanelusername_dbuser'  (your cPanel username + underscore + DB user)
// DB_PASS  → the password you set when creating the DB user in cPanel
// DB_NAME  → typically 'cpanelusername_dbname'  (your cPanel username + underscore + DB name)
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'id_sports');
define('DB_CHARSET', 'utf8mb4');

// ─── BASE_URL (auto-detected) ─────────────────────────────────────────────────
// Works at the domain root AND in subdirectories (e.g. public_html/sports/).
// No manual change is needed here.
$protocol  = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
$host      = $_SERVER['HTTP_HOST'] ?? 'localhost';
$scriptDir = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'] ?? ''));
$scriptDir = ($scriptDir === '/') ? '' : $scriptDir;
define('BASE_URL', $protocol . '://' . $host . $scriptDir . '/');

// ─── App settings ─────────────────────────────────────────────────────────────
define('APP_NAME', 'ID Sports');
define('APP_VERSION', '1.0.0');
define('SESSION_NAME', 'id_sports_session');
define('OTP_EXPIRY', 600); // 10 minutes
