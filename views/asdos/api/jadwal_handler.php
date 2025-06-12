<?php
session_start();
require_once '../../../db.php';

header('Content-Type: application/json');
if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$pdo = get_pdo_connection();
$user_npm = $_SESSION['user'];
$response = ['status' => 'error', 'message' => 'Invalid Request'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $selected_day = $_GET['day'] ?? 1;
    $schedule = [];
    $start_time = new DateTime('09:00');
    $end_time = new DateTime('15:00');
    $break_start = new DateTime('12:00');
    $break_end = new DateTime('12:40');
    $interval = new DateInterval('PT20M');
    $slot_index = 1;
    
    $stmt = $pdo->prepare("SELECT jam, npm, keterangan FROM jadwal_wawancara WHERE hari = ?");
    $stmt->execute([$selected_day]);
    $booked_slots = $stmt->fetchAll(PDO::FETCH_KEY_PAIR);

    $user_has_booking_stmt = $pdo->prepare("SELECT COUNT(*) FROM jadwal_wawancara WHERE npm = ?");
    $user_has_booking_stmt->execute([$user_npm]);
    $user_has_booking = $user_has_booking_stmt->fetchColumn() > 0;

    while ($start_time < $end_time) {
        if ($start_time >= $break_start && $start_time < $break_end) {
            $start_time = clone $break_end;
        }

        $slot_label = "S" . $slot_index;
        $current_slot_end = (clone $start_time)->add($interval);
        
        $slot_info = [
            'jam' => $slot_label,
            'waktu_text' => $start_time->format('H:i') . ' - ' . $current_slot_end->format('H:i'),
            'is_booked' => isset($booked_slots[$slot_label]),
            'is_users_booking' => ($booked_slots[$slot_label] ?? null) === $user_npm,
            'keterangan' => $booked_slots[$slot_label] ?? null,
        ];
        $schedule[] = $slot_info;

        $start_time->add($interval);
        $slot_index++;
    }
    $response = ['status' => 'success', 'schedule' => $schedule, 'user_has_booking' => $user_has_booking];

} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $day = $data['day'] ?? 0;
    $jam = $data['jam'] ?? '';
    $keterangan = $data['keterangan'] ?? '';
    $waktu_text = $data['waktu_text'] ?? '';
    
    $pdo->beginTransaction();
    try {
        if ($keterangan === 'cancel') {
            $stmt = $pdo->prepare("UPDATE jadwal_wawancara SET npm=NULL, nama=NULL, keterangan=NULL WHERE hari=? AND jam=? AND npm=?");
            $stmt->execute([$day, $jam, $user_npm]);
        } else {
            $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM jadwal_wawancara WHERE npm = ?");
            $stmt_check->execute([$user_npm]);
            if ($stmt_check->fetchColumn() > 0) {
                throw new Exception("Anda sudah memiliki jadwal. Batalkan jadwal lama untuk memilih yang baru.");
            }
            
            $stmt_nama = $pdo->prepare("SELECT nama FROM asdos WHERE npm = ?");
            $stmt_nama->execute([$user_npm]);
            $user_nama = $stmt_nama->fetchColumn();

            $sql = "INSERT INTO jadwal_wawancara (hari, jam, waktu_text, npm, nama, keterangan) VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE npm = VALUES(npm), nama = VALUES(nama), keterangan = VALUES(keterangan)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$day, $jam, $waktu_text, $user_npm, $user_nama, $keterangan]);
        }
        $pdo->commit();
        $response = ['status' => 'success', 'message' => 'Jadwal berhasil diperbarui.'];
    } catch (Exception $e) {
        $pdo->rollBack();
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
exit;
?>