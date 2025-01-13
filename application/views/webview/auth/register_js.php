<script src="https://www.google.com/recaptcha/api.js" async defer></script>
<script>
    function register() {
        const ttlnamaValue = $('#nama').val();
        const ttlemailValue = $('#email').val();
        const ttlpassword1Value = $('#password1').val();
        const ttlpassword2Value = $('#password2').val();
        const isTermsChecked = $('#termandconds').is(':checked');
        // const ttltglLahirValue = $('#tgl_lahir').val();
        if (!isTermsChecked) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Term & Conditions Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!ttlnamaValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Nama Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!ttlemailValue) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Email Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (!ttlpassword1Value) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Kolom Password Tidak Boleh Kosong',
                timer: 1500
            });
        } else if (ttlpassword1Value !== ttlpassword2Value) {
            swal.fire({
                customClass: 'slow-animation',
                icon: 'error',
                showConfirmButton: false,
                title: 'Password dan Konfirmasi Password Tidak Sama',
                timer: 1500
            });
        } else {
            const recaptchaResponse = grecaptcha.getResponse();
            if (!recaptchaResponse) {
                swal.fire({
                    customClass: 'slow-animation',
                    icon: 'error',
                    showConfirmButton: false,
                    title: 'Please complete the reCAPTCHA',
                    timer: 1500
                });
                return;
            }
            var base_url = "<?php echo base_url(); ?>";
            var url;
            var formData;
            url = "<?php echo site_url('auth/register_process') ?>";

            // window.location = url_base;
            var formData = new FormData($("#register_form")[0]);
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
                    if (data.status == 'Email Sudah Digunakan') {
                        swal.fire({
                            customClass: 'slow-animation',
                            icon: 'error',
                            showConfirmButton: false,
                            title: 'Email Sudah Digunakan',
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
                            title: 'Berhasil Register',
                            timer: 1500
                        }).then(() => {
                            window.location.href = base_url + 'auth'; // Assuming 'dashboard' is the path for admin dashboard
                        });
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