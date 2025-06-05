document.addEventListener('DOMContentLoaded', function () {
    const modalAddEditMk = document.getElementById('modal-add-edit-mk');
    const btnTambahMk = document.getElementById('btn-tambah-mk');
    const btnCloseModalAddEdit = document.getElementById('btn-close-modal-add-edit');
    const btnCancelModalAddEdit = document.getElementById('btn-cancel-modal-add-edit');
    const formAddEditMk = document.getElementById('form-add-edit-mk');
    const modalMkTitle = document.getElementById('modal-mk-title');
    const modalMkSubmitBtn = document.getElementById('btn-submit-modal-add-edit');
    const mkIdInput = document.getElementById('mk-id');
    const modalAddEditContent = modalAddEditMk ? modalAddEditMk.querySelector('.transform') : null;

    const tabelMkBody = document.querySelector('#tabel-mk tbody');
    const noResultsMkDiv = document.getElementById('no-results-mk');

    let currentlyEditingRow = null;

    function openModalEnhanced(modalElement, modalContentElement) {
        if (!modalElement || !modalContentElement) return;
        modalElement.classList.remove('hidden');
        setTimeout(() => {
            modalElement.classList.remove('opacity-0');
            modalContentElement.classList.remove('scale-95');
        }, 10);
    }

    function closeModalEnhanced(modalElement, modalContentElement) {
        if (!modalElement || !modalContentElement) return;
        modalElement.classList.add('opacity-0');
        modalContentElement.classList.add('scale-95');
        setTimeout(() => {
            modalElement.classList.add('hidden');
        }, 300);
    }

    if (btnTambahMk) {
        btnTambahMk.addEventListener('click', () => {
            currentlyEditingRow = null;
            if(formAddEditMk) formAddEditMk.reset();
            if(mkIdInput) mkIdInput.value = '';
            if(modalMkTitle) modalMkTitle.textContent = 'Tambah Mata Kuliah Baru';
            if(modalMkSubmitBtn) modalMkSubmitBtn.textContent = 'Simpan';
            if(document.getElementById('mk-kode')) document.getElementById('mk-kode').readOnly = false;
            openModalEnhanced(modalAddEditMk, modalAddEditContent);
        });
    }

    if (btnCloseModalAddEdit) btnCloseModalAddEdit.addEventListener('click', () => closeModalEnhanced(modalAddEditMk, modalAddEditContent));
    if (btnCancelModalAddEdit) btnCancelModalAddEdit.addEventListener('click', () => closeModalEnhanced(modalAddEditMk, modalAddEditContent));
    if (modalAddEditMk) {
        modalAddEditMk.addEventListener('click', (e) => {
            if (e.target === modalAddEditMk) closeModalEnhanced(modalAddEditMk, modalAddEditContent);
        });
    }

    if(formAddEditMk){
        formAddEditMk.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(formAddEditMk);
            const mkData = {
                id: currentlyEditingRow ? currentlyEditingRow.dataset.id : Date.now().toString(),
                kode: formData.get('kode'),
                nama: formData.get('nama'),
                sks: formData.get('sks'),
                semester: formData.get('semester'),
                dosen: formData.get('dosen'),
                kuota: formData.get('kuota'),
                status: formData.get('status')
            };

            if (!mkData.kode || !mkData.nama || !mkData.sks || !mkData.semester || !mkData.dosen || !mkData.kuota || !mkData.status) {
                alert('Semua field yang bertanda * harus diisi!');
                return;
            }

            if (currentlyEditingRow) {
                updateTableRow(currentlyEditingRow, mkData);
            } else {
                addNewTableRow(mkData);
            }
            updateMkTableInfo();
            closeModalEnhanced(modalAddEditMk, modalAddEditContent);
        });
    }

    function updateTableRow(row, data) {
        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                row.dataset[key] = data[key];
            }
        }
        row.cells[0].innerHTML = `
            <div>
                <div class="text-sm font-semibold text-gray-100">${data.kode}</div>
                <div class="text-xs text-gray-400 mt-0.5">${data.nama}</div>
            </div>`;
        row.cells[1].textContent = data.sks;
        row.cells[2].textContent = data.semester;
        row.cells[3].textContent = data.dosen;
        row.cells[4].textContent = data.kuota;
        const statusSpan = row.cells[5].querySelector('span');
        statusSpan.textContent = data.status;
        statusSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full leading-normal '; 
        if (data.status === 'Aktif') {
            statusSpan.classList.add('text-green-400', 'bg-green-500/20');
        } else {
            statusSpan.classList.add('text-red-400', 'bg-red-500/20');
        }
    }

    function addNewTableRow(data) {
        if (!tabelMkBody) return;
        const newRow = tabelMkBody.insertRow(0);
        newRow.classList.add('hover:bg-gray-700/60', 'transition-colors', 'duration-150', 'ease-in-out');

        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                newRow.dataset[key] = data[key];
            }
        }

        let statusColorClass = 'text-green-400 bg-green-500/20';
        if (data.status === 'Nonaktif') {
            statusColorClass = 'text-red-400 bg-red-500/20';
        }

        newRow.innerHTML = `
            <td class="px-6 py-4 align-top">
                <div>
                    <div class="text-sm font-semibold text-gray-100">${data.kode}</div>
                    <div class="text-xs text-gray-400 mt-0.5">${data.nama}</div>
                </div>
            </td>
            <td class="px-6 py-4 text-sm text-gray-300 align-top">${data.sks}</td>
            <td class="px-6 py-4 text-sm text-gray-300 align-top">${data.semester}</td>
            <td class="px-6 py-4 text-sm text-gray-300 align-top">${data.dosen}</td>
            <td class="px-6 py-4 text-sm text-gray-300 align-top">${data.kuota}</td>
            <td class="px-6 py-4 align-top">
                <span class="px-3 py-1 text-xs font-semibold rounded-full ${statusColorClass} leading-normal">${data.status}</span>
            </td>
            <td class="px-6 py-4 align-top text-center">
                <div class="flex items-center justify-center space-x-2">
                    <button title="Edit Mata Kuliah" class="text-gray-300 hover:text-secondary p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-edit-mk"><i class="ri-pencil-line ri-lg"></i></button>
                    <button title="Hapus Mata Kuliah" class="text-gray-300 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-hapus-mk"><i class="ri-delete-bin-line ri-lg"></i></button>
                </div>
            </td>
        `;
    }

    if(tabelMkBody) {
        tabelMkBody.addEventListener('click', function(e) {
            const row = e.target.closest('tr');
            if (!row || !row.dataset.id) return;

            if (e.target.closest('.btn-edit-mk')) {
                currentlyEditingRow = row;
                if(modalMkTitle) modalMkTitle.textContent = 'Edit Mata Kuliah';
                if(modalMkSubmitBtn) modalMkSubmitBtn.textContent = 'Update';
                
                if(document.getElementById('mk-kode')) document.getElementById('mk-kode').readOnly = true;

                if(mkIdInput) mkIdInput.value = row.dataset.id;
                if(document.getElementById('mk-kode')) document.getElementById('mk-kode').value = row.dataset.kode;
                if(document.getElementById('mk-nama')) document.getElementById('mk-nama').value = row.dataset.nama;
                if(document.getElementById('mk-sks')) document.getElementById('mk-sks').value = row.dataset.sks;
                if(document.getElementById('mk-semester')) document.getElementById('mk-semester').value = row.dataset.semester;
                if(document.getElementById('mk-dosen')) document.getElementById('mk-dosen').value = row.dataset.dosen;
                if(document.getElementById('mk-kuota')) document.getElementById('mk-kuota').value = row.dataset.kuota;
                if(document.getElementById('mk-status')) document.getElementById('mk-status').value = row.dataset.status;
                
                openModalEnhanced(modalAddEditMk, modalAddEditContent);
            } else if (e.target.closest('.btn-hapus-mk')) {
                if (confirm('Apakah Anda yakin ingin menghapus mata kuliah "' + row.dataset.nama + '"? Aksi ini tidak dapat diurungkan.')) {
                    row.remove();
                    updateMkTableInfo();
                }
            }
        });
    }

    function updateMkTableInfo() {
        if (!tabelMkBody) return;
        const rowCount = tabelMkBody.querySelectorAll('tr').length;
        const showingFrom = document.getElementById('mk-showing-from');
        const showingTo = document.getElementById('mk-showing-to');
        const totalResults = document.getElementById('mk-total-results');

        if (rowCount === 0) {
            if(noResultsMkDiv) noResultsMkDiv.classList.remove('hidden');
            if(showingFrom) showingFrom.textContent = '0';
            if(showingTo) showingTo.textContent = '0';
            if(totalResults) totalResults.textContent = '0';
        } else {
            if(noResultsMkDiv) noResultsMkDiv.classList.add('hidden');
            if(showingFrom) showingFrom.textContent = '1';
            if(showingTo) showingTo.textContent = rowCount;
            if(totalResults) totalResults.textContent = rowCount;
        }
    }
    updateMkTableInfo();

    const searchInputMk = document.getElementById('search-input-mk');
    const filterSemesterMk = document.getElementById('filter-semester-mk');
    const btnFilterMk = document.getElementById('btn-filter-mk');

    if (btnFilterMk) {
        btnFilterMk.addEventListener('click', function() {
            if (!searchInputMk || !filterSemesterMk || !tabelMkBody) return;
            const searchTerm = searchInputMk.value.toLowerCase();
            const selectedSemester = filterSemesterMk.value;
            let visibleRows = 0;

            const rows = tabelMkBody.querySelectorAll('tr');
            rows.forEach(row => {
                const kode = (row.dataset.kode || '').toLowerCase();
                const nama = (row.dataset.nama || '').toLowerCase();
                const semester = row.dataset.semester || '';

                const matchesSearch = kode.includes(searchTerm) || nama.includes(searchTerm);
                const matchesSemester = selectedSemester === "" || semester === selectedSemester;

                if (matchesSearch && matchesSemester) {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            const showingFrom = document.getElementById('mk-showing-from');
            const showingTo = document.getElementById('mk-showing-to');

            if (visibleRows === 0) {
                if(noResultsMkDiv) noResultsMkDiv.classList.remove('hidden');
                if(showingFrom) showingFrom.textContent = '0';
                if(showingTo) showingTo.textContent = '0';
            } else {
               if(noResultsMkDiv) noResultsMkDiv.classList.add('hidden');
               if(showingFrom) showingFrom.textContent = '1';
               if(showingTo) showingTo.textContent = visibleRows;
            }
        });
    }
});