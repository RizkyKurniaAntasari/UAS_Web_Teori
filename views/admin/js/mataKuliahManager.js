document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('modal-add-edit-mk');
    const btnTambah = document.getElementById('btn-tambah-mk');
    const btnClose = document.getElementById('btn-close-modal-add-edit');
    const btnCancel = document.getElementById('btn-cancel-modal-add-edit');
    const form = document.getElementById('form-add-edit-mk');
    const tableBody = document.querySelector('#tabel-mk tbody');

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
        } else {
            alert(result.message);
        }
    };
    
    const createTableRowHTML = (data) => {
        const statusColor = data.status === 'Aktif' ? 'text-green-400 bg-green-500/20' : 'text-red-400 bg-red-500/20';
        return `
            <td class="px-6 py-4" data-col="nama">
                <div>
                    <div class="text-sm font-semibold text-gray-100">${data.kode}</div>
                    <div class="text-xs text-gray-400 mt-0.5">${data.nama}</div>
                </div>
            </td>
            <td class="px-6 py-4 text-sm text-gray-300" data-col="sks">${data.sks}</td>
            <td class="px-6 py-4 text-sm text-gray-300" data-col="semester">${data.semester}</td>
            <td class="px-6 py-4 text-sm text-gray-300" data-col="dosen">${data.dosen}</td>
            <td class="px-6 py-4 text-sm text-gray-300" data-col="kuota">${data.kuota}</td>
            <td class="px-6 py-4" data-col="status">
                <span class="px-3 py-1 text-xs font-semibold rounded-full ${statusColor}">${data.status}</span>
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex items-center justify-center space-x-2">
                    <button title="Edit" class="text-gray-300 hover:text-secondary p-1.5 rounded-md btn-edit-mk"><i class="ri-pencil-line ri-lg"></i></button>
                    <button title="Hapus" class="text-gray-300 hover:text-red-400 p-1.5 rounded-md btn-hapus-mk"><i class="ri-delete-bin-line ri-lg"></i></button>
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
        form.reset();
        document.getElementById('modal-mk-title').textContent = 'Tambah Mata Kuliah Baru';
        document.getElementById('mk-action').value = 'create';
        document.getElementById('mk-id').value = '';
        openModal();
    });

    tableBody.addEventListener('click', async (event) => {
        const editBtn = event.target.closest('.btn-edit-mk');
        const deleteBtn = event.target.closest('.btn-hapus-mk');
        const row = event.target.closest('tr');

        if (editBtn) {
            const id = row.dataset.id;
            const cells = row.querySelectorAll('td');
            
            form.reset();
            document.getElementById('modal-mk-title').textContent = 'Edit Mata Kuliah';
            document.getElementById('mk-action').value = 'update';
            document.getElementById('mk-id').value = id;

            document.getElementById('mk-kode').value = cells[0].querySelector('div > div:first-child').textContent;
            document.getElementById('mk-nama').value = cells[0].querySelector('div > div:last-child').textContent;
            document.getElementById('mk-sks').value = cells[1].textContent;
            document.getElementById('mk-semester').value = cells[2].textContent;
            document.getElementById('mk-dosen').value = cells[3].textContent;
            document.getElementById('mk-kuota').value = cells[4].textContent;
            document.getElementById('mk-status').value = cells[5].querySelector('span').textContent;
            openModal();
        }

        if (deleteBtn) {
            const id = row.dataset.id;
            if (confirm('Apakah Anda yakin ingin menghapus mata kuliah ini?')) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);
                
                const response = await fetch('api/mata_kuliah_handler.php', { method: 'POST', body: formData });
                const result = await response.json();

                if (result.status === 'success') {
                    row.remove();
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