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
                    <h3>Table Riwayat Kredit</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Riwayat Kasir Management</li>
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
                        <!-- <a href="<?= base_url('Riwayat_Kasir/add') ?>" class="btn btn-primary">Create Riwayat Kasir</a> -->
                        <a href="<?= base_url('Riwayat_Kasir/detail_penjualan') ?>" class="btn btn-primary">Semua Penjualan</a>
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Tanggal</th>
                                    <!-- <th>Nama Anggota</th> -->
                                    <th>Nominal Kredit</th>
                                    <th>Nominal Cash</th>
                                    <th>Status</th>
                                    <!-- <th>#</th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="3" style="text-align:right">
                                        Total
                                    </th>
                                    <th id="total_saldo_kredit" style="text-align: right;">
                                        <!-- Rp. <?= number_format($total->nominal ?? 0, 0, ',', '.') ?> -->
                                    </th>
                                    <th id="total_saldo_cash" style="text-align: right;">
                                        <!-- Rp. <?= number_format($total->nominal ?? 0, 0, ',', '.') ?> -->
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