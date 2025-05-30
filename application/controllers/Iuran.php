<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Iuran extends CI_Controller
{
    // https://inkopkar.coop/Riwayat_Kasir/detail_saldo_simpananI 
    // https://www.inkopkar.coop/Riwayat_Kasir/detail_saldo_simpanan
    /**
     * Index Page for this controller.
     *
     * Maps to the following URL
     * 		http://example.com/index.php/welcome
     *	- or -
     * 		http://example.com/index.php/welcome/index
     *	- or -
     * Since this controller is set as the default controller in
     * config/routes.php, it's displayed at http://example.com/
     *
     * So any other public methods not prefixed with an underscore will
     * map to /index.php/welcome/<method_name>
     * @see https://codeigniter.com/userguide3/general/urls.html
     */
    function __construct()
    {
        // require_once APPPATH . 'third_party/PhpSpreadsheet/src/Bootstrap.php';
        parent::__construct();
        $this->load->model('nota_m', 'nota');
        $this->load->model('nota_Management_m', 'nota_management');
        $this->load->model('anggota_Management_m', 'anggota_management');
        $this->load->model('toko_Management_m', 'toko_management');
        $this->load->model('koperasi_Management_m', 'koperasi_management');
        $this->load->model('riwayat_Kasir_m', 'riwayat_kasir');
        $this->load->model('Iuran_m', 'iuran');

        $this->load->helper(array('form', 'url'));
        $this->load->library(array('upload', 'Api_Whatsapp'));

        $this->load->library('upload', 'Api_Whatsapp');
        if (!$this->session->userdata('user_logged_in')) {
            redirect('auth'); // Redirect to the 'autentic' page
        }
    }
    public function ajax_list($uid = null)
    {
        $list = $this->iuran->get_datatables($uid);
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        // var_dump($list);
        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $no;
            // $row[] = $cat->id;
            $row[] = $cat->nama_koperasi;
            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $cat->nominal ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';
            $row[] = $cat->tanggal_bayar;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->iuran->count_all($uid),
            "recordsFiltered" => $this->iuran->count_filtered($uid),
            "data" => $data,
        );

        echo json_encode($output);
    }
    public function index()
    {

        $data['content']     = 'webview/admin/iuran/iuran_v';
        $data['content_js'] = 'webview/admin/iuran/iuran_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function detail()
    {

        $data['content']     = 'webview/admin/iuran/iuran_detail_v';
        $data['content_js'] = 'webview/admin/iuran/iuran_detail_js';
        // $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_transaksi_inkopkar_v';
        // $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_transaksi_inkopkar_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function process_insert_excel()
    {
        $this->load->library('upload');
        require APPPATH . 'third_party/autoload.php';
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

        $config['upload_path'] = FCPATH . 'uploads/iuran';
        $config['allowed_types'] = 'xls|xlsx|csv';
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file_excel')) {
            $error = $this->upload->display_errors();
            echo json_encode(['status' => false, 'message' => $error]);
            return;
        }

        $file_data = $this->upload->data();
        $file_path = $file_data['full_path'];
        $saldo_koperasi_awal = []; // To store initial 'sebelum' balance for each koperasi

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
            $worksheet = $spreadsheet->getActiveSheet();

            $this->db->trans_begin(); // Start transaction

            $dataInsert = [];

            // === Start your ID generator ===
            $current_year = date('Y');
            $latest_entry = $this->iuran->get_latest_entry($current_year);

            if ($latest_entry) {
                $latest_number = (int) substr($latest_entry->id, 0, 6);
            } else {
                $latest_number = 0;
            }
            // === End your ID generator ===

            $latest_number++;
            $new_number = str_pad($latest_number, 6, '0', STR_PAD_LEFT);
            // echo $new_number;
            $koperasis = null;
            foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                // Skip header
                if ($rowIndex == 1 || $rowIndex == 2) continue;

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    // $rowData[] = $cell->getValue();
                    $rowData[] = $cell->getCalculatedValue();
                }

                // Generate next ID
                $new_id = $new_number . $current_year;

                $no_induk_koperasi = isset($rowData[0]) ? $rowData[0] : null;

                // echo $no_induk_koperasi;
                // Find id_anggota from database
                $koperasi = $this->db->get_where('koperasi', ['no_induk' => $no_induk_koperasi])->row();
                if ($koperasi) {

                    $id_koperasi = $koperasi->id;
                    $tanggal_excel = isset($rowData[2]) ? $rowData[2] : null;

                    $tanggal_bayar = null;
                    if (is_numeric($tanggal_excel)) {
                        // Excel date serial to Y-m-d
                        $tanggal_bayar = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tanggal_excel));
                    } elseif (!empty($tanggal_excel)) {
                        // Already a valid date string
                        $tanggal_bayar = date('Y-m-d', strtotime($tanggal_excel));
                    }

                    $nominal = isset($rowData[1]) ? (float)str_replace(',', '', $rowData[1]) : 0;

                    if (!isset($saldo_koperasi_awal[$id_koperasi])) {
                        // First time encountering this koperasi, get saldo from DB
                        $this->db->select_sum('nominal');
                        $this->db->where('id_koperasi', $id_koperasi);
                        $total_before = $this->db->get('iuran')->row()->nominal ?? 0;

                        $saldo_koperasi_awal[$id_koperasi] = $total_before;
                    }

                    $nominal_sebelum = $saldo_koperasi_awal[$id_koperasi];
                    $nominal_sesudah = $nominal_sebelum + $nominal;

                    // Update tracker
                    $saldo_koperasi_awal[$id_koperasi] = $nominal_sesudah;

                    // $this->db->select_sum('nominal');
                    // $this->db->from('iuran');
                    // $this->db->where('id_koperasi', $id_koperasi);
                    // $get_nominal = $this->db->get()->row();
                    // if (!isset($koperasis)) {
                    //     $koperasis = $id_koperasi;
                    //     $nominal_sebelum = $get_nominal->nominal;
                    //     $nominal_sesudah = $nominal_sebelum + $nominal;
                    // } else {
                    //     if ($koperasis == $id_koperasi) {
                    //         $nominal_sebelum = $nominal_sesudah;
                    //         $nominal_sesudah = $nominal_sesudah + $nominal;
                    //     } else {
                    //         $koperasis = $id_koperasi;
                    //         $nominal_sebelum = $get_nominal->nominal;
                    //         $nominal_sesudah = $nominal_sebelum + $nominal;
                    //     }
                    // }

                    // Now map Excel columns to database fields
                    // $dataInsert[] = [
                    //     // 'id'          => $new_id, // **USE GENERATED ID**
                    //     'id_koperasi'  => $id_koperasi,
                    //     'id_user' => $this->session->userdata('user_user_id'),
                    //     'sebelum' => isset($nominal_sebelum) ? $nominal_sebelum : 0,
                    //     'nominal'     => $nominal,
                    //     'sesudah'  => $nominal_sesudah,
                    //     'tanggal_bayar'   => $tanggal_bayar,
                    // ];

                    $dataInsert[] = [
                        'id_koperasi'  => $id_koperasi,
                        'id_user' => $this->session->userdata('user_user_id'),
                        'sebelum' => $nominal_sebelum,
                        'nominal' => $nominal,
                        'sesudah' => $nominal_sesudah,
                        'tanggal_bayar' => $tanggal_bayar,
                    ];
                } else {
                    $this->db->trans_rollback();
                    echo json_encode(['status' => false, 'message' => 'Nomor Induk Koperasi :' . $no_induk_koperasi . ' Tidak Mempunyai Data Koperasi di Sistem!']);
                    return;
                }
            }

            if (!empty($dataInsert)) {
                $this->db->insert_batch('iuran', $dataInsert); // Bulk insert

                // Step: Update koperasi.saldo_iuran berdasarkan sum nominal dari dataInsert
                $updateKoperasi = [];

                foreach ($dataInsert as $item) {
                    $id_koperasi = $item['id_koperasi'];

                    // Hitung total nominal terbaru dari tabel iuran
                    $this->db->select_sum('nominal');
                    $this->db->where('id_koperasi', $id_koperasi);
                    $total = $this->db->get('iuran')->row();

                    $updateKoperasi[] = [
                        'id' => $id_koperasi,
                        'saldo_iuran' => $total->nominal ?? 0,
                    ];
                }

                if (!empty($updateKoperasi)) {
                    $this->db->update_batch('koperasi', $updateKoperasi, 'id');
                } else {
                    echo json_encode(['status' => false, 'message' => 'Gagal Update Iuran Koperasi']);
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(['status' => false, 'message' => 'Database error while inserting data']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => true, 'message' => 'Excel data inserted successfully']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            return;
        } finally {
            if (file_exists($file_path)) unlink($file_path);
        }
    }

    public function process_insert_excel_iuran()
    {
        $this->load->library('upload');
        require APPPATH . 'third_party/autoload.php';
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

        $config['upload_path'] = FCPATH . 'uploads/iuran';
        $config['allowed_types'] = 'xls|xlsx|csv';
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('file_excel')) {
            $error = $this->upload->display_errors();
            echo json_encode(['status' => false, 'message' => $error]);
            return;
        }

        $file_data = $this->upload->data();
        $file_path = $file_data['full_path'];

        try {
            $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($file_path);
            $worksheet = $spreadsheet->getActiveSheet();

            $this->db->trans_begin(); // Start transaction

            $dataInsert = [];

            // === Start your ID generator ===
            $current_year = date('Y');
            $latest_entry = $this->iuran->get_latest_entry($current_year);

            if ($latest_entry) {
                $latest_number = (int) substr($latest_entry->id, 0, 6);
            } else {
                $latest_number = 0;
            }
            // === End your ID generator ===

            $latest_number++;
            $new_number = str_pad($latest_number, 6, '0', STR_PAD_LEFT);
            // echo $new_number;
            $koperasis = null;
            foreach ($worksheet->getRowIterator() as $rowIndex => $row) {
                // Skip header
                if ($rowIndex == 1 || $rowIndex == 2) continue;

                $cellIterator = $row->getCellIterator();
                $cellIterator->setIterateOnlyExistingCells(false);

                $rowData = [];
                foreach ($cellIterator as $cell) {
                    $rowData[] = $cell->getValue();
                }

                // Generate next ID
                $new_id = $new_number . $current_year;

                $no_induk_koperasi = isset($rowData[0]) ? $rowData[0] : null;

                // echo $no_induk_koperasi;
                // Find id_anggota from database
                $koperasi = $this->db->get_where('koperasi', ['no_induk' => $no_induk_koperasi])->row();
                $id_koperasi = $koperasi->id;
                $tanggal_excel = isset($rowData[2]) ? $rowData[2] : null;

                $tanggal_bayar = null;
                if (is_numeric($tanggal_excel)) {
                    // Excel date serial to Y-m-d
                    $tanggal_bayar = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tanggal_excel));
                } elseif (!empty($tanggal_excel)) {
                    // Already a valid date string
                    $tanggal_bayar = date('Y-m-d', strtotime($tanggal_excel));
                }


                if ($koperasi) {

                    $this->db->select_sum('nominal');
                    $this->db->from('iuran');
                    $this->db->where('id_koperasi', $id_koperasi);
                    $get_nominal = $this->db->get()->row();
                    if (!isset($koperasis)) {
                        $koperasis = $id_koperasi;
                        $nominal_sebelum = $get_nominal->nominal;
                        $nominal = isset($rowData[1]) ? (float)str_replace(',', '', $rowData[1]) : 0;
                        $nominal_sesudah = $nominal_sebelum + $nominal;
                    } else {
                        if ($koperasis == $id_koperasi) {
                            $nominal_sebelum = $nominal_sesudah;
                            $nominal_sesudah = $nominal_sesudah + $nominal;
                        } else {
                            $koperasis = $id_koperasi;
                            $nominal_sebelum = $get_nominal->nominal;
                            $nominal = isset($rowData[1]) ? (float)str_replace(',', '', $rowData[1]) : 0;
                            $nominal_sesudah = $nominal_sebelum + $nominal;
                        }
                    }

                    // Now map Excel columns to database fields
                    $dataInsert[] = [
                        // 'id'          => $new_id, // **USE GENERATED ID**
                        'id_koperasi'  => $id_koperasi,
                        'id_user' => $this->session->userdata('user_user_id'),
                        'sebelum' => isset($nominal_sebelum) ? $nominal_sebelum : 0,
                        'nominal'     => $nominal,
                        'sesudah'  => $nominal_sesudah,
                        'tanggal_bayar'   => $tanggal_bayar,
                    ];
                } else {
                    $this->db->trans_rollback();
                    echo json_encode(['status' => false, 'message' => 'Nomor Induk Koperasi :' . $no_induk_koperasi . ' Tidak Mempunyai Data Koperasi di Sistem!']);
                    return;
                }
            }

            if (!empty($dataInsert)) {
                $this->db->insert_batch('iuran', $dataInsert); // Bulk insert

                // Step: Update koperasi.saldo_iuran berdasarkan sum nominal dari dataInsert
                $updateKoperasi = [];

                foreach ($dataInsert as $item) {
                    $id_koperasi = $item['id_koperasi'];

                    // Hitung total nominal terbaru dari tabel iuran
                    $this->db->select_sum('nominal');
                    $this->db->where('id_koperasi', $id_koperasi);
                    $total = $this->db->get('iuran')->row();

                    $updateKoperasi[] = [
                        'id' => $id_koperasi,
                        'saldo_iuran' => $total->nominal ?? 0,
                    ];
                }

                if (!empty($updateKoperasi)) {
                    $this->db->update_batch('koperasi', $updateKoperasi, 'id');
                } else {
                    echo json_encode(['status' => false, 'message' => 'Gagal Update Iuran Koperasi']);
                }
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(['status' => false, 'message' => 'Database error while inserting data']);
            } else {
                $this->db->trans_commit();
                echo json_encode(['status' => true, 'message' => 'Excel data inserted successfully']);
            }
        } catch (Exception $e) {
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
            return;
        } finally {
            if (file_exists($file_path)) unlink($file_path);
        }
    }

    public function ajax_list1()
    {
        $list = $this->iuran->get_datatables_1();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        // var_dump($list);
        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $no;
            // $row[] = $cat->id;
            $row[] = $cat->no_induk;
            $row[] = $cat->nama_koperasi;
            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $cat->saldo_iuran ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';


            $row[] = '<a title="Detail Iuran Koperasi" href="' . base_url('iuran/detail/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg></a>';


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->iuran->count_all_1(),
            "recordsFiltered" => $this->iuran->count_filtered_1(),
            "data" => $data,
        );

        echo json_encode($output);
    }
}
