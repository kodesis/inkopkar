<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Saldo_Simpanan extends CI_Controller
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
    public function add_simpanan()
    {

        $data['anggota'] = $this->nota_management->get_anggota_saldo_simpanan();
        $data['tipe_simpanan'] = $this->nota_management->get_tipe_saldo_simpanan();
        $data['content']     = 'webview/admin/saldo_simpanan/saldo_simpanan_form_v';
        $data['content_js'] = 'webview/admin/saldo_simpanan/saldo_simpanan_js';
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

    public function ajax_search_anggota()
    {
        // Get the search query from the URL parameter (GET request)
        // We will use $_GET directly for simplicity with the fetch API
        $query = $this->input->get('q', TRUE); // The TRUE parameter handles XSS filtering

        // Build the query
        $this->db->select('anggota.id, anggota.nomor_anggota, anggota.nama, koperasi.nama_koperasi');
        $this->db->from('anggota');
        $this->db->join('koperasi', 'anggota.id_koperasi = koperasi.id', 'left');
        $this->db->where('anggota.status', '1');
        $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));

        // Use group_start() and group_end() to properly group the OR conditions
        if ($query) {
            $this->db->group_start();
            $this->db->like('anggota.nomor_anggota', $query);
            $this->db->or_like('anggota.nama', $query);
            $this->db->group_end();
        }

        // Limit the results to prevent overwhelming the user
        $this->db->limit(10);

        $results = $this->db->get()->result();

        // --- IMPORTANT: TRANSFORM THE DATA FOR CHOICES.JS ---
        // Choices.js expects an array of objects with 'value' and 'label' keys.
        $choices_data = [];
        if (!empty($results)) {
            foreach ($results as $anggota) {
                $choices_data[] = [
                    'value' => $anggota->id,
                    'label' => $anggota->nama . ' - ' . $anggota->nomor_anggota
                ];
            }
        }

        // Return the formatted results as JSON
        header('Content-Type: application/json');
        echo json_encode($choices_data);
    }

    public function save()
    {
        $date = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');
        $tanggal_jam = $this->input->post('tanggal_jam');
        $sampai_dengan = $this->input->post('sampai_dengan');
        $id_anggota = $this->input->post('id_anggota');
        $keterangan = $this->input->post('keterangan');
        $tipe_simpanan = $this->input->post('tipe_simpanan');
        $anggota = $this->anggota_management->get_id_edit($id_anggota);

        $nominal_kredit = (int) str_replace('.', '', $this->input->post('nominal_kredit'));
        $token = random_int(100000, 999999); // Generate a secure random number

        // Get the current year
        $current_year = date('Y');

        $current_month = date('F');

        // Get the latest ID from the database for the current year
        $latest_entry = $this->saldo_simpanan->get_latest_entry($current_year);

        if ($latest_entry) {
            // Extract only the first 6 digits of the latest ID (numeric part)
            $latest_number = (int) substr($latest_entry->id, 0, 6);
            $new_number = str_pad($latest_number + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $new_number = "000001"; // Start from 000001 if no previous entry
        }

        $new_id = $new_number . $current_year;

        // Save the new data
        $sub_id = $this->saldo_simpanan->save_file([
            'id'             => $new_id, // New generated ID
            // 'tanggal_jam'    => $date,
            'tanggal_jam'    => $tanggal_jam,
            'sampai_dengan'    => $sampai_dengan,
            'id_anggota'     => $id_anggota,
            'nominal' => $nominal_kredit,
            'tipe_simpanan' => $tipe_simpanan ? strtoupper($tipe_simpanan) : "SIMPANAN POKOK",
            'keterangan' => $keterangan ? $keterangan : "IURAN BULAN " . $current_month,
            'id_kasir'       => $this->session->userdata('user_user_id'),
            'id_koperasi'       => $this->session->userdata('id_koperasi'),
            'id_toko'        => $this->session->userdata('id_toko'),
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
        $this->db->from('saldo_simpanan');
        $this->db->join('anggota', 'anggota.id = saldo_simpanan.id_anggota');
        $this->db->where('id_anggota', $id_anggota);
        $this->db->where('saldo_simpanan.status', '1');

        $query = $this->db->get();
        $result = $query->row();
        $usage_now = $result->nominal;

        $this->db->from('anggota');
        $this->db->where('id', $this->session->userdata('user_user_id'));
        $anggota_now = $this->db->get()->row();

        $tanggal_simpanan_terakhir = $anggota_now->tanggal_simpanan_terakhir;

        if ($sampai_dengan > $tanggal_simpanan_terakhir) {
            $tanggal_simpanan_terakhir = $sampai_dengan;
        }

        $this->anggota_management->update_data(['saldo_simpanan' => $usage_now, 'tanggal_simpanan_terakhir' => $tanggal_simpanan_terakhir], ['id' => $id_anggota]);

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
        $saldo_simpanan = $this->saldo_simpanan->total_saldo_simpanan_anggota($id);
        echo json_encode(array("status" => TRUE, 'nama' => $anggota->nama, 'nomor_anggota' => $anggota->nomor_anggota, 'kredit_limit' => $anggota->kredit_limit, 'saldo_simpanan' => $saldo_simpanan));
    }

    public function process_insert_excel()
    {
        $this->load->library('upload');
        require APPPATH . 'third_party/autoload.php';
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';
        set_time_limit(300); // 300 seconds = 5 minutes
        $config['upload_path'] = FCPATH . 'uploads/saldo_simpanan';
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
            $latest_entry = $this->saldo_simpanan->get_latest_entry($current_year);

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
                    // $rowData[] = $cell->getValue();
                    $rowData[] = $cell->getCalculatedValue(); // <-- Use this for formula results
                }

                // Generate next ID
                $latest_number++;
                $new_number = str_pad($latest_number, 6, '0', STR_PAD_LEFT);
                $new_id = $new_number . $current_year;

                // --- Corrected column mapping based on your template ---
                // A = No (Ignored)
                // B = Nomor Anggota -> rowData[1]
                // C = Nominal -> rowData[2]
                // D = Keterangan -> rowData[3]
                // E = Kode Tipe Simpanan -> rowData[4]
                // F = Tanggal Bayar -> rowData[5]
                // G = Sampai Dengan -> rowData[6]

                $nomor_anggota = isset($rowData[1]) ? $rowData[1] : null;

                // echo $nomor_anggota;
                // echo $nomor_anggota;
                // Find id_anggota from database
                $anggota = $this->db->get_where('anggota', ['nomor_anggota' => $nomor_anggota])->row();
                $id_anggota = $anggota->id;

                $tanggal_excel = isset($rowData[5]) ? $rowData[5] : null;

                $tanggal_bayar = null;
                if (is_numeric($tanggal_excel)) {
                    // Excel date serial to Y-m-d
                    $tanggal_bayar = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tanggal_excel));
                } elseif (!empty($tanggal_excel)) {
                    // Already a valid date string
                    $tanggal_bayar = date('Y-m-d', strtotime($tanggal_excel));
                } else {
                    // If no date is found, you might want to set a default.
                    // For this example, let's set it to the current time.
                    $tanggal_bayar = date('Y-m-d H:i:s');
                }
                $date_for_keterangan_tanggal_bayar = new DateTime($tanggal_bayar);

                $sd_excel = isset($rowData[6]) ? $rowData[6] : null;
                $sampai_dengan = null;
                if (is_numeric($sd_excel)) {
                    // Excel date serial to Y-m-d
                    $sampai_dengan = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($sd_excel));
                } elseif (!empty($sd_excel)) {
                    // Already a valid date string
                    $sampai_dengan = date('Y-m-d', strtotime($sd_excel));
                } else {
                    // If no date is found, you might want to set a default.
                    // For this example, let's set it to the current time.
                    $sampai_dengan = date('Y-m-d H:i:s');
                }
                $date_for_keterangan_sampai_dengan = new DateTime($sampai_dengan);

                $bulan = $date_for_keterangan_sampai_dengan->format('M');
                $bulan_nama = $date_for_keterangan_sampai_dengan->format('F');
                $tahun = $date_for_keterangan_sampai_dengan->format('Y');

                // Now map Excel columns to database fields
                $dataInsert[] = [
                    'id'          => $new_id, // **USE GENERATED ID**
                    'id_anggota'  => $id_anggota,
                    'nominal'     => isset($rowData[2]) ? (float)str_replace(',', '', $rowData[2]) : 0,
                    'keterangan'    => isset($rowData[3]) ? $rowData[3] : "IURAN BULAN " . strtoupper($bulan_nama) . " " . $tahun,
                    'tipe_simpanan'    => isset($rowData[4]) ? strtoupper($rowData[4]) : "SIMPANAN POKOK",
                    'tanggal_jam'   => $tanggal_bayar,
                    'sampai_dengan'   => $sampai_dengan,
                    'status' => 1,
                    'id_kasir' => $this->session->userdata('user_user_id'),
                    'id_toko' => $this->session->userdata('id_toko'),
                    'id_koperasi' => $this->session->userdata('id_koperasi'),
                    // 'id_koperasi' => $this->session->userdata('id_koperasi'),
                ];
            }

            if (!empty($dataInsert)) {
                $this->db->insert_batch('saldo_simpanan', $dataInsert); // Bulk insert

                $updateAnggota = [];

                foreach ($dataInsert as $item) {
                    $id_anggota = $item['id_anggota'];

                    // Hitung total nominal terbaru dari tabel iuran
                    $this->db->select_sum('nominal');
                    $this->db->where('id_anggota', $id_anggota);
                    $total = $this->db->get('saldo_simpanan')->row();

                    $this->db->from('anggota');
                    $this->db->where('id', $id_anggota);
                    $anggota_now = $this->db->get()->row();

                    $tanggal_simpanan_terakhir = $anggota_now->tanggal_simpanan_terakhir;

                    if ($sampai_dengan > $tanggal_simpanan_terakhir) {
                        $tanggal_simpanan_terakhir = $sampai_dengan;
                    }

                    $updateAnggota[] = [
                        'id' => $id_anggota,
                        'saldo_simpanan' => $total->nominal ?? 0,
                        'tanggal_simpanan_terakhir' => $tanggal_simpanan_terakhir,
                    ];
                }

                if (!empty($updateAnggota)) {
                    $this->db->update_batch('anggota', $updateAnggota, 'id');
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
        } finally {
            if (file_exists($file_path)) unlink($file_path);
        }
    }

    public function add_tipe_simpanan()
    {
        // Load the necessary models and libraries

        $kode_tipe = $this->input->post('kode_tipe');
        $nama_tipe = $this->input->post('nama_tipe');

        if (empty($kode_tipe) || empty($nama_tipe)) {
            echo json_encode(['status' => 'error', 'message' => 'Kode Tipe dan Nama Tipe tidak boleh kosong.']);
            return;
        }

        $data = [
            'kode_tipe' => $kode_tipe,
            'nama_tipe' => $nama_tipe
        ];

        $insert_result = $this->saldo_simpanan->insert_tipe_simpanan($data); // Your model function to insert data

        if ($insert_result) {
            echo json_encode(['status' => 'success', 'message' => 'Data berhasil disimpan.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Gagal menyimpan data ke database.']);
        }
    }

    public function export_template_simpanan()
    {
        // Load library PhpSpreadsheet secara manual
        require APPPATH . 'third_party/autoload.php';
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';
        require APPPATH . 'third_party/autoload_zip.php';

        // Membuat objek Spreadsheet baru
        $spreadsheet = new \PhpOffice\PhpSpreadsheet\Spreadsheet();
        $sheet = $spreadsheet->getActiveSheet();

        // Mengatur header kolom
        $sheet->setCellValue('A1', 'No');
        $sheet->setCellValue('B1', 'Nomor Anggota');
        $sheet->setCellValue('C1', 'Nominal');
        $sheet->setCellValue('D1', 'Keterangan');
        $sheet->setCellValue('E1', 'Kode Tipe Simpanan');
        $sheet->setCellValue('F1', 'Tanggal Bayar');
        $sheet->setCellValue('G1', 'Sampai Dengan');
        $sheet->setCellValue('I1', 'Kode Tipe Simpanan');

        // Mengatur data contoh
        $sheet->setCellValue('A2', '1');
        $sheet->setCellValue('B2', 'KKMPCP-0001');
        $sheet->setCellValue('C2', '100000');
        $sheet->setCellValue('D2', 'IURAN BULAN ' . strtoupper(date('F')) . ' ' . date('Y'));
        $sheet->setCellValue('E2', 'SPP');
        $sheet->setCellValue('F2', date('d/m/Y'));
        $sheet->setCellValue('G2', date('d/m/Y'));
        $sheet->setCellValue('H2', 'CONTOH');


        // --- FIX: Mengisi sel G2 dengan string yang benar, bukan array ---

        // Ambil data tipe simpanan dari model
        $tipe_simpanan_data = $this->saldo_simpanan->get_tipe_saldo_simpanan();

        // Buat string dari data yang akan dimasukkan ke sel G2
        $tipe_names = [];
        foreach ($tipe_simpanan_data as $s) {
            $tipe_names[] = $s->kode_tipe . ' :: ' . $s->nama_tipe;
        }

        // Gabungkan nama-nama tipe menjadi satu string yang dipisahkan baris baru
        // Menggunakan "\n" akan membuat setiap tipe berada di baris baru di dalam sel Excel
        $tipe_string = implode("\n", $tipe_names);

        // $sheet->mergeCells('I2:I99');

        // Terapkan wrapping teks agar baris baru terlihat
        $sheet->getStyle('I2')->getAlignment()->setWrapText(true);

        // Atur perataan vertikal ke atas
        $sheet->getStyle('I2')->getAlignment()->setVertical(\PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_TOP);

        // Sekarang, tetapkan nilai sel dengan string yang sudah digabungkan
        $sheet->setCellValue('I2', $tipe_string);

        // --- Penyesuaian lain-lain ---
        $sheet->setCellValue('H3', 'MULAI DARI SINI');

        // Mengatur auto-size untuk semua kolom
        foreach (range('A', 'I') as $columnID) {
            $sheet->getColumnDimension($columnID)->setAutoSize(true);
        }
        // --- Pewarnaan Sel ---
        // A1 to H1: Dark Blue
        $sheet->getStyle('A1:G1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A1:G1')->getFill()->getStartColor()->setARGB('328fd1'); // Dark Blue

        // A2 to H2: Light Blue
        $sheet->getStyle('A2:G2')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A2:G2')->getFill()->getStartColor()->setARGB('32ccd1'); // Light Blue

        // A3 to F3: Light Green
        $sheet->getStyle('A3:G3')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID);
        $sheet->getStyle('A3:G3')->getFill()->getStartColor()->setARGB('32d15c'); // Light Green

        // --- Menambahkan Border ke seluruh sel yang digunakan ---
        $styleArray = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                    'color' => ['argb' => 'FF000000'],
                ],
            ],
        ];

        // Tentukan range sel yang akan diberi border
        // Ini akan menambahkan border ke header (baris 1), contoh data (baris 2), dan teks "MULAI DARI SINI" (baris 3)
        $sheet->getStyle('A1:G3')->applyFromArray($styleArray);

        // --- Bagian output file tetap sama ---

        // Gunakan Xlsx writer untuk menyimpan file
        $writer = new \PhpOffice\PhpSpreadsheet\Writer\Xlsx($spreadsheet);

        // Atur header untuk mengunduh file
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment; filename="Template Saldo Simpanan.xlsx"');
        header('Cache-Control: max-age=0');

        // OUTPUT FILE KE BROWSER
        $writer->save('php://output');

        // Hentikan eksekusi skrip setelah file selesai di-output
        exit();
    }
}
