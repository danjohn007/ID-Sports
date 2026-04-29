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
            // If no schedule record, the space is closed that day
            return [];
        }
        $reserved = $this->getReservedSlots($spaceId, $date);
        $openMinutes  = $this->timeToMinutes($schedule['open_time']);
        $closeMinutes = $this->timeToMinutes($schedule['close_time']);
        $slots = [];
        // Generate 30-minute slots
        for ($m = $openMinutes; $m < $closeMinutes; $m += 30) {
            $slotStart = $this->minutesToTime($m);
            $slotEnd   = $this->minutesToTime($m + 30);
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

    /** Returns day-of-week integers (0=Sun…6=Sat) where the space is closed */
    public function getClosedDays($spaceId) {
        $allDays = [0,1,2,3,4,5,6];
        $open = $this->findAll(
            "SELECT day_of_week FROM schedules WHERE space_id = ? AND is_open = 1",
            [$spaceId]
        );
        $openDays = array_column($open, 'day_of_week');
        $closed = [];
        foreach ($allDays as $d) {
            if (!in_array((string)$d, array_map('strval', $openDays))) {
                $closed[] = $d;
            }
        }
        return $closed;
    }

    private function timeToMinutes($time) {
        if (!is_string($time) || strpos($time, ':') === false) return 0;
        list($h, $m) = array_map('intval', explode(':', $time));
        return $h * 60 + $m;
    }

    private function minutesToTime($minutes) {
        return sprintf('%02d:%02d', intdiv($minutes, 60), $minutes % 60);
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
