<?php
session_start();
require_once __DIR__ . '/../../db.php'; // Correct path to db.php

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../views/asdos/jadwal_wawancara.php');
    exit;
}

if (!isset($_SESSION['user'])) {
    $_SESSION['error'] = "Sesi tidak valid. Silakan login kembali.";
    header('Location: ../../views/asdos/jadwal_wawancara.php');
    exit;
}

$hari = intval($_POST['hari']);
$jam = trim($_POST['jam']); // Ini adalah "S1", "S2", ...
$waktu_text = trim($_POST['waktu_text']); // Ini adalah "09:00 - 09:20"
$npm = $_SESSION['user']; // Get NPM from session
$keterangan = trim($_POST['keterangan']);

try {
    $pdo = get_pdo_connection();
    $pdo->beginTransaction();

    // Fetch user name from 'asdos' table
    $stmt_nama = $pdo->prepare("SELECT nama FROM asdos WHERE npm = ?");
    $stmt_nama->execute([$npm]);
    $nama = $stmt_nama->fetchColumn();
    if (!$nama) {
        throw new Exception("Nama pengguna tidak ditemukan.");
    }

    if ($keterangan === 'cancel') {
        // Batalkan slot (kosongkan dengan NULL)
        $stmt = $pdo->prepare("UPDATE jadwal_wawancara SET npm=NULL, nama=NULL, keterangan=NULL WHERE hari=? AND jam=? AND npm=?");
        $stmt->execute([$hari, $jam, $npm]);
        $_SESSION['success'] = "Jadwal berhasil dibatalkan.";
    } else {
        // Cek dulu apakah user sudah punya jadwal di tempat lain
        $stmtCheckUser = $pdo->prepare("SELECT COUNT(*) FROM jadwal_wawancara WHERE npm = ?");
        $stmtCheckUser->execute([$npm]);
        if ($stmtCheckUser->fetchColumn() > 0) {
            // Check if the existing booking is for the current slot being updated
            $stmtCurrentBooking = $pdo->prepare("SELECT COUNT(*) FROM jadwal_wawancara WHERE npm = ? AND hari = ? AND jam = ?");
            $stmtCurrentBooking->execute([$npm, $hari, $jam]);
            if ($stmtCurrentCurrentBooking->fetchColumn() == 0) {
                 throw new Exception("Anda sudah memiliki jadwal. Batalkan jadwal lama terlebih dahulu untuk memilih yang baru.");
            }
        }

        // Upsert (INSERT or UPDATE) the schedule
        $sqlUpsert = "INSERT INTO jadwal_wawancara (hari, jam, waktu_text, npm, nama, keterangan) VALUES (?, ?, ?, ?, ?, ?)
                      ON DUPLICATE KEY UPDATE waktu_text = VALUES(waktu_text), npm = VALUES(npm), nama = VALUES(nama), keterangan = VALUES(keterangan)";
        $stmtUpsert = $pdo->prepare($sqlUpsert);
        $stmtUpsert->execute([$hari, $jam, $waktu_text, $npm, $nama, $keterangan]);
        $_SESSION['success'] = "Jadwal berhasil diperbarui.";
    }

    $pdo->commit();
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    $_SESSION['error'] = $e->getMessage();
    error_log('Jadwal Wawancara Logic Error: ' . $e->getMessage());
}

header('Location: ../../views/asdos/jadwal_wawancara.php');
exit;