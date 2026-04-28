-- ============================================================
-- ID Sports — Migration: Home v2 (Module 2 & 3)
-- MySQL 5.7+ compatible
-- ============================================================

SET NAMES utf8mb4;

-- ------------------------------------------------------------
-- Add GPS coordinates to clubs (for "Cerca de ti" RF2.6)
-- ------------------------------------------------------------
ALTER TABLE `clubs`
    ADD COLUMN IF NOT EXISTS `latitude`  DECIMAL(10,8) DEFAULT NULL AFTER `state`,
    ADD COLUMN IF NOT EXISTS `longitude` DECIMAL(11,8) DEFAULT NULL AFTER `latitude`;

-- Update sample clubs with Querétaro coordinates
UPDATE `clubs` SET `latitude` = 20.5888, `longitude` = -100.3899 WHERE `id` = 1;
UPDATE `clubs` SET `latitude` = 20.6020, `longitude` = -100.4058 WHERE `id` = 2;
UPDATE `clubs` SET `latitude` = 20.5731, `longitude` = -100.3762 WHERE `id` = 3;

-- ------------------------------------------------------------
-- Add club_id to promotions (for social feed RF2.5)
-- ------------------------------------------------------------
ALTER TABLE `promotions`
    ADD COLUMN IF NOT EXISTS `club_id` INT UNSIGNED DEFAULT NULL AFTER `id`;

-- Avoid duplicate constraint
SET @fk_exists = (
    SELECT COUNT(*) FROM information_schema.TABLE_CONSTRAINTS
    WHERE CONSTRAINT_SCHEMA = DATABASE()
      AND TABLE_NAME = 'promotions'
      AND CONSTRAINT_NAME = 'fk_promo_club'
);
SET @sql = IF(@fk_exists = 0,
    'ALTER TABLE `promotions` ADD CONSTRAINT `fk_promo_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL',
    'SELECT 1');
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- ------------------------------------------------------------
-- NOTIFICATIONS table (for bell icon RF2.1)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `notifications` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT UNSIGNED NOT NULL,
  `title`      VARCHAR(160) NOT NULL,
  `body`       TEXT DEFAULT NULL,
  `type`       ENUM('reservation','club','system','promo') NOT NULL DEFAULT 'system',
  `ref_id`     INT UNSIGNED DEFAULT NULL,
  `is_read`    TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_read` (`user_id`, `is_read`),
  CONSTRAINT `fk_notif_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- CLUB MEMBERSHIPS (follows / social feed RF2.5)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `club_memberships` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT UNSIGNED NOT NULL,
  `club_id`    INT UNSIGNED NOT NULL,
  `status`     ENUM('pending','active','rejected','cancelled') NOT NULL DEFAULT 'pending',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_club` (`user_id`, `club_id`),
  CONSTRAINT `fk_cm_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cm_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- Sample notifications for demo user (id=3)
-- ------------------------------------------------------------
INSERT INTO `notifications` (`user_id`, `title`, `body`, `type`, `is_read`) VALUES
(3, '¡Reservación confirmada!', 'Tu cancha Fútbol 5 — A está lista para mañana a las 10:00.', 'reservation', 0),
(3, 'Promoción activa', 'Usa el cupón BIENVENIDO20 y obtén 20% en tu próxima reserva.', 'promo', 0),
(3, 'Club Pádel Santiago', 'Nueva cancha disponible: Pádel Premium C con precio de apertura.', 'club', 1);
