<?php
class PromotionModel extends Model {
    public function getActive() {
        return $this->findAll("SELECT * FROM promotions WHERE status = 'active' AND (valid_until IS NULL OR valid_until >= CURDATE()) ORDER BY created_at DESC");
    }

    public function findAll($page = 1, $perPage = 20) {
        $offset = ($page - 1) * $perPage;
        return parent::findAll("SELECT * FROM promotions ORDER BY created_at DESC LIMIT $perPage OFFSET $offset");
    }

    public function findById($id) {
        return $this->findOne("SELECT * FROM promotions WHERE id = ?", [$id]);
    }

    public function verifyCoupon($code) {
        return $this->findOne(
            "SELECT * FROM promotions WHERE coupon_code = ? AND status = 'active' AND (valid_until IS NULL OR valid_until >= CURDATE())",
            [$code]
        );
    }

    public function create($data) {
        $sql = "INSERT INTO promotions (title, description, type, discount_percent, coupon_code, valid_from, valid_until, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $this->execute($sql, [
            $data['title'], $data['description'] ?? '', $data['type'] ?? 'promotion',
            $data['discount_percent'] ?? 0, $data['coupon_code'] ?? null,
            $data['valid_from'] ?? null, $data['valid_until'] ?? null,
            $data['status'] ?? 'active'
        ]);
        return $this->lastInsertId();
    }

    public function update($id, $data) {
        $fields = []; $params = [];
        foreach ($data as $k => $v) { $fields[] = "$k = ?"; $params[] = $v; }
        $params[] = $id;
        return $this->execute("UPDATE promotions SET " . implode(', ', $fields) . " WHERE id = ?", $params);
    }

    public function delete($id) {
        return $this->execute("DELETE FROM promotions WHERE id = ?", [$id]);
    }
}

