<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
require_once '../../db.php';

$hasil_seleksi_grouped = [];

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->query("SELECT * FROM hasil_seleksi ORDER BY semester_mk, mata_kuliah, peran DESC");
    $results = $stmt->fetchAll();

    foreach ($results as $row) {
        $semester_key = 'Semester ' . $row['semester_mk'];
        $matkul_key = $row['mata_kuliah'];
        $hasil_seleksi_grouped[$semester_key][$matkul_key][] = [
            'npm' => $row['npm'],
            'nama' => $row['nama_mahasiswa'],
            'Keterangan' => $row['peran'],
            'kelas' => $row['kelas_pj']
        ];
    }
} catch (PDOException $e) {
    error_log("Pengumuman fetch error: " . $e->getMessage());
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengumuman Hasil Seleksi</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="px-10 py-6 flex flex-col flex-grow">
        <h1 class="text-3xl font-bold mb-8 pt-3 text-center text-gray-800">Selamat & Sukses Asisten Dosen Baru!</h1>

        <?php if (empty($hasil_seleksi_grouped)): ?>
            <p class="text-center text-gray-600">Hasil seleksi belum tersedia.</p>
        <?php else: ?>
            <?php foreach ($hasil_seleksi_grouped as $semester => $matkul_list): ?>
                <div class='mb-8'>
                    <h2 class='text-2xl font-semibold text-gray-700 mb-4'><?= htmlspecialchars($semester) ?></h2>
                    <div class='grid grid-cols-1 md:grid-cols-2 gap-6'>
                        <?php foreach ($matkul_list as $matkul => $mahasiswa_list): ?>
                            <div class='bg-white shadow-md rounded-lg overflow-hidden'>
                                <div class='bg-black text-white px-4 py-2 text-lg font-semibold'><?= htmlspecialchars($matkul) ?></div>
                                <div class='p-4 overflow-x-auto'>
                                    <table class='min-w-full border border-gray-200 text-sm'>
                                        <thead class='bg-[#ffcc00]'>
                                            <tr class='text-center'>
                                                <th class='px-4 py-2 border-b'>NPM</th>
                                                <th class='px-4 py-2 border-b'>Nama</th>
                                                <th class='px-4 py-2 border-b'>PJ Kelas</th>
                                                <th class='px-4 py-2 border-b'>Keterangan</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($mahasiswa_list as $mhs): ?>
                                                <tr class='hover:bg-gray-50 text-center'>
                                                    <td class='px-4 py-2 border-b'><?= htmlspecialchars($mhs['npm']) ?></td>
                                                    <td class='px-4 py-2 border-b'><?= htmlspecialchars($mhs['nama']) ?></td>
                                                    <td class='px-4 py-2 border-b'><?= htmlspecialchars($mhs['kelas']) ?></td>
                                                    <td class='px-4 py-2 border-b'><?= htmlspecialchars($mhs['Keterangan']) ?></td>
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

    <?php require_once '../head-nav-foo/footer.php'; ?>
</body>
</html>