<!-- Asisten Dosen / Index -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link href="src/css/style.css" rel="stylesheet" />
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Create Account</title>
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
        .gradient-yellow-bg {
            background: linear-gradient(135deg, #FFCC00 0%, #FFB100 100%);
        }
        .btn-login {
            @apply w-full gradient-yellow-bg text-black font-bold py-3 px-6 rounded-lg shadow-md hover:shadow-lg transition duration-300 ease-in-out transform hover:scale-105 focus:outline-none focus:ring-2 focus:ring-dark-accent-hover focus:ring-opacity-50;
        }
        .form-input-custom {
            @apply w-full py-3 px-4 bg-dark-input-bg text-dark-text-primary border border-dark-border rounded-lg leading-tight placeholder-dark-text-secondary focus:outline-none focus:border-dark-accent focus:ring-1 focus:ring-dark-accent shadow-sm;
        }
        /*Chrome, Safari, Edge*/
        .no-spinner::-webkit-inner-spin-button,
        .no-spinner::-webkit-outer-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
    </style>
</head>

<body class="bg-dark-bg min-h-screen flex items-center justify-center">

    <div class="flex bg-dark-bg w-full max-w-4xl mx-auto rounded-lg overflow-hidden justify-center">
        <div class="w-1/2 bg-dark-card p-8 flex flex-col justify-center items-center rounded-3xl shadow-2xl">
            <div class="w-full max-w-md">
                <img src="img/logo/bansus.png" alt="Logo" class="w-14 h-14 object-contain flex mx-auto mb-4">
                <h2 class="text-4xl font-bold text-dark-text-primary mb-8 text-center">Daftar Akun</h2>

                <form method="POST" autocomplete="off">
                    <!-- Nama Lengkap -->
                    <div class="mb-4">
                        <label for="nama" class="sr-only">Nama Lengkap</label>
                        <input type="text" id="nama" name="nama" placeholder="Masukkan Nama Lengkap"
                            class="form-input-custom">
                    </div>

                    <!-- NPM -->
                    <div class="mb-4">
                        <label for="npm" class="sr-only">NPM</label>
                        <input type="number" id="npm" name="npm" placeholder="Masukkan NPM"
                            class="form-input-custom no-spinner">
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label for="password" class="sr-only">Password</label>
                        <input type="password" id="password" name="password" placeholder="Masukkan Password Anda"
                            class="form-input-custom">
                    </div>

                    <!-- Konfirmasi Password -->
                    <div class="mb-6">
                        <label for="confirm_password" class="sr-only">Konfirmasi Password</label>
                        <input type="password" id="confirm_password" name="confirm_password" placeholder="Konfirmasi Password Anda"
                            class="form-input-custom">
                    </div>

                    <!-- Tombol Daftar -->
                    <button type="submit" name="simpan"
                        class="btn-login">
                        Daftar
                    </button>
                </form>

                <?php
                include 'db.php';
                if (isset($_POST['simpan'])) {
                    $npm = $_POST['npm'];
                    $nama = $_POST['nama'];
                    $password = $_POST['password'];
                    $confirm = $_POST['confirm_password'];

                    if ($password !== $confirm) {
                        echo "<script>alert('Password dan Konfirmasi tidak cocok!');</script>";
                        exit;
                    }

                    $hash = password_hash($password, PASSWORD_DEFAULT);

                    // Simpan ke DB (asumsikan tabel: asdos, dengan kolom: nama, npm, password)
                    $sql = "INSERT INTO asdos (npm, nama, password) VALUES ('$npm', '$nama', '$hash')";
                    $query = mysqli_query($conn, $sql);

                    if ($query) {
                        echo "<script>alert('Akun berhasil dibuat!'); window.location='login.php';</script>";
                    } else {
                        echo "<div class='text-red-500 mt-4'>Gagal membuat akun: " . mysqli_error($conn) . "</div>";
                    }
                }
                ?>

                <!-- Sudah punya akun -->
                <p class="text-center text-dark-text-secondary text-sm mt-6">
                    Sudah memiliki akun?
                    <a href="login.php" class="text-dark-accent hover:underline">Masuk</a>
                </p>
            </div>
        </div>
    </div>

</body>

</html>