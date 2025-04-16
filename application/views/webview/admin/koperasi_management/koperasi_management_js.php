<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/table-datatable-jquery.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/app.css">
<link rel="stylesheet" href="<?= base_url('assets/admin') ?>/compiled/css/app-dark.css">

<script src="<?= base_url('assets/admin') ?>/static/js/initTheme.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/jquery/jquery.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= base_url('assets/admin') ?>/extensions/datatables.net-bs5/js/dataTables.bootstrap5.min.js"></script>


<script>
    let jquery_datatable = $("#table_1").DataTable({
        responsive: true,
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        iDisplayLength: 10,

        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('Koperasi_Management/ajax_list') ?> ",
            type: "POST",
            data: function(data) {}
        },
        columnDefs: [{
            targets: 4, // The 8th column (0-indexed)
            orderable: false // Disable sorting
        }]
    })
    document.addEventListener('DOMContentLoaded', function() {
        // Get current date and time
        const now = new Date();

        // Format date as YYYY-MM-DD
        const year = now.getFullYear();
        const month = String(now.getMonth() + 1).padStart(2, '0'); // Months are zero-based
        const day = String(now.getDate()).padStart(2, '0');
        const formattedDate = `${year}-${month}-${day}`;

        // Format time as HH:MM
        const hours = String(now.getHours()).padStart(2, '0');
        const minutes = String(now.getMinutes()).padStart(2, '0');
        const formattedTime = `${hours}:${minutes}`;

        // Set the values of the inputs
        document.getElementById('tanggal_add').value = formattedDate;
        document.getElementById('jam_add').value = formattedTime;
    });

    function reset_Koperasi() {
        document.getElementById('add_Koperasi').reset(); // Reset the form
    }

    function save_Koperasi() {
        const ttltitleValue = $('#nama_koperasi_add').val();
        const ttlthumbnailValue = $('#telp_add').val();
        const ttltanggalValue = $('#alamat_add').val();


        if (!ttltitleValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Nama Koperasi Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!ttltanggalValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Alamat Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!ttlthumbnailValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Nomor Telpon Tidak Boleh Kosong',
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
                title: 'Ingin Menambahkan Data Koperasi?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    var url;
                    var formData;
                    url = "<?php echo site_url('Koperasi_Management/save') ?>";

                    // window.location = url_base;
                    var formData = new FormData($("#add_Koperasi")[0]);
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
                                    title: 'Berhasil Menambahkan Koperasi',
                                    timer: 1500
                                });
                                // location.reload();
                                setTimeout(function() {
                                    console.log('Redirecting to Koperasi_Management...');
                                    location.href = '<?= base_url('Koperasi_Management') ?>';
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


                }

            })
        }
    }

    function update_Koperasi() {
        // const ttlkategoriValue = $('#kategori_edit').val();
        const ttltitleValue = $('#title_edit').val();
        // const ttltextValue = $('#text').val();
        const ttltanggalValue = $('#tanggal_edit').val();
        const ttljamValue = $('#jam_edit').val();


        // if (!ttlkategoriValue) {
        //     swal.fire({
        //         customClass: 'slow-animation',
        //         icon: 'error',
        //         showConfirmButton: false,
        //         title: 'Kolom Kategori Tidak Boleh Kosong',
        //         timer: 1500
        //     });
        // } else
        // if (!ttltitleValue) {
        //     swal.fire({
        //         customClass: 'slow-animation',
        //         icon: 'error',
        //         showConfirmButton: false,
        //         title: 'Kolom Title Tidak Boleh Kosong',
        //         timer: 1500
        //     });
        // } else if (!ttltanggalValue) {
        //     swal.fire({
        //         customClass: 'slow-animation',
        //         icon: 'error',
        //         showConfirmButton: false,
        //         title: 'Kolom Tanggal Tidak Boleh Kosong',
        //         timer: 1500
        //     });
        // } else if (!ttljamValue) {
        //     swal.fire({
        //         customClass: 'slow-animation',
        //         icon: 'error',
        //         showConfirmButton: false,
        //         title: 'Kolom Jam Tidak Boleh Kosong',
        //         timer: 1500
        //     });
        // } else {
        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                InputEvent: 'form-control',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Ingin Mengubah Data Koperasi?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Ubah',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                var url;
                var formData;
                url = "<?php echo site_url('Koperasi_Management/proses_update') ?>";

                // window.location = url_base;
                var formData = new FormData($("#update_Koperasi")[0]);
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
                                title: 'Berhasil Mengubah Koperasi',
                                timer: 1500
                            });
                            setTimeout(function() {
                                console.log('Redirecting to Koperasi_Management...');
                                location.href = '<?= base_url('Koperasi_Management') ?>';
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


            }

        })
        // }
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
                    url: "<?php echo site_url('Koperasi_Management/delete') ?>",
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


    function uploadImage(file, editor, welEditable) {
        const formData = new FormData();
        formData.append("file", file);

        $.ajax({
            url: "<?php echo site_url('Koperasi_Management/upload_summernote') ?>",
            type: "POST",
            data: formData,
            processData: false,
            contentType: false,
            success: function(response) {
                const result = JSON.parse(response);
                console.log(result); // Add this to check the response
                if (result.success) {
                    $("#summernote1").summernote("insertImage", result.url);
                    // $('#summernote1').summernote('editor.insertImage', result.url);
                } else {
                    alert(result.error || "File upload failed.");
                }
            },
            error: function() {
                alert("Error occurred during file upload.");
            },
        });
    }
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