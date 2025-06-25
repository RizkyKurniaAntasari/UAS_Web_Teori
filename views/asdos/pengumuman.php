<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
require_once '../../db.php';

$hasil_seleksi_grouped = [];

try {
    $pdo = get_pdo_connection();

    // Gabungkan hasil_seleksi dengan mata_kuliah
    $stmt = $pdo->query("
        SELECT hs.npm, hs.nama_mahasiswa, hs.peran, hs.kelas_pj,
               hs.semester_mk, mk.nama AS mata_kuliah
        FROM hasil_seleksi hs
        JOIN mata_kuliah mk ON hs.id_mata_kuliah = mk.id
        ORDER BY hs.semester_mk ASC, mk.nama ASC, hs.peran DESC
    ");
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        $semester_key = 'Semester ' . $row['semester_mk'];
        $matkul_key = $row['mata_kuliah'];
        $hasil_seleksi_grouped[$semester_key][$matkul_key][] = [
            'npm' => $row['npm'],
            'nama' => $row['nama_mahasiswa'],
            'kelas' => $row['kelas_pj'],
            'peran' => $row['peran']
        ];
    }
} catch (PDOException $e) {
    error_log("Error saat mengambil data pengumuman: " . $e->getMessage());
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Hasil Seleksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">
    <?php render_header(); ?>
    <?php render_navbar($currentPage); ?>
    <div class="px-10 py-6 flex flex-col flex-grow">
        <h1 class="text-3xl font-bold mb-8 pt-3 text-center text-gray-800">Selamat & Sukses Asisten Dosen Baru!</h1>

        <?php if (empty($hasil_seleksi_grouped)): ?>
            <p class="text-center text-gray-600">Hasil seleksi belum tersedia.</p>
        <?php else: ?>
            <?php foreach ($hasil_seleksi_grouped as $semester => $matkul_list): ?>
                <div class="mb-8">
                    <h2 class="text-2xl font-semibold text-gray-700 mb-4"><?= htmlspecialchars($semester) ?></h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <?php foreach ($matkul_list as $matkul => $mahasiswa_list): ?>
                            <div class="bg-white shadow-md rounded-lg overflow-hidden">
                                <div class="bg-[#ffffff] text-black px-4 mt-4 text-lg font-semibold">
                                    <?= htmlspecialchars($matkul) ?>
                                </div>
                                <div class="p-4 overflow-x-auto">
                                    <table class="min-w-full border border-black text-sm">
                                        <thead class="bg-yellow-400">
                                            <tr class="text-center">
                                                <th class="px-4 py-2 border border-black">NPM</th>
                                                <th class="px-4 py-2 border border-black">Nama</th>
                                                <th class="px-4 py-2 border border-black">PJ Kelas</th>
                                                <th class="px-4 py-2 border border-black">Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($mahasiswa_list as $mhs): ?>
                                                <tr class="hover:bg-gray-50 text-center">
                                                    <td class="px-4 py-2 border border-black"><?= htmlspecialchars($mhs['npm']) ?></td>
                                                    <td class="px-4 py-2 border border-black"><?= htmlspecialchars($mhs['nama']) ?></td>
                                                    <td class="px-4 py-2 border border-black"><?= htmlspecialchars($mhs['kelas']) ?></td>
                                                    <td class="px-4 py-2 border border-black <?= ($mhs['peran'] === 'Koordinator') ? 'font-semibold' : 'font-normal'; ?>"><?= htmlspecialchars($mhs['peran']) ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <?php include_once '../head-nav-foo/footer.php'; ?>
</body>
</html>
