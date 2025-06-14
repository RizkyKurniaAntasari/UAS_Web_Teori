<?php
session_start();

if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
    header('Location: login.php');
    exit;
}

$pageTitle = "Pengaturan";
$currentPage = "pengaturan";

require __DIR__ . '/components/html_head.php'; 
?>
<style type="text/tailwindcss">
    @layer components {
        .form-input-settings {
            @apply w-full px-4 py-2.5 bg-gray-700 border border-gray-600 text-gray-200 rounded-lg 
                   focus:ring-1 focus:ring-secondary focus:border-secondary 
                   placeholder-gray-400 transition-colors duration-200;
        }
    }
</style>

<body class="bg-primary text-gray-300">
    
    <?php require __DIR__ . '/components/admin_header.php'; ?>

    <div class="flex min-h-screen pt-[68px] sm:pt-[72px]"> 
        
        <?php require __DIR__ . '/components/admin_sidebar.php'; ?>

        <main class="flex-1 p-6 sm:p-8 bg-gray-900 md:ml-64">
            <div class="bg-gray-800 p-6 sm:p-8 rounded-xl shadow-lg min-h-full">
                <h1 class="text-2xl sm:text-3xl font-semibold text-gray-100 mb-8">Pengaturan Akun dan Sistem</h1>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-2">
                        <div class="bg-gray-700/50 p-6 sm:p-8 rounded-xl border border-gray-700 h-full">
                            <h2 class="text-xl font-semibold text-gray-100 mb-6 border-b border-gray-600 pb-4">Profil Admin</h2>
                            <form action="#" method="POST" class="space-y-6">
                                <div>
                                    <label for="admin-name" class="block text-sm font-medium text-gray-300 mb-2">Nama Lengkap</label>
                                    <input type="text" name="admin-name" id="admin-name" value="Admin Utama" class="form-input-settings">
                                </div>
                                <div>
                                    <label for="admin-avatar" class="block text-sm font-medium text-gray-300 mb-2">Foto Profil</label>
                                    <div class="flex items-center space-x-4">
                                        <img class="h-16 w-16 rounded-full object-cover flex-shrink-0" src="https://i.pravatar.cc/150?u=adminutama" alt="Admin Avatar">
                                        <input type="file" name="admin-avatar" id="admin-avatar" class="block w-full">
                                    </div>
                                </div>
                                <div class="border-t border-gray-600 pt-6">
                                    <h3 class="text-md font-semibold text-gray-200 mb-4">Ubah Password</h3>
                                    <div class="space-y-4">
                                        <div>
                                            <label for="current-password" class="block text-sm font-medium text-gray-300 mb-2">Password Saat Ini</label>
                                            <input type="password" name="current-password" id="current-password" class="form-input-settings" placeholder="••••••••">
                                        </div>
                                        <div>
                                            <label for="new-password" class="block text-sm font-medium text-gray-300 mb-2">Password Baru</label>
                                            <input type="password" name="new-password" id="new-password" class="form-input-settings" placeholder="••••••••">
                                        </div>
                                        <div>
                                            <label for="confirm-password" class="block text-sm font-medium text-gray-300 mb-2">Konfirmasi Password Baru</label>
                                            <input type="password" name="confirm-password" id="confirm-password" class="form-input-settings" placeholder="••••••••">
                                        </div>
                                    </div>
                                </div>
                                <div class="flex justify-end pt-6">
                                    <button type="submit" class="bg-secondary text-primary px-6 py-2.5 rounded-button hover:bg-yellow-500 font-semibold flex items-center space-x-2 transition-colors duration-200">
                                        <i class="ri-save-line"></i>
                                        <span>Simpan Perubahan</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="lg:col-span-1">
                        <div class="bg-gray-700/50 p-6 sm:p-8 rounded-xl border border-gray-700 h-full flex flex-col">
                            <h2 class="text-xl font-semibold text-gray-100 mb-6 border-b border-gray-600 pb-4">Pengaturan Sistem</h2>
                            <form action="#" method="POST" class="space-y-6 flex-grow flex flex-col">
                                <div class="flex-grow space-y-4">
                                    <div>
                                        <label for="app-name" class="block text-sm font-medium text-gray-300 mb-2">Nama Aplikasi</label>
                                        <input type="text" name="app-name" id="app-name" value="Open Recruitment Asdos" class="form-input-settings">
                                    </div>
                                    <div>
                                        <label for="recruitment-start" class="block text-sm font-medium text-gray-300 mb-2">Pendaftaran Dibuka</label>
                                        <input type="date" name="recruitment-start" id="recruitment-start" value="2025-06-01" class="form-input-settings">
                                    </div>
                                    <div>
                                        <label for="recruitment-end" class="block text-sm font-medium text-gray-300 mb-2">Pendaftaran Ditutup</label>
                                        <input type="date" name="recruitment-end" id="recruitment-end" value="2025-06-15" class="form-input-settings">
                                    </div>
                                </div>
                                <div class="flex justify-end pt-6">
                                    <button type="submit" class="bg-secondary text-primary w-full px-6 py-2.5 rounded-button hover:bg-yellow-500 font-semibold flex items-center justify-center space-x-2 transition-colors duration-200">
                                        <i class="ri-save-3-line"></i> <span>Simpan Pengaturan</span>
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div> 

    <?php 
    // Dropdown Menus (required by header buttons)
    require __DIR__ . '/components/admin_menu_dropdown.php';
    require __DIR__ . '/components/notifications_dropdown.php'; 
    
    // Mobile Menu
    require __DIR__ . '/components/mobile_menu.php'; 
    
    // Footer JS scripts
    require __DIR__ . '/components/footer_scripts.php'; 
    ?>
</body>
</html>