<?php
session_start();

$pageTitle = "Daftar Mata Kuliah";
$currentPage = "mata_kuliah";

$mata_kuliah_list_dummy = [
    [
        "id" => 1, "kode" => "IF210", "nama" => "Dasar Pemrograman", "sks" => 3, "semester" => 1, 
        "dosen" => "Dwi Sakethi", "kuota" => 2, "status" => "Aktif"
    ],
    [
        "id" => 2, "kode" => "IF220", "nama" => "Struktur Data & Algoritma", "sks" => 4, "semester" => 2, 
        "dosen" => "Rico Adrian", "kuota" => 3, "status" => "Aktif"
    ],
    [
        "id" => 3, "kode" => "IF310", "nama" => "Pemrograman Web", "sks" => 3, "semester" => 3, 
        "dosen" => "Rizky Prabowo", "kuota" => 2, "status" => "Nonaktif"
    ],
    [
        "id" => 4, "kode" => "IF320", "nama" => "Basis Data", "sks" => 3, "semester" => 4, 
        "dosen" => "Aristoteles", "kuota" => 1, "status" => "Aktif"
    ],
    [
        "id" => 5, "kode" => "KU400", "nama" => "Etika", "sks" => 2, "semester" => 5, 
        "dosen" => "Wartarius", "kuota" => 4, "status" => "Aktif"
    ]
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
                    <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-4 sm:mb-0">Daftar Mata Kuliah</h1>
                    <div class="flex space-x-3">
                        <button id="btn-tambah-mk" class="bg-secondary text-primary px-4 py-2 rounded-button hover:bg-yellow-500 font-semibold flex items-center space-x-2 transition-all duration-150 ease-in-out hover:shadow-lg focus:outline-none focus:ring-2 focus:ring-yellow-600 focus:ring-opacity-75">
                            <i class="ri-add-line"></i>
                            <span>Tambah Mata Kuliah</span>
                        </button>
                    </div>
                </div>

                <div class="mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 items-end">
                    <div class="relative">
                        <label for="search-input-mk" class="sr-only">Cari Kode atau Nama</label>
                        <input type="text" id="search-input-mk" placeholder="Cari Kode atau Nama..."
                            class="w-full pl-10 pr-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary placeholder-gray-400">
                        <div class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                            <i class="ri-search-line"></i>
                        </div>
                    </div>
                    <div>
                        <label for="filter-semester-mk" class="block text-sm font-medium text-gray-400 mb-1.5">Semester</label>
                        <select id="filter-semester-mk" name="filter-semester-mk" class="w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg focus:ring-1 focus:ring-secondary focus:border-secondary">
                            <option value="">Semua Semester</option>
                            <option value="1">Semester 1</option>
                            <option value="2">Semester 2</option>
                            <option value="3">Semester 3</option>
                            <option value="4">Semester 4</option>
                            <option value="5">Semester 5</option>
                            <option value="6">Semester 6</option>
                            <option value="7">Semester 7</option>
                            <option value="8">Semester 8</option>
                        </select>
                    </div>
                    <button id="btn-filter-mk" class="bg-gray-600 hover:bg-gray-500 text-gray-200 px-4 py-2.5 rounded-lg font-medium flex items-center justify-center space-x-2 h-[46px] sm:h-auto sm:self-end transition-colors duration-150 ease-in-out">
                        <i class="ri-filter-3-line"></i>
                        <span>Filter</span>
                    </button>
                </div>

                <div class="overflow-x-auto rounded-lg shadow-md border border-gray-700">
                    <table class="w-full min-w-[800px]" id="tabel-mk">
                        <thead class="bg-gray-700/50">
                            <tr class="text-left">
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Kode & Nama</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">SKS</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Semester</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Dosen</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Kuota</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider">Status</th>
                                <th class="px-6 py-3 text-xs font-medium text-gray-300 uppercase tracking-wider text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-700">
                            <?php
                            if (empty($mata_kuliah_list_dummy)): ?>
                                <tr>
                                    <td colspan="7" class="px-6 py-12 text-center text-gray-500">
                                        <div class="flex flex-col items-center">
                                            <i class="ri-book-search-line text-4xl mb-2"></i>
                                            <span>Tidak ada data mata kuliah yang ditemukan.</span>
                                        </div>
                                    </td>
                                </tr>
                            <?php else:
                                foreach ($mata_kuliah_list_dummy as $mk):
                                    $status_color = 'text-green-400 bg-green-500/20'; 
                                    if ($mk['status'] == 'Nonaktif') $status_color = 'text-red-400 bg-red-500/20';
                                ?>
                                <tr class="hover:bg-gray-700/60 transition-colors duration-150 ease-in-out"
                                    data-id="<?= $mk['id'] ?>"
                                    data-kode="<?= htmlspecialchars($mk['kode']) ?>"
                                    data-nama="<?= htmlspecialchars($mk['nama']) ?>"
                                    data-sks="<?= htmlspecialchars($mk['sks']) ?>"
                                    data-semester="<?= htmlspecialchars($mk['semester']) ?>"
                                    data-dosen="<?= htmlspecialchars($mk['dosen']) ?>"
                                    data-kuota="<?= htmlspecialchars($mk['kuota']) ?>"
                                    data-status="<?= htmlspecialchars($mk['status']) ?>">
                                    <td class="px-6 py-4 align-top">
                                        <div>
                                            <div class="text-sm font-semibold text-gray-100"><?= htmlspecialchars($mk['kode']) ?></div>
                                            <div class="text-xs text-gray-400 mt-0.5"><?= htmlspecialchars($mk['nama']) ?></div>
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                        <?= htmlspecialchars($mk['sks']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                        <?= htmlspecialchars($mk['semester']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                        <?= htmlspecialchars($mk['dosen']) ?>
                                    </td>
                                    <td class="px-6 py-4 text-sm text-gray-300 align-top">
                                        <?= htmlspecialchars($mk['kuota']) ?>
                                    </td>
                                    <td class="px-6 py-4 align-top">
                                        <span class="px-3 py-1 text-xs font-semibold rounded-full <?= $status_color ?> leading-normal">
                                            <?= htmlspecialchars($mk['status']) ?>
                                        </span>
                                    </td>
                                    <td class="px-6 py-4 align-top text-center">
                                        <div class="flex items-center justify-center space-x-2">
                                            <button title="Edit Mata Kuliah" class="text-gray-300 hover:text-secondary p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-edit-mk"><i class="ri-pencil-line ri-lg"></i></button>
                                            <button title="Hapus Mata Kuliah" class="text-gray-300 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-hapus-mk"><i class="ri-delete-bin-line ri-lg"></i></button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach;
                            endif; ?>
                        </tbody>
                    </table>
                </div>
                <div id="no-results-mk" class="hidden py-12 text-center text-gray-500">
                    <div class="flex flex-col items-center">
                        <i class="ri-book-search-line text-4xl mb-2"></i>
                        <span>Tidak ada data mata kuliah yang cocok dengan filter.</span>
                    </div>
                </div>

                <div class="mt-6 flex flex-col sm:flex-row justify-between items-center">
                    <div class="text-sm text-gray-400 mb-4 sm:mb-0">
                        Menampilkan <span class="font-medium text-gray-200" id="mk-showing-from">1</span> sampai <span class="font-medium text-gray-200" id="mk-showing-to">3</span> dari <span class="font-medium text-gray-200" id="mk-total-results">3</span> hasil
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

    <div id="modal-add-edit-mk" class="fixed inset-0 bg-gray-900/80 backdrop-blur-sm flex items-center justify-center z-[90] hidden p-4 transition-opacity duration-300 ease-in-out opacity-0">
        <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-2xl w-full max-w-3xl max-h-[90vh] overflow-y-auto border border-gray-700 transform scale-95 transition-transform duration-300 ease-in-out custom-scrollbar">
            <div class="flex justify-between items-center mb-6 border-b border-gray-700 pb-4">
                <h2 id="modal-mk-title" class="text-xl font-semibold text-secondary">Data Mata Kuliah</h2>
                <button id="btn-close-modal-add-edit" class="text-gray-400 hover:text-secondary transition-colors duration-150">
                    <i class="ri-close-line ri-xl"></i>
                </button>
            </div>
            <form id="form-add-edit-mk" class="space-y-6">
                <input type="hidden" name="id" id="mk-id">
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-x-6 gap-y-5">
                    <div class="form-group">
                        <label for="mk-kode" class="form-label-custom">Kode MK <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="ri-hashtag"></i>
                            </span>
                            <input type="text" name="kode" id="mk-kode" required class="form-input-custom-modal pl-10" placeholder="Contoh: IF123">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mk-nama" class="form-label-custom">Nama MK <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="ri-book-2-line"></i>
                            </span>
                            <input type="text" name="nama" id="mk-nama" required class="form-input-custom-modal pl-10" placeholder="Contoh: Pemrograman Web">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mk-sks" class="form-label-custom">SKS <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="ri-stack-line"></i>
                            </span>
                            <input type="number" name="sks" id="mk-sks" min="1" max="6" required class="form-input-custom-modal pl-10" placeholder="Contoh: 3">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mk-semester" class="form-label-custom">Semester <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="ri-calendar-event-line"></i>
                            </span>
                            <select name="semester" id="mk-semester" required class="form-input-custom-modal pl-10">
                                <option value="" disabled selected>Pilih Semester</option>
                                <option value="1">Semester 1</option>
                                <option value="2">Semester 2</option>
                                <option value="3">Semester 3</option>
                                <option value="4">Semester 4</option>
                                <option value="5">Semester 5</option>
                                <option value="6">Semester 6</option>
                                <option value="7">Semester 7</option>
                                <option value="8">Semester 8</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-group md:col-span-2">
                        <label for="mk-dosen" class="form-label-custom">Dosen Pengampu <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="ri-user-voice-line"></i>
                            </span>
                            <input type="text" name="dosen" id="mk-dosen" required class="form-input-custom-modal pl-10" placeholder="Contoh: Dr. John Doe, M.Kom.">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mk-kuota" class="form-label-custom">Kuota Asisten <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="ri-group-2-line"></i>
                            </span>
                            <input type="number" name="kuota" id="mk-kuota" min="1" max="5" required class="form-input-custom-modal pl-10" placeholder="Contoh: 2">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="mk-status" class="form-label-custom">Status <span class="text-red-400">*</span></label>
                        <div class="relative">
                            <span class="input-icon">
                                <i class="ri-checkbox-circle-line"></i>
                            </span>
                            <select name="status" id="mk-status" required class="form-input-custom-modal pl-10">
                                <option value="" disabled selected>Pilih Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                            </select>
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
    <script src="js/mataKuliahManager.js"></script>
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

        .custom-scrollbar {
            scrollbar-width: thin;
            scrollbar-color: #6b7280 #374151;
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