-- Migration v9: Refund/cancellation flow
-- Run once: adds refund_pending status + cancel_reason column

-- 1. Extend status ENUM
ALTER TABLE `reservations`
  MODIFY COLUMN `status`
  ENUM('active','confirmed','completed','cancelled','in_progress','pending','refund_pending')
  NOT NULL DEFAULT 'active';

-- 2. Add cancel_reason column (safe – ignored if already present)
ALTER TABLE `reservations`
  ADD COLUMN `cancel_reason` TEXT DEFAULT NULL AFTER `notes`;
