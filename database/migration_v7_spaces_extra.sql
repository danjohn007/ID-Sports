-- ============================================================
-- ID Sports — Migration v7: Extra columns for spaces
-- Adds surface_type, rules, max_duration_minutes to the spaces table.
-- MySQL 5.7+ compatible — run once on each environment.
-- ============================================================

SET NAMES utf8mb4;

-- surface_type: e.g. 'Sintético', 'Duela', 'Arcilla', 'Concreto'
ALTER TABLE `spaces`
  ADD COLUMN `surface_type`         VARCHAR(80) DEFAULT NULL         AFTER `description`;

-- rules: club/space rules shown to users before booking
ALTER TABLE `spaces`
  ADD COLUMN `rules`                TEXT        DEFAULT NULL         AFTER `surface_type`;

-- max_duration_minutes: maximum booking length allowed by the owner (default 4 hours = 240 min)
ALTER TABLE `spaces`
  ADD COLUMN `max_duration_minutes` INT         NOT NULL DEFAULT 240 AFTER `rules`;
