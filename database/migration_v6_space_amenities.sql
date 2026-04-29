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

-- Back-fill: link every existing amenity to every space that shares the same club
-- (safe default — admins can prune via admin UI later)
INSERT IGNORE INTO `space_amenities` (`space_id`, `amenity_id`)
SELECT s.id, a.id
FROM spaces s
JOIN amenities a ON a.club_id = s.club_id
WHERE a.status = 'active';
