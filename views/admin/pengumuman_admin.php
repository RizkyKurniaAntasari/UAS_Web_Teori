<?php
session_start();
require_once __DIR__ . '/../../db.php';

$pageTitle = "Kelola Pengumuman";
$currentPage = "pengumuman";

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->query("SELECT * FROM hasil_seleksi ORDER BY semester_mk, mata_kuliah, peran DESC");
    $hasil_seleksi = $stmt->fetchAll();
} catch (PDOException $e) {
    $hasil_seleksi = [];
    error_log("Failed to fetch hasil seleksi: " . $e->getMessage());
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
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100">Hasil Seleksi Asisten Dosen</h1>
                    <button id="tambah-asdos-btn" class="bg-[#FFCC00] text-gray-900 px-4 py-2 rounded-lg font-semibold">Tambah Data</button>
                </div>
                <div class="overflow-x-auto rounded-lg shadow-md border border-[#374151]">
                    <table class="w-full min-w-[800px]" id="tabel-asdos">
                        <thead class="bg-[#374151]/50">
                            <tr class="text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">NPM & Nama</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Mata Kuliah</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">PJ Kelas</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Keterangan</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#374151]">
                             <?php foreach ($hasil_seleksi as $data): ?>
                                <tr data-id="<?= $data['id'] ?>">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-100"><?= htmlspecialchars($data['nama_mahasiswa']) ?></div>
                                        <div class="text-xs text-gray-400"><?= htmlspecialchars($data['npm']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-sm"><?= htmlspecialchars($data['mata_kuliah']) ?></td>
                                    <td class="px-6 py-4 text-sm"><?= htmlspecialchars($data['kelas_pj']) ?></td>
                                    <td class="px-6 py-4">
                                        <span class="px-2 py-1 text-xs font-semibold rounded-full <?= $data['peran'] == 'Koordinator' ? 'bg-green-500/20 text-green-400' : 'bg-blue-500/20 text-blue-400' ?>"><?= htmlspecialchars($data['peran']) ?></span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 delete-btn"><i class="ri-delete-bin-line ri-lg"></i></button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
    <div id="tambah-asdos-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 hidden p-4">
        <div class="bg-[#1F2937] p-8 rounded-2xl shadow-2xl w-full max-w-lg border border-[#374151]">
            <h2 class="text-xl font-semibold text-white mb-6">Tambah Data Hasil Seleksi</h2>
            <form id="form-tambah-asdos" class="space-y-5">
                <input type="hidden" name="action" value="create">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">NPM</label>
                    <input type="text" name="npm" required class="form-input-dark" inputmode="numeric" pattern="\d*">
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" required class="form-input-dark">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Mata Kuliah</label>
                    <input type="text" name="mata_kuliah" required class="form-input-dark">
                </div>
                 <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Semester MK</label>
                    <input type="text" name="semester_mk" required class="form-input-dark" inputmode="numeric" pattern="[1-8]">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">PJ Kelas</label>
                    <input type="text" name="kelas_pj" required class="form-input-dark" placeholder="Contoh: A">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Peran/Keterangan</label>
                    <select name="peran" required class="form-input-dark">
                        <option value="Anggota">Anggota</option>
                        <option value="Koordinator">Koordinator</option>
                    </select>
                </div>
                <div class="flex justify-end space-x-4 pt-4">
                    <button type="button" id="cancel-modal-btn" class="px-6 py-2 rounded-lg text-gray-300 bg-gray-600 hover:bg-gray-700">Batal</button>
                    <button type="submit" class="bg-[#FFCC00] text-gray-900 font-semibold px-6 py-2 rounded-lg hover:bg-[#FFB100]">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    <?php require __DIR__ . '/components/footer_scripts.php'; ?>
    <script src="js/pengumumanManager.js"></script>
</body>
</html>