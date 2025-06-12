<?php
require_once '../../../db.php';

header('Content-Type: application/json');

$pdo = get_pdo_connection();
$response = ['status' => 'error', 'message' => 'Invalid Request'];
$action = $_REQUEST['action'] ?? '';

try {
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if ($action === 'get_all') {
            $stmt = $pdo->query("SELECT p.*, a.nama FROM pendaftaran p JOIN asdos a ON p.npm = a.npm ORDER BY p.id_pendaftaran DESC");
            $pendaftar = $stmt->fetchAll();
            $response = ['status' => 'success', 'data' => $pendaftar];
        }
    } elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if ($action === 'update_status') {
            $id = $_POST['id'] ?? 0;
            $status = $_POST['status'] ?? '';
            if ($id && $status) {
                $stmt = $pdo->prepare("UPDATE pendaftaran SET status = ? WHERE id_pendaftaran = ?");
                $stmt->execute([$status, $id]);
                $response = ['status' => 'success', 'message' => 'Status updated successfully.'];
            } else {
                 $response['message'] = 'Missing ID or Status.';
            }
        } elseif ($action === 'delete') {
            $id = $_POST['id'] ?? 0;
            if ($id) {
                $stmt = $pdo->prepare("DELETE FROM pendaftaran WHERE id_pendaftaran = ?");
                $stmt->execute([$id]);
                $response = ['status' => 'success', 'message' => 'Pendaftar deleted successfully.'];
            } else {
                $response['message'] = 'Missing ID.';
            }
        }
    }
} catch (PDOException $e) {
    $response['message'] = 'Database Error: ' . $e->getMessage();
    error_log($response['message']);
}

echo json_encode($response);
exit;

?>