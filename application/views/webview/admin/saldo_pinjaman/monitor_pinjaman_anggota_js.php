<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/table-datatable-jquery.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/app.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/app-dark.css">

<script src="<?= base_url('assets/admin') ?>/static/js/initTheme.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>

<!-- CHOICE JS -->
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/extensions/choices.js/public/assets/styles/choices.min.css">
<script src="<?= base_url('assets/admin') ?>/extensions/choices.js/public/assets/scripts/choices.min.js"></script>

<script>
    let jquery_datatable = $("#table_1").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        iDisplayLength: 10,
        ajax: {
            url: "<?php echo site_url('Saldo_Pinjaman/ajax_list_monitor_pinjaman_anggota/' . $this->uri->segment(3)) ?>",
            type: "POST",
            data: function(data) {
                data.filter_status = $('#filter_status').val(); // Mengirim nilai filter ke server
            }
        },
        columnDefs: [{
            targets: [],
            orderable: false
        }],
    });

    // Event listener untuk dropdown filter
    $('#filter_status').on('change', function() {
        jquery_datatable.ajax.reload(); // Memuat ulang data tabel dengan filter baru
    });

    // Event listener untuk tombol ekspor
    $('#export_per_anggota').on('click', function(e) {
        e.preventDefault();
        window.location.href = "<?php echo site_url('Saldo_Pinjaman/export_per_anggota/' . $this->uri->segment(3)) ?>";
    });
</script>