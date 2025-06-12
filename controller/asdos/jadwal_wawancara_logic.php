<?php
session_start();
require_once __DIR__ .'../../db.php';

$hari = intval($_POST['hari']);
$jam = trim($_POST['jam']); // Ini adalah "S1", "S2", ...
$waktu_text = trim($_POST['waktu_text']); // Ini adalah "09:00 - 09:20"
$npm = trim($_POST['npm']);
$nama = trim($_POST['nama']);
$keterangan = trim($_POST['keterangan']);

// Validasi sederhana untuk memastikan waktu_text tidak kosong saat memilih jadwal
if ($keterangan !== '' && empty($waktu_text)) {
    $_SESSION['error'] = "Terjadi kesalahan, data waktu tidak lengkap.";
    header('Location: ../../views/asdos/jadwal_wawancara.php');
    exit;
}

if ($keterangan === '') {
    // Batalkan slot (kosongkan dengan NULL), tidak perlu ubah waktu_text
    $sql = "UPDATE jadwal_wawancara SET npm = NULL, nama = NULL, keterangan = NULL WHERE hari = ? AND jam = ? AND npm = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        $_SESSION['error'] = "Gagal prepare statement: " . $conn->error;
    } else {
        $stmt->bind_param('iss', $hari, $jam, $npm);
        $stmt->execute();
        $stmt->close();
    }
} else {
    // Cek dulu apakah user sudah punya jadwal di tempat lain
    $sqlCheckUser = "SELECT jam FROM jadwal_wawancara WHERE npm = ? AND (hari != ? OR jam != ?)";
    $stmtCheckUser = $conn->prepare($sqlCheckUser);
    $stmtCheckUser->bind_param('sis', $npm, $hari, $jam);
    $stmtCheckUser->execute();
    $resultUser = $stmtCheckUser->get_result();
    if ($resultUser->num_rows > 0) {
        $_SESSION['error'] = "Anda sudah memiliki jadwal. Batalkan jadwal lama terlebih dahulu untuk memilih yang baru.";
        header('Location: ../../views/asdos/jadwal_wawancara.php');
        exit;
    }
    $stmtCheckUser->close();

    // Cek apakah slot yang dituju kosong
    $sqlCheckSlot = "SELECT npm FROM jadwal_wawancara WHERE hari = ? AND jam = ? LIMIT 1";
    $stmtCheckSlot = $conn->prepare($sqlCheckSlot);
    $stmtCheckSlot->bind_param('is', $hari, $jam);
    $stmtCheckSlot->execute();
    $resultSlot = $stmtCheckSlot->get_result();
    $row = $resultSlot->fetch_assoc();
    $stmtCheckSlot->close();

    if (!$row || is_null($row['npm']) || $row['npm'] === $npm) {
        // Slot tersedia, update atau insert
        // Kita gunakan klausa ON DUPLICATE KEY UPDATE agar lebih efisien
        // Ini membutuhkan UNIQUE KEY pada (hari, jam)
        $sqlUpsert = "INSERT INTO jadwal_wawancara (hari, jam, waktu_text, npm, nama, keterangan) VALUES (?, ?, ?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE waktu_text = VALUES(waktu_text), npm = VALUES(npm), nama = VALUES(nama), keterangan = VALUES(keterangan)";

        $stmtUpsert = $conn->prepare($sqlUpsert);
        if (!$stmtUpsert) {
            $_SESSION['error'] = "Gagal prepare statement: " . $conn->error;
        } else {
            $stmtUpsert->bind_param('isssss', $hari, $jam, $waktu_text, $npm, $nama, $keterangan);
            $stmtUpsert->execute();
            $stmtUpsert->close();
        }
    } else {
        $_SESSION['error'] = "Slot sudah diisi pengguna lain.";
    }
}

header('Location: ../../views/asdos/jadwal_wawancara.php');
exit;