-- ============================================================
-- ID Sports — Migration v3 (MySQL 5.7 compatible)
-- Replaces migration_home_v2.sql ADD COLUMN IF NOT EXISTS
-- which is NOT supported in MySQL 5.7 (MariaDB-only syntax).
-- Safe to run multiple times.
-- ============================================================

SET NAMES utf8mb4;

-- ------------------------------------------------------------
-- Add latitude to clubs (MySQL 5.7 compatible)
-- ------------------------------------------------------------
SET @col = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'clubs'
      AND COLUMN_NAME  = 'latitude'
);
SET @sql = IF(@col = 0,
    'ALTER TABLE `clubs` ADD COLUMN `latitude` DECIMAL(10,8) DEFAULT NULL',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- ------------------------------------------------------------
-- Add longitude to clubs (MySQL 5.7 compatible)
-- ------------------------------------------------------------
SET @col = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'clubs'
      AND COLUMN_NAME  = 'longitude'
);
SET @sql = IF(@col = 0,
    'ALTER TABLE `clubs` ADD COLUMN `longitude` DECIMAL(11,8) DEFAULT NULL',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Update sample clubs with Querétaro coordinates (safe: no-op if already set)
UPDATE `clubs` SET `latitude` = 20.5888, `longitude` = -100.3899 WHERE `id` = 1 AND (`latitude` IS NULL OR `latitude` = 0);
UPDATE `clubs` SET `latitude` = 20.6020, `longitude` = -100.4058 WHERE `id` = 2 AND (`latitude` IS NULL OR `latitude` = 0);
UPDATE `clubs` SET `latitude` = 20.5731, `longitude` = -100.3762 WHERE `id` = 3 AND (`latitude` IS NULL OR `latitude` = 0);

-- ------------------------------------------------------------
-- Add club_id to promotions (MySQL 5.7 compatible)
-- ------------------------------------------------------------
SET @col = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'promotions'
      AND COLUMN_NAME  = 'club_id'
);
SET @sql = IF(@col = 0,
    'ALTER TABLE `promotions` ADD COLUMN `club_id` INT UNSIGNED DEFAULT NULL',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- Add FK for promotions.club_id (skip if already present)
SET @fk = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.TABLE_CONSTRAINTS
    WHERE CONSTRAINT_SCHEMA = DATABASE()
      AND TABLE_NAME         = 'promotions'
      AND CONSTRAINT_NAME    = 'fk_promo_club'
);
SET @sql = IF(@fk = 0,
    'ALTER TABLE `promotions` ADD CONSTRAINT `fk_promo_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

-- ------------------------------------------------------------
-- NOTIFICATIONS table (bell icon RF2.1)
-- CREATE TABLE IF NOT EXISTS is supported in MySQL 5.7
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
-- CLUB MEMBERSHIPS / follows (RF2.5, social feed)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `club_memberships` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT UNSIGNED NOT NULL,
  `club_id`    INT UNSIGNED NOT NULL,
  `status`     ENUM('pending','active','rejected','cancelled') NOT NULL DEFAULT 'active',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_user_club` (`user_id`, `club_id`),
  CONSTRAINT `fk_cm_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_cm_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- USER GPS location session (for "Cerca de ti" RF2.6)
-- Stores the last known lat/lng per user to personalise club ordering
-- ------------------------------------------------------------
SET @col = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'users'
      AND COLUMN_NAME  = 'last_lat'
);
SET @sql = IF(@col = 0,
    'ALTER TABLE `users` ADD COLUMN `last_lat` DECIMAL(10,8) DEFAULT NULL',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;

SET @col = (
    SELECT COUNT(*) FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'users'
      AND COLUMN_NAME  = 'last_lng'
);
SET @sql = IF(@col = 0,
    'ALTER TABLE `users` ADD COLUMN `last_lng` DECIMAL(11,8) DEFAULT NULL',
    'SELECT 1'
);
PREPARE stmt FROM @sql; EXECUTE stmt; DEALLOCATE PREPARE stmt;
