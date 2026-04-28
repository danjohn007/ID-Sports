<?php
class ClubMembershipModel extends Model {
    public function getByUser($userId) {
        return $this->findAll(
            "SELECT cm.*, c.name as club_name, c.logo, c.cover_image, c.city
             FROM club_memberships cm
             LEFT JOIN clubs c ON cm.club_id = c.id
             WHERE cm.user_id = ? AND cm.status = 'active'
             ORDER BY cm.created_at DESC",
            [$userId]
        );
    }

    public function getClubIdsByUser($userId) {
        $rows = $this->findAll(
            "SELECT club_id FROM club_memberships WHERE user_id = ? AND status = 'active'",
            [$userId]
        );
        return array_column($rows, 'club_id');
    }

    public function isMember($userId, $clubId) {
        $row = $this->findOne(
            "SELECT id FROM club_memberships WHERE user_id = ? AND club_id = ? AND status = 'active'",
            [$userId, $clubId]
        );
        return $row !== null;
    }

    public function join($userId, $clubId) {
        $existing = $this->findOne(
            "SELECT id, status FROM club_memberships WHERE user_id = ? AND club_id = ?",
            [$userId, $clubId]
        );
        if ($existing) {
            return $this->execute(
                "UPDATE club_memberships SET status = 'active', updated_at = NOW() WHERE id = ?",
                [$existing['id']]
            );
        }
        return $this->execute(
            "INSERT INTO club_memberships (user_id, club_id, status) VALUES (?, ?, 'active')",
            [$userId, $clubId]
        );
    }

    public function leave($userId, $clubId) {
        return $this->execute(
            "UPDATE club_memberships SET status = 'cancelled', updated_at = NOW() WHERE user_id = ? AND club_id = ?",
            [$userId, $clubId]
        );
    }
}
