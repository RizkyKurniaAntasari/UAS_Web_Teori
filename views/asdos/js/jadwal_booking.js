document.addEventListener('DOMContentLoaded', () => {
    const dateSelector = document.getElementById('dateSelector');
    const tableBody = document.getElementById('jadwalTbody');
    const table = document.getElementById('jadwalTable');
    const loadingDiv = document.getElementById('loading');
    
    const API_URL = 'api/jadwal_handler.php';

    const fetchAndRenderSchedule = async () => {
        if (!dateSelector || !dateSelector.value) {
            loadingDiv.textContent = 'Elemen pemilih tanggal tidak ditemukan.';
            return;
        }
        
        table.classList.add('hidden');
        loadingDiv.classList.remove('hidden');
        loadingDiv.textContent = 'Memuat jadwal...';
        tableBody.innerHTML = '';

        const selectedDay = dateSelector.value;
        try {
            const response = await fetch(`${API_URL}?day=${selectedDay}`);
            const result = await response.json();

            loadingDiv.classList.add('hidden');
            table.classList.remove('hidden');

            if (result.status === 'success') {
                if (result.schedule.length === 0) {
                     tableBody.innerHTML = `<tr><td colspan="3" class="text-center p-4 text-gray-500">Tidak ada jadwal yang tersedia untuk tanggal ini.</td></tr>`;
                     return;
                }
                renderTable(result.schedule, result.user_has_booking);
            } else {
                throw new Error(result.message || 'Gagal memuat jadwal.');
            }
        } catch(error) {
            loadingDiv.classList.add('hidden');
            tableBody.innerHTML = `<tr><td colspan="3" class="text-center p-4 text-red-500">Error: ${error.message}</td></tr>`;
        }
    };

    const renderTable = (schedule, userHasBooking) => {
        schedule.forEach(slot => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 text-center';
            
            let availabilityCellHTML = '';
            if (slot.is_users_booking) {
                availabilityCellHTML = `
                    <div class="flex items-center justify-center space-x-2">
                        <span class="font-semibold text-green-600">Jadwal Anda: ${slot.keterangan}</span>
                        <button class="px-3 py-1 text-xs font-medium text-white bg-red-600 rounded-md hover:bg-red-700 btn-cancel" data-jam="${slot.jam}" data-waktu-text="${slot.waktu_text}">Batalkan</button>
                    </div>`;
            } else if (slot.is_booked) {
                availabilityCellHTML = `<span class="px-3 py-1 text-xs font-semibold text-gray-700 bg-gray-200 rounded-full">Sudah Diisi</span>`;
            } else if (userHasBooking) {
                availabilityCellHTML = `<span class="text-gray-400">-</span>`;
            } else {
                availabilityCellHTML = `
                     <select class="p-1 border rounded text-xs select-book" data-jam="${slot.jam}" data-waktu-text="${slot.waktu_text}">
                        <option value="">-- Ambil Jadwal --</option>
                        <option value="Online">Online</option>
                        <option value="Offline">Offline</option>
                    </select>`;
            }

            row.innerHTML = `
                <td class="border px-2 py-2">${slot.jam}</td>
                <td class="border px-2 py-2 font-mono">${slot.waktu_text}</td>
                <td class="border px-2 py-2">${availabilityCellHTML}</td>`;
            
            tableBody.appendChild(row);
        });
    };

    const handleBookingAction = async (event) => {
        const target = event.target;
        
        const isBooking = target.classList.contains('select-book');
        const isCancelling = target.classList.contains('btn-cancel');

        if (!isBooking && !isCancelling) return;

        const day = dateSelector.value;
        let keterangan, jam, waktu_text, confirmationMessage;
        
        if (isBooking) {
            keterangan = target.value;
            if (!keterangan) return; // Abaikan jika user memilih placeholder "-- Ambil Jadwal --"
            jam = target.dataset.jam;
            waktu_text = target.dataset.waktuText;
            confirmationMessage = `Anda yakin ingin mengambil jadwal ${keterangan} pada jam ${waktu_text}?`;
        } else { // isCancelling
            keterangan = 'cancel';
            jam = target.dataset.jam;
            waktu_text = target.dataset.waktuText;
            confirmationMessage = `Anda yakin ingin membatalkan jadwal wawancara Anda?`;
        }

        if (!confirm(confirmationMessage)) {
            if(isBooking) target.value = ""; // Reset dropdown jika user membatalkan konfirmasi
            return;
        }

        try {
            const response = await fetch(API_URL, {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ day, jam, waktu_text, keterangan })
            });
            const result = await response.json();

            if (result.status !== 'success') {
                throw new Error(result.message);
            }
            alert(result.message);
        } catch(error) {
            alert(`Error: ${error.message}`);
        } finally {
            fetchAndRenderSchedule();
        }
    };

    if(dateSelector) {
        dateSelector.addEventListener('change', fetchAndRenderSchedule);
    }
    
    // Dengarkan event click (untuk tombol) dan change (untuk select) pada table body
    tableBody.addEventListener('click', handleBookingAction);
    tableBody.addEventListener('change', handleBookingAction);

    fetchAndRenderSchedule();
});