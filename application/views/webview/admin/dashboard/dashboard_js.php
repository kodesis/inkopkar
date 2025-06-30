<script>
    $(document).ready(function() {

        function load_summary() {
            const summary_container = $('#summary_container');

            // Tampilkan pesan loading
            summary_container.html('<p>Menghitung total...</p>');

            $.ajax({
                url: "<?php echo site_url('dashboard/rekap_kebutuhan') ?>",
                type: "POST",
                data: {},
                dataType: "JSON",
                success: function(response) {
                    if (response.length > 0) {
                        let html = '<table class="table table-bordered">';
                        html += '<thead><tr><th>Kebutuhan</th><th>Total</th></tr></thead><tbody>';

                        response.forEach(item => {
                            let itemName = item.nama_kebutuhan;
                            if (item.tipe_kebutuhan) {
                                itemName += ' - Tipe ' + item.tipe_kebutuhan.toUpperCase();
                            }

                            let total = parseFloat(item.total_jumlah).toLocaleString('id-ID', {
                                minimumFractionDigits: 2,
                                maximumFractionDigits: 2
                            });

                            html += `<tr><td>${itemName}</td><td><strong>${total} ${item.satuan}</strong></td></tr>`;
                        });

                        html += '</tbody></table>';
                        summary_container.html(html);
                    } else {
                        summary_container.html('<p class="text-muted">Tidak ada data kebutuhan.</p>');
                    }
                },
                error: function() {
                    summary_container.html('<p class="text-danger">Gagal memuat rekapitulasi. Silakan coba lagi.</p>');
                }
            });
        }

        load_summary();
    });
</script>