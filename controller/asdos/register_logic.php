<?php
require_once __DIR__ . '/../../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../index.php');
    exit;
}

$npm = $_POST['npm'] ?? '';
$nama = $_POST['nama'] ?? '';
$password = $_POST['password'] ?? '';
$confirm = $_POST['confirm_password'] ?? '';

if (empty($npm) || empty($nama) || empty($password)) {
    exit('Error: Semua kolom wajib diisi.');
}

if ($password !== $confirm) {
    exit('Error: Password dan Konfirmasi Password tidak cocok.');
}

if (!ctype_digit($npm) || strlen($npm) > 10) {
    exit('Error: NPM harus berupa angka dengan maksimal 10 digit.');
}

try {
    $pdo = get_pdo_connection();

    $stmt = $pdo->prepare("SELECT COUNT(*) FROM asdos WHERE npm = ?");
    $stmt->execute([$npm]);
    if ($stmt->fetchColumn() > 0) {
        exit('Error: NPM sudah terdaftar.');
    }

    $hash = password_hash($password, PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("INSERT INTO asdos (npm, nama, password) VALUES (?, ?, ?)");
    $stmt->execute([$npm, $nama, $hash]);

    echo "<script>alert('Akun berhasil dibuat! Silakan login.'); window.location.href='../../login.php';</script>";

} catch (PDOException $e) {
    error_log('Registration Error: ' . $e->getMessage());
    exit('Terjadi kesalahan pada server. Silakan coba lagi nanti.');
}
?>