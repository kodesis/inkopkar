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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Nota Iuran</li>
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

                        <div class="card-header">
                            <h4 class="card-title">Tambah Nota Iuran</h4>
                        </div>

                        <div class="card-content">
                            <div class="card-body">
                                <div id="detail_user" style="display:none">
                                    <table class="table">
                                        <tr>
                                            <td style="width:20%"><b>Nama Koperasi</b></td>
                                            <td colspan="2">:</td>
                                            <td style="text-align: right;" id="detail_nama"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%"><b>Saldo Rekening</b></td>
                                            <td>:</td>
                                            <td style="width: 70%; text-align:right;">Rp.</td>
                                            <td style="text-align: right;" id="detail_rekening"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%"><b>Saldo Iuran</b></td>
                                            <td>:</td>
                                            <td style="width: 70%; text-align:right;">Rp.</td>
                                            <td style="text-align: right;" id="detail_iuran"></td>
                                        </tr>
                                    </table>
                                </div>
                                <form class="form" id="add_Nota">
                                    <div class="row">
                                        <input type="hidden" name="id_koperasi" id="id_koperasi_add" value="<?= $this->session->userdata('id_koperasi') ?>">
                                        <!-- <div class="col-12">
                                            <div class="form-group">
                                                <label for="text">Anggota</label>
                                                <select class="choices form-select" name="id_koperasi" id="id_koperasi_add" onchange="get_detail_koperasi(); toggleNominalKredit(); ">
                                                    <option selected disabled>-- Pilih Koperasi --</option>
                                                    <?php
                                                    foreach ($koperasi as $c) {
                                                    ?>
                                                        <option value="<?= $c->id ?>"><?= $c->nama_koperasi ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div> -->

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Nominal</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <div class="form-group position-relative has-icon-left">
                                                    <input type="text" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" onfocus="removeFormat(this)" onblur="formatNumber(this)">
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="text">Saldo Rekening Awal</label>
                                                <div class="form-group position-relative has-icon-left">
                                                    <input disabled type="text" class="form-control" id="nominal_rekening_awal">
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group">
                                                <label for="text">Saldo Rekening Setelah</label>
                                                <div class="form-group position-relative has-icon-left">
                                                    <input disabled type="text" class="form-control" id="nominal_rekening_setelah">
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" onclick="save_Nota_iuran(event)" class="btn btn-primary me-1 mb-1">Submit</button>
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