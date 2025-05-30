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
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        iDisplayLength: 10,

        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('iuran/ajax_list/' . $this->uri->segment(3)) ?> ",
            // url: "<?php echo site_url('iuran/ajax_list1/') ?> ",
            type: "POST",
            data: function(data) {}
        },
        columnDefs: [{
            // targets: -1, // The 8th column (0-indexed)
            // orderable: false // Disable sorting
        }]
    })

    $(document).ready(function() {
        $('#upload_excel_form').submit(function(e) {
            e.preventDefault(); // stop normal form submit

            var formData = new FormData(this);

            $.ajax({
                url: "<?php echo site_url('Iuran/process_insert_excel/') ?>",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                beforeSend: function() {
                    Swal.fire({
                        title: 'Loading...',
                        text: 'Please wait while fetching details.',
                        allowOutsideClick: false,
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                },
                success: function(data) {
                    /* if(!data.status)alert("ho"); */
                    Swal.close();

                    if (!data.status) swal.fire('Gagal menyimpan data', 'error :' + data.message);
                    else {

                        // document.getElementById('rumahadat').reset();
                        // $('#add_modal').modal('hide');
                        (JSON.stringify(data));
                        // alert(data)
                        swal.fire({
                            customClass: 'slow-animation',
                            icon: 'success',
                            showConfirmButton: false,
                            title: 'Berhasil Menambahkan Data',
                            timer: 1500
                        });
                        // location.reload();
                        $('#uploadModal').modal('hide');
                        setTimeout(function() {
                            jquery_datatable.ajax.reload();
                        }, 1500); // Delay for smooth transition
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire('Operation Failed!', errorThrown, 'error');
                },
                complete: function() {
                    console.log('Editing job done');
                }
            });
        });
    });
</script>
<!-- Include jQuery (required by Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>