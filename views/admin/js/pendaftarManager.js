document.addEventListener('DOMContentLoaded', function () {
    const modalLihatLanjut = document.getElementById('modal-lihat-lanjut');
    const btnCloseModalLihatLanjut = document.getElementById('btn-close-modal-lihat-lanjut');
    const btnOkModalLihatLanjut = document.getElementById('btn-ok-modal-lihat-lanjut');
    const modalLihatLanjutContent = modalLihatLanjut ? modalLihatLanjut.querySelector('.transform') : null;

    const modalAddEditPendaftar = document.getElementById('modal-add-edit-pendaftar');
    const btnTambahPendaftar = document.getElementById('btn-tambah-pendaftar');
    const btnCloseModalAddEdit = document.getElementById('btn-close-modal-add-edit');
    const btnCancelModalAddEdit = document.getElementById('btn-cancel-modal-add-edit');
    const formAddEditPendaftar = document.getElementById('form-add-edit-pendaftar');
    const modalPendaftarTitle = document.getElementById('modal-pendaftar-title');
    const modalPendaftarSubmitBtn = document.getElementById('btn-submit-modal-add-edit');
    const pendaftarIdInput = document.getElementById('pendaftar-id');
    const pendaftarNpmInput = document.getElementById('pendaftar-npm');
    const pendaftarStatusSelect = document.getElementById('pendaftar-status');
    const previewSuratEdit = document.getElementById('preview-surat-edit');
    const inputSuratPernyataanUrl = document.getElementById('pendaftar-surat_pernyataan_url');
    const modalAddEditContent = modalAddEditPendaftar ? modalAddEditPendaftar.querySelector('.transform') : null;

    const tabelPendaftarBody = document.querySelector('#tabel-pendaftar tbody');
    const noResultsPendaftarDiv = document.getElementById('no-results-pendaftar');

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

    if (btnCloseModalLihatLanjut) btnCloseModalLihatLanjut.addEventListener('click', () => closeModalEnhanced(modalLihatLanjut, modalLihatLanjutContent));
    if (btnOkModalLihatLanjut) btnOkModalLihatLanjut.addEventListener('click', () => closeModalEnhanced(modalLihatLanjut, modalLihatLanjutContent));
    if (modalLihatLanjut) {
        modalLihatLanjut.addEventListener('click', (e) => {
            if (e.target === modalLihatLanjut) closeModalEnhanced(modalLihatLanjut, modalLihatLanjutContent);
        });
    }

    function populateDetailModal(row) {
        document.getElementById('detail-nama').textContent = row.dataset.nama || 'N/A';
        document.getElementById('detail-npm').textContent = row.dataset.npm || 'N/A';
        document.getElementById('detail-no_wa').textContent = row.dataset.no_wa || 'N/A';
        document.getElementById('detail-mk_1').textContent = row.dataset.mk_1 || 'N/A';
        document.getElementById('detail-mk_2').textContent = row.dataset.mk_2 || 'Tidak Ada';
        document.getElementById('detail-alasan').textContent = row.dataset.alasan || 'N/A';
        document.getElementById('detail-bersedia_2_mk').textContent = row.dataset.bersedia_2_mk || 'N/A';
        document.getElementById('detail-pernah_asdos').textContent = row.dataset.pernah_asdos || 'N/A';
        document.getElementById('detail-bersedia_mk_lain').textContent = row.dataset.bersedia_mk_lain || 'N/A';
        const suratImg = document.getElementById('detail-surat_pernyataan_url');
        suratImg.src = row.dataset.surat_pernyataan_url || 'https://via.placeholder.com/300x100.png?text=Tidak+Ada+Gambar';
        suratImg.alt = "Surat Pernyataan " + (row.dataset.nama || '');
    }

    if (btnTambahPendaftar) {
        btnTambahPendaftar.addEventListener('click', () => {
            currentlyEditingRow = null;
            if(formAddEditPendaftar) formAddEditPendaftar.reset();
            if(pendaftarIdInput) pendaftarIdInput.value = '';
            if(modalPendaftarTitle) modalPendaftarTitle.textContent = 'Tambah Pendaftar Baru';
            if(modalPendaftarSubmitBtn) modalPendaftarSubmitBtn.textContent = 'Simpan';
            if(pendaftarNpmInput) pendaftarNpmInput.readOnly = false;
            if(pendaftarStatusSelect) pendaftarStatusSelect.value = ""; 
            if(previewSuratEdit) {
                previewSuratEdit.classList.add('hidden');
                previewSuratEdit.src = '';
            }
            openModalEnhanced(modalAddEditPendaftar, modalAddEditContent);
        });
    }
    if (inputSuratPernyataanUrl) {
        inputSuratPernyataanUrl.addEventListener('input', function() {
            if (this.value && (this.value.startsWith('http://') || this.value.startsWith('https://'))) {
                if(previewSuratEdit) {
                    previewSuratEdit.src = this.value;
                    previewSuratEdit.classList.remove('hidden');
                }
            } else {
                if(previewSuratEdit) {
                    previewSuratEdit.classList.add('hidden');
                    previewSuratEdit.src = '';
                }
            }
        });
    }

    if (btnCloseModalAddEdit) btnCloseModalAddEdit.addEventListener('click', () => closeModalEnhanced(modalAddEditPendaftar, modalAddEditContent));
    if (btnCancelModalAddEdit) btnCancelModalAddEdit.addEventListener('click', () => closeModalEnhanced(modalAddEditPendaftar, modalAddEditContent));
    if (modalAddEditPendaftar) {
        modalAddEditPendaftar.addEventListener('click', (e) => {
            if (e.target === modalAddEditPendaftar) closeModalEnhanced(modalAddEditPendaftar, modalAddEditContent);
        });
    }

    if(formAddEditPendaftar){
        formAddEditPendaftar.addEventListener('submit', function(e) {
            e.preventDefault();
            const formData = new FormData(formAddEditPendaftar);
            const pendaftarData = {
                id: currentlyEditingRow ? currentlyEditingRow.dataset.id : Date.now().toString(), 
                nama: formData.get('nama'),
                npm: formData.get('npm'),
                no_wa: formData.get('no_wa'),
                status: formData.get('status'),
                mk_1: formData.get('mk_1'),
                mk_2: formData.get('mk_2') || '',
                alasan: formData.get('alasan'),
                bersedia_2_mk: formData.get('bersedia_2_mk'),
                pernah_asdos: formData.get('pernah_asdos'),
                bersedia_mk_lain: formData.get('bersedia_mk_lain'),
                surat_pernyataan_url: formData.get('surat_pernyataan_url') || 'https://via.placeholder.com/300x100.png?text=Tidak+Ada+Gambar'
            };

            if (!pendaftarData.status) {
                alert("Silakan pilih status pendaftaran.");
                if(pendaftarStatusSelect) pendaftarStatusSelect.focus();
                return;
            }

            if (currentlyEditingRow) {
                updateTableRow(currentlyEditingRow, pendaftarData);
            } else {
                addNewTableRow(pendaftarData);
            }
            updatePendaftarTableInfo();
            closeModalEnhanced(modalAddEditPendaftar, modalAddEditContent);
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
                <div class="text-sm font-semibold text-gray-100">${data.nama}</div>
                <div class="text-xs text-gray-400 mt-0.5">NPM: ${data.npm}</div>
            </div>`;
        row.cells[1].textContent = data.no_wa;
        const statusSpan = row.cells[2].querySelector('span');
        statusSpan.textContent = data.status;
        statusSpan.className = 'px-3 py-1 text-xs font-semibold rounded-full leading-normal '; 
        if (data.status === 'Diterima') {
            statusSpan.classList.add('text-green-400', 'bg-green-500/20');
        } else if (data.status === 'Ditolak') {
            statusSpan.classList.add('text-red-400', 'bg-red-500/20');
        } else { 
            statusSpan.classList.add('text-yellow-400', 'bg-yellow-500/20');
        }
    }

    function addNewTableRow(data) {
        if (!tabelPendaftarBody) return;
        const newRow = tabelPendaftarBody.insertRow(0); 
        newRow.classList.add('hover:bg-gray-700/60', 'transition-colors', 'duration-150', 'ease-in-out');

        for (const key in data) {
            if (data.hasOwnProperty(key)) {
                newRow.dataset[key] = data[key];
            }
        }

        let statusColorClass = 'text-yellow-400 bg-yellow-500/20'; 
        if (data.status === 'Diterima') {
            statusColorClass = 'text-green-400 bg-green-500/20';
        } else if (data.status === 'Ditolak') {
            statusColorClass = 'text-red-400 bg-red-500/20';
        }

        newRow.innerHTML = `
            <td class="px-6 py-4 align-top">
                <div>
                    <div class="text-sm font-semibold text-gray-100">${data.nama}</div>
                    <div class="text-xs text-gray-400 mt-0.5">NPM: ${data.npm}</div>
                </div>
            </td>
            <td class="px-6 py-4 text-sm text-gray-300 align-top">${data.no_wa}</td>
            <td class="px-6 py-4 align-top">
                <span class="px-3 py-1 text-xs font-semibold rounded-full ${statusColorClass} leading-normal">${data.status}</span>
            </td>
            <td class="px-6 py-4 align-top text-center">
                <div class="flex items-center justify-center space-x-2">
                    <button type="button" class="text-secondary hover:underline text-sm font-medium btn-lihat-lanjut">Detail</button>
                    <button title="Edit Pendaftar" class="text-gray-300 hover:text-secondary p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-edit-pendaftar"><i class="ri-pencil-line ri-lg"></i></button>
                    <button title="Hapus Pendaftar" class="text-gray-300 hover:text-red-400 p-1.5 rounded-md hover:bg-gray-600/50 transition-colors btn-hapus-pendaftar"><i class="ri-delete-bin-line ri-lg"></i></button>
                </div>
            </td>
        `;
    }

    if(tabelPendaftarBody) {
        tabelPendaftarBody.addEventListener('click', function(e) {
            const row = e.target.closest('tr');
            if (!row || !row.dataset.id) return; 

            if (e.target.closest('.btn-lihat-lanjut')) {
                populateDetailModal(row);
                openModalEnhanced(modalLihatLanjut, modalLihatLanjutContent);
            } else if (e.target.closest('.btn-edit-pendaftar')) {
                currentlyEditingRow = row;
                if(modalPendaftarTitle) modalPendaftarTitle.textContent = 'Edit Pendaftar';
                if(modalPendaftarSubmitBtn) modalPendaftarSubmitBtn.textContent = 'Update';
                if(pendaftarNpmInput) pendaftarNpmInput.readOnly = true; 

                if(pendaftarIdInput) pendaftarIdInput.value = row.dataset.id;
                document.getElementById('pendaftar-nama').value = row.dataset.nama;
                if(pendaftarNpmInput) pendaftarNpmInput.value = row.dataset.npm;
                document.getElementById('pendaftar-no_wa').value = row.dataset.no_wa;
                if(pendaftarStatusSelect) pendaftarStatusSelect.value = row.dataset.status;
                document.getElementById('pendaftar-mk_1').value = row.dataset.mk_1;
                document.getElementById('pendaftar-mk_2').value = row.dataset.mk_2;
                document.getElementById('pendaftar-alasan').value = row.dataset.alasan;
                document.getElementById('pendaftar-bersedia_2_mk').value = row.dataset.bersedia_2_mk;
                document.getElementById('pendaftar-pernah_asdos').value = row.dataset.pernah_asdos;
                document.getElementById('pendaftar-bersedia_mk_lain').value = row.dataset.bersedia_mk_lain;
                
                const suratUrl = row.dataset.surat_pernyataan_url;
                if(inputSuratPernyataanUrl) inputSuratPernyataanUrl.value = suratUrl;
                if (previewSuratEdit && suratUrl && (suratUrl.startsWith('http://') || suratUrl.startsWith('https://'))) {
                    previewSuratEdit.src = suratUrl;
                    previewSuratEdit.classList.remove('hidden');
                } else if (previewSuratEdit) {
                    previewSuratEdit.classList.add('hidden');
                    previewSuratEdit.src = '';
                }
                openModalEnhanced(modalAddEditPendaftar, modalAddEditContent);

            } else if (e.target.closest('.btn-hapus-pendaftar')) {
                if (confirm('Apakah Anda yakin ingin menghapus pendaftar "' + row.dataset.nama + '"? Aksi ini tidak dapat diurungkan.')) {
                    row.remove();
                    updatePendaftarTableInfo();
                }
            }
        });
    }

    function updatePendaftarTableInfo() {
        if (!tabelPendaftarBody) return;
        const rowCount = tabelPendaftarBody.querySelectorAll('tr').length;
        const showingFrom = document.getElementById('pendaftar-showing-from');
        const showingTo = document.getElementById('pendaftar-showing-to');
        const totalResults = document.getElementById('pendaftar-total-results');

        if (rowCount === 0) {
            if(noResultsPendaftarDiv) noResultsPendaftarDiv.classList.remove('hidden');
            if(showingFrom) showingFrom.textContent = '0';
            if(showingTo) showingTo.textContent = '0';
            if(totalResults) totalResults.textContent = '0';
        } else {
            if(noResultsPendaftarDiv) noResultsPendaftarDiv.classList.add('hidden');
            if(showingFrom) showingFrom.textContent = '1';
            if(showingTo) showingTo.textContent = rowCount;
            if(totalResults) totalResults.textContent = rowCount;
        }
    }
    updatePendaftarTableInfo(); 

    const searchInputPendaftar = document.getElementById('search-input-pendaftar');
    const filterStatusPendaftar = document.getElementById('filter-status-pendaftar');
    const btnFilterPendaftar = document.getElementById('btn-filter-pendaftar');

    if (btnFilterPendaftar) {
        btnFilterPendaftar.addEventListener('click', function() {
            const searchTerm = searchInputPendaftar.value.toLowerCase();
            const selectedStatus = filterStatusPendaftar.value;
            let visibleRows = 0;

            if(!tabelPendaftarBody) return;
            const rows = tabelPendaftarBody.querySelectorAll('tr');
            rows.forEach(row => {
                const nama = (row.dataset.nama || '').toLowerCase();
                const npm = (row.dataset.npm || '').toLowerCase();
                const status = row.dataset.status || '';

                const matchesSearch = nama.includes(searchTerm) || npm.includes(searchTerm);
                const matchesStatus = selectedStatus === "" || status === selectedStatus;

                if (matchesSearch && matchesStatus) {
                    row.style.display = '';
                    visibleRows++;
                } else {
                    row.style.display = 'none';
                }
            });
            
            const showingFrom = document.getElementById('pendaftar-showing-from');
            const showingTo = document.getElementById('pendaftar-showing-to');

            if (visibleRows === 0) {
                if(noResultsPendaftarDiv) noResultsPendaftarDiv.classList.remove('hidden');
                if(showingFrom) showingFrom.textContent = '0';
                if(showingTo) showingTo.textContent = '0';
            } else {
                if(noResultsPendaftarDiv) noResultsPendaftarDiv.classList.add('hidden');
                if(showingFrom) showingFrom.textContent = '1';
                if(showingTo) showingTo.textContent = visibleRows;
            }
        });
    }
});