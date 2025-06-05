<?php
session_start(); 

// if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }

$pageTitle = "Data Pendaftar";
$currentPage = "pendaftar"; 

$pendaftar_list_dummy = [
    [
        "id" => 1, "nama" => "Ahmad Fauzi", "npm" => "1234567890", "status" => "Diterima",
        "no_wa" => "081234567890", "mk_1" => "Pemrograman Web", "mk_2" => "Basis Data", "alasan" => "Ingin memperdalam ilmu dan berkontribusi.\nSemoga bisa memberikan yang terbaik.", "bersedia_2_mk" => true, "pernah_asdos" => false, "bersedia_mk_lain" => "Bersedia", "surat_pernyataan_url" => "https://via.placeholder.com/400x500.png?text=Surat+Ahmad"
    ],
    [
        "id" => 2, "nama" => "Bunga Citra Lestari", "npm" => "0987654321", "status" => "Ditolak",
        "no_wa" => "081209876543", "mk_1" => "Algoritma & Struktur Data", "mk_2" => "", "alasan" => "Tertarik dengan materi Algoritma dan ingin berbagi ilmu.", "bersedia_2_mk" => false, "pernah_asdos" => true, "bersedia_mk_lain" => "Tidak Bersedia", "surat_pernyataan_url" => "https://via.placeholder.com/400x500.png?text=Surat+Bunga"
    ],
    [
        "id" => 3, "nama" => "Charlie Puth", "npm" => "1122334455", "status" => "Diterima",
        "no_wa" => "081122334455", "mk_1" => "Jaringan Komputer", "mk_2" => "Keamanan Informasi", "alasan" => "Suka bidang jaringan dan keamanan. Pengalaman sebelumnya sebagai asisten lab.", "bersedia_2_mk" => true, "pernah_asdos" => true, "bersedia_mk_lain" => "Bersedia", "surat_pernyataan_url" => "https://via.placeholder.com/400x500.png?text=Surat+Charlie"
    ],
];

require __DIR__ . '/components/html_head.php';
?>

<body class="bg-primary text-gray-300">

    <?php
    require __DIR__ . '/components/admin_header.php';
    ?>

    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]">

        <?php
        require __DIR__ . '/components/admin_sidebar.php';
        ?>

        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 rounded-xl shadow-lg min-h-full">
                <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-4 sm:mb-0">Data Pendaftar</h1>
                    <div class="flex space-x-3">
                        <button id="btn-tambah-pendaftar" class="bg-secondary text-primary px-4 py-2 rounded-button hover:bg-yellow-500 font-semibold flex items-center space-x-2 transition-all duration-150 ease-in-out hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-75">
                            <i class="ri-user-add-line"></i>
                            <span>Tambah Pendaftar</span>
                        </button>
                    </div>
                </div>

                <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                    <div class="relative">
                         <label for="search-input-pendaftar" class="sr-only">Cari Nama atau NPM</label>
                        <input type="text" id="search-input-pendaftar" placeholder="Cari Nama atau NPM..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary placeholder-gray-400">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="ri-search-line"></i>
                        </div>
                    </div>
                    <div>
                        <label for="filter-status-pendaftar" class="block text-sm font-medium text-gray-400 mb-1.5">Status Pendaftaran</label>
                        <select id="filter-status-pendaftar" name="filter-status-pendaftar" class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary">
                            <option value="">Semua Status</option>
                            <option value="Dalam Review">Dalam Review</option>
                            <option value="Diterima">Diterima</option>
                            <option value="Ditolak">Ditolak</option>
                        </select>
                    </div>
                     <button id="btn-filter-pendaftar" class="bg-gray-600 hover:bg-gray-500 text-gray-200 px-4 py-2.5 rounded-lg font-medium flex items-center justify-center space-x-2 h-[46px] sm:h-auto sm:self-end transition-colors duration-150 ease-in-out">
                        <i class="ri-filter-3-line"></i>
                        <span>Filter Pendaftar</span>
                    </button>
                </div>

                <div class="overflow-x-auto rounded-lg shadow-md border border-gray-700">
                    <table class="w-full min-w-[600px]" id="tabel-pendaftar">
                        <thead class="bg-gray-700/50">
                            <tr class="text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Nama & NPM</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Kontak (WA)</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php
                            if (empty($pendaftar_list_dummy)): ?>
                                <tr>
                                    <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="ri-user-search-line text-4xl mb-2"></i>
                                            <span>Tidak ada data pendaftar yang ditemukan.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php else:
                                foreach ($pendaftar_list_dummy as $pendaftar):
                                    $status_color = 'text-yellow-400 bg-yellow-500/20'; 
                                    if ($pendaftar['status'] == 'Diterima') $status_color = 'text-green-400 bg-green-500/20';
                                    if ($pendaftar['status'] == 'Ditolak') $status_color = 'text-red-400 bg-red-500/20';
                                ?>
                                <tr class="hover:bg-gray-700/60 transition-colors duration-150 ease-in-out"
                                    data-id="<?= $pendaftar['id'] ?>"
                                    data-nama="<?= htmlspecialchars($pendaftar['nama']) ?>"
                                    data-npm="<?= htmlspecialchars($pendaftar['npm']) ?>"
                                    data-status="<?= htmlspecialchars($pendaftar['status']) ?>"
                                    data-no_wa="<?= htmlspecialchars($pendaftar['no_wa']) ?>"
                                    data-mk_1="<?= htmlspecialchars($pendaftar['mk_1']) ?>"
                                    data-mk_2="<?= htmlspecialchars($pendaftar['mk_2']) ?>"
                                    data-alasan="<?= htmlspecialchars($pendaftar['alasan']) ?>"
                                    data-bersedia_2_mk="<?= $pendaftar['bersedia_2_mk'] ? 'Ya' : 'Tidak' ?>"
                                    data-pernah_asdos="<?= $pendaftar['pernah_asdos'] ? 'Ya' : 'Tidak' ?>"
                                    data-bersedia_mk_lain="<?= htmlspecialchars($pendaftar['bersedia_mk_lain']) ?>"
                                    data-surat_pernyataan_url="<?= htmlspecialchars($pendaftar['surat_pernyataan_url']) ?>">
                                    <td class="px-6 py-4 align-top">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-100"><?= htmlspecialchars($pendaftar['nama']) ?></div>
                                            <div class="text-xs text-gray-400 mt-0.5">NPM: <?= htmlspecialchars($pendaftar['npm']) ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                         <?= htmlspecialchars($pendaftar['no_wa']) ?>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $status_color ?> leading-normal">
                                            <?= htmlspecialchars($pendaftar['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button type="button" class="text-secondary hover:underline text-sm font-medium btn-lihat-lanjut">Detail</button>
                                            <button title="Edit Pendaftar" class="text-gray-300 hover:text-secondary p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-edit-pendaftar"><i class="ri-pencil-line ri-lg"></i></button>
                                            <button title="Hapus Pendaftar" class="text-gray-300 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-hapus-pendaftar"><i class="ri-delete-bin-line ri-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <div id="no-results-pendaftar" class="hidden py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <i class="ri-user-search-line text-4xl mb-2"></i>
                        <span>Tidak ada data pendaftar yang cocok dengan filter.</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-400 mb-4 sm:mb-0">
                        Menampilkan <span class="font-medium text-gray-200" id="pendaftar-showing-from">1</span> sampai <span class="font-medium text-gray-200" id="pendaftar-showing-to">3</span> dari <span class="font-medium text-gray-200" id="pendaftar-total-results">3</span> hasil
                    </div>
                     <div class="inline-flex rounded-button shadow-sm">
                        <button class="px-3 py-2 border border-gray-600 bg-gray-700 text-gray-400 rounded-l-lg hover:bg-gray-600 disabled:opacity-50" disabled>
                            <i class="ri-arrow-left-s-line"></i>
                        </button>
                        <button class="pagination-btn px-4 py-2 border-y border-l border-gray-600 bg-secondary text-primary">1</button>
                        <button class="px-3 py-2 border border-gray-600 bg-gray-700 text-gray-300 rounded-r-lg hover:bg-gray-600">
                            <i class="ri-arrow-right-s-line"></i>
                        </button>
                    </div>
                </div>
            </div>
        </main>
    </div>

    <div id="modal-lihat-lanjut" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center z-[80] hidden p-4 transition-opacity duration-300 ease-in-out opacity-0">
        <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-2xl w-full max-w-2xl max-h-[85vh] flex flex-col border border-gray-700 transform scale-95 transition-transform duration-300 ease-in-out">
            <div class="flex justify-between items-center mb-5 border-b border-gray-700 pb-4">
                <h2 class="text-xl font-semibold text-secondary">Detail Pendaftar</h2>
                <button id="btn-close-modal-lihat-lanjut" class="text-gray-400 hover:text-secondary transition-colors duration-150">
                    <i class="ri-close-line ri-xl"></i>
                </button>
            </div>
            <div class="space-y-4 overflow-y-auto flex-grow pr-2 text-sm custom-scrollbar">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                    <div><strong class="font-medium text-gray-400">Nama Lengkap:</strong> <span id="detail-nama" class="text-gray-100 break-words ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">NPM:</strong> <span id="detail-npm" class="text-gray-100 break-words ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">No. WhatsApp:</strong> <span id="detail-no_wa" class="text-gray-100 break-words ml-1"></span></div>
                </div>
                 <hr class="border-gray-700 my-3">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-3">
                    <div><strong class="font-medium text-gray-400">MK Pilihan 1:</strong> <span id="detail-mk_1" class="text-gray-100 break-words ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">MK Pilihan 2:</strong> <span id="detail-mk_2" class="text-gray-100 break-words ml-1"></span></div>
                </div>
                 <hr class="border-gray-700 my-3">
                <div class="space-y-1.5">
                    <p><strong class="font-medium text-gray-400">Alasan Mendaftar:</strong></p>
                    <p id="detail-alasan" class="text-gray-200 bg-gray-700/50 p-3.5 rounded-lg whitespace-pre-wrap text-sm leading-relaxed"></p>
                </div>
                 <hr class="border-gray-700 my-3">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-x-6 gap-y-3">
                    <div><strong class="font-medium text-gray-400">Bersedia 2 MK:</strong> <span id="detail-bersedia_2_mk" class="text-gray-100 ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">Pernah Asdos:</strong> <span id="detail-pernah_asdos" class="text-gray-100 ml-1"></span></div>
                    <div><strong class="font-medium text-gray-400">Bersedia MK Lain:</strong> <span id="detail-bersedia_mk_lain" class="text-gray-100 ml-1"></span></div>
                </div>
                <div class="pt-2">
                    <p><strong class="font-medium text-gray-400">Surat Pernyataan:</strong></p>
                    <div class="mt-2 border border-gray-600 rounded-lg overflow-hidden max-h-80 flex justify-center items-start bg-gray-700/40 p-2">
                         <img id="detail-surat_pernyataan_url" src="" alt="Surat Pernyataan" class="max-w-full max-h-full object-contain rounded-md">
                    </div>
                </div>
            </div>
            <div class="mt-6 text-right border-t border-gray-700 pt-5">
                <button id="btn-ok-modal-lihat-lanjut" class="bg-secondary text-primary px-6 py-2.5 rounded-button hover:bg-yellow-500 font-semibold transition-all duration-150 ease-in-out hover:shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-75">Tutup</button>
            </div>
        </div>
    </div>

    <div id="modal-add-edit-pendaftar" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center z-[90] hidden p-4 transition-opacity duration-300 ease-in-out opacity-0">
        <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-1xl w-full max-w-1xl max-h-[90vh] overflow-y-auto border border-gray-700 transform scale-95 transition-transform duration-300 ease-in-out custom-scrollbar">
            <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-4">
                <h2 id="modal-pendaftar-title" class="text-xl font-semibold text-secondary">Data Pendaftar</h2>
                <button id="btn-close-modal-add-edit" class="text-gray-400 hover:text-secondary transition-colors duration-150">
                    <i class="ri-close-line ri-xl"></i>
                </button>
            </div>
            <form id="form-add-edit-pendaftar" class="space-y-6">
                <input type="hidden" name="id" id="pendaftar-id">
                
                <div class="bg-gray-700/30 rounded-lg p-5 space-y-5">
                    <h3 class="text-lg font-medium text-gray-200 mb-4">Data Pribadi</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div class="form-group">
                            <label for="pendaftar-nama" class="form-label-custom">Nama Lengkap <span class="text-red-400">*</span></label>
                            <div class="relative rounded-lg">
                                <span class="input-icon">
                                    <i class="ri-user-line"></i>
                                </span>
                                <input type="text" name="nama" id="pendaftar-nama" required class="form-input-custom-modal pl-10" placeholder="Masukkan nama lengkap">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pendaftar-npm" class="form-label-custom">NPM <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <span class="input-icon">
                                    <i class="ri-id-card-line"></i>
                                </span>
                                <input type="text" name="npm" id="pendaftar-npm" pattern="\d{10}" title="NPM harus 10 digit angka" required class="form-input-custom-modal pl-10" placeholder="Masukkan 10 digit NPM">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pendaftar-no_wa" class="form-label-custom">No. WA <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <span class="input-icon">
                                    <i class="ri-whatsapp-line"></i>
                                </span>
                                <input type="tel" name="no_wa" id="pendaftar-no_wa" required class="form-input-custom-modal pl-10" placeholder="Contoh: 081234567890">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pendaftar-status" class="form-label-custom">Status <span class="text-red-400">*</span></label>
                            <div class="relative">
                                <span class="input-icon">
                                    <i class="ri-checkbox-circle-line"></i>
                                </span>
                                <select name="status" id="pendaftar-status" required class="form-input-custom-modal pl-10">
                                    <option value="" disabled selected>Pilih Status</option>
                                    <option value="Dalam Review">Dalam Review</option>
                                    <option value="Diterima">Diterima</option>
                                    <option value="Ditolak">Ditolak</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-700/30 rounded-lg p-5 space-y-5">
                    <h3 class="text-lg font-medium text-gray-200 mb-4">Data Mata Kuliah</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                        <div class="form-group">
                            <label for="pendaftar-mk_1" class="form-label-custom">Mata Kuliah Pilihan 1</label>
                            <div class="relative">
                                <span class="input-icon">
                                    <i class="ri-book-line"></i>
                                </span>
                                <input type="text" name="mk_1" id="pendaftar-mk_1" class="form-input-custom-modal pl-10" placeholder="Contoh: Pemrograman Web">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pendaftar-mk_2" class="form-label-custom">Mata Kuliah Pilihan 2 (Opsional)</label>
                            <div class="relative">
                                <span class="input-icon">
                                    <i class="ri-book-2-line"></i>
                                </span>
                                <input type="text" name="mk_2" id="pendaftar-mk_2" class="form-input-custom-modal pl-10" placeholder="Contoh: Basis Data">
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pendaftar-alasan" class="form-label-custom">Alasan Mendaftar</label>
                        <div class="relative">
                            <span class="absolute left-3 top-3 text-gray-400 input-icon top-align"> 
                                <i class="ri-message-2-line"></i>
                            </span>
                            <textarea name="alasan" id="pendaftar-alasan" rows="3" class="form-input-custom-modal pl-10" placeholder="Jelaskan alasan Anda mendaftar..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-700/30 rounded-lg p-5 space-y-5">
                    <h3 class="text-lg font-medium text-gray-200 mb-4">Data Tambahan</h3>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-x-6 gap-y-5">
                        <div class="form-group">
                            <label for="pendaftar-bersedia_2_mk" class="form-label-custom">Bersedia 2 MK?</label>
                            <div class="relative">
                                <span class="input-icon">
                                    <i class="ri-check-double-line"></i>
                                </span>
                                <select name="bersedia_2_mk" id="pendaftar-bersedia_2_mk" class="form-input-custom-modal pl-10 w-full">
                                    <option value="Ya">Ya</option>
                                    <option value="Tidak">Tidak</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pendaftar-pernah_asdos" class="form-label-custom">Pernah Jadi Asdos?</label>
                            <div class="relative">
                                <span class="input-icon">
                                    <i class="ri-user-star-line"></i>
                                </span>
                                <select name="pernah_asdos" id="pendaftar-pernah_asdos" class="form-input-custom-modal pl-10 w-full">
                                    <option value="Tidak">Tidak</option>
                                    <option value="Ya">Ya</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="pendaftar-bersedia_mk_lain" class="form-label-custom">Bersedia MK Lain?</label>
                            <div class="relative">
                                <span class="input-icon">
                                    <i class="ri-book-open-line"></i>
                                </span>
                                <select name="bersedia_mk_lain" id="pendaftar-bersedia_mk_lain" class="form-input-custom-modal pl-10 w-full">
                                    <option value="Bersedia">Bersedia</option>
                                    <option value="Tidak Bersedia">Tidak Bersedia</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-gray-700/30 rounded-lg p-5 space-y-5">
                    <h3 class="text-lg font-medium text-gray-200 mb-4">Upload Surat</h3>
                    <div class="form-group">
                        <label for="pendaftar-surat_pernyataan_url" class="form-label-custom">Link Gambar Surat Pernyataan (URL)</label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="ri-file-upload-line"></i>
                            </span>
                            <input type="url" name="surat_pernyataan_url" id="pendaftar-surat_pernyataan_url" class="form-input-custom-modal pl-10" placeholder="https://example.com/gambar.jpg">
                        </div>
                        <div class="mt-2">
                            <img id="preview-surat-edit" src="" alt="Preview Surat Pernyataan" class="rounded-md max-h-36 hidden border border-gray-600 bg-gray-700/50 p-1">
                        </div>
                    </div>
                </div>

                <div class="flex justify-end space-x-3 pt-5">
                    <button type="button" id="btn-cancel-modal-add-edit" class="px-5 py-2.5 rounded-button text-gray-300 hover:bg-gray-700 hover:text-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-opacity-75 transition-colors duration-150">Batal</button>
                    <button type="submit" id="btn-submit-modal-add-edit" class="bg-secondary text-primary px-6 py-2.5 rounded-button hover:bg-yellow-500 font-semibold transition-all duration-150 ease-in-out hover:shadow-md focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-75">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <?php
    require __DIR__ . '/components/notifications_dropdown.php';
    require __DIR__ . '/components/admin_menu_dropdown.php';
    require __DIR__ . '/components/mobile_menu.php';
    require __DIR__ . '/components/footer_scripts.php';
    ?>
    <script src="js/pendaftarManager.js"></script>
    <style>
        .form-label-custom {
            @apply block text-sm font-medium text-gray-300 mb-1.5;
        }
        .form-input-custom-modal {
            @apply w-full px-4 py-2.5 bg-gray-700/50 border border-gray-600/50 text-gray-200 rounded-lg 
                   focus:ring-2 focus:ring-secondary/50 focus:border-secondary/50 
                   hover:bg-gray-700/70 hover:border-gray-500/50
                   transition-all duration-200 ease-in-out 
                   placeholder-gray-400/50
                   shadow-sm hover:shadow-md focus:shadow-lg;
            line-height: 1.5; 
        }
        .form-input-custom-modal.pl-10 { 
            padding-left: 2.5rem; 
        }
        textarea.form-input-custom-modal.pl-10 { 
             padding-left: 2.5rem;
        }

        .form-group {
            @apply transition-all duration-200 ease-in-out;
        }
        .form-group:focus-within {
            @apply transform scale-[1.01];
        }
        .form-group:focus-within .form-label-custom {
            @apply text-secondary;
        }
        .form-group .input-icon { 
            @apply absolute left-3 top-1/2 -translate-y-1/2 text-gray-400 transition-colors duration-200;
        }
        
        .form-group .input-icon.top-align { 
            @apply absolute left-3 text-gray-400 transition-colors duration-200;
            top: 0.625rem; 
            transform: none; 
        }
        .form-group:focus-within .input-icon, 
        .form-group.field-active .input-icon {
            @apply text-secondary;
        }
        .form-group textarea.form-input-custom-modal {
            @apply resize-none;
        }
        
        .form-group select.form-input-custom-modal {
            @apply appearance-none cursor-pointer bg-no-repeat;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%239CA3AF'%3E%3Cpath d='M12 15.0006L7.75732 10.758L9.17154 9.34375L12 12.1722L14.8284 9.34375L16.2426 10.758L12 15.0006Z'%3E%3C/path%3E%3C/svg%3E");
            background-position: right 0.75rem center;
            background-size: 1.25em 1.25em; 
            padding-right: 3rem; 
            overflow: hidden; 
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .form-group:focus-within select.form-input-custom-modal,
        .form-group.field-active select.form-input-custom-modal {
             background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23FFCC00'%3E%3Cpath d='M12 15.0006L7.75732 10.758L9.17154 9.34375L12 12.1722L14.8284 9.34375L16.2426 10.758L12 15.0006Z'%3E%3C/path%3E%3C/svg%3E");
        }
        .form-group select.form-input-custom-modal::-ms-expand { 
            display: none;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
            height: 6px;
        }
        .custom-scrollbar::-webkit-scrollbar-track {
            background: #374151;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #6b7280;
            border-radius: 3px;
        }
        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #9ca3af;
        }
    </style>

</body>
</html>