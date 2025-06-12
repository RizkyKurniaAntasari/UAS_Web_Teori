-- SCHEMA DATABASE
CREATE DATABASE IF NOT EXISTS uas_web;

USE uas_web;

CREATE TABLE asdos(
    npm INT UNSIGNED PRIMARY KEY,
    nama VARCHAR(255) NOT NULL,
    password VARCHAR(255) NOT NULL
);

CREATE TABLE pendaftaran(
    id_pendaftaran INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    npm INT UNSIGNED NOT NULL,
    wa VARCHAR(15) NOT NULL,
    matkul1 VARCHAR(255) NOT NULL,
    matkul2 VARCHAR(255) NOT NULL,
    alasan TEXT,
    kebersediaan VARCHAR(50),
    pengalaman VARCHAR(50),
    prioritas VARCHAR(50),
    file VARCHAR(255) NOT NULL,
    FOREIGN KEY (npm) REFERENCES asdos(npm) ON DELETE CASCADE
);

CREATE TABLE jadwal_wawancara (
  id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  hari DATE NOT NULL,
  jam VARCHAR(20) NOT NULL,
  waktu_text VARCHAR(20) NULL,
  npm INT UNSIGNED DEFAULT NULL,
  nama VARCHAR(255) DEFAULT NULL,
  keterangan VARCHAR(20) DEFAULT NULL,
  UNIQUE KEY (hari, jam),
  FOREIGN KEY (npm) REFERENCES asdos(npm) ON DELETE SET NULL
);

CREATE TABLE mata_kuliah (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    kode VARCHAR(20) NOT NULL UNIQUE,
    nama VARCHAR(255) NOT NULL,
    sks INT NOT NULL,
    semester INT NOT NULL,
    dosen VARCHAR(255) NOT NULL,
    kuota INT NOT NULL,
    status ENUM('Aktif', 'Nonaktif') NOT NULL DEFAULT 'Aktif'
);

CREATE TABLE hasil_seleksi (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    npm INT UNSIGNED NOT NULL,
    nama_mahasiswa VARCHAR(255) NOT NULL,
    id_mata_kuliah INT UNSIGNED NOT NULL,
    peran ENUM('Koordinator', 'Anggota') NOT NULL,
    kelas_pj VARCHAR(10) NOT NULL,
    FOREIGN KEY (npm) REFERENCES asdos(npm) ON DELETE CASCADE,
    FOREIGN KEY (id_mata_kuliah) REFERENCES mata_kuliah(id) ON DELETE CASCADE
);