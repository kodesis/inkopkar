<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/table-datatable-jquery.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/app.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/app-dark.css">

<script src="<?= base_url('assets/admin') ?>/static/js/initTheme.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>


<script>
    // Ganti inisialisasi DataTable Anda dengan ini
    let jquery_datatable = $("#table_1").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        iDisplayLength: 10,
        ajax: {
            url: "<?php echo site_url('Kebutuhan/ajax_list') ?>",
            type: "POST",
            // TAMBAHKAN BAGIAN INI UNTUK MENGIRIM DATA FILTER
            data: function(d) {
                // Ambil nilai dari input bulan dan kirim sebagai parameter 'filter_bulan'
                d.filter_bulan = $('#filter_bulan').val();
            }
        },
        columnDefs: [{
            targets: [-1],
            orderable: false
        }]
    });

    // TAMBAHKAN EVENT LISTENER UNTUK TOMBOL FILTER
    $('#btn_filter').on('click', function() {
        // Reload DataTable
        jquery_datatable.ajax.reload();

        // Panggil fungsi untuk memuat rekapitulasi (akan kita buat di Bagian B)
        load_summary();
    });

    function load_summary() {
        const filter_bulan = $('#filter_bulan').val();
        const summary_container = $('#summary_container');

        if (!filter_bulan) {
            summary_container.html('<p class="text-muted">Silakan pilih bulan dan klik Filter untuk melihat rekapitulasi.</p>');
            return;
        }

        // Tampilkan pesan loading
        summary_container.html('<p>Menghitung total...</p>');

        $.ajax({
            url: "<?php echo site_url('Kebutuhan/ajax_summary') ?>",
            type: "POST",
            data: {
                filter_bulan: filter_bulan
            },
            dataType: "JSON",
            success: function(response) {
                if (response.length > 0) {
                    let html = '<table class="table table-bordered">';
                    html += '<thead><tr><th>Kebutuhan</th><th>Total</th></tr></thead><tbody>';

                    response.forEach(item => {
                        let itemName = item.nama_kebutuhan;
                        if (item.tipe_kebutuhan) {
                            itemName += ' - Tipe ' + item.tipe_kebutuhan.toUpperCase();
                        }

                        let total = parseFloat(item.total_jumlah).toLocaleString('id-ID', {
                            minimumFractionDigits: 2,
                            maximumFractionDigits: 2
                        });

                        html += `<tr><td>${itemName}</td><td><strong>${total} ${item.satuan}</strong></td></tr>`;
                    });

                    html += '</tbody></table>';
                    summary_container.html(html);
                } else {
                    summary_container.html('<p class="text-muted">Tidak ada data kebutuhan pada bulan yang dipilih.</p>');
                }
            },
            error: function() {
                summary_container.html('<p class="text-danger">Gagal memuat rekapitulasi. Silakan coba lagi.</p>');
            }
        });
    }

    $('#btn_filter').click();
</script>