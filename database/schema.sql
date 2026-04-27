-- ============================================================
-- ID Sports — Database Schema (Full Version)
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
  `avatar`       VARCHAR(255) DEFAULT NULL,
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
  `email`      VARCHAR(180) NOT NULL,
  `code`       VARCHAR(10)  NOT NULL,
  `expires_at` DATETIME     NOT NULL,
  `used`       TINYINT(1)   NOT NULL DEFAULT 0,
  `created_at` DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_email_code` (`email`, `code`),
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
  `city`           VARCHAR(100) DEFAULT 'Querétaro',
  `state`          VARCHAR(100) DEFAULT 'Querétaro',
  `phone`          VARCHAR(20)  DEFAULT NULL,
  `email`          VARCHAR(180) DEFAULT NULL,
  `website`        VARCHAR(255) DEFAULT NULL,
  `whatsapp`       VARCHAR(20)  DEFAULT NULL,
  `logo`           VARCHAR(255) DEFAULT NULL,
  `cover_image`    VARCHAR(255) DEFAULT NULL,
  `commission_pct` DECIMAL(5,2) NOT NULL DEFAULT 10.00,
  `status`         ENUM('pending','active','suspended','rejected') NOT NULL DEFAULT 'pending',
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
  `sport_type`     VARCHAR(80)  NOT NULL DEFAULT 'other',
  `capacity`       SMALLINT     DEFAULT 2,
  `price_per_hour` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `photo`          VARCHAR(255) DEFAULT NULL,
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
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `space_id`    INT UNSIGNED NOT NULL,
  `day_of_week` TINYINT UNSIGNED NOT NULL COMMENT '0=Sun,1=Mon,...,6=Sat',
  `open_time`   TIME NOT NULL DEFAULT '07:00:00',
  `close_time`  TIME NOT NULL DEFAULT '22:00:00',
  `is_open`     TINYINT(1) NOT NULL DEFAULT 1,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_space_day` (`space_id`, `day_of_week`),
  CONSTRAINT `fk_sched_space` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- AMENITIES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `amenities` (
  `id`          INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `club_id`     INT UNSIGNED NOT NULL,
  `name`        VARCHAR(120) NOT NULL,
  `description` TEXT         DEFAULT NULL,
  `price`       DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `stock`       INT           NOT NULL DEFAULT 0,
  `photo`       VARCHAR(255)  DEFAULT NULL,
  `status`      ENUM('active','inactive') NOT NULL DEFAULT 'active',
  PRIMARY KEY (`id`),
  KEY `idx_club` (`club_id`),
  CONSTRAINT `fk_amenity_club` FOREIGN KEY (`club_id`) REFERENCES `clubs` (`id`) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- RESERVATIONS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservations` (
  `id`              INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`         INT UNSIGNED NOT NULL,
  `space_id`        INT UNSIGNED NOT NULL,
  `date`            DATE         NOT NULL,
  `start_time`      TIME         NOT NULL,
  `end_time`        TIME         NOT NULL,
  `num_people`      TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `subtotal`        DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `service_fee`     DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `amenities_total` DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `discount`        DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `total`           DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  `coupon_code`     VARCHAR(50)  DEFAULT NULL,
  `payment_method`  VARCHAR(50)  DEFAULT 'pending',
  `payment_status`  ENUM('pending','paid','failed','refunded') NOT NULL DEFAULT 'pending',
  `qr_code`         VARCHAR(500) DEFAULT NULL,
  `notes`           TEXT         DEFAULT NULL,
  `status`          ENUM('active','confirmed','completed','cancelled') NOT NULL DEFAULT 'active',
  `payment_ref`     VARCHAR(100) DEFAULT NULL,
  `created_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  `updated_at`      DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  KEY `idx_user` (`user_id`),
  KEY `idx_space_date` (`space_id`, `date`),
  CONSTRAINT `fk_res_user`  FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`),
  CONSTRAINT `fk_res_space` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- RESERVATION AMENITIES
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reservation_amenities` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `reservation_id` INT UNSIGNED NOT NULL,
  `amenity_id`     INT UNSIGNED NOT NULL,
  `quantity`       TINYINT UNSIGNED NOT NULL DEFAULT 1,
  `price`          DECIMAL(10,2) NOT NULL DEFAULT 0.00,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_ra_res`     FOREIGN KEY (`reservation_id`) REFERENCES `reservations` (`id`) ON DELETE CASCADE,
  CONSTRAINT `fk_ra_amenity` FOREIGN KEY (`amenity_id`)     REFERENCES `amenities`    (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- REVIEWS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `reviews` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        INT UNSIGNED NOT NULL,
  `space_id`       INT UNSIGNED NOT NULL,
  `reservation_id` INT UNSIGNED DEFAULT NULL,
  `rating`         TINYINT UNSIGNED NOT NULL DEFAULT 5,
  `comment`        TEXT DEFAULT NULL,
  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_rev_user`  FOREIGN KEY (`user_id`)  REFERENCES `users`  (`id`),
  CONSTRAINT `fk_rev_space` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- INCIDENTS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `incidents` (
  `id`             INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `user_id`        INT UNSIGNED DEFAULT NULL,
  `space_id`       INT UNSIGNED NOT NULL,
  `reservation_id` INT UNSIGNED DEFAULT NULL,
  `type`           ENUM('bathroom','damaged_equipment','cleaning','parking','security','other') NOT NULL DEFAULT 'other',
  `description`    TEXT NOT NULL,
  `status`         ENUM('open','in_progress','resolved') NOT NULL DEFAULT 'open',
  `created_at`     DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  CONSTRAINT `fk_inc_space` FOREIGN KEY (`space_id`) REFERENCES `spaces` (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- PROMOTIONS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `promotions` (
  `id`               INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `title`            VARCHAR(160) NOT NULL,
  `description`      TEXT DEFAULT NULL,
  `image`            VARCHAR(255) DEFAULT NULL,
  `type`             ENUM('promotion','news','banner','coupon') NOT NULL DEFAULT 'promotion',
  `discount_percent` DECIMAL(5,2) DEFAULT 0.00,
  `coupon_code`      VARCHAR(50)  DEFAULT NULL,
  `valid_from`       DATE DEFAULT NULL,
  `valid_until`      DATE DEFAULT NULL,
  `status`           ENUM('active','inactive') NOT NULL DEFAULT 'active',
  `created_at`       DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`),
  UNIQUE KEY `uq_coupon_code` (`coupon_code`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ------------------------------------------------------------
-- LEADS
-- ------------------------------------------------------------
CREATE TABLE IF NOT EXISTS `leads` (
  `id`            INT UNSIGNED NOT NULL AUTO_INCREMENT,
  `name`          VARCHAR(120) NOT NULL,
  `email`         VARCHAR(180) DEFAULT NULL,
  `phone`         VARCHAR(20)  DEFAULT NULL,
  `business_name` VARCHAR(160) DEFAULT NULL,
  `message`       TEXT         DEFAULT NULL,
  `status`        ENUM('new','contacted','converted','discarded') NOT NULL DEFAULT 'new',
  `created_at`    DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
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
  `error_type` VARCHAR(80)  DEFAULT NULL,
  `message`    TEXT         NOT NULL,
  `file`       VARCHAR(500) DEFAULT NULL,
  `line`       INT UNSIGNED DEFAULT NULL,
  `trace`      TEXT         DEFAULT NULL,
  `created_at` DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

SET FOREIGN_KEY_CHECKS = 1;

-- ============================================================
-- SAMPLE DATA — Querétaro, México
-- ============================================================

-- USERS
-- Passwords:
--   Admin1234  → bcrypt hash below
--   User1234   → bcrypt hash below
-- To regenerate: php -r "echo password_hash('Admin1234', PASSWORD_DEFAULT);"
INSERT INTO `users` (`name`, `email`, `password`, `whatsapp`, `role`, `status`) VALUES
('Super Admin ID Sports', 'admin@idsports.mx',
 '$2y$10$TKh8H1.PfbuNIlQqHHSZEuGZhGtUJfxiNQNDGmSrX4c3wN1F3GKOW',
 '+524421000001', 'super_admin', 'active'),
('Carlos Deportivo', 'club@deportivoqueretaro.mx',
 '$2y$10$TKh8H1.PfbuNIlQqHHSZEuGZhGtUJfxiNQNDGmSrX4c3wN1F3GKOW',
 '+524421000002', 'club_admin', 'active'),
('Juan González', 'juan@gmail.com',
 '$2y$10$vI3EHaVMHGy4N5hPmU.vJeL8aSp4OQ9J7KVbpYIVjx1w3sF3f9.oC',
 '+524421000003', 'user', 'active');

-- NOTE: The hashes above are placeholders. Run this after import:
-- UPDATE users SET password = '$2y$10$...' WHERE email = 'admin@idsports.mx';
-- Or use test_connection.php to reset passwords.

-- CLUBS
INSERT INTO `clubs` (`owner_id`, `name`, `description`, `address`, `city`, `state`, `phone`, `email`, `commission_pct`, `status`) VALUES
(2, 'Deportivo Querétaro', 'El complejo deportivo más completo de la ciudad, con canchas de fútbol, pádel y tenis.', 'Av. Constituyentes 100, Col. San Pablo', 'Querétaro', 'Querétaro', '+524421100001', 'contacto@deportivoqueretaro.mx', 10.00, 'active'),
(2, 'Club Pádel Santiago', 'Club especializado en pádel con 6 canchas techadas y academia profesional.', 'Blvd. Bernardo Quintana 500, Santiago de Querétaro', 'Querétaro', 'Querétaro', '+524421100002', 'info@padelsantiago.mx', 8.00, 'active'),
(2, 'Complejo Deportivo Hércules', 'Complejo familiar con alberca olímpica, canchas de fútbol rápido y zona de juegos.', 'Calle Hércules 200, Col. Hércules', 'Querétaro', 'Querétaro', '+524421100003', 'hercules@deportes.mx', 12.00, 'active');

-- SPACES
INSERT INTO `spaces` (`club_id`, `name`, `description`, `sport_type`, `capacity`, `price_per_hour`, `status`) VALUES
-- Club 1 — Deportivo Querétaro
(1, 'Cancha de Fútbol 5 — A', 'Cancha de césped sintético techada con iluminación LED profesional.', 'football', 10, 350.00, 'active'),
(1, 'Cancha de Fútbol 5 — B', 'Cancha de césped natural exterior.', 'football', 10, 280.00, 'active'),
(1, 'Cancha de Pádel 1', 'Cancha de pádel con cristal panorámico y piso blue clay.', 'padel', 4, 200.00, 'active'),
(1, 'Cancha de Pádel 2', 'Cancha de pádel exterior cubierta.', 'padel', 4, 180.00, 'active'),
(1, 'Cancha de Tenis', 'Cancha de tenis con superficie hard court.', 'tennis', 4, 250.00, 'active'),
-- Club 2 — Club Pádel Santiago
(2, 'Cancha de Fútbol 7', 'Cancha grande de fútbol 7 con pasto sintético de última generación.', 'football', 14, 450.00, 'active'),
(2, 'Pista de Básquetbol', 'Duela profesional de maple, apta para 3x3 y 5x5.', 'basketball', 10, 220.00, 'active'),
(2, 'Pádel Premium A', 'Cancha de pádel cerrada con ventilación y marcador electrónico.', 'padel', 4, 260.00, 'active'),
(2, 'Pádel Premium B', 'Cancha de pádel cerrada con sistema de sonido.', 'padel', 4, 260.00, 'active'),
-- Club 3 — Hércules
(3, 'Cancha Fútbol Rápido', 'Fútbol rápido 5x5 techado con iluminación nocturna.', 'football', 10, 300.00, 'active'),
(3, 'Alberca Olímpica', 'Alberca de 25m con 6 carriles individuales y cronómetro digital.', 'swimming', 30, 120.00, 'active'),
(3, 'Cancha de Voleibol', 'Cancha de voleibol interior con piso de tarima.', 'volleyball', 12, 180.00, 'active');

-- SCHEDULES (0=Dom,1=Lun,2=Mar,3=Mié,4=Jue,5=Vie,6=Sáb)
INSERT INTO `schedules` (`space_id`, `day_of_week`, `open_time`, `close_time`, `is_open`) VALUES
(1,1,'07:00','22:00',1),(1,2,'07:00','22:00',1),(1,3,'07:00','22:00',1),(1,4,'07:00','22:00',1),(1,5,'07:00','22:00',1),(1,6,'08:00','22:00',1),(1,0,'08:00','20:00',1),
(3,1,'07:00','22:00',1),(3,2,'07:00','22:00',1),(3,3,'07:00','22:00',1),(3,4,'07:00','22:00',1),(3,5,'07:00','22:00',1),(3,6,'08:00','22:00',1),(3,0,'08:00','20:00',1),
(6,1,'07:00','22:00',1),(6,2,'07:00','22:00',1),(6,3,'07:00','22:00',1),(6,4,'07:00','22:00',1),(6,5,'07:00','22:00',1),(6,6,'08:00','22:00',1),(6,0,'08:00','20:00',1),
(10,1,'07:00','21:00',1),(10,2,'07:00','21:00',1),(10,3,'07:00','21:00',1),(10,4,'07:00','21:00',1),(10,5,'07:00','21:00',1),(10,6,'08:00','22:00',1),(10,0,'09:00','20:00',1),
(11,1,'06:00','20:00',1),(11,2,'06:00','20:00',1),(11,3,'06:00','20:00',1),(11,4,'06:00','20:00',1),(11,5,'06:00','20:00',1),(11,6,'07:00','19:00',1),(11,0,'07:00','17:00',1);

-- AMENITIES
INSERT INTO `amenities` (`club_id`, `name`, `description`, `price`, `stock`, `status`) VALUES
(1, 'Balón de Fútbol', 'Balón profesional para renta por hora.', 50.00, 10, 'active'),
(1, 'Petos (6 piezas)', 'Juego de 6 petos de colores.', 30.00, 5, 'active'),
(1, 'Agua embotellada', 'Botella de 600ml.', 20.00, 50, 'active'),
(1, 'Toalla deportiva', 'Toalla limpia para uso en instalaciones.', 25.00, 20, 'active'),
(2, 'Raqueta de Pádel', 'Raqueta profesional para renta.', 80.00, 8, 'active'),
(2, 'Pelotas de Pádel (3)', 'Tubo de 3 pelotas nuevas.', 60.00, 15, 'active'),
(2, 'Paletas de ping-pong', 'Set de 2 paletas + 3 pelotas.', 40.00, 6, 'active'),
(3, 'Lentes de natación', 'Lentes profesionales antiempañantes.', 35.00, 12, 'active'),
(3, 'Gorra de natación', 'Gorra de silicona.', 25.00, 20, 'active'),
(3, 'Balón de voleibol', 'Balón oficial de voleibol.', 50.00, 4, 'active');

-- RESERVATIONS (sample)
INSERT INTO `reservations` (`user_id`, `space_id`, `date`, `start_time`, `end_time`, `num_people`, `subtotal`, `service_fee`, `total`, `payment_method`, `payment_status`, `qr_code`, `status`) VALUES
(3, 1, DATE_ADD(CURDATE(), INTERVAL 1 DAY), '10:00:00', '11:00:00', 10, 350.00, 17.50, 367.50, 'card', 'paid', 'RES-SAMPLE001', 'active'),
(3, 3, DATE_ADD(CURDATE(), INTERVAL 3 DAY), '16:00:00', '17:00:00', 4, 200.00, 10.00, 210.00, 'card', 'paid', 'RES-SAMPLE002', 'active'),
(3, 6, DATE_SUB(CURDATE(), INTERVAL 7 DAY), '09:00:00', '10:00:00', 14, 450.00, 22.50, 472.50, 'paypal', 'paid', 'RES-SAMPLE003', 'completed'),
(3, 11, DATE_SUB(CURDATE(), INTERVAL 14 DAY), '07:00:00', '08:00:00', 1, 120.00, 6.00, 126.00, 'card', 'paid', 'RES-SAMPLE004', 'completed');

-- REVIEWS
INSERT INTO `reviews` (`user_id`, `space_id`, `reservation_id`, `rating`, `comment`) VALUES
(3, 6, 3, 5, '¡Excelente cancha! El pasto sintético es de muy buena calidad y la iluminación perfecta.'),
(3, 11, 4, 4, 'Alberca muy limpia y bien mantenida. El personal muy amable.');

-- INCIDENTS
INSERT INTO `incidents` (`user_id`, `space_id`, `type`, `description`, `status`) VALUES
(3, 1, 'cleaning', 'Los vestidores necesitaban limpieza al llegar.', 'resolved'),
(3, 6, 'damaged_equipment', 'Una portería tiene la red rota.', 'in_progress');

-- PROMOTIONS
INSERT INTO `promotions` (`title`, `description`, `type`, `discount_percent`, `coupon_code`, `valid_from`, `valid_until`, `status`) VALUES
('¡Primera reservación con 20% OFF!', 'Usa este código en tu primera reservación y obtén 20% de descuento en cualquier cancha.', 'coupon', 20.00, 'BIENVENIDO20', '2024-01-01', '2025-12-31', 'active'),
('Fines de semana en familia', 'Reserva cualquier cancha sábado o domingo y disfruta de nuestras instalaciones con toda la familia.', 'promotion', 15.00, NULL, '2024-06-01', '2025-12-31', 'active'),
('Verano Deportivo 2025', 'Descuento especial de verano en todas las canchas de Querétaro.', 'coupon', 10.00, 'VERANO10', '2025-06-01', '2025-08-31', 'active'),
('Apertura Club Pádel Santiago', 'Celebramos nuestra apertura con precios especiales en canchas de pádel.', 'news', 0.00, NULL, '2025-01-01', '2025-03-31', 'active');

-- LEADS
INSERT INTO `leads` (`name`, `email`, `phone`, `business_name`, `message`, `status`) VALUES
('Roberto Mendoza', 'roberto@gmail.com', '+524424000001', 'Club Pádel Los Arcos', 'Me interesa registrar mi club de pádel con 4 canchas en la plataforma.', 'new'),
('Club Deportivo Las Águilas', 'info@aguilas.mx', '+524424000002', 'Club Las Águilas', 'Tenemos 5 canchas de tenis y queremos digitalizarnos.', 'contacted'),
('María Luisa Vega', 'mlvega@correo.mx', '+524424000003', 'Alberca Vega', 'Tengo una alberca y quiero ofrecer clases de natación a través de la plataforma.', 'new');

-- CONFIG
INSERT INTO `config` (`cfg_key`, `cfg_value`) VALUES
('app_name', 'ID Sports'),
('app_description', 'Plataforma de reservaciones deportivas en Querétaro, México'),
('contact_email', 'contacto@idsports.mx'),
('contact_phone', '+52 442 100 0000'),
('address', 'Querétaro, Qro., México'),
('timezone', 'America/Mexico_City'),
('qr_enabled', '1'),
('chatbot_enabled', '0'),
('color_primary', '#0EA5E9'),
('color_secondary', '#7C3AED'),
('paypal_mode', 'sandbox'),
('paypal_client_id', ''),
('paypal_secret', ''),
('smtp_host', 'smtp.gmail.com'),
('smtp_port', '587'),
('smtp_user', ''),
('smtp_pass', ''),
('smtp_from', 'noreply@idsports.mx'),
('chatbot_token', ''),
('chatbot_phone', ''),
('qr_api_url', 'https://api.qrserver.com/v1/create-qr-code/');
