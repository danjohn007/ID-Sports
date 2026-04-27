<?php
class UserModel extends Model {
    public function findByEmail($email) {
        return $this->findOne("SELECT * FROM users WHERE email = ?", [$email]);
    }

    public function findById($id) {
        return $this->findOne("SELECT * FROM users WHERE id = ?", [$id]);
    }

    public function create($data) {
        $sql = "INSERT INTO users (name, email, password, whatsapp, birth_date, role) VALUES (?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['name'], $data['email'], $data['password'],
            $data['whatsapp'] ?? null, $data['birth_date'] ?? null, $data['role'] ?? 'user'
        ]);
        return $this->lastInsertId();
    }

    public function update($id, $data) {
        $fields = [];
        $params = [];
        foreach ($data as $key => $value) {
            $fields[] = "$key = ?";
            $params[] = $value;
        }
        $params[] = $id;
        $sql = "UPDATE users SET " . implode(', ', $fields) . " WHERE id = ?";
        return $this->execute($sql, $params);
    }

    public function createOtp($userId, $email, $code) {
        $expires = date('Y-m-d H:i:s', time() + OTP_EXPIRY);
        $this->execute("UPDATE otp_codes SET used = 1 WHERE email = ? AND used = 0", [$email]);
        $sql = "INSERT INTO otp_codes (user_id, email, code, expires_at) VALUES (?, ?, ?, ?)";
        $this->execute($sql, [$userId, $email, $code, $expires]);
    }

    public function verifyOtp($email, $code) {
        return $this->findOne(
            "SELECT * FROM otp_codes WHERE email = ? AND code = ? AND used = 0 AND expires_at > NOW() ORDER BY id DESC LIMIT 1",
            [$email, $code]
        );
    }

    public function markOtpUsed($id) {
        $this->execute("UPDATE otp_codes SET used = 1 WHERE id = ?", [$id]);
    }

    public function getAllUsers($page = 1, $perPage = 20) {
        $perPage = max(1, (int)$perPage);
        $offset  = max(0, ((int)$page - 1) * $perPage);
        return $this->findAll("SELECT * FROM users ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    }

    public function countUsers() {
        $row = $this->findOne("SELECT COUNT(*) as cnt FROM users");
        return $row['cnt'] ?? 0;
    }
}
