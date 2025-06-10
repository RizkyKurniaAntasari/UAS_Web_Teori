<?php
session_start();
require_once __DIR__ . '/../../db.php';

$npm = $_SESSION['user'];

if (!$conn) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

$sql = "DELETE FROM asdos WHERE npm = '$npm'";
$sql_remove_pendaftaran = "DELETE FROM pendaftaran WHERE npm = '$npm'";

if(mysqli_query($conn, $sql_remove_pendaftaran)){}

if (mysqli_query($conn, $sql)) {
    echo "Akun berhasil dihapus.";
    session_destroy();
    header("Location: " . BASE_URL . "/index.php");
    exit();
} else {
    echo "Gagal menghapus akun: " . mysqli_error($conn);
}
