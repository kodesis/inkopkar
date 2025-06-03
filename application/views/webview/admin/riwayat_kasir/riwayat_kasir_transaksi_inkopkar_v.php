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
                    <h3>Table Riwayat Transaksi Inkopkar</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Riwayat Transaksi Inkopkar Management</li>
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
                        <?php if ($this->uri->segment(1) == "iuran") {
                        ?>
                            <a href="<?= base_url('assets/template/Template_Iuran.xlsx') ?>" class="btn btn-secondary" download target="_blank">Download Template</a>
                            <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                    <path fill="#ffffff" d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z" />
                                </svg> Upload Excel</button>
                        <?php
                        } ?>
                        <!-- <a href="<?= base_url('Riwayat_Kasir/add') ?>" class="btn btn-primary">Create Riwayat Kasir</a> -->
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Koperasi</th>
                                    <th>Tujuan</th>
                                    <th>Tanggal</th>
                                    <th>Sebelum</th>
                                    <th>Nominal</th>
                                    <th>Sesudah</th>
                                    <!-- <th>#</th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="6">
                                        Total
                                    </th>
                                    <th id="total_saldo" style="text-align: right;">
                                        <!-- Rp.
                                        <?= number_format(
                                            $total->nominal ?? 0,
                                            0,
                                            ',',
                                            '.'
                                        ) ?> -->
                                    </th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Minimal jQuery Datatable end -->

    </div>