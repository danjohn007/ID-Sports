<?php
class IncidentModel extends Model {
    public function findByClub($clubId, $status = null) {
        $sql = "SELECT i.*, u.name as user_name, s.name as space_name
                FROM incidents i
                LEFT JOIN users u ON i.user_id = u.id
                LEFT JOIN spaces s ON i.space_id = s.id
                WHERE s.club_id = ?";
        $params = [$clubId];
        if ($status) { $sql .= " AND i.status = ?"; $params[] = $status; }
        $sql .= " ORDER BY i.created_at DESC";
        return $this->findAll($sql, $params);
    }

    public function findById($id) {
        return $this->findOne("SELECT * FROM incidents WHERE id = ?", [$id]);
    }

    public function create($data) {
        $sql = "INSERT INTO incidents (user_id, space_id, reservation_id, type, description) VALUES (?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['user_id'] ?? null, $data['space_id'],
            $data['reservation_id'] ?? null,
            $data['type'] ?? 'other', $data['description']
        ]);
        return $this->lastInsertId();
    }

    public function updateStatus($id, $status) {
        return $this->execute("UPDATE incidents SET status = ? WHERE id = ?", [$status, $id]);
    }

    public function countByClub($clubId, $status = 'open') {
        $row = $this->findOne(
            "SELECT COUNT(*) as cnt FROM incidents i JOIN spaces s ON i.space_id = s.id WHERE s.club_id = ? AND i.status = ?",
            [$clubId, $status]
        );
        return $row['cnt'] ?? 0;
    }
}
