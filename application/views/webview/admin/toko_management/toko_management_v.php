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
                    <h3>Table Manajemen Toko</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manajemen Toko</li>
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
                        <a href="<?= base_url('Toko_Management/add') ?>" class="btn btn-primary">Tambah Toko</a>

                    </h5>
                </div>
                <div class="card-body">
                    <!-- Custom filter bar -->
                    <div class="d-flex justify-content-end align-items-center gap-2 mb-2 flex-wrap" id="customFilterContainer">
                        <!-- Search by dropdown -->
                        <div id="datatable-filter-bar" class="d-flex align-items-center">
                            <label for="searchBy" class="me-2 mb-0">Search by:</label>
                            <select id="searchBy" class="form-select form-select-sm" style="width: auto;">
                                <option value="">All</option>
                                <option value="nama_koperasi">Nama Koperasi</option>
                                <option value="nama_toko">Nama Toko</option>
                            </select>
                        </div>
                        <!-- Placeholder for the DataTables search box -->
                        <div id="custom-dt-search" class="ms-3"></div>
                    </div>

                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama Koperasi</th>
                                    <th>Nama Toko</th>
                                    <th>Alamat</th>
                                    <th>PIC</th>
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