<!-- main-area -->
<main class="fix">
    <!-- breadcrumb-area -->
    <section class="breadcrumb__area breadcrumb__bg" data-background="<?= base_url() ?>assets/img/inkopkar/blog.png">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="breadcrumb__content">
                        <h2 class="title">Artikel Details</h2>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="<?= base_url() ?>">Home</a></li>
                                <li class="breadcrumb-item active" aria-current="page">Artikel Details</li>
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
    <!-- blog-details-area -->
    <section class="blog__details-area">
        <div class="container">
            <div class="blog__inner-wrap">
                <div class="row">
                    <div class="col-70">
                        <div class="blog__details-wrap">
                            <div class="blog__details-thumb">
                                <img src="<?= base_url('uploads/artikel/' . $detail->thumbnail) ?>" alt="">
                            </div>
                            <div class="blog__details-content">
                                <h2 class="title"><?= $detail->title ?></h2>
                                <div class="blog-post-meta">
                                    <ul class="list-wrap">
                                        <!-- <li><a href="blog.html" class="blog__post-tag-two">Business</a></li> -->
                                        <!-- <li>
                                            <div class="blog-avatar">
                                                <div class="avatar-thumb">
                                                    <img src="<?= base_url() ?>assets/img/blog/blog_avatar01.png" alt="">
                                                </div>
                                                <div class="avatar-content">
                                                    <p>By <a href="blog-details.html">Doman Smith</a></p>
                                                </div>
                                            </div>
                                        </li> -->
                                        <li><i class="fas fa-calendar-alt"></i><?= $detail->tanggal ?></li>
                                        <!-- <li><i class="far fa-comment"></i><a href="blog-details.html">05 Comments</a></li> -->
                                    </ul>
                                </div>
                                <p><?= $detail->text ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-30">
                        <aside class="blog__sidebar">
                            <!-- <div class="sidebar__widget sidebar__widget-two">
                                <div class="sidebar__search">
                                    <form action="#">
                                        <input type="text" placeholder="Search . . .">
                                        <button type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="none">
                                                <path d="M19.0002 19.0002L14.6572 14.6572M14.6572 14.6572C15.4001 13.9143 15.9894 13.0324 16.3914 12.0618C16.7935 11.0911 17.0004 10.0508 17.0004 9.00021C17.0004 7.9496 16.7935 6.90929 16.3914 5.93866C15.9894 4.96803 15.4001 4.08609 14.6572 3.34321C13.9143 2.60032 13.0324 2.01103 12.0618 1.60898C11.0911 1.20693 10.0508 1 9.00021 1C7.9496 1 6.90929 1.20693 5.93866 1.60898C4.96803 2.01103 4.08609 2.60032 3.34321 3.34321C1.84288 4.84354 1 6.87842 1 9.00021C1 11.122 1.84288 13.1569 3.34321 14.6572C4.84354 16.1575 6.87842 17.0004 9.00021 17.0004C11.122 17.0004 13.1569 16.1575 14.6572 14.6572Z" stroke="currentcolor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </div> -->
                            <div class="sidebar__widget">
                                <h4 class="sidebar__widget-title">Latest Posts</h4>
                                <div class="sidebar__post-list">
                                    <?php
                                    if (!empty($recent)) {
                                        foreach ($recent as $r) {

                                    ?>
                                            <div class="sidebar__post-item">
                                                <div class="sidebar__post-thumb">
                                                    <a href="blog-details.html"><img src="<?= base_url('uploads/artikel/' . $r->thumbnail) ?>" alt=""></a>
                                                </div>
                                                <div class="sidebar__post-content">
                                                    <h5 class="title"><a href="<?= base_url('artikel/detail/' . $r->Id) ?>"><?= $r->title ?></a></h5>
                                                    <span class="date"><i class="flaticon-time"></i><?= $r->tanggal ?></span>
                                                </div>
                                            </div>
                                    <?php

                                        }
                                    }
                                    ?>
                                </div>
                            </div>
                        </aside>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- blog-details-area-end -->
</main>
<!-- main-area-end -->