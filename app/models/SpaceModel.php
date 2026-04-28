<?php
class SpaceModel extends Model {
    public function findByClub($clubId) {
        return $this->findAll("SELECT * FROM spaces WHERE club_id = ? AND status = 'active' ORDER BY name", [$clubId]);
    }

    public function findById($id) {
        return $this->findOne(
            "SELECT s.*, s.club_id, c.name as club_name, c.address as club_address, c.city as club_city FROM spaces s LEFT JOIN clubs c ON s.club_id = c.id WHERE s.id = ?",
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

    public function getAvailableByDate($date, $sportType = '') {
        $dayOfWeek = (int)date('w', strtotime($date)); // 0=Sun..6=Sat
        $sql = "SELECT s.*, c.name as club_name, c.address, c.city,
                       c.latitude, c.longitude,
                       sch.open_time, sch.close_time
                FROM spaces s
                LEFT JOIN clubs c ON s.club_id = c.id
                LEFT JOIN schedules sch ON sch.space_id = s.id AND sch.day_of_week = ?
                WHERE s.status = 'active'
                  AND c.status = 'active'
                  AND (sch.is_open = 1 OR sch.id IS NULL)";
        $params = [$dayOfWeek];
        if ($sportType) {
            $sql .= " AND s.sport_type = ?";
            $params[] = $sportType;
        }
        $sql .= " ORDER BY s.price_per_hour ASC";
        return $this->findAll($sql, $params);
    }

    public function countAvailableByDate($date, $sportType = '') {
        $dayOfWeek = (int)date('w', strtotime($date));
        $sql = "SELECT COUNT(DISTINCT s.id) as cnt
                FROM spaces s
                LEFT JOIN clubs c ON s.club_id = c.id
                LEFT JOIN schedules sch ON sch.space_id = s.id AND sch.day_of_week = ?
                WHERE s.status = 'active'
                  AND c.status = 'active'
                  AND (sch.is_open = 1 OR sch.id IS NULL)";
        $params = [$dayOfWeek];
        if ($sportType) {
            $sql .= " AND s.sport_type = ?";
            $params[] = $sportType;
        }
        $row = $this->findOne($sql, $params);
        return $row['cnt'] ?? 0;
    }

    public function getAvailableSlots($spaceId, $date) {
        $dayOfWeek = (int)date('w', strtotime($date));
        $schedule = $this->findOne(
            "SELECT open_time, close_time FROM schedules WHERE space_id = ? AND day_of_week = ? AND is_open = 1",
            [$spaceId, $dayOfWeek]
        );
        if (!$schedule) {
            $schedule = ['open_time' => '07:00:00', 'close_time' => '22:00:00'];
        }
        $reserved = $this->getReservedSlots($spaceId, $date);
        $openHour  = (int)substr($schedule['open_time'], 0, 2);
        $closeHour = (int)substr($schedule['close_time'], 0, 2);
        $slots = [];
        for ($h = $openHour; $h < $closeHour; $h++) {
            $slotStart = sprintf('%02d:00', $h);
            $slotEnd   = sprintf('%02d:00', $h + 1);
            $busy = false;
            foreach ($reserved as $r) {
                $rs = substr($r['start_time'], 0, 5);
                $re = substr($r['end_time'], 0, 5);
                if ($slotStart < $re && $slotEnd > $rs) { $busy = true; break; }
            }
            $slots[] = ['time' => $slotStart, 'available' => !$busy];
        }
        return $slots;
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

    public function upsertSchedule($spaceId, $dayOfWeek, $openTime, $closeTime) {
        return $this->execute(
            "INSERT INTO schedules (space_id, day_of_week, open_time, close_time, is_open)
             VALUES (?, ?, ?, ?, 1)
             ON DUPLICATE KEY UPDATE open_time = VALUES(open_time), close_time = VALUES(close_time), is_open = 1",
            [$spaceId, $dayOfWeek, $openTime, $closeTime]
        );
    }

    public function getReservedSlots($spaceId, $date) {
        return $this->findAll(
            "SELECT start_time, end_time FROM reservations WHERE space_id = ? AND date = ? AND status IN ('confirmed','pending')",
            [$spaceId, $date]
        );
    }
}
