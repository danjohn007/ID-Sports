<?php
class IncidentModel extends Model {
    public function findByClub($clubId, $status = null) {
        $sql = "SELECT i.*, s.name as space_name
                FROM incidents i
                LEFT JOIN spaces s ON i.space_id = s.id
                WHERE i.club_id = ?";
        $params = [$clubId];
        if ($status) { $sql .= " AND i.status = ?"; $params[] = $status; }
        $sql .= " ORDER BY i.created_at DESC";
        return $this->findAll($sql, $params);
    }

    public function findById($id) {
        return $this->findOne("SELECT * FROM incidents WHERE id = ?", [$id]);
    }

    public function create($data) {
        $sql = "INSERT INTO incidents (club_id, space_id, reported_by, type, description) VALUES (?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['club_id'], $data['space_id'] ?? null,
            $data['reported_by'] ?? null, $data['type'] ?? 'other',
            $data['description']
        ]);
        return $this->lastInsertId();
    }

    public function updateStatus($id, $status) {
        $resolvedAt = $status === 'resolved' ? date('Y-m-d H:i:s') : null;
        return $this->execute(
            "UPDATE incidents SET status = ?, resolved_at = ? WHERE id = ?",
            [$status, $resolvedAt, $id]
        );
    }

    public function countByClub($clubId, $status = 'open') {
        $row = $this->findOne(
            "SELECT COUNT(*) as cnt FROM incidents WHERE club_id = ? AND status = ?",
            [$clubId, $status]
        );
        return $row['cnt'] ?? 0;
    }
}
