<?php
session_start();
require_once '../../db.php';

$pageTitle = "Dashboard";
$currentPage = "dashboard";

try {
    $pdo = get_pdo_connection();
    $pendaftar_count = $pdo->query("SELECT COUNT(*) FROM pendaftaran")->fetchColumn();
    $matkul_count = $pdo->query("SELECT COUNT(*) FROM mata_kuliah WHERE status = 'Aktif'")->fetchColumn();
    $jadwal_today_count = $pdo->query("SELECT COUNT(*) FROM jadwal_wawancara WHERE DATE(hari) = CURDATE()")->fetchColumn(); // Assuming 'hari' can be a DATE/DATETIME
    $recent_matkul = $pdo->query("SELECT * FROM mata_kuliah ORDER BY id DESC LIMIT 3")->fetchAll();
} catch (PDOException $e) {
    $pendaftar_count = 0;
    $matkul_count = 0;
    $jadwal_today_count = 0;
    $recent_matkul = [];
    error_log("Dashboard fetch error: " . $e->getMessage());
}

require __DIR__ . '/components/html_head.php';
?>

<body class="bg-primary text-gray-300">
    <?php require __DIR__ . '/components/admin_header.php'; ?>
    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]">
        <?php require __DIR__ . '/components/admin_sidebar.php'; ?>
        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg min-h-full">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-6">Dashboard</h1>
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 mb-8">
                    <div class="bg-gray-700/50 p-6 rounded-xl border border-gray-600">
                        <p class="text-sm text-gray-400">Total Pendaftar</p>
                        <h3 class="text-2xl font-semibold text-gray-100 mt-1"><?= $pendaftar_count ?></h3>
                    </div>
                    <div class="bg-gray-700/50 p-6 rounded-xl border border-gray-600">
                        <p class="text-sm text-gray-400">Mata Kuliah Dibuka</p>
                        <h3 class="text-2xl font-semibold text-gray-100 mt-1"><?= $matkul_count ?></h3>
                    </div>
                     <div class="bg-gray-700/50 p-6 rounded-xl border border-gray-600">
                        <p class="text-sm text-gray-400">Wawancara Hari Ini</p>
                        <h3 class="text-2xl font-semibold text-gray-100 mt-1"><?= $jadwal_today_count ?></h3>
                    </div>
                </div>

                <div class="bg-gray-700/50 rounded-xl border border-gray-600 overflow-hidden">
                    <div class="p-4 border-b border-gray-600">
                        <h2 class="text-lg font-semibold text-gray-100">Mata Kuliah Terbaru</h2>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full min-w-[800px]">
                            <thead class="bg-gray-700/50">
                                <tr>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-left">Kode & Nama</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-left">Dosen</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-left">Kuota</th>
                                    <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-left">Status</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-700">
                                <?php if(empty($recent_matkul)): ?>
                                    <tr><td colspan="4" class="text-center p-4 text-gray-500">Belum ada mata kuliah.</td></tr>
                                <?php else: ?>
                                    <?php foreach ($recent_matkul as $mk): ?>
                                    <tr>
                                        <td class="px-6 py-4">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-100"><?= htmlspecialchars($mk['kode']) ?></div>
                                                <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($mk['nama']) ?></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-300"><?= htmlspecialchars($mk['dosen']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-300"><?= htmlspecialchars($mk['kuota']) ?></td>
                                        <td class="px-6 py-4">
                                            <?php $status_color = $mk['status'] == 'Aktif' ? 'text-green-400 bg-green-500/20' : 'text-red-400 bg-red-500/20'; ?>
                                            <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $status_color ?>"><?= htmlspecialchars($mk['status']) ?></span>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </main>
    </div>
    <?php require __DIR__ . '/components/footer_scripts.php'; ?>
</body>
</html>