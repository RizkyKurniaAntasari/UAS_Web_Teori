document.addEventListener('DOMContentLoaded', () => {
    const daySelector = document.getElementById('daySelector');
    const tableBody = document.getElementById('jadwalTbody');
    const table = document.getElementById('jadwalTable');
    const loadingDiv = document.getElementById('loading');
    
    const API_URL = 'api/jadwal_handler.php';

    const fetchAndRenderSchedule = async () => {
        table.classList.add('hidden');
        loadingDiv.classList.remove('hidden');
        tableBody.innerHTML = '';

        const selectedDay = daySelector.value;
        const response = await fetch(`${API_URL}?day=${selectedDay}`);
        const result = await response.json();

        loadingDiv.classList.add('hidden');
        table.classList.remove('hidden');

        if (result.status === 'success') {
            renderTable(result.schedule, result.user_has_booking);
        } else {
            tableBody.innerHTML = `<tr><td colspan="3" class="text-center p-4 text-red-500">${result.message}</td></tr>`;
        }
    };

    const renderTable = (schedule, userHasBooking) => {
        schedule.forEach(slot => {
            const row = document.createElement('tr');
            row.className = 'hover:bg-gray-50 text-center';
            
            let availabilityCellHTML = '';
            if (slot.is_users_booking) {
                availabilityCellHTML = `
                    <select class="p-1 border rounded text-xs w-full max-w-xs" data-action="update" data-jam="${slot.jam}" data-waktu-text="${slot.waktu_text}">
                        <option value="cancel">-- Batalkan Jadwal --</option>
                        <option value="Offline" ${slot.keterangan === 'Offline' ? 'selected' : ''}>Offline</option>
                        <option value="Online" ${slot.keterangan === 'Online' ? 'selected' : ''}>Online</option>
                    </select>`;
            } else if (slot.is_booked) {
                availabilityCellHTML = `<span class="text-red-500 font-semibold">Sudah Diisi</span>`;
            } else if (userHasBooking) {
                availabilityCellHTML = `<span class="text-gray-400">-</span>`;
            } else {
                availabilityCellHTML = `
                     <select class="p-1 border rounded text-xs w-full max-w-xs" data-action="book" data-jam="${slot.jam}" data-waktu-text="${slot.waktu_text}">
                        <option value="">-- Pilih Keterangan --</option>
                        <option value="Offline">Offline</option>
                        <option value="Online">Online</option>
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
        const selectElement = event.target;
        if (selectElement.tagName !== 'SELECT' || !selectElement.dataset.action) return;
        
        const keterangan = selectElement.value;
        if (!keterangan) return; 

        const jam = selectElement.dataset.jam;
        const waktu_text = selectElement.dataset.waktuText;
        const day = daySelector.value;
        
        const isCancel = keterangan === 'cancel';
        const confirmationMessage = isCancel ? 
            `Yakin ingin membatalkan jadwal wawancara?` : 
            `Yakin memilih jadwal pada jam ${waktu_text} dengan keterangan: ${keterangan}?`;

        if (!confirm(confirmationMessage)) {
            fetchAndRenderSchedule();
            return;
        }

        const response = await fetch(API_URL, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ day, jam, waktu_text, keterangan })
        });
        const result = await response.json();

        if (result.status !== 'success') {
            alert(`Error: ${result.message}`);
        }

        fetchAndRenderSchedule();
    };

    daySelector.addEventListener('change', fetchAndRenderSchedule);
    tableBody.addEventListener('change', handleBookingAction);

    fetchAndRenderSchedule();
});