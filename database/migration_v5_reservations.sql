-- ============================================================
-- ID Sports — Migration v5: Reservations status ENUM update
-- MySQL 5.7+ compatible
-- Adds 'pending' and 'in_progress' to the status column of reservations
-- ============================================================

SET NAMES utf8mb4;

-- Add 'pending' and 'in_progress' to reservations.status ENUM
ALTER TABLE `reservations`
  MODIFY COLUMN `status`
    ENUM('pending','active','confirmed','completed','cancelled','in_progress')
    NOT NULL DEFAULT 'pending';

-- Ensure reservation_amenities table exists with quantity column
CREATE TABLE IF NOT EXISTS `reservation_amenities` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` INT UNSIGNED NOT NULL,
  `amenity_id`     INT UNSIGNED NOT NULL,
  `quantity`       TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `price`          DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ra_res`     FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ra_amenity` FOREIGN KEY (`amenity_id`)     REFERENCES `amenities`    (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
