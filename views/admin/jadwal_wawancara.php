<?php
session_start();
if ($_SESSION['username'] != 'admin') {
    header("Location: index.php");
    exit;
}
require_once '../../db.php';

$pageTitle = "Jadwal Wawancara";
$currentPage = "jadwal_wawancara";

$selected_date = $_GET['tanggal'] ?? date('Y-m-d');

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->prepare(
        "SELECT j.*, a.nama as nama_asdos 
         FROM jadwal_wawancara j 
         LEFT JOIN asdos a ON j.npm = a.npm
         WHERE j.hari = ? ORDER BY j.jam"
    );
    $stmt->execute([$selected_date]);
    $jadwal_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $jadwal_list = [];
    error_log("Failed to fetch jadwal wawancara: " . $e->getMessage());
}

require __DIR__ . '/components/html_head.php';
?>

<body class="bg-primary text-gray-300">
    <?php require __DIR__ . '/components/admin_header.php'; ?>
    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]">
        <?php require __DIR__ . '/components/admin_sidebar.php'; ?>
        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg min-h-full">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-6">Jadwal Wawancara</h1>
                <form method="GET" class="mb-6">
                    <label for="filter-tanggal" class="block text-sm font-medium text-gray-400 mb-1.5">Pilih Tanggal</label>
                    <div class="flex items-center gap-4">
                        <input type="date" id="filter-tanggal" name="tanggal" value="<?= htmlspecialchars($selected_date) ?>" class="w-full sm:w-auto px-4 py-2.5 bg-gray-700 border border-gray-600 rounded-lg">
                        <button type="submit" class="bg-secondary text-primary px-4 py-2.5 rounded-button font-medium">Filter</button>
                    </div>
                </form>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px]"> 
                        <thead class="bg-gray-700/50">
                            <tr class="text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase">Waktu</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase">Calon Asisten</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase">Keterangan</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php if (empty($jadwal_list)): ?>
                                <tr><td colspan="3" class="px-6 py-12 text-center text-gray-500">Tidak ada jadwal untuk tanggal ini.</td></tr>
                            <?php else: ?>
                                <?php foreach ($jadwal_list as $jadwal): ?>
                                <tr>
                                    <td class="px-6 py-4 font-mono"><?= htmlspecialchars($jadwal['waktu_text']) ?></td>
                                    <td class="px-6 py-4">
                                        <?php if($jadwal['npm']): ?>
                                            <div>
                                                <div class="text-sm font-medium text-gray-100"><?= htmlspecialchars($jadwal['nama_asdos']) ?></div>
                                                <div class="text-xs text-gray-400">NPM: <?= htmlspecialchars($jadwal['npm']) ?></div>
                                            </div>
                                        <?php else: ?>
                                            <span class="text-gray-500">Slot Kosong</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm"><?= htmlspecialchars($jadwal['keterangan']) ?></td>
                                </tr>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div> 
    <?php require __DIR__ . '/components/footer_scripts.php'; ?>
</body>
</html>