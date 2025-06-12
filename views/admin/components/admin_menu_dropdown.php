<header class="bg-[#1F2937] shadow-md fixed top-0 left-0 right-0 z-50 border-b border-gray-700">
    <div class="flex justify-between items-center px-4 sm:px-6 lg:px-8 py-3">
        <a href="dashboard.php" class="text-xl font-bold text-yellow-400">ADMIN PANEL</a>
        <div class="flex items-center space-x-3 sm:space-x-4">
            <div class="relative">
                <button id="notifications-btn" class="w-10 h-10 flex items-center justify-center text-gray-300 hover:text-yellow-400 relative">
                    <i class="ri-notification-3-line ri-lg"></i>
                    <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                </button>
            </div>
            <div class="relative hidden md:flex">
                <button id="admin-menu-btn" class="flex items-center space-x-2 text-gray-100 hover:text-yellow-400">
                    <div class="w-8 h-8 bg-gray-700 rounded-full flex items-center justify-center">
                         <i class="ri-user-line text-yellow-400"></i> 
                    </div>
                    <span class="font-medium">Admin</span>
                    <i class="ri-arrow-down-s-line"></i>
                </button>
            </div>
            <div class="md:hidden">
                <button id="mobile-menu-button" class="p-2 text-gray-200 hover:text-yellow-400">
                    <i class="ri-menu-line ri-xl"></i>
                </button>
            </div>
        </div>
    </div>
</header>