<nav class="bg-black text-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-12">
            <!-- Desktop Menu (di tengah) -->
            <div class="hidden md:flex flex-1 justify-center">
                <ul class="flex space-x-10 text-sm font-semibold uppercase">
                    <li><a href="index.php" class="<?php echo ($currentPage == 'index.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Beranda</a></li>
                    <li><a href="daftar_asdos.php" class="<?php echo ($currentPage == 'daftar_asdos.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Daftar Asdos</a></li>
                    <li><a href="jadwal_wawancara.php" class="<?php echo ($currentPage == 'jadwal_wawancara.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Jadwal Wawancara</a></li>
                    <li><a href="pengumuman.php" class="<?php echo ($currentPage == 'pengumuman.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Hasil Seleksi</a></li>
                    <li><a href="kontak_kami.php" class="<?php echo ($currentPage == 'kontak_kami.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Kontak Kami</a></li>
                </ul>
            </div>

            <!-- Hamburger Icon -->
            <div class="md:hidden">
                <button id="menu-toggle" class="focus:outline-none">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" stroke-width="2"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                </button>
            </div>
        </div>
    </div>

    <!-- Mobile Menu -->
    <ul id="mobile-menu" class="md:hidden hidden flex-col px-4 pb-4 space-y-2 text-sm font-semibold uppercase">
        <li><a href="index.php" class="<?php echo ($currentPage == 'index.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Beranda</a></li>
        <li><a href="daftar_asdos.php" class="<?php echo ($currentPage == 'daftar_asdos.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Daftar Asdos</a></li>
        <li><a href="jadwal_wawancara.php" class="<?php echo ($currentPage == 'jadwal_wawancara.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Jadwal Wawancara</a></li>
        <li><a href="pengumuman.php" class="<?php echo ($currentPage == 'pengumuman.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Hasil Seleksi</a></li>
        <li><a href="kontak_kami.php" class="<?php echo ($currentPage == 'kontak_kami.php') ? 'text-[#ffcc00]' : 'hover:text-[#ffcc00]'; ?>">Kontak Kami</a></li>
    </ul>
</nav>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const toggleBtn = document.getElementById("menu-toggle");
        const mobileMenu = document.getElementById("mobile-menu");

        toggleBtn.addEventListener("click", () => {
            mobileMenu.classList.toggle("hidden");
        });
    });
</script>
