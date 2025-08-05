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
                    <h3>Table Saldo Simpanan Management</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Saldo Simpanan Management</li>
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
                            <td style="width: 20%;">Nama Koperasi</td>
                            <td>:</td>
                            <td><?= $koperasi->nama_koperasi ?> - <?= $koperasi->alamat ?></td>
                        </tr>
                        <tr>
                            <td style="width: 20%;">Saldo Simpanan</td>
                            <td>:</td>
                            <?php
                            $this->db->select_sum('nominal');
                            $this->db->from('saldo_simpanan');
                            $this->db->where('id_anggota', $Anggota->id);
                            $this->db->where('status', '1');
                            $query = $this->db->get()->row();

                            $saldo_simpanan = $query->nominal;
                            ?>
                            <td><?= number_format(
                                    $saldo_simpanan ?? 0,
                                    0,
                                    ',',
                                    '.'
                                ) ?></td>
                        </tr>
                    </table>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-3">
                            <select id="filter_month" class="form-control">
                                <option value="">Pilih Bulan</option>
                                <option value="1">Januari</option>
                                <option value="2">Februari</option>
                                <option value="3">Maret</option>
                                <option value="4">April</option>
                                <option value="5">Mei</option>
                                <option value="6">Juni</option>
                                <option value="7">Juli</option>
                                <option value="8">Agustus</option>
                                <option value="9">September</option>
                                <option value="10">Oktober</option>
                                <option value="11">November</option>
                                <option value="12">Desember</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select id="filter_year" class="form-control">
                                <option value="">Pilih Tahun</option>
                                <?php
                                $current_year = date('Y');
                                for ($i = $current_year; $i >= $current_year - 5; $i--) {
                                    echo "<option value='$i'>$i</option>";
                                }
                                ?>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <button id="search_button" class="btn btn-primary">Cari</button>
                        </div>
                    </div>
                    <div class="table-responsive datatable-minimal">
                        <table class="table" id="table_1">
                            <thead>
                                <tr>
                                    <th>No Anggota</th>
                                    <th>Tanggal Transaksi</th>
                                    <th>Sampai Dengan</th>
                                    <th>Nominal</th>
                                    <!-- <th>Toko - Kasir</th> -->
                                    <!-- <th>Status</th> -->
                                    <!-- <th>#</th> -->
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th colspan="3">
                                        Total
                                    </th>
                                    <th id="total_saldo" style="text-align: right;">
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