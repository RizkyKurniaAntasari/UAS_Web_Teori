<?php
$currentPage = basename($_SERVER['PHP_SELF']);
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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Asisten Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <section class="p-8 max-w-4xl mx-auto bg-white shadow-md rounded-md mb-10 mt-8">
        <h2 class="text-center text-3xl font-bold text-black mb-10  ">Form Pendaftaran Asisten Dosen</h2>
        <form action="../../controller/asdos/daftar_asdos_logic.php" method="POST" enctype="multipart/form-data" class="space-y-5" autocomplete="off">

            <!-- Nama Lengkap -->
            <div>
                <label class="block font-bold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" readonly
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none">
            </div>

            <!-- NPM -->
            <div>
                <label class="block font-bold mb-1">NPM</label>
                <input type="text" name="npm" value="<?= htmlspecialchars($npm) ?>" readonly
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none">
            </div>

            <!-- Handphone -->
            <div>
                <label class="block font-bold mb-1">No. Whatsapp</label>
                <input type="wa" name="wa" required <?= $disabled ?> value="<?= htmlspecialchars($wa) ?>" class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
            </div>

            <!-- Mata Kuliah Pilihan 1 -->
            <div>
                <label class="block font-bold mb-1">Mata Kuliah Pilihan 1</label>
                <select name="matkul1" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= $matkul1 == '' ? 'selected' : '' ?>>Pilih Mata Kuliah</option>
                    <option <?= $matkul1 == 'Algoritma & Struktur Data' ? 'selected' : '' ?>>Algoritma & Struktur Data</option>
                    <option <?= $matkul1 == 'Pemrograman Web' ? 'selected' : '' ?>>Pemrograman Web</option>
                    <option <?= $matkul1 == 'Sistem Operasi' ? 'selected' : '' ?>>Sistem Operasi</option>
                    <option <?= $matkul1 == 'Jaringan Komputer' ? 'selected' : '' ?>>Jaringan Komputer</option>
                    <option <?= $matkul1 == 'Pemrograman Berorientasi Objek' ? 'selected' : '' ?>>Pemrograman Berorientasi Objek</option>
                    <option <?= $matkul1 == 'Basis Data' ? 'selected' : '' ?>>Basis Data</option>
                    <option <?= $matkul1 == 'AI Dasar' ? 'selected' : '' ?>>AI Dasar</option>
                    <option <?= $matkul1 == 'Statistik Komputasi' ? 'selected' : '' ?>>Statistik Komputasi</option>
                </select>
            </div>

            <!-- Mata Kuliah Pilihan 2 -->
            <div>
                <label class="block font-bold mb-1">Mata Kuliah Pilihan 2</label>
                <select name="matkul2" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= $matkul2 == '' ? 'selected' : '' ?>>Pilih Mata Kuliah</option>
                    <option <?= $matkul2 == 'Algoritma & Struktur Data' ? 'selected' : '' ?>>Algoritma & Struktur Data</option>
                    <option <?= $matkul2 == 'Pemrograman Web' ? 'selected' : '' ?>>Pemrograman Web</option>
                    <option <?= $matkul2 == 'Sistem Operasi' ? 'selected' : '' ?>>Sistem Operasi</option>
                    <option <?= $matkul2 == 'Jaringan Komputer' ? 'selected' : '' ?>>Jaringan Komputer</option>
                    <option <?= $matkul2 == 'Pemrograman Berorientasi Objek' ? 'selected' : '' ?>>Pemrograman Berorientasi Objek</option>
                    <option <?= $matkul2 == 'Basis Data' ? 'selected' : '' ?>>Basis Data</option>
                    <option <?= $matkul2 == 'AI Dasar' ? 'selected' : '' ?>>AI Dasar</option>
                    <option <?= $matkul2 == 'Statistik Komputasi' ? 'selected' : '' ?>>Statistik Komputasi</option>
                </select>
            </div>

            <!-- Alasan -->
            <div>
                <textarea name="alasan" rows="4" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4
                    py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]"
                    placeholder="Tuliskan alasan Anda ingin menjadi asisten dosen"><?= htmlspecialchars($alasan) ?></textarea>
            </div>

            <!-- KEBERSEDIAAN -->
            <div>
                <label class="block font-bold mb-1">Apakah Anda besedia menjadi asdos di 2 mata kuliah?</label>
                <select name="kebersediaan" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= $kebersediaan == '' ? 'selected' : '' ?>>Pilih Jawaban</option>
                    <option <?= $kebersediaan == 'Bersedia' ? 'selected' : '' ?>>Bersedia</option>
                    <option <?= $kebersediaan == 'Tidak Bersedia' ? 'selected' : '' ?>>Tidak Bersedia</option>
                </select>
            </div>

            <!-- PENGALAMAN JADI ASDOS -->
            <div>
                <label class="block font-bold mb-1">Apakah Anda sudah pernah menjadi asdos?</label>
                <select name="pengalaman" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= $pengalaman == '' ? 'selected' : '' ?>>Pilih Jawaban</option>
                    <option <?= $pengalaman == 'Sudah Pernah' ? 'selected' : '' ?>>Sudah Pernah</option>
                    <option <?= $pengalaman ==  'Belum Pernah' ? 'selected' : '' ?>>Belum Pernah</option>
                </select>
            </div>

            <!--  BUKAN PRIORITAS -->
            <div>
                <label class="block font-bold mb-1">Apakah Anda bersedia ditempatkan pada mata kuliah selain yang dipilih</label>
                <select name="prioritas" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled selected <?= $prioritas == '' ? 'selected' : '' ?>>Pilih Jawaban</option>
                    <option <?= $prioritas == 'Bersedia' ? 'selected' : '' ?>>Bersedia</option>
                    <option <?= $prioritas == 'Tidak Bersedia' ? 'selected' : '' ?>>Tidak Bersedia</option>
                </select>
            </div>

            <!-- Upload Surat Pernyataan -->
            <div>
                <label class="block font-bold mb-1">Upload Surat Pernyataan<a class="text-underline underline underline-offset-4 text-blue-600" href="https://docs.google.com/document/d/13sA5RUgaHtU7RrfY6cQAReyO4-tckxa7/edit?usp=sharing&ouid=109242753190899151626&rtpof=true&sd=true" target="_blank">(Unduh disini)</a></label>
                <input type="file" name="file" <?= $disabled ?> accept=".pdf,.doc,.docx" class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
            </div>

            <!-- Tombol Submit -->
            <?php if (!$is_submitted): ?>
                <div class="text-right">
                    <button type="submit" name="simpan" class="bg-[#ffcc00] hover:bg-[#ffcc00] text-black font-bold py-2 px-6 rounded shadow">Kirim</button>
                </div>
            <?php else: ?>
                <p class="text-red-600 font-semibold text-center">Anda sudah pernah mendaftar. Data tidak dapat diubah kembali.</p>
            <?php endif; ?>

        </form>
    </section>
    <?php
    require_once '../head-nav-foo/footer.php';
    ?>
</body>

</html>