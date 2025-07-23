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
                    <h3>Account Profile</h3>
                    <p class="text-subtitle text-muted">A page where users can change profile information</p>
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="index.html">Dashboard</a></li>
                            <li class="breadcrumb-item">Account</li>
                            <li class="breadcrumb-item active" aria-current="page">Profile</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section class="section">
            <div class="row">
                <div class="col-12 col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <div class="d-flex justify-content-center align-items-center flex-column">
                                <div class="avatar avatar-2xl">
                                    <img src="<?= base_url('/assets/admin/compiled/jpg/') ?>2.jpg" alt="Avatar">
                                </div>

                                <h3 class="mt-3"><?= $detail->nama ?></h3>
                                <p class="text-small"><?= $detail->nomor_anggota ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-lg-8">
                    <div class="card">
                        <div class="card-body">
                            <form id="form-profile" method="get">
                                <input type="hidden" name="id_anggota" value="<?= $detail->id ?>">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="name" class="form-label">Name</label>
                                            <input type="text" name="nama" id="nama" class="form-control" placeholder="Your Name" value="<?= $detail->nama ?>">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="email" class="form-label">Tempat Lahir</label>
                                            <input type="text" name="tempat_lahir" id="tempat_lahir" class="form-control" placeholder="Your Birth Place" value="<?= $detail->tempat_lahir ?>">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="phone" class="form-label">Tanggal Lahir</label>
                                            <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" placeholder="Your Birth Date" value="<?= $detail->tanggal_lahir ?>">
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label for="birthday" class="form-label">Nomor Telpon</label>
                                        <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="Your Phone Number" value="<?= $detail->no_telp ?>" readonly>
                                    </div>
                                    <div class="form-group">
                                        <label for="gender" class="form-label">Password</label>
                                        <div class="row">
                                            <div class="col-11">
                                                <input type="password" name="password" id="password" class="form-control" placeholder="Your Password">
                                            </div>
                                            <div class="col-1">
                                                <a class="btn btn-secondary" id="togglePassword">
                                                    <i class="bi bi-eye-fill" id="toggleIcon"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <div class="form-group">
                                <button type="submit" class="btn btn-primary" onclick="save(event)">Save Changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>