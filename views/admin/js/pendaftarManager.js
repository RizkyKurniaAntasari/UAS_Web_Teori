document.addEventListener('DOMContentLoaded', function () {
    const tableBody = document.querySelector('#tabel-pendaftar tbody');

    if (!tableBody) return;

    const handleAction = async (formData) => {
        try {
            const response = await fetch('api/pendaftar_handler.php', {
                method: 'POST',
                body: formData
            });
            if (!response.ok) throw new Error(`HTTP error! status: ${response.status}`);
            return await response.json();
        } catch (error) {
            console.error('Fetch Error:', error);
            return { status: 'error', message: 'Request failed. See console for details.' };
        }
    };

    tableBody.addEventListener('change', async (event) => {
        if (event.target.classList.contains('status-select')) {
            const row = event.target.closest('tr');
            const id = row.dataset.id;
            const status = event.target.value;

            const formData = new FormData();
            formData.append('action', 'update_status');
            formData.append('id', id);
            formData.append('status', status);

            const result = await handleAction(formData);
            if (result.status !== 'success') {
                alert(`Error: ${result.message}`);
            }
        }
    });

    tableBody.addEventListener('click', async (event) => {
        const deleteBtn = event.target.closest('.btn-hapus-pendaftar');
        if (deleteBtn) {
            const row = deleteBtn.closest('tr');
            const id = row.dataset.id;
            const nama = row.querySelector('.font-semibold').textContent;

            if (confirm(`Apakah Anda yakin ingin menghapus pendaftar "${nama}"?`)) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);

                const result = await handleAction(formData);

                if (result.status === 'success') {
                    row.remove();
                    if (tableBody.rows.length === 0) {
                        const noResultsRow = `<tr id="no-results-pendaftar"><td colspan="4" class="px-6 py-12 text-center text-gray-500">Tidak ada data pendaftar.</td></tr>`;
                        tableBody.innerHTML = noResultsRow;
                    }
                } else {
                    alert(`Error: ${result.message}`);
                }
            }
        }
    });
});