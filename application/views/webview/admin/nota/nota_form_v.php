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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Nota</li>
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
                                <h4 class="card-title">Tambah Nota</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" id="add_Nota">
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Anggota</label>
                                                    <select class="form-select" name="id_anggota" id="id_anggota_add">
                                                        <option disabled selected>-- Pilih Anggota --</option>
                                                        <?php
                                                        foreach ($anggota as $c) {
                                                        ?>
                                                            <option value="<?= $c->id ?>"><?= $c->id ?> - <?= $c->nama ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nominal</label>
                                                    <input type="number" class="form-control" id="nominal_kredit_add" name="nominal_kredit" placeholder="Nominal">
                                                </div>
                                            </div>
                                            <!-- <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Alamat</label>
                                                    <textarea class="form-control" name="alamat" id="alamat_add"></textarea>
                                                </div>
                                            </div> -->
                                        </div>
                                    </form>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" onclick="save_Nota()" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" onclick="reset_Nota()" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        <a href="<?= base_url('Nota_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="card-header">
                                <h4 class="card-title">Update Nota</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" id="update_Nota">
                                        <div class="row">
                                            <input type="hidden" name="id_edit" value="<?= $Nota->id ?>">

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Anggota</label>
                                                    <select class="form-control" name="id_anggota" id="id_anggota_edit">
                                                        <option disabled>-- Pilih Anggota --</option>
                                                        <?php
                                                        foreach ($anggota as $c) {
                                                        ?>
                                                            <option <?php if ($Nota->id_anggota == $c->id) echo "selected" ?> value="<?= $c->id ?>"><?= $c->id ?> - <?= $c->nama ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nominal</label>
                                                    <input type="number" class="form-control" id="nominal_kredit_edit" name="nominal_kredit" placeholder="Nominal">
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" onclick="update_Nota()" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="<?= base_url('Nota_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
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