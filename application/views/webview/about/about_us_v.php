<!-- main-area -->
<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="<?= base_url() ?>assets/img/inkopkar/about2.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">About Us</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">About</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb__shape">
            <img src="<?= base_url() ?>assets/img/images/breadcrumb_shape01.png" alt="">
            <img src="<?= base_url() ?>assets/img/images/breadcrumb_shape02.png" alt="" class="rightToLeft">
            <img src="<?= base_url() ?>assets/img/images/breadcrumb_shape03.png" alt="">
            <img src="<?= base_url() ?>assets/img/images/breadcrumb_shape04.png" alt="">
            <img src="<?= base_url() ?>assets/img/images/breadcrumb_shape05.png" alt="" class="alltuchtopdown">
        </div>
    </section>
    <!-- breadcrumb-area-end -->
    <!-- about-area -->
    <section class="about__area-five">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about__content-five">
                        <div class="section-title mb-30">
                            <h2 class="title"><span>Sejarah</span> <br> INKOPKAR</h2>
                        </div>
                        <div class="about__img-wrap-five">
                            <img src="<?= base_url() ?>/assets/img/inkopkar/baru/about3.png" alt="">
                        </div>
                        <p style="text-align: justify;">
                            Kelahiran Induk Koperasi Karyawan (INKOPKAR) tidak bisa dilepaskan dari inisiasi sosok Agus Sudono, tokoh buruh Indonesia. Setelah malang melintang dalam berbagai organisasi buruh bahkan menjadi pegiat buruh internasional dengan menjadi salah satu Anggota Dewan Pimpinan di ILO (International Labour International) 1969-1999 di Geneva - Swiss, ia menyadari bahwa perjuangan buruh adalah perjuangan ekonomi.
                            <br>
                            <br>
                            Perjuangan untuk meningkatkan kesejahteraan kemudian kemudian diwujudkan dengan menghimpun kekuatan ekonomi karyawan melalui koperasi di setiap perusahaan sebagai koperasi primer, lalu koperasi primer mendirikan koperasi sekunder tingkat propinsi yang disebut Pusat Koperasi. Sebanyak 5 Pusat Koperasi yaitu Puskoperindo DIKI Jakarta Raya, Puskobin Jawa Barat Puskobin DI Yogyakarta, Puskobin Bali dan Puskobin Jawa Tengah kemudian mendirikan Induk Koperasi Pekerja Indonesia (Inkoperindo) pada tanggal 14 - 16 Januari 1986 yang didaftarkan oleh Direktur Jenderal Bina Lembaga Koperasi dengan Nomor Badan Hukum 8291 tanggal 29 Januari 1986.
                            <br>
                            <br>
                            Pada Rapat Anggota Khusus Perubahan Anggaran Dasar tanggal 23 Agustus 1986, Inkoperindo berubah nama menjadi Induk Koperasi Karyawan (INKOPKAR). Setelah itu dilakukan perubahan Anggaran Dasar pada tanggal 7 Oktober 1989 dan tanggal 20 Juli 1991 yang telah didaftarkan pada Direktur Jenderal Bina Lembaga Koperasi pada tanggal 11 September 1992 dengan Nomor Badan Hukum 8291C.
                        </p>
                        <br>
                        <br>
                        <br>
                        <p><b>Keanggotaan INKOPKAR terdiri dari 8 Puskopkar yang masih aktif berbadan hukum, yaitu :</b></p>
                        <br>
                        <div class="table">
                            <?php
                            // Sample data array
                            $data = [
                                ['nama' => 'Banten', 'provinsi' => 'Banten'],
                                ['nama' => 'DKI', 'provinsi' => 'DKI Jakarta'],
                                ['nama' => 'Jateng', 'provinsi' => 'Jawa Tengah'],
                                ['nama' => 'DIY', 'provinsi' => 'DI Yogyakarta'],
                                ['nama' => 'Jatim', 'provinsi' => 'Jawa Timur'],
                                ['nama' => 'Bali', 'provinsi' => 'Bali'],
                                ['nama' => 'Riau', 'provinsi' => 'Riau'],
                                ['nama' => 'Kalbar', 'provinsi' => 'Kalimantan Barat'],
                            ];

                            ?>

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Nama</th>
                                        <th>Provinsi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($data as $index => $row) : ?>
                                        <tr>
                                            <td><?= $index + 1; ?></td>
                                            <td>Puskopkar <?= htmlspecialchars($row['nama']); ?></td>
                                            <td><?= htmlspecialchars($row['provinsi']); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- about-area-end -->
    <!-- choose-area -->
    <section class="choose-area">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-6 col-md-8">
                    <div class="about__img-wrap-six">
                        <img src="<?= base_url() ?>assets/img/inkopkar/baru/about3.jpg" style="width: 80%;" alt="">
                        <!-- <img src="<?= base_url() ?>assets/img/images/h4_about_img02.jpg" alt="" data-parallax='{"x" : 40}'> -->
                        <!-- <div class="experience__box-four">
                            <h2 class="title">25</h2>
                            <p>Years Experience <br> in This Field</p>
                        </div> -->
                        <div class="shape">
                            <img src="<?= base_url() ?>assets/img/images/h4_about_img_shape.png" alt="" class="alltuchtopdown">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__content-six">
                        <div class="section-title white-title mb-25">
                            <span class="sub-title">About Us</span>
                            <h2 class="title">Apa Itu <br> INKOPKAR?</h2>
                        </div>
                        <p style="text-align: justify; color: #ffffff;"><b>INKOPKAR</b> merupakan organisasi koperasi tingkat nasional yang menaungi
                            koperasi-koperasi karyawan dari berbagai sektor. Didirikan dengan tujuan meningkatkan
                            kesejahteraan ekonomi karyawan, kami menyediakan berbagai layanan keuangan, pelatihan, dan
                            pengembangan usaha.</p>
                        <!-- <div class=" about__content-inner-four">
                        <div class="about__list-box">
                            <ul class="list-wrap">
                                <li><i class="flaticon-arrow-button"></i>Medicare Advantage Plans</li>
                                <li><i class="flaticon-arrow-button"></i>Analysis & Research</li>
                                <li><i class="flaticon-arrow-button"></i>100% Secure Money Back</li>
                            </ul>
                        </div>
                        <div class="about__list-img-three">
                            <img src="<?= base_url() ?>assets/img/images/about_list_img03.png" alt="">
                            <a href="https://www.youtube.com/watch?v=6mkoGSqTqFI" class="play-btn popup-video"><i class="fas fa-play"></i></a>
                        </div>
                    </div>
                    <a href="contact.html" class="btn btn-two">Quick Contact Us</a> -->
                    </div>
                </div>
            </div>
        </div>
        <div class="choose-shape-wrap">
            <img src="<?= base_url() ?>assets/img/images/h2_services_shape01.png" alt="" data-aos="fade-right" data-aos-delay="400">
            <img src="<?= base_url() ?>assets/img/images/h2_services_shape02.png" alt="" data-aos="fade-left" data-aos-delay="400">
        </div>
    </section>
    <!-- choose-area-end -->
    <!-- testimonial-area -->
    <section class="testimonial__area-four testimonial__bg testimonial__bg-two" data-background="<?= base_url() ?>assets/img/bg/h3_testimonial_bg.jpg">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-lg-5 col-md-8">
                    <div class="testimonial__img-wrap-two">
                        <img src="<?= base_url() ?>assets/img/inkopkar/baru/about2.jpg" alt="">
                        <div class="testimonial__img-shape-two">
                            <!-- <img src="<?= base_url() ?>assets/img/images/h3_testimonial_shape01.png" alt="" class="alltuchtopdown">
                            <img src="<?= base_url() ?>assets/img/images/inner_testimonial_shape.png" alt="" class="rotateme">
                            <img src="<?= base_url() ?>assets/img/images/h3_testimonial_shape03.png" alt=""> -->
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="choose-content">
                        <div class="section-title  mb-25">
                            <span class="sub-title">Visi Dan Misi</span>
                            <h2 class="title">Apa Visi INKOPKAR?</h2>
                        </div>
                        <p style="text-align: justify; color: #014A41">Menjadi koperasi terkemuka yang mendukung pemberdayaan ekonomi karyawan Indonesia.</p>
                        <div class="section-title  mb-25">
                            <!-- <span class="sub-title">Visi Dan Misi</span> -->
                            <h4 class="title">Apa Misi INKOPKAR?</h4>
                        </div>
                        <div class="about__content-inner-four">
                            <div class="about__list-box">
                                <ul class="list-wrap">
                                    <li><i class="flaticon-arrow-button"></i>Memberikan layanan terbaik dalam pengelolaan keuangan koperasi.</li>
                                    <li><i class="flaticon-arrow-button"></i>Mengembangkan peluang usaha yang berorientasi pada kesejahteraan anggota.</li>
                                    <li><i class="flaticon-arrow-button"></i>Menyediakan pelatihan dan edukasi untuk meningkatkan keterampilan dan
                                        profesionalitas anggota koperasi.</li>
                                    <li><i class="flaticon-arrow-button"></i>Menjaga nilai-nilai gotong royong dan keadilan dalam setiap program kerja.</li>
                                </ul>
                            </div>
                            <!-- <div class="about__list-img-three">
                                <img src="<?= base_url() ?>assets/img/images/about_list_img03.png" alt="">
                                <a href="https://www.youtube.com/watch?v=6mkoGSqTqFI" class="play-btn popup-video"><i class="fas fa-play"></i></a>
                            </div> -->
                        </div>
                        <a href="<?= base_url('contact') ?> " class="btn btn-one">Quick Contact Us</a>
                    </div>
                </div>

            </div>
        </div>
    </section>
    <!-- testimonial-area-end -->


    <!-- about-area -->
    <!-- <section class="about__area-six">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 order-0 order-lg-2">
                    <div class="choose-img-wrap">
                        <img src="<?= base_url() ?>assets/img/images/choose_img01.jpg" alt="">
                        <img src="<?= base_url() ?>assets/img/images/choose_img02.jpg" alt="" data-parallax='{"x" : 50 }'>
                        <img src="<?= base_url() ?>assets/img/images/choose_img_shape.png" alt="" class="alltuchtopdown">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="about__content-six">
                        <div class="section-title mb-30">
                            <span class="sub-title">Why We Are The Best</span>
                            <h2 class="title">We Offer Business Insight <br> World Class Consulting</h2>
                        </div>
                        <p>We successfully cope with tasks of varying complexity provide area longerty guarantees and regularly master new Practice Following gies heur portfolio includes dozen.</p>
                        <div class="choose-list">
                            <ul class="list-wrap">
                                <li>
                                    <div class="icon">
                                        <i class="flaticon-investment"></i>
                                    </div>
                                    <div class="">
                                        <h4 class="title">Business Solutions</h4>
                                        <p>Semper egetuis kelly for tellus urna area condition.</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="flaticon-investment-1"></i>
                                    </div>
                                    <div class="">
                                        <h4 class="title">Market Analysis</h4>
                                        <p>Semper egetuis kelly for tellus urna area condition.</p>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="about__shape-wrap-four">
            <img src="<?= base_url() ?>assets/img/images/h4_about_shape01.png" alt="">
            <img src="<?= base_url() ?>assets/img/images/h4_about_shape02.png" alt="" data-parallax='{"x" : -80 , "y" : -80 }'>
        </div>
    </section> -->
    <!-- about-area-end -->
    <!-- pricing-area -->
    <!-- <section class="pricing__area pricing__bg" data-background="<?= base_url() ?>assets/img/bg/pricing_bg.jpg">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-5">
                    <div class="section-title text-center mb-30">
                        <span class="sub-title">Flexible Pricing Plan</span>
                        <h2 class="title">We’ve Offered The Best Pricing For You</h2>
                    </div>
                </div>
            </div>
            <div class="pricing__item-wrap">
                <div class="pricing__tab">
                    <span class="pricing__tab-btn monthly_tab_title">Monthly</span>
                    <span class="pricing__tab-switcher"></span>
                    <span class="pricing__tab-btn annual_tab_title">Yearly</span>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="pricing__box">
                            <div class="pricing__head">
                                <h5 class="title">Basic Plan</h5>
                            </div>
                            <div class="pricing__price">
                                <h2 class="price monthly_price"><strong>$</strong> 15.00 <span>/ Month</span></h2>
                                <h2 class="price annual_price"><strong>$</strong> 149.00 <span>/ Month</span></h2>
                            </div>
                            <div class="pricing__list">
                                <ul class="list-wrap">
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        5000 User Activities
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        Unlimited Access
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        No Hidden Charge
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        03 Time Updates
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        Figma Source File
                                    </li>
                                </ul>
                            </div>
                            <div class="pricing__btn">
                                <a href="javascript:void(0)" class="btn">Get this plan Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="pricing__box">
                            <div class="pricing__head">
                                <h5 class="title">Standard Plan</h5>
                            </div>
                            <div class="pricing__price">
                                <h2 class="price monthly_price"><strong>$</strong> 29.00 <span>/ Month</span></h2>
                                <h2 class="price annual_price"><strong>$</strong> 229.00 <span>/ Month</span></h2>
                            </div>
                            <div class="pricing__list">
                                <ul class="list-wrap">
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        5000 User Activities
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        Unlimited Access
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        No Hidden Charge
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        03 Time Updates
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        Figma Source File
                                    </li>
                                </ul>
                            </div>
                            <div class="pricing__btn">
                                <a href="javascript:void(0)" class="btn">Get this plan Now</a>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6 col-sm-8">
                        <div class="pricing__box">
                            <div class="pricing__head">
                                <h5 class="title">Corporate Plan</h5>
                            </div>
                            <div class="pricing__price">
                                <h2 class="price monthly_price"><strong>$</strong> 89.00 <span>/ Month</span></h2>
                                <h2 class="price annual_price"><strong>$</strong> 889.00 <span>/ Month</span></h2>
                            </div>
                            <div class="pricing__list">
                                <ul class="list-wrap">
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        5000 User Activities
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        Unlimited Access
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        No Hidden Charge
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        03 Time Updates
                                    </li>
                                    <li>
                                        <img src="<?= base_url() ?>assets/img/icon/check_icon.svg" alt="">
                                        Figma Source File
                                    </li>
                                </ul>
                            </div>
                            <div class="pricing__btn">
                                <a href="javascript:void(0)" class="btn">Get this plan Now</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pricing__shape-wrap">
            <img src="<?= base_url() ?>assets/img/images/pricing_shape01.png" alt="" data-aos="fade-right" data-aos-delay="400">
            <img src="<?= base_url() ?>assets/img/images/pricing_shape02.png" alt="" data-aos="fade-left" data-aos-delay="400">
        </div>
    </section> -->
    <!-- pricing-area-end -->
    <!-- brand-area -->
    <!-- <div class="brand__area-two">
        <div class="container">
            <div class="swiper-container brand-active">
                <div class="swiper-wrapper">
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="<?= base_url() ?>assets/img/brand/brand_img01.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="<?= base_url() ?>assets/img/brand/brand_img02.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="<?= base_url() ?>assets/img/brand/brand_img03.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="<?= base_url() ?>assets/img/brand/brand_img04.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="<?= base_url() ?>assets/img/brand/brand_img05.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="<?= base_url() ?>assets/img/brand/brand_img06.png" alt="">
                        </div>
                    </div>
                    <div class="swiper-slide">
                        <div class="brand-item">
                            <img src="<?= base_url() ?>assets/img/brand/brand_img03.png" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div> -->
    <!-- brand-area -->
</main>
<!-- main-area-end -->