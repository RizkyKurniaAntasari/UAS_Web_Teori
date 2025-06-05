document.addEventListener('DOMContentLoaded', function () {
    const notificationsBtn = document.getElementById('notifications-btn');
    const notificationsDropdown = document.getElementById('notifications-dropdown');
    const adminMenuBtn = document.getElementById('admin-menu-btn');
    const adminMenuDropdown = document.getElementById('admin-menu-dropdown');

    const mobileMenuButton = document.getElementById('mobile-menu-button');
    const mobileMenu = document.getElementById('mobile-menu');
    const closeMobileMenuButton = document.getElementById('close-mobile-menu-button');

    function toggleDropdown(button, dropdown) {
        if (!dropdown) return;
        const isVisible = !dropdown.classList.contains('hidden');
        
        if (dropdown !== notificationsDropdown && notificationsDropdown) notificationsDropdown.classList.add('hidden');
        if (dropdown !== adminMenuDropdown && adminMenuDropdown) adminMenuDropdown.classList.add('hidden');

        if (isVisible) {
            dropdown.classList.add('hidden');
        } else {
            dropdown.classList.remove('hidden');
        }
    }

    function hideAllDropdowns() {
        if (notificationsDropdown) notificationsDropdown.classList.add('hidden');
        if (adminMenuDropdown) adminMenuDropdown.classList.add('hidden');
    }

    if (notificationsBtn) {
        notificationsBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown(notificationsBtn, notificationsDropdown);
        });
    }

    if (adminMenuBtn) {
        adminMenuBtn.addEventListener('click', (e) => {
            e.stopPropagation();
            toggleDropdown(adminMenuBtn, adminMenuDropdown);
        });
    }

    
    if (mobileMenuButton && mobileMenu) {
        mobileMenuButton.addEventListener('click', function() {
            if (mobileMenu) {
                mobileMenu.classList.remove('hidden');
                mobileMenu.classList.add('flex');
            }
        });
    }
    if (closeMobileMenuButton && mobileMenu) {
            closeMobileMenuButton.addEventListener('click', function() {
            if (mobileMenu) {
                mobileMenu.classList.add('hidden');
                mobileMenu.classList.remove('flex');
            }
        });
    }

    
    document.addEventListener('click', (e) => {
        let clickedInsideADropdown = false;
        if (notificationsDropdown && notificationsDropdown.contains(e.target)) clickedInsideADropdown = true;
        if (adminMenuDropdown && adminMenuDropdown.contains(e.target)) clickedInsideADropdown = true;

        let clickedOnAButton = false;
        if (notificationsBtn && notificationsBtn.contains(e.target)) clickedOnAButton = true;
        if (adminMenuBtn && adminMenuBtn.contains(e.target)) clickedOnAButton = true;

        if (!clickedInsideADropdown && !clickedOnAButton) {
            hideAllDropdowns();
        }
    });

    
    if (mobileMenu) {
        const mobileLinks = mobileMenu.querySelectorAll('a');
        mobileLinks.forEach(link => {
            link.addEventListener('click', function (event) {
                const href = link.getAttribute('href');
                if (href && href.startsWith('#') && href.length > 1 && !href.startsWith('#!')) {
                    if(href === '#profile' || href === '#logout') { 
                            mobileMenu.classList.add('hidden');
                            mobileMenu.classList.remove('flex');
                    }
                } else if (href && !href.startsWith('#')) { 
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('flex');
                }
            });
        });
    }

    
    const selectAllCheckbox = document.getElementById('select-all-pendaftar');
    const pendaftarCheckboxes = document.querySelectorAll('input[name="pendaftar_ids[]"]');
    if(selectAllCheckbox && pendaftarCheckboxes.length > 0) {
        selectAllCheckbox.addEventListener('change', function() {
            pendaftarCheckboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });
    }
});

document.addEventListener("DOMContentLoaded", function () {
    document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
        anchor.addEventListener("click", function (e) {
            const targetId = this.getAttribute("href");
            if (targetId === "#" || targetId.startsWith("#!") || targetId === "#profile" || targetId === "#settings" || targetId === "#logout" ) return;

            if (this.closest('#notifications-dropdown') || this.closest('#admin-menu-dropdown')) {
                return;
            }

            let targetElement;
            try {
                targetElement = document.querySelector(targetId);
            } catch (error) {
                console.warn("Smooth scroll target not found or invalid selector:", targetId);
                return;
            }

            if (targetElement) {
                e.preventDefault();
                const adminHeader = document.querySelector("header.fixed");
                const headerHeight = adminHeader ? adminHeader.offsetHeight : 0;
                const targetPosition = targetElement.offsetTop - headerHeight - 20;

                window.scrollTo({
                    top: targetPosition,
                    behavior: "smooth",
                });
                const mobileMenu = document.getElementById('mobile-menu');
                if(mobileMenu && mobileMenu.classList.contains('flex')){
                    mobileMenu.classList.add('hidden');
                    mobileMenu.classList.remove('flex');
                }
            }
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const slider = document.querySelector(".slider");
    if (!slider) return;
    const slides = slider.querySelectorAll(".slide");
    const dots = document.querySelectorAll(".slider-dot");
    if (slides.length === 0 || dots.length === 0) return;

    let currentSlide = 0;
    const slideCount = slides.length;

    function goToSlide(index) {
        slider.style.transform = `translateX(-${index * 100}%)`;
        dots.forEach((dot) => dot.classList.remove("active", "bg-secondary"));
        dots.forEach((dot) => dot.classList.add("bg-white/50"));
        if (dots[index]) {
            dots[index].classList.add("active", "bg-secondary");
            dots[index].classList.remove("bg-white/50");
        }
        currentSlide = index;
    }

    dots.forEach((dot, index) => {
        dot.addEventListener("click", () => {
            goToSlide(index);
        });
    });

    function nextSlide() {
        let next = currentSlide + 1;
        if (next >= slideCount) {
            next = 0;
        }
        goToSlide(next);
    }

    const slideInterval = setInterval(nextSlide, 5000);
    slider.addEventListener("mouseenter", () => {
        clearInterval(slideInterval);
    });
    if (slideCount > 0) {
        goToSlide(0);
    }
});