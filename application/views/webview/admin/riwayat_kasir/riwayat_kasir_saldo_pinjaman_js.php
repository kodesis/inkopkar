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
<script>
    $(document).ready(function() {
        // 1. Intercept the form submission using the correct ID
        $('#deleteDataPinjaman').on('submit', async function(e) {
            // Prevent the default form submission (which would cause a page reload)
            e.preventDefault();

            // Optional: Get the action URL. You must define where to send the data.
            // Replace 'your_delete_endpoint.php' with the actual server-side URL.
            var actionUrl = '<?php echo base_url("riwayat_kasir/hapus_data_pinjaman_by_month"); ?>';

            // 2. Collect the form data (specifically the month/year input)
            var formData = $(this).serialize();

            // Optional: Show a loading state
            var $submitButton = $(this).find('button[type="submit"]');
            const result = await Swal.fire({
                title: 'Anda Yakin?',
                text: "Anda akan menghapus semua data pinjaman untuk bulan yang dipilih. Tindakan ini tidak dapat dibatalkan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545', // Red color for delete
                cancelButtonColor: '#6c757d', // Gray color for cancel
                confirmButtonText: 'Ya, Hapus Sekarang!',
                cancelButtonText: 'Batal'
            });

            // Check if the user clicked the confirmation button
            if (result.isConfirmed) {

                // --- STEP 2: START LOADING & CLOSE MODAL (ONLY IF CONFIRMED) ---
                $submitButton.html('<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menghapus...');
                $submitButton.prop('disabled', true);

                // Close the form modal to focus on the SweetAlert notification later
                $('#deleteModal').modal('hide');

                // --- STEP 3: EXECUTE AJAX CALL ---
                $.ajax({
                    type: 'POST',
                    url: actionUrl,
                    data: formData,
                    dataType: 'json',

                    success: function(response) {
                        console.log("Success:", response);

                        if (response.status === 'success') {
                            // SUCCESS NOTIFICATION using SweetAlert2
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil Dihapus!',
                                text: response.message, // Use the detailed message from the CI3 Controller
                                confirmButtonText: 'OK'
                            }).then(
                                jquery_datatable.ajax.reload()
                            );

                            // Optional: Call a function to reload your data table here (e.g., reloadDataTable())
                        } else {
                            // SERVER-SIDE ERROR NOTIFICATION (e.g., validation failed or no data found)
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal Menghapus Data',
                                text: response.message,
                                confirmButtonText: 'Tutup'
                            });
                        }
                    },

                    error: function(xhr, status, error) {
                        console.error("Error:", xhr.responseText);
                        // AJAX FAILURE NOTIFICATION (e.g., 404, 500 error, network issue)
                        Swal.fire({
                            icon: 'error',
                            title: 'Kesalahan Sistem!',
                            text: 'Terjadi kesalahan jaringan atau server. Mohon coba lagi.',
                            confirmButtonText: 'Tutup'
                        });
                    },

                    complete: function() {
                        // Reset button state regardless of success or failure
                        $submitButton.text('Hapus');
                        $submitButton.prop('disabled', false);
                    }
                });
            }
        });
    });
</script>