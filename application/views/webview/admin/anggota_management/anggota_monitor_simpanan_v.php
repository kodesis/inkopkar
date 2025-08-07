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
                    <h3>Table Monitoring Iuran Anggota</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Monitoring Iuran Anggota</li>
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
                                <a href="<?= base_url('Anggota_Management') ?>" class="btn btn-primary"><i class=""></i>
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
                                </tr>
                            </thead>

                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Minimal jQuery Datatable end -->

    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form id="upload_excel_form" method="post" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="uploadModalLabel">Upload Excel File</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="excelFile" class="form-label">Choose Excel File</label>
                            <input class="form-control" type="file" name="file_excel" id="excelFile" accept=".xlsx,.xls">
                        </div>
                        <span><b>Pastikan yang meng upload adalah user kopkar terkait*</b></span>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>

            </div>
        </div>
    </div>