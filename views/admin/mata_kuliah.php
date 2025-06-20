<?php
session_start();
require_once __DIR__ . '/../../db.php';

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pageTitle = "Daftar Mata Kuliah";
$currentPage = "mata_kuliah";

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->query("SELECT * FROM mata_kuliah ORDER BY semester, nama");
    $mata_kuliah_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $mata_kuliah_list = [];
    error_log("Failed to fetch mata kuliah: " . $e->getMessage());
}

require __DIR__ . '/components/html_head.php';
?>
<style type="text/tailwindcss">
    @layer components {
        .form-input-dark {
            @apply w-full py-2 px-4 bg-[#374151] text-[#F3F4F6] border border-transparent rounded-lg leading-tight placeholder-[#9CA3AF] focus:outline-none focus:border-[#FFCC00] focus:ring-1 focus:ring-[#FFCC00] shadow-sm transition-all duration-200;
        }
    }
</style>

<body class="bg-[#111827] text-gray-300">
    <?php require __DIR__ . '/components/admin_header.php'; ?>
    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]">
        <?php require __DIR__ . '/components/admin_sidebar.php'; ?>
        <main class="flex-1 p-6 sm:p-8 bg-[#1F2937] md:ml-64">
            <div class="bg-[#111827] p-6 rounded-xl shadow-lg min-h-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100">Daftar Mata Kuliah</h1>
                    <button id="btn-tambah-mk" class="bg-[#FFCC00] text-gray-900 px-4 py-2 rounded-lg font-semibold flex items-center space-x-2">
                        <i class="ri-add-line"></i>
                        <span>Tambah Mata Kuliah</span>
                    </button>
                </div>

                <div class="overflow-x-auto rounded-lg shadow-md border border-[#374151]">
                    <table class="w-full min-w-[800px]" id="tabel-mk">
                        <thead class="bg-[#374151]/50">
                            <tr class="text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Kode & Nama</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">SKS</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Semester</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Dosen</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Kuota</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#374151]">
                            <?php if (empty($mata_kuliah_list)): ?>
                                <tr id="no-results-mk"><td colspan="7" class="px-6 py-12 text-center text-gray-500">Tidak ada data mata kuliah.</td></tr>
                            <?php else: ?>
                                <?php foreach ($mata_kuliah_list as $mk): ?>
                                    <tr data-id="<?= $mk['id'] ?>">
                                        <td class="px-6 py-4">
                                            <div class="font-semibold"><?= htmlspecialchars($mk['kode']) ?></div>
                                            <div class="text-xs text-gray-400"><?= htmlspecialchars($mk['nama']) ?></div>
                                        </td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($mk['sks']) ?></td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($mk['semester']) ?></td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($mk['dosen']) ?></td>
                                        <td class="px-6 py-4"><?= htmlspecialchars($mk['kuota']) ?></td>
                                        <td class="px-6 py-4">
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $mk['status'] == 'Aktif' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400' ?>"><?= htmlspecialchars($mk['status']) ?></span>
                                        </td>
                                        <td class="px-6 py-4 text-center">
                                            <div class="flex items-center justify-center space-x-2">
                                                <button title="Edit" class="text-gray-400 hover:text-[#FFCC00] p-1.5 btn-edit-mk"><i class="ri-pencil-line ri-lg"></i></button>
                                                <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 btn-hapus-mk"><i class="ri-delete-bin-line ri-lg"></i></button>
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

    <div id="modal-add-edit-mk" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
         <div class="bg-[#1F2937] p-8 rounded-2xl shadow-2xl w-full max-w-3xl border border-[#374151]">
            <div class="flex justify-between items-center mb-6 pb-4 border-b border-[#374151]">
                <h2 id="modal-mk-title" class="text-xl font-semibold text-white">Data Mata Kuliah</h2>
                <button id="btn-close-modal-add-edit" class="text-gray-400 hover:text-white"><i class="ri-close-line ri-xl"></i></button>
            </div>
            <form id="form-add-edit-mk" class="space-y-6">
                <input type="hidden" name="id" id="mk-id">
                <input type="hidden" name="action" id="mk-action">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="mk-kode" class="block text-sm font-medium text-gray-300 mb-2">Kode MK</label>
                        <input type="text" name="kode" id="mk-kode" required class="form-input-dark" placeholder="Contoh: IF123">
                    </div>
                    <div>
                        <label for="mk-nama" class="block text-sm font-medium text-gray-300 mb-2">Nama MK</label>
                        <input type="text" name="nama" id="mk-nama" required class="form-input-dark" placeholder="Contoh: Pemrograman Web">
                    </div>
                    <div>
                        <label for="mk-sks" class="block text-sm font-medium text-gray-300 mb-2">SKS</label>
                        <input type="number" name="sks" id="mk-sks" min="1" max="6" required class="form-input-dark" placeholder="Contoh: 3">
                    </div>
                    <div>
                        <label for="mk-semester" class="block text-sm font-medium text-gray-300 mb-2">Semester</label>
                        <select name="semester" id="mk-semester" required class="form-input-dark">
                            <option value="" disabled selected>Pilih Semester</option>
                            <option value="1">1</option><option value="2">2</option><option value="3">3</option><option value="4">4</option>
                            <option value="5">5</option><option value="6">6</option><option value="7">7</option><option value="8">8</option>
                        </select>
                    </div>
                    <div class="md:col-span-2">
                        <label for="mk-dosen" class="block text-sm font-medium text-gray-300 mb-2">Dosen Pengampu</label>
                        <input type="text" name="dosen" id="mk-dosen" required class="form-input-dark" placeholder="Contoh: Dr. John Doe, M.Kom.">
                    </div>
                    <div>
                        <label for="mk-kuota" class="block text-sm font-medium text-gray-300 mb-2">Kuota Asisten</label>
                        <input type="number" name="kuota" id="mk-kuota" min="1" max="10" required class="form-input-dark" placeholder="Contoh: 2">
                    </div>
                    <div>
                        <label for="mk-status" class="block text-sm font-medium text-gray-300 mb-2">Status</label>
                        <select name="status" id="mk-status" required class="form-input-dark">
                            <option value="Aktif">Aktif</option>
                            <option value="Nonaktif">Nonaktif</option>
                        </select>
                    </div>
                </div>
                <div class="flex justify-end space-x-4 pt-6">
                    <button type="button" id="btn-cancel-modal-add-edit" class="px-6 py-2 rounded-lg text-gray-300 bg-gray-600 hover:bg-gray-700">Batal</button>
                    <button type="submit" id="btn-submit-modal-add-edit" class="bg-[#FFCC00] text-gray-900 font-semibold px-6 py-2 rounded-lg hover:bg-[#FFB100]">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    
    <?php require __DIR__ . '/components/footer_scripts.php'; ?>
    <script src="js/mataKuliahManager.js"></script>
</body>
</html>