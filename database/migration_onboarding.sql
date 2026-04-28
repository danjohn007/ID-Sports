-- ============================================================
-- ID Sports — Migration: Onboarding + User Location
-- MySQL 5.7+
-- ============================================================

-- Add state (location) column to users table (non-invasive / optional)
ALTER TABLE `users`
    ADD COLUMN IF NOT EXISTS `state` VARCHAR(100) DEFAULT NULL AFTER `whatsapp`;

-- Seed default onboarding config keys (only if they don't exist yet)
INSERT IGNORE INTO `config` (`cfg_key`, `cfg_value`) VALUES
    ('onboarding_slide1_title', 'Encuentra tu cancha ideal'),
    ('onboarding_slide1_desc',  'Busca y reserva espacios deportivos cerca de ti, en tiempo real.'),
    ('onboarding_slide1_image', ''),
    ('onboarding_slide2_title', 'Reserva y accede sin filas'),
    ('onboarding_slide2_desc',  'Tu código QR te da acceso inmediato a la cancha reservada.'),
    ('onboarding_slide2_image', ''),
    ('onboarding_slide3_title', 'Juega con la comunidad'),
    ('onboarding_slide3_desc',  'Conecta con deportistas de tu ciudad y forma tu equipo.'),
    ('onboarding_slide3_image', ''),
    ('auth_bg_image',           '');
