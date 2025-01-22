-- Membuat database gaji_dosen
CREATE DATABASE gaji_dosen;

-- Menggunakan database gaji_dosen
USE gaji_dosen;
-- Tabel Fakultas
CREATE TABLE Fakultas (
    id_fakultas INT AUTO_INCREMENT PRIMARY KEY,
    nama_fakultas VARCHAR(100) NOT NULL
);

-- Tabel Jurusan
CREATE TABLE Jurusan (
    id_jurusan INT AUTO_INCREMENT PRIMARY KEY,
    nama_jurusan VARCHAR(100) NOT NULL,
    id_fakultas INT NOT NULL,
    FOREIGN KEY (id_fakultas) REFERENCES Fakultas(id_fakultas)
);

-- Tabel Users untuk login (nama dan username satu kata)
CREATE TABLE Users (
    id_user INT AUTO_INCREMENT PRIMARY KEY,
    nama VARCHAR(100) NOT NULL,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin','tu','dosen','mahasiswa') NOT NULL
);

-- Tabel Mahasiswa
CREATE TABLE Mahasiswa (
    id_mahasiswa INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    nim VARCHAR(20) NOT NULL UNIQUE,
    id_jurusan INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES Users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_jurusan) REFERENCES Jurusan(id_jurusan)
);

-- Tabel Dosen
CREATE TABLE Dosen (
    id_dosen INT AUTO_INCREMENT PRIMARY KEY,
    id_user INT NOT NULL,
    nidn VARCHAR(20) NOT NULL UNIQUE,
    id_jurusan INT NOT NULL,
    FOREIGN KEY (id_user) REFERENCES Users(id_user) ON DELETE CASCADE,
    FOREIGN KEY (id_jurusan) REFERENCES Jurusan(id_jurusan)
);

-- Tabel GajiDosen
CREATE TABLE gaji_dosen (
    id_gaji INT AUTO_INCREMENT PRIMARY KEY,
    id_dosen INT NOT NULL,
    jumlah_gaji DECIMAL(15, 2) NOT NULL,
    tanggal_pembayaran DATE NOT NULL,
    FOREIGN KEY (id_dosen) REFERENCES Dosen(id_dosen)
);

-- Tabel BayaranMahasiswa
CREATE TABLE bayaran_mahasiswa (
    id_bayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_mahasiswa INT NOT NULL,
    jumlah_bayaran DECIMAL(15, 2) NOT NULL,
    tanggal_pembayaran DATE NOT NULL,
    FOREIGN KEY (id_mahasiswa) REFERENCES Mahasiswa(id_mahasiswa)
);

-- Tabel Laporan (modifikasi untuk mendukung transaksi mahasiswa dan dosen)
CREATE TABLE log (
    id_log INT AUTO_INCREMENT PRIMARY KEY,
    deskripsi_laporan TEXT NOT NULL,
    tanggal DATE NOT NULL
);

-- Menambahkan data pada tabel Fakultas
INSERT INTO Fakultas (nama_fakultas)
VALUES
('Fakultas Teknik'),
('Fakultas Ekonomi'),
('Fakultas Ilmu Komputer'),
('Fakultas Hukum'),
('Fakultas Kedokteran');

-- Menambahkan data pada tabel Jurusan
INSERT INTO Jurusan (nama_jurusan, id_fakultas)
VALUES
('Teknik Informatika', 1),
('Ekonomi Bisnis', 2),
('Sistem Informasi', 3),
('Hukum Perdata', 4),
('Kedokteran Umum', 5);

-- Menambahkan data pada tabel Users (nama dan username satu kata)
INSERT INTO Users (nama, username, password, role)
VALUES
('Budi', 'budi', 'password1', 'admin'),
('Ani', 'ani', 'password2', 'tu'),
('Dono', 'dono', 'password3', 'tu'),
('Rita', 'rita', 'password4', 'mahasiswa'),
('Irwan', 'irwan', 'password5', 'mahasiswa'),
('Mohammad', 'mohammad', 'password6', 'dosen'),
('Siti', 'siti', 'password7', 'dosen'),
('Ahmad', 'ahmad', 'password8', 'dosen'),
('Sulaiman', 'sulaiman', 'password9', 'dosen'),
('Nana', 'nana', 'password10', 'dosen');

-- Menambahkan data pada tabel Mahasiswa
INSERT INTO Mahasiswa (id_user, nim, id_jurusan)
VALUES
(4, 'M004', 4),
(5, 'M005', 5);

-- Menambahkan data pada tabel Dosen
INSERT INTO Dosen (id_user, nidn, id_jurusan)
VALUES
(6, 'D001', 1),
(7, 'D002', 2),
(8, 'D003', 3),
(9, 'D004', 4),
(10, 'D005', 5);

DELIMITER //

CREATE TRIGGER after_bayaran_mahasiswa
AFTER INSERT ON bayaran_mahasiswa
FOR EACH ROW
BEGIN
    INSERT INTO log (deskripsi_laporan, tanggal)
    VALUES (
        CONCAT('Pembayaran sebesar ', NEW.jumlah_bayaran, ' untuk mahasiswa dengan ID ', NEW.id_mahasiswa, ' pada tanggal ', NEW.tanggal_pembayaran),
        NEW.tanggal_pembayaran
    );
END //

DELIMITER ;
