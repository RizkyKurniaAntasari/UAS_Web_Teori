<?php
require_once __DIR__ . '/../../db.php';

$nama = '';
if (isset($_SESSION['user'])) {
    $user_id = $_SESSION['user'];
    try {
        $pdo = get_pdo_connection();
        $stmt = $pdo->prepare("SELECT nama FROM asdos WHERE npm = ? LIMIT 1");
        $stmt->execute([$user_id]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($row) {
            $nama = $row['nama'];
        }
    } catch (PDOException $e) {
        error_log("Header user fetch error: " . $e->getMessage());
    }
}
?>

<!-- External Resources -->
<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" />
<link href="../../src/css/style.css" rel="stylesheet">

<!-- Responsive Header -->
<header class="bg-[#FFCC00] w-full">
    <div class="flex flex-col md:flex-row items-center justify-between px-6 md:px-16 py-2 gap-2 md:gap-0">
        <!-- Logo & Title -->
        <div class="flex items-center space-x-3">
            <img src="../../img/logo/bansus.png" alt="Logo" class="w-10 h-10 rounded-full" />
            <div class="h-10 w-px bg-black hidden sm:block"></div>
            <div class="text-center md:text-left">
                <p class="text-black font-bold text-sm leading-tight m-0">BADAN KHUSUS</p>
                <p class="text-black font-bold text-sm leading-tight m-0">HIMAKOM PERIODE 2025</p>
            </div>
        </div>

        <!-- Social Media & User -->
        <div class="flex items-center space-x-4 text-black text-lg">
            <a href="https://www.instagram.com/himakomunila" target="_blank" title="Instagram"><i class="fab fa-instagram"></i></a>
            <a href="https://youtube.com/@himakommedia" target="_blank" title="YouTube"><i class="fab fa-youtube"></i></a>
            <a href="https://x.com/himakomunila" target="_blank" title="X"><i class="fab fa-x-twitter"></i></a>
            <a href="https://www.tiktok.com/@himakomunila" target="_blank" title="TikTok"><i class="fab fa-tiktok mr-2"></i></a>

            <?php if (!empty($nama)): ?>
                <div class="relative group">
                    <img src="https://ui-avatars.com/api/?name=<?= urlencode($nama) ?>"
                        alt="Avatar"
                        class="cursor-pointer w-8 h-8 md:w-9 md:h-9 rounded-full object-cover border-2 border-white hover:border-yellow-400 transition duration-300" />

                    <!-- Dropdown -->
                    <div class="absolute right-0 w-40 bg-white rounded shadow-md z-50 hidden group-hover:block">
                        <a href="../../controller/asdos/logout_logic.php"
                            onclick="return confirm('Apakah Anda yakin ingin logout?')"
                            class="block px-4 py-2 text-sm text-gray-700 hover:bg-yellow-100">
                            Logout
                        </a>
                        <a href="../../controller/asdos/delete_account_logic.php"
                            onclick="return confirm('Apakah Anda yakin ingin menghapus akun ini? Tindakan ini tidak bisa dibatalkan.')"
                            class="block px-4 py-2 text-sm text-red-600 hover:bg-red-100">
                            Delete Account
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="../../login.php">
                    <img src="../../img/user.jpg"
                        alt="Default Avatar"
                        class="w-8 h-8 md:w-9 md:h-9 rounded-full object-cover border-2 border-white hover:border-yellow-400 transition duration-300" />
                </a>
            <?php endif; ?>
        </div>
    </div>
</header>
