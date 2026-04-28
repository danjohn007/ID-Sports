<?php
class ClubModel extends Model {
    public function findAll($where = '', $params = [], $page = 1, $perPage = 20) {
        $perPage = max(1, (int)$perPage);
        $offset  = max(0, ((int)$page - 1) * $perPage);
        $sql = "SELECT c.*, u.name as owner_name FROM clubs c LEFT JOIN users u ON c.owner_id = u.id";
        if ($where) $sql .= " WHERE $where";
        $sql .= " ORDER BY c.created_at DESC LIMIT $perPage OFFSET $offset";
        return parent::findAll($sql, $params);
    }

    public function findById($id) {
        return $this->findOne(
            "SELECT c.*, u.name as owner_name FROM clubs c LEFT JOIN users u ON c.owner_id = u.id WHERE c.id = ?",
            [$id]
        );
    }

    public function findByOwnerId($ownerId) {
        return $this->findOne("SELECT * FROM clubs WHERE owner_id = ?", [$ownerId]);
    }

    public function create($data) {
        $sql = "INSERT INTO clubs (owner_id, name, description, address, whatsapp, commission_pct, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['owner_id'], $data['name'], $data['description'] ?? '',
            $data['address'] ?? '', $data['whatsapp'] ?? '',
            $data['commission_pct'] ?? 10.00,
            $data['status'] ?? 'pending'
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
        $sql = "UPDATE clubs SET " . implode(', ', $fields) . " WHERE id = ?";
        return $this->execute($sql, $params);
    }

    public function countByStatus($status = null) {
        if ($status) {
            $row = $this->findOne("SELECT COUNT(*) as cnt FROM clubs WHERE status = ?", [$status]);
        } else {
            $row = $this->findOne("SELECT COUNT(*) as cnt FROM clubs");
        }
        return $row['cnt'] ?? 0;
    }

    public function getNearby($lat = null, $lng = null, $limit = 6) {
        if ($lat && $lng) {
            // Distance formula compatible with MySQL 5.7
            return parent::findAll(
                "SELECT c.*,
                    ( 6371 * ACOS(
                        COS(RADIANS(?)) * COS(RADIANS(c.latitude)) *
                        COS(RADIANS(c.longitude) - RADIANS(?)) +
                        SIN(RADIANS(?)) * SIN(RADIANS(c.latitude))
                    )) AS distance_km
                 FROM clubs c
                 WHERE c.status = 'active'
                   AND c.latitude IS NOT NULL
                 HAVING distance_km < 50
                 ORDER BY distance_km ASC
                 LIMIT $limit",
                [$lat, $lng, $lat]
            );
        }
        return $this->getActiveClubs();
    }

    public function getActiveClubs($search = '') {
        if ($search) {
            return parent::findAll(
                "SELECT * FROM clubs WHERE status = 'active' AND (name LIKE ? OR address LIKE ?) ORDER BY name",
                ["%$search%", "%$search%"]
            );
        }
        return parent::findAll("SELECT * FROM clubs WHERE status = 'active' ORDER BY name");
    }
}
