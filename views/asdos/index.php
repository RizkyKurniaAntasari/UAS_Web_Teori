<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
require_once '../../../db.php';

try {
    $pdo = get_pdo_connection();
    $stmt = $pdo->query("SELECT nama, dosen, kuota FROM mata_kuliah WHERE status = 'Aktif' ORDER BY nama");
    $matkul_list = $stmt->fetchAll();
} catch (PDOException $e) {
    $matkul_list = [];
    error_log("Failed to fetch mata kuliah list for index: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html class="scroll-smooth">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Open Recruitment Asisten Dosen Ganjil 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    <style>
        .slider { display: flex; transition: transform 0.5s ease-in-out; }
        .slide { min-width: 100%; }
    </style>
</head>
<body class="bg-gray-50">
    <section id="beranda" class="relative overflow-hidden h-[600px]">
        <div class="slider h-full">
            <div class="slide bg-cover bg-center" style="background-image: url('../../img/FOTO/DSC_1801.JPG')"></div>
            <div class="slide bg-cover bg-center" style="background-image: url('../../img/FOTO/IMG_6726.JPG')"></div>
            <div class="slide bg-cover bg-center" style="background-image: url('../../img/FOTO/DSCF9427.JPG')"></div>
        </div>
        <div class="absolute inset-0 bg-gradient-to-r from-black/70 to-black/0 flex items-center p-8 sm:p-16">
            <div class="max-w-xl text-white">
                <h1 class="text-4xl md:text-5xl font-bold mb-4">Open Recruitment Asisten Dosen Ganjil 2025</h1>
                <p class="text-lg mb-8">Jadilah bagian dari tim pengajar dan kembangkan potensi akademik Anda.</p>
                <a href="daftar_asdos.php" class="bg-yellow-500 hover:bg-yellow-600 font-semibold py-3 px-8 rounded-lg inline-flex items-center">
                    Daftar Sekarang <i class="ri-arrow-right-line ml-2"></i>
                </a>
            </div>
        </div>
    </section>

    <section id="matakuliah" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4 scroll-mt-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Daftar Mata Kuliah</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Mata kuliah yang membuka rekrutmen asisten dosen untuk semester Ganjil 2025.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php if(empty($matkul_list)): ?>
                    <p class="col-span-full text-center text-gray-500">Informasi mata kuliah belum tersedia.</p>
                <?php else: ?>
                    <?php foreach ($matkul_list as $m): ?>
                        <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                            <div class="p-5">
                                <h3 class="text-lg font-semibold text-gray-900 truncate"><?= htmlspecialchars($m['nama']) ?></h3>
                                <p class="text-sm text-gray-600 mb-2 truncate">Dosen: <?= htmlspecialchars($m['dosen']) ?></p>
                                <span class="bg-black text-yellow-500 text-xs font-medium px-2.5 py-1 rounded-full">Kuota: <?= htmlspecialchars($m['kuota']) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>
    </section>

    <?php require_once '../head-nav-foo/footer.php'; ?>
</body>
</html>