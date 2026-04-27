<?php
class SpaceModel extends Model {
    public function findByClub($clubId) {
        return $this->findAll("SELECT * FROM spaces WHERE club_id = ? AND status = 'active' ORDER BY name", [$clubId]);
    }

    public function findById($id) {
        return $this->findOne(
            "SELECT s.*, c.name as club_name, c.address as club_address, c.city as club_city FROM spaces s LEFT JOIN clubs c ON s.club_id = c.id WHERE s.id = ?",
            [$id]
        );
    }

    public function search($query = '', $sportType = '') {
        $sql = "SELECT s.*, c.name as club_name, c.address, c.city,
                    AVG(r.rating) as avg_rating, COUNT(r.id) as review_count
                FROM spaces s
                LEFT JOIN clubs c ON s.club_id = c.id
                LEFT JOIN reviews r ON r.space_id = s.id
                WHERE s.status = 'active' AND c.status = 'active'";
        $params = [];
        if ($query) {
            $sql .= " AND (s.name LIKE ? OR s.sport_type LIKE ? OR c.name LIKE ? OR c.city LIKE ?)";
            $params = array_merge($params, ["%$query%", "%$query%", "%$query%", "%$query%"]);
        }
        if ($sportType) {
            $sql .= " AND s.sport_type = ?";
            $params[] = $sportType;
        }
        $sql .= " GROUP BY s.id ORDER BY avg_rating DESC, s.name";
        return $this->findAll($sql, $params);
    }

    public function create($data) {
        $sql = "INSERT INTO spaces (club_id, name, sport_type, description, capacity, price_per_hour, status) VALUES (?, ?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['club_id'], $data['name'], $data['sport_type'],
            $data['description'] ?? '', $data['capacity'] ?? 2,
            $data['price_per_hour'], $data['status'] ?? 'active'
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
        return $this->execute("UPDATE spaces SET " . implode(', ', $fields) . " WHERE id = ?", $params);
    }

    public function delete($id) {
        return $this->execute("UPDATE spaces SET status = 'inactive' WHERE id = ?", [$id]);
    }

    public function getSchedules($spaceId) {
        return $this->findAll("SELECT * FROM schedules WHERE space_id = ? ORDER BY day_of_week", [$spaceId]);
    }

    public function getReservedSlots($spaceId, $date) {
        return $this->findAll(
            "SELECT start_time, end_time FROM reservations WHERE space_id = ? AND date = ? AND status = 'active'",
            [$spaceId, $date]
        );
    }
}
