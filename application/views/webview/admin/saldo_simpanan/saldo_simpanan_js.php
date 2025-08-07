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
    const element = document.getElementById('id_anggota_search');

    // Initialize Choices.js and store the instance in a variable.
    const choicesInstance = new Choices(element, {
        searchEnabled: true,
        placeholder: true,
        placeholderValue: '-- Pilih Anggota --',
        // Make sure the dropdown is empty initially if you're loading via AJAX
        allowHTML: true // This might be useful if your labels have HTML
    });

    // Add an event listener to the Choices.js instance for when the user types.
    element.addEventListener('search', (event) => {
        const searchTerm = event.detail.value;

        // Ensure the search term has at least 2 characters to trigger a search
        if (searchTerm.length >= 2) {
            // Use your PHP-generated URL and append the search query
            const url = `<?php echo site_url('Saldo_Simpanan/ajax_search_anggota') ?>?q=${searchTerm}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    return response.json();
                })
                .then(data => {
                    // `data` should be an array of objects like:
                    // [{ value: '1', label: 'John Doe' }, { value: '2', label: 'Jane Smith' }]
                    // The `setChoices` method clears existing options and replaces them with the new data.
                    choicesInstance.setChoices(data, 'value', 'label', true);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                });
        }
    });

    // --- NEW: Add event listener for when an option is selected ---
    element.addEventListener('change', (event) => {
        // The 'event.detail.value' will contain the value of the selected option.
        // You can also get the selected label if needed: event.detail.label
        const selectedAnggotaId = event.detail.value;
        console.log('Selected Anggota ID:', selectedAnggotaId);

        // Call your function here
        toggleNominalKredit(selectedAnggotaId); // Pass the selected ID if toggleNominalKredit needs it
    });
</script>
<script>
    const dateInput1 = document.getElementById('tanggal_jam_add');
    const dateInput2 = document.getElementById('sampai_dengan_add');

    // Create a new date object for today
    const today = new Date();

    // Get the year, month, and day
    const year = today.getFullYear();
    // Months are 0-indexed, so we add 1
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');

    // Format the date as 'YYYY-MM-DD', which is the required format for date inputs
    const formattedDate = `${year}-${month}-${day}`;

    // Set the value of the input field
    dateInput1.value = formattedDate;
    dateInput2.value = formattedDate;

    // let selects1 = $('#id_anggota_add').select2({
    // placeholder: "-- Pilih Anggota --",
    // allowClear: true,
    // width: '100%',
    // });

    function formatNumber(input) {
        let value = input.value.replace(/\./g, ''); // Remove existing dots
        if (!isNaN(value) && value !== "") {
            input.value = new Intl.NumberFormat('id-ID').format(value);
        }
    }

    function removeFormat(input) {
        input.value = input.value.replace(/\./g, ''); // Remove dots when editing
    }

    let jquery_datatable = $("#table_1").DataTable({
        responsive: true,
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        iDisplayLength: 10,

        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('Saldo_Simpanan/ajax_list') ?> ",
            type: "POST",
            data: function(data) {}
        },
        columnDefs: [{
            targets: 4, // The 8th column (0-indexed)
            orderable: false // Disable sorting
        }]
    })



    function reset_Nota() {
        document.getElementById('add_Nota').reset(); // Reset the form
    }

    function save_Nota(event) {
        event.preventDefault(); // Prevent form from submitting and refreshing
        const ttltitleValue = $('#id_anggota_search').val();
        const ttlthumbnailValue = $('#nominal_kredit_add').val();


        if (!ttltitleValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Anggota Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!ttlthumbnailValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Nominal Tidak Boleh Kosong',
                timer: 1500
            });
        } else {
            const swalWithBootstrapButtons = Swal.mixin({
                customClass: {
                    InputEvent: 'form-control',
                    confirmButton: 'btn btn-success',
                    cancelButton: 'btn btn-danger'
                },
                buttonsStyling: false
            })

            swalWithBootstrapButtons.fire({
                title: 'Ingin Menambahkan Data Nota?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    var url;
                    var formData;
                    url = "<?php echo site_url('Saldo_Simpanan/save') ?>";

                    // window.location = url_base;
                    var formData = new FormData($("#add_Nota")[0]);
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: formData,
                        contentType: false,
                        processData: false,
                        dataType: "JSON",
                        beforeSend: function() {
                            swal.fire({
                                icon: 'info',
                                timer: 3000,
                                showConfirmButton: false,
                                title: 'Loading...'

                            });
                        },
                        success: function(data) {
                            /* if(!data.status)alert("ho"); */
                            if (!data.status) swal.fire('Gagal menyimpan data', 'error :' + data.Pesan);
                            else {

                                // document.getElementById('rumahadat').reset();
                                // $('#add_modal').modal('hide');
                                (JSON.stringify(data));
                                // alert(data)
                                swal.fire({
                                    customClass: 'slow-animation',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    title: 'Berhasil Menambahkan Nota',
                                    timer: 1500
                                });
                                // location.reload();
                                setTimeout(function() {
                                    console.log('Redirecting to Nota Anggota...');
                                    // location.href = '<?= base_url('Anggota/detail/') ?>' + ttltitleValue;
                                    location.href = '<?= base_url('Riwayat_Kasir/detail_saldo_simpanan/') ?>';
                                }, 3000); // Delay for smooth transition
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            swal.fire('Operation Failed!', errorThrown, 'error');
                        },
                        complete: function() {
                            console.log('Editing job done');
                        }
                    });


                }

            })
        }
    }


    $(document).ready(function() {
        $("#add_Nota").on("submit", function(event) {
            event.preventDefault(); // Prevent the form from actually submitting
            verifikasi_Nota(event); // Call your function manually
        });
    });

    function get_detail_user() {
        var selectedOption = $("#id_anggota_add option:selected");
        const ttltitleValue = $('#id_anggota_add').val();

        if (selectedOption.val()) {
            var url;
            var formData;
            url = "<?php echo site_url('Saldo_Simpanan/cari_detail_user/') ?>" + ttltitleValue;

            // window.location = url_base;
            // var formData = new FormData($("#add_Nota")[0]);
            $.ajax({
                url: url,
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                dataType: "JSON",
                beforeSend: function() {
                    swal.fire({
                        icon: 'info',
                        timer: 1500,
                        showConfirmButton: false,
                        title: 'Loading...'

                    });
                },
                success: function(data) {
                    /* if(!data.status)alert("ho"); */
                    if (!data.status) console.log('Verifikasi Gagal', 'error : ' + data.Pesan);
                    else {
                        $("#detail_nama").text(data.nama);
                        $("#detail_nomor_anggota").text(data.nomor_anggota);
                        // $("#detail_kredit_limit").text(data.kredit_limit);
                        // $("#detail_usage_kredit").text(data.usage_kredit);
                        // Ensure the values are numbers before formatting
                        // var kreditLimit = Number(data.kredit_limit).toLocaleString("id-ID");
                        // var usageKredit = Number(data.usage_kredit).toLocaleString("id-ID");

                        // $("#detail_kredit_limit").text(kreditLimit);
                        // $("#detail_usage_kredit").text(usageKredit);

                        var kreditLimit = Number(data.saldo_simpanan).toLocaleString("id-ID");
                        $("#detail_kredit_limit").text(kreditLimit);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    swal.fire('Operation Failed!', errorThrown, 'error');
                },
                complete: function() {
                    console.log('Editing job done');
                }
            });

            $("#detail_user").show();
        } else {
            $("#detail_user").hide();
        }
    }

    function toggleNominalKredit() {
        console.log('cek anggota');

        const anggotaSelect = document.getElementById('id_anggota_search');
        const nominalInput = document.getElementById('nominal_kredit_add');

        if (anggotaSelect.value) {
            // If an option is selected, enable the input
            console.log('Idupin Nominal');
            nominalInput.disabled = false;
        } else {
            // If no option is selected, disable the input
            console.log('Matiin Nominal');
            nominalInput.disabled = true;
        }
    }

    // Call the function on page load to set the initial state
    // document.addEventListener('DOMContentLoaded', function() {
    // toggleNominalKredit();
    // });

    function cek_nominal() {
        console.log('lagi itung');
        const nominal_kredit_add = Number($('#nominal_kredit_add').val()) || 0;
        const detail_usage_kredit = Number($('#detail_usage_kredit').text().replace(/\./g, '')) || 0;
        const detail_kredit_limit = Number($('#detail_kredit_limit').text().replace(/\./g, '')) || 0;

        console.log('usage_kredit :' + detail_usage_kredit);
        console.log('kredit_limit :' + detail_kredit_limit);
        const usage_now = detail_usage_kredit + nominal_kredit_add;

        if (usage_now >= detail_kredit_limit) {
            const cash = usage_now - detail_kredit_limit;
            const credit = nominal_kredit_add - cash;
            $("#nominal_cash_sekarang").val(cash.toLocaleString("id-ID"));
            $("#nominal_kredit_sekarang").val(credit.toLocaleString("id-ID"));
        } else {
            $("#nominal_cash_sekarang").val("0");
            $("#nominal_kredit_sekarang").val(nominal_kredit_add.toLocaleString("id-ID"));
        }
    }

    function cek_nominal_pembayaran() {
        console.log('lagi itung');
        const nominal_kredit_add = Number($('#nominal_kredit_add').val().replace(/\./g, '')) || 0;
        const detail_usage_kredit = Number($('#detail_usage_kredit').text().replace(/\./g, '')) || 0;
        const detail_kredit_limit = Number($('#detail_kredit_limit').text().replace(/\./g, '')) || 0;

        console.log('usage_kredit :' + detail_usage_kredit);
        console.log('kredit_limit :' + detail_kredit_limit);
        const usage_now = detail_usage_kredit - nominal_kredit_add;

        $("#nominal_kredit_sekarang").val(usage_now.toLocaleString("id-ID"));

    }



    $(document).ready(function() {
        $('#upload_excel_form').submit(function(e) {
            e.preventDefault(); // stop normal form submit

            var formData = new FormData(this);

            $.ajax({
                url: "<?php echo site_url('Saldo_Simpanan/process_insert_excel/') ?>",
                type: 'POST',
                data: formData,
                contentType: false, // important for file upload
                processData: false, // important for file upload
                beforeSend: function() {
                    Swal.fire({
                        title: 'Uploading...',
                        // text: 'Please wait while your file is being processed.',
                        text: 'Mohon tunggu selagi berkas Anda sedang diproses.',
                        allowOutsideClick: false, // Prevent closing by clicking outside
                        allowEscapeKey: false, // Prevent closing by pressing Esc key
                        didOpen: () => {
                            Swal.showLoading(); // Show the loading spinner
                        }
                    });
                },
                success: function(response) {
                    // Do something when upload success
                    Swal.close();
                    console.log(response);
                    if (typeof response === 'string') {
                        response = JSON.parse(response);
                    }

                    console.log(response);

                    if (!response.status) {
                        console.log('Upload Gagal', 'error : ' + response.message);
                        Swal.fire({
                            customClass: 'slow-animation',
                            icon: 'error',
                            showConfirmButton: false,
                            title: 'Upload Gagal',
                            text: response.message,
                            timer: 1500
                        });
                    } else {
                        $('#uploadModal').modal('hide');
                        Swal.fire({
                            customClass: 'slow-animation',
                            icon: 'success',
                            showConfirmButton: false,
                            title: 'Berhasil Menambahkan Saldo Pinjaman',
                            timer: 1500
                        });
                    }
                },
                error: function(xhr, status, error) {
                    // Handle error
                    console.error(error);
                    alert('Upload failed. Please try again.');
                }
            });
        });
    });
</script>
<!-- Include jQuery (required by Summernote) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Include Summernote CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.js"></script>