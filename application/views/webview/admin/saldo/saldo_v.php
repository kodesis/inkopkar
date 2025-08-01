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
                    <h3>Table Saldo Anggota</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Saldo Anggota</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- Minimal jQuery Datatable start -->
        <section class="section">
            <div class="card">
                <div class="card-header">
                    <?php
                    if ($this->session->userdata('role') == "Koperasi" || $this->session->userdata('role') == "Admin") {
                    ?>
                        <div class="row">
                            <div class="col-6">
                                <h5 class="card-title">
                                    <!-- Minimal jQuery Datatable -->
                                    <button type="button" class="btn btn-primary ms-2" data-bs-toggle="modal" data-bs-target="#tambahModal">Tambah Saldo Akhir</button>
                                </h5>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <div class="card-title">
                                    <a href="<?= base_url('assets/template/Contoh_Format_Saldo.xlsx') ?>" class="btn btn-secondary" download target="_blank">Download Template</a>
                                    <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                            <path fill="#ffffff" d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z" />
                                        </svg> Upload Excel</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <label for="filter_month">Month:</label>
                            <select id="filter_month" class="form-control">
                                <option value="">All Months</option>
                                <option value="01">January</option>
                                <option value="02">February</option>
                                <option value="03">March</option>
                                <option value="04">April</option>
                                <option value="05">May</option>
                                <option value="06">June</option>
                                <option value="07">July</option>
                                <option value="08">August</option>
                                <option value="09">September</option>
                                <option value="10">October</option>
                                <option value="11">November</option>
                                <option value="12">December</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filter_year">Year:</label>
                            <select id="filter_year" class="form-control">
                                <option value="">All Years</option>
                                <?php
                                $currentYear = date('Y');
                                for ($i = $currentYear; $i >= $currentYear - 5; $i--) { // Last 5 years
                                    echo '<option value="' . $i . '">' . $i . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-2 d-flex align-items-end">
                            <button id="apply_filter_btn" class="btn btn-primary">Apply Filter</button>
                        </div>
                    </div>
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Keterangan</th>
                                    <th>Saldo Simpanan</th>
                                    <th>Keterangan</th>
                                    <th>Saldo Pinjaman</th>
                                    <th>Tanggal Data</th>
                                    <th>#</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="3">Total</th>
                                    <th id="total-saldo-simpanan">0</th>
                                    <th id="total-saldo-pinjaman">0</th>
                                    <th></th>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>
        <!-- Minimal jQuery Datatable end -->

    </div>

    <div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="add_saldo_form" method="post" onsubmit="add_saldo(event)">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Tambah Saldo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class=" modal-body">
                        <div class="form-group">
                            <label for="text">Anggota</label>
                            <select class="choices form-select" name="id_anggota" id="id_anggota_add">
                                <option disabled selected>-- Pilih Anggota --</option>
                                <?php
                                foreach ($anggota as $c) {
                                ?>
                                    <option value="<?= $c->id ?>"><?= $c->nomor_anggota ?> - <?= $c->nama ?> - <?= $c->nama_koperasi ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_data_add">Tanggal Data</label>
                            <div class="form-group">
                                <input id="tanggal_data_add" name="tanggal" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Saldo Simpanan Akhir</label>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan_simpanan" id="keterangan_simpanan_add" value="IURAN BULAN JUNI 2025">
                            </div>
                            <div class="form-group">
                                <label for="">Nominal</label>
                                <input type="number" min="0" class="form-control" name="saldo_simpanan_akhir" id="saldo_simpanan_akhir_add" value="0">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="">Saldo Pinjaman Akhir</label>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan_pinjaman" id="keterangan_pinjaman_add" value="IURAN BULAN JUNI 2025">
                            </div>
                            <div class="form-group">
                                <label for="">Nominal</label>
                                <input type="number" min="0" class="form-control" name="saldo_pinjaman_akhir" id="saldo_pinjaman_akhir_add" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="add_saldo()">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="ideditModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="edit_saldo_form" method="post" onsubmit="update_saldo(event)">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ideditModalLabel">Tambah Saldo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="id_edit" id="id_edit">
                        <div class="form-group">
                            <label for="text">Anggota</label>
                            <select class="form-select" name="id_anggota" id="id_anggota_edit" disabled>
                                <?php
                                foreach ($anggota as $c) {
                                ?>
                                    <option value="<?= $c->id ?>"><?= $c->nomor_anggota ?> - <?= $c->nama ?> - <?= $c->nama_koperasi ?></option>
                                <?php
                                }
                                ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tanggal_data_add">Tanggal Data</label>
                            <div class="form-group">
                                <input id="tanggal_data_edit" name="tanggal" type="date" class="form-control">
                            </div>
                        </div>
                        <!-- <div class="form-group">
                        <label for="">Saldo Simpanan Akhir</label>
                        <input type="number" min="0" class="form-control" name="saldo_simpanan_akhir" id="saldo_simpanan_akhir_edit">
                    </div>
                    <div class="form-group">
                        <label for="">Saldo Pinjaman Akhir</label>
                        <input type="number" min="0" class="form-control" name="saldo_pinjaman_akhir" id="saldo_pinjaman_akhir_edit">
                    </div> -->
                        <div class="form-group">
                            <label for="">Saldo Simpanan Akhir</label>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan_simpanan" id="keterangan_simpanan_edit">
                            </div>
                            <div class="form-group">
                                <label for="">Nominal</label>
                                <input type="number" min="0" class="form-control" name="saldo_simpanan_akhir" id="saldo_simpanan_akhir_edit" value="0">
                            </div>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label for="">Saldo Simpanan Akhir</label>
                            <div class="form-group">
                                <label for="">Keterangan</label>
                                <input type="text" class="form-control" name="keterangan_pinjaman" id="keterangan_pinjaman_edit">
                            </div>
                            <div class="form-group">
                                <label for="">Nominal</label>
                                <input type="number" min="0" class="form-control" name="saldo_pinjaman_akhir" id="saldo_pinjaman_akhir_edit" value="0">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="update_saldo()">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <form id="upload_saldo_form" method="post" onsubmit="upload_user(event)" enctype="multipart/form-data">
                    <div class="modal-header">
                        <h5 class="modal-title" id="tambahModalLabel">Upload Saldo</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class=" modal-body">
                        <div class="form-group">
                            <label for="tanggal_data_add">Tanggal Data</label>
                            <div class="form-group">
                                <input id="tanggal_upload" name="tanggal" type="date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="">Saldo Simpanan Akhir</label>
                            <input type="file" min="0" class="form-control" name="file" id="file">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" onclick="upload_user()">Tambah</button>
                    </div>
                </form>
            </div>
        </div>
    </div>