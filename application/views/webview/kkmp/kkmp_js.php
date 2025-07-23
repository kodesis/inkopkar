<script>
    $(document).ready(function() {
        // Search functionality
        $('#kelurahanSearchInput').on('keyup', function() {
            var searchTerm = $(this).val().toLowerCase(); // Get search term and convert to lowercase

            // Iterate over each kelurahan item
            $('#kelurahanListContainer .kelurahan-item').each(function() {
                var kelurahanText = $(this).find('.title').text().toLowerCase(); // Get Kelurahan name
                var kecamatanText = $(this).find('span').text().toLowerCase(); // Get Kecamatan name

                // Check if the search term is found in either kelurahan or kecamatan name
                if (kelurahanText.includes(searchTerm) || kecamatanText.includes(searchTerm)) {
                    $(this).show(); // Show the item if it matches
                } else {
                    $(this).hide(); // Hide the item if it doesn't match
                }
            });
        });

        // ... your existing JavaScript (e.g., noUser function, upload form submit) ...

        // Example noUser function (ensure this exists and is properly defined)
        // function noUser(kelurahan) {
        //     console.log("noUser function called for:", kelurahan);
        //     // Your logic for when a kelurahan without users is clicked
        //     // e.g., Swal.fire for informational message
        // }
    });

    function noUser(kel) {
        swal.fire({
            customClass: 'slow-animation',
            icon: 'error',
            showConfirmButton: false,
            title: 'Tidak ada anggota di Kelurahan ' + kel,
            timer: 1500
        });
    }
</script>