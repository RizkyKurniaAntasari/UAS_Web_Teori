<?php
session_start();
require_once '../../db.php';

if (!isset($_SESSION['user'])) {
    exit('Sesi tidak valid. Silakan login kembali.');
}

$npm = $_SESSION['user'];

try {
    $pdo = get_pdo_connection();
    $pdo->beginTransaction();

    $stmt_pendaftaran = $pdo->prepare("DELETE FROM pendaftaran WHERE npm = ?");
    $stmt_pendaftaran->execute([$npm]);

    $stmt_jadwal = $pdo->prepare("UPDATE jadwal_wawancara SET npm = NULL, nama = NULL, keterangan = NULL WHERE npm = ?");
    $stmt_jadwal->execute([$npm]);
    
    $stmt_asdos = $pdo->prepare("DELETE FROM asdos WHERE npm = ?");
    $stmt_asdos->execute([$npm]);

    $pdo->commit();

    session_unset();
    session_destroy();

    echo "<script>alert('Akun berhasil dihapus.'); window.location.href='../../index.php';</script>";
    exit();

} catch (PDOException $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    error_log('Account Deletion Error: ' . $e->getMessage());
    exit('Gagal menghapus akun. Silakan coba lagi nanti.');
}
?>