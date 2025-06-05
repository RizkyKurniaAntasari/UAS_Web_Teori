<?php
$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kontak Kami</title>
</head>

<body class="bg-gray-100">
    <div class="max-w-4xl mx-auto px-4 py-10">
        <h1 class="text-3xl font-bold text-center mb-8">Kontak Kami</h1>

        <p class="text-center mb-10 text-gray-600">Silakan hubungi Penanggung Jawab (PJ) kami melalui WhatsApp untuk informasi lebih lanjut.</p>

        <div class="grid md:grid-cols-2 gap-6">
            <!-- PJ 1 -->
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
                <h2 class="text-xl font-semibold mb-2">Samuel Ananta Sinulingga</h2>
                <p class="text-gray-600 mb-1">PJ Pendaftaran</p>
                <p class="text-gray-600 mb-3">+62 812 3456 7890</p>
                <a href="https://wa.me/6281234567890" target="_blank" class="inline-block bg-[#FFCC00] text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                    Hubungi via WhatsApp
                </a>
            </div>

            <!-- PJ 2 -->
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
                <h2 class="text-xl font-semibold mb-2">Rizky Kurnia Antasari</h2>
                <p class="text-gray-600 mb-1">PJ Pendaftaran</p>
                <p class="text-gray-600 mb-3">+62 899 9998 856</p>
                <a href="https://wa.me/62899998856" target="_blank" class="inline-block bg-[#FFCC00] text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                    Hubungi via WhatsApp
                </a>
            </div>

            <!-- PJ 3 -->
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
                <h2 class="text-xl font-semibold mb-2">Lekok Indah Lia</h2>
                <p class="text-gray-600 mb-1">PJ Pendaftaran</p>
                <p class="text-gray-600 mb-3">+62 899 9998 856</p>
                <a href="https://wa.me/62899998856" target="_blank" class="inline-block bg-[#FFCC00] text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                    Hubungi via WhatsApp
                </a>
            </div>

            <!-- PJ 4 -->
            <div class="bg-white shadow-lg rounded-2xl p-6 border border-gray-200">
                <h2 class="text-xl font-semibold mb-2">Nadya Arsa</h2>
                <p class="text-gray-600 mb-1">PJ Pendaftaran</p>
                <p class="text-gray-600 mb-3">+62 899 9998 856</p>
                <a href="https://wa.me/62899998856" target="_blank" class="inline-block bg-[#FFCC00] text-white px-4 py-2 rounded-lg hover:bg-yellow-500 transition">
                    Hubungi via WhatsApp
                </a>
            </div>
        </div>
    </div>
</body>
<?php
    require_once '../head-nav-foo/footer.php';
?>

</html>