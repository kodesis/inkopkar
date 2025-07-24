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
                    <h3>Table Manajemen Koperasi</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manajemen Koperasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Minimal jQuery Datatable start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        <!-- Minimal jQuery Datatable -->
                        <?php
                        if ($this->session->userdata('role') != "Puskopkar") {
                        ?>
                            <a href="<?= base_url('Koperasi_Management/add') ?>" class="btn btn-primary">Tambah Koperasi</a>
                            <a href="<?= base_url('Koperasi_Management/transaksi') ?>" class="btn btn-primary">Transaksi</a>
                        <?php
                        }
                        ?>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nomor Induk Koperasi</th>
                                    <th>Nama Koperasi</th>
                                    <th>Kelurahan</th>
                                    <th>Alamat</th>
                                    <th>Telpon</th>
                                    <th>Saldo Iuran</th>
                                    <?php
                                    if ($this->session->userdata('role') != "Puskopkar") {
                                    ?>
                                        <th>Saldo Inkopkar</th>
                                    <?php
                                    }
                                    ?>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="5" style="text-align: right;">Total </th>
                                    <th id="total_saldo_iuran" style="text-align: right;">
                                        <!-- <div style="text-align: right;">Rp. Rp. <?= number_format($total_usage ?? 0, 0, ',', '.') ?></div> -->
                                    </th>
                                    <?php
                                    if ($this->session->userdata('role') != "Puskopkar") {
                                    ?>
                                        <th id="total_saldo_inkopkar" style="text-align: right;">
                                            <!-- <div style="text-align: right;">Rp. <?= number_format($total_saldo_tagihan ?? 0, 0, ',', '.') ?></div> -->
                                        </th>
                                    <?php
                                    }
                                    ?>
                                    <th>#</th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Minimal jQuery Datatable end -->

    </div>