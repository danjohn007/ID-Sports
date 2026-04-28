<?php
class SportTypeModel extends Model {
    /** All active sport types ordered by sort_order (for user-facing views) */
    public function getAll() {
        return $this->findAll(
            "SELECT * FROM sport_types WHERE is_active = 1 ORDER BY sort_order ASC, name ASC"
        );
    }

    /** All sport types including inactive (for admin management) */
    public function getAllForAdmin() {
        return $this->findAll(
            "SELECT * FROM sport_types ORDER BY sort_order ASC, name ASC"
        );
    }

    /** Single sport type by slug */
    public function getBySlug($slug) {
        return $this->findOne("SELECT * FROM sport_types WHERE slug = ?", [$slug]);
    }

    /** Insert or update a sport type */
    public function save(array $data) {
        static $allowed = ['name', 'slug', 'color_from', 'color_to', 'sort_order', 'is_active'];

        if (!empty($data['id'])) {
            $id = (int)$data['id'];
            unset($data['id']);
            $fields = []; $params = [];
            foreach ($data as $k => $v) {
                if (!in_array($k, $allowed, true)) continue;
                $fields[] = "`$k` = ?";
                $params[] = $v;
            }
            if (empty($fields)) return $id;
            $params[] = $id;
            $this->execute("UPDATE sport_types SET " . implode(', ', $fields) . " WHERE id = ?", $params);
            return $id;
        }
        $this->execute(
            "INSERT INTO sport_types (slug, name, color_from, color_to, sort_order, is_active)
             VALUES (?, ?, ?, ?, ?, ?)",
            [$data['slug'], $data['name'], $data['color_from'] ?? '#10b981',
             $data['color_to'] ?? '#059669', $data['sort_order'] ?? 0, 1]
        );
        return $this->lastInsertId();
    }

    /** Update image_path for a sport */
    public function setImage($id, $path) {
        $this->execute("UPDATE sport_types SET image_path = ? WHERE id = ?", [$path, $id]);
    }

    /** Toggle active status */
    public function toggle($id) {
        $this->execute("UPDATE sport_types SET is_active = 1 - is_active WHERE id = ?", [$id]);
    }

    /** Delete by id */
    public function delete($id) {
        $this->execute("DELETE FROM sport_types WHERE id = ?", [$id]);
    }

    /**
     * Returns an associative map [slug => [name, color_from, color_to, image_path]]
     * suitable for rendering sport cards.
     */
    public function getMap() {
        $rows = $this->getAll();
        $map = [];
        foreach ($rows as $row) {
            $map[$row['slug']] = $row;
        }
        return $map;
    }
}
