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
    <title>Pengumuman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <div class="px-10 py-6">
        <h1 class="text-3xl font-bold mb-8 pt-3 text-center text-gray-800">Selamat & Sukses Asisten Dosen Baru!</h1>

        <?php
        $jadwal = [
            'Semester 1' => [
                'Logika' => [
                    ['npm' => '2410110001', 'nama' => 'Lekok Indah Lia', 'Keterangan' => 'Koordinator', 'kelas' => 'A'],
                    ['npm' => '2410110002', 'nama' => 'Nadya Arsa', 'Keterangan' => 'Anggota', 'kelas' => 'B'],
                ],
                'Matematika' => [
                    ['npm' => '2410110003', 'nama' => 'Rizky Kurnia A', 'Keterangan' => 'Koordinator', 'kelas' => 'C'],
                    ['npm' => '2410110004', 'nama' => 'Samuel Ananta', 'Keterangan' => 'Anggota', 'kelas' => 'D'],
                ],
            ],
            'Semester 3' => [
                'Basis Data' => [
                    ['npm' => '2310110005', 'nama' => 'Dea Delvinata R', 'Keterangan' => 'Koordinator', 'kelas' => 'A'],
                    ['npm' => '2310110006', 'nama' => 'Alfi Rahma A', 'Keterangan' => 'Anggota', 'kelas' => 'C'],
                ],
                'Multimedia' => [
                    ['npm' => '2310110007', 'nama' => 'M. Alif Abrar', 'Keterangan' => 'Koordinator', 'kelas' => 'B'],
                    ['npm' => '2310110008', 'nama' => 'Nugraha Aji', 'Keterangan' => 'Anggota', 'kelas' => 'D'],
                ],
            ],
            'Semester 5' => [
                'Sistem Pakar' => [
                    ['npm' => '2210110009', 'nama' => 'Febrina Aulia A', 'Keterangan' => 'Koordinator', 'kelas' => 'A'],
                    ['npm' => '2210110010', 'nama' => 'Wildan Mukmin', 'Keterangan' => 'Anggota', 'kelas' => 'B'],
                ],
                'Web Lanjut' => [
                    ['npm' => '2210110011', 'nama' => 'Bungaran Natanael', 'Keterangan' => 'Koordinator', 'kelas' => 'C'],
                    ['npm' => '2210110012', 'nama' => 'Alia Rahayu', 'Keterangan' => 'Anggota', 'kelas' => 'D'],
                ],
            ],
        ];

        foreach ($jadwal as $semester => $matkulList) {
            echo "<div class='mb-8'>";
            echo "<h2 class='text-2xl font-semibold text-gray-700 mb-4'>$semester</h2>";

            echo "<div class='grid grid-cols-1 md:grid-cols-2 gap-6'>";
            foreach ($matkulList as $matkul => $mahasiswa) {
                echo "<div class='bg-white shadow-md rounded-lg overflow-hidden'>";
                echo "<div class='bg-white text-black px-4 py-2 text-lg font-semibold'>$matkul</div>";
                echo "<div class='p-4 overflow-x-auto'>";
                echo "<table class='min-w-full border border-gray-200 text-sm'>";
                echo "<thead class='bg-[#ffcc00]'>";
                echo "<tr class='text-center'>
                        <th class='px-4 py-2 border-b border-gray-300'>NPM</th>
                        <th class='px-4 py-2 border-b border-gray-300'>Nama</th>
                        <th class='px-4 py-2 border-b border-gray-300'>PJ Kelas</th>
                        <th class='px-4 py-2 border-b border-gray-300'>Keterangan</th>
                      </tr>";
                echo "</thead><tbody>";

                foreach ($mahasiswa as $mhs) {
                    echo "<tr class='hover:bg-gray-50 text-center'>
                            <td class='px-4 py-2 border-b border-gray-200'>{$mhs['npm']}</td>
                            <td class='px-4 py-2 border-b border-gray-200'>{$mhs['nama']}</td>
                            <td class='px-4 py-2 border-b border-gray-200'>{$mhs['kelas']}</td>
                            <td class='px-4 py-2 border-b border-gray-200'>{$mhs['Keterangan']}</td>
                          </tr>";
                }

                echo "</tbody></table></div></div>";
            }
            echo "</div></div>";
        }
        ?>
    </div>
</body>
<?php
    require_once '../head-nav-foo/footer.php';
?>

</html>
