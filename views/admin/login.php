<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    $username_valid = 'admin';
    $password_valid = 'password'; 
    if ($_POST['username'] === $username_valid && $_POST['password'] === $password_valid) {
        $_SESSION['logged_in'] = true;
        $_SESSION['username'] = $_POST['username'];
        header('Location: dashboard.php'); 
        exit;
    } else {
        $error = "Nama pengguna atau kata sandi tidak valid.";
    }
}
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Rekrutmen Asisten Dosen</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Poppins', 'sans-serif'],
                    },
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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style type="text/tailwindcss">
        @layer base {
            body {
                font-family: 'Inter', sans-serif;
            }
        }
        .gradient-yellow-bg {
            background: linear-gradient(135deg, #FFCC00 0%, #FFB100 100%); 
        }
        .btn-login {
            @apply w-full gradient-yellow-bg text-black font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg 
                   transition duration-300 ease-in-out transform hover:scale-105 
                   focus:outline-none focus:ring-2 focus:ring-dark-accent-hover focus:ring-opacity-75;
        }
        .form-input-custom {
            @apply w-full py-3 px-4 bg-dark-input-bg text-dark-text-primary border border-dark-border 
                   rounded-lg leading-tight placeholder-dark-text-secondary 
                   focus:outline-none focus:border-dark-accent focus:ring-1 focus:ring-dark-accent shadow-sm;
        }
        .form-label-custom {
            @apply block text-dark-text-secondary text-sm font-medium mb-2;
        }
    </style>
</head>
<body class="bg-dark-bg">
    <div class="min-h-screen flex flex-col items-center justify-center p-4">
        <div class="bg-dark-card p-8 sm:p-10 rounded-xl shadow-2xl w-full max-w-md">
            <div class="text-center mb-8">
                <h1 class="text-2xl sm:text-3xl font-bold text-dark-text-primary">Login Admin</h1>
                <p class="mt-2 text-sm text-dark-text-secondary">Portal Rekrutmen Asisten Dosen</p>
                <div class="h-1 w-20 sm:w-24 gradient-yellow-bg mx-auto mt-4"></div>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-900/70 border border-red-700 text-red-300 px-4 py-3 rounded-md mb-6 text-sm" role="alert">
                    <strong class="font-bold">Kesalahan!</strong>
                    <span><?php echo htmlspecialchars($error); ?></span>
                </div>
            <?php endif; ?>
            
            <form method="post" action="login.php">
                <div class="mb-5">
                    <label class="form-label-custom" for="username">
                        Nama Pengguna
                    </label>
                    <input class="form-input-custom" 
                           id="username" name="username" type="text" placeholder="Contoh: admin" required
                           aria-describedby="username-error">
                </div>
                <div class="mb-6">
                    <label class="form-label-custom" for="password">
                        Kata Sandi
                    </label>
                    <input class="form-input-custom" 
                           id="password" name="password" type="password" placeholder="Masukkan kata sandi Anda" required
                           aria-describedby="password-error">
                </div>
                <div class="pt-2">
                    <button class="btn-login" type="submit">
                        Masuk ke Akun
                    </button>
                </div>
            </form>
            <p class="text-center text-dark-text-secondary text-xs mt-10">
                &copy; <?php echo date("Y"); ?> Fakultas Ilmu Komputer. Hak Cipta Dilindungi.
            </p>
        </div>
    </div>
</body>
</html>