<?php
require_once '../../../db.php';

header('Content-Type: application/json');
$pdo = get_pdo_connection();
$response = ['status' => 'error', 'message' => 'Invalid Request'];

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $action = $_POST['action'] ?? '';

        if ($action === 'create') {
            $jenis_jadwal = trim($_POST['jenis_jadwal'] ?? '');
            $tanggal = $_POST['tanggal'] ?? '';
            $pukul = $_POST['pukul'] ?? '';
            $status = $_POST['status'] ?? 'Dibuka';

            if (empty($jenis_jadwal) || empty($tanggal) || empty($pukul)) {
                throw new Exception('Jenis Jadwal, Tanggal, dan Pukul harus diisi.');
            }

            $new_slot_datetime = new DateTime($tanggal . ' ' . $pukul);

            if ($jenis_jadwal === 'Jadwal Awal' || $jenis_jadwal === 'Jadwal Akhir') {
                $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM slot_jadwal WHERE jenis_jadwal = ?");
                $stmt_check->execute([$jenis_jadwal]);
                if ($stmt_check->fetchColumn() > 0) {
                    throw new Exception("Hanya boleh ada satu '" . htmlspecialchars($jenis_jadwal) . "'.");
                }
            }

            $stmt_all_slots = $pdo->query("SELECT tanggal, pukul FROM slot_jadwal ORDER BY tanggal DESC, pukul DESC LIMIT 1");
            $latest_existing_slot = $stmt_all_slots->fetch(PDO::FETCH_ASSOC);

            if ($latest_existing_slot) {
                $latest_existing_datetime = new DateTime($latest_existing_slot['tanggal'] . ' ' . $latest_existing_slot['pukul']);
                if ($new_slot_datetime < $latest_existing_datetime) {
                    throw new Exception("Jadwal baru tidak bisa lebih cepat dari jadwal yang sudah ada.");
                }
            }

            $stmt_get_awal = $pdo->query("SELECT tanggal, pukul FROM slot_jadwal WHERE jenis_jadwal = 'Jadwal Awal'")->fetch(PDO::FETCH_ASSOC);

            if ($jenis_jadwal === 'Jadwal Wawancara' || $jenis_jadwal === 'Jadwal Istirahat' || $jenis_jadwal === 'Jadwal Akhir') {
                if (!$stmt_get_awal) {
                    throw new Exception("Anda harus membuat 'Jadwal Awal' terlebih dahulu.");
                }
                $jadwal_awal_datetime = new DateTime($stmt_get_awal['tanggal'] . ' ' . $stmt_get_awal['pukul']);
                if ($new_slot_datetime < $jadwal_awal_datetime) {
                    throw new Exception("Tanggal dan pukul " . htmlspecialchars($jenis_jadwal) . " tidak boleh sebelum 'Jadwal Awal'.");
                }
            }

            if ($jenis_jadwal === 'Jadwal Akhir') {
                $stmt_get_latest_wawancara = $pdo->query("SELECT tanggal, pukul FROM slot_jadwal WHERE jenis_jadwal = 'Jadwal Wawancara' ORDER BY tanggal DESC, pukul DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                $stmt_get_latest_istirahat = $pdo->query("SELECT tanggal, pukul FROM slot_jadwal WHERE jenis_jadwal = 'Jadwal Istirahat' ORDER BY tanggal DESC, pukul DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                
                $latest_preceding_datetime = null;
                if ($stmt_get_latest_wawancara) {
                    $latest_preceding_datetime = new DateTime($stmt_get_latest_wawancara['tanggal'] . ' ' . $stmt_get_latest_wawancara['pukul']);
                }
                if ($stmt_get_latest_istirahat) {
                    $istirahat_datetime = new DateTime($stmt_get_latest_istirahat['tanggal'] . ' ' . $stmt_get_latest_istirahat['pukul']);
                    if ($latest_preceding_datetime === null || $istirahat_datetime > $latest_preceding_datetime) {
                        $latest_preceding_datetime = $istirahat_datetime;
                    }
                }

                if ($latest_preceding_datetime && $new_slot_datetime < $latest_preceding_datetime) {
                    throw new Exception("Tanggal dan pukul 'Jadwal Akhir' tidak boleh sebelum 'Jadwal Wawancara' atau 'Jadwal Istirahat' terakhir.");
                }
            }

            $stmt = $pdo->prepare("INSERT INTO slot_jadwal (jenis_jadwal, tanggal, pukul, status) VALUES (?, ?, ?, ?)");
            $stmt->execute([$jenis_jadwal, $tanggal, $pukul, $status]);
            $last_id = $pdo->lastInsertId();

            $stmt = $pdo->prepare("SELECT * FROM slot_jadwal WHERE id = ?");
            $stmt->execute([$last_id]);
            $new_slot = $stmt->fetch(PDO::FETCH_ASSOC);

            $response = ['status' => 'success', 'message' => 'Slot jadwal berhasil ditambahkan.', 'data' => $new_slot];

        } elseif ($action === 'update') {
            $id = $_POST['id'] ?? 0;
            $jenis_jadwal = trim($_POST['jenis_jadwal'] ?? '');
            $tanggal = $_POST['tanggal'] ?? '';
            $pukul = $_POST['pukul'] ?? '';
            $status = $_POST['status'] ?? 'Dibuka';

            if (empty($id) || empty($jenis_jadwal) || empty($tanggal) || empty($pukul)) {
                throw new Exception('ID, Jenis Jadwal, Tanggal, dan Pukul harus diisi untuk pembaruan.');
            }
            
            $stmt_original = $pdo->prepare("SELECT jenis_jadwal FROM slot_jadwal WHERE id = ?");
            $stmt_original->execute([$id]);
            $original_jenis_jadwal = $stmt_original->fetchColumn();

            $current_slot_datetime = new DateTime($tanggal . ' ' . $pukul);

            if (($jenis_jadwal === 'Jadwal Awal' && $original_jenis_jadwal !== 'Jadwal Awal') ||
                ($jenis_jadwal === 'Jadwal Akhir' && $original_jenis_jadwal !== 'Jadwal Akhir')) {
                $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM slot_jadwal WHERE jenis_jadwal = ? AND id != ?");
                $stmt_check->execute([$jenis_jadwal, $id]);
                if ($stmt_check->fetchColumn() > 0) {
                    throw new Exception("Hanya boleh ada satu '" . htmlspecialchars($jenis_jadwal) . "'.");
                }
            }

            $stmt_check_any_later = $pdo->prepare("SELECT tanggal, pukul FROM slot_jadwal WHERE id != ? AND CONCAT(tanggal, ' ', pukul) > ? ORDER BY tanggal ASC, pukul ASC LIMIT 1");
            $stmt_check_any_later->execute([$id, $tanggal . ' ' . $pukul]);
            $earliest_later_slot = $stmt_check_any_later->fetch(PDO::FETCH_ASSOC);

            if ($earliest_later_slot) {
                if ($jenis_jadwal !== 'Jadwal Awal') {
                    $stmt_earliest_overall = $pdo->query("SELECT tanggal, pukul FROM slot_jadwal WHERE id != $id ORDER BY tanggal ASC, pukul ASC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                    if ($stmt_earliest_overall && $current_slot_datetime < new DateTime($stmt_earliest_overall['tanggal'] . ' ' . $stmt_earliest_overall['pukul'])) {
                        throw new Exception("Jadwal baru tidak bisa lebih cepat dari jadwal yang sudah ada.");
                    }
                }
            }
            
            $stmt_get_awal = $pdo->query("SELECT id, tanggal, pukul FROM slot_jadwal WHERE jenis_jadwal = 'Jadwal Awal'")->fetch(PDO::FETCH_ASSOC);
            
            if ($jenis_jadwal === 'Jadwal Awal') {
                $stmt_check_other_slots = $pdo->prepare("SELECT COUNT(*) FROM slot_jadwal WHERE jenis_jadwal != 'Jadwal Awal' AND id != ? AND CONCAT(tanggal, ' ', pukul) < ?");
                $stmt_check_other_slots->execute([$id, $tanggal . ' ' . $pukul]);
                if ($stmt_check_other_slots->fetchColumn() > 0) {
                    throw new Exception("Tidak dapat mengatur 'Jadwal Awal' setelah slot jadwal lainnya.");
                }
            } elseif ($jenis_jadwal === 'Jadwal Wawancara' || $jenis_jadwal === 'Jadwal Istirahat' || $jenis_jadwal === 'Jadwal Akhir') {
                if (!$stmt_get_awal || ($stmt_get_awal['id'] === $id && $original_jenis_jadwal === 'Jadwal Awal')) {
                    if ($stmt_get_awal && $stmt_get_awal['id'] !== $id) {
                        $jadwal_awal_datetime = new DateTime($stmt_get_awal['tanggal'] . ' ' . $stmt_get_awal['pukul']);
                        if ($current_slot_datetime < $jadwal_awal_datetime) {
                            throw new Exception("Tanggal dan pukul " . htmlspecialchars($jenis_jadwal) . " tidak boleh sebelum 'Jadwal Awal'.");
                        }
                    } else if (!$stmt_get_awal && $jenis_jadwal !== 'Jadwal Awal') {
                        throw new Exception("Anda harus membuat 'Jadwal Awal' terlebih dahulu.");
                    }
                }
            }

            if ($jenis_jadwal === 'Jadwal Akhir') {
                $stmt_get_latest_wawancara = $pdo->query("SELECT tanggal, pukul FROM slot_jadwal WHERE jenis_jadwal = 'Jadwal Wawancara' AND id != $id ORDER BY tanggal DESC, pukul DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                $stmt_get_latest_istirahat = $pdo->query("SELECT tanggal, pukul FROM slot_jadwal WHERE jenis_jadwal = 'Jadwal Istirahat' AND id != $id ORDER BY tanggal DESC, pukul DESC LIMIT 1")->fetch(PDO::FETCH_ASSOC);
                
                $latest_preceding_datetime = null;
                if ($stmt_get_latest_wawancara) {
                    $latest_preceding_datetime = new DateTime($stmt_get_latest_wawancara['tanggal'] . ' ' . $stmt_get_latest_wawancara['pukul']);
                }
                if ($stmt_get_latest_istirahat) {
                    $istirahat_datetime = new DateTime($stmt_get_latest_istirahat['tanggal'] . ' ' . $stmt_get_latest_istirahat['pukul']);
                    if ($latest_preceding_datetime === null || $istirahat_datetime > $latest_preceding_datetime) {
                        $latest_preceding_datetime = $istirahat_datetime;
                    }
                }

                if ($latest_preceding_datetime && $current_slot_datetime < $latest_preceding_datetime) {
                    throw new Exception("Tanggal dan pukul 'Jadwal Akhir' tidak boleh sebelum 'Jadwal Wawancara' atau 'Jadwal Istirahat' terakhir.");
                }
            }

            $stmt = $pdo->prepare("UPDATE slot_jadwal SET jenis_jadwal = ?, tanggal = ?, pukul = ?, status = ? WHERE id = ?");
            $stmt->execute([$jenis_jadwal, $tanggal, $pukul, $status, $id]);

            $stmt = $pdo->prepare("SELECT * FROM slot_jadwal WHERE id = ?");
            $stmt->execute([$id]);
            $updated_slot = $stmt->fetch(PDO::FETCH_ASSOC);

            $response = ['status' => 'success', 'message' => 'Slot jadwal berhasil diperbarui.', 'data' => $updated_slot];

        } elseif ($action === 'delete') {
            $id = $_POST['id'] ?? 0;
            if (empty($id)) {
                throw new Exception('ID harus diisi untuk penghapusan.');
            }
            $stmt = $pdo->prepare("DELETE FROM slot_jadwal WHERE id = ?");
            $stmt->execute([$id]);
            $response = ['status' => 'success', 'message' => 'Slot jadwal berhasil dihapus.'];
        } else {
            throw new Exception('Aksi tidak valid.');
        }
    } else {
        throw new Exception('Metode permintaan tidak didukung.');
    }
} catch (PDOException $e) {
    if ($e->getCode() == 23000) {
        $response['message'] = 'Gagal: Tanggal dan Pukul slot ini sudah ada.';
    } else {
        $response['message'] = 'Database Error: ' . $e->getMessage();
    }
    error_log("Slot Jadwal Handler Error: " . $response['message']);
} catch (Exception $e) {
    $response['message'] = $e->getMessage();
}

echo json_encode($response);
exit;