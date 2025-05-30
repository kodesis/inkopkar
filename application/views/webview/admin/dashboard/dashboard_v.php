<div id="main">
    <header class="mb-3">
        <a href="#" class="burger-btn d-block d-xl-none">
            <i class="bi bi-justify fs-3"></i>
        </a>
    </header>

    <div class="page-heading">
        <h3>Dashboard</h3>
    </div>
    <div class="page-content">
        <section class="row">
            <!-- <div class="col-12 col-lg-9"> -->
            <div class="col-12 col-lg-12">
                <div class="row">
                    <?php
                    if ($this->session->userdata('role') == "Admin") {
                    ?>
                        <div class="col-6 col-lg-3 col-md-6">
                            <?php
                            if ($this->session->userdata('role') == "Admin") {
                            ?>
                                <a href="<?= base_url('Riwayat_Kasir/detail_penjualan') ?> ">
                                <?php
                            } else {
                                ?>
                                    <a href="#">
                                    <?php
                                }
                                    ?>
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon purple mb-2">
                                                        <i class="iconly-boldShow"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <!-- <h6 class="text-muted font-semibold">Total Semua Kredit</h6> -->
                                                    <h6 class="text-muted font-semibold">Total Omset</h6>

                                                    <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format($total_semua_kredit ?? 0, 0, ',', '.') ?>
                                                    </h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>
                        </div>
                    <?php
                        // } else if ($this->session->userdata('role') == "Anggota" || $this->session->userdata('role') == "Koperasi") {
                    } else if ($this->session->userdata('role') == "Koperasi") {
                    ?>
                        <!-- SALDO SIMPANAN -->
                        <!-- <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <?php
                                            if ($this->session->userdata('role') == "Koperasi") {
                                            ?>
                                                <h6 class="text-muted font-semibold">Saldo Simpanan Koperasi</h6>
                                            <?php
                                            } else if ($this->session->userdata('role') == "Anggota") {
                                            ?>
                                                <h6 class="text-muted font-semibold">Saldo Simpanan</h6>

                                            <?php
                                            }
                                            ?>
                                            <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format($total_semua_kredit ?? 0, 0, ',', '.') ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div> -->
                        <div class="col-6 col-lg-3 col-md-6">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                            <div class="stats-icon purple mb-2">
                                                <i class="iconly-boldShow"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <?php
                                            if ($this->session->userdata('role') == "Koperasi") {
                                            ?>
                                                <h6 class="text-muted font-semibold">Piutang Omset </h6>
                                            <?php
                                            }
                                            // else if ($this->session->userdata('role') == "Anggota") {
                                            ?>
                                            <!-- <h6 class="text-muted font-semibold">Saldo Simpanan</h6> -->

                                            <?php
                                            // }
                                            ?>
                                            <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format($total_semua_kredit ?? 0, 0, ',', '.') ?>
                                            </h6>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>
                    <div class="col-6 col-lg-3 col-md-6">
                        <a href="<?= base_url('riwayat_kasir/detail') ?>">
                            <div class="card">
                                <div class="card-body px-4 py-4-5">
                                    <div class="row">
                                        <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                            <div class="stats-icon blue mb-2">
                                                <i class="iconly-boldProfile"></i>
                                            </div>
                                        </div>
                                        <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                            <?php
                                            if ($this->session->userdata('role') == "Anggota") {
                                            ?>
                                                <h6 class="text-muted font-semibold">Usage</h6>
                                                <!-- <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format($total_kredit ?? 0, 0, ',', '.') ?>
                                                </h6> -->
                                            <?php
                                            } else {
                                            ?>
                                                <h6 class="text-muted font-semibold">Kredit Anggota</h6>
                                                <!-- <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format($total_kredit - $saldo_tagihan ?? 0, 0, ',', '.') ?>
                                                </h6> -->
                                            <?php
                                            }
                                            ?>
                                            <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format($total_kredit ?? 0, 0, ',', '.') ?>
                                            </h6>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <?php
                    if ($this->session->userdata('role') != "Puskopkar") {

                    ?>
                        <div class="col-6 col-lg-3 col-md-6">
                            <?php
                            if ($this->session->userdata('role') == "Admin") {
                            ?>
                                <a href="<?= base_url('Koperasi_Management/transaksi') ?> ">
                                <?php
                            } else {
                                ?>
                                    <a href="#"></a>
                                <?php
                            }
                                ?>
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-4 d-flex justify-content-start ">
                                                <div class="stats-icon green mb-2">
                                                    <i class="iconly-boldPaper"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-8">
                                                <?php
                                                if ($this->session->userdata('role') == "Admin") {
                                                ?>
                                                    <h6 class="text-muted font-semibold">Saldo Koperasi</h6>
                                                <?php
                                                } else if ($this->session->userdata('role') == "Anggota") {
                                                ?>
                                                    <h6 class="text-muted font-semibold">Limit Kredit</h6>
                                                <?php
                                                } else {
                                                ?>
                                                    <h6 class="text-muted font-semibold">Saldo Internal</h6>
                                                <?php
                                                }
                                                ?>
                                                <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format(
                                                                                    $saldo_tagihan,
                                                                                    0,
                                                                                    ', ',
                                                                                    ' . '
                                                                                ) ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </a>

                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if ($this->session->userdata('role') != "Anggota" && $this->session->userdata('role') != "Puskopkar") {
                    ?>
                        <div class="col-6 col-lg-3 col-md-6">
                            <?php
                            if ($this->session->userdata('role') == "Admin") {
                            ?>
                                <a href="<?= base_url('Koperasi_Management') ?> ">
                                <?php
                            } else if ($this->session->userdata('role') == "Koperasi") {
                                ?>
                                    <a href="<?= base_url('Riwayat_Kasir/detail_penjualan') ?> ">
                                    <?php
                                } else {
                                    ?>
                                        <a href="#"></a>
                                    <?php
                                }
                                    ?>
                                    <div class="card">
                                        <div class="card-body px-4 py-4-5">
                                            <div class="row">
                                                <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                    <div class="stats-icon red mb-2">
                                                        <i class="iconly-boldWallet"></i>
                                                    </div>
                                                </div>
                                                <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                    <?php
                                                    if ($this->session->userdata('role') == "Admin") {
                                                    ?>
                                                        <h6 class="text-muted font-semibold">Saldo Inkopkar</h6>
                                                    <?php
                                                    } else {
                                                    ?>
                                                        <h6 class="text-muted font-semibold">Saldo Rekening</h6>
                                                    <?php
                                                    }
                                                    ?>
                                                    <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format(
                                                                                        $saldo_rekening,
                                                                                        0,
                                                                                        ', ',
                                                                                        ' . '
                                                                                    ) ?></h6>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    </a>

                        </div>
                    <?php
                    }
                    ?>
                    <?php
                    if ($this->session->userdata('role') == "Koperasi" || $this->session->userdata('role') == "Puskopkar") {
                    ?>
                        <div class="col-6 col-lg-3 col-md-6">
                            <a href="<?= base_url('iuran') ?>">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                <div class="stats-icon red mb-2">
                                                    <i class="iconly-boldWallet"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Saldo Iuran</h6>
                                                <h6 class="font-extrabold mb-0">
                                                    <?= 'Rp. ' . number_format($total_saldo_iuran ?? 0, 0, ',', '.') ?>
                                                </h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <!-- <div class="col-6 col-lg-3 col-md-6">
                            <a href="<?= base_url('Koperasi_Management') ?> ">
                                <div class="card">
                                    <div class="card-body px-4 py-4-5">
                                        <div class="row">
                                            <div class="col-md-4 col-lg-12 col-xl-12 col-xxl-5 d-flex justify-content-start ">
                                                <div class="stats-icon red mb-2">
                                                    <i class="iconly-boldWallet"></i>
                                                </div>
                                            </div>
                                            <div class="col-md-8 col-lg-12 col-xl-12 col-xxl-7">
                                                <h6 class="text-muted font-semibold">Total Saldo</h6>
                                                <h6 class="font-extrabold mb-0"><?= 'Rp. ' . number_format(
                                                                                    $total_saldo,
                                                                                    0,
                                                                                    ', ',
                                                                                    ' . '
                                                                                ) ?></h6>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div> -->
                    <?php
                    }
                    ?>
                </div>
                <!-- <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <div id="chart-profile-visit"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-xl-4">
                        <div class="card">
                            <div class="card-header">
                                <h4>Profile Visit</h4>
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-7">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-primary" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use
                                                    xlink:href="<?= base_url() ?>assets/admin/static/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">Europe</h5>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h5 class="mb-0 text-end">862</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-europe"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-success" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use
                                                    xlink:href="<?= base_url() ?>assets/admin/static/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">America</h5>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h5 class="mb-0 text-end">375</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-america"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-success" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use
                                                    xlink:href="<?= base_url() ?>assets/admin/static/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">India</h5>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h5 class="mb-0 text-end">625</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-india"></div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-7">
                                        <div class="d-flex align-items-center">
                                            <svg class="bi text-danger" width="32" height="32" fill="blue"
                                                style="width:10px">
                                                <use
                                                    xlink:href="<?= base_url() ?>assets/admin/static/images/bootstrap-icons.svg#circle-fill" />
                                            </svg>
                                            <h5 class="mb-0 ms-3">Indonesia</h5>
                                        </div>
                                    </div>
                                    <div class="col-5">
                                        <h5 class="mb-0 text-end">1025</h5>
                                    </div>
                                    <div class="col-12">
                                        <div id="chart-indonesia"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-8">
                        <div class="card">
                            <div class="card-header">
                                <h4>Latest Comments</h4>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-hover table-lg">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>Comment</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="<?= base_url() ?>assets/admin/compiled/jpg/5.jpg">
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Si Cantik</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class=" mb-0">Congratulations on your graduation!</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="<?= base_url() ?>assets/admin/compiled/jpg/2.jpg">
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Si Ganteng</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class=" mb-0">Wow amazing design! Can you make another tutorial for
                                                        this design?</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="<?= base_url() ?>assets/admin/compiled/jpg/8.jpg">
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Singh Eknoor</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class=" mb-0">What a stunning design! You are so talented and creative!</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td class="col-3">
                                                    <div class="d-flex align-items-center">
                                                        <div class="avatar avatar-md">
                                                            <img src="<?= base_url() ?>assets/admin/compiled/jpg/3.jpg">
                                                        </div>
                                                        <p class="font-bold ms-3 mb-0">Rani Jhadav</p>
                                                    </div>
                                                </td>
                                                <td class="col-auto">
                                                    <p class=" mb-0">I love your design! It’s so beautiful and unique! How did you learn to do this?</p>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div> -->
            </div>
            <!-- <div class="col-12 col-lg-3">
                <div class="card">
                    <div class="card-body py-4 px-4">
                        <div class="d-flex align-items-center">
                            <div class="avatar avatar-xl">
                                <img src="<?= base_url() ?>assets/admin/compiled/jpg/1.jpg" alt="Face 1">
                            </div>
                            <div class="ms-3 name">
                                <h5 class="font-bold">John Duck</h5>
                                <h6 class="text-muted mb-0">@johnducky</h6>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Recent Messages</h4>
                    </div>
                    <div class="card-content pb-4">
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="<?= base_url() ?>assets/admin/compiled/jpg/4.jpg">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">Hank Schrader</h5>
                                <h6 class="text-muted mb-0">@johnducky</h6>
                            </div>
                        </div>
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="<?= base_url() ?>assets/admin/compiled/jpg/5.jpg">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">Dean Winchester</h5>
                                <h6 class="text-muted mb-0">@imdean</h6>
                            </div>
                        </div>
                        <div class="recent-message d-flex px-4 py-3">
                            <div class="avatar avatar-lg">
                                <img src="<?= base_url() ?>assets/admin/compiled/jpg/1.jpg">
                            </div>
                            <div class="name ms-4">
                                <h5 class="mb-1">John Dodol</h5>
                                <h6 class="text-muted mb-0">@dodoljohn</h6>
                            </div>
                        </div>
                        <div class="px-4">
                            <button class='btn btn-block btn-xl btn-outline-primary font-bold mt-3'>Start Conversation</button>
                        </div>
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h4>Visitors Profile</h4>
                    </div>
                    <div class="card-body">
                        <div id="chart-visitors-profile"></div>
                    </div>
                </div>
            </div> -->
        </section>
    </div>