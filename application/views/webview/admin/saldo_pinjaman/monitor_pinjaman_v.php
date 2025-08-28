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
                    <h3>Table Monitoring Iuran Pinjaman Anggota</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Monitoring Iuran Pinjaman Anggota</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Minimal jQuery Datatable start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">
                            <h5 class="card-title">
                                <!-- Minimal jQuery Datatable -->
                                <a href="<?= base_url('dashboard') ?>" class="btn btn-primary"><i class=""></i>
                                    < Kembali</a>
                            </h5>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-3 mb-3">
                            <label for="filter_status">Filter Status:</label>
                            <select class="form-control" id="filter_status">
                                <option value="">Semua Status</option>
                                <option value="Belum Dibayar">Belum Dibayar</option>
                                <option value="Sudah Dibayar">Sudah Dibayar</option>
                            </select>
                        </div>
                        <div class="col-md-9 mb-3 d-flex justify-content-end">
                            <a href="#" id="export_belum_dibayar" class="btn btn-success mt-4">Export Excel (Belum Dibayar)</a>
                        </div>
                    </div>
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>

                                <tr>
                                    <th>No</th>
                                    <th>Nomor Anggota</th>
                                    <th>Nama</th>
                                    <th>Tanggal Iuran Terakhir</th>
                                    <th>Status</th>
                                    <th>#</th>
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Minimal jQuery Datatable end -->

    </div>