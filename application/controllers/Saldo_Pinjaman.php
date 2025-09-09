<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldo_Pinjaman extends CI_Controller
{

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
        $this->load->model('Saldo_Simpanan_m', 'saldo_simpanan');
        $this->load->model('Saldo_Pinjaman_m', 'saldo_pinjaman');

        $this->load->helper(array('form', 'url'));
        $this->load->library(array('upload', 'Api_Whatsapp'));

        $this->load->library('upload', 'Api_Whatsapp');
        if (!$this->session->userdata('user_logged_in')) {
            redirect('auth'); // Redirect to the 'autentic' page
        }
    }
    public function ajax_list()
    {
        $list = $this->nota_management->get_datatables();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $cat->id;
            $row[] = $cat->tanggal_jam;
            $row[] = $cat->nama;
            $row[] = $cat->nominal_kredit;

            $row[] = '<center> <div class="list-icons d-inline-flex">

                                                <a title="Delete User" onclick="onDelete(' . $cat->id . ')" class="btn btn-danger"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg></a>
            </div>
    </center>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->nota_management->count_all(),
            "recordsFiltered" => $this->nota_management->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function index()
    {

        $data['content']     = 'webview/admin/nota_management/nota_management_v';
        $data['content_js'] = 'webview/admin/nota_management/nota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function add_pinjaman()
    {

        $data['anggota'] = $this->nota_management->get_anggota_saldo_pinjaman();
        $data['content']     = 'webview/admin/saldo_pinjaman/saldo_pinjaman_form_v';
        $data['content_js'] = 'webview/admin/saldo_pinjaman/saldo_pinjaman_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function update($id)
    {
        $data['Nota'] = $this->nota_management->get_id_edit($id);
        $data['anggota'] = $this->nota_management->get_anggota();
        $data['content']     = 'webview/admin/nota_management/nota_form_v';
        $data['content_js'] = 'webview/admin/nota_management/nota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function verifikasi()
    {
        // $data['Nota'] = $this->nota_management->get_id_edit($id);
        // $data['anggota'] = $this->nota_management->get_anggota();
        $data['content']     = 'webview/admin/nota_management/nota_verifikasi';
        $data['content_js'] = 'webview/admin/nota_management/nota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function save()
    {
        // $date = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');
        $tanggal_jam = $this->input->post('tanggal_jam');
        $id_anggota = $this->input->post('id_anggota');
        $keterangan = $this->input->post('keterangan');
        $bulan = $this->input->post('bulan');
        $jenis_pinjaman = $this->input->post('jenis_pinjaman');
        $anggota = $this->anggota_management->get_id_edit($id_anggota);

        $nominal_kredit = (int) str_replace('.', '', $this->input->post('nominal_kredit'));
        $cicilan = (int) str_replace('.', '', $this->input->post('cicilan'));
        $sisa_cicilan = (int) str_replace('.', '', $this->input->post('sisa_cicilan'));

        $token = random_int(100000, 999999); // Generate a secure random number

        // Get the current year
        $current_year = date('Y');

        // Get the latest ID from the database for the current year
        $latest_entry = $this->saldo_pinjaman->get_latest_entry($current_year);

        if ($latest_entry) {
            // Extract only the first 6 digits of the latest ID (numeric part)
            $latest_number = (int) substr($latest_entry->id, 0, 6);
            $new_number = str_pad($latest_number + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $new_number = "000001"; // Start from 000001 if no previous entry
        }

        $new_id = $new_number . $current_year;

        // Save the new data
        $sub_id = $this->saldo_pinjaman->save_file([
            'id'             => $new_id, // New generated ID
            'tanggal_jam'    => $tanggal_jam,
            'id_anggota'     => $id_anggota,
            'nominal' => $nominal_kredit,
            'keterangan' => $keterangan,
            'jenis_pinjaman' => $jenis_pinjaman,
            'cicilan' => $cicilan,
            'sisa_cicilan' => $sisa_cicilan,
            'bulan' => $bulan,
            'id_kasir'       => $this->session->userdata('user_user_id'),
            'id_toko'        => $this->session->userdata('id_toko'),
            'id_koperasi' => $this->session->userdata('id_koperasi'),
            'status'         => '1'
        ]);

        // $task_name = $get_task_detail['task_name'];
        // $nama_member = $get_user["nama"];
        // $comment = $this->input->post("commentt");
        // $nama_session = $this->session->userdata('nama');
        // $msg = "Kode verifikasi Anda adalah: " . $token . " \n Gunakan kode ini untuk melengkapi proses verifikasi nota anda.";
        // $this->api_whatsapp->wa_notif($msg, $anggota->no_telp);
        // Update anggota's usage_kredit
        // $usage_kredit = $anggota->usage_kredit + $nominal_kredit;

        $this->db->select_sum('nominal');
        $this->db->from('saldo_pinjaman');
        $this->db->join('anggota', 'anggota.id = saldo_pinjaman.id_anggota');
        $this->db->where('id_anggota', $id_anggota);
        $this->db->where('saldo_pinjaman.status', '1');

        $query = $this->db->get();
        $result = $query->row();
        $usage_now = $result->nominal;

        $this->db->from('anggota');
        $this->db->where('id', $this->session->userdata('user_user_id'));
        $anggota_now = $this->db->get()->row();

        $tanggal_pinjaman_terakhir = $anggota_now->tanggal_pinjaman_terakhir;

        if ($tanggal_jam > $tanggal_pinjaman_terakhir) {
            $tanggal_pinjaman_terakhir = $tanggal_jam;
        }

        // $this->anggota_management->update_data(['saldo_simpanan' => $usage_now, 'tanggal_pinjaman_terakhir' => $tanggal_pinjaman_terakhir], ['id' => $id_anggota]);
        $this->anggota_management->update_data(['saldo_pinjaman' => $usage_now, 'tanggal_pinjaman_terakhir' => $tanggal_pinjaman_terakhir], ['id' => $id_anggota]);

        // if (!$response) {
        //     echo json_encode(["status" => FALSE, "error" => "Failed to send WhatsApp message"]);
        //     exit;
        // } elseif (isset($response['error'])) {
        //     echo json_encode(["status" => FALSE, "error" => $response['error']]);
        //     exit;
        // }

        // If successful
        echo json_encode(["status" => TRUE, "sub_id" => $sub_id, "Telp" => $anggota->no_telp]);

        // echo json_encode(["status" => TRUE, "sub_id" => $sub_id]);
    }

    public function cari_detail_user($id)
    {
        $anggota = $this->anggota_management->get_id_edit($id);
        $saldo_pinjaman = $this->saldo_pinjaman->total_saldo_pinjaman_anggota($id);
        echo json_encode(array("status" => TRUE, 'nama' => $anggota->nama, 'nomor_anggota' => $anggota->nomor_anggota, 'kredit_limit' => $anggota->kredit_limit, 'saldo_pinjaman' => $saldo_pinjaman));
    }

    public function process_insert_excel()
    {
        $this->load->library('upload');
        require APPPATH . 'third_party/autoload.php';
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

        $config['upload_path'] = FCPATH . 'uploads/saldo_pinjaman';
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
            $latest_entry = $this->saldo_pinjaman->get_latest_entry($current_year);

            if ($latest_entry) {
                $latest_number = (int) substr($latest_entry->id, 0, 6);
            } else {
                $latest_number = 0;
            }
            // === End your ID generator ===

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
                $latest_number++;
                $new_number = str_pad($latest_number, 6, '0', STR_PAD_LEFT);
                $new_id = $new_number . $current_year;

                $nomor_anggota = isset($rowData[1]) ? $rowData[1] : null;
                // echo $nomor_anggota;
                // echo $nomor_anggota;
                // Find id_anggota from database
                $anggota = $this->db->get_where('anggota', ['nomor_anggota' => $nomor_anggota])->row();

                // --- THE UPDATED LOGIC IS HERE ---
                $hasError = false;
                if (!$anggota) {
                    // Rollback transaction immediately on error
                    $this->db->trans_rollback();
                    echo json_encode([
                        'status' => false,
                        'message' => 'Anggota Tidak Di Temukan pada baris ' . $rowIndex . '.'
                    ]);
                    $hasError = true;
                    break; // Exit the loop
                }
                // --- END OF UPDATED LOGIC ---

                if (isset($rowData[2])) {
                    $nominal = (float)str_replace(',', '', $rowData[2]);
                } else {
                    // Rollback transaction immediately on error
                    echo json_encode([
                        'status' => false,
                        'message' => 'Nominal Tidak Di Temukan pada baris ' . $rowIndex . '.'
                    ]);
                    $hasError = true;
                    break; // Exit the loop
                }

                if (isset($rowData[3])) {
                    $keterangan = strtoupper($rowData[3]);
                } else {
                    // Rollback transaction immediately on error
                    echo json_encode([
                        'status' => false,
                        'message' => 'Keterangan Tidak Di Temukan pada baris ' . $rowIndex . '.'
                    ]);
                    $hasError = true;
                    break; // Exit the loop
                }

                if (isset($rowData[4])) {
                    $jenis_pinjaman = strtoupper($rowData[4]);
                } else {
                    // Rollback transaction immediately on error
                    echo json_encode([
                        'status' => false,
                        'message' => 'Jenis Pinjaman Tidak Di Temukan pada baris ' . $rowIndex . '.'
                    ]);
                    $hasError = true;
                    break; // Exit the loop
                }

                if (isset($rowData[5])) {
                    $cicilan = (float)str_replace(',', '', $rowData[5]);
                } else {
                    // Rollback transaction immediately on error
                    echo json_encode([
                        'status' => false,
                        'message' => 'Cicilan Tidak Di Temukan pada baris ' . $rowIndex . '.'
                    ]);
                    $hasError = true;
                    break; // Exit the loop
                }

                if (isset($rowData[6])) {
                    $sisa_cicilan = (float)str_replace(',', '', $rowData[6]);
                } else {
                    // Rollback transaction immediately on error
                    echo json_encode([
                        'status' => false,
                        'message' => 'Sisa Cicilan Tidak Di Temukan pada baris ' . $rowIndex . '.'
                    ]);
                    $hasError = true;
                    break; // Exit the loop
                }

                if (isset($rowData[7])) {
                    $bulan = $rowData[7];
                } else {
                    // Rollback transaction immediately on error
                    echo json_encode([
                        'status' => false,
                        'message' => 'Bulan Tidak Di Temukan pada baris ' . $rowIndex . '.'
                    ]);
                    $hasError = true;
                    break; // Exit the loop
                }

                $id_anggota = $anggota->id;
                $column_letter = \PhpOffice\PhpSpreadsheet\Cell\Coordinate::stringFromColumnIndex(9);

                // Get the cell object using the column letter and row index
                $cell = $worksheet->getCell($column_letter . $rowIndex);

                // Now, get the calculated value from the cell
                $tanggal_excel = isset($rowData[8]) ? $cell->getCalculatedValue() : null;
                // $tanggal_excel = isset($rowData[8]) ? $rowData[8] : null;
                // echo $tanggal_excel;


                if (is_numeric($tanggal_excel)) {
                    // Excel date serial to Y-m-d
                    $tanggal_bayar = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tanggal_excel));
                } elseif (!empty($tanggal_excel)) {
                    // Already a valid date string
                    $tanggal_bayar = date('Y-m-d', strtotime($tanggal_excel));
                } else {
                    // If no date is found, you might want to set a default.
                    // For this example, let's set it to the current time.
                    // $tanggal_bayar = date('Y-m-d H:i:s');
                    echo json_encode([
                        'status' => false,
                        'message' => 'Tanggal Transaksi Tidak Di Temukan pada baris ' . $rowIndex . '.'
                    ]);
                    $hasError = true;
                    break; // Exit the loop
                }

                // echo $tanggal_bayar;


                // Now map Excel columns to database fields
                $dataInsert[] = [
                    'id'          => $new_id, // **USE GENERATED ID**
                    'id_anggota'  => $id_anggota,
                    // 'nominal'     => isset($rowData[2]) ? (float)str_replace(',', '', $rowData[2]) : 0,
                    // 'keterangan'    => isset($rowData[3]) ? $rowData[3] : "CICILAN BULAN " . strtoupper($bulan_nama) . " " . $tahun,
                    // 'jenis_pinjaman'    => isset($rowData[4]) ? $rowData[4] : "PINJAMAN",
                    // 'cicilan' => isset($rowData[5]) ? (float)str_replace(',', '', $rowData[5]) : 0,
                    // 'sisa_cicilan' => isset($rowData[6]) ? (float)str_replace(',', '', $rowData[6]) : 0,
                    // 'bulan' => isset($rowData[7]) ? $rowData[7] : 1,
                    'nominal'     => $nominal,
                    'keterangan'    => $keterangan,
                    'jenis_pinjaman'    => $jenis_pinjaman,
                    'cicilan' => $cicilan,
                    'sisa_cicilan' => $sisa_cicilan,
                    'bulan' => $bulan,
                    'tanggal_jam'   => $tanggal_bayar,
                    'status' => 1,
                    'id_kasir' => $this->session->userdata('user_user_id'),
                    'id_toko' => $this->session->userdata('id_toko'),
                    'id_koperasi' => $this->session->userdata('id_koperasi'),
                ];
            }

            if (!$hasError) {

                if (!empty($dataInsert)) {
                    $this->db->insert_batch('saldo_pinjaman', $dataInsert); // Bulk insert

                    $updateAnggota = [];

                    foreach ($dataInsert as $item) {
                        $id_anggota = $item['id_anggota'];

                        // Hitung total nominal terbaru dari tabel iuran
                        $this->db->select_sum('nominal');
                        $this->db->where('id_anggota', $id_anggota);
                        $total = $this->db->get('saldo_pinjaman')->row();

                        $updateAnggota[] = [
                            'id' => $id_anggota,
                            'saldo_pinjaman' => $total->nominal ?? 0,
                        ];

                        $this->db->from('anggota');
                        $this->db->where('id', $id_anggota);
                        $anggota_now = $this->db->get()->row();

                        $tanggal_pinjaman_terakhir = $anggota_now->tanggal_pinjaman_terakhir;

                        if ($item['tanggal_jam'] > $tanggal_pinjaman_terakhir) {
                            $tanggal_pinjaman_terakhir = $item['tanggal_jam'];
                        }

                        $updateAnggota[] = [
                            'id' => $id_anggota,
                            'saldo_pinjaman' => $total->nominal ?? 0,
                            'tanggal_pinjaman_terakhir' => $tanggal_pinjaman_terakhir,
                        ];
                    }

                    if (!empty($updateAnggota)) {
                        $this->db->update_batch('anggota', $updateAnggota, 'id');
                    } else {
                        echo json_encode(['status' => false, 'message' => 'Gagal Update Iuran Koperasi']);
                    }
                }
            }

            if (!$hasError && $this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                echo json_encode(['status' => false, 'message' => 'Database error while inserting data']);
            } else if (!$hasError) {
                $this->db->trans_commit();
                echo json_encode(['status' => true, 'message' => 'Excel data inserted successfully']);
            }
        } catch (Exception $e) {
            $this->db->trans_rollback(); // Ensure rollback on any exception
            echo json_encode(['status' => false, 'message' => $e->getMessage()]);
        } finally {
            if (file_exists($file_path)) unlink($file_path);
        }
    }


    public function ajax_list_monitor_pinjaman()
    {
        // Menerima filter dari POST
        $filter_status = $this->input->post('filter_status');
        $list = $this->saldo_pinjaman->get_datatables_monitor_pinjaman($filter_status);
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            if ($cat->id == '1') {
                continue;
            }

            $no++;
            $row = array();
            $tanggal_sekarang = new DateTime();

            // Format both dates to a 'YYYY-MM' string for easy comparison
            $bulan_tahun_sekarang = $tanggal_sekarang->format('Y-m');
            $status_simpanan_now = '';
            $status_class = '';

            if ($cat->tanggal_pinjaman_terakhir == '' || $cat->tanggal_pinjaman_terakhir == Null) {
                $tanggal_tampil = '-';
                $status_simpanan_now = '<b>Belum Dibayar</b>';
                $status_class = 'text-danger';
            } else {
                $tanggal_pinjaman_terakhir = new DateTime($cat->tanggal_pinjaman_terakhir);
                $bulan_tahun_terakhir = $tanggal_pinjaman_terakhir->format('Y-m');
                $selisih = $tanggal_sekarang->diff($tanggal_pinjaman_terakhir);

                // if ($bulan_tahun_terakhir < $bulan_tahun_sekarang || $tanggal_pinjaman_terakhir < $tanggal_sekarang) {
                if ($bulan_tahun_terakhir < $bulan_tahun_sekarang) {
                    $tanggal_tampil = date('d F Y', strtotime($cat->tanggal_pinjaman_terakhir));
                    $status_simpanan = 'Belum Dibayar';
                    // $keterangan_waktu = ' (' . $selisih->days . ' hari yang lalu)';
                    // $status_simpanan_now = '<b>' . $status_simpanan . $keterangan_waktu . '</b>';
                    $status_simpanan_now = '<b>' . $status_simpanan  . '</b>';
                    $status_class = 'text-danger';
                } else {
                    $tanggal_tampil = date('d F Y', strtotime($cat->tanggal_pinjaman_terakhir));
                    $status_simpanan = 'Sudah Dibayar';
                    // $keterangan_waktu = ' (Tersisa ' . $selisih->days . ' hari)';
                    // $status_simpanan_now = '<b>' . $status_simpanan . $keterangan_waktu . '</b>';
                    $status_simpanan_now = '<b>' . $status_simpanan  . '</b>';
                    $status_class = 'text-success';
                }
            }

            // Terapkan kelas CSS ke setiap elemen di baris
            $row[] = '<span class="' . $status_class . '">' . $no . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->nomor_anggota . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->nama . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $tanggal_tampil . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $status_simpanan_now . '</span>';
            $row[] = "<a href=" . base_url('Saldo_Pinjaman/monitoring_pinjaman_anggota/' . $cat->nomor_anggota) . " class='btn btn-primary me-1 mb-1'>Detail</a>";
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->saldo_pinjaman->count_all_monitor_pinjaman(),
            "recordsFiltered" => $this->saldo_pinjaman->count_filtered_monitor_pinjaman($filter_status),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function monitoring_pinjaman()
    {

        $data['content']     = 'webview/admin/saldo_pinjaman/monitor_pinjaman_v';
        $data['content_js'] = 'webview/admin/saldo_pinjaman/monitor_pinjaman_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function export_belum_dibayar_excel()
    {
        // Mengambil data dengan filter 'Belum Dibayar'
        $list_belum_dibayar = $this->saldo_pinjaman->get_data_untuk_export('Belum Dibayar');

        // Load library PhpSpreadsheet secara manual
        // Baris ini memuat semua kelas yang dibutuhkan, jadi baris di bawahnya tidak diperlukan
        require APPPATH . 'third_party/autoload.php';
        // Hapus baris ini karena tidak diperlukan dan bisa menyebabkan masalah
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

        // Membuat objek Spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Mengatur header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nomor Anggota');
        $sheet->setCellValue('C1', 'Nama');
        $sheet->setCellValue('D1', 'Tanggal Iuran Terakhir');
        $sheet->setCellValue('E1', 'Status');

        $row = 2;
        $no = 1;
        foreach ($list_belum_dibayar as $data) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $data->nomor_anggota);
            $sheet->setCellValue('C' . $row, $data->nama);

            // Logika untuk menampilkan tanggal yang sudah diformat atau '-'
            if (empty($data->tanggal_pinjaman_terakhir)) {
                $sheet->setCellValue('D' . $row, '-');
            } else {
                $sheet->setCellValue('D' . $row, date('d F Y', strtotime($data->tanggal_pinjaman_terakhir)));
            }

            // Logika untuk menampilkan status Belum Dibayar
            $tanggal_sekarang = new \DateTime();

            // Memastikan tanggal tidak kosong sebelum membuat objek DateTime
            if (!empty($data->tanggal_pinjaman_terakhir)) {
                $tanggal_pinjaman_terakhir = new \DateTime($data->tanggal_pinjaman_terakhir);
                $selisih = $tanggal_sekarang->diff($tanggal_pinjaman_terakhir);
                $status_text = 'Belum Dibayar'; // Status default jika tanggal kosong
                // $status_text = 'Belum Dibayar (' . $selisih->days . ' hari yang lalu)';
            } else {
                $status_text = 'Belum Dibayar'; // Status default jika tanggal kosong
            }
            $sheet->setCellValue('E' . $row, $status_text);

            $row++;
        }

        // --- Add this section to auto-size the columns ---
        $highestColumn = $sheet->getHighestColumn();
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // --- End of new section ---

        require APPPATH . 'third_party/autoload_zip.php';

        // Gunakan Xlsx writer untuk menyimpan file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Atur header untuk mengunduh file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Monitoring Iuran Pinjaman Terakhir.xlsx"');
        header('Cache-Control: max-age=0');

        // OUTPUT FILE KE BROWSER
        // Baris ini adalah yang terpenting! Anda harus memanggilnya.
        $writer->save('php://output');

        // Hentikan eksekusi skrip setelah file selesai di-output
        exit();
    }

    public function ajax_list_monitor_pinjaman_anggota($nomor_anggota)
    {
        // Menerima filter dari POST
        $filter_status = $this->input->post('filter_status');
        $list = $this->saldo_pinjaman->get_datatables_monitor_pinjaman_anggota($nomor_anggota, $filter_status);
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            if ($cat->id == '1') {
                continue;
            }

            $no++;
            $row = array();

            $row[] = $no;
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->nominal ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';
            $row[] = $cat->keterangan;

            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->cicilan ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->sisa_cicilan ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';
            $tanggal_jam = date('d F Y', strtotime($cat->tanggal_jam));
            $row[] = $tanggal_jam;


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->saldo_pinjaman->count_all_monitor_pinjaman_anggota($nomor_anggota),
            "recordsFiltered" => $this->saldo_pinjaman->count_filtered_monitor_pinjaman_anggota($nomor_anggota, $filter_status),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function monitoring_pinjaman_anggota($nomor_anggota)
    {
        $detail_anggota = $this->db->where('nomor_anggota', $nomor_anggota)->get('anggota')->row();

        $data['detail_anggota']     = $detail_anggota;
        $data['content']     = 'webview/admin/saldo_pinjaman/monitor_pinjaman_anggota_v';
        $data['content_js'] = 'webview/admin/saldo_pinjaman/monitor_pinjaman_anggota_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function export_per_anggota($nomor_anggota)
    {
        // Mengambil data dengan filter 'Belum Dibayar'
        $list_belum_dibayar = $this->saldo_pinjaman->get_data_untuk_export_per_anggota($nomor_anggota);

        $detail_anggota = $this->db->where('nomor_anggota', $nomor_anggota)->get('anggota')->row();
        // Load library PhpSpreadsheet secara manual
        // Baris ini memuat semua kelas yang dibutuhkan, jadi baris di bawahnya tidak diperlukan
        require APPPATH . 'third_party/autoload.php';
        // Hapus baris ini karena tidak diperlukan dan bisa menyebabkan masalah
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';

        // Membuat objek Spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Mengatur header kolom
        $sheet->setCellValue('A1', 'Nomor Anggota');
        $sheet->setCellValue('B1', $nomor_anggota);

        $sheet->setCellValue('A2', 'Nama Anggota');
        $sheet->setCellValue('B2', $detail_anggota->nama);


        $sheet->setCellValue('A3', 'No');
        $sheet->setCellValue('B3', 'Nominal');
        $sheet->setCellValue('C3', 'Keterangan');
        $sheet->setCellValue('D3', 'Cicilan');
        $sheet->setCellValue('E3', 'Sisa Cicilan');
        $sheet->setCellValue('F3', 'Tanggal Transaksi');

        $row = 4;
        $no = 1;
        foreach ($list_belum_dibayar as $data) {
            $sheet->setCellValue('A' . $row, $no++);
            $sheet->setCellValue('B' . $row, $data->nominal);
            $sheet->setCellValue('C' . $row, $data->keterangan);
            $sheet->setCellValue('D' . $row, $data->cicilan);
            $sheet->setCellValue('E' . $row, $data->sisa_cicilan);

            // Logika untuk menampilkan tanggal yang sudah diformat atau '-'
            if (empty($data->tanggal_jam)) {
                $sheet->setCellValue('F' . $row, '-');
            } else {
                $sheet->setCellValue('F' . $row, date('d F Y', strtotime($data->tanggal_jam)));
            }

            $row++;
        }

        // --- Add this section to auto-size the columns ---
        $highestColumn = $sheet->getHighestColumn();
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }
        // --- End of new section ---

        require APPPATH . 'third_party/autoload_zip.php';

        // Gunakan Xlsx writer untuk menyimpan file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Atur header untuk mengunduh file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Monitoring Iuran Pinjaman Anggota ' . $detail_anggota->nama . '.xlsx"');
        header('Cache-Control: max-age=0');

        // OUTPUT FILE KE BROWSER
        // Baris ini adalah yang terpenting! Anda harus memanggilnya.
        $writer->save('php://output');

        // Hentikan eksekusi skrip setelah file selesai di-output
        exit();
    }
}
