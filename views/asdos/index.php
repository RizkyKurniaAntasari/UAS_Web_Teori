<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
?>
<!-- Data Matkul -->
<?php
            $matkul = [
                [
                    'nama' => 'Logika',
                    'dosen' => 'Ani Rose Irawati, S.T., M.Cs.',
                    'kuota' => 10
                ],
                [
                    'nama' => 'Basis Data',
                    'dosen' => 'Dr. Aristoteles, S.Si., M.Si.',
                    'kuota' => 8
                ],
                [
                    'nama' => 'Multimedia',
                    'dosen' => 'Yunda Heningtyas, M. Kom.',
                    'kuota' => 4
                ],
                [
                    'nama' => 'Pem. Interpreter',
                    'dosen' => 'Rahman Taufik, M.Kom',
                    'kuota' => 4
                ],
                [
                    'nama' => 'Komdat Jarkom',
                    'dosen' => 'RICO ANDRIAN, S.Si., M.Kom.',
                    'kuota' => 8
                ],
                [
                    'nama' => 'DDP',
                    'dosen' => 'Dwi Sakethi, S.Si., M.Kom.',
                    'kuota' => 10
                ],
                [
                    'nama' => 'Matematika',
                    'dosen' => 'Dewi Asiah Shofiana, M.Kom',
                    'kuota' => 10
                ],
                [
                    'nama' => 'PBO',
                    'dosen' => 'DIDIK KURNIAWAN S.SI, M.T',
                    'kuota' => 8
                ],
            ];
            ?>

<!DOCTYPE html>
<html lang="id">
<html class="scroll-smooth">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Open Recruitment Asisten Dosen Ganjil 2025</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link
        href="https://fonts.googleapis.com/css2?family=Pacifico&display=swap"
        rel="stylesheet" />
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap"
        rel="stylesheet" />
    <link
        rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/remixicon/4.6.0/remixicon.min.css" />
    <style>
        /* Keeping custom styles that are not part of Tailwind defaults */

        .timeline-container::after {
            content: "";
            position: absolute;
            width: 100%;
            height: 4px;
            background-color: #e5e7eb;
            top: 50%;
            transform: translateY(-50%);
            z-index: -1;
        }

        .slider-container {
            position: relative;
            overflow: hidden;
            height: 600px;
        }

        .slider {
            display: flex;
            transition: transform 0.5s ease-in-out;
            height: 100%;
        }

        .slide {
            min-width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            position: relative;
        }

        .slide-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(to right,
                    rgba(0, 0, 0, 0.7) 0%,
                    rgba(0, 0, 0, 0.3) 50%,
                    rgba(0, 0, 0, 0) 100%);
            display: flex;
            flex-direction: column;
            justify-content: center;
            padding-left: 10%;
        }

        .slide-content {
            max-width: 600px;
        }

        .slider-nav {
            position: absolute;
            bottom: 20px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 10px;
        }

        .slider-dot {
            width: 12px;
            height: 12px;
            border-radius: 50%;
            background-color: rgba(255, 255, 255, 0.5);
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .slider-dot.active {
            background-color: #fff;
        }

        input[type="checkbox"] {
            appearance: none;
            -webkit-appearance: none;
            width: 20px;
            height: 20px;
            border: 2px solid #d1d5db;
            border-radius: 4px;
            outline: none;
            cursor: pointer;
            position: relative;
        }

        input[type="checkbox"]:checked {
            background-color: #ffcc00;
            /* warna kuning */
            border-color: #ffcc00;
            /* warna kuning */
        }

        input[type="checkbox"]:checked::after {
            content: "";
            position: absolute;
            width: 5px;
            height: 10px;
            border: solid white;
            border-width: 0 2px 2px 0;
            top: 2px;
            left: 6px;
            transform: rotate(45deg);
        }

        .search-input:focus {
            outline: none;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.3);
        }
    </style>
</head>

<body class="bg-gray-50">
    <section id="beranda" class="">
        <div class="slider-container">
            <div class="slider">
                <div class="slide" style="background-image: url('../../img/FOTO/DSC_1801.JPG')">
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
                <div class="slide" style="background-image: url('../../img/FOTO/IMG_6726.JPG')">
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
                <div class="slide" style="background-image: url('../../img/FOTO/DSCF9427.JPG')">
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
                <div class="slide" style="background-image: url('../../img/FOTO/IMG_0286.JPG')">
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
                <div class="slide" style="background-image: url('../../img/FOTO/IMG_5465.JPG')">
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
    <section class="py-20 bg-gray-50">
        <div id="matakuliah" class="container mx-auto px-4 scroll-mt-10">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-gray-900 mb-4">
                    Daftar Mata Kuliah
                </h2>
                <p class="text-gray-600 max-w-2xl mx-auto">
                    Berikut adalah daftar mata kuliah yang membuka rekrutmen asisten
                    dosen untuk semester Ganjil 2025
                </p>
            </div>
            <div class="mb-8 flex flex-col md:flex-row gap-4 justify-between">
                <div class="relative w-full md:w-96">
                    <input
                        type="text"
                        id="search-matkul"
                        placeholder="Cari mata kuliah..."
                        class="w-full pl-10 pr-4 py-3 bg-white border border-gray-200 rounded-lg search-input" />
                    <div
                        class="absolute left-3 top-1/2 transform -translate-y-1/2 w-5 h-5 flex items-center justify-center text-gray-400">
                        <i class="ri-search-line"></i>
                    </div>
                </div>
                <div class="flex flex-wrap gap-3">
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="filter_all" checked />
                        <label for="filter_all" class="text-sm text-gray-700">Semua</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="filter_ilmukomputer" />
                        <label for="filter_ilmukomputer" class="text-sm text-gray-700">Ilmu Komputer</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="filter_sistem_informasi" />
                        <label for="filter_sistem_informasi" class="text-sm text-gray-700">Sistem Informasi</label>
                    </div>
                    <div class="flex items-center gap-2">
                        <input type="checkbox" id="filter_manajemeninformasir" />
                        <label for="filter_manajemeninformasir" class="text-sm text-gray-700">D3 Manajemen Informatika</label>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                <?php foreach ($matkul as $m):

                ?>
                    <div class="bg-white rounded-lg shadow-sm overflow-hidden hover:shadow-md transition-shadow">
                        <div class="p-5">
                            <div class="flex justify-between items-start mb-1">
                                <h3 class="text-lg font-semibold text-gray-900"><?= htmlspecialchars($m['nama']) ?></h3>
                                <span class="bg-black text-yellow-500 text-xs px-2 py-1 rounded-full"><?= htmlspecialchars($m['dosen']) ?></span>
                            </div>

                            <div class="flex justify-between items-center">
                                <p class="text-xs text-gray-500">Kuota Tersedia <?= $m['kuota'] ?></p>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>

            <div class="mt-10 flex justify-center">
                <div class="inline-flex rounded-md shadow-sm">
                    <button
                        class="px-3 py-2 border border-gray-300 bg-white text-gray-500 rounded-l-lg hover:bg-gray-50 rounded-lg whitespace-nowrap">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="ri-arrow-left-s-line"></i>
                        </div>
                    </button>
                    <button
                        class="px-4 py-2 border-t border-b border-r border-gray-300 bg-yellow-500 text-white hover:bg-yellow-400 rounded-lg whitespace-nowrap">
                        1
                    </button>
                    <button
                        class="px-4 py-2 border-t border-b border-r border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-lg whitespace-nowrap">
                        2
                    </button>
                    <button
                        class="px-4 py-2 border-t border-b border-r border-gray-300 bg-white text-gray-700 hover:bg-gray-50 rounded-lg whitespace-nowrap">
                        3
                    </button>
                    <button
                        class="px-3 py-2 border-t border-b border-r border-gray-300 bg-white text-gray-500 rounded-r-lg hover:bg-gray-50 rounded-lg whitespace-nowrap">
                        <div class="w-5 h-5 flex items-center justify-center">
                            <i class="ri-arrow-right-s-line"></i>
                        </div>
                    </button>
                </div>
            </div>
        </div>
    </section>
    <section id="daftar" class="py-20 bg-black text-white">
        <div class="container mx-auto px-4">
            <div class="max-w-3xl mx-auto text-center">
                <h2 class="text-3xl font-bold mb-6">
                    Siap Menjadi Bagian dari Tim Asdos Ganjil 2025?
                </h2>
                <p class="text-lg mb-8 opacity-90">
                    Jangan lewatkan kesempatan untuk mengembangkan kemampuan akademik
                    dan soft skill Anda. Daftar sekarang dan jadilah bagian dari tim
                    asisten dosen semester Ganjil 2025!
                </p>
                <a
                    href="#beranda"
                    class="inline-block bg-yellow-500 text-white font-semibold py-3 px-8 rounded-lg shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-1 whitespace-nowrap">
                    Daftar Sekarang
                </a>
                <p class="mt-6 text-sm opacity-80">
                    Pendaftaran ditutup pada 14 Juli 2025, pukul 23:59 WIB
                </p>
            </div>
        </div>
    </section>

    <?php require_once '../head-nav-foo/footer.php'; ?>

    <script id="slider-script">
        document.addEventListener("DOMContentLoaded", function() {
            const slider = document.querySelector(".slider");
            const slides = document.querySelectorAll(".slide");
            const dots = document.querySelectorAll(".slider-dot");
            let currentSlide = 0;
            const slideCount = slides.length;

            function goToSlide(index) {
                slider.style.transform = `translateX(-${index * 100}%)`;
                dots.forEach((dot) => dot.classList.remove("active"));
                dots[index].classList.add("active");
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
        });
    </script>

    <script id="search-filter-script">
        document.addEventListener("DOMContentLoaded", function() {
            const searchInput = document.getElementById("search-matkul");
            const filterAll = document.getElementById("filter_all");
            const filterIlmuKomputer = document.getElementById("filter_ilmukomputer");
            const filterSistemInformasi = document.getElementById(
                "filter_sistem_informasi",
            );
            const filterManajemenInformatika = document.getElementById(
                "filter_manajemeninformasir",
            );
            
            searchInput.addEventListener("input", function() {
                console.log("Searching for:", this.value);
            });
            filterAll.addEventListener("change", function() {
                if (this.checked) {
                    filterIlmuKomputer.checked = false;
                    filterSistemInformasi.checked = false;
                    filterManajemenInformatika.checked = false;
                }
            });
            [filterIlmuKomputer, filterSistemInformasi, filterManajemenInformatika].forEach(
                (filter) => {
                    filter.addEventListener("change", function() {
                        if (this.checked) {
                            filterAll.checked = false;
                        }
                        if (
                            !filterIlmuKomputer.checked &&
                            !filterSistemInformasi.checked &&
                            !filterManajemenInformatika.checked
                        ) {
                            filterAll.checked = true;
                        }
                    });
                },
            );
        });
    </script>

    <script>
        function toggleAccordion(id) {
            const element = document.getElementById(id);
            const arrow = document.getElementById(`${id}-arrow`);
            if (element.classList.contains('hidden')) {
                element.classList.remove('hidden');
                arrow.classList.remove('rotate-180');
            } else {
                element.classList.add('hidden');
                arrow.classList.add('rotate-180');
            }
        }
    </script>

</body>

</html>