<script>
    // function changePassword() {
    //     var passwordField = document.getElementById("password");

    //     if (passwordField.type === "password") {
    //         passwordField.type = "text";
    //     } else {
    //         passwordField.type = "password";
    //     }
    // }
    $(document).ready(function() {
        $('#login_form').on('submit', function(event) {
            login(event);
        });
    });

    function login(event) {
        event.preventDefault(); // Prevent the default form submission

        const ttlnamaValue = $('#username').val();
        const ttlfileValue = $('#password').val();


        if (!ttlnamaValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Email Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!ttlfileValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Password Tidak Boleh Kosong',
                timer: 1500
            });
        } else {
            var base_url = "<?php echo base_url(); ?>";
            var url;
            var formData;
            url = "<?php echo site_url('auth/login_process') ?>";

            // window.location = url_base;
            var formData = new FormData($("#login_form")[0]);
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
                    if (!data.status) {
                        swal.fire('Gagal menyimpan data', 'error');
                    }
                    if (data.status == 'Gagal Cari') {
                        swal.fire({
                            customClass: 'slow-animation',
                            icon: 'error',
                            showConfirmButton: false,
                            title: 'Username Dan Password Salah',
                            timer: 1500
                        });
                    } else {
                        // document.getElementById('rumahadat').reset();
                        // $('#add_modal').modal('hide');
                        (JSON.stringify(data));
                        // alert(data)
                        swal.fire({
                            customClass: 'slow-animation',
                            icon: 'success',
                            showConfirmButton: false,
                            title: 'Berhasil Login',
                            timer: 1500
                        });


                        // if (data.status == 'admin') {
                        //     window.location.href = base_url + 'dashboard'; // Assuming 'dashboard' is the path for admin dashboard
                        // } else if (data.status == 'user') {
                        //     window.location.href = base_url + 'SaldoUser'; // Assuming 'SaldoUser' is the path for the user page
                        // }
                        window.location.href = base_url + 'dashboard'; // Assuming 'dashboard' is the path for admin dashboard

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
    }
</script>