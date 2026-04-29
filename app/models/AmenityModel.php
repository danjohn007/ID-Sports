<?php
class AmenityModel extends Model {
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
