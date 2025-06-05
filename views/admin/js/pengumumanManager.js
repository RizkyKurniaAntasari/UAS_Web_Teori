document.addEventListener('DOMContentLoaded', function () {
    const tambahAsdosBtn = document.getElementById('tambah-asdos-btn');
    const modal = document.getElementById('tambah-asdos-modal');
    const closeModalBtn = document.getElementById('close-modal-btn');
    const cancelModalBtn = document.getElementById('cancel-modal-btn');
    const formTambahAsdos = document.getElementById('form-tambah-asdos');
    const tabelAsdosBody = document.querySelector('#tabel-asdos tbody');
    const noResultsDiv = document.getElementById('no-results');
    
    const modalTitleEl = document.getElementById('modal-title');
    const modalSubmitBtn = document.getElementById('modal-submit-btn');
    const modalNpmInput = document.getElementById('modal-npm');

    let editingRow = null; 

    function openModal() {
        if (!modal) return;
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeModal() {
        if (!modal) return;
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        if (formTambahAsdos) formTambahAsdos.reset();
        editingRow = null; 
        if (modalTitleEl) modalTitleEl.textContent = 'Tambah Asisten Dosen Baru';
        if (modalSubmitBtn) modalSubmitBtn.textContent = 'Simpan Asisten';
        if (modalNpmInput) modalNpmInput.readOnly = false;
    }

    if (tambahAsdosBtn) {
        tambahAsdosBtn.addEventListener('click', function() {
            editingRow = null; 
            if (modalTitleEl) modalTitleEl.textContent = 'Tambah Asisten Dosen Baru';
            if (modalSubmitBtn) modalSubmitBtn.textContent = 'Simpan Asisten';
            if (modalNpmInput) modalNpmInput.readOnly = false;
            if (formTambahAsdos) formTambahAsdos.reset();
            openModal();
        });
    }

    if (closeModalBtn) closeModalBtn.addEventListener('click', closeModal);
    if (cancelModalBtn) cancelModalBtn.addEventListener('click', closeModal);
    
    if (modal) {
        modal.addEventListener('click', function(event) {
            if (event.target === modal) {
                closeModal();
            }
        });
    }

    if (formTambahAsdos) {
        formTambahAsdos.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(formTambahAsdos);
            const npm = formData.get('npm');
            const nama = formData.get('nama');
            const pjKelas = formData.get('pj_kelas');
            const matkul = formData.get('matkul');
            const keterangan = formData.get('keterangan');

            let keteranganClass = 'text-blue-400 bg-blue-500/20'; 
            if (keterangan && keterangan.toLowerCase() === 'koordinator') {
                keteranganClass = 'text-green-400 bg-green-500/20';
            }

            if (editingRow) { 
                editingRow.cells[0].textContent = npm; 
                editingRow.cells[1].querySelector('div').textContent = nama;
                editingRow.cells[2].textContent = pjKelas;
                editingRow.cells[3].textContent = matkul;
                const keteranganSpan = editingRow.cells[4].querySelector('span');
                if (keteranganSpan) {
                    keteranganSpan.textContent = keterangan;
                    keteranganSpan.className = `px-2 py-1 text-xs font-semibold rounded-full ${keteranganClass}`;
                }
            } else { 
                if (!tabelAsdosBody) return;
                const newRow = document.createElement('tr');
                newRow.classList.add('hover:bg-gray-700/50', 'transition-colors', 'duration-150');
                newRow.innerHTML = `
                    <td class="px-6 py-4 text-sm text-gray-200">${npm}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-medium text-gray-100">${nama}</div>
                    </td>
                    <td class="px-6 py-4 text-sm text-gray-200">${pjKelas}</td>
                    <td class="px-6 py-4 text-sm text-gray-200">${matkul}</td>
                    <td class="px-6 py-4">
                        <span class="px-2 py-1 text-xs font-semibold rounded-full ${keteranganClass}">${keterangan}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center space-x-1">
                            <button title="Edit" class="text-gray-400 hover:text-blue-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors edit-btn"><i class="ri-pencil-line ri-lg"></i></button>
                            <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors delete-btn"><i class="ri-delete-bin-line ri-lg"></i></button>
                        </div>
                    </td>
                `;
                tabelAsdosBody.appendChild(newRow);
            }
            updateTableInfo();
            closeModal();
        });
    }

    if (tabelAsdosBody) {
        tabelAsdosBody.addEventListener('click', function(event) {
            const targetElement = event.target;
            const deleteButton = targetElement.closest('.delete-btn');
            const editButton = targetElement.closest('.edit-btn');

            if (deleteButton) {
                const rowToRemove = deleteButton.closest('tr');
                if (rowToRemove) {
                    rowToRemove.remove();
                    updateTableInfo();
                }
            } else if (editButton) {
                editingRow = editButton.closest('tr');
                if (!editingRow) return;

                const npm = editingRow.cells[0].textContent;
                const nama = editingRow.cells[1].querySelector('div').textContent;
                const pjKelas = editingRow.cells[2].textContent;
                const matkul = editingRow.cells[3].textContent;
                const keteranganText = editingRow.cells[4].querySelector('span').textContent;

                if(modalNpmInput) modalNpmInput.value = npm;
                if(document.getElementById('modal-nama')) document.getElementById('modal-nama').value = nama;
                if(document.getElementById('modal-pj-kelas')) document.getElementById('modal-pj-kelas').value = pjKelas;
                if(document.getElementById('modal-matkul')) document.getElementById('modal-matkul').value = matkul;
                if(document.getElementById('modal-keterangan')) document.getElementById('modal-keterangan').value = keteranganText;
                
                if (modalTitleEl) modalTitleEl.textContent = 'Edit Data Asisten Dosen';
                if (modalSubmitBtn) modalSubmitBtn.textContent = 'Update Data';
                if (modalNpmInput) modalNpmInput.readOnly = true; 

                openModal();
            }
        });
    }
    
    function updateTableInfo() {
        if (!tabelAsdosBody) return;
        const rowCount = tabelAsdosBody.querySelectorAll('tr').length;
        const showingFrom = document.getElementById('showing-from');
        const showingTo = document.getElementById('showing-to');
        const totalResults = document.getElementById('total-results');

        if (rowCount === 0) {
            if (noResultsDiv) noResultsDiv.classList.remove('hidden');
            if (showingFrom) showingFrom.textContent = '0';
            if (showingTo) showingTo.textContent = '0';
            if (totalResults) totalResults.textContent = '0';
        } else {
            if (noResultsDiv) noResultsDiv.classList.add('hidden');
            if (showingFrom) showingFrom.textContent = '1';
            if (showingTo) showingTo.textContent = rowCount;
            if (totalResults) totalResults.textContent = rowCount;
        }
    }

    updateTableInfo();

    const searchInput = document.getElementById('search-input');
    const filterMatkulSelect = document.getElementById('filter-matkul');
    const filterButton = document.getElementById('filter-button');

    if (filterButton) {
        filterButton.addEventListener('click', function() {
            if (!searchInput || !filterMatkulSelect || !tabelAsdosBody) return;

            const searchTerm = searchInput.value.toLowerCase();
            const selectedMatkul = filterMatkulSelect.value; 
            let visibleRows = 0;

            const rows = tabelAsdosBody.querySelectorAll('tr');
            rows.forEach(row => {
                const npm = row.cells[0].textContent.toLowerCase();
                const nama = row.cells[1].textContent.toLowerCase(); 
                const matkulInRow = row.cells[3].textContent;
                
                const matchesSearch = npm.includes(searchTerm) || nama.includes(searchTerm);
                const matchesMatkul = selectedMatkul === "" || matkulInRow === selectedMatkul;

                if (matchesSearch && matchesMatkul) {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            const showingFrom = document.getElementById('showing-from');
            const showingTo = document.getElementById('showing-to');

            if (visibleRows === 0) {
                if (noResultsDiv) noResultsDiv.classList.remove('hidden');
                if (showingFrom) showingFrom.textContent = '0';
                if (showingTo) showingTo.textContent = '0';
            } else {
                if (noResultsDiv) noResultsDiv.classList.add('hidden');
                if (showingFrom) showingFrom.textContent = '1';
                if (showingTo) showingTo.textContent = visibleRows;
            }
            
            if (noResultsDiv) {
                if (visibleRows === 0 && (searchTerm || selectedMatkul)) {
                        noResultsDiv.classList.remove('hidden');
                } else if (visibleRows === 0 && !searchTerm && !selectedMatkul && tabelAsdosBody.querySelectorAll('tr').length > 0) {
                        if (tabelAsdosBody.querySelectorAll('tr[style*="display: none"]').length === tabelAsdosBody.querySelectorAll('tr').length && tabelAsdosBody.querySelectorAll('tr').length > 0){
                            noResultsDiv.classList.remove('hidden'); 
                        } else if (tabelAsdosBody.querySelectorAll('tr').length === 0){
                            noResultsDiv.classList.remove('hidden'); 
                        }
                } else if (visibleRows > 0) {
                        noResultsDiv.classList.add('hidden');
                }
            }
        });
    }
});