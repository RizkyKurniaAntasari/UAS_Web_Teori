<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
require_once '../../db.php';

$user_data = ['nama' => '', 'npm' => ''];
$pendaftaran_data = [];
$is_submitted = false;
$disabled = '';
$available_courses = []; // This will hold the processed, unique course names

if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
    $pdo = get_pdo_connection();

    $stmt = $pdo->prepare("SELECT nama, npm FROM asdos WHERE npm = ? LIMIT 1");
    $stmt->execute([$user_id]);
    $user_data = $stmt->fetch();

    $stmt = $pdo->prepare("SELECT * FROM pendaftaran WHERE npm = ? LIMIT 1");
    $stmt->execute([$user_id]);
    $pendaftaran_data = $stmt->fetch();

    if ($pendaftaran_data) {
        $is_submitted = true;
        $disabled = 'disabled';
    }
    
    // Fetch all active course names
    $stmt_courses = $pdo->query("SELECT nama FROM mata_kuliah WHERE status = 'Aktif' ORDER BY nama");
    $raw_courses = $stmt_courses->fetchAll(PDO::FETCH_COLUMN);

    // Process raw courses to ensure case-insensitive uniqueness
    $seen_courses = [];
    foreach ($raw_courses as $course) {
        $lower_course = strtolower($course);
        if (!isset($seen_courses[$lower_course])) {
            $seen_courses[$lower_course] = $course; // Store the original casing of the first encountered unique course
        }
    }
    $available_courses = array_values($seen_courses); // Get only the unique course names (with their first encountered casing)
    sort($available_courses); // Keep them sorted alphabetically
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
        <h2 class="text-center text-3xl font-bold text-black mb-10">Form Pendaftaran Asisten Dosen</h2>
        <form action="../../controller/asdos/daftar_asdos_logic.php" method="POST" enctype="multipart/form-data" class="space-y-5" autocomplete="off">
            <div>
                <label class="block font-bold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" value="<?= htmlspecialchars($user_data['nama']) ?>" readonly class="w-full border bg-gray-200 border-gray-400 rounded px-4 py-2">
            </div>
            <div>
                <label class="block font-bold mb-1">NPM</label>
                <input type="text" name="npm" value="<?= htmlspecialchars($user_data['npm']) ?>" readonly class="w-full border bg-gray-200 border-gray-400 rounded px-4 py-2">
            </div>
            <div>
                <label class="block font-bold mb-1">No. Whatsapp</labeL>
                <input type="tel" name="wa" required <?= $disabled ?> value="<?= htmlspecialchars($pendaftaran_data['wa'] ?? '') ?>" class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
            </div>
            <div>
                <label class="block font-bold mb-1">Mata Kuliah Pilihan 1</label>
                <select name="matkul1" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= empty($pendaftaran_data['matkul1']) ? 'selected' : '' ?>>Pilih Mata Kuliah</option>
                    <?php foreach ($available_courses as $course): ?>
                        <option <?= ($pendaftaran_data['matkul1'] ?? '') == $course ? 'selected' : '' ?>><?= htmlspecialchars($course) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block font-bold mb-1">Mata Kuliah Pilihan 2</label>
                <select name="matkul2" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled <?= empty($pendaftaran_data['matkul2']) ? 'selected' : '' ?>>Pilih Mata Kuliah</option>
                    <?php foreach ($available_courses as $course): ?>
                        <option <?= ($pendaftaran_data['matkul2'] ?? '') == $course ? 'selected' : '' ?>><?= htmlspecialchars($course) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div>
                <label class="block font-bold mb-1">Alasan Mendaftar</label>
                <textarea name="alasan" rows="4" required <?= $disabled ?> class="w-full border border-gray-400 rounded px-4 py-2" placeholder="Tuliskan alasan Anda ingin menjadi asisten dosen"><?= htmlspecialchars($pendaftaran_data['alasan'] ?? '') ?></textarea>
            </div>
            <div>
                <label class="block font-bold mb-1">Upload Surat Pernyataan</label>
                <?php if ($is_submitted): ?>
                    <a href="<?= BASE_URL . '/uploads/' . htmlspecialchars($pendaftaran_data['file']) ?>" target="_blank" class="text-blue-600 underline">Lihat File Terunggah</a>
                <?php else: ?>
                    <input type="file" name="file" required accept=".pdf" class="w-full border border-gray-400 rounded px-4 py-2">
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
    <?php require_once '../head-nav-foo/footer.php'; ?>
</body>
</html>