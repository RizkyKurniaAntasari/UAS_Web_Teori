<?php
session_start();

if (isset($_POST['username']) && isset($_POST['password'])) {
    if ($_POST['username'] === 'admin' && $_POST['password'] === 'password') {
        $_SESSION['logged_in'] = true;
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
    <title>Admin Login</title>
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
            @apply w-full gradient-yellow-bg text-black font-semibold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-dark-accent-hover focus:ring-opacity-50;
        }
        .form-input-custom {
            @apply w-full py-3 px-4 bg-dark-input-bg text-dark-text-primary border border-dark-border rounded-lg leading-tight placeholder-dark-text-secondary focus:outline-none focus:border-dark-accent focus:ring-1 focus:ring-dark-accent shadow-sm;
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
                <h1 class="text-3xl font-bold text-dark-text-primary">Admin Login</h1>
                <div class="h-1.5 w-24 gradient-yellow-bg mx-auto mt-3"></div>
            </div>
            
            <?php if (isset($error)): ?>
                <div class="bg-red-500/20 border border-red-500 text-red-300 px-4 py-3 rounded-md mb-6 text-sm">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>
            
            <form method="post" action="login.php" autocomplete="off"> 
                <div class="mb-5">
                    <label class="form-label-custom" for="username">
                        Nama Pengguna
                    </label>
                    <input class="form-input-custom" 
                           id="username" name="username" type="text" placeholder="Masukkan nama pengguna" required>
                </div>
                <div class="mb-8">
                    <label class="form-label-custom" for="password">
                        Kata Sandi
                    </label>
                    <input class="form-input-custom" 
                           id="password" name="password" type="password" placeholder="Masukkan kata sandi" required>
                </div>
                <div class="flex items-center justify-center">
                    <button class="btn-login" type="submit">
                        Masuk
                    </button>
                </div>
            </form>
            <p class="text-center text-dark-text-secondary text-xs mt-8">
                &copy; <?php echo date("Y"); ?> Portal Rekrutmen Asisten Dosen
            </p>
        </div>
    </div>
</body>
</html>