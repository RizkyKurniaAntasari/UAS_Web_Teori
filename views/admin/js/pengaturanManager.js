document.addEventListener('DOMContentLoaded', function () {
    const showMessage = (type, message) => {
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('px-4', 'py-3', 'rounded-md', 'mb-6', 'text-sm');
        if (type === 'success') {
            messageContainer.classList.add('bg-green-900/70', 'border', 'border-green-700', 'text-green-300');
        } else if (type === 'error') {
            messageContainer.classList.add('bg-red-900/70', 'border', 'border-red-700', 'text-red-300');
            messageContainer.innerHTML = `<strong class="font-bold">Kesalahan!</strong> <span>${message}</span>`;
        }
        if (type === 'success') {
            messageContainer.innerHTML = `<span>${message}</span>`;
        }

        const mainContentArea = document.querySelector('main .bg-gray-800');
        if (mainContentArea) {
            const existingMessages = mainContentArea.querySelectorAll('.bg-green-900\\/70, .bg-red-900\\/70');
            existingMessages.forEach(msg => msg.remove());
            mainContentArea.prepend(messageContainer);
        }

        setTimeout(() => {
            messageContainer.remove();
        }, 5000);
    };

    const formAddSlot = document.getElementById('form-add-slot');
    const tableSlotJadwalBody = document.querySelector('#tabel-slot-jadwal tbody');
    const btnCancelSlot = document.getElementById('btn-cancel-slot');
    const btnSubmitSlot = document.getElementById('btn-submit-slot');
    const slotActionInput = document.getElementById('slot-action');
    const slotIdInput = document.getElementById('slot-id');
    const slotJenisJadwalSelect = document.getElementById('slot-jenis-jadwal');
    const slotTanggalInput = document.getElementById('slot-tanggal');
    const slotPukulInput = document.getElementById('slot-pukul');
    const statusDibukaRadio = document.getElementById('status-dibuka');
    const statusDitutupRadio = document.getElementById('status-ditutup');

    const getAllExistingSlotDatetimes = (excludeId = null) => {
        const datetimes = [];
        const rows = Array.from(tableSlotJadwalBody.querySelectorAll('tr'));
        rows.forEach(row => {
            if (row.id === 'no-slot-results') return; 
            if (excludeId && row.dataset.id === excludeId) {
                return; 
            }
            const tanggal = row.children[1].textContent.trim();
            const pukul = row.children[2].textContent.trim();
            datetimes.push(new Date(`${tanggal}T${pukul}`));
        });
        return datetimes;
    };

    const getJadwalAwalFromTable = () => {
        const rows = Array.from(tableSlotJadwalBody.querySelectorAll('tr'));
        for (let row of rows) {
            if (row.id === 'no-slot-results') continue;
            const jenisJadwal = row.dataset.jenisJadwal;
            if (jenisJadwal === 'Jadwal Awal') {
                const tanggal = row.children[1].textContent.trim();
                const pukul = row.children[2].textContent.trim();
                return new Date(`${tanggal}T${pukul}`);
            }
        }
        return null;
    };

    const getLatestJadwalWawancaraFromTable = (excludeId = null) => {
        const wawancaraSlots = Array.from(tableSlotJadwalBody.querySelectorAll('tr[data-jenis-jadwal="Jadwal Wawancara"]'));
        if (wawancaraSlots.length === 0) return null;

        let latestDateTime = null;
        wawancaraSlots.forEach(row => {
            if (excludeId && row.dataset.id === excludeId) return;
            const tanggal = row.children[1].textContent.trim();
            const pukul = row.children[2].textContent.trim();
            const currentDateTime = new Date(`${tanggal}T${pukul}`);
            if (latestDateTime === null || currentDateTime > latestDateTime) {
                latestDateTime = currentDateTime;
            }
        });
        return latestDateTime;
    };

    const getLatestJadwalIstirahatFromTable = (excludeId = null) => {
        const istirahatSlots = Array.from(tableSlotJadwalBody.querySelectorAll('tr[data-jenis-jadwal="Jadwal Istirahat"]'));
        if (istirahatSlots.length === 0) return null;

        let latestDateTime = null;
        istirahatSlots.forEach(row => {
            if (excludeId && row.dataset.id === excludeId) return;
            const tanggal = row.children[1].textContent.trim();
            const pukul = row.children[2].textContent.trim();
            const currentDateTime = new Date(`${tanggal}T${pukul}`);
            if (latestDateTime === null || currentDateTime > latestDateTime) {
                latestDateTime = currentDateTime;
            }
        });
        return latestDateTime;
    };


    const updateJenisJadwalOptions = () => {
        slotJenisJadwalSelect.innerHTML = '<option value="" disabled selected>Pilih Jenis Jadwal</option>'; 

        const currentJadwalAwal = getJadwalAwalFromTable();
        const hasJadwalAwal = currentJadwalAwal !== null;
        const hasJadwalAkhir = Array.from(tableSlotJadwalBody.querySelectorAll('tr[data-jenis-jadwal="Jadwal Akhir"]')).length > 0;

        const optionsToAdd = [];
        if (!hasJadwalAwal) {
            optionsToAdd.push('Jadwal Awal');
        } else {
            optionsToAdd.push('Jadwal Wawancara');
            optionsToAdd.push('Jadwal Istirahat');
            if (!hasJadwalAkhir) {
                optionsToAdd.push('Jadwal Akhir');
            }
        }
        
        const allPossibleOptions = ['Jadwal Awal', 'Jadwal Wawancara', 'Jadwal Istirahat', 'Jadwal Akhir'];
        allPossibleOptions.forEach(type => {
            const option = document.createElement('option');
            option.value = type;
            option.textContent = type;
            
            let shouldAdd = false;
            let shouldDisable = false;

            if (slotActionInput.value === 'create') {
                if (type === 'Jadwal Awal' && !hasJadwalAwal) {
                    shouldAdd = true;
                } else if (type === 'Jadwal Wawancara' && hasJadwalAwal) {
                    shouldAdd = true;
                } else if (type === 'Jadwal Istirahat' && hasJadwalAwal) {
                    shouldAdd = true;
                } else if (type === 'Jadwal Akhir' && hasJadwalAwal && !hasJadwalAkhir) {
                    shouldAdd = true;
                }
            } else if (slotActionInput.value === 'update') {
                shouldAdd = true; 
                const originalJenisJadwal = document.querySelector(`tr[data-id='${slotIdInput.value}']`)?.dataset.jenisJadwal;
                if (type === 'Jadwal Awal' && hasJadwalAwal && originalJenisJadwal !== 'Jadwal Awal') {
                    shouldDisable = true;
                }
                if (type === 'Jadwal Akhir' && hasJadwalAkhir && originalJenisJadwal !== 'Jadwal Akhir') {
                    shouldDisable = true;
                }
            }

            if (shouldAdd) {
                slotJenisJadwalSelect.appendChild(option);
                if (shouldDisable) {
                    option.disabled = true;
                }
            }
        });
        
        let hasSelectableOption = false;
        Array.from(slotJenisJadwalSelect.options).forEach(opt => {
            if (opt.value !== "" && !opt.disabled) {
                hasSelectableOption = true;
            }
        });

        if (!hasSelectableOption) {
            slotJenisJadwalSelect.innerHTML = '<option value="" disabled selected>Tidak ada slot tersedia untuk ditambahkan</option>';
            slotJenisJadwalSelect.disabled = true;
            btnSubmitSlot.disabled = true;
        } else {
            slotJenisJadwalSelect.disabled = false;
            btnSubmitSlot.disabled = false;
        }
        
        if (slotJenisJadwalSelect.options.length === 2 && slotJenisJadwalSelect.options[0].value === "") { 
            slotJenisJadwalSelect.value = slotJenisJadwalSelect.options[1].value;
        }
    };

    const createSlotTableRowHTML = (data) => {
        const statusColorClass = data.status === 'Dibuka' ? 'bg-green-500/20 text-green-400' : 'bg-red-500/20 text-red-400';
        return `
            <td class="px-6 py-4 text-sm text-gray-300">${data.jenis_jadwal}</td>
            <td class="px-6 py-4 text-sm text-gray-300">${data.tanggal}</td>
            <td class="px-6 py-4 text-sm text-gray-300">${data.pukul}</td>
            <td class="px-6 py-4">
                <span class="px-2 py-1 text-xs font-semibold rounded-full ${statusColorClass}">
                    ${data.status}
                </span>
            </td>
            <td class="px-6 py-4 text-center">
                <div class="flex items-center justify-center space-x-2">
                    <button title="Edit" class="text-gray-300 hover:text-secondary p-1.5 btn-edit-slot"><i class="ri-pencil-line ri-lg"></i></button>
                    <button title="Hapus" class="text-gray-300 hover:text-red-400 p-1.5 btn-delete-slot"><i class="ri-delete-bin-line ri-lg"></i></button>
                </div>
            </td>
        `;
    };

    const resetSlotForm = () => {
        formAddSlot.reset();
        slotActionInput.value = 'create';
        slotIdInput.value = '';
        btnSubmitSlot.innerHTML = '<i class="ri-add-line"></i> <span>Tambah Slot</span>';
        btnCancelSlot.classList.add('hidden');
        statusDibukaRadio.checked = true;
        updateJenisJadwalOptions(); 
    };

    if (formAddSlot) {
        formAddSlot.addEventListener('submit', async (e) => {
            e.preventDefault();
            const formData = new FormData(formAddSlot);
            const action = formData.get('action');
            const jenisJadwalSelected = formData.get('jenis_jadwal');
            const newSlotTanggal = formData.get('tanggal');
            const newSlotPukul = formData.get('pukul');
            const newSlotDatetime = new Date(`${newSlotTanggal}T${newSlotPukul}`);

            const allExistingDatetimes = getAllExistingSlotDatetimes(action === 'update' ? slotIdInput.value : null);
            for (const existingDt of allExistingDatetimes) {
                if (newSlotDatetime < existingDt) {
                    showMessage('error', "Jadwal baru tidak bisa lebih cepat dari jadwal yang sudah ada.");
                    return;
                }
            }

            const currentJadwalAwal = getJadwalAwalFromTable();
            
            if (jenisJadwalSelected === 'Jadwal Wawancara' || jenisJadwalSelected === 'Jadwal Istirahat' || jenisJadwalSelected === 'Jadwal Akhir') {
                if (!currentJadwalAwal) {
                    showMessage('error', "Anda harus membuat 'Jadwal Awal' terlebih dahulu.");
                    return;
                }
                if (newSlotDatetime < currentJadwalAwal) {
                    showMessage('error', `Tanggal dan pukul ${jenisJadwalSelected} tidak boleh sebelum 'Jadwal Awal'.`);
                    return;
                }
            }

            if (jenisJadwalSelected === 'Jadwal Akhir') {
                const latestWawancara = getLatestJadwalWawancaraFromTable(action === 'update' ? slotIdInput.value : null);
                const latestIstirahat = getLatestJadwalIstirahatFromTable(action === 'update' ? slotIdInput.value : null);
                
                let latestPrecedingDateTime = null;
                if (latestWawancara) {
                    latestPrecedingDateTime = latestWawancara;
                }
                if (latestIstirahat) {
                    if (latestPrecedingDateTime === null || latestIstirahat > latestPrecedingDateTime) {
                        latestPrecedingDateTime = latestIstirahat;
                    }
                }

                if (latestPrecedingDateTime && newSlotDatetime < latestPrecedingDateTime) {
                     showMessage('error', "Tanggal dan pukul 'Jadwal Akhir' tidak boleh sebelum 'Jadwal Wawancara' atau 'Jadwal Istirahat' terakhir.");
                     return;
                }
            }

            const response = await fetch('api/slot_jadwal_handler.php', {
                method: 'POST',
                body: formData
            });
            const result = await response.json();

            if (result.status === 'success') {
                showMessage('success', result.message);
                if (action === 'create') {
                    const newRow = document.createElement('tr');
                    newRow.dataset.id = result.data.id;
                    newRow.dataset.jenisJadwal = result.data.jenis_jadwal;
                    newRow.innerHTML = createSlotTableRowHTML(result.data);
                    tableSlotJadwalBody.prepend(newRow);
                    
                    const noResultsRow = document.getElementById('no-slot-results');
                    if (noResultsRow) noResultsRow.remove();

                } else if (action === 'update') {
                    const updatedRow = tableSlotJadwalBody.querySelector(`tr[data-id='${result.data.id}']`);
                    if (updatedRow) {
                        updatedRow.dataset.jenisJadwal = result.data.jenis_jadwal;
                        updatedRow.innerHTML = createSlotTableRowHTML(result.data);
                    }
                }
                resetSlotForm();
            } else {
                showMessage('error', result.message);
            }
        });
    }

    if (tableSlotJadwalBody) {
        tableSlotJadwalBody.addEventListener('click', async (e) => {
            const row = e.target.closest('tr');
            if (!row) return;

            const id = row.dataset.id;
            const cells = row.querySelectorAll('td');
            const currentJenisJadwalInRow = row.dataset.jenisJadwal;


            if (e.target.closest('.btn-edit-slot')) {
                slotActionInput.value = 'update';
                slotIdInput.value = id;
                
                slotJenisJadwalSelect.innerHTML = `
                    <option value="Jadwal Awal">Jadwal Awal</option>
                    <option value="Jadwal Wawancara">Jadwal Wawancara</option>
                    <option value="Jadwal Istirahat">Jadwal Istirahat</option>
                    <option value="Jadwal Akhir">Jadwal Akhir</option>
                `;
                const rows = Array.from(tableSlotJadwalBody.querySelectorAll('tr'));
                rows.forEach(r => {
                    if (r.dataset.id !== id) { 
                        const jenis = r.dataset.jenisJadwal;
                        if (jenis === 'Jadwal Awal') {
                            slotJenisJadwalSelect.querySelector('option[value="Jadwal Awal"]').disabled = true;
                        }
                        if (jenis === 'Jadwal Akhir') {
                            slotJenisJadwalSelect.querySelector('option[value="Jadwal Akhir"]').disabled = true;
                        }
                    }
                });


                slotJenisJadwalSelect.value = cells[0].textContent.trim();
                slotTanggalInput.value = cells[1].textContent.trim();
                slotPukulInput.value = cells[2].textContent.trim();
                
                const currentStatus = cells[3].querySelector('span').textContent.trim();
                if (currentStatus === 'Dibuka') {
                    statusDibukaRadio.checked = true;
                } else {
                    statusDitutupRadio.checked = true;
                }

                btnSubmitSlot.innerHTML = '<i class="ri-save-line"></i> <span>Perbarui Slot</span>';
                btnCancelSlot.classList.remove('hidden');
                slotJenisJadwalSelect.disabled = false;
            }

            if (e.target.closest('.btn-delete-slot')) {
                const jenisJadwal = cells[0].textContent.trim();
                const tanggal = cells[1].textContent.trim();
                const pukul = cells[2].textContent.trim();

                if (confirm(`Apakah Anda yakin ingin menghapus slot jadwal "${jenisJadwal} - ${tanggal} ${pukul}"?`)) {
                    const formData = new FormData();
                    formData.append('action', 'delete');
                    formData.append('id', id);

                    const response = await fetch('api/slot_jadwal_handler.php', {
                        method: 'POST',
                        body: formData
                    });
                    const result = await response.json();

                    if (result.status === 'success') {
                        showMessage('success', result.message);
                        row.remove();
                        if (tableSlotJadwalBody.children.length === 0) {
                            const noResultsRow = document.createElement('tr');
                            noResultsRow.id = 'no-slot-results';
                            noResultsRow.innerHTML = '<td colspan="5" class="px-6 py-12 text-center text-gray-500">Tidak ada jadwal slot tersedia.</td>';
                            tableSlotJadwalBody.appendChild(noResultsRow);
                        }
                        resetSlotForm(); 
                    } else {
                        showMessage('error', result.message);
                    }
                }
            }
        });
    }

    if (btnCancelSlot) {
        btnCancelSlot.addEventListener('click', resetSlotForm);
    }

    updateJenisJadwalOptions();
});