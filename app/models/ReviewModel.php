<?php
class ReviewModel extends Model {
    public function findBySpace($spaceId) {
        return $this->findAll(
            "SELECT r.*, u.name as user_name FROM reviews r LEFT JOIN users u ON r.user_id = u.id WHERE r.space_id = ? ORDER BY r.created_at DESC",
            [$spaceId]
        );
    }

    public function create($data) {
        $sql = "INSERT INTO reviews (user_id, reservation_id, space_id, rating, comment) VALUES (?, ?, ?, ?, ?)";
        $this->execute($sql, [$data['user_id'], $data['reservation_id'], $data['space_id'], $data['rating'], $data['comment']]);
        return $this->lastInsertId();
    }

    public function getAvgRating($spaceId) {
        $row = $this->findOne("SELECT AVG(rating) as avg FROM reviews WHERE space_id = ?", [$spaceId]);
        return round($row['avg'] ?? 0, 1);
    }
}
