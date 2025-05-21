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
    // let selects1 = $('#id_anggota_add').select2({
    //     placeholder: "-- Pilih Anggota --",
    //     allowClear: true,
    //     width: '100%',
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
            url: "<?php echo site_url('Nota_Management/ajax_list') ?> ",
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

    function save_Nota_iuran(event) {
        event.preventDefault(); // Prevent form from submitting and refreshing
        const ttltitleValue = $('#id_koperasi_add').val();
        const ttlthumbnailValue = $('#nominal_kredit_add').val();


        // if (!ttltitleValue) {
        //     swal.fire({
        //         customClass: 'slow-animation',
        //         icon: 'error',
        //         showConfirmButton: false,
        //         title: 'Kolom Anggota Tidak Boleh Kosong',
        //         timer: 1500
        //     });
        // } else
        if (!ttlthumbnailValue) {
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
                    url = "<?php echo site_url('Nota_Management/save_iuran') ?>";

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
                                    title: 'Berhasil Menambahkan Nota Iuran',
                                    timer: 1500
                                });
                                // location.reload();
                                setTimeout(function() {
                                    console.log('Redirecting to Nota Anggota...');
                                    // location.href = '<?= base_url('Anggota/detail/') ?>' + ttltitleValue;
                                    location.href = '<?= base_url('dashboard/') ?>';
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


    function get_detail_koperasi() {
        // var selectedOption = $("#id_koperasi_add option:selected");
        const ttltitleValue = $('#id_koperasi_add').val();

        // if (selectedOption.val()) {
        var url;
        var formData;
        url = "<?php echo site_url('Nota_Management/cari_detail_koperasi/') ?>" + ttltitleValue;

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
                    var rekening = Number(data.saldo_rekening).toLocaleString("id-ID");
                    var iuran = Number(data.saldo_iuran).toLocaleString("id-ID");

                    $("#nominal_rekening_awal").val(rekening);
                    $("#nominal_rekening_setelah").val(iuran);
                    // $("#nominal_kredit_add").val(usageKredit);
                    // $("#nominal_kredit_value").val(usageKredit);
                    cek_nominal();
                    toggleNominalKredit();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                swal.fire('Operation Failed!', errorThrown, 'error');
            },
            complete: function() {
                console.log('Editing job done');
            }
        });

        // $("#detail_user").show();
        // } else {
        //     $("#detail_user").hide();
        // }
    }

    function toggleNominalKredit() {
        console.log('cek anggota');

        const anggotaSelect = document.getElementById('id_koperasi_add');
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
    //     // toggleNominalKredit();

    //     get_detail_koperasi();
    //     toggleNominalKredit();
    // });
    $(document).ready(function() {
        get_detail_koperasi();
        toggleNominalKredit();
    });

    function cek_nominal() {
        console.log('lagi itung');
        const nominal_kredit_add = Number($('#nominal_kredit_add').val()) || 0;
        const detail_usage_kredit = Number($('#nominal_rekening_awal').val().replace(/\./g, '')) || 0;
        const detail_kredit_limit = Number($('#nominal_rekening_setelah').val().replace(/\./g, '')) || 0;
        // const detail_usage_kredit = Number($('#detail_rekening').text().replace(/\./g, '')) || 0;
        // const detail_kredit_limit = Number($('#detail_iuran').text().replace(/\./g, '')) || 0;

        const nominalInput = document.getElementById('nominal_kredit_add');

        if (detail_usage_kredit == 0) {
            nominalInput.disabled = false;
            nominalInput.removeAttribute('max');
        } else {
            nominalInput.disabled = false;
            nominalInput.setAttribute('max', detail_usage_kredit);

            // Optionally: prevent entering a value beyond the limit
            if (nominal_kredit_add > detail_usage_kredit) {
                nominalInput.value = detail_usage_kredit;
            }

            console.log('usage_kredit :' + detail_usage_kredit);
            console.log('kredit_limit :' + detail_kredit_limit);
            // const usage_now = detail_usage_kredit + nominal_kredit_add;

            if (nominal_kredit_add >= detail_usage_kredit) {
                $("#nominal_rekening_awal").val(detail_usage_kredit.toLocaleString("id-ID"));
                $("#nominal_rekening_setelah").val('0');
            } else {
                const rekening_now = detail_usage_kredit - nominal_kredit_add;

                $("#nominal_rekening_awal").val(detail_usage_kredit.toLocaleString("id-ID"));
                $("#nominal_rekening_setelah").val(rekening_now.toLocaleString("id-ID"));
            }
        }
    }


    function cek_nominal_pembayaran() {
        console.log('lagi itung');
        const nominal_kredit_add = Number($('#nominal_kredit_add').val().replace(/\./g, '')) || 0;
        const detail_usage_kredit = Number($('#nominal_rekening_awal').text().replace(/\./g, '')) || 0;
        const detail_kredit_limit = Number($('#nominal_rekening_setelah').text().replace(/\./g, '')) || 0;

        console.log('usage_kredit :' + detail_usage_kredit);
        console.log('kredit_limit :' + detail_kredit_limit);
        const usage_now = detail_usage_kredit - nominal_kredit_add;

        $("#nominal_rekening_setelah").val(usage_now.toLocaleString("id-ID"));

    }

    function save_Nota_pembayaran(event) {
        event.preventDefault(); // Prevent form from submitting and refreshing
        const ttltitleValue = $('#id_anggota_add').val();
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
                    url = "<?php echo site_url('Nota_Management/save_pembayaran') ?>";

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
                                    location.href = '<?= base_url('Anggota/detail_pembayaran/') ?>' + ttltitleValue;
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
</script>
<!-- Include jQuery (required by Summernote) -->
<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> -->

<!-- Include Summernote CSS and JS -->
<link href="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/summernote/dist/summernote-lite.min.js"></script>