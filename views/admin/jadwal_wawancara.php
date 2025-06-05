<?php
session_start(); // Mulai session jika belum dimulai

// // Cek autentikasi (aktifkan jika sudah ada sistem login yang berfungsi)
// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }

// Definisikan variabel khusus untuk halaman ini
$pageTitle = "Jadwal Wawancara";
$currentPage = "jadwal_wawancara"; // Untuk menandai menu aktif

// 1. Include Komponen Head HTML
require __DIR__ . '/components/html_head.php'; 
?>

<body class="bg-primary text-gray-300">
    
    <?php 
    // 2. Include Komponen Header Admin
    require __DIR__ . '/components/admin_header.php'; 
    ?>

    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]"> 
        
        <?php 
        // 3. Include Komponen Sidebar Admin
        require __DIR__ . '/components/admin_sidebar.php'; 
        ?>

        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg min-h-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-4 sm:mb-0">Jadwal Wawancara</h1>
                    <div class="flex space-x-3">
                        <button class="bg-secondary text-primary px-4 py-2 rounded-button hover:bg-yellow-500 font-medium flex items-center space-x-2">
                            <i class="ri-calendar-event-line"></i>
                            <span>Buat Jadwal Baru</span>
                        </button>
                    </div>
                </div>

                <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                    <div>
                        <label for="filter-tanggal" class="block text-sm font-medium text-gray-400 mb-1.5">Tanggal Wawancara</label>
                        <input type="date" id="filter-tanggal" name="filter-tanggal"
                            class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary">
                    </div>
                    <div>
                        <label for="filter-status-wawancara" class="block text-sm font-medium text-gray-400 mb-1.5">Status Wawancara</label>
                        <select id="filter-status-wawancara" name="filter-status-wawancara" class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary">
                            <option value="">Semua Status</option>
                            <option value="selesai">Selesai</option>
                            <option value="belum">Belum</option>
                        </select>
                    </div>
                     <button class="bg-gray-600 hover:bg-gray-500 text-gray-200 px-4 py-2.5 rounded-lg font-medium flex items-center justify-center space-x-2 h-[46px] sm:h-auto sm:self-end">
                        <i class="ri-filter-3-line"></i>
                        <span>Filter Jadwal</span>
                    </button>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full min-w-[800px]"> 
                        <thead>
                            <tr class="bg-gray-700/50 text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tl-lg">Tanggal & Waktu</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Calon Asisten</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Keterangan</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-400 uppercase tracking-wider rounded-tr-lg">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php 
                            // Data dummy (Mata Kuliah telah dihapus dari array)
                            $jadwal_list = [
                                ["id" => 1, "tanggal" => "2025-06-10", "waktu_mulai" => "09:00", "waktu_selesai" => "09:30", "nama_calon" => "Ahmad Fauzi", "nim_calon" => "201011400001",  "Keterangan" => "Offline", "status" => "Selesai"],
                                ["id" => 2, "tanggal" => "2025-06-10", "waktu_mulai" => "10:00", "waktu_selesai" => "10:30", "nama_calon" => "Bunga Citra Lestari", "nim_calon" => "211011400002", "Keterangan" => "Online", "status" => "Selesai"],
                                ["id" => 3, "tanggal" => "2025-06-11", "waktu_mulai" => "13:00", "waktu_selesai" => "13:45", "nama_calon" => "Eko Patrio", "nim_calon" => "201011400005", "Keterangan" => "Offline", "status" => "Belum"],
                                ["id" => 4, "tanggal" => "2025-06-12", "waktu_mulai" => "11:00", "waktu_selesai" => "11:30", "nama_calon" => "Siti Aminah", "nim_calon" => "221011400007", "Keterangan" => "Offline", "status" => "Belum"],
                            ];

                            if (empty($jadwal_list)): ?>
                                <tr>
                                    <td colspan="6" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="ri-calendar-close-line text-4xl mb-2"></i>
                                            <span>Tidak ada jadwal wawancara yang ditemukan.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php else:
                                foreach ($jadwal_list as $jadwal): 
                                    $status_color = 'text-gray-400 bg-gray-600/30'; 
                                    if ($jadwal['status'] == 'Selesai') $status_color = 'text-green-400 bg-green-500/20';
                                    if ($jadwal['status'] == 'Belum') $status_color = 'text-red-400 bg-red-500/20';
                                ?>
                                <tr class="hover:bg-gray-700/50 transition-colors duration-150">
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-100"><?= date('d M Y', strtotime($jadwal['tanggal'])) ?></div>
                                        <div class="text-xs text-gray-400"><?= htmlspecialchars($jadwal['waktu_mulai']) ?> - <?= htmlspecialchars($jadwal['waktu_selesai']) ?> WIB</div>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="text-sm font-medium text-gray-100"><?= htmlspecialchars($jadwal['nama_calon']) ?></div>
                                        <div class="text-xs text-gray-400">NIM: <?= htmlspecialchars($jadwal['nim_calon']) ?></div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300">
                                        <?php if (filter_var($jadwal['Keterangan'], FILTER_VALIDATE_URL)): ?>
                                            <a href="<?= htmlspecialchars($jadwal['Keterangan']) ?>" target="_blank" class="text-secondary hover:underline"><?= htmlspecialchars(parse_url($jadwal['lokasi'], PHP_URL_HOST) ?: "Link Meeting") ?> <i class="ri-external-link-line text-xs"></i></a>
                                        <?php else: ?>
                                            <?= htmlspecialchars($jadwal['Keterangan']) ?>
                                        <?php endif; ?>
                                    </td>
                                    <td class="px-6 py-4">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $status_color ?>">
                                            <?= htmlspecialchars($jadwal['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4">
                                        <div class="flex items-center space-x-1">
                                            <button title="Lihat Detail" class="text-gray-400 hover:text-secondary p-1.5 rounded-md hover:bg-gray-600/50 transition-colors"><i class="ri-eye-line ri-lg"></i></button>
                                            <button title="Edit Jadwal" class="text-gray-400 hover:text-blue-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors"><i class="ri-edit-line ri-lg"></i></button>
                                            <?php if ($jadwal['status'] == 'Terjadwal' || $jadwal['status'] == 'Menunggu Konfirmasi'): ?>
                                            <button title="Batalkan Jadwal" class="text-gray-400 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors"><i class="ri-close-circle-line ri-lg"></i></button>
                                            <button title="Tandai Selesai" class="text-gray-400 hover:text-green-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors"><i class="ri-checkbox-circle-line ri-lg"></i></button>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; 
                            endif; ?>
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-400 mb-4 sm:mb-0">
                        Menampilkan <span class="font-medium text-gray-200">1</span> sampai <span class="font-medium text-gray-200"><?= count($jadwal_list) ?></span> dari <span class="font-medium text-gray-200"><?= count($jadwal_list) ?></span> hasil
                    </div>
                    <div class="inline-flex rounded-button shadow-sm">
                        <button class="px-3 py-2 border border-gray-600 bg-gray-700 text-gray-400 rounded-l-lg hover:bg-gray-600 disabled:opacity-50" disabled>
                            <i class="ri-arrow-left-s-line"></i>
                        </button>
                        <button class="pagination-btn px-4 py-2 border-y border-l border-gray-600 bg-secondary text-primary">1</button>
                        <button class="pagination-btn px-4 py-2 border-y border-l border-gray-600 bg-gray-700 text-gray-300 hover:bg-gray-600">2</button>
                        <button class="px-3 py-2 border border-gray-600 bg-gray-700 text-gray-300 rounded-r-lg hover:bg-gray-600">
                            <i class="ri-arrow-right-s-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div> 

    <?php 
    require __DIR__ . '/components/notifications_dropdown.php'; 
    require __DIR__ . '/components/admin_menu_dropdown.php'; 
    require __DIR__ . '/components/mobile_menu.php'; 
    require __DIR__ . '/components/footer_scripts.php'; 
    ?>
</body>
</html>