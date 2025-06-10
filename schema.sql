-- SCHEMA DATABASE
CREATE DATABASE IF NOT EXISTS uas_web;
use uas_web;
CREATE TABLE asdos(
    npm INT PRIMARY KEY,
    nama VARCHAR(250),
    password VARCHAR(1000)
);

CREATE TABLE pendaftaran(
    id_pendaftaran INT PRIMARY KEY AUTO_INCREMENT,
    npm INT,
    wa VARCHAR(15),
    matkul1 VARCHAR(250),
    matkul2 VARCHAR(250),
    alasan VARCHAR(1000),
    kebersediaan VARCHAR(50),
    pengalaman VARCHAR(50),
    prioritas VARCHAR(50),
    file VARCHAR(250),
    
    -- Menambahkan relasi ke tabel asdos
    FOREIGN KEY (npm) REFERENCES asdos(npm)
);

CREATE TABLE jadwal_wawancara (
  id INT AUTO_INCREMENT PRIMARY KEY,
  hari INT NOT NULL,
  jam VARCHAR(20) NOT NULL,
  waktu_text VARCHAR(20) NULL,
  npm VARCHAR(20) DEFAULT NULL,
  nama VARCHAR(100) DEFAULT NULL,
  keterangan VARCHAR(20) DEFAULT NULL,
  UNIQUE (hari, jam)
);

