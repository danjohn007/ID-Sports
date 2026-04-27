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
        $offset = ($page - 1) * $perPage;
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
        $qrData = 'RES-' . uniqid();
        $sql = "INSERT INTO reservations (user_id, space_id, date, start_time, end_time, num_people, subtotal, service_fee, amenities_total, discount, total, payment_method, payment_status, qr_code, notes) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['user_id'], $data['space_id'], $data['date'],
            $data['start_time'], $data['end_time'], $data['num_people'] ?? 1,
            $data['subtotal'], $data['service_fee'] ?? 0,
            $data['amenities_total'] ?? 0, $data['discount'] ?? 0,
            $data['total'], $data['payment_method'] ?? 'pending',
            $data['payment_status'] ?? 'pending', $qrData,
            $data['notes'] ?? ''
        ]);
        return $this->lastInsertId();
    }

    public function updateStatus($id, $status) {
        return $this->execute("UPDATE reservations SET status = ? WHERE id = ?", [$status, $id]);
    }

    public function updatePaymentStatus($id, $status) {
        return $this->execute("UPDATE reservations SET payment_status = ? WHERE id = ?", [$status, $id]);
    }

    public function getMonthlyStats($userId) {
        return $this->findAll(
            "SELECT DATE_FORMAT(date, '%Y-%m') as month, SUM(total) as total, COUNT(*) as count
             FROM reservations WHERE user_id = ? AND status != 'cancelled'
             GROUP BY month ORDER BY month DESC LIMIT 12",
            [$userId]
        );
    }

    public function getTodayForClub($clubId) {
        return $this->findAll(
            "SELECT r.*, s.name as space_name, u.name as user_name
             FROM reservations r
             LEFT JOIN spaces s ON r.space_id = s.id
             LEFT JOIN users u ON r.user_id = u.id
             WHERE s.club_id = ? AND r.date = CURDATE() AND r.status = 'active'
             ORDER BY r.start_time",
            [$clubId]
        );
    }

    public function getSystemStats() {
        return [
            'total' => $this->findOne("SELECT COUNT(*) as cnt FROM reservations")['cnt'] ?? 0,
            'today' => $this->findOne("SELECT COUNT(*) as cnt FROM reservations WHERE date = CURDATE()")['cnt'] ?? 0,
            'revenue' => $this->findOne("SELECT SUM(total) as total FROM reservations WHERE payment_status = 'paid'")['total'] ?? 0,
            'monthly_revenue' => $this->findAll("SELECT DATE_FORMAT(date,'%Y-%m') as month, SUM(total) as total FROM reservations WHERE payment_status='paid' GROUP BY month ORDER BY month DESC LIMIT 6"),
        ];
    }

    public function countByClub($clubId) {
        $row = $this->findOne("SELECT COUNT(*) as cnt FROM reservations r JOIN spaces s ON r.space_id = s.id WHERE s.club_id = ?", [$clubId]);
        return $row['cnt'] ?? 0;
    }

    public function revenueByClub($clubId) {
        $row = $this->findOne("SELECT SUM(r.total) as total FROM reservations r JOIN spaces s ON r.space_id = s.id WHERE s.club_id = ? AND r.payment_status = 'paid'", [$clubId]);
        return $row['total'] ?? 0;
    }
}
