document.addEventListener('DOMContentLoaded', function () {
    const modal = document.getElementById('tambah-asdos-modal');
    const form = document.getElementById('form-tambah-asdos');
    const tableBody = document.querySelector('#tabel-asdos tbody');
    
    document.getElementById('tambah-asdos-btn').addEventListener('click', () => modal.classList.remove('hidden'));
    document.getElementById('cancel-modal-btn').addEventListener('click', () => modal.classList.add('hidden'));

    form.addEventListener('submit', async (e) => {
        e.preventDefault();
        const formData = new FormData(form);
        const response = await fetch('api/pengumuman_handler.php', { method: 'POST', body: formData });
        const result = await response.json();

        if (result.status === 'success') {
            const newRow = document.createElement('tr');
            newRow.dataset.id = result.data.id;
            const peranClass = result.data.peran === 'Koordinator' ? 'text-green-400 bg-green-500/20' : 'text-blue-400 bg-blue-500/20';
            newRow.innerHTML = `
                <td class="px-6 py-4">
                    <div class="text-sm font-medium text-gray-100">${result.data.nama_mahasiswa}</div>
                    <div class="text-xs text-gray-400">${result.data.npm}</div>
                </td>
                <td class="px-6 py-4 text-sm">${result.data.mata_kuliah}</td>
                <td class="px-6 py-4 text-sm">${result.data.kelas_pj}</td>
                <td class="px-6 py-4">
                    <span class="px-2 py-1 text-xs font-semibold rounded-full ${peranClass}">${result.data.peran}</span>
                </td>
                <td class="px-6 py-4">
                    <button title="Hapus" class="text-gray-400 hover:text-red-400 p-1.5 delete-btn"><i class="ri-delete-bin-line ri-lg"></i></button>
                </td>
            `;
            const noResultsRow = document.getElementById('no-results');
            if(noResultsRow) noResultsRow.remove();
            tableBody.appendChild(newRow);
            form.reset();
            modal.classList.add('hidden');
        } else {
            alert('Error: ' + result.message);
        }
    });

    tableBody.addEventListener('click', async (e) => {
        if (e.target.closest('.delete-btn')) {
            const row = e.target.closest('tr');
            const id = row.dataset.id;
            if (confirm('Yakin ingin menghapus data ini?')) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);
                const response = await fetch('api/pengumuman_handler.php', { method: 'POST', body: formData });
                const result = await response.json();
                if (result.status === 'success') {
                    row.remove();
                } else {
                    alert('Error: ' + result.message);
                }
            }
        }
    });
});