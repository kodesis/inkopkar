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
    document.addEventListener('DOMContentLoaded', (event) => {
        const dateInput = document.getElementById('tanggal_data_add');
        const tanggal_upload = document.getElementById('tanggal_upload');
        const today = new Date();

        // Format the date to YYYY-MM-DD
        const year = today.getFullYear();
        const month = String(today.getMonth() + 1).padStart(2, '0'); // Month is 0-indexed
        const day = String(today.getDate()).padStart(2, '0');

        const formattedDate = `${year}-${month}-${day}`;

        // Set the value of the input field
        dateInput.value = formattedDate;
        tanggal_upload.value = formattedDate;
    });


    function add_saldo(event) {
        event.preventDefault(); // Prevent the default form submission

        const tglsaldo_simpanan_akhir = $('#saldo_simpanan_akhir_add').val();
        const tglsaldo_pinjaman_akhir = $('#saldo_pinjaman_akhir_add').val();
        const tglDataValue = $('#tanggal_data_add').val();

        if (!tglsaldo_simpanan_akhir) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Saldo Simpanan Akhir Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!tglsaldo_pinjaman_akhir) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Saldo Pinjaman Akhir Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!tglDataValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Tanggal Data Tidak Boleh Kosong',
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
                title: 'Ingin Menambahkan Data Saldo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    var url;
                    var formData;
                    url = "<?php echo site_url('Saldo/save') ?>";

                    // window.location = url_base;
                    var formData = new FormData($("#add_saldo_form")[0]);
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
                            if (!data.status) swal.fire('Gagal menyimpan data', 'error');
                            else {
                                if (data.status == "Peserta Tidak ada") {
                                    swal.fire({
                                        customClass: 'slow-animation',
                                        icon: 'warning',
                                        showConfirmButton: false,
                                        title: 'Peserta Tidak ada',
                                        // text: 'Kode Peserta : ' + data.peserta,
                                        timer: 1500
                                    });
                                } else if (data.status == "Menimpa") {
                                    // document.getElementById('rumahadat').reset();
                                    // $('#add_modal').modal('hide');
                                    (JSON.stringify(data));
                                    // alert(data)
                                    swal.fire({
                                        customClass: 'slow-animation',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        title: 'Berhasil Menimpa Data Saldo',
                                        // text: 'UID : ' + data.id,
                                        timer: 1500
                                    });
                                    // document.getElementById('add_user').reset(); // Reset the form
                                    jquery_datatable.ajax.reload();
                                } else {
                                    {
                                        // document.getElementById('rumahadat').reset();
                                        // $('#add_modal').modal('hide');
                                        (JSON.stringify(data));
                                        // alert(data)
                                        swal.fire({
                                            customClass: 'slow-animation',
                                            icon: 'success',
                                            showConfirmButton: false,
                                            title: 'Berhasil Menambahkan Data Saldo',
                                            timer: 1500
                                        });
                                        document.getElementById('add_saldo_form').reset(); // Reset the form
                                        jquery_datatable.ajax.reload();
                                    }
                                }
                                $('#tambahModal').modal('hide'); // Hide the modal
                                // location.reload();

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

    function onEdit(id) {
        $('#edit_saldo_form')[0].reset(); // reset form on modals
        $.ajax({
            url: "<?php echo site_url('Saldo/ajax_edit/') ?>" + id,
            type: "POST",
            dataType: "JSON",
            success: function(data) {

                JSON.stringify(data.id);
                // alert(JSON.stringify(data));

                $('#id_anggota_edit').val(data.id_anggota);
                $('#id_edit').val(data.id);
                $('#saldo_simpanan_akhir_edit').val(data.saldo_simpanan_akhir);
                $('#saldo_pinjaman_akhir_edit').val(data.saldo_pinjaman_akhir);
                $('#tanggal_data_edit').val(data.tanggal_data);

                $('.dropdown-toggle').dropdown();

                $('#editModal').modal('show'); // show bootstrap modal when complete loaded
                console.log('bisa 2')
            },
            error: function(jqXHR, textStatus, errorThrown) {
                alert('Error get data from ajax');
            }
        });

    }

    function update_saldo(event) {
        event.preventDefault(); // Prevent the default form submission

        const tglsaldo_simpanan_akhir = $('#saldo_simpanan_akhir_edit').val();
        const tglsaldo_pinjaman_akhir = $('#saldo_pinjaman_akhir_edit').val();
        const tglDataValue = $('#tanggal_data_edit').val();

        if (!tglsaldo_simpanan_akhir) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Saldo Simpanan Akhir Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!tglsaldo_pinjaman_akhir) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Saldo Pinjaman Akhir Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!tglDataValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Tanggal Data Tidak Boleh Kosong',
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
                title: 'Ingin Mengubah Data Saldo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Ubah',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    var url;
                    var formData;
                    url = "<?php echo site_url('Saldo/update') ?>";

                    // window.location = url_base;
                    var formData = new FormData($("#edit_saldo_form")[0]);
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
                            if (!data.status) swal.fire('Gagal menyimpan data', 'error');
                            else {
                                // document.getElementById('rumahadat').reset();
                                // $('#add_modal').modal('hide');
                                (JSON.stringify(data));
                                // alert(data)
                                swal.fire({
                                    customClass: 'slow-animation',
                                    icon: 'success',
                                    showConfirmButton: false,
                                    title: 'Berhasil Mengubah Data Saldo',
                                    timer: 1500
                                });
                                document.getElementById('edit_saldo_form').reset(); // Reset the form
                                $('#editModal').modal('hide'); // Hide the modal
                                jquery_datatable.ajax.reload();
                                // location.reload();

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

    function onDelete(id) {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Apakah anda yakin ingin menghapus Data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus Data',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?php echo site_url('Saldo/delete') ?>",
                    type: "POST",
                    data: {
                        id_delete: id
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        // showLoading("Saving data...", "Mohon tunggu");
                    },
                    success: function(data) {
                        if (!data.status) showAlert('Gagal!', data.message.toString().replace(/<[^>]*>/g, ''), 'error');
                        else {
                            swalWithBootstrapButtons.fire(
                                'Terhapus!',
                                'Data berhasil dihapus.',
                                'success'
                            )
                            jquery_datatable.ajax.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swalWithBootstrapButtons.fire(
                            'Gagal',
                            'Data gagal dihapus',
                            'error'
                        )
                    },
                    complete: function() {
                        console.log('published job done');
                    }
                });


            }

        })



    }

    function upload_user(event) {
        event.preventDefault(); // Prevent the default form submission

        const ttltanggalValue = $('#tanggal_upload').val();
        const ttlnamaValue = $('#file').val();


        if (!ttltanggalValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Tanggal Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!ttlnamaValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom File Tidak Boleh Kosong',
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
                title: 'Ingin Menambahkan Data Saldo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    var url;
                    var formData;
                    url = "<?php echo site_url('Saldo/process_insert_excel') ?>";

                    // window.location = url_base;
                    var formData = new FormData($("#upload_saldo_form")[0]);
                    let accumulatedResponse = ""; // Variable to accumulate the response

                    $.ajax({
                        url: url,
                        type: "POST",
                        dataType: "text", // Change to 'text' to handle server-sent events
                        data: formData,
                        contentType: false,
                        processData: false,
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
                                    timer: 3000
                                });
                            } else {
                                if (response.status == "Data Peserta Tidak Ada") {
                                    Swal.fire({
                                        customClass: 'slow-animation',
                                        icon: 'error',
                                        showConfirmButton: false,
                                        title: 'Upload Gagal',
                                        text: "Anggota dengan Nomor Anggota : " + response.nomor_anggota + ", Tidak DI Temukan",
                                        timer: 3000
                                    });
                                } else {
                                    $('#uploadModal').modal('hide');
                                    Swal.fire({
                                        customClass: 'slow-animation',
                                        icon: 'success',
                                        showConfirmButton: false,
                                        title: 'Berhasil Menambahkan Anggota',
                                        timer: 3000
                                    }).then((result) => {
                                        jquery_datatable.ajax.reload()
                                    });
                                }

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

    let jquery_datatable = $("#table_1").DataTable({
        responsive: true,
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        iDisplayLength: 10,

        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('Saldo/ajax_list/') ?>",
            type: "POST",
            data: function(data) {
                // Add month and year filters to the AJAX data
                data.filter_month = $('#filter_month').val();
                data.filter_year = $('#filter_year').val();
            }
        },
        columnDefs: [{
            targets: [-1], // The 8th column (0-indexed)
            orderable: false // Disable sorting
        }]
    });

    // Add an event listener to the "Apply Filter" button
    $('#apply_filter_btn').on('click', function() {
        jquery_datatable.ajax.reload(null, false); // Reload the DataTable, keeping current paging
    });

    // Optional: Reload DataTable when month or year selection changes
    $('#filter_month, #filter_year').on('change', function() {
        // jquery_datatable.ajax.reload(null, false); // Uncomment if you want auto-reload on change
    });
</script>