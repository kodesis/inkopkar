<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <div class="page-title">
            <div class="row">
                <div class="col-12 col-md-6 order-md-1 order-last">
                    <h3>Table Riwayat Saldo Pinjaman</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Riwayat Saldo Pinjaman Management</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Minimal jQuery Datatable start -->
        <section class="section">
            <div class="card">
                <div class="card-header mb-3">
                    <h5 class="card-title">
                        <!-- Minimal jQuery Datatable -->
                        <!-- <a href="<?= base_url('Riwayat_Kasir/add') ?>" class="btn btn-primary">Create Riwayat Saldo</a> -->
                        <a href="<?= base_url('saldo_pinjaman/monitoring_pinjaman') ?>" class="btn btn-primary">Monitoring Pinjaman</a>
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#deleteModal">Hapus Data</button>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="filter_month" class="form-control">
                                <option value="">Pilih Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filter_year" class="form-control">
                                <option value="">Pilih Tahun</option>
                                <?php
                                $current_year = date('Y');
                                for ($i = $current_year; $i >= $current_year - 5; $i--) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="search_button" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <!-- <th>Koperasi</th> -->
                                    <th>keterangan</th>
                                    <th>Jenis Pinjaman</th>
                                    <th>Bulan Tahun</th>
                                    <!-- <th>Tahun</th> -->
                                    <th>Tanggal Bayar</th>
                                    <th>Nominal</th>
                                    <th>Cicilan</th>
                                    <th>Sisa Cicilan</th>
                                    <th>Sisa Jangka Waktu</th>
                                    <!-- <th>Status</th> -->
                                    <!-- <th>#</th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="7" style="text-align:right">
                                        Total
                                    </th>
                                    <th id="total_saldo" style="text-align: right;">
                                        Rp. <?= number_format($total->cicilan ?? 0, 0, ',', '.') ?>
                                    </th>

                                    <th colspan="2">
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Minimal jQuery Datatable end -->
        <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <form id="deleteDataPinjaman" method="post" enctype="multipart/form-data">
                        <div class="modal-header">
                            <h5 class="modal-title" id="uploadModalLabel">Hapus Data Pinjaman</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>

                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="tanggal_data" class="form-label">Tanggal Data</label>
                                <!-- <input type="month" name="tanggal_data" id="tanggal_data" class="form-control"> -->
                                <select class="form-control" name="tanggal_data" id="tanggal_data">
                                    <option selected disabled>Pilih Tanggal Input Data</option>
                                    <?php
                                    // Check if $grouped_data is available and is an array/object
                                    if (isset($grouped_data) && is_array($grouped_data)) {

                                        // Loop through the data grouped by post_date
                                        foreach ($grouped_data as $g) {

                                            // The value (for POSTing) is the raw date/time string, e.g., '2025-09-25 10:30:00'
                                            $post_date_raw = $g->post_date;

                                            // Format the date/time for user display (optional, but recommended)
                                            // You might need to adjust the format based on your database output
                                            try {
                                                $datetime = new DateTime($post_date_raw);
                                                $display_date = $datetime->format('d F Y'); // e.g., 25 Sep 2025 10:30:00
                                            } catch (Exception $e) {
                                                $display_date = $post_date_raw; // Fallback if formatting fails
                                            }
                                    ?>
                                            <option value="<?= $post_date_raw ?>"><?= $display_date ?></option>
                                        <?php
                                        }
                                    } else {
                                        // Display an option if no data is available
                                        ?>
                                        <option disabled>Tidak ada data tersedia</option>
                                    <?php
                                    }
                                    ?>
                                </select>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>