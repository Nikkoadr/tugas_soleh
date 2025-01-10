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
    role ENUM('mahasiswa', 'dosen') NOT NULL
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
CREATE TABLE GajiDosen (
    id_gaji INT AUTO_INCREMENT PRIMARY KEY,
    id_dosen INT NOT NULL,
    jumlah_gaji DECIMAL(15, 2) NOT NULL,
    tanggal_pembayaran DATE NOT NULL,
    FOREIGN KEY (id_dosen) REFERENCES Dosen(id_dosen)
);

-- Tabel BayaranMahasiswa
CREATE TABLE BayaranMahasiswa (
    id_bayaran INT AUTO_INCREMENT PRIMARY KEY,
    id_mahasiswa INT NOT NULL,
    jumlah_bayaran DECIMAL(15, 2) NOT NULL,
    tanggal_pembayaran DATE NOT NULL,
    FOREIGN KEY (id_mahasiswa) REFERENCES Mahasiswa(id_mahasiswa)
);

-- Tabel Laporan (modifikasi untuk mendukung transaksi mahasiswa dan dosen)
CREATE TABLE Laporan (
    id_laporan INT AUTO_INCREMENT PRIMARY KEY,
    deskripsi_laporan TEXT NOT NULL,
    tanggal_laporan DATE NOT NULL,
    id_dosen INT,
    id_mahasiswa INT,
    id_bayaran INT, -- Menyimpan ID bayaran jika laporan terkait dengan pembayaran
    tipe_laporan ENUM('transaksi_bayaran', 'aktivitas_dosen') NOT NULL, -- Untuk membedakan laporan tipe
    FOREIGN KEY (id_dosen) REFERENCES Dosen(id_dosen),
    FOREIGN KEY (id_mahasiswa) REFERENCES Mahasiswa(id_mahasiswa),
    FOREIGN KEY (id_bayaran) REFERENCES BayaranMahasiswa(id_bayaran)
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
('Budi', 'budi', 'password1', 'mahasiswa'),
('Ani', 'ani', 'password2', 'mahasiswa'),
('Dono', 'dono', 'password3', 'mahasiswa'),
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
(1, 'M001', 1),
(2, 'M002', 2),
(3, 'M003', 3),
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

-- Menambahkan data pada tabel GajiDosen
INSERT INTO GajiDosen (id_dosen, jumlah_gaji, tanggal_pembayaran)
VALUES
(1, 10000000.00, '2025-01-05'),
(2, 9500000.00, '2025-01-05'),
(3, 12000000.00, '2025-01-05'),
(4, 10500000.00, '2025-01-05'),
(5, 13000000.00, '2025-01-05');

-- Menambahkan data pada tabel BayaranMahasiswa
INSERT INTO BayaranMahasiswa (id_mahasiswa, jumlah_bayaran, tanggal_pembayaran)
VALUES
(1, 5000000.00, '2025-01-07'),
(2, 4500000.00, '2025-01-07'),
(3, 5500000.00, '2025-01-07'),
(4, 6000000.00, '2025-01-07'),
(5, 6500000.00, '2025-01-07');

-- Menambahkan data pada tabel Laporan untuk pembayaran mahasiswa
INSERT INTO Laporan (deskripsi_laporan, tanggal_laporan, id_mahasiswa, id_bayaran, tipe_laporan)
VALUES
('Pembayaran sebesar 5000000 untuk mahasiswa NIM M001', '2025-01-07', 1, 1, 'transaksi_bayaran'),
('Pembayaran sebesar 4500000 untuk mahasiswa NIM M002', '2025-01-07', 2, 2, 'transaksi_bayaran');

-- Menambahkan data pada tabel Laporan untuk aktivitas dosen (gaji)
INSERT INTO Laporan (deskripsi_laporan, tanggal_laporan, id_dosen, tipe_laporan)
VALUES
('Pembayaran gaji sebesar 10000000 untuk dosen NIDN D001', '2025-01-05', 1, 'aktivitas_dosen'),
('Pembayaran gaji sebesar 9500000 untuk dosen NIDN D002', '2025-01-05', 2, 'aktivitas_dosen');

-- Trigger untuk mencatat pembayaran mahasiswa ke dalam Laporan
DELIMITER //

CREATE TRIGGER after_mahasiswa_payment
AFTER INSERT ON BayaranMahasiswa
FOR EACH ROW
BEGIN
    INSERT INTO Laporan (deskripsi_laporan, tanggal_laporan, id_mahasiswa, id_bayaran, tipe_laporan)
    VALUES (
        CONCAT('Pembayaran sebesar ', NEW.jumlah_bayaran, ' untuk mahasiswa NIM ', NEW.id_mahasiswa),
        NEW.tanggal_pembayaran,
        NEW.id_mahasiswa,
        NEW.id_bayaran,
        'transaksi_bayaran'
    );
END //

DELIMITER ;

-- Trigger untuk mencatat pembayaran gaji dosen ke dalam Laporan
DELIMITER //

CREATE TRIGGER after_dosen_salary_payment
AFTER INSERT ON GajiDosen
FOR EACH ROW
BEGIN
    INSERT INTO Laporan (deskripsi_laporan, tanggal_laporan, id_dosen, tipe_laporan)
    VALUES (
        CONCAT('Pembayaran gaji sebesar ', NEW.jumlah_gaji, ' untuk dosen NIDN ', NEW.id_dosen),
        NEW.tanggal_pembayaran,
        NULL,
        'aktivitas_dosen'
    );
END //

DELIMITER ;
