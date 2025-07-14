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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Koperasi</li>
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

                        <?php
                        if ($this->uri->segment(3) == null) {
                        ?>
                            <div class="card-header">
                                <h4 class="card-title">Tambah Koperasi</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" id="add_Koperasi">
                                        <div class="row">
                                            <!-- <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Puskopkar</label>
                                                    <select class="choices form-control" name="id_toko" id="id_toko_edit">
                                                        <option disabled>-- Pilih Puskopkar --</option>
                                                        <?php
                                                        foreach ($puskopkar as $c) {
                                                        ?>
                                                            <option value="<?= $c->id ?>"><?= $c->id . ' - ' . $c->nomor_anggota . ' - ' . $c->nama ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> -->

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Induk Koperasi</label>
                                                    <input type="text" class="form-control" id="no_induk_add" name="no_induk" placeholder="Nomor Induk Koperasi">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nama Koperasi</label>
                                                    <input type="text" class="form-control" id="nama_koperasi_add" name="nama_koperasi" placeholder="Nama Koperasi">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Telpon</label>
                                                    <input type="number" class="form-control" id="telp_add" name="telp" placeholder="Nomor Telpon">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Alamat</label>
                                                    <textarea class="form-control" name="alamat" id="alamat_add"></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" onclick="save_Koperasi()" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" onclick="reset_Koperasi()" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        <a href="<?= base_url('Koperasi_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="card-header">
                                <h4 class="card-title">Update Koperasi</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" id="update_Koperasi">
                                        <div class="row">
                                            <input type="hidden" name="id_edit" value="<?= $Koperasi->id ?>">
                                            <!-- <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Puskopkar</label>
                                                    <select class="choices form-control" name="id_toko" id="id_toko_edit">
                                                        <option disabled>-- Pilih Puskopkar --</option>
                                                        <?php
                                                        foreach ($puskopkar as $c) {
                                                        ?>
                                                            <option <?php if ($Anggota->id_toko == $c->id) echo "selected" ?> value="<?= $c->id ?>"><?= $c->id . ' - ' . $c->nama_koperasi . ' - ' . $c->nama_toko ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div> -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Induk Koperasi</label>
                                                    <input type="text" class="form-control" id="no_induk" name="no_induk" placeholder="Nomor Induk Koperasi" value="<?= $Koperasi->no_induk ?>" disabled>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nama Koperasi</label>
                                                    <input type="text" class="form-control" id="nama_koperasi_edit" name="nama_koperasi" placeholder="Nama Koperasi" value="<?= $Koperasi->nama_koperasi ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Telpon</label>
                                                    <input type="number" class="form-control" id="telp_edit" name="telp" placeholder="Nomor Telpon" value="<?= $Koperasi->telp ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Alamat</label>
                                                    <textarea class="form-control" name="alamat" id="alamat_edit"><?= $Koperasi->alamat ?></textarea>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Puskopkar</label>
                                                    <select class="choices form-control" name="id_puskopkar" id="id_puskopkar_edit">
                                                        <option disabled>-- Pilih Puskopkar --</option>
                                                        <?php foreach ($puskopkar as $c) { ?>
                                                            <option <?php if ($Anggota->id_puskopkar == $c->id) echo "selected" ?> value="<?= $c->id ?>"><?= $c->id . ' - ' . $c->nomor_anggota . ' - ' . $c->nama ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" onclick="update_Koperasi()" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="<?= base_url('Koperasi_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>