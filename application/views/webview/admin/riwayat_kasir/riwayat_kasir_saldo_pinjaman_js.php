<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/table-datatable-jquery.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/app.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/app-dark.css">

<!-- <script src="<?= base_url('assets/admin') ?>/static/js/initTheme.js"></script> -->
<!-- <script src="<?= base_url('assets/admin') ?>/extensions/jquery/jquery.min.js"></script> -->
<script src="<?= base_url('assets/admin') ?>/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>
<!-- jQuery (Must be loaded first) -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> -->

<!-- Select2 CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>




<script>
    let jquery_datatable = $("#table_1").DataTable({
        responsive: true,
        processing: true,
        serverSide: true,
        order: [],
        iDisplayLength: 10,

        ajax: {
            url: "<?php echo site_url('Riwayat_Kasir/ajax_list_saldo_pinjaman/' . $this->uri->segment(3)) ?>",
            type: "POST",
            data: function(d) {
                d.month = $('#filter_month').val();
                d.year = $('#filter_year').val();
            },
            dataSrc: function(json) {
                // Update footer

                $('#total_saldo').html(
                    new Intl.NumberFormat('id-ID', {
                        style: 'currency',
                        currency: 'IDR',
                        minimumFractionDigits: 0
                    }).format(json.total_saldo)
                );
                return json.data;
            }
        },
        columnDefs: [{
            orderable: false
        }]
    });

    // Add a click handler for the search button
    $('#search_button').on('click', function() {
        jquery_datatable.ajax.reload();
    });
</script>
<!-- Include jQuery (required by Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Summernote CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote1').summernote({
        callbacks: {
            onImageUpload: function(files) {
                uploadImage(files[0]);
            }
        }
    });
    $("#hint").summernote({
        height: 100,
        toolbar: false,
        placeholder: "type with apple, orange, watermelon and lemon",
        hint: {
            words: ["apple", "orange", "watermelon", "lemon"],
            match: /\b(\w{1,})$/,
            search: function(keyword, callback) {
                callback(
                    $.grep(this.words, function(item) {
                        return item.indexOf(keyword) === 0
                    })
                )
            },
        },
    })
</script>