<style>
    .btn-merah {
        --bs-btn-color: #fff;
        --bs-btn-bg: #e74c3c;
        --bs-btn-border-color: #e74c3c;
        --bs-btn-hover-color: #fff;
        --bs-btn-hover-bg: #b03527ff;
        --bs-btn-hover-border-color: #b03527ff;
        --bs-btn-focus-shadow-rgb: 130, 138, 145;
        --bs-btn-active-color: #fff;
        --bs-btn-active-bg: #b03527ff;
        --bs-btn-active-border-color: #7e251bff;
        --bs-btn-active-shadow: inset 0 3px 5px rgba(0, 0, 0, 0.125);
        --bs-btn-disabled-color: #fff;
        --bs-btn-disabled-bg: #e74c3c;
        --bs-btn-disabled-border-color: #e74c3c;

        background: #e74c3c none repeat scroll 0 0;
    }

    .btn-merah:hover {
        background: #d84536 none repeat scroll 0 0;
        --bs-link-color-rgb: #d84536
    }

    .btn-merah:before {
        background: #d84536;
    }

    .text-merah {
        color: #e74c3c !important;
    }

    .bg-lightgray {
        /* background-color: #bdc3c7; */
        background-color: #7d8184;
    }

    .bg-yellow {
        /* background-color: #bdc3c7; */
        background-color: #fe9e07;
    }
</style>
<!-- main-area -->
<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="<?= base_url() ?>/assets/img/inkopkar/kkmp1.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <!-- <h2 class="title">Our Team Members</h2> -->
                        <h2 class="title text-merah">Koperasi Kelurahan <br> Merah Putih</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item text-merah" aria-current="page">Anggota</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__shape">
            <img src="<?= base_url() ?>/assets/img/images/breadcrumb_shape01.png" alt="">
            <img src="<?= base_url() ?>/assets/img/images/breadcrumb_shape02.png" alt="" class="rightToLeft">
            <img src="<?= base_url() ?>/assets/img/images/breadcrumb_shape03.png" alt="">
            <img src="<?= base_url() ?>/assets/img/images/breadcrumb_shape04.png" alt="">
            <img src="<?= base_url() ?>/assets/img/images/breadcrumb_shape05.png" alt="" class="alltuchtopdown">
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <!-- team-area -->
    <!-- <section class="team-area pt-120 pb-90" data-background="<?= base_url() ?>assets/img/bg/h3_services_bg_color.png">
        <div class="container">
            <div class="team-item-wrap">
                <div class="row justify-content-center">
                    <h4 style="color:#ffffff; text-align:center; margin-bottom: 30px;">Ketua Umum Induk Koperasi Karyawan (INKOPKAR) yang Pernah Menjabat
                    </h4>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team-item">
                            <div class="team-thumb">
                                <img src="<?= base_url() ?>/assets/img/inkopkar/team/agus_sudono.jpg" alt="">

                            </div>
                            <div class="team-content">
                                <h4 class="title" style="color: #ffffff;"><a href="#">H. Agus Sudono</a></h4>
                                <span>1986 - 2008</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team-item">
                            <div class="team-thumb">
                                <img src="<?= base_url() ?>/assets/img/team/default_avatar.jpg" alt="">

                            </div>
                            <div class="team-content">
                                <h4 class="title" style="color: #ffffff;"><a href="#">HM Arbi, S.H.</a></h4>
                                <span>2008 - 2013</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team-item">
                            <div class="team-thumb">
                                <img src="<?= base_url() ?>/assets/img/team/default_avatar.jpg" alt="">

                            </div>
                            <div class="team-content">
                                <h4 class="title" style="color: #ffffff;"><a href="#">HM Arbi, S.H.</a></h4>
                                <span>2013 - 2014</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team-item">
                            <div class="team-thumb">
                                <img src="<?= base_url() ?>/assets/img/team/default_avatar.jpg" alt="">

                            </div>
                            <div class="team-content">
                                <h4 class="title" style="color: #ffffff;"><a href="#">Ir.Sulistyo (PLT)</a></h4>
                                <span>2014 - 2016</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team-item">
                            <div class="team-thumb">
                                <img src="<?= base_url() ?>/assets/img/team/default_avatar.jpg" alt="">

                            </div>
                            <div class="team-content">
                                <h4 class="title" style="color: #ffffff;"><a href="#">Drs. Suparwanto, M.B.A. (PLT)</a></h4>
                                <span>2016 - 2018</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team-item">
                            <div class="team-thumb">
                                <img src="<?= base_url() ?>/assets/img/inkopkar/team/fadel_muhammad.jpg" alt="">

                            </div>
                            <div class="team-content">
                                <h4 class="title" style="color: #ffffff;"><a href="#">Prof. Dr. Ir. H. fadel muhammad</a></h4>
                                <span>2019 - 2024</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8">
                        <div class="team-item">
                            <div class="team-thumb">
                                <img src="<?= base_url() ?>/assets/img/inkopkar/team/soeryo.jpg" alt="">

                            </div>
                            <div class="team-content">
                                <h4 class="title" style="color: #ffffff;"><a href="#">Soeryo</a></h4>
                                <span>2025 - 2030</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section> -->
    <!-- team-area-end -->
    <!-- team-area -->
    <!-- <section class="team-area pt-120 pb-90">
        <div class="container">
            <div class="team-item-wrap">
                <div class="row justify-content-center">
                    <img src="<?= base_url() ?>/assets/img/inkopkar/prabowo.jpeg" alt="">
                </div>
            </div>
        </div>
    </section> -->
    <!-- team-area-end -->
    <!-- team-area -->
    <section class="team-area pt-120 pb-90" data-background="<?= base_url() ?>assets/img/bg/h3_services_bg_red.png">
        <div class="container">
            <div class="team-item-wrap">
                <div class="row justify-content-center">
                    <h4 style="color:#ffffff; text-align:center; margin-bottom: 30px;">KKMP WILAYAH JAKARTA</h4>
                    <div class="col-12 mb-4">
                        <input type="text" id="kelurahanSearchInput" class="form-control" placeholder="Cari Kelurahan atau Kecamatan..." style="border-radius: 20px; padding: 10px 15px;">
                    </div>
                    <div id="kelurahanListContainer" class="row justify-content-center">

                        <?php
                        foreach ($kelurahan as $k) {
                            $this->db->from('koperasi');
                            $this->db->where('kelurahan', $k->id);
                            $user = $this->db->get()->num_rows();
                            if ($user > 0) {
                        ?>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 kelurahan-item">

                                    <!-- <div class="team-item" style="background-color:#e74c3c"> -->
                                    <a href="<?= base_url('auth') ?>">
                                        <div class="team-item bg-yellow">
                                            <div class="team-content">
                                                <h4 class="title" style="color: #ffffff;">Kel. <?= $k->kelurahan ?>
                                                </h4>
                                                <span style="color: #ffffff;">Kec. <?= $k->kecamatan ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 kelurahan-item">

                                    <!-- <div class="team-item" style="background-color:#e74c3c"> -->
                                    <!-- <a onclick="noUser(<?= $k->kelurahan ?>)"> -->
                                    <a onclick="noUser('<?= $k->kelurahan ?>')">
                                        <div class="team-item bg-lightgray">
                                            <div class="team-content">
                                                <h4 class="title" style="color: #fff;">Kel. <?= $k->kelurahan ?>
                                                </h4>
                                                <span style="color: #fff;">Kec. <?= $k->kecamatan ?></span>
                                            </div>
                                        </div>
                                    </a>
                                </div>

                        <?php
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- team-area-end -->
</main>

<!-- main-area-end -->