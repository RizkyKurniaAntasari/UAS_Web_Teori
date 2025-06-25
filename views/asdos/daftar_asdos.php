<?php
$currentPage = basename($_SERVER['PHP_SELF']);
session_start(); // Mulai sesi jika belum dimulai
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
require_once '../../db.php'; // Sesuaikan path sesuai struktur proyek Anda

$user_data = ['nama' => '', 'npm' => ''];
$pendaftaran_data = [];
$is_submitted = false;
$disabled = '';
$available_courses = [];

// Nilai default untuk field form jika belum submit atau user belum login
$nama = '';
$npm = '';
$wa = '';
$matkul1 = '';
$matkul2 = '';
$alasan = '';
$kebersediaan = '';
$pengalaman = '';
$prioritas = '';
$file_uploaded = ''; // Untuk menyimpan nama file jika sudah diupload
$keterangan = '';
// var_dump($_SESSION);
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
    $pdo = get_pdo_connection();

    // Ambil data dasar user (nama, npm)
    $stmt = $pdo->prepare("SELECT nama, npm FROM asdos WHERE npm = ? LIMIT 1");
    $stmt->execute([$user_id]);
    // var_dump($stmt);
    $user_data = $stmt->fetch(PDO::FETCH_ASSOC);
    // var_dump($user_data);

    if ($user_data) {
        $nama = $user_data['nama'];
        $npm = $user_data['npm'];
    }

    // Ambil data pendaftaran yang sudah ada
    $stmt = $pdo->prepare("SELECT * FROM pendaftaran WHERE npm = ? LIMIT 1");
    $stmt->execute([$user_id]);
    $pendaftaran_data = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($pendaftaran_data) {
        $is_submitted = true;
        $disabled = 'disabled'; // Nonaktifkan field form
        // Isi field form dengan data yang sudah disubmit
        $wa = $pendaftaran_data['wa'];
        $matkul1 = $pendaftaran_data['matkul1'];
        $matkul2 = $pendaftaran_data['matkul2'];
        $alasan = $pendaftaran_data['alasan'];
        $kebersediaan = $pendaftaran_data['kebersediaan'];
        $pengalaman = $pendaftaran_data['pengalaman'];
        $prioritas = $pendaftaran_data['prioritas'];
        $keterangan = $pendaftaran_data['keterangan'];
        $file_uploaded = $pendaftaran_data['file']; // Ambil nama file yang sudah diupload
    }
    
    // Ambil semua nama mata kuliah yang aktif
    $stmt_courses = $pdo->query("SELECT nama FROM mata_kuliah WHERE status = 'Aktif' ORDER BY nama");
    $raw_courses = $stmt_courses->fetchAll(PDO::FETCH_COLUMN);

    // Proses agar nama mata kuliah unik tanpa memperhatikan kapital
    $seen_courses = [];
    foreach ($raw_courses as $course) {
        $lower_course = strtolower($course);
        if (!isset($seen_courses[$lower_course])) {
            $seen_courses[$lower_course] = $course;
        }
    }
    $available_courses = array_values($seen_courses);
    sort($available_courses);
} else {
    header('Location: ../../login.php'); 
    exit();
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

<body class="bg-gray-100 flex flex-col min-h-screen">
    <section class="p-8 max-w-4xl mx-auto bg-white shadow-md rounded-md mb-10 mt-8 flex-grow w-full">
        <h2 class="text-center text-3xl font-bold text-black mb-10">Form Pendaftaran Asisten Dosen</h2>
        <form action="../../controller/asdos/daftar_asdos_logic.php" method="POST" enctype="multipart/form-data" class="space-y-5" autocomplete="off">

            <div>
                <label class="block font-bold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($nama) ?>" readonly
                    class="w-full border bg-gray-200 border-gray-400 rounded px-4 py-2">
            </div>

            <div>
                <label class="block font-bold mb-1">NPM</label>
                <input type="text" name="npm" value="<?= htmlspecialchars($npm) ?>" readonly
                    class="w-full border bg-gray-200 border-gray-400 rounded px-4 py-2">
            </div>

            <div>
                <label class="block font-bold mb-1">No. Whatsapp</label>
                <input type="tel" name="wa" required <?= $disabled ?> value="<?= htmlspecialchars($wa) ?>"
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
            </div>

            <div>
                <label class="block font-bold mb-1">Mata Kuliah Pilihan 1</label>
                <select name="matkul1" required <?= $disabled ?>
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= empty($matkul1) ? 'selected' : '' ?>>Pilih Mata Kuliah</option>
                    <?php foreach ($available_courses as $course): ?>
                        <option <?= $matkul1 == $course ? 'selected' : '' ?>><?= htmlspecialchars($course) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block font-bold mb-1">Mata Kuliah Pilihan 2</label>
                <select name="matkul2" required <?= $disabled ?>
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= empty($matkul2) ? 'selected' : '' ?>>Pilih Mata Kuliah</option>
                    <?php foreach ($available_courses as $course): ?>
                        <option <?= $matkul2 == $course ? 'selected' : '' ?>><?= htmlspecialchars($course) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <input type="hidden" name="kebersediaan" value="Bersedia">

            <div>
                <label class="block font-bold mb-1">Alasan Mendaftar</label>
                <textarea name="alasan" rows="4" required <?= $disabled ?>
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]"
                    placeholder="Tuliskan alasan Anda ingin menjadi asisten dosen"><?= htmlspecialchars($alasan) ?></textarea>
            </div>
            <div>
                <label class="block font-bold mb-1">Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="4" <?= $disabled ?>
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]"
                    placeholder="Tuliskan keterangan tambahan"><?= htmlspecialchars($keterangan) ?></textarea>
            </div>

            <div>
                <label class="block font-bold mb-1">Apakah Anda sudah pernah menjadi asdos?</label>
                <select name="pengalaman" required <?= $disabled ?>
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= empty($pengalaman) ? 'selected' : '' ?>>Pilih Jawaban</option>
                    <option <?= $pengalaman == 'Sudah Pernah' ? 'selected' : '' ?>>Sudah Pernah</option>
                    <option <?= $pengalaman == 'Belum Pernah' ? 'selected' : '' ?>>Belum Pernah</option>
                </select>
            </div>

            <div>
                <label class="block font-bold mb-1">Apakah Anda bersedia ditempatkan pada mata kuliah selain yang dipilih</label>
                <select name="prioritas" required <?= $disabled ?>
                    class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= empty($prioritas) ? 'selected' : '' ?>>Pilih Jawaban</option>
                    <option <?= $prioritas == 'Bersedia' ? 'selected' : '' ?>>Bersedia</option>
                    <option <?= $prioritas == 'Tidak Bersedia' ? 'selected' : '' ?>>Tidak Bersedia</option>
                </select>
            </div>

            <div>
                <label class="block font-bold mb-1">Upload Surat Pernyataan<a class="text-underline underline underline-offset-4 text-blue-600" href="https://docs.google.com/document/d/13sA5RUgaHtU7RrfY6cQAReyO4-tckxa7/edit?usp=sharing&ouid=109242753190899151626&rtpof=true&sd=true" target="_blank">(Unduh disini)</a></label>
                <?php if ($is_submitted && !empty($file_uploaded)): ?>
                    <p class="mb-2">File yang sudah diunggah: <a href="<?= '../../uploads/' . htmlspecialchars($file_uploaded) ?>" target="_blank" class="text-blue-600 underline">Lihat File</a></p>
                    <input type="file" name="file" <?= $disabled ?> accept=".pdf" class="w-full border border-gray-400 rounded px-4 py-2">
                    <p class="text-sm text-gray-500 mt-1">Anda tidak dapat mengubah file setelah pendaftaran.</p>
                <?php else: ?>
                    <input type="file" name="file" required accept=".pdf" class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                <?php endif; ?>
            </div>

            <?php if (!$is_submitted): ?>
                <div class="text-right">
                    <button type="submit" name="simpan" class="bg-[#ffcc00] hover:bg-yellow-500 text-black font-bold py-2 px-6 rounded shadow">Kirim</button>
                </div>
            <?php else: ?>
                <p class="text-red-600 font-semibold text-center">Anda sudah mendaftar. Data tidak dapat diubah.</p>
            <?php endif; ?>

        </form>
    </section>
    
    <?php require_once '../head-nav-foo/footer.php';?>
    
</body>

</html>