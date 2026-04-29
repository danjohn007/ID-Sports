<?php
class NotificationModel extends Model {
    public function getForUser($userId, $limit = 20) {
        $limit = max(1, min(100, (int)$limit));
        return $this->findAll(
            "SELECT * FROM notifications WHERE user_id = ? ORDER BY created_at DESC LIMIT $limit",
            [$userId]
        );
    }

    public function countUnread($userId) {
        $row = $this->findOne(
            "SELECT COUNT(*) as cnt FROM notifications WHERE user_id = ? AND is_read = 0",
            [$userId]
        );
        return $row['cnt'] ?? 0;
    }

    public function markAllRead($userId) {
        return $this->execute(
            "UPDATE notifications SET is_read = 1 WHERE user_id = ?",
            [$userId]
        );
    }

    public function markRead($id, $userId) {
        return $this->execute(
            "UPDATE notifications SET is_read = 1 WHERE id = ? AND user_id = ?",
            [$id, $userId]
        );
    }

    public function create($userId, $title, $body, $type = 'system', $refId = null) {
        return $this->execute(
            "INSERT INTO notifications (user_id, title, body, type, ref_id) VALUES (?, ?, ?, ?, ?)",
            [$userId, $title, $body, $type, $refId]
        );
    }
}
