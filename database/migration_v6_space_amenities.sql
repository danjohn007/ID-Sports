-- ============================================================
-- ID Sports — Migration v6: space_amenities pivot table
-- Allows admin to assign specific amenities to a space.
-- MySQL 5.7+ compatible
-- ============================================================

SET NAMES utf8mb4;

CREATE TABLE IF NOT EXISTS `space_amenities` (
  `space_id`   INT UNSIGNED NOT NULL,
  `amenity_id` INT UNSIGNED NOT NULL,
  PRIMARY KEY (`space_id`, `amenity_id`),
  CONSTRAINT `fk_sa_space`   FOREIGN KEY (`space_id`)   REFERENCES `spaces`    (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_sa_amenity` FOREIGN KEY (`amenity_id`) REFERENCES `amenities` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4
  COMMENT='Pivot: which amenities are available for each space';

-- NOTE: No automatic back-fill. Admins assign amenities to specific spaces
-- via the admin panel (Admin > Canchas > Gestionar Amenidades).
-- Running the v8 migration will clear any previously back-filled rows.
