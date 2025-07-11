<header class="bg-primary shadow-md fixed top-0 left-0 right-0 z-50">
    <div class="flex justify-between items-center px-4 sm:px-6 lg:px-8 py-3">
        <a href="dashboard.php" class="flex items-center bg-secondary px-3 py-2 rounded-lg text-primary shadow-sm hover:opacity-90 transition-opacity duration-200">
            <img src="img/bansus.png" alt="Logo Badan Khusus" class="h-8 w-8 mr-2 object-contain">
            <div class="flex flex-col font-['Poppins']">
                <span class="text-sm font-semibold whitespace-nowrap">BADAN KHUSUS</span>
                <span class="text-xs font-medium whitespace-nowrap">HIMAKOM PERIODE 2025</span>
            </div>
        </a>
        <div class="flex items-center space-x-3 sm:space-x-4">
            <?php if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true): ?>
            <div class="relative hidden md:flex">
                <button id="admin-menu-btn" class="flex items-center space-x-2 text-gray-100 hover:text-secondary"
                    aria-label="Menu Admin" title="Menu Admin">
                    <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                         <i class="ri-user-line text-secondary"></i> 
                    </div>
                    <span class="font-medium">Admin</span>
                    <i class="ri-arrow-down-s-line"></i>
                </button>
            </div>
            <?php endif; ?>
            <div class="md:hidden">
                <button id="mobile-menu-button" title="Buka Menu" aria-label="Buka Menu" class="p-2 text-gray-200 hover:text-secondary focus:outline-none">
                    <i class="ri-menu-line ri-xl"></i>
                </button>
            </div>
        </div>
    </div>
</header>
<?php 

if (isset($_SESSION['logged_in']) && $_SESSION['logged_in'] === true) {
    require __DIR__ . '/admin_menu_dropdown.php';
}
?>