<?php
class Model {
    protected $pdo;

    public function __construct() {
        try {
            $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false,
            ];
            $this->pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
        } catch (PDOException $e) {
            error_log('DB connection failed: ' . $e->getMessage());
            http_response_code(503);
            die('<!DOCTYPE html><html lang="es"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Error de conexión — ID Sports</title><style>body{font-family:sans-serif;display:flex;align-items:center;justify-content:center;min-height:100vh;margin:0;background:#f0f9ff}div{background:#fff;border-radius:1rem;padding:2rem 2.5rem;max-width:480px;box-shadow:0 4px 24px rgba(0,0,0,.08);text-align:center}h2{color:#0ea5e9;margin-top:0}p{color:#64748b;font-size:.95rem}small{display:block;margin-top:1rem;font-size:.8rem;color:#94a3b8}</style></head><body><div><h2>⚠️ Error de conexión a la base de datos</h2><p>No se pudo conectar con la base de datos. Verifica los datos en <strong>config/config.php</strong> y asegúrate de que la base de datos exista en cPanel.</p><small>El detalle del error ha sido registrado en el log del servidor.</small></div></body></html>');
        }
    }

    protected function query($sql, $params = []) {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt;
    }

    protected function findOne($sql, $params = []) {
        return $this->query($sql, $params)->fetch();
    }

    protected function findAll($sql, $params = []) {
        return $this->query($sql, $params)->fetchAll();
    }

    protected function execute($sql, $params = []) {
        return $this->query($sql, $params);
    }

    protected function lastInsertId() {
        return $this->pdo->lastInsertId();
    }
}
