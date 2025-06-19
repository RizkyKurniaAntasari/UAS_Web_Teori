<?php
/**
 * Admin Menu Dropdown Component
 * This dropdown appears when the admin icon in the header is clicked.
 * It should be included in the main layout file after the header.
 */
?>
<div id="admin-menu-dropdown" class="hidden absolute right-4 sm:right-6 lg:right-8 top-[62px] sm:top-[66px] mt-1 w-48 bg-gray-800 rounded-lg shadow-xl border border-gray-700 z-[70]">
    <div class="p-1">
        
        <hr class="my-1 border-gray-600">
        <a href="login.php?action=logout" class="block flex items-center space-x-3 px-3 py-2 text-sm text-red-400 hover:bg-gray-700 rounded-md" onclick="return confirm('Apakah Anda yakin ingin logout?');">
            <i class="ri-logout-box-r-line"></i>
            <span>Logout</span>
        </a>
    </div>
</div>