-- ============================================================
--  Base de datos: VOZELIA (Web corporativa + captación de leads)
--  Charset: utf8mb4 / collation: utf8mb4_unicode_ci
-- ============================================================

DROP DATABASE IF EXISTS vozelia;
CREATE DATABASE vozelia CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE vozelia;

-- -----------------------
-- Usuarios (acceso portal)
-- -----------------------
CREATE TABLE users (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL UNIQUE,
  password_hash VARCHAR(255) NOT NULL,
  phone_enc TEXT NULL,
  address_enc TEXT NULL,
  role ENUM('customer','admin') NOT NULL DEFAULT 'customer',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- -----------------------
-- Leads (cotizaciones)
-- -----------------------
CREATE TABLE leads (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  email VARCHAR(150) NOT NULL,
  phone VARCHAR(60) NULL,
  company VARCHAR(150) NULL,
  service VARCHAR(120) NULL,
  pbx VARCHAR(120) NULL,
  extensions INT NULL,
  concurrent_channels INT NULL,
  destinations VARCHAR(255) NULL,
  subject VARCHAR(150) NULL,
  message TEXT NOT NULL,
  priority ENUM('baja','media','alta') NOT NULL DEFAULT 'media',
  est_monthly_usd DECIMAL(10,2) NULL,
  first_response_due_at DATETIME NULL,
  first_response_at DATETIME NULL,
  status ENUM('nuevo','en_proceso','cerrado') NOT NULL DEFAULT 'nuevo',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_leads_created (created_at),
  INDEX idx_leads_status (status),
  INDEX idx_leads_due (first_response_due_at)
) ENGINE=InnoDB;

-- -----------------------
-- Servicios (catálogo)
-- -----------------------
CREATE TABLE services (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(140) NOT NULL UNIQUE,
  short_desc VARCHAR(255) NULL,
  body TEXT NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_services_active (is_active, sort_order)
) ENGINE=InnoDB;

-- -----------------------
-- Tarifas nacionales (referenciales)
-- -----------------------
CREATE TABLE national_rates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category VARCHAR(120) NOT NULL,
  unit ENUM('min','mes') NOT NULL DEFAULT 'min',
  price DECIMAL(10,4) NOT NULL DEFAULT 0,
  currency CHAR(3) NOT NULL DEFAULT 'USD',
  notes VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- -----------------------
-- Destinos (países)
-- -----------------------
CREATE TABLE destinations (
  id INT AUTO_INCREMENT PRIMARY KEY,
  country VARCHAR(120) NOT NULL,
  iso2 CHAR(2) NULL,
  region VARCHAR(80) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  UNIQUE KEY uk_dest_country (country)
) ENGINE=InnoDB;

-- -----------------------
-- Tarifas internacionales (por país + tipo)
-- -----------------------
CREATE TABLE international_rates (
  id INT AUTO_INCREMENT PRIMARY KEY,
  destination_id INT NOT NULL,
  rate_type ENUM('fijo','movil') NOT NULL DEFAULT 'fijo',
  unit ENUM('min','mes') NOT NULL DEFAULT 'min',
  price DECIMAL(10,4) NOT NULL DEFAULT 0,
  currency CHAR(3) NOT NULL DEFAULT 'USD',
  notes VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  INDEX idx_int_dest (destination_id, rate_type, is_active),
  CONSTRAINT fk_int_dest FOREIGN KEY (destination_id) REFERENCES destinations(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- -----------------------
-- Soluciones (cargos mensuales / referenciales)
-- -----------------------
CREATE TABLE solution_pricing (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(140) NOT NULL,
  unit ENUM('mes','evento') NOT NULL DEFAULT 'mes',
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  currency CHAR(3) NOT NULL DEFAULT 'USD',
  notes VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0
) ENGINE=InnoDB;

-- -----------------------
-- Numeración (DID) - ofertas por país
-- -----------------------
CREATE TABLE did_offers (
  id INT AUTO_INCREMENT PRIMARY KEY,
  destination_id INT NOT NULL,
  did_scope ENUM('nacional','internacional') NOT NULL DEFAULT 'internacional',
  example_format VARCHAR(80) NULL,
  availability_notes VARCHAR(255) NULL,
  setup_fee DECIMAL(10,2) NULL DEFAULT 0,
  monthly_fee DECIMAL(10,2) NULL DEFAULT 0,
  currency CHAR(3) NOT NULL DEFAULT 'USD',
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  sort_order INT NOT NULL DEFAULT 0,
  INDEX idx_did_dest (destination_id, did_scope, is_active),
  CONSTRAINT fk_did_dest FOREIGN KEY (destination_id) REFERENCES destinations(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

-- -----------------------
-- Suscripciones (newsletter)
-- -----------------------
CREATE TABLE subscriptions (
  id INT AUTO_INCREMENT PRIMARY KEY,
  email VARCHAR(150) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Compatibilidad (mensajes de contacto legacy)
-- ------------------------------------------------------------
CREATE TABLE contact_messages (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(100) NOT NULL,
  email VARCHAR(150) NOT NULL,
  subject VARCHAR(150),
  message TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- (Opcional) Tablas legacy del template original (no visibles)
-- ------------------------------------------------------------
CREATE TABLE categories (
  id INT AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(140) NOT NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE products (
  id INT AUTO_INCREMENT PRIMARY KEY,
  category_id INT NOT NULL,
  name VARCHAR(160) NOT NULL,
  slug VARCHAR(180) NOT NULL UNIQUE,
  description TEXT NULL,
  price DECIMAL(10,2) NOT NULL DEFAULT 0,
  stock INT NOT NULL DEFAULT 0,
  image VARCHAR(255) NULL,
  is_active TINYINT(1) NOT NULL DEFAULT 1,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_products_active (is_active, created_at),
  CONSTRAINT fk_products_category FOREIGN KEY (category_id) REFERENCES categories(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE orders (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  total DECIMAL(10,2) NOT NULL DEFAULT 0,
  status VARCHAR(40) NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_orders_user (user_id, created_at),
  CONSTRAINT fk_orders_user FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE order_items (
  id INT AUTO_INCREMENT PRIMARY KEY,
  order_id INT NOT NULL,
  product_id INT NOT NULL,
  quantity INT NOT NULL DEFAULT 1,
  unit_price DECIMAL(10,2) NOT NULL DEFAULT 0,
  subtotal DECIMAL(10,2) NOT NULL DEFAULT 0,
  INDEX idx_items_order (order_id),
  CONSTRAINT fk_items_order FOREIGN KEY (order_id) REFERENCES orders(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_items_product FOREIGN KEY (product_id) REFERENCES products(id)
    ON UPDATE CASCADE ON DELETE RESTRICT
) ENGINE=InnoDB;

CREATE TABLE reviews (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  product_id INT NOT NULL,
  rating TINYINT NOT NULL,
  comment TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_reviews_product (product_id, created_at),
  CONSTRAINT fk_reviews_user FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE CASCADE,
  CONSTRAINT fk_reviews_product FOREIGN KEY (product_id) REFERENCES products(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

CREATE TABLE addresses (
  id INT AUTO_INCREMENT PRIMARY KEY,
  user_id INT NOT NULL,
  label_enc TEXT NOT NULL,
  address_enc TEXT NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  INDEX idx_addr_user (user_id, created_at),
  CONSTRAINT fk_addr_user FOREIGN KEY (user_id) REFERENCES users(id)
    ON UPDATE CASCADE ON DELETE CASCADE
) ENGINE=InnoDB;

-- ------------------------------------------------------------
-- Observabilidad (Pilar 3): eventos, métricas, alertas
-- ------------------------------------------------------------
CREATE TABLE events (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  ts DATETIME NOT NULL,
  level VARCHAR(12) NOT NULL,
  name VARCHAR(120) NOT NULL,
  request_id VARCHAR(32) NULL,
  tags_json JSON NULL,
  payload_json JSON NULL,
  INDEX idx_events_ts (ts),
  INDEX idx_events_name_ts (name, ts)
) ENGINE=InnoDB;

CREATE TABLE metric_points (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  ts DATETIME NOT NULL,
  name VARCHAR(120) NOT NULL,
  value DOUBLE NOT NULL,
  tags_json JSON NULL,
  request_id VARCHAR(32) NULL,
  INDEX idx_metrics_name_ts (name, ts),
  INDEX idx_metrics_ts (ts)
) ENGINE=InnoDB;

CREATE TABLE alerts (
  id BIGINT AUTO_INCREMENT PRIMARY KEY,
  ts DATETIME NOT NULL,
  severity VARCHAR(12) NOT NULL,
  code VARCHAR(80) NOT NULL,
  message VARCHAR(255) NOT NULL,
  tags_json JSON NULL,
  request_id VARCHAR(32) NULL,
  INDEX idx_alerts_ts (ts),
  INDEX idx_alerts_sev_ts (severity, ts)
) ENGINE=InnoDB;

-- -----------------------
-- Seed básico
-- -----------------------
INSERT INTO users (name, email, password_hash, role) VALUES
('Admin','admin@vozelia.local','$2y$10$Q7O2uH2qTj8xGd2fL5u5uOxvG0iXdjZy1nOoymVQx2V3nKqHwiU4a','admin'),
('Admin2','admin2@vozelia.local','$2y$10$ZJHHVf5RF3v/sszFtAHtV.Z09SgIM6CpCFy7lyqzHJnyjtaNDxRai','admin');

INSERT INTO services (name, slug, short_desc, body, sort_order) VALUES
('Trunk SIP','trunk-sip','Conecta tu PBX y gestiona canales simultáneos, enrutamiento y seguridad.',
 'Interconexión SIP para PBX on‑premise o en la nube. Permite control de rutas, DID, redundancia y calidad de voz.', 10),
('Numeración (DID)','numeracion-did','DIDs nacionales e internacionales para presencia local en distintos países.',
 'Numeración por país/ciudad según disponibilidad. Opciones para fijo/móvil y validación por inventario.', 20),
('PBX / Telefonía IP','pbx-telefonia-ip','Telefonía IP para empresas: extensiones, IVR, grabación y reportes.',
 'Implementación y soporte de plataformas PBX según requerimientos: extensiones, IVR, colas, grabación y monitoreo.', 30),
('Conectividad / Internet','conectividad-internet','Conectividad para operación estable y voz sin cortes.',
 'Enlaces y configuración orientada a estabilidad y baja latencia, ideal para voz y aplicaciones empresariales.', 40);

INSERT INTO destinations (country, iso2, region) VALUES
('Panamá','PA','LatAm'),
('Estados Unidos','US','Norteamérica'),
('España','ES','Europa'),
('Colombia','CO','LatAm'),
('México','MX','LatAm');

INSERT INTO national_rates (category, unit, price, notes, sort_order) VALUES
('Local (fijo a fijo)','min',0.0150,'Referencial, sujeto a volumen', 10),
('Fijo a móvil','min',0.0450,'Referencial, sujeto a volumen', 20),
('Móvil a fijo','min',0.0350,'Referencial, sujeto a volumen', 30);

INSERT INTO international_rates (destination_id, rate_type, unit, price, notes, sort_order) VALUES
((SELECT id FROM destinations WHERE country='Estados Unidos'),'fijo','min',0.0200,'Referencial', 10),
((SELECT id FROM destinations WHERE country='Estados Unidos'),'movil','min',0.0300,'Referencial', 20),
((SELECT id FROM destinations WHERE country='España'),'fijo','min',0.0300,'Referencial', 30),
((SELECT id FROM destinations WHERE country='España'),'movil','min',0.0550,'Referencial', 40),
((SELECT id FROM destinations WHERE country='Colombia'),'fijo','min',0.0450,'Referencial', 50),
((SELECT id FROM destinations WHERE country='Colombia'),'movil','min',0.0900,'Referencial', 60);

INSERT INTO solution_pricing (name, unit, price, notes, sort_order) VALUES
('PBX (gestión y soporte)','mes',49.00,'Plan base, ajustable por tamaño', 10),
('Grabación de llamadas','mes',19.00,'Según retención y almacenamiento', 20),
('Monitoreo y reportes','mes',15.00,'Incluye reportes básicos', 30);

INSERT INTO did_offers (destination_id, did_scope, example_format, availability_notes, setup_fee, monthly_fee, sort_order) VALUES
((SELECT id FROM destinations WHERE country='Panamá'),'nacional','+507 3xxx xxxx','Disponibilidad por área', 0.00, 8.00, 10),
((SELECT id FROM destinations WHERE country='Estados Unidos'),'internacional','+1 (305) xxx-xxxx','Ciudad/área según inventario', 5.00, 12.00, 20),
((SELECT id FROM destinations WHERE country='España'),'internacional','+34 9xx xxx xxx','Ciudad/área según inventario', 5.00, 12.00, 30);

-- Categorías y productos legacy (mínimo para no dejar vacío)
INSERT INTO categories (name, slug) VALUES
('Servicios','servicios'),
('Equipos','equipos');

INSERT INTO products (category_id, name, slug, description, price, stock, image, is_active) VALUES
((SELECT id FROM categories WHERE slug='servicios'),'Plan Trunk SIP Base','plan-trunk-sip-base','Plan referencial para pruebas internas (no visible en menú).', 0.00, 0, NULL, 0);
