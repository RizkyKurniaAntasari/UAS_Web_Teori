<?php
session_start();
require_once __DIR__ . '/../../db.php';

$npm = $_POST['npm'];
$password = $_POST['password'];

$query = "SELECT * FROM asdos WHERE npm='$npm'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user'] = $user['npm'];
    header("Location: " . BASE_URL . "views/asdos/index.php");
    exit();
} else {
    $_SESSION['error'] = "npm atau password salah";
    header("Location: " . BASE_URL . "login.php");
    exit();
}
?>
