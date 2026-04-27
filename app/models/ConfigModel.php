<?php
class ConfigModel extends Model {
    public function get($key, $default = null) {
        $row = $this->findOne("SELECT config_value FROM config WHERE config_key = ?", [$key]);
        return $row ? $row['config_value'] : $default;
    }

    public function set($key, $value, $group = 'general') {
        $existing = $this->findOne("SELECT id FROM config WHERE config_key = ?", [$key]);
        if ($existing) {
            $this->execute("UPDATE config SET config_value = ?, config_group = ? WHERE config_key = ?", [$value, $group, $key]);
        } else {
            $this->execute("INSERT INTO config (config_key, config_value, config_group) VALUES (?, ?, ?)", [$key, $value, $group]);
        }
    }

    public function getGroup($group) {
        $rows = $this->findAll("SELECT config_key, config_value FROM config WHERE config_group = ?", [$group]);
        $result = [];
        foreach ($rows as $row) {
            $result[$row['config_key']] = $row['config_value'];
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
        $sql = "INSERT INTO iot_devices (club_id, name, device_type, ip_address, port, username, password, channel) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['club_id'], $data['name'], $data['device_type'],
            $data['ip_address'], $data['port'] ?? 80,
            $data['username'] ?? '', $data['password'] ?? '', $data['channel'] ?? 1
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
        $offset = ($page - 1) * $perPage;
        return $this->findAll(
            "SELECT l.*, u.name as user_name FROM action_logs l LEFT JOIN users u ON l.user_id = u.id ORDER BY l.created_at DESC LIMIT $perPage OFFSET $offset"
        );
    }

    public function getErrorLogs($page = 1, $perPage = 50) {
        $offset = ($page - 1) * $perPage;
        return $this->findAll("SELECT * FROM error_logs ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    }

    public function logAction($userId, $action, $description = '') {
        $ip = $_SERVER['REMOTE_ADDR'] ?? '';
        $ua = $_SERVER['HTTP_USER_AGENT'] ?? '';
        $this->execute(
            "INSERT INTO action_logs (user_id, action, description, ip_address, user_agent) VALUES (?, ?, ?, ?, ?)",
            [$userId, $action, $description, $ip, $ua]
        );
    }
}
