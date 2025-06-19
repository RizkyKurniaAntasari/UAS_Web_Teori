<?php
session_start();
require_once '../../../db.php';

header('Content-Type: application/json');
if (!isset($_SESSION['user'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Not authenticated']);
    exit;
}

$pdo = get_pdo_connection();
$user_npm = $_SESSION['user'];
$response = ['status' => 'error', 'message' => 'Invalid Request'];

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    try {
        $selected_day = $_GET['day'] ?? date('Y-m-d');
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $selected_day)) {
             throw new Exception("Format tanggal tidak valid.");
        }

        $schedule = [];
        $start_time = new DateTime('07:30');
        $end_time = new DateTime('17:30');
        $break_start = new DateTime('12:40');
        $break_end = new DateTime('13:55');
        $interval = new DateInterval('PT15M');
        $slot_index = 1;
        
        $stmt = $pdo->prepare("SELECT jam, npm, keterangan FROM jadwal_wawancara WHERE hari = ?");
        $stmt->execute([$selected_day]);
        $db_booked_slots = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        $booked_slots = [];
        foreach ($db_booked_slots as $slot) {
            if(!empty($slot['npm'])) {
                $booked_slots[$slot['jam']] = ['npm' => $slot['npm'], 'keterangan' => $slot['keterangan']];
            }
        }

        $user_has_booking_stmt = $pdo->prepare("SELECT COUNT(*) FROM jadwal_wawancara WHERE npm = ?");
        $user_has_booking_stmt->execute([$user_npm]);
        $user_has_booking = $user_has_booking_stmt->fetchColumn() > 0;

        $current_time = clone $start_time;

        while ($current_time < $end_time) {
            if ($current_time >= $break_start && $current_time < $break_end) {
                $current_time = clone $break_end;
                continue;
            }

            $slot_label = "S" . $slot_index;
            $current_slot_end = (clone $current_time)->add($interval);
            
            $is_booked = isset($booked_slots[$slot_label]);
            $is_users_booking = $is_booked && ($booked_slots[$slot_label]['npm'] == $user_npm);

            $slot_info = [
                'jam' => $slot_label,
                'waktu_text' => $current_time->format('H:i') . ' - ' . $current_slot_end->format('H:i'),
                'is_booked' => $is_booked,
                'is_users_booking' => $is_users_booking,
                'keterangan' => $is_booked ? $booked_slots[$slot_label]['keterangan'] : null
            ];
            $schedule[] = $slot_info;

            $current_time->add($interval);
            $slot_index++;
        }
        $response = ['status' => 'success', 'schedule' => $schedule, 'user_has_booking' => $user_has_booking];

    } catch (Exception $e) {
        http_response_code(500);
        $response['message'] = $e->getMessage();
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $day = $data['day'] ?? '';
    $jam = $data['jam'] ?? '';
    $keterangan = $data['keterangan'] ?? '';
    $waktu_text = $data['waktu_text'] ?? '';
    
    if (empty($day) || empty($jam) || empty($keterangan) || empty($waktu_text)) {
        http_response_code(400);
        $response['message'] = 'Data tidak lengkap.';
        echo json_encode($response);
        exit;
    }

    $pdo->beginTransaction();
    try {
        if ($keterangan === 'cancel') {
            $stmt = $pdo->prepare("DELETE FROM jadwal_wawancara WHERE hari = ? AND jam = ? AND npm = ?");
            $stmt->execute([$day, $jam, $user_npm]);
            $response = ['status' => 'success', 'message' => 'Jadwal berhasil dibatalkan.'];
        } else {
            // Cek apakah user sudah memiliki booking lain
            $stmt_check = $pdo->prepare("SELECT jam FROM jadwal_wawancara WHERE npm = ?");
            $stmt_check->execute([$user_npm]);
            if ($stmt_check->fetchColumn()) {
                throw new Exception("Anda sudah memiliki jadwal. Batalkan jadwal lama untuk memilih yang baru.");
            }
            
            // Cek dan booking slot secara atomik
            $stmt_nama = $pdo->prepare("SELECT nama FROM asdos WHERE npm = ?");
            $stmt_nama->execute([$user_npm]);
            $user_nama = $stmt_nama->fetchColumn();

            $sql = "INSERT INTO jadwal_wawancara (hari, jam, waktu_text, npm, nama, keterangan) VALUES (?, ?, ?, ?, ?, ?)
                    ON DUPLICATE KEY UPDATE npm = IF(npm IS NULL, VALUES(npm), npm), 
                                            nama = IF(npm IS NULL, VALUES(nama), nama), 
                                            keterangan = IF(npm IS NULL, VALUES(keterangan), keterangan)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$day, $jam, $waktu_text, $user_npm, $user_nama, $keterangan]);
            
            if ($stmt->rowCount() == 0) {
                 throw new Exception("Gagal memesan jadwal. Slot mungkin sudah dipesan oleh orang lain. Silakan muat ulang halaman.");
            }
            $response = ['status' => 'success', 'message' => 'Jadwal berhasil dipesan!'];
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        http_response_code(409); 
        $response['message'] = $e->getMessage();
    }
}

echo json_encode($response);
exit;
?>