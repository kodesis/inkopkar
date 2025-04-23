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
                    <h3>Table Nota Management</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Nota Management</li>
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
                        <!-- <a href="<?= base_url('Nota_Management/add') ?>" class="btn btn-primary">Create Nota</a> -->
                    </h5>
                    <table class="table" id="table_anggota">
                        <tr>
                            <td style="width: 20%;">Nomor</td>
                            <td>:</td>
                            <td><?= $Anggota->nomor_anggota ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Nama</td>
                            <td>:</td>
                            <td><?= $Anggota->nama ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Nomor Telpon</td>
                            <td>:</td>
                            <td><?= $Anggota->no_telp ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Kredit Limit</td>
                            <td>:</td>
                            <td><?= number_format(
                                    $Anggota->kredit_limit,
                                    0,
                                    ',',
                                    '.'
                                ) ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Usage Kredit</td>
                            <td>:</td>
                            <?php
                            $this->db->select_sum('nominal_kredit');
                            $this->db->from('nota');
                            $this->db->join('anggota', 'anggota.id = nota.id_anggota');
                            $this->db->where('id_anggota', $Anggota->id);
                            $this->db->where('status', '1');
                            $query = $this->db->get();
                            $result = $query->row();
                            $usage_kredit = $result->nominal_kredit;
                            ?>
                            <td><?= number_format(
                                    $usage_kredit ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="card-body">
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No</th>
                                    <th>Tanggal</th>
                                    <!-- <th>Nama Anggota</th> -->
                                    <th>Nominal Kredit</th>
                                    <th>Nominal Cash</th>
                                    <th>Toko - Kasir</th>
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