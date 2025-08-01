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
                    <h3>Table Kebutuhan List</h3>
                    <!-- <p class="text-subtitle text-muted">Powerful interactive tables with datatables (jQuery required).</p> -->
                </div>
                <div class="col-12 col-md-6 order-md-2 order-first">
                    <nav aria-label="breadcrumb" class="breadcrumb-header float-start float-lg-end">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?= base_url('dashboard') ?>">Dashboard</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Kebutuhan List</li>
                        </ol>
                    </nav>
                </div>
            </div>
        </div>

        <section class="section">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">Laporan Kebutuhan Anggota (Pivot)</h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="table_laporan">
                            <thead>
                                <tr>
                                    <th class="text-center">No</th>
                                    <th>Nama Anggota</th>
                                    <?php foreach ($item_headers as $header): ?>
                                        <th class="text-center"><?= htmlspecialchars($header, ENT_QUOTES, 'UTF-8'); ?></th>
                                    <?php endforeach; ?>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $no = 1;
                                foreach ($pivoted_data as $nama_anggota => $kebutuhan):
                                ?>
                                    <tr>
                                        <td class="text-center"><?= $no++; ?></td>
                                        <td><?= htmlspecialchars($nama_anggota, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <?php
                                        foreach ($item_headers as $header):
                                            $jumlah = isset($kebutuhan[$header]) ? $kebutuhan[$header] : '-';
                                        ?>
                                            <td class="text-center"><?= htmlspecialchars($jumlah, ENT_QUOTES, 'UTF-8'); ?></td>
                                        <?php endforeach; ?>
                                    </tr>
                                <?php endforeach; ?>

                                <?php if (empty($pivoted_data)): ?>
                                    <tr>
                                        <td colspan="<?= count($item_headers) + 2 ?>" class="text-center">Tidak ada data untuk bulan yang dipilih.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                            <tfoot>
                                <tr style="background-color: #fff; font-weight: bold; ">
                                    <td style="color: #000" colspan="2" class="text-center">TOTAL KESELURUHAN</td>
                                    <?php
                                    // Loop melalui header lagi untuk memastikan kolom total sejajar
                                    foreach ($item_headers as $header):
                                        // Cek jika ada total untuk header kolom ini
                                        if (isset($column_totals[$header])):
                                            $total_data = $column_totals[$header];
                                            // $total_formatted = number_format($total_data['total'], 2, ',', '.') . ' ' . $total_data['satuan'];
                                            $total_formatted = number_format($total_data['total']) . ' ' . $total_data['satuan'];
                                    ?>
                                            <td style="color: #000" class="text-center"><?= $total_formatted; ?></td>
                                        <?php else: ?>
                                            <td style="color: #000" class="text-center">-</td>
                                        <?php endif; ?>
                                    <?php endforeach; ?>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        </section>

    </div>