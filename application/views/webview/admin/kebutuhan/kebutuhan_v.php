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
                            <li class="breadcrumb-item active" aria-current="page">Tambah Koperasi</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>
        <section id="multiple-column-form">
            <div class="row match-height">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4 class="card-title">Form Input Kebutuhan</h4>
                        </div>
                        <div class="card-body">
                            <?php if ($this->session->flashdata('success')): ?>
                                <div class="alert alert-success" role="alert"><?php echo $this->session->flashdata('success'); ?></div>
                            <?php endif; ?>
                            <?php if (validation_errors()): ?>
                                <div class="alert alert-danger" role="alert"><?php echo validation_errors(); ?></div>
                            <?php endif; ?>

                            <?php echo form_open('kebutuhan/simpan'); ?>

                            <div class="mb-3">
                                <label for="nama_anggota" class="form-label">Nama Anggota:</label>
                                <input type="text" class="form-control" id="nama_anggota" name="nama_anggota" value="<?= $this->session->userdata('name') ?>" readonly>
                            </div>
                            <hr>

                            <div id="items-container">
                                <?php
                                $itemIndex = 0; // Inisialisasi index untuk nama array
                                if (!empty($detail_kebutuhan)):
                                    foreach ($detail_kebutuhan as $detail):
                                ?>
                                        <div class="item-row row g-2 align-items-center mb-3 border-bottom pb-3">
                                            <input type="hidden" name="items[<?php echo $itemIndex; ?>][id]" value="<?php echo $detail['id']; ?>">

                                            <div class="col-md-6">
                                                <label class="form-label">Pilih Item</label>
                                                <select class="form-select item-select" name="items[<?php echo $itemIndex; ?>][name]">
                                                    <option disabled value="">-- Pilih Kebutuhan --</option>
                                                    <?php foreach ($kebutuhan_list as $item_name => $item_details): ?>
                                                        <option value="<?php echo $item_name; ?>" <?php echo ($item_name == $detail['nama_kebutuhan']) ? 'selected' : ''; ?>>
                                                            <?php echo $item_name; ?>
                                                        </option>
                                                    <?php endforeach; ?>
                                                </select>
                                            </div>
                                            <div class="col-md-4">
                                                <label class="form-label">Jumlah</label>
                                                <div class="input-group">
                                                    <input type="number" class="form-control item-quantity" name="items[<?php echo $itemIndex; ?>][quantity]" placeholder="Jumlah" min="0" step="0.1" value="<?php echo $detail['jumlah']; ?>">
                                                    <span class="input-group-text item-unit"><?php echo $detail['satuan']; ?></span>
                                                </div>
                                            </div>
                                            <div class="col-md-2">
                                                <label class="form-label">Action</label>
                                                <div class="input-group">
                                                    <button type="button" class="btn btn-danger remove-item-btn">Hapus</button>
                                                </div>
                                            </div>
                                            <div class="col-md-12 mt-2 item-extra-options" style="<?php echo ($detail['nama_kebutuhan'] == 'Beras') ? '' : 'display: none;'; ?>">
                                                <?php if ($detail['nama_kebutuhan'] == 'Beras'): ?>
                                                    <div class="row">
                                                        <div class="col-md-8 offset-md-4">
                                                            <label class="form-label">Pilih Tipe</label>
                                                            <select class="form-select item-type-select" name="items[<?php echo $itemIndex; ?>][type]">
                                                                <?php foreach ($kebutuhan_list['Beras']['types'] as $type_val => $type_label): ?>
                                                                    <option value="<?php echo $type_val; ?>" <?php echo ($type_val == $detail['tipe_kebutuhan']) ? 'selected' : ''; ?>>
                                                                        <?php echo $type_label; ?>
                                                                    </option>
                                                                <?php endforeach; ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                <?php
                                        $itemIndex++; // Naikkan index untuk baris berikutnya
                                    endforeach;
                                endif;
                                ?>
                            </div>
                            <div class="mt-3">
                                <button type="button" class="btn btn-primary" id="add-item-btn">+ Tambah Item</button>
                            </div>

                            <hr>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                            </div>

                            <?php echo form_close(); ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <template id="item-template">
            <div class="item-row row g-2 align-items-center mb-3 border-bottom pb-3">
                <input type="hidden" name="items[0][id]" value="">

                <div class="col-md-6">
                    <label class="form-label">Pilih Item</label>
                    <select class="form-select item-select" name="items[0][name]">
                        <option selected disabled value="">-- Pilih Kebutuhan --</option>
                        <?php foreach ($kebutuhan_list as $item => $details): ?>
                            <option value="<?php echo $item; ?>"><?php echo $item; ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-4">
                    <label class="form-label">Jumlah</label>
                    <div class="input-group">
                        <input type="number" class="form-control item-quantity" name="items[0][quantity]" placeholder="Jumlah" min="0" step="0.1" disabled>
                        <span class="input-group-text item-unit"></span>
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">Action</label>
                    <div class="input-group">
                        <button type="button" class="btn btn-danger remove-item-btn">Hapus</button>
                    </div>
                </div>
                <div class="col-md-12 mt-2 item-extra-options" style="display: none;"></div>
            </div>
        </template>
    </div>