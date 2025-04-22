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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Nota Pembayaran</li>
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
                            <h4 class="card-title">Tambah Nota Pembayaran</h4>
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
                                        <tr>
                                            <td style="width:20%"><b>Kredit Limit</b></td>
                                            <td>:</td>
                                            <td style="width: 70%; text-align:right;">Rp.</td>
                                            <td style="text-align: right;" id="detail_kredit_limit"></td>
                                        </tr>
                                        <tr>
                                            <td style="width:20%"><b>Pemaikaian Kredit</b></td>
                                            <td>:</td>
                                            <td style="width: 70%; text-align:right;">Rp.</td>
                                            <td style="text-align: right;" id="detail_usage_kredit"></td>
                                        </tr>
                                    </table>
                                </div>
                                <form class="form" id="add_Nota">
                                    <div class="row">

                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="text">Anggota</label>
                                                <select class="choices form-select" name="id_anggota" id="id_anggota_add" onchange="get_detail_user_pembayaran(); ">
                                                    <option disabled selected>-- Pilih Anggota --</option>
                                                    <?php
                                                    foreach ($anggota as $c) {
                                                    ?>
                                                        <option value="<?= $c->id ?>"><?= $c->id ?> - <?= $c->nomor_anggota ?> - <?= $c->nama ?> - <?= $c->nama_koperasi ?></option>
                                                    <?php
                                                    }
                                                    ?>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Nominal</label>
                                                <!-- <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" onchange="cek_nominal()" placeholder="Nominal"> -->
                                                <div class="form-group position-relative has-icon-left">
                                                    <input type="number" class="form-control" id="nominal_kredit_add" onchange="cek_nominal_pembayaran()" onfocus="removeFormat(this)" onblur="formatNumber(this)" disabled>
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                    <input type="hidden" id="nominal_kredit_value" name="nominal_kredit">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="text">Nominal Sisa Kredit</label>
                                                <!-- <input disabled class="form-control" type="text" id="nominal_kredit_sekarang"> -->
                                                <div class="form-group position-relative has-icon-left">
                                                    <input disabled type="text" class="form-control" id="nominal_kredit_sekarang">
                                                    <div class="form-control-icon">
                                                        <p>Rp.</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" onclick="save_Nota_pembayaran(event)" class="btn btn-primary me-1 mb-1">Submit</button>
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