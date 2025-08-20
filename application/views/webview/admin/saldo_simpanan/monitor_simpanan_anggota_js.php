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
    $(document).ready(function() {
        function togglePuskopkarField_edit() {
            if ($('#role_edit').val() == '2') {
                $('#puskopkar-field-edit').show();
            } else {
                $('#puskopkar-field-edit').hide();
            }
        }

        function togglePuskopkarField_add() {
            if ($('#role_add').val() == '2') {
                $('#puskopkar-field-add').show();
            } else {
                $('#puskopkar-field-add').hide();
            }
        }

        // Run on page load
        togglePuskopkarField_edit();
        togglePuskopkarField_add();

        // Run when dropdown changes
        $('#role_edit').change(function() {
            togglePuskopkarField_edit();
        });
        $('#role_add').change(function() {
            togglePuskopkarField_add();
        });


    });

    document.addEventListener("DOMContentLoaded", function() {
        // Elements for both adding and editing roles
        const kasirAddSelect = document.getElementById("role_add"); // ID for adding
        const kasirEditSelect = document.getElementById("role_edit"); // ID for editing
        const kasirCheckbox = document.getElementById("role_add"); // checkbox

        const koperasiFieldAdd = document.getElementById("koperasi-field-add"); // The div wrapper for Koperasi
        const KoperasiInputFieldAdd = document.getElementById("id_koperasi_add"); // The Koperasi select element itself
        const tokoFieldAdd = document.getElementById("toko-field-add"); // The div wrapper for Toko
        const tokoInputFieldAdd = document.getElementById("id_toko_add"); // The Toko select element itself

        const koperasiFielEdit = document.getElementById("koperasi-field-edit"); // The div wrapper for Koperasi
        const KoperasiInputFieldEdit = document.getElementById("id_koperasi_add");
        const tokoFieldEdit = document.getElementById("toko-field-edit");
        const tokoInputFieldEdit = document.getElementById("id_toko_edit");

        const div = document.getElementById("id_toko_koperasi_div");
        const toko = document.getElementById("title_toko");
        const koperasi = document.getElementById("title_koperasi");

        // 2. Get references to the container div and label for the Toko field
        const tokoFieldContainerAdd = document.getElementById('toko-field-add'); // The div wrapping the select
        const tokoLabelAdd = document.getElementById('title_toko'); // The label for the Toko field

        const tokoLabel = document.getElementById("title_toko");
        const koperasiLabel = document.getElementById("title_koperasi"); // Assuming you use this elsewhere
        const BASE_URL = '<?php echo base_url(); ?>';


        //  --- Kelurahan Field Setup ---
        const kelurahanSelectElement = document.getElementById('kelurahan_add');
        let choicesKelurahanInstance;

        if (kelurahanSelectElement) {
            try {
                choicesKelurahanInstance = new Choices(kelurahanSelectElement, {
                    searchEnabled: true,
                    itemSelectText: '',
                    placeholder: true,
                    placeholderValue: '-- Ketik untuk mencari Kelurahan --', // Custom placeholder
                    removeItemButton: true, // Allow user to clear selection
                    noResultsText: 'Tidak ada hasil yang ditemukan',
                    noChoicesText: 'Ketik untuk mencari Kelurahan',
                    // This is crucial for dynamic loading. Set to false to disable default fetching.
                    shouldSort: false, // Don't sort if you control order from backend
                });

                // Make the initial fetch (e.g., load a few common ones or an empty list)
                // You might want to fetch an initial set of options or none at all,
                // depending on if you want results to appear immediately or only after typing.
                fetchKelurahanData(''); // Fetch an initial empty set or common ones if you wish

                // Add an event listener for search input
                choicesKelurahanInstance.passedElement.element.addEventListener('search', function(event) {
                    const searchTerm = event.detail.value;
                    console.log("Searching for Kelurahan:", searchTerm);
                    fetchKelurahanData(searchTerm);
                }, false);

            } catch (e) {
                console.error("Error initializing Choices.js for kelurahan_add:", e);
            }
        } else {
            console.warn("HTML element with ID 'kelurahan_add' not found. Cannot initialize Choices.js.");
        }

        // Function to fetch Kelurahan data from API
        function fetchKelurahanData(searchTerm) {
            // Construct the URL with the search term
            const url = `${BASE_URL}anggota_management/getKelurahanData?search=${encodeURIComponent(searchTerm)}`;

            fetch(url)
                .then(response => {
                    if (!response.ok) {
                        throw new Error(`HTTP error! Status: ${response.status}`);
                    }
                    return response.json();
                })
                .then(data => {
                    console.log("Fetched Kelurahan data:", data);
                    if (choicesKelurahanInstance) {
                        // Set new choices, replacing existing ones
                        choicesKelurahanInstance.setChoices(
                            data,
                            'value', // The key in your data objects for the option's value
                            'label', // The key in your data objects for the option's display text
                            true // True to remove existing choices
                        );
                    }
                })
                .catch(error => {
                    console.error('Error fetching Kelurahan data:', error);
                    if (choicesKelurahanInstance) {
                        choicesKelurahanInstance.setChoices([], 'value', 'label', true); // Clear options on error
                    }
                });
        }

        let choicesTokoAddInstance; // This variable will hold the Choices.js instance for the ADD form

        // 3. Initialize Choices.js ONLY if the <select> element exists
        if (tokoInputFieldAdd) {
            try {
                choicesTokoAddInstance = new Choices(tokoInputFieldAdd, {
                    searchEnabled: true,
                    itemSelectText: '',
                    placeholder: true,
                    placeholderValue: '-- Pilih Toko Koperasi --',
                    // allowHTML: true // Uncomment if your labels have HTML like ` - `
                });
                console.log("Choices.js initialized successfully for id_toko_add:", choicesTokoAddInstance);
            } catch (e) {
                console.error("Error initializing Choices.js for id_toko_add:", e);
            }
        } else {
            console.warn("HTML element with ID 'id_toko_add' not found. Cannot initialize Choices.js.");
        }

        // --- You also need to initialize Choices.js for your Koperasi select if it uses Choices.js ---
        let choicesKoperasiAddInstance;
        if (KoperasiInputFieldAdd) {
            try {
                choicesKoperasiAddInstance = new Choices(KoperasiInputFieldAdd, {
                    searchEnabled: true,
                    itemSelectText: '',
                    placeholder: true,
                    placeholderValue: '-- Pilih Koperasi --',
                });
                console.log("Choices.js initialized successfully for id_koperasi_add:", choicesKoperasiAddInstance);
            } catch (e) {
                console.error("Error initializing Choices.js for id_koperasi_add:", e);
            }
        }

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

                if (role === 4 || role === 3) {
                    koperasi.style.display = "block";
                    koperasiField.style.display = "block";
                    div.style.display = "block";
                    // } else if (role === 3) {
                    // toko.style.display = "block";
                    // tokoField.style.display = "block";
                    // div.style.display = "block";
                    // } else if (role === 2) {
                    //     puskopkar.style.display = "block";
                    //     puskopkar.style.display = "block";
                    //     div.style.display = "block";
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


            function toggleFieldsKoperasi(koperasiField, tokoFieldContainer, tokoChoicesInstance) {
                // The previous critical check will now likely pass:
                // if (!tokoChoicesInstance || typeof tokoChoicesInstance.setChoices !== 'function') { ... }

                const selectedKoperasiId = koperasiField.value;
                // Assuming BASE_URL is defined globally in a script tag before this script

                // Get the label element (no change here, it was already correct)
                const tokoLabel = document.getElementById('title_toko');

                if (selectedKoperasiId) {
                    fetch(`${BASE_URL}anggota_management/getTokoByKoperasi?id_koperasi=${selectedKoperasiId}`)
                        .then(response => {
                            if (!response.ok) {
                                throw new Error('Network response was not ok');
                            }
                            return response.json();
                        })
                        .then(data => {
                            const choicesData = data.map(toko => ({
                                value: toko.id,
                                label: `${toko.id} - ${toko.nama_toko}`
                            }));

                            tokoChoicesInstance.setChoices(
                                choicesData,
                                'value',
                                'label',
                                true
                            );

                            if (tokoFieldContainer) {
                                tokoFieldContainer.style.display = 'block';
                            }
                            if (tokoLabel) {
                                tokoLabel.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching toko data:', error);
                            tokoChoicesInstance.setChoices([], 'value', 'label', true);
                            if (tokoFieldContainer) {
                                tokoFieldContainer.style.display = 'none';
                            }
                            if (tokoLabel) {
                                tokoLabel.style.display = 'none';
                            }
                        });
                } else {
                    tokoChoicesInstance.setChoices([], 'value', 'label', true);
                    if (tokoFieldContainer) {
                        tokoFieldContainer.style.display = 'none';
                    }
                    if (tokoLabel) {
                        tokoLabel.style.display = 'none';
                    }
                }
            }

            if (KoperasiInputFieldAdd && choicesTokoAddInstance) { // Ensure both elements and Choices instance exist
                KoperasiInputFieldAdd.addEventListener("change", function() {
                    // Pass the correct parameters:
                    // 1. Koperasi select element (KoperasiInputFieldAdd)
                    // 2. Toko field container (tokoFieldAdd) - This is the div
                    // 3. The Choices.js instance for the Toko select (choicesTokoAddInstance)
                    // toggleFieldsKoperasi(KoperasiInputFieldAdd, tokoFieldAdd, choicesTokoAddInstance);
                    const currentRole = parseInt(kasirAddSelect.value);
                    if (currentRole === 3) {
                        console.log("Koperasi changed and current role is 3. Updating Toko options.");
                        toggleFieldsKoperasi(KoperasiInputFieldAdd, tokoFieldAdd, choicesTokoAddInstance);
                    } else {
                        console.log("Koperasi changed, but current role is not 3. Skipping Toko update.");
                    }
                });
                // Initial call
                // toggleFieldsKoperasi(KoperasiInputFieldAdd, tokoFieldAdd, choicesTokoAddInstance);
            } else {
                console.warn("KoperasiInputFieldAdd or choicesTokoAddInstance is not available for dynamic filtering setup.");
            }

            // Event listener for editing role
            if (koperasiInputFieldEdit) {
                koperasiInputFieldEdit.addEventListener("change", function() {
                    toggleFieldsKoperasi(koperasiInputFieldEdit, tokoFieldEdit, tokoInputFieldEdit);
                });
                // Initial call to set the fields on page load for editing
                // toggleFieldsKoperasi(koperasiInputFieldEdit, tokoFieldEdit);
            }

        <?php
        }
        ?>

        function toggleFieldsKoperasi(koperasiField, tokoFieldContainer, tokoChoicesInstance) {
            // The previous critical check will now likely pass:
            // if (!tokoChoicesInstance || typeof tokoChoicesInstance.setChoices !== 'function') { ... }

            const selectedKoperasiId = koperasiField.value;
            // Assuming BASE_URL is defined globally in a script tag before this script

            // Get the label element (no change here, it was already correct)
            const tokoLabel = document.getElementById('title_toko');

            if (selectedKoperasiId) {
                fetch(`${BASE_URL}anggota_management/getTokoByKoperasi?id_koperasi=${selectedKoperasiId}`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        const choicesData = data.map(toko => ({
                            value: toko.id,
                            label: `${toko.id} - ${toko.nama_toko}`
                        }));

                        tokoChoicesInstance.setChoices(
                            choicesData,
                            'value',
                            'label',
                            true
                        );

                        if (tokoFieldContainer) {
                            tokoFieldContainer.style.display = 'block';
                        }
                        if (tokoLabel) {
                            tokoLabel.style.display = 'block';
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching toko data:', error);
                        tokoChoicesInstance.setChoices([], 'value', 'label', true);
                        if (tokoFieldContainer) {
                            tokoFieldContainer.style.display = 'none';
                        }
                        if (tokoLabel) {
                            tokoLabel.style.display = 'none';
                        }
                    });
            } else {
                tokoChoicesInstance.setChoices([], 'value', 'label', true);
                if (tokoFieldContainer) {
                    tokoFieldContainer.style.display = 'none';
                }
                if (tokoLabel) {
                    tokoLabel.style.display = 'none';
                }
            }
        }

        function toggleFieldsByCheckbox() {
            if (kasirCheckbox.checked) {
                tokoFieldAdd.style.display = "block";
                toko.style.display = "block";
            } else {
                tokoFieldAdd.style.display = "none";
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
        processing: true,
        serverSide: true,
        order: [],
        iDisplayLength: 10,
        ajax: {
            url: "<?php echo site_url('Saldo_Simpanan/ajax_list_monitor_simpanan_anggota/' . $this->uri->segment(3)) ?>",
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
        window.location.href = "<?php echo site_url('Saldo_Simpanan/export_per_anggota/' . $this->uri->segment(3)) ?>";
    });

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

    function onAktif(id) {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Apakah anda ingin Meng-Aktifkan Anggota?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Aktifkan Anggota',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?php echo site_url('Anggota_Management/activate_anggota') ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        // showLoading("Saving data...", "Mohon tunggu");
                    },
                    success: function(data) {
                        if (!data.status) showAlert('Gagal!', data.message.toString().replace(/<[^>]*>/g, ''), 'error');
                        else {
                            swalWithBootstrapButtons.fire(
                                'Berhasil!',
                                'Data berhasil DiAktifkan.',
                                'success'
                            )
                            jquery_datatable.ajax.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swalWithBootstrapButtons.fire(
                            'Gagal',
                            'Data gagal DiAktifkan',
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

    function onNonAktif(id) {

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Apakah anda ingin Meng-Non-Aktifkan Anggota?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Non-Aktifkan Anggota',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                $.ajax({
                    url: "<?php echo site_url('Anggota_Management/non_activate_anggota') ?>",
                    type: "POST",
                    data: {
                        id: id
                    },
                    dataType: "JSON",
                    beforeSend: function() {
                        // showLoading("Saving data...", "Mohon tunggu");
                    },
                    success: function(data) {
                        if (!data.status) showAlert('Gagal!', data.message.toString().replace(/<[^>]*>/g, ''), 'error');
                        else {
                            swalWithBootstrapButtons.fire(
                                'Berhasil!',
                                'Data berhasil DiNon-Aktifkan.',
                                'success'
                            )
                            jquery_datatable.ajax.reload();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        swalWithBootstrapButtons.fire(
                            'Gagal',
                            'Data gagal DiNon-Aktifkan',
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

    $(document).ready(function() {
        $('#upload_excel_form').submit(function(e) {
            e.preventDefault(); // stop normal form submit

            var formData = new FormData(this);

            $.ajax({
                url: "<?php echo site_url('Anggota_Management/process_insert_excel/') ?>",
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