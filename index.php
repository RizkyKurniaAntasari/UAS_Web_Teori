<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Daftar Akun</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style type="text/tailwindcss">
        @layer components {
            .form-input-dark {
                @apply w-full py-3 px-4 bg-[#374151] text-[#F3F4F6] border border-transparent rounded-lg leading-tight placeholder-[#9CA3AF] focus:outline-none focus:border-[#FFCC00] focus:ring-1 focus:ring-[#FFCC00] shadow-sm transition-all duration-200;
            }
        }
    </style>
</head>
<body class="bg-[#111827] min-h-screen flex items-center justify-center p-4">
    <div class="bg-[#1F2937] p-8 sm:p-10 rounded-3xl shadow-2xl w-full max-w-sm">
        <img src="img/logo/bansus.png" alt="Logo" class="w-14 h-14 object-contain mx-auto mb-4">
        <h2 class="text-3xl font-bold text-[#F3F4F6] mb-8 text-center">Daftar Akun</h2>
        <form action="controller/asdos/register_logic.php" method="POST" autocomplete="off" class="w-full">
            <div class="mb-4">
                <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Lengkap" required class="form-input-dark">
            </div>
            <div class="mb-4">
                <input type="text" inputmode="numeric" pattern="\d*" id="npm" name="npm" placeholder="Masukkan NPM" required class="form-input-dark">
            </div>
            <div class="mb-4">
                <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required class="form-input-dark">
            </div>
            <div class="mb-6">
                <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password Anda" required class="form-input-dark">
            </div>
            <button type="submit" name="simpan" class="w-full bg-[#FFCC00] text-gray-900 font-bold py-3 px-4 rounded-lg hover:bg-[#FFB100] transition-all duration-200">
                Daftar
            </button>
        </form>
        <p class="text-center text-[#9CA3AF] text-sm mt-6">
            Sudah memiliki akun?
            <a href="login.php" class="text-[#FFCC00] hover:underline">Masuk</a>
        </p>
    </div>
</body>
</html>