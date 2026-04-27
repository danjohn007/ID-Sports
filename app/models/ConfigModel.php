<?php
class ConfigModel extends Model {
    public function get($key, $default = null) {
        $row = $this->findOne("SELECT cfg_value FROM config WHERE cfg_key = ?", [$key]);
        return $row ? $row['cfg_value'] : $default;
    }

    public function set($key, $value) {
        $existing = $this->findOne("SELECT id FROM config WHERE cfg_key = ?", [$key]);
        if ($existing) {
            $this->execute("UPDATE config SET cfg_value = ? WHERE cfg_key = ?", [$value, $key]);
        } else {
            $this->execute("INSERT INTO config (cfg_key, cfg_value) VALUES (?, ?)", [$key, $value]);
        }
    }

    public function getAll() {
        $rows = $this->findAll("SELECT cfg_key, cfg_value FROM config");
        $result = [];
        foreach ($rows as $row) {
            $result[$row['cfg_key']] = $row['cfg_value'];
        }
        return $result;
    }

    public function getIotDevices($clubId = null) {
        if ($clubId) {
            return $this->findAll("SELECT * FROM iot_devices WHERE club_id = ? ORDER BY name", [$clubId]);
        }
        return $this->findAll("SELECT d.*, c.name as club_name FROM iot_devices d LEFT JOIN clubs c ON d.club_id = c.id ORDER BY d.name");
    }

    public function addIotDevice($data) {
        $sql = "INSERT INTO iot_devices (club_id, name, device_type, ip_address, api_url, username, password) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['club_id'] ?: null, $data['name'], $data['device_type'] ?? 'generic',
            $data['ip_address'] ?? null, $data['api_url'] ?? null,
            $data['username'] ?? '', $data['password'] ?? ''
        ]);
        return $this->lastInsertId();
    }

    public function updateIotDevice($id, $data) {
        $fields = []; $params = [];
        foreach ($data as $k => $v) { $fields[] = "$k = ?"; $params[] = $v; }
        $params[] = $id;
        return $this->execute("UPDATE iot_devices SET " . implode(', ', $fields) . " WHERE id = ?", $params);
    }

    public function deleteIotDevice($id) {
        return $this->execute("DELETE FROM iot_devices WHERE id = ?", [$id]);
    }

    public function getLogs($page = 1, $perPage = 50) {
        $perPage = max(1, (int)$perPage);
        $offset  = max(0, ((int)$page - 1) * $perPage);
        return $this->findAll(
            "SELECT * FROM action_logs ORDER BY created_at DESC LIMIT $perPage OFFSET $offset"
        );
    }

    public function getErrorLogs($page = 1, $perPage = 50) {
        $perPage = max(1, (int)$perPage);
        $offset  = max(0, ((int)$page - 1) * $perPage);
        return $this->findAll("SELECT * FROM error_logs ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    }

    public function logAction($userId, $action) {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $name = $_SESSION['user_name'] ?? null;
        $this->execute(
            "INSERT INTO action_logs (user_id, user_name, action, ip_address) VALUES (?, ?, ?, ?)",
            [$userId, $name, $action, $ip]
        );
    }

    public function clearLogs() {
        $this->execute("DELETE FROM action_logs");
    }

    public function clearErrors() {
        $this->execute("DELETE FROM error_logs");
    }
}
