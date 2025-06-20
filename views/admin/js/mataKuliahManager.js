document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-add-edit-mk');
    const btnTambah = document.getElementById('btn-tambah-mk');
    const btnClose = document.getElementById('btn-close-modal-add-edit');
    const btnCancel = document.getElementById('btn-cancel-modal-add-edit');
    const form = document.getElementById('form-add-edit-mk');
    const tableBody = document.querySelector('#tabel-mk tbody');
    const modalTitle = document.getElementById('modal-mk-title');
    const mkIdInput = document.getElementById('mk-id');
    const mkActionInput = document.getElementById('mk-action');
    const mkKodeInput = document.getElementById('mk-kode');
    const mkNamaInput = document.getElementById('mk-nama');
    const mkSksInput = document.getElementById('mk-sks');
    const mkSemesterSelect = document.getElementById('mk-semester');
    const mkDosenInput = document.getElementById('mk-dosen');
    const mkKuotaInput = document.getElementById('mk-kuota');
    const mkStatusSelect = document.getElementById('mk-status');

    const openModal = () => modal.classList.remove('hidden');
    const closeModal = () => modal.classList.add('hidden');

    const handleFormSubmit = async (event) => {
        event.preventDefault();
        const formData = new FormData(form);
        const response = await fetch('api/mata_kuliah_handler.php', {
            method: 'POST',
            body: formData
        });
        const result = await response.json();

        if (result.status === 'success') {
            const action = formData.get('action');
            if (action === 'create') {
                appendTableRow(result.data);
            } else if (action === 'update') {
                updateTableRow(result.data);
            }
            closeModal();
            alert(result.message); // Show success message
        } else {
            alert(result.message); // Show error message
        }
    };
    
    const createTableRowHTML = (data) => {
        const statusColor = data.status === 'Aktif' ? 'text-green-400 bg-green-500/20' : 'text-red-400 bg-red-500/20';
        return `
            <td class="px-6 py-4" data-col="nama">
                <div>
                    <div class="font-semibold">${data.kode}</div>
                    <div class="text-xs text-gray-400 mt-0.5">${data.nama}</div>
                </td>
            <td class="px-6 py-4">${data.sks}</td>
            <td class="px-6 py-4">${data.semester}</td>
            <td class="px-6 py-4">${data.dosen}</td>
            <td class="px-6 py-4">${data.kuota}</td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusColor}">${data.status}</span>
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex items-center justify-center space-x-2">
                    <button title="Edit" class="text-gray-400 hover:text-[#FFCC00] p-1.5 btn-edit-mk"><i class="ri-pencil-line ri-lg"></i></button>
                    <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 btn-hapus-mk"><i class="ri-delete-bin-line ri-lg"></i></button>
                </div>
            </td>
        `;
    };

    const appendTableRow = (data) => {
        const noResultsRow = document.getElementById('no-results-mk');
        if (noResultsRow) noResultsRow.remove();
        
        const newRow = document.createElement('tr');
        newRow.dataset.id = data.id;
        newRow.innerHTML = createTableRowHTML(data);
        tableBody.appendChild(newRow);
    };

    const updateTableRow = (data) => {
        const row = tableBody.querySelector(`tr[data-id='${data.id}']`);
        if(row) row.innerHTML = createTableRowHTML(data);
    };

    btnTambah.addEventListener('click', () => {
        form.reset(); // Clear form fields
        modalTitle.textContent = 'Tambah Mata Kuliah Baru';
        mkActionInput.value = 'create';
        mkIdInput.value = '';
        openModal();
    });

    tableBody.addEventListener('click', async (event) => {
        const editBtn = event.target.closest('.btn-edit-mk');
        const deleteBtn = event.target.closest('.btn-hapus-mk');
        const row = event.target.closest('tr');

        if (editBtn) {
            const id = row.dataset.id;
            // Fetch the data from the row
            const kode = row.children[0].querySelector('.font-semibold').textContent.trim();
            const nama = row.children[0].querySelector('.text-xs').textContent.trim();
            const sks = row.children[1].textContent.trim();
            const semester = row.children[2].textContent.trim();
            const dosen = row.children[3].textContent.trim();
            const kuota = row.children[4].textContent.trim();
            const status = row.children[5].querySelector('span').textContent.trim();
            
            // Populate the form fields
            mkIdInput.value = id;
            mkActionInput.value = 'update';
            modalTitle.textContent = 'Edit Mata Kuliah';
            mkKodeInput.value = kode;
            mkNamaInput.value = nama;
            mkSksInput.value = sks;
            mkSemesterSelect.value = semester;
            mkDosenInput.value = dosen;
            mkKuotaInput.value = kuota;
            mkStatusSelect.value = status;
            
            openModal();
        }

        if (deleteBtn) {
            const id = row.dataset.id;
            const namaMk = row.children[0].querySelector('.text-xs').textContent.trim();
            if (confirm(`Apakah Anda yakin ingin menghapus mata kuliah "${namaMk}"?`)) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);
                
                const response = await fetch('api/mata_kuliah_handler.php', { method: 'POST', body: formData });
                const result = await response.json();

                if (result.status === 'success') {
                    row.remove();
                    if (tableBody.children.length === 0) {
                        const noResultsRow = document.createElement('tr');
                        noResultsRow.id = 'no-results-mk';
                        noResultsRow.innerHTML = '<td colspan="7" class="px-6 py-12 text-center text-gray-500">Tidak ada data mata kuliah.</td>';
                        tableBody.appendChild(noResultsRow);
                    }
                    alert(result.message);
                } else {
                    alert(result.message);
                }
            }
        }
    });

    btnClose.addEventListener('click', closeModal);
    btnCancel.addEventListener('click', closeModal);
    form.addEventListener('submit', handleFormSubmit);
});