<?php
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
require_once '../../db.php';

$nama = '';
$npm = '';
$wa = '';
$matkul1 = '';
$matkul2 = '';
$alasan = '';
$kebersediaan = '';
$pengalaman = '';
$prioritas = '';
$is_submitted = false;
$disabled = ''; // Default: tombol aktif

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];

    // Ambil data user dari tabel asdos
    $query = "SELECT nama, npm FROM asdos WHERE npm = $user_id LIMIT 1";
    $result = mysqli_query($conn, $query);
    if ($result && mysqli_num_rows($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $nama = $row['nama'];
        $npm = $row['npm'];
    }

    // Ambil data pendaftaran jika sudah ada
    $pendaftaranQuery = "SELECT * FROM pendaftaran WHERE npm = $user_id LIMIT 1";
    $pendaftaranResult = mysqli_query($conn, $pendaftaranQuery);
    if ($pendaftaranResult && mysqli_num_rows($pendaftaranResult) === 1) {
        $pendaftaranData = mysqli_fetch_assoc($pendaftaranResult);
        $wa = $pendaftaranData['wa'];
        $matkul1 = $pendaftaranData['matkul1'];
        $matkul2 = $pendaftaranData['matkul2'];
        $alasan = $pendaftaranData['alasan'];
        $kebersediaan = $pendaftaranData['kebersediaan'];
        $pengalaman = $pendaftaranData['pengalaman'];
        $prioritas = $pendaftaranData['prioritas'];
    }

    // Cek apakah user sudah pernah mendaftar
    $cekQuery = "SELECT COUNT(*) as total FROM pendaftaran WHERE npm = $user_id";
    $cekResult = mysqli_query($conn, $cekQuery);
    if ($cekResult) {
        $cekData = mysqli_fetch_assoc($cekResult);
        if ($cekData['total'] > 0) {
            $is_submitted = true;
            $disabled = 'disabled';
        }
    }
}
?>