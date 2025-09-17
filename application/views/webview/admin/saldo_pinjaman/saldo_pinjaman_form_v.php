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
                    <h3>Form Layout</h3>
                    <!-- <p class="text-subtitle text-muted">Multiple form layouts, you can use.</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Tambah Saldo Pinjaman</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <!-- // Basic multiple Column Form section start -->
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">

                        <div class="card-header row">
                            <div class="col-6">
                                <h4 class="card-title">Tambah Saldo Pinjaman</h4>
                            </div>
                            <div class="col-6 d-flex justify-content-end">
                                <a href="<?= base_url('assets/template/Template_Saldo_pinjaman.xlsx') ?>" class="btn btn-secondary" download target="_blank">Download Template</a>
                                <button type="button" class="btn btn-success ms-2" data-bs-toggle="modal" data-bs-target="#uploadModal">
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 384 512">
                                        <path fill="#ffffff" d="M64 0C28.7 0 0 28.7 0 64L0 448c0 35.3 28.7 64 64 64l256 0c35.3 0 64-28.7 64-64l0-288-128 0c-17.7 0-32-14.3-32-32L224 0 64 0zM256 0l0 128 128 0L256 0zM155.7 250.2L192 302.1l36.3-51.9c7.6-10.9 22.6-13.5 33.4-5.9s13.5 22.6 5.9 33.4L221.3 344l46.4 66.2c7.6 10.9 5 25.8-5.9 33.4s-25.8 5-33.4-5.9L192 385.8l-36.3 51.9c-7.6 10.9-22.6 13.5-33.4 5.9s-13.5-22.6-5.9-33.4L162.7 344l-46.4-66.2c-7.6-10.9-5-25.8 5.9-33.4s25.8-5 33.4 5.9z" />
                                    </svg> Upload Excel</button>
                            </div>
                        </div>

                        <div class="card-content">
                            <div class="card-body">
                                <div id="detail_user" style="display:none">
                                    <table class="table">
                                        <tr>
                                            <td style="width:20%"><b>Nama</b></td>
                                            <td colspan="2">:</td>
                                            <td style="text-align: right;" id="detail_nama"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%"><b>Nomor Anggota</b></td>
                                            <td colspan="2">:</td>
                                            <td style="text-align: right;" id="detail_nomor_anggota"></td>
                                        </tr>
                                        <!-- <tr>
                                            <td style="width:20%"><b>Saldo Pinjaman</b></td>
                                            <td>:</td>
                                            <td style="width: 70%; text-align:right;">Rp.</td>
                                            <td style="text-align: right;" id="detail_kredit_limit"></td>
                                        </tr> -->
                                        <!-- <tr>
                                            <td style="width:20%"><b>Pemaikaian Kredit</b></td>
                                            <td>:</td>
                                            <td style="width: 70%; text-align:right;">Rp.</td>
                                            <td style="text-align: right;" id="detail_usage_kredit"></td>
                                        </tr> -->
                                    </table>
                                </div>
                                <form class="form" id="add_Nota">
                                    <div class="row">

                                        <!-- <div class="col-12">
                                            <div class="form-group">
                                                <label for="text">Anggota</label>
                                                <select class="choices form-select" name="id_anggota" id="id_anggota_add" onchange="get_detail_user(); toggleNominalKredit();">
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
                                        </div> -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="text">Anggota</label>
                                                <select class="form-select" name="id_anggota" id="id_anggota_search">
                                                    <option disabled selected value="">-- Pilih Anggota --</option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Nominal Pinjaman</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <div class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onfocus="removeFormat(this)" onblur="formatNumber(this)" disabled>
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Keterangan</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="keterangan_add" name="keterangan" value="CICILAN BULAN <?= strtoupper(date('F'))  ?> <?= date('Y') ?>">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Jenis Pinjaman</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <div class="form-group">
                                                    <input type="text" class="form-control" id="jenis_pinjaman_add" name="jenis_pinjaman" value="PINJAMAN">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Angsuran</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <div class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control" id="cicilan_add" name="cicilan" onfocus="removeFormat(this)" onblur="formatNumber(this)">
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Sisa Pinjaman</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <div class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control" id="sisa_cicilan_add" name="sisa_cicilan" onfocus="removeFormat(this)" onblur="formatNumber(this)">
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Sisa Jangka Waktu</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <input type="number" class="form-control" id="sisa_jkw_add" name="sisa_jkw" min="0" value="0">
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Bulan Angsuran</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <!-- <div class="form-group">
                                                    <select id="bulan" name="bulan" class="form-control">
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
                                                </div> -->
                                                <input type="date" class="form-control" id="bulan_add" name="bulan">
                                            </div>
                                        </div>
                                        <!-- <div class="col-6">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Tahun Angsuran</label>
                                                <div class="form-group">
                                                    <input type="number" class="form-control" id="tahun_add" name="tahun" min="2000" value="<?= date('Y') ?>">
                                                </div>
                                            </div>
                                        </div> -->
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Tanggal Transaksi</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <div class="form-group">
                                                    <input type="date" class="form-control" id="tanggal_jam_add" name="tanggal_jam">
                                                </div>
                                            </div>
                                        </div>
                                        <!-- <div class="col-6">
                                            <div class="form-group">
                                                <label for="text">Nominal Kredit</label>
                                                <div class="form-group position-relative has-icon-left">
                                                    <input disabled type="text" class="form-control" id="nominal_kredit_sekarang">
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="text">Nominal Cash</label>
                                                <div class="form-group position-relative has-icon-left">
                                                    <input disabled type="text" class="form-control" id="nominal_cash_sekarang">
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->
                                    </div>
                                </form>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" onclick="save_Nota(event)" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" onclick="reset_Nota()" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    <a href="<?= base_url('Nota_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
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
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary">Upload</button>
                    </div>
                </form>

            </div>
        </div>
    </div>