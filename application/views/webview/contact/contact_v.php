<!-- main-area -->
<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="<?= base_url() ?>assets/img/bg/breadcrumb_bg.jpg">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">Contact With Us</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="index.html">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Contact</li>
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
    <!-- contact-area -->
    <section class="contact__area">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="contact-map">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3152.332792000835!2d144.96011341744386!3d-37.805673299999995!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x6ad65d4c2b349649%3A0xb6899234e561db11!2sEnvato!5e0!3m2!1sen!2sbd!4v1685027435635!5m2!1sen!2sbd" allowfullscreen loading="lazy"></iframe>
                    </div>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-5">
                    <div class="contact__content">
                        <div class="section-title mb-35">
                            <h2 class="title">How can we help you?</h2>
                            <p>When an unknown printer took a galley of type and scrambled it to make type pecimen book. It has survived not only five areafact types remaining essentially unchangedIt</p>
                        </div>
                        <div class="contact__info">
                            <ul class="list-wrap">
                                <li>
                                    <div class="icon">
                                        <i class="flaticon-pin"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">Address</h4>
                                        <p>Awamileaug Drive, Kensington London, UK</p>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="flaticon-phone-call"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">Phone</h4>
                                        <a href="tel:0123456789">+48 500-130-0001</a>
                                    </div>
                                </li>
                                <li>
                                    <div class="icon">
                                        <i class="flaticon-mail"></i>
                                    </div>
                                    <div class="content">
                                        <h4 class="title">E-mail</h4>
                                        <a href="mailto:info@gmail.com">info@gmail.com</a>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact__form-wrap">
                        <h2 class="title">Give Us a Message</h2>
                        <p>Your email address will not be published. Required fields are marked *</p>
                        <form id="contact-form" action="<?= base_url() ?>assets/mail.php" method="POST">
                            <div class="form-grp">
                                <textarea name="message" placeholder="Message"></textarea>
                            </div>
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-grp">
                                        <input type="text" name="name" placeholder="Name">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-grp">
                                        <input type="email" name="email" placeholder="Email">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-grp">
                                        <input type="number" name="phone" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                            <div class="form-grp checkbox-grp">
                                <input type="checkbox" name="checkbox" id="checkbox">
                                <label for="checkbox">Save my name, email, and website in this browser for the next time I comment.</label>
                            </div>
                            <button type="submit" class="btn">Submit post</button>
                        </form>
                        <p class="ajax-response mb-0"></p>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- contact-area-end -->
    <!-- call-back-area -->
    <section class="call-back-area">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="call-back-content">
                        <div class="section-title white-title mb-10">
                            <h2 class="title">Request A Call Back</h2>
                        </div>
                        <p>Ever find yourself staring at your computer screen a good consulting slogan to come to mind? Oftentimes.</p>
                        <div class="shape">
                            <img src="<?= base_url() ?>assets/img/images/call_back_shape.png" alt="" data-aos="fade-right" data-aos-delay="400">
                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="call-back-form">
                        <form action="#">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-grp">
                                        <input type="text" placeholder="Name *">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-grp">
                                        <input type="email" placeholder="E-mail *">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-grp">
                                        <input type="number" placeholder="Phone *">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <button type="submit" class="btn">Send Now</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- call-back-area-end -->
</main>
<!-- main-area-end -->