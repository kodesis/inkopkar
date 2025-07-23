<script>
    document.getElementById("togglePassword").addEventListener("click", function(e) {
        e.preventDefault();
        const passwordInput = document.getElementById("password");
        const icon = document.getElementById("toggleIcon");

        if (passwordInput.type === "password") {
            passwordInput.type = "text";
            icon.classList.remove("bi-eye-fill");
            icon.classList.add("bi-eye-slash-fill");
        } else {
            passwordInput.type = "password";
            icon.classList.remove("bi-eye-slash-fill");
            icon.classList.add("bi-eye-fill");
        }
    });

    function save(event) {
        event.preventDefault(); // Prevent form from submitting and refreshing

        const swalWithBootstrapButtons = Swal.mixin({
            customClass: {
                InputEvent: 'form-control',
                confirmButton: 'btn btn-success',
                cancelButton: 'btn btn-danger'
            },
            buttonsStyling: false
        })

        swalWithBootstrapButtons.fire({
            title: 'Ingin Mengubah Data?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, Ubah',
            cancelButtonText: 'Tidak',
            reverseButtons: true
        }).then((result) => {

            if (result.isConfirmed) {

                var url;
                var formData;
                url = "<?php echo site_url('Profile/update') ?>";

                // window.location = url_base;
                var formData = new FormData($("#form-profile")[0]);
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
                                title: 'Berhasil Mengubah Data',
                                timer: 1500
                            }).then((result) =>
                                location.reload()
                            );
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
</script>