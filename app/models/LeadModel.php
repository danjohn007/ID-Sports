<?php
class LeadModel extends Model {
    public function findAll($page = 1, $perPage = 20) {
        $offset = ($page - 1) * $perPage;
        return parent::findAll("SELECT * FROM leads ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    }

    public function create($data) {
        $sql = "INSERT INTO leads (name, email, phone, business_name, message) VALUES (?, ?, ?, ?, ?)";
        $this->execute($sql, [$data['name'], $data['email'], $data['phone'] ?? '', $data['business_name'] ?? '', $data['message'] ?? '']);
        return $this->lastInsertId();
    }

    public function updateStatus($id, $status) {
        return $this->execute("UPDATE leads SET status = ? WHERE id = ?", [$status, $id]);
    }

    public function countByStatus($status) {
        $row = $this->findOne("SELECT COUNT(*) as cnt FROM leads WHERE status = ?", [$status]);
        return $row['cnt'] ?? 0;
    }
}
