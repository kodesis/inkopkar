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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Toko</li>
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
                                <h4 class="card-title">Tambah Toko</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" id="add_Toko">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Koperasi</label>
                                                    <select class="form-control" name="id_koperasi" id="id_koperasi_add">
                                                        <option disabled selected>-- Pilih Koperasi --</option>
                                                        <?php
                                                        foreach ($koperasi as $c) {
                                                        ?>
                                                            <option value="<?= $c->id ?>"><?= $c->nama_koperasi ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nama Toko</label>
                                                    <input type="text" class="form-control" id="nama_toko_add" name="nama_toko" placeholder="Nama Toko">
                                                </div>
                                            </div>
                                            <!-- <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Telpon</label>
                                                    <input type="number" class="form-control" id="telp_add" name="telp" placeholder="Nomor Telpon">
                                                </div>
                                            </div> -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">PIC</label>
                                                    <input type="text" class="form-control" id="pic_add" name="pic" placeholder="PIC">
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
                                        <button type="submit" onclick="save_Toko()" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" onclick="reset_Toko()" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        <a href="<?= base_url('Toko_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="card-header">
                                <h4 class="card-title">Update Toko</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" id="update_Toko">
                                        <div class="row">
                                            <input type="hidden" name="id_edit" value="<?= $Toko->id ?>">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Koperasi</label>
                                                    <select class="form-control" name="id_koperasi" id="id_koperasi_edit">
                                                        <option disabled>-- Pilih Koperasi --</option>
                                                        <?php
                                                        foreach ($koperasi as $c) {
                                                        ?>
                                                            <option <?php if ($Toko->id_koperasi == $c->id) echo "selected" ?> value="<?= $c->id ?>"><?= $c->nama_koperasi ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nama Toko</label>
                                                    <input type="text" class="form-control" id="nama_toko_edit" name="nama_toko" placeholder="Nama Toko" value="<?= $Toko->nama_toko ?>">
                                                </div>
                                            </div>
                                            <!-- <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Telpon</label>
                                                    <input type="number" class="form-control" id="telp_edit" name="telp" placeholder="Nomor Telpon" value="<?= $Toko->telp ?>">
                                                </div>
                                            </div> -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">PIC</label>
                                                    <input type="text" class="form-control" id="pic_edit" name="pic" placeholder="PIC" value="<?= $Toko->pic ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Alamat</label>
                                                    <textarea class="form-control" name="alamat" id="alamat_edit"><?= $Toko->alamat ?></textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" onclick="update_Toko()" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="<?= base_url('Toko_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
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