-- ============================================================
--  APLIKASI INVENTARIS BARANG - STRUKTUR MVC
--  Mata Kuliah : Pemrograman Web Lanjut
--  Database    : db_inventaris
-- ============================================================

DROP DATABASE IF EXISTS db_inventaris;
CREATE DATABASE db_inventaris CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE db_inventaris;

-- Tabel users (login, register, remember me)
CREATE TABLE users (
    id             INT(11)      NOT NULL AUTO_INCREMENT,
    nama           VARCHAR(100) NOT NULL,
    username       VARCHAR(50)  NOT NULL,
    password       VARCHAR(255) NOT NULL,
    remember_token VARCHAR(64)  DEFAULT NULL,
    created_at     DATETIME     NOT NULL DEFAULT CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_username (username)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Akun default: username=admin | password=admin123
INSERT INTO users (nama, username, password) VALUES
('Administrator', 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

-- Tabel barang
CREATE TABLE barang (
    id          INT(11)        NOT NULL AUTO_INCREMENT,
    kode_barang VARCHAR(20)    NOT NULL,
    nama_barang VARCHAR(100)   NOT NULL,
    kategori    VARCHAR(50)    NOT NULL,
    stok        INT(11)        NOT NULL DEFAULT 0,
    harga       DECIMAL(15,2)  NOT NULL DEFAULT 0.00,
    deskripsi   TEXT,
    status      ENUM('aktif','nonaktif') NOT NULL DEFAULT 'aktif',
    created_at  DATETIME       NOT NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at  DATETIME       DEFAULT NULL ON UPDATE CURRENT_TIMESTAMP,
    PRIMARY KEY (id),
    UNIQUE KEY uq_kode_barang (kode_barang)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- Data contoh
INSERT INTO barang (kode_barang, nama_barang, kategori, stok, harga, deskripsi, status) VALUES
('BRG001', 'Laptop ASUS VivoBook 14', 'Elektronik', 15, 7500000.00, 'Laptop tipis, Intel Core i5, RAM 8GB, SSD 512GB.', 'aktif'),
('BRG002', 'Kemeja Polos Putih Pria', 'Pakaian',    50,   85000.00, 'Bahan katun combed 24s, ukuran S-XL.', 'aktif'),
('BRG003', 'Mie Instan Goreng Pedas', 'Makanan',   200,    3500.00, 'Rasa goreng pedas, berat 85 gram.', 'aktif'),
('BRG004', 'Pulpen Ballpoint Hitam',  'Alat Tulis',300,    5000.00, 'Tinta hitam tip 0.7mm.', 'aktif'),
('BRG005', 'Sepatu Lari Pria',        'Olahraga',    8,  250000.00, 'Sol karet anti selip, ukuran 39-44.', 'nonaktif');
