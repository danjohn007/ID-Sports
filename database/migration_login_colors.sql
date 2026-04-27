-- =============================================================
-- Migration: Add login page color configuration keys
-- Compatible with MySQL 5.7
-- Run this on existing databases that already have the config table
-- =============================================================

INSERT IGNORE INTO `config` (`cfg_key`, `cfg_value`) VALUES
    ('color_login_button',  '#0EA5E9'),
    ('color_login_link',    '#0EA5E9'),
    ('color_login_logo_bg', '#0EA5E9');
