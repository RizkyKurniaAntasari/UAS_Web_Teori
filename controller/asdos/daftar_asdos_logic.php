<?php
session_start();
require_once '../../db.php';

if (!isset($_SESSION['user'])) {
    exit('Sesi tidak valid. Silakan login kembali.');
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['simpan'])) {
    header('Location: ../../views/asdos/daftar_asdos.php');
    exit;
}

$npm = $_SESSION['user'];
$wa = $_POST['wa'] ?? '';
$matkul1 = $_POST['matkul1'] ?? '';
$matkul2 = $_POST['matkul2'] ?? '';
$alasan = $_POST['alasan'] ?? '';
$kebersediaan = $_POST['kebersediaan'] ?? 'Tidak Bersedia';
$pengalaman = $_POST['pengalaman'] ?? 'Belum Pernah';
$prioritas = $_POST['prioritas'] ?? 'Tidak Bersedia';

if (empty($wa) || empty($matkul1) || empty($matkul2) || empty($alasan) || empty($_FILES['file']['name'])) {
    exit('Semua field wajib diisi.');
}

if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    $file_tmp_path = $_FILES['file']['tmp_name'];
    $file_name = $_FILES['file']['name'];
    $file_size = $_FILES['file']['size'];
    $file_type = $_FILES['file']['type'];
    $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_ext = 'pdf';
    $max_file_size = 5 * 1024 * 1024; // 5 MB

    if ($file_ext !== $allowed_ext) {
        exit('Error: Hanya file PDF yang diizinkan.');
    }
    if ($file_size > $max_file_size) {
        exit('Error: Ukuran file maksimal adalah 5 MB.');
    }

    $upload_dir = '../../uploads/';
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0755, true);
    }
    $sanitized_name = preg_replace('/[^a-zA-Z0-9-_\.]/', '', basename($file_name));
    $file_for_db = uniqid($npm . '_', true) . '.' . $file_ext;
    $dest_path = $upload_dir . $file_for_db;

    if (move_uploaded_file($file_tmp_path, $dest_path)) {
        try {
            $pdo = get_pdo_connection();
            $stmt_check = $pdo->prepare("SELECT COUNT(*) FROM pendaftaran WHERE npm = ?");
            $stmt_check->execute([$npm]);
            if ($stmt_check->fetchColumn() > 0) {
                 exit('Anda sudah pernah mendaftar.');
            }

            $sql = "INSERT INTO pendaftaran (npm, wa, matkul1, matkul2, alasan, kebersediaan, pengalaman, prioritas, file)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([$npm, $wa, $matkul1, $matkul2, $alasan, $kebersediaan, $pengalaman, $prioritas, $file_for_db]);
            
            echo "<script>alert('Pendaftaran berhasil!'); window.location.href='../../views/asdos/index.php';</script>";

        } catch (PDOException $e) {
            unlink($dest_path);
            error_log('Database Error: ' . $e->getMessage());
            exit('Gagal menyimpan data ke database.');
        }
    } else {
        exit('Gagal memindahkan file yang diunggah.');
    }
} else {
    exit('Terjadi kesalahan saat mengunggah file. Kode: ' . $_FILES['file']['error']);
}
?>