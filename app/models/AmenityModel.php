<?php
class AmenityModel extends Model {
    public function findByClub($clubId) {
        return $this->findAll("SELECT * FROM amenities WHERE club_id = ? AND deleted_at IS NULL ORDER BY name", [$clubId]);
    }

    public function findById($id) {
        return $this->findOne("SELECT * FROM amenities WHERE id = ?", [$id]);
    }

    public function create($data) {
        $sql = "INSERT INTO amenities (club_id, name) VALUES (?, ?)";
        $this->execute($sql, [$data['club_id'], $data['name']]);
        return $this->lastInsertId();
    }

    public function update($id, $data) {
        $fields = []; $params = [];
        foreach ($data as $k => $v) { $fields[] = "$k = ?"; $params[] = $v; }
        $params[] = $id;
        return $this->execute("UPDATE amenities SET " . implode(', ', $fields) . " WHERE id = ?", $params);
    }

    public function delete($id) {
        return $this->execute("UPDATE amenities SET deleted_at = NOW() WHERE id = ?", [$id]);
    }
}
