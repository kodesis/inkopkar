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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Anggota</li>
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
                                <h4 class="card-title">Tambah Anggota</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" id="add_Anggota">
                                        <div class="row">

                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Anggota</label>
                                                    <input type="text" class="form-control" id="nomor_anggota_add" name="nomor_anggota" placeholder="Nomor Anggota">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nama</label>
                                                    <input type="text" class="form-control" id="nama_add" name="nama" placeholder="Nama">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Tempat Lahir</label>
                                                    <input type="text" class="form-control" id="tempat_lahir_add" name="tempat_lahir" placeholder="Tempat Lahir">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" id="tanggal_lahir_add" name="tanggal_lahir" placeholder="Tanggal Lahir">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Telpon (WA Wajib Aktif)</label>
                                                    <input type="number" class="form-control" id="no_telp_add" name="no_telp" placeholder="Nomor Telpon">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Username</label>
                                                    <input type="text" class="form-control" id="username_add" name="username" placeholder="Username">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Password</label>
                                                    <input type="password" class="form-control" id="password_add" name="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Kredit Limit</label>
                                                    <!-- <input type="number" class="form-control" id="kredit_limit_add" name="kredit_limit" placeholder="Kredit Limit"> -->
                                                    <div class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="kredit_limit_add" name="kredit_limit"
                                                            placeholder="Kredit Limit"
                                                            onfocus="removeFormat(this)" oninput="validateAndFormat(this)" onblur="formatNumber(this)">
                                                        <div class="form-control-icon">
                                                            <p>Rp.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Usage Kredit</label>
                                                    <input type="number" class="form-control" id="usage_kredit_add" name="usage_kredit" placeholder="Usage Kredit">
                                                </div>
                                            </div> -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Toko Koperasi</label>
                                                    <?php
                                                    if ($this->session->userdata('role') == "Koperasi") {
                                                    ?>
                                                        <select class="choices form-control" name="id_toko" id="id_toko_add">
                                                            <option disabled selected>-- Pilih Toko Koperasi --</option>
                                                            <?php
                                                            foreach ($koperasi as $c) {
                                                            ?>
                                                                <option value="<?= $c->id ?>"><?= $c->id . ' - ' . $c->nama_koperasi . ' - ' . $c->nama_toko ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    <?php
                                                    } else if ($this->session->userdata('role') == "Admin") {
                                                    ?>
                                                        <select class="choices form-control" name="id_toko" id="id_toko_add">
                                                            <option disabled selected>-- Pilih Toko Koperasi --</option>
                                                            <?php
                                                            foreach ($koperasi as $c) {
                                                            ?>
                                                                <option value="<?= $c->id ?>"><?= $c->id . ' - ' . $c->nama_koperasi . ' - ' . $c->nama_toko ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>
                                                    <?php
                                                    }
                                                    ?>
                                                </div>
                                            </div>
                                            <?php
                                            if ($this->session->userdata('role') == "Admin") {
                                            ?>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="text">Role</label>
                                                        <select class="form-select" name="role" id="kasir_add">
                                                            <option disabled selected>-- Pilih Role --</option>
                                                            <option value="1">Admin Inkopkar</option>
                                                            <option value="2">User Koperasi</option>
                                                            <option value="3">User Kasir</option>
                                                            <option value="4">User Anggota</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php
                                            } elseif ($this->session->userdata('role') == "Koperasi") {
                                            ?>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="role" id="kasir_add" class="form-check-input" value="3">
                                                            <label for="checkbox1">Kasir</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </form>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" onclick="save_Anggota()" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <button type="reset" onclick="reset_Anggota()" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                        <a href="<?= base_url('Anggota_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
                                    </div>
                                </div>
                            </div>
                        <?php
                        } else {
                        ?>
                            <div class="card-header">
                                <h4 class="card-title">Update Anggota</h4>
                            </div>
                            <div class="card-content">
                                <div class="card-body">
                                    <form class="form" id="update_Anggota">
                                        <div class="row">
                                            <input type="hidden" name="id_edit" value="<?= $Anggota->id ?>">
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Anggota</label>
                                                    <input type="text" class="form-control" id="nomor_anggota_edit" name="nomor_anggota" placeholder="Nomor Anggota" value="<?= $Anggota->nomor_anggota ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nama</label>
                                                    <input type="text" class="form-control" id="nama_edit" name="nama" placeholder="Nama" value="<?= $Anggota->nama ?>">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Tempat Lahir</label>
                                                    <input type="text" class="form-control" id="tempat_lahir_edit" name="tempat_lahir" placeholder="Tempat Lahir" value="<?= $Anggota->tempat_lahir ?>">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Tanggal Lahir</label>
                                                    <input type="date" class="form-control" id="tanggal_lahir_edit" name="tanggal_lahir" placeholder="Tanggal Lahir" value="<?= $Anggota->tanggal_lahir ?>">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Nomor Telpon (WA Wajib Aktif)</label>
                                                    <input type="number" class="form-control" id="no_telp_edit" name="no_telp" placeholder="Nomor Telpon" value="<?= $Anggota->no_telp ?>">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Username</label>
                                                    <input type="text" class="form-control" id="username_edit" name="username" placeholder="Username" value="<?= $Anggota->username ?>">
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Password</label>
                                                    <input type="password" class="form-control" id="password_edit" name="password" placeholder="Password">
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Kredit Limit</label>
                                                    <!-- <input type="number" class="form-control" id="kredit_limit_edit" name="kredit_limit" placeholder="Kredit Limit" value="<?= $Anggota->kredit_limit ?>"> -->
                                                    <div class="form-group position-relative has-icon-left">
                                                        <input type="text" class="form-control" id="kredit_limit_edit" name="kredit_limit"
                                                            placeholder="Kredit Limit" value="<?= $Anggota->kredit_limit ?>"
                                                            onfocus="removeFormat(this)" oninput="validateAndFormat(this)" onblur="formatNumber(this)">

                                                        <div class="form-control-icon">
                                                            <p>Rp.</p>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- <div class="col-6">
                                                <div class="form-group">
                                                    <label for="email-id-vertical">Usage Kredit</label>
                                                    <input type="number" class="form-control" id="usage_kredit_edit" name="usage_kredit" placeholder="Usage Kredit" value="<?= $Anggota->usage_kredit ?>">
                                                </div>
                                            </div> -->
                                            <div class="col-12">
                                                <div class="form-group">
                                                    <label for="text">Toko Koperasi</label>
                                                    <select class="choices form-control" name="id_toko" id="id_toko_edit">
                                                        <option disabled>-- Pilih Toko Koperasi --</option>
                                                        <?php
                                                        foreach ($koperasi as $c) {
                                                        ?>
                                                            <option <?php if ($Anggota->id_toko == $c->id) echo "selected" ?> value="<?= $c->id ?>"><?= $c->id . ' - ' . $c->nama_koperasi . ' - ' . $c->nama_toko ?></option>
                                                        <?php
                                                        }
                                                        ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <?php
                                            if ($this->session->userdata('role') == "Admin") {
                                            ?>
                                                <div class="col-12">
                                                    <div class="form-group">
                                                        <label for="text">Role</label>
                                                        <select class="form-select" name="role" id="kasir_edit">
                                                            <option disabled selected>-- Pilih Role --</option>
                                                            <option <?= $Anggota->role == 1 ? 'selected' : '' ?>
                                                                value="1">Admin Inkopkar</option>
                                                            <option <?= $Anggota->role == 2 ? 'selected' : '' ?>
                                                                value="2">User Koperasi</option>
                                                            <option <?= $Anggota->role == 3 ? 'selected' : '' ?>
                                                                value="3">User Kasir</option>
                                                            <option <?= $Anggota->role == 4 ? 'selected' : '' ?>
                                                                value="4">User Anggota</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            <?php
                                            } elseif ($this->session->userdata('role') == "Koperasi") {
                                            ?>
                                                <div class="col-12">
                                                    <div class="form-check">
                                                        <div class="checkbox">
                                                            <input type="checkbox" name="role" id="kasir_edit" class="form-check-input" value="3" <?= $Anggota->role == 3 ? 'selected' : '' ?>>
                                                            <label for="checkbox1">Kasir</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </form>
                                    <div class="col-12 d-flex justify-content-end">
                                        <button type="submit" onclick="update_Anggota()" class="btn btn-primary me-1 mb-1">Submit</button>
                                        <a href="<?= base_url('Anggota_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
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