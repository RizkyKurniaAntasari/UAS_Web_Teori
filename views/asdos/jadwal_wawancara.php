<?php
session_start();

// Simulasi user login
$_SESSION['npm'] = '2317051097';
$_SESSION['nama'] = 'Lekok Indah Lia';

$currentPage = basename($_SERVER['PHP_SELF']);
require_once '../head-nav-foo/header.php';
require_once '../head-nav-foo/navbar.php';
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
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
    const userNPM = "<?= $_SESSION['npm'] ?>";
    const userNama = "<?= $_SESSION['nama'] ?>";

    const startHour = 9;
    const endHour = 15;
    const breakStart = 12 * 60;
    const breakEnd = 12 * 60 + 40;

    let dataJadwal = {};
    for (let h = 1; h <= 5; h++) {
      let slots = [];
      let waktu = startHour * 60;
      let no = 1;
      while (waktu < endHour * 60) {
        if (waktu >= breakStart && waktu < breakEnd) {
          waktu = breakEnd;
          continue;
        }
        slots.push({
          no: no++,
          jam: toJam(waktu) + ' - ' + toJam(waktu + 20),
          npm: '',
          nama: '',
          keterangan: ''
        });
        waktu += 20;
      }
      dataJadwal[h] = slots;
    }

    function toJam(menit) {
      let jam = Math.floor(menit / 60);
      let mnt = menit % 60;
      return `${jam.toString().padStart(2, '0')}:${mnt.toString().padStart(2, '0')}`;
    }

    function renderJadwal(hari) {
      const data = dataJadwal[hari];
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

      data.forEach((item, index) => {
        html += `<tr class="hover:bg-gray-50 text-center">
        <td class="border px-2 py-2">${item.no}</td>
        <td class="border px-2 py-2 truncate">${item.npm || '-'}</td>
        <td class="border px-2 py-2 truncate">${item.nama || '-'}</td>
        <td class="border px-2 py-2">${item.jam}</td>
        <td class="border px-2 py-2">`;

        if (!item.npm) {
          if (!userSudahPunyaSlot()) {
            html += `<select onchange="isiKeterangan(${hari}, ${index}, this.value)" class="border rounded p-1 text-center text-xs w-full">
                    <option value="">-- Pilih --</option>
                    <option value="Offline">Offline</option>
                    <option value="Online">Online</option>
                  </select>`;
          } else {
            html += '-';
          }
        } else if (item.npm === userNPM) {
          html += `<select onchange="isiKeterangan(${hari}, ${index}, this.value)" class="border rounded p-1 text-center text-xs w-full">
                    <option value="Offline" ${item.keterangan === 'Offline' ? 'selected' : ''}>Offline</option>
                    <option value="Online" ${item.keterangan === 'Online' ? 'selected' : ''}>Online</option>
                    <option value="">-- Batalkan --</option>
                  </select>`;
        } else {
          html += item.keterangan || '-';
        }

        html += `</td></tr>`;
      });

      html += '</tbody></table>';
      document.getElementById('jadwalContainer').innerHTML = html;
    }

    function userSudahPunyaSlot() {
      for (let h = 1; h <= 5; h++) {
        if (dataJadwal[h].some(slot => slot.npm === userNPM)) {
          return true;
        }
      }
      return false;
    }

    function isiKeterangan(hari, index, value) {
      const currentSlot = dataJadwal[hari][index];
      const isUserSlot = currentSlot.npm === userNPM;
      const slotTerisiOrangLain = currentSlot.npm && !isUserSlot;

      if (slotTerisiOrangLain) {
        alert("Slot ini sudah diisi oleh orang lain.");
        renderJadwal(hari);
        return;
      }

      if (isUserSlot && value === "") {
        currentSlot.npm = '';
        currentSlot.nama = '';
        currentSlot.keterangan = '';
        renderJadwal(hari);
        return;
      }

      if (!isUserSlot && value !== "") {
        if (userSudahPunyaSlot()) {
          alert("Anda hanya boleh memilih 1 slot wawancara.");
          renderJadwal(hari);
          return;
        }
        currentSlot.npm = userNPM;
        currentSlot.nama = userNama;
        currentSlot.keterangan = value;
        renderJadwal(hari);
        return;
      }

      if (isUserSlot && value !== "") {
        currentSlot.keterangan = value;
        renderJadwal(hari);
        return;
      }

      renderJadwal(hari);
    }

    document.getElementById('daySelector').addEventListener('change', e => {
      renderJadwal(e.target.value);
    });

    renderJadwal(1);
  </script>
  <?php
      require_once '../head-nav-foo/footer.php';
  ?>
</body>


</html>