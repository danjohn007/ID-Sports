<?php
class ReservationModel extends Model {
    public function findById($id) {
        return $this->findOne(
            "SELECT r.*, s.name as space_name, s.sport_type, c.name as club_name, c.address as club_address,
                    u.name as user_name, u.email as user_email
             FROM reservations r
             LEFT JOIN spaces s ON r.space_id = s.id
             LEFT JOIN clubs c ON s.club_id = c.id
             LEFT JOIN users u ON r.user_id = u.id
             WHERE r.id = ?",
            [$id]
        );
    }

    public function findByUser($userId, $status = null) {
        $sql = "SELECT r.*, s.name as space_name, s.sport_type, c.name as club_name
                FROM reservations r
                LEFT JOIN spaces s ON r.space_id = s.id
                LEFT JOIN clubs c ON s.club_id = c.id
                WHERE r.user_id = ?";
        $params = [$userId];
        if ($status) {
            $sql .= " AND r.status = ?";
            $params[] = $status;
        }
        $sql .= " ORDER BY r.date DESC, r.start_time DESC";
        return $this->findAll($sql, $params);
    }

    public function findByClub($clubId, $date = null, $status = null, $page = 1, $perPage = 20) {
        $perPage = max(1, (int)$perPage);
        $offset  = max(0, ((int)$page - 1) * $perPage);
        $sql = "SELECT r.*, s.name as space_name, u.name as user_name, u.email as user_email, u.whatsapp
                FROM reservations r
                LEFT JOIN spaces s ON r.space_id = s.id
                LEFT JOIN users u ON r.user_id = u.id
                WHERE s.club_id = ?";
        $params = [$clubId];
        if ($date) { $sql .= " AND r.date = ?"; $params[] = $date; }
        if ($status) { $sql .= " AND r.status = ?"; $params[] = $status; }
        $sql .= " ORDER BY r.date DESC, r.start_time DESC LIMIT $perPage OFFSET $offset";
        return $this->findAll($sql, $params);
    }

    public function create($data) {
        $sql = "INSERT INTO reservations (user_id, space_id, date, start_time, end_time, subtotal, service_fee, amenities_total, discount, total, coupon_code, notes, status, payment_ref) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['user_id'], $data['space_id'], $data['date'],
            $data['start_time'], $data['end_time'],
            $data['subtotal'] ?? $data['total'] ?? 0,
            $data['service_fee'] ?? 0,
            $data['amenities_total'] ?? 0,
            $data['discount'] ?? 0,
            $data['total'], $data['coupon_code'] ?? null,
            $data['notes'] ?? '', $data['status'] ?? 'pending',
            $data['payment_ref'] ?? null
        ]);
        return $this->lastInsertId();
    }

    public function updateQrCode($id, $qrCode) {
        return $this->execute(
            "UPDATE reservations SET qr_code = ?, status = 'confirmed' WHERE id = ?",
            [$qrCode, $id]
        );
    }

    public function updateStatus($id, $status) {
        return $this->execute("UPDATE reservations SET status = ? WHERE id = ?", [$status, $id]);
    }

    public function updatePaymentRef($id, $ref) {
        return $this->execute("UPDATE reservations SET payment_ref = ? WHERE id = ?", [$ref, $id]);
    }

    public function getMonthlyStats($userId) {
        return $this->findAll(
            "SELECT DATE_FORMAT(date, '%Y-%m') as month, SUM(total) as total, COUNT(*) as count
             FROM reservations WHERE user_id = ? AND status != 'cancelled'
             GROUP BY month ORDER BY month DESC LIMIT 12",
            [$userId]
        );
    }

    public function getActiveForUser($userId) {
        return $this->findAll(
            "SELECT r.*, s.name as space_name, s.sport_type, s.photo as space_photo,
                    c.name as club_name, c.id as club_id, c.address as club_address
             FROM reservations r
             LEFT JOIN spaces s ON r.space_id = s.id
             LEFT JOIN clubs c ON s.club_id = c.id
             WHERE r.user_id = ?
               AND r.status IN ('confirmed','active','pending','in_progress')
               AND (r.date > CURDATE()
                    OR (r.date = CURDATE() AND r.end_time >= CURTIME()))
             ORDER BY r.date ASC, r.start_time ASC",
            [$userId]
        );
    }

    public function getTodayForUser($userId) {
        return $this->findOne(
            "SELECT r.*, s.name as space_name, s.sport_type, c.name as club_name
             FROM reservations r
             LEFT JOIN spaces s ON r.space_id = s.id
             LEFT JOIN clubs c ON s.club_id = c.id
             WHERE r.user_id = ? AND r.date = CURDATE()
               AND r.status IN ('active','confirmed')
             ORDER BY r.start_time ASC
             LIMIT 1",
            [$userId]
        );
    }

    public function getTodayAllForUser($userId) {
        return $this->findAll(
            "SELECT r.*, s.name as space_name, s.sport_type, c.name as club_name
             FROM reservations r
             LEFT JOIN spaces s ON r.space_id = s.id
             LEFT JOIN clubs c ON s.club_id = c.id
             WHERE r.user_id = ? AND r.date = CURDATE()
               AND r.status IN ('active','confirmed','in_progress','pending')
             ORDER BY r.start_time ASC",
            [$userId]
        );
    }

    public function getTodayForClub($clubId) {
        return $this->findAll(
            "SELECT r.*, s.name as space_name, u.name as user_name
             FROM reservations r
             LEFT JOIN spaces s ON r.space_id = s.id
             LEFT JOIN users u ON r.user_id = u.id
             WHERE s.club_id = ? AND r.date = CURDATE() AND r.status IN ('confirmed','pending')
             ORDER BY r.start_time",
            [$clubId]
        );
    }

    public function getSystemStats() {
        return [
            'total'           => $this->findOne("SELECT COUNT(*) as cnt FROM reservations")['cnt'] ?? 0,
            'today'           => $this->findOne("SELECT COUNT(*) as cnt FROM reservations WHERE date = CURDATE()")['cnt'] ?? 0,
            'revenue'         => $this->findOne("SELECT SUM(total) as total FROM reservations WHERE status = 'confirmed'")['total'] ?? 0,
            'monthly_revenue' => $this->findAll("SELECT DATE_FORMAT(date,'%Y-%m') as month, SUM(total) as total FROM reservations WHERE status IN ('confirmed','completed') GROUP BY month ORDER BY month DESC LIMIT 6"),
        ];
    }

    public function saveAmenities($reservationId, array $amenities) {
        // $amenities = [ ['id' => X, 'qty' => Y, 'price' => Z], ... ]
        foreach ($amenities as $a) {
            $this->execute(
                "INSERT INTO reservation_amenities (reservation_id, amenity_id, quantity, price) VALUES (?, ?, ?, ?)",
                [(int)$reservationId, (int)$a['id'], (int)$a['qty'], (float)$a['price']]
            );
        }
    }

    public function getAmenities($reservationId) {
        return $this->findAll(
            "SELECT ra.*, a.name, a.photo FROM reservation_amenities ra
             JOIN amenities a ON ra.amenity_id = a.id
             WHERE ra.reservation_id = ?",
            [(int)$reservationId]
        );
    }

    public function checkIn($reservationId) {
        return $this->execute(
            "UPDATE reservations SET status = 'in_progress' WHERE id = ? AND status = 'confirmed'",
            [(int)$reservationId]
        );
    }

    public function findByQrCode($qrCode) {
        return $this->findOne(
            "SELECT r.*, s.name as space_name, s.sport_type, c.name as club_name, u.name as user_name
             FROM reservations r
             LEFT JOIN spaces s ON r.space_id = s.id
             LEFT JOIN clubs c ON s.club_id = c.id
             LEFT JOIN users u ON r.user_id = u.id
             WHERE r.qr_code = ?",
            [$qrCode]
        );
    }

    public function restoreAmenityStock($reservationId) {
        $amenities = $this->getAmenities($reservationId);
        if (empty($amenities)) return;
        $amenityModel = new AmenityModel();
        foreach ($amenities as $a) {
            $amenityModel->incrementStock($a['amenity_id'], $a['quantity']);
        }
    }

    /** Mark a reservation as completed and restore amenity stock */
    public function complete($reservationId) {
        $updated = $this->execute(
            "UPDATE reservations SET status = 'completed' WHERE id = ? AND status IN ('confirmed','in_progress')",
            [(int)$reservationId]
        );
        if ($updated) {
            $this->restoreAmenityStock($reservationId);
        }
        return $updated;
    }

    public function countByClub($clubId) {
        $row = $this->findOne("SELECT COUNT(*) as cnt FROM reservations r JOIN spaces s ON r.space_id = s.id WHERE s.club_id = ?", [$clubId]);
        return $row['cnt'] ?? 0;
    }

    public function revenueByClub($clubId) {
        $row = $this->findOne("SELECT SUM(r.total) as total FROM reservations r JOIN spaces s ON r.space_id = s.id WHERE s.club_id = ? AND r.status IN ('confirmed','completed')", [$clubId]);
        return $row['total'] ?? 0;
    }
}
