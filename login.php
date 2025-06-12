<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'dark-bg': '#111827',
                        'dark-card': '#1F2937',
                        'dark-accent': '#FFCC00',
                        'dark-accent-hover': '#FFB100',
                        'dark-text-primary': '#F3F4F6',
                        'dark-text-secondary': '#9CA3AF',
                        'dark-border': '#374151',
                        'dark-input-bg': '#374151',
                    }
                }
            }
        }
    </script>
    <style type="text/tailwindcss">
        .form-input-custom {
            @apply w-full py-3 px-4 bg-dark-input-bg text-dark-text-primary border border-dark-border rounded-lg leading-tight placeholder-dark-text-secondary focus:outline-none focus:border-dark-accent focus:ring-1 focus:ring-dark-accent shadow-sm;
        }
    </style>
</head>

<body class="bg-dark-bg min-h-screen flex items-center justify-center p-4">

    <div class="bg-dark-card p-8 sm:p-10 rounded-3xl shadow-2xl w-full max-w-sm">
        <img src="img/logo/bansus.png" alt="Logo" class="w-14 h-14 object-contain flex mx-auto mb-4">
        <h2 class="text-3xl font-bold text-dark-text-primary mb-8 text-center">Masuk Akun</h2>
        <form action="controller/asdos/login_logic.php" method="POST" autocomplete="off" class="w-full">
            <div class="mb-4">
                <label for="npm" class="sr-only">NPM</label>
                <input type="text" inputmode="numeric" pattern="\d*" id="npm" name="npm" placeholder="Masukkan NPM" required
                    class="form-input-custom">
            </div>
            <div class="mb-4">
                <label for="password" class="sr-only">Password</label>
                <input type="password" id="password" name="password" placeholder="Masukkan Password Anda" required
                    class="form-input-custom">
            </div>
            <button type="submit"
                class="w-full bg-dark-accent text-gray-900 font-bold py-3 px-4 rounded-lg hover:bg-dark-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-yellow-500 transition-all duration-200">
                Masuk
            </button>
        </form>
        <p class="text-center text-dark-text-secondary text-sm mt-6">
            Belum memiliki akun?
            <a href="index.php" class="text-dark-accent hover:underline">Daftar</a>
        </p>
    </div>

</body>

</html>