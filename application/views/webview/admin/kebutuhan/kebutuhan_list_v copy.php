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
                    <h3>Table Kebutuhan List</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kebutuhan List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Minimal jQuery Datatable start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Daftar Kebutuhan Anggota</h5>
                </div>
                <div class="card-body">

                    <div class="row mb-4">
                        <div class="col-md-4">
                            <label for="filter_bulan" class="form-label">Pilih Bulan & Tahun</label>
                            <input type="month" id="filter_bulan" class="form-control" value="<?php echo date('Y-m'); ?>">
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button type="button" id="btn_filter" class="btn btn-primary">Filter</button>
                        </div>
                    </div>
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Anggota</th>
                                    <th>Nama Kebutuhan</th>
                                    <th>Jumlah</th>
                                    <th>Tanggal</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </section>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Rekapitulasi Total Kebutuhan Bulan Terpilih</h5>
                </div>
                <div class="card-body" id="summary_container">
                    <p class="text-muted">Silakan pilih bulan dan klik Filter untuk melihat rekapitulasi.</p>
                </div>
            </div>
        </section>
        <!-- Minimal jQuery Datatable end -->

    </div>