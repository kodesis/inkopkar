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
        $date = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');
        $id_anggota = $this->input->post('id_anggota');
        $anggota = $this->anggota_management->get_id_edit($id_anggota);

        $nominal_kredit = (int) str_replace('.', '', $this->input->post('nominal_kredit'));
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
            'tanggal_jam'    => $date,
            'id_anggota'     => $id_anggota,
            'nominal' => $nominal_kredit,
            'id_kasir'       => $this->session->userdata('user_user_id'),
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
        $this->db->from('saldo_pinjaman');
        $this->db->join('anggota', 'anggota.id = saldo_pinjaman.id_anggota');
        $this->db->where('id_anggota', $id_anggota);
        $this->db->where('status', '1');

        $query = $this->db->get();
        $result = $query->row();
        $usage_now = $result->nominal;

        $this->anggota_management->update_data(['saldo_pinjaman' => $usage_now], ['id' => $id_anggota]);

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

                $nomor_anggota = isset($rowData[0]) ? $rowData[0] : null;

                // echo $nomor_anggota;
                // Find id_anggota from database
                $anggota = $this->db->get_where('anggota', ['nomor_anggota' => $nomor_anggota])->row();
                $id_anggota = $anggota->id;
                $tanggal_excel = isset($rowData[2]) ? $rowData[2] : null;

                $tanggal_bayar = null;
                if (is_numeric($tanggal_excel)) {
                    // Excel date serial to Y-m-d
                    $tanggal_bayar = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tanggal_excel));
                } elseif (!empty($tanggal_excel)) {
                    // Already a valid date string
                    $tanggal_bayar = date('Y-m-d', strtotime($tanggal_excel));
                }


                // Now map Excel columns to database fields
                $dataInsert[] = [
                    'id'          => $new_id, // **USE GENERATED ID**
                    'id_anggota'  => $id_anggota,
                    'nominal'     => isset($rowData[1]) ? (float)str_replace(',', '', $rowData[1]) : 0,
                    'tanggal_jam'   => $tanggal_bayar,
                    'status' => 1,
                    'id_kasir' => $this->session->userdata('user_user_id'),
                    'id_toko' => $this->session->userdata('id_toko'),
                    // 'id_koperasi' => $this->session->userdata('id_koperasi'),
                ];
            }

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
}
