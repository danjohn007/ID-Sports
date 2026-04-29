-- ============================================================
-- ID Sports — Migration v8: clear incorrectly back-filled space_amenities
--
-- Migration v6 contained an INSERT that linked every club amenity to every
-- space in that club. This meant football amenities appeared on tennis courts
-- and vice-versa. This migration removes all those rows so that admins can
-- assign amenities per-space correctly via the admin panel.
--
-- Run ONCE on any environment where migration_v6 was already applied.
-- MySQL 5.7+ compatible
-- ============================================================

TRUNCATE TABLE `space_amenities`;
