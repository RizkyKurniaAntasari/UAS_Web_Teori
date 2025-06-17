<?php
require_once '../../../db.php';

header('Content-Type: application/json');
$pdo = get_pdo_connection();
$response = ['status' => 'error', 'message' => 'Invalid Request'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    try {
        if ($action === 'create') {
            $stmt = $pdo->prepare("
        INSERT INTO hasil_seleksi (npm, nama_mahasiswa, id_mata_kuliah, semester_mk, peran, kelas_pj)
        VALUES (?, ?, ?, ?, ?, ?)
    ");
            $stmt->execute([
                $_POST['npm'],
                $_POST['nama'],
                $_POST['mata_kuliah'],
                $_POST['semester_mk'],
                $_POST['peran'],
                $_POST['kelas_pj']
            ]);

            $last_id = $pdo->lastInsertId();

            // JOIN agar bisa dapat nama mata kuliah
            $stmt = $pdo->prepare("
        SELECT hs.*, mk.nama AS mata_kuliah 
        FROM hasil_seleksi hs
        JOIN mata_kuliah mk ON hs.id_mata_kuliah = mk.id
        WHERE hs.id = ?
    ");
            $stmt->execute([$last_id]);
            $new_data = $stmt->fetch();

            $response = [
                'status' => 'success',
                'message' => 'Data berhasil ditambahkan.',
                'data' => $new_data
            ];
        } elseif ($action === 'delete') {
            $stmt = $pdo->prepare("DELETE FROM hasil_seleksi WHERE id = ?");
            $stmt->execute([$_POST['id']]);
            $response = ['status' => 'success', 'message' => 'Data berhasil dihapus.'];
        }
    } catch (PDOException $e) {
        $response['message'] = 'Database Error: ' . $e->getMessage();
    }
}

echo json_encode($response);
exit;
