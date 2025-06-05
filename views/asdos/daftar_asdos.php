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
    <title>Daftar Asisten Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <section class="p-8 max-w-4xl mx-auto bg-white shadow-md rounded-md mb-10 mt-8">
        <h2 class="text-center text-3xl font-bold text-black mb-10  ">Form Pendaftaran Asisten Dosen</h2>
        <form action="#" method="POST" enctype="multipart/form-data" class="space-y-5" autocomplete="off">

            <!-- Nama Lengkap -->
            <div>
                <label class="block font-bold mb-1">Nama Lengkap</label>
                <input type="text" name="nama" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
            </div>

            <!-- NPM -->
            <div>
                <label class="block font-bold mb-1">NPM</label>
                <input type="text" name="npm" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
            </div>

            <!-- Handphone -->
            <div>
                <label class="block font-bold mb-1">No. Whatsapp</label>
                <input type="wa" name="wa" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
            </div>

            <!-- Mata Kuliah Pilihan 1 -->
            <div>
                <label class="block font-bold mb-1">Mata Kuliah Pilihan 1</label>
                <select name="matkul1" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled selected>Pilih Mata Kuliah</option>
                    <option>Algoritma & Struktur Data</option>
                    <option>Pemrograman Web</option>
                    <option>Sistem Operasi</option>
                    <option>Jaringan Komputer</option>
                    <option>Pemrograman Berorientasi Objek</option>
                    <option>Basis Data</option>
                    <option>AI Dasar</option>
                    <option>Statistik Komputasi</option>
                </select>
            </div>

            <!-- Mata Kuliah Pilihan 2 -->
            <div>
                <label class="block font-bold mb-1">Mata Kuliah Pilihan 2</label>
                <select name="matkul2" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled selected>Pilih Mata Kuliah</option>
                    <option>Algoritma & Struktur Data</option>
                    <option>Pemrograman Web</option>
                    <option>Sistem Operasi</option>
                    <option>Jaringan Komputer</option>
                    <option>Pemrograman Berorientasi Objek</option>
                    <option>Basis Data</option>
                    <option>AI Dasar</option>
                    <option>Statistik Komputasi</option>
                </select>
            </div>

            <!-- Alasan -->
            <div>
                <label class="block font-bold mb-1">Alasan</label>
                <textarea name="alasan" rows="4" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]" placeholder="Tuliskan alasan Anda ingin menjadi asisten dosen"></textarea>
            </div>

            <!-- KEBERSEDIAAN -->
            <div>
                <label class="block font-bold mb-1">Apakah Anda besedia menjadi asdos di 2 mata kuliah?</label>
                <select name="kebersediaan" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option>Bersedia</option>
                    <option>Tidak Bersedia</option>
                </select>
            </div>

            <!-- PENGALAMAN JADI ASDOS -->
            <div>
                <label class="block font-bold mb-1">Apakah Anda sudah pernah menjadi asdos?</label>
                <select name="kebersediaan" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option>Sudah Pernah</option>
                    <option>Belum Pernah</option>
                </select>
            </div>

            <!-- KEBERSEDIAAN BUKAN PRIORITAS -->
            <div>
                <label class="block font-bold mb-1">Apakah Anda bersedia ditempatkan pada mata kuliah selain yang dipilih</label>
                <select name="kebersediaan" required class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
                    <option value="" disabled selected>Pilih Jawaban</option>
                    <option>Bersedia</option>
                    <option>Tidak Bersedia</option>
                </select>
            </div>

            <!-- Upload Surat Pernyataan -->
            <div>
                <label class="block font-bold mb-1">Upload Surat Pernyataan<a class="text-underline underline underline-offset-4 text-blue-600" href="https://docs.google.com/document/d/13sA5RUgaHtU7RrfY6cQAReyO4-tckxa7/edit?usp=sharing&ouid=109242753190899151626&rtpof=true&sd=true" target="_blank">(Unduh disini)</a></label>
                <input type="file" name="cv" accept=".pdf,.doc,.docx" class="w-full border border-gray-400 rounded px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#ffcc00]">
            </div>

            <!-- Tombol Submit -->
            <div class="text-right">
                <button type="submit" class="bg-[#ffcc00] hover:bg-[#ffcc00] text-black font-bold py-2 px-6 rounded shadow">Kirim</button>
            </div>

        </form>
    </section>
    <?php
        require_once '../head-nav-foo/footer.php';
    ?>

</body>

</html>