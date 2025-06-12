<?php
require_once __DIR__ . '/../../../db.php';

header('Content-Type: application/json');

$pdo = get_pdo_connection();
$method = $_SERVER['REQUEST_METHOD'];
$response = ['status' => 'error', 'message' => 'Invalid Request'];

if ($method === 'POST') {
    $action = $_POST['action'] ?? '';
    
    try {
        if ($action === 'create') {
            $stmt = $pdo->prepare("INSERT INTO mata_kuliah (kode, nama, sks, semester, dosen, kuota, status) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->execute([
                $_POST['kode'], $_POST['nama'], $_POST['sks'], $_POST['semester'],
                $_POST['dosen'], $_POST['kuota'], $_POST['status']
            ]);
            $last_id = $pdo->lastInsertId();
            $stmt = $pdo->prepare("SELECT * FROM mata_kuliah WHERE id = ?");
            $stmt->execute([$last_id]);
            $new_mk = $stmt->fetch();
            $response = ['status' => 'success', 'message' => 'Mata Kuliah berhasil dibuat.', 'data' => $new_mk];

        } elseif ($action === 'update') {
            $stmt = $pdo->prepare("UPDATE mata_kuliah SET kode=?, nama=?, sks=?, semester=?, dosen=?, kuota=?, status=? WHERE id=?");
            $stmt->execute([
                $_POST['kode'], $_POST['nama'], $_POST['sks'], $_POST['semester'],
                $_POST['dosen'], $_POST['kuota'], $_POST['status'], $_POST['id']
            ]);
            $stmt = $pdo->prepare("SELECT * FROM mata_kuliah WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $updated_mk = $stmt->fetch();
            $response = ['status' => 'success', 'message' => 'Mata Kuliah berhasil diperbarui.', 'data' => $updated_mk];

        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM mata_kuliah WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $response = ['status' => 'success', 'message' => 'Mata Kuliah berhasil dihapus.'];
        }
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $response['message'] = 'Gagal: Kode Mata Kuliah sudah ada.';
        } else {
            $response['message'] = 'Database Error: ' . $e->getMessage();
        }
    }
}

echo json_encode($response);
exit;
?>