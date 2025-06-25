<?php
session_start();
$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';

$user_npm = $_SESSION['user'] ?? '';
$today_date = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jadwal Wawancara</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col">
  <div class="flex-grow max-w-5xl mx-auto p-6 w-full">
    <h1 class="text-3xl font-bold text-center mb-8">Jadwal Wawancara Calon Asisten</h1>
    <div class="flex justify-end mb-4">
      <label for="dateSelector" class="sr-only">Pilih Tanggal</label>
      <input type="date" id="dateSelector" value="<?= htmlspecialchars($today_date) ?>" class="p-2 rounded border bg-white">
    </div>
    <div id="jadwalContainer" class="overflow-x-auto bg-white p-4 rounded-lg shadow">
      <div id="loading" class="text-center p-8">Memuat jadwal...</div>
      <table class="w-full border text-sm table-auto hidden" id="jadwalTable">
        <thead class="bg-yellow-400">
          <tr class="text-center">
            <th class="border px-2 py-2 w-[10%]">Slot</th>
            <th class="border px-2 py-2 w-[25%]">Waktu</th>
            <th class="border px-2 py-2 w-[65%]">Ketersediaan</th>
          </tr>
        </thead>
        <tbody id="jadwalTbody"></tbody>
      </table>
    </div>
  </div>

  <script>
    const userNPM = "<?= htmlspecialchars($user_npm, ENT_QUOTES, 'UTF-8') ?>";
  </script>
  <script src="js/jadwal_booking.js?v=<?= time() ?>"></script>
  <?php require_once '../head-nav-foo/footer.php'; ?>
</body>

</html>