<?php
require_once '../../../db.php';

header('Content-Type: application/json');
$pdo = get_pdo_connection();
$response = ['status' => 'error', 'message' => 'Invalid Request'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $hari = $_GET['hari'] ?? date('Y-m-d');
        $stmt = $pdo->prepare("SELECT * FROM jadwal_wawancara WHERE DATE(hari) = ? ORDER BY jam");
        $stmt->execute([$hari]);
        $jadwal = $stmt->fetchAll();
        $response = ['status' => 'success', 'data' => $jadwal];
    }
} catch (PDOException $e) {
    $response['message'] = 'Database Error: ' . $e->getMessage();
    error_log($response['message']);
}

echo json_encode($response);
exit;
?>