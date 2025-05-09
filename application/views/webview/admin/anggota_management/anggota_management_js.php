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




<script>
    $(document).ready(function() {
        function togglePuskopkarField_edit() {
            if ($('#kasir_edit').val() == '2') {
                $('#puskopkar-field-edit').show();
            } else {
                $('#puskopkar-field-edit').hide();
            }
        }

        function togglePuskopkarField_add() {
            if ($('#kasir_add').val() == '2') {
                $('#puskopkar-field-add').show();
            } else {
                $('#puskopkar-field-add').hide();
            }
        }

        // Run on page load
        togglePuskopkarField_edit();
        togglePuskopkarField_add();

        // Run when dropdown changes
        $('#kasir_edit').change(function() {
            togglePuskopkarField_edit();
        });
        $('#kasir_add').change(function() {
            togglePuskopkarField_add();
        });


    });

    document.addEventListener("DOMContentLoaded", function() {
        // Elements for both adding and editing roles
        const kasirAddSelect = document.getElementById("kasir_add"); // ID for adding
        const kasirEditSelect = document.getElementById("kasir_edit"); // ID for editing
        const kasirCheckbox = document.getElementById("kasir_add"); // checkbox

        const koperasiFieldAdd = document.getElementById("koperasi-field-add");
        const tokoFieldAdd = document.getElementById("toko-field-add");
        const koperasiFieldEdit = document.getElementById("koperasi-field-edit");
        const tokoFieldEdit = document.getElementById("toko-field-edit");

        const div = document.getElementById("id_toko_koperasi_div");
        const toko = document.getElementById("title_toko");
        const koperasi = document.getElementById("title_koperasi");

        // Function to toggle fields based on the selected role
        <?php
        if ($this->session->userdata('role') == 'Admin') {
        ?>

            function toggleFields(roleSelect, koperasiField, tokoField) {
                koperasiField.style.display = "none";
                tokoField.style.display = "none";
                div.style.display = "none";
                toko.style.display = "none";
                koperasi.style.display = "none";

                const role = parseInt(roleSelect.value);

                if (role === 2 || role === 5 || role === 4) {
                    koperasi.style.display = "block";
                    koperasiField.style.display = "block";
                    div.style.display = "block";
                } else if (role === 3) {
                    toko.style.display = "block";
                    tokoField.style.display = "block";
                    div.style.display = "block";
                }
            }

            // Event listener for adding role
            if (kasirAddSelect) {
                kasirAddSelect.addEventListener("change", function() {
                    toggleFields(kasirAddSelect, koperasiFieldAdd, tokoFieldAdd);
                });
                // Initial call to set the fields on page load for adding
                toggleFields(kasirAddSelect, koperasiFieldAdd, tokoFieldAdd);
            }

            // Event listener for editing role
            if (kasirEditSelect) {
                kasirEditSelect.addEventListener("change", function() {
                    toggleFields(kasirEditSelect, koperasiFieldEdit, tokoFieldEdit);
                });
                // Initial call to set the fields on page load for editing
                toggleFields(kasirEditSelect, koperasiFieldEdit, tokoFieldEdit);
            }
        <?php
        }
        ?>

        function toggleFieldsByCheckbox() {
            if (kasirCheckbox.checked) {
                koperasiFieldAdd.style.display = "none";
                tokoFieldAdd.style.display = "block";
                koperasi.style.display = "none";
                toko.style.display = "block";
            } else {
                koperasiFieldAdd.style.display = "block";
                tokoFieldAdd.style.display = "none";
                koperasi.style.display = "block";
                toko.style.display = "none";
            }
        }



        if (kasirCheckbox) {
            kasirCheckbox.addEventListener("change", toggleFieldsByCheckbox);
            toggleFieldsByCheckbox(); // Panggil saat halaman pertama kali load
        }
    });

    // document.addEventListener("DOMContentLoaded", function() {
    //     const roleSelect = document.getElementById("kasir_add");
    //     const koperasiField = document.getElementById("koperasi-field-add");
    //     const tokoField = document.getElementById("toko-field-add");
    //     const div = document.getElementById("id_toko_koperasi_div");
    //     const toko = document.getElementById("title_toko");
    //     const koperasi = document.getElementById("title_koperasi");
    //     roleSelect.addEventListener("change", function() {
    //         const role = parseInt(this.value);

    //         koperasiField.style.display = "none";
    //         tokoField.style.display = "none";
    //         div.style.display = "none";
    //         toko.style.display = "none";
    //         koperasi.style.display = "none";

    //         if (role === 2 || role === 5) {
    //             koperasi.style.display = "block";
    //             koperasiField.style.display = "block";
    //             div.style.display = "block";

    //         } else if (role === 3 || role === 4) {
    //             toko.style.display = "block";
    //             tokoField.style.display = "block";
    //             div.style.display = "block";

    //         } else {
    //             koperasiField.style.display = "none";
    //             tokoField.style.display = "none";
    //             div.style.display = "none";
    //         }
    //     });
    // });

    // document.addEventListener("DOMContentLoaded", function() {
    //     const roleSelect = document.getElementById("kasir_edit");
    //     const koperasiField = document.getElementById("koperasi-field-edit");
    //     const tokoField = document.getElementById("toko-field-edit");
    //     const div = document.getElementById("id_toko_koperasi_div");
    //     const toko = document.getElementById("title_toko");
    //     const koperasi = document.getElementById("title_koperasi");
    //     roleSelect.addEventListener("change", function() {
    //         const role = parseInt(this.value);

    //         koperasiField.style.display = "none";
    //         tokoField.style.display = "none";

    //         if (role === 2 || role === 5) {
    //             koperasi.style.display = "block";
    //             koperasiField.style.display = "block";
    //             div.style.display = "block";

    //         } else if (role === 3 || role === 4) {
    //             toko.style.display = "block";
    //             tokoField.style.display = "block";
    //             div.style.display = "block";

    //         } else {
    //             koperasiField.style.display = "none";
    //             tokoField.style.display = "none";
    //             div.style.display = "none";
    //         }
    //     });
    // });

    // let selects1 = $('#id_toko_add').select2({
    //     placeholder: "-- Pilih Toko Koperasi --",
    //     allowClear: true,
    //     width: '100%',
    // });
    // let selects2 = $('#id_toko_edit').select2({
    //     placeholder: "-- Pilih Toko Koperasi --",
    //     allowClear: true,
    //     width: '100%',
    // });

    function formatNumber(input) {
        let value = input.value.replace(/\D/g, ''); // Remove all non-numeric characters
        if (value !== "") {
            input.value = new Intl.NumberFormat('id-ID').format(value); // Format with thousands separator
        }
    }

    function removeFormat(input) {
        input.value = input.value.replace(/\D/g, ''); // Remove formatting (keep only numbers)
    }

    function validateAndFormat(input) {
        let value = input.value.replace(/\D/g, ''); // Remove non-numeric characters
        if (value.length > 15) { // Prevent excessive input (adjust as needed)
            value = value.substring(0, 15);
        }
        input.value = value; // Update input value while typing
    }



    let jquery_datatable = $("#table_1").DataTable({
        responsive: true,
        processing: true, //Feature control the processing indicator.
        serverSide: true, //Feature control DataTables' server-side processing mode.
        order: [], //Initial no order.
        iDisplayLength: 10,

        // Load data for the table's content from an Ajax source
        ajax: {
            url: "<?php echo site_url('Anggota_Management/ajax_list/' . $this->uri->segment('3')) ?> ",
            type: "POST",
            data: function(data) {}
        },
        columnDefs: [{
            targets: [11, 12], // The 8th column (0-indexed)
            orderable: false // Disable sorting
        }]
    })

    function reset_Anggota() {
        document.getElementById('add_Anggota').reset(); // Reset the form
    }

    function save_Anggota() {
        const nomor_anggota_add = $('#nomor_anggota_add').val();
        const nama_add = $('#nama_add').val();
        const tempat_lahir_add = $('#tempat_lahir_add').val();
        const tanggal_lahir_add = $('#tanggal_lahir_add').val();
        const no_telp_add = $('#no_telp_add').val();
        const username_add = $('#username_add').val();
        const password_add = $('#password_add').val();
        const kredit_limit_add = $('#kredit_limit_add').val();
        const id_koperasi_add = $('#password_add').val();


        if (!nomor_anggota_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Nomor Anggota Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
        } else if (!nama_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Nama Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
        } else if (!tempat_lahir_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Tempat Lahir Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
        } else if (!tanggal_lahir_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Tanggal Lahir Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
        } else if (!no_telp_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Nomor Telepon Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
        } else if (!username_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Username Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
        } else if (!password_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Password Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
        } else if (!kredit_limit_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Kredit Limit Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
        } else if (!id_koperasi_add) {
            Swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom ID Koperasi Tidak Boleh Kosong',
                timer: 1500
            });
            return false;
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
                title: 'Ingin Menambahkan Data Anggota?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Ya, Tambahkan',
                cancelButtonText: 'Tidak',
                reverseButtons: true
            }).then((result) => {

                if (result.isConfirmed) {

                    var url;
                    var formData;
                    url = "<?php echo site_url('Anggota_Management/save') ?>";

                    // window.location = url_base;
                    var formData = new FormData($("#add_Anggota")[0]);
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
                                    title: 'Berhasil Menambahkan Anggota',
                                    timer: 1500
                                });
                                // location.reload();
                                setTimeout(function() {
                                    console.log('Redirecting to Anggota_Management...');
                                    location.href = '<?= base_url('Anggota_Management') ?>';
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

    function update_Anggota() {
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
            title: 'Ingin Mengubah Data Anggota?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Ubah',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                var url;
                var formData;
                url = "<?php echo site_url('Anggota_Management/proses_update') ?>";

                // window.location = url_base;
                var formData = new FormData($("#update_Anggota")[0]);
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
                                title: 'Berhasil Mengubah Anggota',
                                timer: 1500
                            });
                            setTimeout(function() {
                                console.log('Redirecting to Anggota_Management...');
                                location.href = '<?= base_url('Anggota_Management') ?>';
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
                    url: "<?php echo site_url('Anggota_Management/delete') ?>",
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
<script>

</script>