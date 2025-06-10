<?php
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
require_once '../../db.php';

// Bagian untuk mengambil data user dari session
$nama = '';
$npm = '';

if (isset($_SESSION['user'])) {
  $user_id = $_SESSION['user'];
  // Gunakan prepared statement untuk keamanan
  $query = "SELECT nama, npm FROM asdos WHERE npm = ? LIMIT 1";
  $stmt = $conn->prepare($query);
  $stmt->bind_param('s', $user_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result && $result->num_rows === 1) {
    $row = $result->fetch_assoc();
    $nama = $row['nama'];
    $npm = $row['npm'];
    $_SESSION['nama'] = $nama;
    $_SESSION['npm'] = $npm;
  }
  $stmt->close();
}

// Blok utama untuk menghasilkan data jadwal
$jadwalDB = [];
for ($hari = 1; $hari <= 3; $hari++) {
  // 1. Ambil data yang sudah terisi dari database untuk hari terkait
  $dbSlots = [];
  $sql = "SELECT jam, waktu_text, npm, nama, keterangan, hari FROM jadwal_wawancara WHERE hari = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param('i', $hari);
  $stmt->execute();
  $result = $stmt->get_result();
  while ($row = $result->fetch_assoc()) {
    $dbSlots[$row['jam']] = $row;
  }
  $stmt->close();

  // 2. Buat kerangka jadwal lengkap dari jam 09:00 - 15:00
  $jadwalHariIni = [];
  $start = new DateTime('09:00');
  $end   = new DateTime('15:00');
  $breakStart = new DateTime('12:00');
  $breakEnd   = new DateTime('12:40');
  $interval = new DateInterval('PT20M');
  $slotIndex = 1;

  // Ini adalah satu-satunya perulangan (loop) yang diperlukan
  while ($start < $end) {
    // Logika untuk melewati waktu istirahat
    if ($start >= $breakStart && $start < $breakEnd) {
      $start = clone $breakEnd; // Langsung lompat ke 12:40
    }

    $slotLabel = "S$slotIndex";
    $jamAwal = $start->format('H:i');

    // Hitung jam akhir slot
    $jamAkhirDt = clone $start;
    $jamAkhirDt->add($interval);
    $jamAkhir = $jamAkhirDt->format('H:i');

    $waktuText = "$jamAwal - $jamAkhir";

    // 3. Siapkan data default untuk setiap slot
    $slotData = [
      'jam' => $slotLabel,
      'waktu_text' => $waktuText,
      'npm' => null,
      'nama' => null,
      'keterangan' => null,
      'hari' => $hari,
    ];

    // 4. Jika slot ini ada di database, ambil detail bookingnya saja
    // Ini memastikan 'waktu_text' yang kita hitung tidak akan tertimpa
    if (isset($dbSlots[$slotLabel])) {
      $slotData['npm']        = $dbSlots[$slotLabel]['npm'];
      $slotData['nama']       = $dbSlots[$slotLabel]['nama'];
      $slotData['keterangan'] = $dbSlots[$slotLabel]['keterangan'];
    }

    $jadwalHariIni[] = $slotData;

    $start->add($interval);
    $slotIndex++;
  }

  $jadwalDB[$hari] = $jadwalHariIni;
}
?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Jadwal Wawancara</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <style>
    select {
      min-width: 100px;
      max-width: 100%;
    }

    td,
    th {
      min-height: 44px;
      line-height: 1.5;
    }
  </style>
</head>

<body class="bg-gray-100 text-gray-800">
  <div class="max-w-5xl mx-auto p-6">
    <h1 class="text-3xl font-bold text-center mb-8">Jadwal Wawancara Calon Asisten</h1>

    <div class="flex justify-end mb-4">
      <select id="daySelector" class="p-2 rounded border">
        <option value="1">28 Juli 2025</option>
        <option value="2">29 Juli 2025</option>
        <option value="3">30 Juli 2025</option>
      </select>
    </div>

    <div id="jadwalContainer" class="overflow-x-auto"></div>
  </div>

  <script>
    const userNPM = "<?= htmlspecialchars($npm ?? '', ENT_QUOTES, 'UTF-8') ?>";
    const userNama = "<?= htmlspecialchars($nama ?? '', ENT_QUOTES, 'UTF-8') ?>";
    const jadwalDB = <?= json_encode($jadwalDB) ?>;

    function userSudahPunyaSlot() {
      for (let h in jadwalDB) {
        if (jadwalDB[h].some(slot => slot.npm === userNPM)) return true;
      }
      return false;
    }

    function renderJadwal(hari) {
      const data = jadwalDB[hari] || [];
      let html = `<table class="w-full border text-sm table-fixed">
        <thead class="bg-yellow-400">
          <tr class="text-center">
            <th class="border px-2 py-2 w-[5%]">No</th>
            <th class="border px-2 py-2 w-[15%]">NPM</th>
            <th class="border px-2 py-2 w-[25%]">Nama</th>
            <th class="border px-2 py-2 w-[20%]">Jam</th>
            <th class="border px-2 py-2 w-[35%]">Keterangan</th>
          </tr>
        </thead>
        <tbody>`;

      data.forEach((item) => {
        const jamFormatted = item.waktu_text || '-';

        html += `<tr class="hover:bg-gray-50 text-center">
          <td class="border px-2 py-2">${item.jam}</td>
          <td class="border px-2 py-2 truncate">${item.npm || '-'}</td>
          <td class="border px-2 py-2 truncate">${item.nama || '-'}</td>
          <td class="border px-2 py-2 font-mono">${jamFormatted}</td>
          <td class="border px-2 py-2">`;

        if (!item.npm) {
          if (!userSudahPunyaSlot()) {
            html += `<select onchange="isiKeterangan(${hari}, '${item.jam}', '${jamFormatted}', this.value)" class="border rounded p-1 text-center text-xs w-full">
              <option value="">-- Pilih --</option>
              <option value="Offline">Offline</option>
              <option value="Online">Online</option>
            </select>`;
          } else {
            html += '-';
          }
        } else if (item.npm === userNPM) {
          html += `<select onchange="isiKeterangan(${hari}, '${item.jam}', '${jamFormatted}', this.value)" class="border rounded p-1 text-center text-xs w-full">
            <option value="">-- Batalkan --</option>
            <option value="Offline" ${item.keterangan === 'Offline' ? 'selected' : ''}>Offline</option>
            <option value="Online" ${item.keterangan === 'Online' ? 'selected' : ''}>Online</option>
          </select>`;
        } else {
          html += item.keterangan || '-';
        }
        html += `</td></tr>`;
      });

      html += '</tbody></table>';
      document.getElementById('jadwalContainer').innerHTML = html;
    }

    function isiKeterangan(hari, jam, waktuText, keterangan) {
      const pesanKonfirmasi = keterangan === "" ?
        "Yakin ingin membatalkan jadwal wawancara?" :
        `Yakin memilih jadwal pada jam ${waktuText} dengan keterangan: ${keterangan}?`;

      if (!confirm(pesanKonfirmasi)) {
        renderJadwal(document.getElementById('daySelector').value); // reset tampilan jika batal
        return;
      }

      const form = document.createElement('form');
      form.method = 'POST';
      form.action = '../../controller/asdos/jadwal_wawancara_logic.php';

      const inputs = {
        hari: hari,
        jam: jam,
        waktu_text: waktuText,
        npm: userNPM,
        nama: userNama,
        keterangan: keterangan
      };

      for (const key in inputs) {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = inputs[key];
        form.appendChild(input);
      }
      document.body.appendChild(form);
      form.submit();
    }

    document.getElementById('daySelector').addEventListener('change', e => {
      renderJadwal(e.target.value);
    });

    renderJadwal(1); // Render jadwal hari pertama saat halaman dimuat
  </script>

</body>

</html>