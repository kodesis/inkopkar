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
                    <h3>Form Verifikasi</h3>
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
                        <div class="card-header">
                            <h4 class="card-title">Tambah Nota</h4>
                        </div>
                        <div class="card-content">
                            <div class="card-body">
                                <form class="form" id="add_Nota">
                                    <input type="hidden" name="id_nota" value="<?= $this->uri->segment(3) ?>">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="email-id-vertical">Token</label>
                                                <input type="number" class="form-control" id="token" name="token" placeholder="Token">
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
                                    <button type="submit" onclick="verifikasi_Nota(event)" class="btn btn-primary me-1 mb-1">Submit</button>
                                    <button type="reset" onclick="reset_Nota()" class="btn btn-light-secondary me-1 mb-1">Reset</button>
                                    <a href="<?= base_url('Nota_Management') ?>" class="btn btn-warning me-1 mb-1">Back</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- // Basic multiple Column Form section end -->
    </div>