<body>
    <script src="<?= base_url() ?>assets/admin/static/js/initTheme.js"></script>
    <div id="app">
        <div id="sidebar">
            <div class="sidebar-wrapper active">
                <div class="sidebar-header position-relative">
                    <div class="d-flex justify-content-between align-items-center">
                        <div class="logo">
                            <a href="<?= base_url('dashboard') ?>"><img style="height: 3rem" src="<?= base_url() ?>assets/admin/logo/logo.gif" alt="Logo" srcset=""></a>
                        </div>
                        <div class="theme-toggle d-flex gap-2  align-items-center mt-2">
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--system-uicons" width="20" height="20"
                                preserveAspectRatio="xMidYMid meet" viewBox="0 0 21 21">
                                <g fill="none" fill-rule="evenodd" stroke="currentColor" stroke-linecap="round"
                                    stroke-linejoin="round">
                                    <path
                                        d="M10.5 14.5c2.219 0 4-1.763 4-3.982a4.003 4.003 0 0 0-4-4.018c-2.219 0-4 1.781-4 4c0 2.219 1.781 4 4 4zM4.136 4.136L5.55 5.55m9.9 9.9l1.414 1.414M1.5 10.5h2m14 0h2M4.135 16.863L5.55 15.45m9.899-9.9l1.414-1.415M10.5 19.5v-2m0-14v-2"
                                        opacity=".3"></path>
                                    <g transform="translate(-210 -1)">
                                        <path d="M220.5 2.5v2m6.5.5l-1.5 1.5"></path>
                                        <circle cx="220.5" cy="11.5" r="4"></circle>
                                        <path d="m214 5l1.5 1.5m5 14v-2m6.5-.5l-1.5-1.5M214 18l1.5-1.5m-4-5h2m14 0h2"></path>
                                    </g>
                                </g>
                            </svg>
                            <div class="form-check form-switch fs-6">
                                <input class="form-check-input  me-0" type="checkbox" id="toggle-dark" style="cursor: pointer">
                                <label class="form-check-label"></label>
                            </div>
                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" aria-hidden="true"
                                role="img" class="iconify iconify--mdi" width="20" height="20" preserveAspectRatio="xMidYMid meet"
                                viewBox="0 0 24 24">
                                <path fill="currentColor"
                                    d="m17.75 4.09l-2.53 1.94l.91 3.06l-2.63-1.81l-2.63 1.81l.91-3.06l-2.53-1.94L12.44 4l1.06-3l1.06 3l3.19.09m3.5 6.91l-1.64 1.25l.59 1.98l-1.7-1.17l-1.7 1.17l.59-1.98L15.75 11l2.06-.05L18.5 9l.69 1.95l2.06.05m-2.28 4.95c.83-.08 1.72 1.1 1.19 1.85c-.32.45-.66.87-1.08 1.27C15.17 23 8.84 23 4.94 19.07c-3.91-3.9-3.91-10.24 0-14.14c.4-.4.82-.76 1.27-1.08c.75-.53 1.93.36 1.85 1.19c-.27 2.86.69 5.83 2.89 8.02a9.96 9.96 0 0 0 8.02 2.89m-1.64 2.02a12.08 12.08 0 0 1-7.8-3.47c-2.17-2.19-3.33-5-3.49-7.82c-2.81 3.14-2.7 7.96.31 10.98c3.02 3.01 7.84 3.12 10.98.31Z">
                                </path>
                            </svg>
                        </div>
                        <div class="sidebar-toggler  x">
                            <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
                        </div>
                    </div>
                </div>
                <div class="sidebar-menu">
                    <ul class="menu">
                        <?php
                        $url_now = $this->uri->segment('1');
                        ?>
                        <li class="sidebar-title">Menu</li>

                        <li
                            class="sidebar-item <?php if ($url_now == 'dashboard') {
                                                    echo 'active ';
                                                } ?> ">
                            <a href="<?= base_url('dashboard') ?>" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Dashboard</span>
                            </a>


                        </li>



                        <li class="sidebar-title">Sistem</li>

                        <!-- <li
                            class="sidebar-item <?php if ($url_now == 'Koperasi_Management') {
                                                    echo 'active ';
                                                } ?>">
                            <a href="<?= base_url('Koperasi_Management') ?>" class='sidebar-link'>
                                <i class="bi bi-grid-fill"></i>
                                <span>Koperasi Management</span>
                            </a>
                        </li> -->

                        <?php
                        if ($this->session->userdata('role') == "Anggota") {
                        ?>
                            <li
                                class="sidebar-item <?php if ($url_now == 'kebutuhan') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('kebutuhan') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Kebutuhan</span>
                                </a>
                            </li>
                        <?php
                        } else if ($this->session->userdata('role') == "Koperasi") {
                        ?>
                            <li
                                class="sidebar-item <?php if ($url_now == 'kebutuhan') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('kebutuhan/laporan') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Kebutuhan</span>
                                </a>
                            </li>
                        <?php
                        }
                        ?>

                        <?php
                        if ($this->session->userdata('role') == "Admin") {
                        ?>
                            <li
                                class="sidebar-item <?php if ($url_now == 'Koperasi_Management' || $url_now == 'Toko_Management') {
                                                        echo 'active ';
                                                    } ?> has-sub">
                                <a href="#" class='sidebar-link'>
                                    <i class="bi bi-stack"></i>
                                    <span>Koperasi</span>
                                </a>

                                <ul class="submenu">
                                    <li class="submenu-item <?php if ($url_now == 'Koperasi_Management') {
                                                                echo 'active ';
                                                            } ?>">
                                        <a href="<?= base_url('Koperasi_Management') ?>" class="submenu-link">Manajemen Koperasi</a>

                                    </li>

                                    <li class="submenu-item <?php if ($url_now == 'Toko_Management') {
                                                                echo 'active ';
                                                            } ?>">
                                        <a href="<?= base_url('Toko_Management') ?>" class="submenu-link">Manajemen Toko</a>

                                    </li>

                                </ul>


                            </li>
                        <?php
                        }
                        ?>

                        <li
                            class="sidebar-item <?php if ($url_now == 'Riwayat_Kasir') {
                                                    echo 'active ';
                                                } ?> has-sub">
                            <a href="#" class='sidebar-link'>
                                <i class="bi bi-stack"></i>
                                <span>Riwayat</span>
                            </a>

                            <ul class="submenu">
                                <?php
                                if ($this->session->userdata('role') != "Puskopkar") {
                                ?>
                                    <li class="submenu-item <?php if ($url_now == 'Riwayat_Kasir/detail') {
                                                                echo 'active ';
                                                            } ?>">
                                        <a href="<?= base_url('Riwayat_Kasir/detail') ?>" class="submenu-link">Penjualan Kredit</a>

                                    </li>

                                <?php
                                }
                                ?>
                                <?php
                                if ($this->session->userdata('role') == "Admin" || $this->session->userdata('role') == "Koperasi") {
                                ?>
                                    <li class="submenu-item <?php if ($url_now == 'Riwayat_Kasir/detail_pembayaran') {
                                                                echo 'active ';
                                                            } ?>">
                                        <a href="<?= base_url('Riwayat_Kasir/detail_pembayaran') ?>" class="submenu-link">Riwayat Pembayaran</a>

                                    </li>
                                <?php
                                }
                                ?>
                                <?php
                                if ($this->session->userdata('role') == "Admin") {
                                ?>
                                    <li class="submenu-item <?php if ($url_now == 'Riwayat_Kasir/detail_transaksi_inkopkar') {
                                                                echo 'active ';
                                                            } ?>">
                                        <a href="<?= base_url('Riwayat_Kasir/detail_transaksi_inkopkar') ?>" class="submenu-link">Riwayat Transaksi Inkopkar</a>

                                    </li>
                                <?php
                                }
                                ?>
                                <?php
                                if ($this->session->userdata('role') == "Admin" || $this->session->userdata('role') == "Koperasi") {
                                ?>
                                    <!-- <li class="submenu-item <?php if ($url_now == 'Riwayat_Kasir/detail_pencairan') {
                                                                        echo 'active ';
                                                                    } ?>">
                                        <a href="<?= base_url('Riwayat_Kasir/detail_pencairan') ?>" class="submenu-link">Riwayat Pencairan</a>

                                    </li> -->
                                <?php
                                }
                                ?>
                                <?php
                                if ($this->session->userdata('role') == "Admin" || $this->session->userdata('role') == "Koperasi" || $this->session->userdata('role') == "Puskopkar" || $this->session->userdata('role') == "Anggota") {
                                ?>
                                    <li class="submenu-item <?php if ($url_now == 'Riwayat_Kasir/detail_saldo_simpanan') {
                                                                echo 'active ';
                                                            } ?>">
                                        <a href="<?= base_url('Riwayat_Kasir/detail_saldo_simpanan') ?>" class="submenu-link">Riwayat Saldo Simpanan</a>

                                    </li>
                                    <li class="submenu-item <?php if ($url_now == 'Riwayat_Kasir/detail_saldo_pinjaman') {
                                                                echo 'active ';
                                                            } ?>">
                                        <a href="<?= base_url('Riwayat_Kasir/detail_saldo_pinjaman') ?>" class="submenu-link">Riwayat Saldo Pinjaman</a>

                                    </li>
                                <?php
                                }
                                ?>

                            </ul>
                        </li>
                        <?php
                        if ($this->session->userdata('role') == "Admin" || $this->session->userdata('role') == "Koperasi" || $this->session->userdata('role') == "Puskopkar") {
                        ?>
                            </li>

                            <?php
                            if ($this->session->userdata('role') == "Puskopkar") {
                            ?>
                                <li
                                    class="sidebar-item <?php if ($url_now == 'Koperasi_Management') {
                                                            echo 'active ';
                                                        } ?>">
                                    <a href="<?= base_url('Koperasi_Management') ?>" class='sidebar-link'>
                                        <i class="bi bi-grid-fill"></i>
                                        <span>Manajemen Anggota</span>
                                    </a>
                                </li>
                            <?php
                            } else {
                            ?>
                                <li
                                    class="sidebar-item <?php if ($url_now == 'Anggota_Management') {
                                                            echo 'active ';
                                                        } ?>">
                                    <a href="<?= base_url('Anggota_Management') ?>" class='sidebar-link'>
                                        <i class="bi bi-grid-fill"></i>
                                        <span>Manajemen Anggota</span>
                                    </a>
                                </li>
                            <?php
                            }
                            ?>
                        <?php
                        }
                        ?>
                        <?php
                        if ($this->session->userdata('role') == "Admin" || $this->session->userdata('role') == "Koperasi" || $this->session->userdata('role') == "Kasir") {
                        ?>
                            <li
                                class="sidebar-item <?php if ($url_now == 'Nota_Management/add') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('Nota_Management/add') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Belanja Kredit</span>
                                </a>
                            </li>
                        <?php
                        }
                        ?>
                        </li>
                        <?php
                        if ($this->session->userdata('role') == "Admin" || $this->session->userdata('role') == "Koperasi") {
                        ?>
                            <li
                                class="sidebar-item <?php if ($url_now == 'Nota_Management/add_pembayaran') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('Nota_Management/add_pembayaran') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Pembayaran Belanja</span>
                                </a>
                            </li>

                        <?php
                        }
                        if ($this->session->userdata('role') == "Koperasi") {
                        ?>
                            <!-- <li
                                class="sidebar-item <?php if ($url_now == 'Nota_Management/add_iuran') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('Nota_Management/add_iuran') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Pencairan</span>
                                </a>
                            </li> -->
                        <?php
                        }
                        ?>
                        <?php
                        if ($this->session->userdata('role') == "Puskopkar") {
                        ?>
                            <li class="sidebar-item <?php if ($url_now == 'iuran/') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('iuran/') ?>" class="sidebar-link">
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Iuran</span>
                                </a>

                            </li>
                        <?php
                        }
                        ?>
                        <?php
                        // if ($this->session->userdata('role') == "Puskopkar" || $this->session->userdata('role') == "Koperasi" || $this->session->userdata('role') == "Admin") {
                        if ($this->session->userdata('role') == "Admin" || $this->session->userdata('role') == "Koperasi") {
                        ?>
                            <li
                                class="sidebar-item <?php if ($url_now == 'Saldo_Simpanan/add_simpanan') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('Saldo_Simpanan/add_simpanan') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Tambah Saldo Simpanan</span>
                                </a>
                            </li>
                            <!-- <li
                                class="sidebar-item <?php if ($url_now == 'Saldo_Pinjaman/add_pinjaman') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('Saldo_Pinjaman/add_pinjaman') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Tambah Saldo Pinjaman</span>
                                </a>
                            </li> -->
                        <?php
                        }
                        ?>
                        <?php
                        if ($this->session->userdata('role') == "Admin") {
                        ?>
                            <li class="sidebar-title">Manajemen Halaman</li>

                            <li
                                class="sidebar-item <?php if ($url_now == 'Gallery_Management') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('Gallery_Management') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Manajemen Galeri</span>
                                </a>


                            </li>
                            <li
                                class="sidebar-item <?php if ($url_now == 'Artikel_Management') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('Artikel_Management') ?>" class='sidebar-link'>
                                    <i class="bi bi-grid-fill"></i>
                                    <span>Manajemen Artikel</span>
                                </a>


                            </li>
                            <li class="sidebar-title">Utility</li>

                            <li
                                class="sidebar-item <?php if ($url_now == 'utility') {
                                                        echo 'active ';
                                                    } ?>">
                                <a href="<?= base_url('utility') ?>" class='sidebar-link'>
                                    <i class="bi bi-gear"></i>
                                    <span>Utility</span>
                                </a>


                            </li>
                        <?php
                        }
                        ?>
                        <li class="sidebar-title">Account</li>
                        <li
                            class="sidebar-item <?php if ($url_now == 'profile') {
                                                    echo 'active ';
                                                } ?>">
                            <a href="<?= base_url('Profile') ?>" class='sidebar-link'>
                                <i class="bi bi-person-square"></i>
                                <span>Profile</span>
                            </a>


                        </li>
                        <li
                            class="sidebar-item <?php if ($url_now == 'logout') {
                                                    echo 'active ';
                                                } ?>">
                            <a href="<?= base_url('auth/logout') ?>" class='sidebar-link'>
                                <i class="bi bi-box-arrow-left"></i>
                                <span>Logout</span>
                            </a>


                        </li>
                    </ul>
                </div>
            </div>
        </div>