<?php
$host = "localhost";
$user = "root";
$password = "";
$db = "uas_web";

$conn = mysqli_connect($host, $user, $password, $db);

function check_auth()
{
    if (!isset($_SESSION['user'])) {
        echo "<script>
        alert('Silahkan login dulu!');
        window.location.href = '" . BASE_URL . "login.php';
    </script>";
        exit;
    }
}

if (!$conn) {
    die("Error Connection : " . mysqli_connect_error());
}
if (!defined('BASE_URL')) {
    // Ambil path absolut ke file saat ini
    $document_root = realpath($_SERVER['DOCUMENT_ROOT']);
    $current_dir = realpath(__DIR__);
    $relative_path = str_replace($document_root, '', $current_dir);
    $base_url = '/' . ltrim(str_replace('\\', '/', $relative_path), '/') . '/';
    define('BASE_URL', $base_url);
}
