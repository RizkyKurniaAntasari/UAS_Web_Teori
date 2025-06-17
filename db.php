<?php
$document_root = realpath($_SERVER['DOCUMENT_ROOT']);
$current_dir = realpath(__DIR__);
$relative_path = str_replace($document_root, '', $current_dir);
$base_url = '/' . ltrim(str_replace('\\', '/', $relative_path), '/') . '/';
define('BASE_URL', $base_url);

function get_pdo_connection(): PDO
{
    $host = 'localhost';
    $db   = 'uas_web'; 
    $user = 'root';    
    $pass = '';         
    $charset = 'utf8mb4';

    $dsn = "mysql:host=$host;dbname=$db;charset=$charset";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    try {
        return new PDO($dsn, $user, $pass, $options);
    } catch (\PDOException $e) {
        throw new \PDOException($e->getMessage(), (int)$e->getCode());
    }
}