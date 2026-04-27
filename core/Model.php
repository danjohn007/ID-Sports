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
            die(json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]));
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
