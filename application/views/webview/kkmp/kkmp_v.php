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

    .white-text {
        color: #ffffff;
        font-weight: bold;
        font-size: 18px;
        margin: 5px;
    }

    .white-text:hover {
        color: #fe9e07;
    }

    .white-text:focus {
        color: #fe9e07;
    }

    .white-text.active {
        text-decoration: underline;
        /* color: #fe9e07; */

    }

    .white-outline {
        border: 2px solid #ffffff;
        border-radius: 25px;
    }

    .white-outline:hover {
        border: 2px solid #fe9e07;

    }

    .white-outline:focus {
        border: 2px solid #fe9e07;
    }

    .white-outline.active {
        /* border: 1px solid #fe9e07; */
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
                        <h2 class="title text-merah">Koperasi Kelurahan <br>Merah Putih</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item text-merah" aria-current="page">KKMP Jakarta</li>
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
            <div class="row justify-content-center">
                <nav class="sub-navbar mb-4">
                    <ul class="nav justify-content-center" id="kkmpTabs" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link white-text white-outline active" id="kkmp-tab" data-bs-toggle="tab" data-bs-target="#tab-kkmp" type="button" role="tab" aria-controls="tab-kkmp" aria-selected="true">Koperasi Merah Putih</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link white-text white-outline" id="registrasi-kkmp-tab" data-bs-toggle="tab" data-bs-target="#tab-registrasi-kkmp" type="button" role="tab" aria-controls="tab-registrasi-kkmp" aria-selected="false">Cara Registrasi KKMP</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link white-text white-outline" id="registrasi-anggota-kkmp-tab" data-bs-toggle="tab" data-bs-target="#tab-registrasi-anggota-kkmp" type="button" role="tab" aria-controls="tab-registrasi-anggota-kkmp" aria-selected="false">Cara Registrasi Anggota KKMP</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link white-text white-outline" id="registrasi-contoh-proposal" data-bs-toggle="tab" data-bs-target="#tab-contoh-proposal" type="button" role="tab" aria-controls="tab-contoh-proposal" aria-selected="false">Contoh Proposal KKMP</button>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="tab-content" id="kkmpTabContent">
                <div class="team-item-wrap tab-pane fade show active" id="tab-kkmp" role="tabpanel" aria-labelledby="kkmp-tab">
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
                <div class="team-item-wrap tab-pane fade" id="tab-registrasi-kkmp" role="tabpanel" aria-labelledby="registrasi-kkmp-tab">
                    <div class="row justify-content-center">
                        <h4 style="color:#ffffff; text-align:center; margin-bottom: 30px;">Cara Registrasi Aplikasi Koperasi Untuk KKMP</h4>
                        <div class="services__item-four shine-animate-item">
                            <div class="services__content-four">
                                <h2 class="title">Cara Mudah Mendaftar Aplikasi Koperasi untuk KKMP Anda</h2>
                                <p>Untuk memastikan Koperasi Merah Putih Anda dapat terdaftar dengan lancar dan mulai beroperasi secara optimal, siapkan beberapa dokumen dan data penting berikut:</p>
                                <div class="about__list-box">
                                    <ul class="list-wrap">
                                        <li><i class="fas fa-check"></i>Dokumen Legalitas Koperasi: </li>
                                        <p style="margin-left: 45px; font-size: 15px;">Ini termasuk akta pendirian koperasi, Anggaran Dasar (AD) dan Anggaran Rumah Tangga (ART) yang telah disahkan, serta dokumen perizinan lainnya yang diperlukan sesuai regulasi pemerintah. Kelengkapan legalitas ini menjadi fondasi utama bagi operasional koperasi yang sah dan terpercaya.</p>

                                        <li><i class="fas fa-check"></i>Data-data Pengurus Koperasi: </li>
                                        <p style="margin-left: 45px; font-size: 15px;">Siapkan data lengkap para pengurus koperasi, meliputi nama lengkap, nomor identitas (KTP), alamat, jabatan, dan informasi kontak yang valid. Data ini penting untuk memastikan transparansi manajemen dan memudahkan koordinasi dalam menjalankan kegiatan koperasi.</p>

                                        <li><i class="fas fa-check"></i>Data-data Pengawas Koperasi: </li>
                                        <p style="margin-left: 45px; font-size: 15px;"> Serupa dengan pengurus, data lengkap para pengawas koperasi juga sangat dibutuhkan. Ini mencakup nama lengkap, nomor identitas (KTP), alamat, serta informasi kontak mereka. Peran pengawas sangat krusial dalam menjaga akuntabilitas dan memastikan operasional koperasi berjalan sesuai ketentuan.</p>

                                        <li><i class="fas fa-check"></i>Menghubungi Admin untuk Mendaftar: </li>
                                        <p style="margin-left: 45px; font-size: 15px;">Setelah semua dokumen dan data di atas lengkap, langkah terakhir adalah menghubungi admin Koperasi Merah Putih. Tim kami akan memandu Anda melalui proses pendaftaran, membantu verifikasi dokumen, dan menjawab setiap pertanyaan yang Anda miliki. Kami berkomitmen untuk membuat proses ini semudah dan seefisien mungkin bagi Anda. </p>
                                    </ul>
                                </div>
                                <p>Dengan memenuhi persyaratan di atas dan mengikuti panduan dari tim admin kami, Koperasi Merah Putih Anda akan segera terdaftar dan siap memberikan manfaat finansial yang optimal bagi seluruh anggotanya. Jangan tunda lagi, mari wujudkan potensi penuh koperasi Anda bersama kami!
                                </p>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="team-item-wrap tab-pane fade" id="tab-registrasi-anggota-kkmp" role="tabpanel" aria-labelledby="registrasi-anggota-kkmp-tab">
                    <div class="row justify-content-center">
                        <h4 style="color:#ffffff; text-align:center; margin-bottom: 30px;">Cara Registrasi Anggota Koperasi Merah Putih</h4>
                        <div class="services__item-four shine-animate-item">
                            <div class="services__content-four">
                                <h2 class="title">Langkah Mudah Registrasi Anggota Koperasi Merah Putih</h2>
                                <p>Proses pendaftaran sebagai anggota Koperasi Merah Putih dirancang agar sederhana dan tidak merepotkan. Ikuti langkah-langkah singkat di bawah ini:</p>
                                <div class="about__list-box">
                                    <ul class="list-wrap">
                                        <li><i class="fas fa-check"></i>Kunjungi atau Hubungi Koperasi Terdekat:</li>
                                        <p style="margin-left: 45px; font-size: 15px;">Langkah pertama adalah mendatangi atau menghubungi kantor Koperasi Merah Putih yang berlokasi di sekitar Anda. Anda bisa mencari informasi kontak atau alamat kantor melalui situs web resmi Koperasi Merah Putih (jika tersedia) atau menanyakan kepada kerabat yang mungkin sudah menjadi anggota. Staf kami akan dengan senang hati membantu dan menjelaskan lebih lanjut mengenai prosedur pendaftaran.</p>

                                        <li><i class="fas fa-check"></i>Siapkan Dokumen Penting Anda:</li>
                                        <p style="margin-left: 45px; font-size: 15px;">Untuk mempercepat proses registrasi, pastikan Anda telah menyiapkan data dan dokumen pribadi yang diperlukan. Umumnya, dokumen yang diminta meliputi:
                                        <ul class="list-wrap" style="margin-left: 45px; margin-bottom: 60px; ">
                                            <li><i class="fas fa-arrow-right"></i>Kartu Tanda Penduduk (KTP)</li>
                                            <li><i class="fas fa-arrow-right"></i>Kartu Keluarga (KK)</li>
                                            <li><i class="fas fa-arrow-right"></i>Nomor Pokok Wajib Pajak (NPWP)</li>
                                            <li><i class="fas fa-arrow-right"></i>Dokumen Pendukung Lainnya</li>
                                        </ul>
                                        </p>

                                        <li><i class="fas fa-check"></i>Proses Verifikasi dan Anda Resmi Menjadi Anggota!</li>
                                        <p style="margin-left: 45px; font-size: 15px;">Setelah semua data dan dokumen Anda lengkap, staf koperasi akan membantu Anda mengisi formulir pendaftaran dan memverifikasi kelengkapan berkas. Proses ini biasanya tidak memakan waktu lama. Setelah verifikasi selesai dan Anda memenuhi semua persyaratan, Anda akan resmi terdaftar sebagai anggota Koperasi Merah Putih.</p>
                                    </ul>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
                <div class="team-item-wrap tab-pane fade show active" id="tab-contoh-proposal" role="tabpanel" aria-labelledby="contoh-proposal-tab">
                    <div class="row justify-content-center">
                        <h4 style="color:#ffffff; text-align:center; margin-bottom: 30px;">Contoh Proposal KKMP</h4>
                        <div id="kelurahanListContainer" class="row justify-content-center">
                            <!-- <div class="col-xl-3 col-lg-4 col-md-6 col-sm-8 kelurahan-item">
                                <a href="<?= base_url('auth') ?>">
                                    <div class="team-item bg-yellow">
                                        <div class="team-content">
                                            <h4 class="title" style="color: #ffffff;">Kel. <?= $k->kelurahan ?>
                                            </h4>
                                            <span style="color: #ffffff;">Kec. <?= $k->kecamatan ?></span>
                                        </div>
                                    </div>
                                </a>
                            </div> -->

                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8 kelurahan-item">
                                <div class="team-item">
                                    <div class="team-content">
                                        <h4 class="title" style="color: #ffffff;">Proposal Koperasi Simpan Pinjam KKMP</h4>
                                        <!-- <span style="color: #ffffff;">Kec. <?= $k->kecamatan ?></span> -->
                                        <a class="btn btn-light" href="<?= base_url('assets/contoh-proposal/') ?>Koperasi_Simpan_Pinjam_KKMP.pptx" download target="_blank">Download File</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8 kelurahan-item">
                                <div class="team-item">
                                    <div class="team-content">
                                        <h4 class="title" style="color: #ffffff;">Proposal Pertanian KKMP</h4>
                                        <!-- <span style="color: #ffffff;">Kec. <?= $k->kecamatan ?></span> -->
                                        <a class="btn btn-light" href="<?= base_url('assets/contoh-proposal/') ?>Koperasi_Pertanian_KKMP.pptx" download target="_blank">Download File</a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 col-sm-8 kelurahan-item">
                                <div class="team-item">
                                    <div class="team-content">
                                        <h4 class="title" style="color: #ffffff;">Proposal Sekolah KKMP</h4>
                                        <!-- <span style="color: #ffffff;">Kec. <?= $k->kecamatan ?></span> -->
                                        <a class="btn btn-light" href="<?= base_url('assets/contoh-proposal/') ?>Koperasi_Sekolah_KKMP.pptx" download target="_blank">Download File</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- team-area-end -->
</main>

<!-- main-area-end -->