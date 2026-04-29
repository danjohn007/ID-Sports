-- Migration v10: Reviews and Clubs Discover
-- Ensures clubs table has state and city columns, adds reservation_id to reviews

-- 1. Add state column to clubs (safe if already exists via schema.sql)
ALTER TABLE `clubs`
  ADD COLUMN IF NOT EXISTS `state` VARCHAR(100) DEFAULT NULL AFTER `city`;

-- 2. Add city column to clubs (already in schema.sql as 'city', alias for municipality)
ALTER TABLE `clubs`
  ADD COLUMN IF NOT EXISTS `city` VARCHAR(100) DEFAULT 'Querétaro' AFTER `address`;

-- 3. Ensure reservation_id exists in reviews table for deduplication
ALTER TABLE `reviews`
  ADD COLUMN IF NOT EXISTS `reservation_id` INT UNSIGNED DEFAULT NULL AFTER `user_id`;
