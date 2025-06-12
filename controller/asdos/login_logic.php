<?php
session_start();
require_once '../../db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: ../../login.php');
    exit;
}

$npm = $_POST['npm'] ?? '';
$password = $_POST['password'] ?? '';

if (empty($npm) || empty($password)) {
    $_SESSION['error'] = "NPM dan password wajib diisi.";
    header("Location: ../../login.php");
    exit();
}

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->prepare("SELECT npm, password FROM asdos WHERE npm = ?");
    $stmt->execute([$npm]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        session_regenerate_id(true);
        $_SESSION['user'] = $user['npm'];
        unset($_SESSION['error']);
        header("Location: ../../views/asdos/index.php");
        exit();
    } else {
        $_SESSION['error'] = "NPM atau password salah.";
        header("Location: ../../login.php");
        exit();
    }
} catch (PDOException $e) {
    error_log('Login Error: ' . $e->getMessage());
    $_SESSION['error'] = "Terjadi kesalahan pada server.";
    header("Location: ../../login.php");
    exit();
}
?>