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
        $limit = max(1, min(50, (int)$limit));
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
                "SELECT c.*, COUNT(s.id) as space_count FROM clubs c LEFT JOIN spaces s ON s.club_id = c.id AND s.status = 'active' WHERE c.status = 'active' AND (c.name LIKE ? OR c.address LIKE ?) GROUP BY c.id ORDER BY c.name",
                ["%$search%", "%$search%"]
            );
        }
        return parent::findAll("SELECT c.*, COUNT(s.id) as space_count FROM clubs c LEFT JOIN spaces s ON s.club_id = c.id AND s.status = 'active' WHERE c.status = 'active' GROUP BY c.id ORDER BY c.name");
    }

    public function discoverClubs($search = '', $state = '', $city = '') {
        $conditions = ["c.status = 'active'"];
        $params = [];
        if ($search) {
            $conditions[] = "(c.name LIKE ? OR c.address LIKE ? OR c.city LIKE ?)";
            $params[] = "%$search%";
            $params[] = "%$search%";
            $params[] = "%$search%";
        }
        if ($state) {
            $conditions[] = "c.state = ?";
            $params[] = $state;
        }
        if ($city) {
            $conditions[] = "c.city = ?";
            $params[] = $city;
        }
        $where = implode(' AND ', $conditions);
        return parent::findAll(
            "SELECT c.*, COUNT(s.id) as space_count FROM clubs c LEFT JOIN spaces s ON s.club_id = c.id AND s.status = 'active' WHERE $where GROUP BY c.id ORDER BY c.name",
            $params
        );
    }

    public function getDistinctStates() {
        $rows = parent::findAll("SELECT DISTINCT state FROM clubs WHERE status = 'active' AND state IS NOT NULL AND state != '' ORDER BY state");
        return array_column($rows, 'state');
    }

    public function getDistinctCities($state = '') {
        if ($state) {
            $rows = parent::findAll("SELECT DISTINCT city FROM clubs WHERE status = 'active' AND state = ? AND city IS NOT NULL AND city != '' ORDER BY city", [$state]);
        } else {
            $rows = parent::findAll("SELECT DISTINCT city FROM clubs WHERE status = 'active' AND city IS NOT NULL AND city != '' ORDER BY city");
        }
        return array_column($rows, 'city');
    }
}
