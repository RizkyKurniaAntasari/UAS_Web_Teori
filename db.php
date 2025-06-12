<?php
$host = "localhost";
$user = "root";
$password = "";
$db_name = "uas_web";
$charset = "utf8mb4";

if (!defined('BASE_URL')) {
    define('BASE_URL', '/teori/oprec');
}

function get_pdo_connection(): PDO
{
    global $host, $db_name, $user, $password, $charset;
    static $pdo = null;

    if ($pdo === null) {
        $dsn = "mysql:host=$host;dbname=$db_name;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
        try {
            $pdo = new PDO($dsn, $user, $password, $options);
        } catch (\PDOException $e) {
            throw new \PDOException($e->getMessage(), (int)$e->getCode());
        }
    }
    return $pdo;
}

$conn = mysqli_connect($host, $user, $password, $db_name);
if (!$conn) {
    die("Legacy Connection Error: " . mysqli_connect_error());
}
?>