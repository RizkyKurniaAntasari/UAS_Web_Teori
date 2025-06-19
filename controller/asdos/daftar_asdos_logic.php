<?php
session_start();
require_once '../../db.php';
// Cek apakah user sudah login
if (!isset($_SESSION['user'])) {
    echo "<script>
        alert('Silakan login terlebih dahulu!');
        window.location = '../../login.php';
    </script>";
    exit;
}

if (isset($_POST['simpan'])) {
    $npm          = $_SESSION['user']; // Ambil dari session, bukan dari POST (lebih aman)
    $wa           = $_POST['wa'];
    $matkul1      = $_POST['matkul1'];
    $matkul2      = $_POST['matkul2'];
    $alasan       = $_POST['alasan'];
    $kebersediaan = $_POST['kebersediaan'];
    $pengalaman   = $_POST['pengalaman'];
    $prioritas    = $_POST['prioritas'];

    // File upload
    $file_name  = $_FILES['file']['name'];
    $tmp_name   = $_FILES['file']['tmp_name'];
    $upload_dir = '../../uploads/'; // absolute path only, gabisa URL
    $file_path  = $upload_dir . uniqid() . '_' . basename($file_name);

    if (move_uploaded_file($tmp_name, $file_path)) {
        $file_for_db = basename($file_path);
        $sql2 = "INSERT INTO pendaftaran (npm, wa, matkul1, matkul2, alasan, kebersediaan, pengalaman, prioritas, file)
                 VALUES ('$npm', '$wa', '$matkul1', '$matkul2', '$alasan', '$kebersediaan', '$pengalaman', '$prioritas', '$file_for_db')";
        $query2 = mysqli_query($conn, $sql2);

        if ($query2) {
            echo "<script>
                alert('Pendaftaran berhasil!');
                window.location = '../../views/asdos/index.php'; // ganti sesuai halaman selanjutnya
            </script>";
        } else {
            echo "<script>alert('Gagal menyimpan data: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Upload file gagal!');</script>";
    }
}
?>
