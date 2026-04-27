-- ============================================================
-- ID Sports — Database Schema
-- MySQL 5.7+ / MariaDB 10.3+
-- Querétaro, México
-- ============================================================

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ------------------------------------------------------------
-- USERS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `users` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`         VARCHAR(120) NOT NULL,
  `email`        VARCHAR(180) NOT NULL,
  `password`     VARCHAR(255) NOT NULL,
  `whatsapp`     VARCHAR(20)  DEFAULT NULL,
  `birth_date`   DATE         DEFAULT NULL,
  `role`         ENUM('user','club_admin','super_admin') NOT NULL DEFAULT 'user',
  `dark_mode`    TINYINT(1)   NOT NULL DEFAULT 0,
  `status`       ENUM('active','inactive','banned') NOT NULL DEFAULT 'active',
  `created_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_email` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- OTP CODES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `otp_codes` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT UNSIGNED NOT NULL,
  `code`       VARCHAR(10)  NOT NULL,
  `expires_at` DATETIME     NOT NULL,
  `used`       TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user_code` (`user_id`, `code`),
  CONSTRAINT `fk_otp_user` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- CLUBS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `clubs` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `owner_id`       INT UNSIGNED NOT NULL,
  `name`           VARCHAR(160) NOT NULL,
  `description`    TEXT         DEFAULT NULL,
  `address`        VARCHAR(255) DEFAULT NULL,
  `whatsapp`       VARCHAR(20)  DEFAULT NULL,
  `commission_pct` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
  `status`         ENUM('pending','active','suspended') NOT NULL DEFAULT 'pending',
  `created_at`     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_owner` (`owner_id`),
  CONSTRAINT `fk_club_owner` FOREIGN KEY (`owner_id`) REFERENCES `users` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- SPACES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `spaces` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `club_id`        INT UNSIGNED NOT NULL,
  `name`           VARCHAR(120) NOT NULL,
  `description`    TEXT         DEFAULT NULL,
  `sport_type`     ENUM('football','padel','tennis','basketball','volleyball','swimming','other') NOT NULL DEFAULT 'other',
  `capacity`       SMALLINT     DEFAULT NULL,
  `price_per_hour` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `status`         ENUM('active','inactive','maintenance') NOT NULL DEFAULT 'active',
  `created_at`     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_club` (`club_id`),
  CONSTRAINT `fk_space_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- SCHEDULES (per space, per day)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `schedules` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `space_id`       INT UNSIGNED NOT NULL,
  `day_of_week`    ENUM('monday','tuesday','wednesday','thursday','friday','saturday','sunday') NOT NULL,
  `open_time`      TIME NOT NULL DEFAULT '07:00:00',
  `close_time`     TIME NOT NULL DEFAULT '22:00:00',
  `price_override` DECIMAL(10,2) DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_space_day` (`space_id`, `day_of_week`),
  CONSTRAINT `fk_sched_space` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- AMENITIES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `amenities` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `club_id`    INT UNSIGNED NOT NULL,
  `name`       VARCHAR(120) NOT NULL,
  `deleted_at` DATETIME     DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_amenity_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- RESERVATIONS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservations` (
  `id`           INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`      INT UNSIGNED NOT NULL,
  `space_id`     INT UNSIGNED NOT NULL,
  `date`         DATE         NOT NULL,
  `start_time`   TIME         NOT NULL,
  `end_time`     TIME         NOT NULL,
  `subtotal`     DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `discount`     DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `total`        DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code`  VARCHAR(50)  DEFAULT NULL,
  `notes`        TEXT         DEFAULT NULL,
  `status`       ENUM('pending','confirmed','cancelled','completed') NOT NULL DEFAULT 'pending',
  `payment_ref`  VARCHAR(100) DEFAULT NULL,
  `created_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`   DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_space_date` (`space_id`, `date`),
  CONSTRAINT `fk_res_user`  FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`),
  CONSTRAINT `fk_res_space` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- REVIEWS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        INT UNSIGNED NOT NULL,
  `space_id`       INT UNSIGNED NOT NULL,
  `reservation_id` INT UNSIGNED DEFAULT NULL,
  `rating`         TINYINT      NOT NULL DEFAULT 5,
  `comment`        TEXT         DEFAULT NULL,
  `created_at`     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_rev_user`  FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`),
  CONSTRAINT `fk_rev_space` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- INCIDENTS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `incidents` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `club_id`     INT UNSIGNED NOT NULL,
  `space_id`    INT UNSIGNED DEFAULT NULL,
  `reported_by` INT UNSIGNED DEFAULT NULL,
  `type`        ENUM('maintenance','security','complaint','other') DEFAULT 'other',
  `description` TEXT NOT NULL,
  `status`      ENUM('open','in_progress','resolved') NOT NULL DEFAULT 'open',
  `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `resolved_at` DATETIME DEFAULT NULL,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_inc_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- PROMOTIONS / COUPONS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `promotions` (
  `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `club_id`          INT UNSIGNED DEFAULT NULL,
  `type`             ENUM('promotion','coupon') NOT NULL DEFAULT 'promotion',
  `title`            VARCHAR(160) NOT NULL,
  `description`      TEXT DEFAULT NULL,
  `discount_percent` DECIMAL(5,2) DEFAULT 0.00,
  `coupon_code`      VARCHAR(50)  DEFAULT NULL,
  `valid_from`       DATE DEFAULT NULL,
  `valid_until`      DATE DEFAULT NULL,
  `max_uses`         INT UNSIGNED DEFAULT NULL,
  `uses_count`       INT UNSIGNED NOT NULL DEFAULT 0,
  `active`           TINYINT(1)   NOT NULL DEFAULT 1,
  `created_at`       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_coupon_code` (`coupon_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- LEADS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `leads` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`       VARCHAR(120) NOT NULL,
  `email`      VARCHAR(180) DEFAULT NULL,
  `whatsapp`   VARCHAR(20)  DEFAULT NULL,
  `message`    TEXT         DEFAULT NULL,
  `status`     ENUM('new','contacted','converted','closed') NOT NULL DEFAULT 'new',
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- CONFIG (key-value store)
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `config` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `cfg_key`    VARCHAR(80)  NOT NULL,
  `cfg_value`  TEXT         DEFAULT NULL,
  `updated_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_key` (`cfg_key`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- IOT DEVICES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `iot_devices` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `club_id`     INT UNSIGNED DEFAULT NULL,
  `name`        VARCHAR(120) NOT NULL,
  `device_type` ENUM('hikvision','shelly','generic') NOT NULL DEFAULT 'generic',
  `ip_address`  VARCHAR(45)  DEFAULT NULL,
  `api_url`     VARCHAR(255) DEFAULT NULL,
  `username`    VARCHAR(80)  DEFAULT NULL,
  `password`    VARCHAR(255) DEFAULT NULL,
  `status`      ENUM('online','offline','unknown') NOT NULL DEFAULT 'unknown',
  `created_at`  DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_iot_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE SET NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- ACTION LOGS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `action_logs` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`    INT UNSIGNED DEFAULT NULL,
  `user_name`  VARCHAR(120) DEFAULT NULL,
  `action`     VARCHAR(255) NOT NULL,
  `ip_address` VARCHAR(45)  DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- ERROR LOGS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `error_logs` (
  `id`         INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `message`    TEXT NOT NULL,
  `file`       VARCHAR(255) DEFAULT NULL,
  `line`       INT UNSIGNED DEFAULT NULL,
  `trace`      TEXT         DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_created` (`created_at`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- SEED DATA — Querétaro, México
-- Passwords:
--   Admin1234 → $2y$10$QdNPmLNarhxDJSCBPtamWeD3rsFx8XGaeElkQm7fnQnT47BPCT9zu
--   User1234  → $2y$10$l6VEoo3/pPB1NxGoccKPOeEMSBhkweOALQwRMmG9MFPL4BW3LBsDy
-- ============================================================

INSERT INTO `users` (`name`, `email`, `password`, `whatsapp`, `role`, `status`) VALUES
('Super Admin', 'superadmin@idsports.mx', '$2y$10$QdNPmLNarhxDJSCBPtamWeD3rsFx8XGaeElkQm7fnQnT47BPCT9zu', '+524421000001', 'super_admin', 'active'),
('Carlos Ramírez', 'carlos@idsports.mx', '$2y$10$QdNPmLNarhxDJSCBPtamWeD3rsFx8XGaeElkQm7fnQnT47BPCT9zu', '+524421000002', 'club_admin', 'active'),
('Laura Torres', 'laura@idsports.mx', '$2y$10$QdNPmLNarhxDJSCBPtamWeD3rsFx8XGaeElkQm7fnQnT47BPCT9zu', '+524421000003', 'club_admin', 'active'),
('Ana González', 'ana@ejemplo.mx', '$2y$10$l6VEoo3/pPB1NxGoccKPOeEMSBhkweOALQwRMmG9MFPL4BW3LBsDy', '+524421111111', 'user', 'active'),
('Pedro Sánchez', 'pedro@ejemplo.mx', '$2y$10$l6VEoo3/pPB1NxGoccKPOeEMSBhkweOALQwRMmG9MFPL4BW3LBsDy', '+524422222222', 'user', 'active'),
('Sofía Herrera', 'sofia@ejemplo.mx', '$2y$10$l6VEoo3/pPB1NxGoccKPOeEMSBhkweOALQwRMmG9MFPL4BW3LBsDy', '+524423333333', 'user', 'active');

INSERT INTO `clubs` (`owner_id`, `name`, `description`, `address`, `whatsapp`, `commission_pct`, `status`) VALUES
(2, 'Complejo Deportivo Querétaro', 'El mejor complejo deportivo del centro de Querétaro con canchas de fútbol, pádel y más.', 'Av. Constituyentes 100, Centro, Querétaro, Qro.', '+524421000002', 10.00, 'active'),
(3, 'Club Deportivo Juriquilla', 'Club premium en la zona norte con instalaciones de alto nivel.', 'Blvd. Juriquilla 2500, Juriquilla, Querétaro, Qro.', '+524421000003', 12.00, 'active'),
(2, 'Arena Deportiva El Marqués', 'Canchas sintéticas y naturales en El Marqués.', 'Carretera 57 Km 5, El Marqués, Qro.', '+524421000005', 8.00, 'active');

INSERT INTO `spaces` (`club_id`, `name`, `description`, `sport_type`, `capacity`, `price_per_hour`, `status`) VALUES
-- Club 1
(1, 'Cancha de Fútbol 5 — A', 'Cancha de césped sintético, techada, iluminación LED.', 'football', 10, 350.00, 'active'),
(1, 'Cancha de Fútbol 5 — B', 'Cancha de césped natural, exterior.', 'football', 10, 280.00, 'active'),
(1, 'Cancha de Pádel 1', 'Cancha de pádel con cristal panorámico.', 'padel', 4, 200.00, 'active'),
(1, 'Cancha de Pádel 2', 'Cancha de pádel exterior cubierta.', 'padel', 4, 180.00, 'active'),
(1, 'Cancha de Tenis', 'Cancha de tenis con superficie dura.', 'tennis', 4, 250.00, 'active'),
-- Club 2
(2, 'Cancha de Fútbol 7', 'Cancha grande de fútbol 7 con pasto sintético.', 'football', 14, 450.00, 'active'),
(2, 'Pista de Básquetbol', 'Duela profesional, 3x3 y 5x5.', 'basketball', 10, 220.00, 'active'),
(2, 'Cancha de Voleibol', 'Cancha de voleibol interior.', 'volleyball', 12, 200.00, 'active'),
(2, 'Pádel Premium', 'Cancha de pádel cerrada con sistema de ventilación.', 'padel', 4, 260.00, 'active'),
-- Club 3
(3, 'Cancha Fútbol Rápido', 'Fútbol rápido 5x5 techado.', 'football', 10, 300.00, 'active'),
(3, 'Alberca Olímpica', 'Alberca de 25m con carriles individuales.', 'swimming', 30, 120.00, 'active');

INSERT INTO `schedules` (`space_id`, `day_of_week`, `open_time`, `close_time`, `price_override`) VALUES
(1,'monday','07:00','22:00',NULL),(1,'tuesday','07:00','22:00',NULL),(1,'wednesday','07:00','22:00',NULL),
(1,'thursday','07:00','22:00',NULL),(1,'friday','07:00','22:00',NULL),(1,'saturday','08:00','22:00',380.00),(1,'sunday','08:00','20:00',380.00),
(2,'monday','07:00','22:00',NULL),(2,'friday','07:00','22:00',NULL),(2,'saturday','08:00','22:00',320.00),(2,'sunday','08:00','20:00',320.00),
(3,'monday','07:00','22:00',NULL),(3,'tuesday','07:00','22:00',NULL),(3,'wednesday','07:00','22:00',NULL),
(3,'thursday','07:00','22:00',NULL),(3,'friday','07:00','22:00',NULL),(3,'saturday','08:00','22:00',220.00),(3,'sunday','08:00','20:00',220.00),
(6,'monday','07:00','22:00',NULL),(6,'tuesday','07:00','22:00',NULL),(6,'saturday','08:00','22:00',500.00),(6,'sunday','08:00','20:00',500.00);

INSERT INTO `amenities` (`club_id`, `name`) VALUES
(1,'Estacionamiento gratuito'),(1,'Regaderas'),(1,'Cafetería'),(1,'Iluminación nocturna'),(1,'Vestidores'),
(2,'Alberca'),(2,'Gimnasio'),(2,'Regaderas'),(2,'Cafetería'),(2,'Estacionamiento'),(2,'WiFi'),
(3,'Regaderas'),(3,'Estacionamiento'),(3,'Tienda de artículos deportivos');

INSERT INTO `promotions` (`type`, `title`, `description`, `discount_percent`, `coupon_code`, `valid_from`, `valid_until`, `active`) VALUES
('coupon', '¡Primera reservación con descuento!', 'Usa este código en tu primera reservación y obtén 20% de descuento.', 20.00, 'BIENVENIDO20', '2024-01-01', '2025-12-31', 1),
('promotion', 'Fines de semana en familia', 'Reserva cualquier cancha sábado o domingo y lleva a tus hijos gratis.', 15.00, NULL, '2024-06-01', '2025-06-30', 1),
('coupon', 'Verano Deportivo', 'Descuento especial de verano en todas las canchas.', 10.00, 'VERANO10', '2024-06-01', '2025-08-31', 1);

INSERT INTO `leads` (`name`, `email`, `whatsapp`, `message`, `status`) VALUES
('Roberto Mendoza', 'roberto@gmail.com', '+524424000001', 'Me interesa registrar mi club de pádel en la plataforma.', 'new'),
('Club Deportivo Las Águilas', 'info@aguilas.mx', '+524424000002', 'Tenemos 5 canchas de tenis y queremos digitalizarnos.', 'contacted'),
('María Luisa Vega', 'mlvega@correo.mx', '+524424000003', 'Tengo una alberca y quiero ofrecer clases de natación.', 'new');

INSERT INTO `config` (`cfg_key`, `cfg_value`) VALUES
('app_name', 'ID Sports'),
('app_description', 'Plataforma de reservaciones deportivas en Querétaro, México'),
('contact_email', 'contacto@idsports.mx'),
('contact_phone', '+52 442 100 0000'),
('address', 'Querétaro, Qro., México'),
('timezone', 'America/Mexico_City'),
('qr_enabled', '1'),
('qr_expiry_minutes', '30'),
('chatbot_enabled', '0'),
('color_primary', '#0EA5E9'),
('color_secondary', '#7C3AED');
