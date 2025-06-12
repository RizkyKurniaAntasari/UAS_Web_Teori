document.addEventListener('DOMContentLoaded', function () {
    // --- Dropdown Logic ---
    const adminMenuBtn = document.getElementById('admin-menu-btn');
    const adminMenuDropdown = document.getElementById('admin-menu-dropdown');
    const notificationsBtn = document.getElementById('notifications-btn');
    const notificationsDropdown = document.getElementById('notifications-dropdown');

    const toggleDropdown = (targetDropdown) => {
        if (!targetDropdown) return;
        const isHidden = targetDropdown.classList.contains('hidden');
        // Hide all dropdowns first
        if (adminMenuDropdown) adminMenuDropdown.classList.add('hidden');
        if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
        // If the target was hidden, show it
        if (isHidden) {
            targetDropdown.classList.remove('hidden');
        }
    };

    if (adminMenuBtn) {
        adminMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown(adminMenuDropdown);
        });
    }

    if (notificationsBtn) {
        notificationsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown(notificationsDropdown);
        });
    }

    // Hide dropdowns if clicked outside
    window.addEventListener('click', (e) => {
        if (adminMenuDropdown && !adminMenuDropdown.contains(e.target) && !adminMenuBtn.contains(e.target)) {
            adminMenuDropdown.classList.add('hidden');
        }
        if (notificationsDropdown && !notificationsDropdown.contains(e.target) && !notificationsBtn.contains(e.target)) {
            notificationsDropdown.classList.add('hidden');
        }
    });


    // --- Mobile Menu Logic ---
    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu-button');

    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.remove('hidden');
            mobileMenu.classList.add('flex');
        });
    }
    
    if (closeMobileMenuButton && mobileMenu) {
        closeMobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.add('hidden');
            mobileMenu.classList.remove('flex');
        });
    }
});