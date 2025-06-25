<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
require_once '../../db.php';

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
    <link rel="preload" as="image" href="../../img/FOTO/DSC_1801.webp" type="image/webp">
    <link rel="preload" as="image" href="../../img/FOTO/IMG_6726.webp" type="image/webp">
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    <link rel="stylesheet" href="style/index_style.css">
    <style>
        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }

        .slide {
            min-width: 100%;
            background-size: cover;
            background-position: center;
        }
    </style>
</head>

<body class="bg-gray-50 flex flex-col min-h-screen">
    <section id="beranda" class="">
        <div class="slider-container">
            <div class="slider">
                <div class="slide" style="background-image: url('../../img/FOTO/DSC_1801.webp')">
                    <div class="slide-overlay">
                        <div class="slide-content">
                            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                                Open Recruitment Asisten Dosen Ganjil 2025
                            </h1>
                            <p class="text-white text-lg mb-8">
                                Jadilah bagian dari tim pengajar dan kembangkan potensi
                                akademik Anda bersama kami
                            </p>
                            <a
                                href="daftar_asdos.php"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-lg whitespace-nowrap inline-flex items-center">
                                Daftar Sekarang
                                <div class="w-5 h-5 ml-2 flex items-center justify-center">
                                    <i class="ri-arrow-right-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="slide" style="background-image: url('../../img/FOTO/IMG_6726.webp')">
                    <div class="slide-overlay">
                        <div class="slide-content">
                            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                                Tingkatkan Kemampuan Akademik Anda
                            </h1>
                            <p class="text-white text-lg mb-8">
                                Menjadi asisten dosen membuka peluang untuk mengembangkan soft
                                skill dan hard skill Anda
                            </p>
                            <a
                                href="daftar_asdos.php"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-lg whitespace-nowrap inline-flex items-center">
                                Daftar Sekarang
                                <div class="w-5 h-5 ml-2 flex items-center justify-center">
                                    <i class="ri-arrow-right-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="slide" style="background-image: url('../../img/FOTO/DSCF9427.webp')">
                    <div class="slide-overlay">
                        <div class="slide-content">
                            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                                Berbagi Pengetahuan, Tumbuh Bersama
                            </h1>
                            <p class="text-white text-lg mb-8">
                                Bergabunglah dengan komunitas asisten dosen dan bantu
                                mahasiswa lain untuk berkembang
                            </p>
                            <a
                                href="daftar_asdos.php"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-lg whitespace-nowrap inline-flex items-center">
                                Daftar Sekarang
                                <div class="w-5 h-5 ml-2 flex items-center justify-center">
                                    <i class="ri-arrow-right-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="slide" style="background-image: url('../../img/FOTO/IMG_0286.webp')">
                    <div class="slide-overlay">
                        <div class="slide-content">
                            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                                Konfersi Mata Kuliah sebagai Benefit
                            </h1>
                            <p class="text-white text-lg mb-8">
                                Pengalaman Anda sebagai Asisten Dosen dapat dikonfersikan ke matakuliah Tugas Khusus
                            </p>
                            <a
                                href="daftar_asdos.php"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-lg whitespace-nowrap inline-flex items-center">
                                Daftar Sekarang
                                <div class="w-5 h-5 ml-2 flex items-center justify-center">
                                    <i class="ri-arrow-right-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
                <div class="slide" style="background-image: url('../../img/FOTO/IMG_5465.webp')">
                    <div class="slide-overlay">
                        <div class="slide-content">
                            <h1 class="text-4xl md:text-5xl font-bold text-white mb-4">
                                Memperkaya CV Anda
                            </h1>
                            <p class="text-white text-lg mb-8">
                                Pengalaman Anda sebagai Asisten Dosen akan memperkaya CV dan Portofolio Anda
                            </p>
                            <a
                                href="daftar_asdos.php"
                                class="bg-yellow-500 hover:bg-yellow-600 text-white font-semibold py-3 px-8 rounded-lg whitespace-nowrap inline-flex items-center">
                                Daftar Sekarang
                                <div class="w-5 h-5 ml-2 flex items-center justify-center">
                                    <i class="ri-arrow-right-line"></i>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="slider-nav">
                <div class="slider-dot active"></div>
                <div class="slider-dot"></div>
                <div class="slider-dot"></div>
                <div class="slider-dot"></div>
                <div class="slider-dot"></div>
            </div>
        </div>
    </section>

    <section class="py-20 bg-gray-50">
        <div id="syarat" class="container mx-auto px-4 scroll-mt-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Syarat dan Komitmen
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Berikut adalah persyaratan yang harus dipenuhi untuk menjadi asisten
                    dosen pada semester Ganjil 2025
                </p>
            </div>
            <div class="max-w-4xl mx-auto">
                <div class="space-y-4">
                    <!-- Persyaratan -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <button onclick="toggleAccordion('akademik')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="ri-user-line ri-lg text-yellow-500"></i>
                                </div>
                                <h3 class="text-xl font-semibold">Persyaratan</h3>
                            </div>
                            <i class="ri-arrow-down-s-line text-2xl text-gray-500 transition-transform" id="akademik-arrow"></i>
                        </button>
                        <div id="akademik" class="hidden px-6 pb-6">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <div class="w-5 h-5 flex items-center justify-center mt-0.5 mr-2 text-yellow-500">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                    <span>Mahasiswa Aktif Jurusan Ilmu Komputer Universitas Lampung angkatan 2024, 2023 dan 2022.</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-5 h-5 flex items-center justify-center mt-0.5 mr-2 text-yellow-500">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                    <span>Lulus mata kuliah pilihan yang dipilih.</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-5 h-5 flex items-center justify-center mt-0.5 mr-2 text-yellow-500">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                    <span>Mengupload Surat Pernyataan</span>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <!-- Komitmen -->
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden">
                        <button onclick="toggleAccordion('komitmen')" class="w-full px-6 py-4 flex items-center justify-between hover:bg-gray-50 transition-colors">
                            <div class="flex items-center">
                                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center mr-4">
                                    <i class="ri-time-line ri-lg text-yellow-500"></i>
                                </div>
                                <h3 class="text-xl font-semibold">Komitmen</h3>
                            </div>
                            <i class="ri-arrow-down-s-line text-2xl text-gray-500 transition-transform" id="komitmen-arrow"></i>
                        </button>
                        <div id="komitmen" class="hidden px-6 pb-6">
                            <ul class="space-y-3">
                                <li class="flex items-start">
                                    <div class="w-5 h-5 flex items-center justify-center mt-0.5 mr-2 text-yellow-500">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                    <span>Bersedia mengikuti ketentuan yang nantinya ditetapkan.</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-5 h-5 flex items-center justify-center mt-0.5 mr-2 text-yellow-500">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                    <span>Bersedia mengajar 1 semester dengan penuh tanggungjawab.</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-5 h-5 flex items-center justify-center mt-0.5 mr-2 text-yellow-500">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                    <span>Berpartisipasi dalam kegiatan Forum Silaturahmi (FoSi) Asdos.</span>
                                </li>
                                <li class="flex items-start">
                                    <div class="w-5 h-5 flex items-center justify-center mt-0.5 mr-2 text-yellow-500">
                                        <i class="ri-checkbox-circle-line"></i>
                                    </div>
                                    <span>Berpartisipasi dalam kegiatan Pelatihan Asisten Dosen.</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <div class="inline-flex items-center text-yellow-500">
                    <div class="w-5 h-5 flex items-center justify-center mr-2">
                        <i class="ri-information-line"></i>
                    </div>
                    <span>Pendaftaran hanya dapat dilakukan melalui sistem online. Dokumen
                        fisik tidak diperlukan pada tahap awal.</span>
                </div>
            </div>
        </div>
    </section>

    <section id="timeline" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <div class="text-center mb-16">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Timeline Pendaftaran
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Berikut adalah jadwal dan tahapan proses seleksi asisten dosen untuk
                    semester Ganjil 2025
                </p>
            </div>
            <div class="relative timeline-container max-w-4xl mx-auto px-4 py-6 bg-gray-50">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                    <div class="flex flex-col items-center">
                        <div
                            class="w-16 h-16 bg-black rounded-full border-4 border-yellow-500 flex items-center justify-center mb-4">
                            <div
                                class="w-8 h-8 flex items-center justify-center text-yellow-500">
                                <i class="ri-file-upload-line ri-lg"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h4 class="font-semibold text-gray-900">Pendaftaran</h4>
                            <p class="text-sm text-gray-600 mt-1">1 - 7 Juli 2025</p>
                            <p class="text-xs text-gray-500 mt-2">
                                Pengisian formulir dan upload surat pernyataan
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div
                            class="w-16 h-16 bg-black rounded-full border-4 border-yellow-500 flex items-center justify-center mb-4">
                            <div
                                class="w-8 h-8 flex items-center justify-center text-yellow-500">
                                <i class="ri-user-voice-line ri-lg"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h4 class="font-semibold text-gray-900">Wawancara</h4>
                            <p class="text-sm text-gray-600 mt-1">28 Juli - 02 Agustus 2025</p>
                            <p class="text-xs text-gray-500 mt-2">
                                Wawancara dengan Badan Khusus atau Dosen Pengampu Mata Kuliah
                            </p>
                        </div>
                    </div>
                    <div class="flex flex-col items-center">
                        <div
                            class="w-16 h-16 bg-black rounded-full border-4 border-yellow-500 flex items-center justify-center mb-4">
                            <div
                                class="w-8 h-8 flex items-center justify-center text-yellow-500">
                                <i class="ri-medal-line ri-lg"></i>
                            </div>
                        </div>
                        <div class="text-center">
                            <h4 class="font-semibold text-gray-900">Pengumuman</h4>
                            <p class="text-sm text-gray-600 mt-1">05 Agustus 2025</p>
                            <p class="text-xs text-gray-500 mt-2">
                                Pengumuman hasil seleksi
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="mt-12 text-center">
                <div
                    class="inline-flex items-center bg-yellow-100 text-yellow-500 px-4 py-2 rounded-lg">
                    <div class="w-5 h-5 flex items-center justify-center mr-2">
                        <i class="ri-calendar-check-line"></i>
                    </div>
                    <span class="font-medium">Saat ini: Pendaftaran Asisten Dosen Ganjil 2025 Belum Dibuka</span>
                </div>
            </div>
        </div>
    </section>

    <section id="matakuliah" class="py-20 bg-gray-50 flex-grow w-full">
        <div class="container mx-auto px-4 scroll-mt-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">Daftar Mata Kuliah</h2>
                <p class="text-gray-600 max-w-2xl mx-auto">Mata kuliah yang membuka rekrutmen asisten dosen untuk semester Ganjil 2025.</p>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php if (empty($matkul_list)): ?>
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
    <script src="js/index_script.js"></script>
</body>

</html>

