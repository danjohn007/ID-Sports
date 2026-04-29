-- ============================================================
-- ID Sports — Migration v4: sport_types master table
-- MySQL 5.7 compatible (no ADD COLUMN IF NOT EXISTS)
-- Safe to run multiple times
-- ============================================================

-- ── Create sport_types table ──────────────────────────────
CREATE TABLE IF NOT EXISTS sport_types (
    id          INT UNSIGNED NOT NULL AUTO_INCREMENT,
    slug        VARCHAR(64)  NOT NULL UNIQUE COMMENT 'Machine key, e.g. football',
    name        VARCHAR(120) NOT NULL          COMMENT 'Display name in Spanish',
    color_from  VARCHAR(7)   NOT NULL DEFAULT '#10b981' COMMENT 'Gradient start hex',
    color_to    VARCHAR(7)   NOT NULL DEFAULT '#059669' COMMENT 'Gradient end hex',
    image_path  VARCHAR(255) DEFAULT NULL      COMMENT 'Path to uploaded PNG icon',
    sort_order  SMALLINT     NOT NULL DEFAULT 0,
    is_active   TINYINT(1)   NOT NULL DEFAULT 1,
    created_at  TIMESTAMP    NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- ── Seed master sport list (INSERT IGNORE = idempotent) ───
INSERT IGNORE INTO sport_types (slug, name, color_from, color_to, sort_order) VALUES
  ('football',        'Fútbol',             '#10b981', '#059669',  1),
  ('football_sala',   'Fútbol Sala',        '#16a34a', '#15803d',  2),
  ('futbol_7',        'Fútbol 7',           '#22c55e', '#16a34a',  3),
  ('futbol_rapido',   'Fútbol Rápido',      '#4ade80', '#22c55e',  4),
  ('padel',           'Pádel',              '#3b82f6', '#1d4ed8',  5),
  ('tennis',          'Tenis',              '#f59e0b', '#d97706',  6),
  ('basketball',      'Basketball',         '#f97316', '#ea580c',  7),
  ('volleyball',      'Voleibol',           '#8b5cf6', '#7c3aed',  8),
  ('swimming',        'Natación',           '#06b6d4', '#0891b2',  9),
  ('baseball',        'Béisbol',            '#ef4444', '#dc2626', 10),
  ('softbol',         'Softbol',            '#f87171', '#ef4444', 11),
  ('squash',          'Squash',             '#a78bfa', '#7c3aed', 12),
  ('badminton',       'Badminton',          '#fb923c', '#f97316', 13),
  ('rugby',           'Rugby',              '#84cc16', '#65a30d', 14),
  ('handball',        'Handball',           '#e879f9', '#c026d3', 15),
  ('gym',             'Gimnasio',           '#64748b', '#475569', 16),
  ('yoga',            'Yoga / Pilates',     '#ec4899', '#db2777', 17),
  ('crossfit',        'CrossFit',           '#dc2626', '#b91c1c', 18),
  ('cycling',         'Ciclismo Indoor',    '#0ea5e9', '#0284c7', 19),
  ('other',           'Otro',               '#94a3b8', '#64748b', 99);

-- ── config table: store secondary gradient color ──────────
-- (uses INFORMATION_SCHEMA pattern for MySQL 5.7 compatibility)
SET @exist_secondary = (
    SELECT COUNT(*)
    FROM INFORMATION_SCHEMA.COLUMNS
    WHERE TABLE_SCHEMA = DATABASE()
      AND TABLE_NAME   = 'config'
      AND COLUMN_NAME  = 'id'
);
-- No schema change needed — color_secondary is stored as a row in the
-- existing config table via ConfigController, no ALTER required.
