<?php
session_start();
require_once '../../db.php';
require __DIR__ . '/components/html_head.php'; 
$pageTitle = "Data Pendaftar";
$currentPage = "pendaftar";

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->query("SELECT p.*, 
                                a.nama, p.status
                                FROM pendaftaran p 
                                JOIN asdos a 
                                ON p.npm = a.npm 
                                ORDER BY p.id_pendaftaran 
                                DESC");
    $pendaftar_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $pendaftar_list = [];
    error_log("Failed to fetch pendaftar: " . $e->getMessage());
}

?>

<body class="bg-primary text-gray-300">
    <?php require __DIR__ . '/components/admin_header.php'; ?>
    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]">
        <?php require __DIR__ . '/components/admin_sidebar.php'; ?>
        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg min-h-full">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-6">Data Pendaftar</h1>
                
                <div class="overflow-x-auto rounded-lg shadow-md border border-gray-700">
                    <table class="w-full min-w-[600px]" id="tabel-pendaftar">
                        <thead class="bg-gray-700/50">
                            <tr class="text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Nama & NPM</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Kontak (WA)</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Matkul 1</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Matkul 2</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Kebersediaan</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Pengalaman</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php if (empty($pendaftar_list)): ?>
                                <tr id="no-results-pendaftar">
                                    <td colspan="8" class="px-6 py-12 text-center text-gray-500 align-middle" style="vertical-align: middle; height: 300px;">
                                        <div class="flex flex-col items-center justify-center h-full w-full">
                                            <span class="block text-center w-full">Tidak ada data pendaftar.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php else: ?>
                                <?php foreach ($pendaftar_list as $pendaftar): ?>
                                    <tr data-id="<?= $pendaftar['id_pendaftaran'] ?>">
                                        <td class="px-6 py-4 align-top">
                                            <div>
                                                <div class="text-sm font-semibold text-gray-100"><?= htmlspecialchars($pendaftar['nama']) ?></div>
                                                <div class="text-xs text-gray-400 mt-0.5">NPM: <?= htmlspecialchars($pendaftar['npm']) ?></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm text-gray-300 align-top"><?= htmlspecialchars($pendaftar['wa']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-300 align-top"><?= htmlspecialchars($pendaftar['matkul1']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-300 align-top"><?= htmlspecialchars($pendaftar['matkul2']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-300 align-top"><?= htmlspecialchars($pendaftar['kebersediaan']) ?></td>
                                        <td class="px-6 py-4 text-sm text-gray-300 align-top"><?= htmlspecialchars($pendaftar['pengalaman']) ?></td>
                                        <td class="px-6 py-4 align-top">
                                            <select name="status" class="status-select bg-gray-700 border border-gray-600 text-gray-200 rounded-lg text-xs p-1">
                                                <option value="Dalam Review" <?= $pendaftar['status'] == 'Dalam Review' ? 'selected' : '' ?>>Dalam Review</option>
                                                <option value="Diterima" <?= $pendaftar['status'] == 'Diterima' ? 'selected' : '' ?>>Diterima</option>
                                                <option value="Ditolak" <?= $pendaftar['status'] == 'Ditolak' ? 'selected' : '' ?>>Ditolak</option>
                                            </select>
                                        </td>
                                        <td class="px-6 py-4 align-top text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <a href="<?= BASE_URL . '/uploads/' . htmlspecialchars($pendaftar['file']) ?>" target="_blank" title="Lihat Berkas" class="text-gray-300 hover:text-secondary p-1.5"><i class="ri-file-text-line ri-lg"></i></a>
                                                <button title="Hapus Pendaftar" class="text-gray-300 hover:text-red-400 p-1.5 btn-hapus-pendaftar"><i class="ri-delete-bin-line ri-lg"></i></button>
                                            </div>
                                        </td>
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
    <script src="js/pendaftarManager.js"></script>
</body>
</html>