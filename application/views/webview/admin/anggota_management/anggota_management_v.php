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
                    <h3>Table Anggota Management</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Anggota Management</li>
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
                        <a href="<?= base_url('Anggota_Management/add') ?>" class="btn btn-primary">Create Anggota</a>

                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <?php
                                    if ($this->session->userdata('role') == "Puskopkar") {
                                    ?>
                                        <th>Nomor Koperasi</th>

                                    <?php
                                    } else {
                                    ?>
                                        <th>Nomor Anggota</th>
                                    <?php
                                    }
                                    ?>
                                    <th>Nama</th>
                                    <th>Tempat Lahir</th>
                                    <th>Tanggal Lahir</th>
                                    <th>Nomor Telpon</th>
                                    <th>Username</th>
                                    <th>Kredit Limit</th>
                                    <th>Usage Kredit</th>
                                    <th>Saldo Simpanan</th>
                                    <th>Koperasi</th>
                                    <th>Role</th>
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