<?php
class AmenityModel extends Model {
    public function findBySpace($spaceId) {
        // Returns amenities assigned to this specific space via the pivot table.
        // Falls back to club-level amenities if none are assigned yet, or if the
        // space_amenities table does not exist (migration pending).
        try {
            $rows = $this->findAll(
                "SELECT a.* FROM amenities a
                 INNER JOIN space_amenities sa ON sa.amenity_id = a.id
                 WHERE sa.space_id = ? AND a.status = 'active'
                 ORDER BY a.name",
                [(int)$spaceId]
            );
            if (!empty($rows)) return $rows;
        } catch (\PDOException $e) {
            // space_amenities table may not exist yet (migration pending); fall back silently
            error_log('AmenityModel::findBySpace fallback — ' . $e->getMessage());
        }

        // Fallback: use club-level amenities (e.g. before migration or backfill runs)
        $space = $this->findOne("SELECT club_id FROM spaces WHERE id = ?", [(int)$spaceId]);
        if (!$space) return [];
        return $this->findByClub($space['club_id']);
    }

    public function findByClub($clubId) {
        return $this->findAll("SELECT * FROM amenities WHERE club_id = ? AND status = 'active' ORDER BY name", [$clubId]);
    }

    public function findById($id) {
        return $this->findOne("SELECT * FROM amenities WHERE id = ?", [$id]);
    }

    public function create($data) {
        $sql = "INSERT INTO amenities (club_id, name, description, price, stock) VALUES (?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['club_id'], $data['name'],
            $data['description'] ?? '', $data['price'] ?? 0.00, $data['stock'] ?? 0
        ]);
        return $this->lastInsertId();
    }

    public function update($id, $data) {
        $fields = []; $params = [];
        foreach ($data as $k => $v) { $fields[] = "$k = ?"; $params[] = $v; }
        $params[] = $id;
        return $this->execute("UPDATE amenities SET " . implode(', ', $fields) . " WHERE id = ?", $params);
    }

    public function decrementStock($id, $qty = 1) {
        return $this->execute(
            "UPDATE amenities SET stock = GREATEST(0, stock - ?) WHERE id = ?",
            [(int)$qty, $id]
        );
    }

    public function incrementStock($id, $qty = 1) {
        return $this->execute(
            "UPDATE amenities SET stock = stock + ? WHERE id = ?",
            [(int)$qty, $id]
        );
    }
}
