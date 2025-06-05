<?php
if (!isset($currentPage)) {
    $currentPage = ''; 
}

if (!function_exists('isActiveMobile')) { 
    function isActiveMobile($pageName, $currentPage) {
        return ($pageName === $currentPage) ? 'text-secondary bg-gray-700/50' : 'text-gray-200 hover:text-secondary hover:bg-gray-700/30';
    }
}
?>
<div id="mobile-menu" class="fixed inset-0 bg-primary z-[60] hidden flex-col pt-0 md:hidden">
    <div class="flex justify-between items-center p-4 border-b border-gray-700">
        <a href="dashboard.php" class="text-xl font-['Pacifico'] text-secondary">BANSUSS</a>
        <button id="close-mobile-menu-button" title="Tutup Menu" aria-label="Tutup Menu" class="p-2 text-gray-200 hover:text-secondary focus:outline-none">
            <i class="ri-close-line ri-xl"></i>
        </button>
    </div>
    <div class="container mx-auto px-4 py-4 flex-1 overflow-y-auto">
        <a href="dashboard.php" 
            class="block py-3 text-lg font-medium border-b border-gray-700 <?php echo isActiveMobile('dashboard', $currentPage); ?> rounded-md px-3">
            Dashboard
        </a>
        <a href="pendaftar.php" 
            class="block py-3 text-lg font-medium border-b border-gray-700 <?php echo isActiveMobile('pendaftar', $currentPage); ?> rounded-md px-3">
            Pendaftar
        </a>
        <a href="jadwal_wawancara.php" 
            class="block py-3 text-lg font-medium border-b border-gray-700 <?php echo isActiveMobile('jadwal_wawancara', $currentPage); ?> rounded-md px-3">
            Jadwal Wawancara
        </a> 
        <a href="pengumuman_admin.php" 
            class="block py-3 text-lg font-medium border-b border-gray-700 <?php echo isActiveMobile('pengumuman', $currentPage); ?> rounded-md px-3">
            Pengumuman
        </a> 
        <a href="pengaturan_admin.php" 
            class="block py-3 text-lg font-medium border-b border-gray-700 <?php echo isActiveMobile('pengaturan', $currentPage); ?> rounded-md px-3">
            Pengaturan
        </a>
        <div class="mt-6 border-t border-gray-700 pt-6">
             <a href="login.php?action=logout"
                class="flex items-center space-x-3 px-3 py-3 text-lg text-red-400 hover:text-red-300 hover:bg-gray-700/30 rounded-md">
                <div class="w-5 h-5 flex items-center justify-center"><i class="ri-logout-box-r-line"></i></div>
                <span>Logout</span>
            </a>
        </div>
    </div>
</div>