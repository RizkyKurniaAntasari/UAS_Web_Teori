<script>
document.addEventListener('DOMContentLoaded', function () {
    const adminMenuBtn = document.getElementById('admin-menu-btn');
    const adminMenuDropdown = document.getElementById('admin-menu-dropdown');

    const toggleDropdown = (targetDropdown) => {
        if (!targetDropdown) return;
        const isHidden = targetDropdown.classList.contains('hidden');
        
        if (adminMenuDropdown) adminMenuDropdown.classList.add('hidden');
        
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

    window.addEventListener('click', (e) => {
        if (adminMenuBtn && adminMenuDropdown && !adminMenuDropdown.contains(e.target) && !adminMenuBtn.contains(e.target)) {
            adminMenuDropdown.classList.add('hidden');
        }
    });
    
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

    if (typeof initializeGenericPagination === 'function') {
        initializeGenericPagination();
    }
});
</script>

<script src="js/tableHelper.js"></script>