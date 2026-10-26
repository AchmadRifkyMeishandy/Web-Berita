window.addEventListener('DOMContentLoaded', () => {
    if (typeof simpleDatatables === 'undefined') {
        return;
    }

    document.querySelectorAll('[data-datatable]').forEach((table) => {
        new simpleDatatables.DataTable(table, {
            perPage: 10,
            perPageSelect: [5, 10, 25, 50],
            searchable: true,
            fixedHeight: false,
            labels: {
                placeholder: 'Cari data...',
                perPage: '{select} data per halaman',
                noRows: 'Tidak ada data yang cocok',
                info: 'Menampilkan {start}–{end} dari {rows} data'
            }
        });
    });
});
