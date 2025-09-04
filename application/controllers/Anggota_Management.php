<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_Management extends CI_Controller
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
        $this->load->model('anggota_Management_m', 'anggota_management');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('user_logged_in')) {
            redirect('auth'); // Redirect to the 'autentic' page
        }
    }
    public function ajax_list($detail = null)
    {
        $list = $this->anggota_management->get_datatables($detail);
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            if ($cat->id == '1') {
                continue;
            }

            $no++;
            $row = array();
            $status_class = ($cat->status == 1) ? 'text-success' : 'text-danger';

            // Masukkan data ke dalam array $row dengan wrapper HTML
            // yang sudah memiliki kelas status. Ini akan menerapkan warna
            // ke seluruh teks dalam sel.
            $row[] = '<span class="' . $status_class . '">' . $no . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->nomor_anggota . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->nama . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->tempat_lahir . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->tanggal_lahir . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->no_telp . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->username . '</span>';

            $this->db->select_sum('nominal_kredit');
            $this->db->from('nota');
            $this->db->where('id_anggota', $cat->id);
            $this->db->where('status', '1');
            $query = $this->db->get();
            $result = $query->row();
            $row[] = '<div class="' . $status_class . '" style="text-align: right;">Rp. ' . number_format($result->kredit_limit ?? 0, 0, ',', '.') . '</div>';


            $row[] = '<div class="' . $status_class . '" style="text-align: right;">Rp. ' . number_format($result->nominal_kredit ?? 0, 0, ',', '.') . '</div>';

            $row[] = '<span class="' . $status_class . '">' . $cat->nama_koperasi . '</span>';
            $row[] = '<span class="' . $status_class . '">' . $cat->jabatan . '</span>';

            // Status kolom terakhir
            $status_text = ($cat->status == 1) ? '<b>Aktif</b>' : '<b>Tidak Aktif</b>';
            $row[] = '<span class="' . $status_class . '">' . $status_text . '</span>';

            if ($cat->status == 1) {
                $btn_aktif = '<a title="Non-Activate User" onclick="onNonAktif(' . $cat->id . ')" class="btn btn-danger"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-x">
    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
    <circle cx="8.5" cy="7" r="4"></circle>
    <line x1="18" y1="8" x2="23" y2="13"></line>
    <line x1="23" y1="8" x2="18" y2="13"></line>
</svg></a>';
            } else {

                $btn_aktif = '<a title="Activate User" onclick="onAktif(' . $cat->id . ')" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-check">
    <path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
    <circle cx="8.5" cy="7" r="4"></circle>
    <polyline points="17 11 19 13 23 9"></polyline>
</svg></a>';
            }
            $row[] = '<center> <div class="list-icons d-inline-flex">
            <a title="Saldo Simpanan Anggota" href="' . base_url('Anggota/detail_saldo_simpanan/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#ffffff" d="M400 96l0 .7c-5.3-.4-10.6-.7-16-.7L256 96c-16.5 0-32.5 2.1-47.8 6c-.1-2-.2-4-.2-6c0-53 43-96 96-96s96 43 96 96zm-16 32c3.5 0 7 .1 10.4 .3c4.2 .3 8.4 .7 12.6 1.3C424.6 109.1 450.8 96 480 96l11.5 0c10.4 0 18 9.8 15.5 19.9l-13.8 55.2c15.8 14.8 28.7 32.8 37.5 52.9l13.3 0c17.7 0 32 14.3 32 32l0 96c0 17.7-14.3 32-32 32l-32 0c-9.1 12.1-19.9 22.9-32 32l0 64c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32l0-32-128 0 0 32c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32l0-64c-34.9-26.2-58.7-66.3-63.2-112L68 304c-37.6 0-68-30.4-68-68s30.4-68 68-68l4 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-4 0c-11 0-20 9-20 20s9 20 20 20l31.2 0c12.1-59.8 57.7-107.5 116.3-122.8c12.9-3.4 26.5-5.2 40.5-5.2l128 0zm64 136a24 24 0 1 0 -48 0 24 24 0 1 0 48 0z"/></svg></a>
            <a title="Detail Pembayaran Anggota" href="' . base_url('Anggota/detail_pembayaran/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#ffffff" d="M64 64C28.7 64 0 92.7 0 128L0 384c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64L64 64zm64 320l-64 0 0-64c35.3 0 64 28.7 64 64zM64 192l0-64 64 0c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64l0 64-64 0zm64-192c-35.3 0-64-28.7-64-64l64 0 0 64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg></svg></a>
            <a title="Detail Anggota" href="' . base_url('Anggota/detail/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><path fill="#ffffff" d="M64 32C28.7 32 0 60.7 0 96l0 32 576 0 0-32c0-35.3-28.7-64-64-64L64 32zM576 224L0 224 0 416c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-192zM112 352l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-64 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm112 16c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16z"/></svg></a>
            <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            </svg></a> ' . $btn_aktif . '
        </div></center>
        ';

            ' <a title="Delete User" onclick="onDelete(' . $cat->id . ')" class="btn btn-danger"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg></a>';

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->anggota_management->count_all($detail),
            "recordsFiltered" => $this->anggota_management->count_filtered($detail),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function index()
    {

        $data['content']     = 'webview/admin/anggota_management/anggota_management_v';
        $data['content_js'] = 'webview/admin/anggota_management/anggota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function detail($detail)
    {

        $data['content']     = 'webview/admin/anggota_management/anggota_management_v';
        $data['content_js'] = 'webview/admin/anggota_management/anggota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function add()
    {

        $data['koperasi'] = $this->anggota_management->get_koperasi();
        $data['toko'] = $this->anggota_management->get_toko_koperasi();
        $data['puskopkar'] = $this->anggota_management->get_puskopkar();
        $data['kelurahan'] = $this->anggota_management->get_kelurahan();
        $data['content']     = 'webview/admin/anggota_management/anggota_form_v';
        $data['content_js'] = 'webview/admin/anggota_management/anggota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function update($id)
    {
        $data['Anggota'] = $this->anggota_management->get_id_edit($id);
        $data['koperasi'] = $this->anggota_management->get_koperasi();
        $data['toko'] = $this->anggota_management->get_toko_koperasi();
        $data['puskopkar'] = $this->anggota_management->get_puskopkar();
        $data['kelurahan'] = $this->anggota_management->get_kelurahan();
        $data['content']     = 'webview/admin/anggota_management/anggota_form_v';
        $data['content_js'] = 'webview/admin/anggota_management/anggota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function save()
    {
        $nomor_anggota = strtoupper($this->input->post('nomor_anggota'));
        $nama = strtoupper($this->input->post('nama'));
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $no_telp = $this->input->post('no_telp');
        $kelurahan = $this->input->post('kelurahan');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $jabatan = $this->input->post('jabatan');
        $kredit_limit = (int) str_replace('.', '', $this->input->post('kredit_limit'));

        // $usage_kredit = $this->input->post('usage_kredit');
        if ($this->session->userdata('role') == "Admin") {
            $role = $this->input->post('role') ? $this->input->post('role') : 4; // 1 if checked, 0 if unchecked
            $id_koperasi = $this->input->post('id_koperasi');
            $id_toko = $this->input->post('id_toko') ? $this->input->post('id_toko') : 0;
        } else if ($this->session->userdata('role') == "Koperasi") {
            $role = $this->input->post('role') ? $this->input->post('role') : 4; // 1 if checked, 0 if unchecked
            // if ($role == 3) {
            $id_koperasi = $this->session->userdata('id_koperasi');
            // } else {
            // $id_koperasi = $this->input->post('id_koperasi');
            // }
            // $id_koperasi = $this->session->userdata('id_koperasi');
            $id_toko = $this->input->post('id_toko') ? $this->input->post('id_toko') : 0;
        } else if ($this->session->userdata('role') == "Kasir") {
            $role = 4; // 1 if checked, 0 if unchecked
            // $id_koperasi = $this->session->userdata('id_koperasi');
            $id_koperasi = $this->input->post('id_koperasi');
            $id_toko =  0;
        }
        // if ($this->session->userdata('role') != "Puskopkar") {
        //     $role = $this->input->post('role') ? $this->input->post('role') : 4; // 1 if checked, 0 if unchecked
        // } else {
        //     $role = 2; // Kalo Puskopkar Auto Create Koperasi
        // }

        // if ($role == '2' || $role == '5' || $role == '4') {
        //     $id_toko = null;
        //     $id_koperasi = $this->input->post('id_koperasi');
        // } else if ($role == '3') {
        //     $id_toko = $this->input->post('id_toko');

        //     $this->db->from('toko');
        //     $this->db->where('id', $id_toko);
        //     $toko = $this->db->get()->row();
        //     if ($toko) {
        //         $id_koperasi = $toko->id_koperasi;
        //     } else {
        //         $id_koperasi = $this->session->userdata('id_koperasi');
        //     }
        // } else {
        //     $id_toko = null;
        //     $id_koperasi = null;
        // }

        // Prepare data array
        $data = array(
            'nomor_anggota' => $nomor_anggota,
            'nama' => $nama,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'no_telp' => $no_telp,
            'kelurahan' => $kelurahan,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT), // Hash the password
            'kredit_limit' => $kredit_limit,
            // 'usage_kredit' => $usage_kredit,
            'usage_kredit' => 0,
            'jabatan' => $jabatan,
            'id_toko' => $id_toko,
            'id_koperasi' => $id_koperasi,
            'role' => $role, // Add the checkbox value to the array
            'id_creator' => $this->session->userdata('user_user_id'),
            'status' => 1,
        );

        if ($this->session->userdata('role') == "Puskopkar") {
            $data['id_puskopkar'] = $this->session->userdata('user_user_id');
        } else {
            $data['id_puskopkar'] = $this->input->post('id_puskopkar');
        }

        // Save data using the model
        $this->anggota_management->save_file($data);
        echo json_encode(array("status" => TRUE));
    }
    public function proses_update()
    {
        $id_edit = $this->input->post('id_edit');
        $nomor_anggota = strtoupper($this->input->post('nomor_anggota'));
        $nama = strtoupper($this->input->post('nama'));
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $no_telp = $this->input->post('no_telp');
        $kelurahan = $this->input->post('kelurahan');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $jabatan = $this->input->post('jabatan');
        $kredit_limit = (int) str_replace('.', '', $this->input->post('kredit_limit'));
        // $usage_kredit = $this->input->post('usage_kredit');
        $id_toko = $this->input->post('id_toko');
        // $id_koperasi = $this->input->post('id_koperasi');
        $role = $this->input->post('role') ? $this->input->post('role') : 4; // 1 if checked, 0 if unchecked
        $tanggal_simpanan_terakhir = $this->input->post('tanggal_simpanan_terakhir');
        $this->db->from('toko');
        $this->db->where('id', $id_toko);
        $toko = $this->db->get()->row();

        if ($role == 4) {
            $id_toko = null;
        }

        // Prepare data array
        $data_update = [
            'nomor_anggota' => $nomor_anggota,
            'nama' => $nama,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'no_telp' => $no_telp,
            'kelurahan' => $kelurahan,
            'username' => $username,
            // 'password' => password_hash($password, PASSWORD_BCRYPT), // Hash the password
            'kredit_limit' => $kredit_limit,
            // 'usage_kredit' => $usage_kredit,
            'jabatan' => $jabatan,
            // 'id_koperasi' => $id_koperasi,
            'id_toko' => $id_toko,
            // 'id_creator' => $this->session->userdata('user_user_id'),
            'role' => $role, // Add the checkbox value to the array
            'tanggal_simpanan_terakhir' => $tanggal_simpanan_terakhir
        ];

        if ($this->session->userdata('role') == "Puskopkar") {
            $data_update['id_puskopkar'] = $this->session->userdata('user_user_id');
        } else {
            $data_update['id_puskopkar'] = $this->input->post('id_puskopkar') ? $this->input->post('id_puskopkar') : '0';
        }

        if (!empty($password)) {
            $data_update['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->anggota_management->update_data($data_update, array('id' => $id_edit));
        // echo json_encode(array("status" => TRUE, "title" => $title));
        // $this->anggota_management->update_data($data_update, array('Id' => $id_edit));
        echo json_encode(array("status" => TRUE));
    }
    public function delete()
    {
        $id = $this->input->post('id_delete');

        $this->anggota_management->delete(array('id' => $id));

        echo json_encode(array("status" => TRUE));
    }
    public function activate_anggota()
    {
        $id = $this->input->post('id');
        $data_update = [
            'status' => 1,
        ];

        $this->anggota_management->update_data($data_update, array('id' => $id));
        echo json_encode(array("status" => TRUE));
    }
    public function non_activate_anggota()
    {
        $id = $this->input->post('id');
        $data_update = [
            'status' => 0,
        ];

        $this->anggota_management->update_data($data_update, array('id' => $id));
        echo json_encode(array("status" => TRUE));
    }
    public function upload_summernote()
    {
        $uploadDir = FCPATH . 'uploads/summernote/';
        $title = $this->input->post('title') ?? 'image'; // Dynamic title fallback

        // Ensure the directory exists
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        $config['upload_path'] = $uploadDir;
        $config['allowed_types'] = 'jpeg|jpg|png|gif';
        $config['max_size'] = 2048; // 2MB
        $config['encrypt_name'] = false; // Set to true if unique names are required
        $config['file_name'] = 'summernote_' . $title . '_' . time();

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('file')) {
            $image_data = $this->upload->data();
            $filePath = base_url('uploads/summernote/' . $image_data['file_name']);

            echo json_encode([
                'success' => true,
                'url' => $filePath,
            ]);
        } else {
            // Log and return errors
            log_message('error', 'Upload Error: ' . $this->upload->display_errors());
            echo json_encode([
                'success' => false,
                'error' => $this->upload->display_errors(),
            ]);
        }
    }
    public function getTokoByKoperasi()
    {
        // if (!$this->input->is_ajax_request()) {
        //     show_404();
        // }
        $koperasi_id = $this->input->get('id_koperasi');

        if ($koperasi_id) {
            $toko_data = $this->anggota_management->get_toko_by_koperasi($koperasi_id);
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode($toko_data));
        } else {
            // Handle case where id_koperasi is not provided
            $this->output
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'id_koperasi is required']));
        }
    }
    public function getKelurahanData()
    {
        $this->output->set_content_type('application/json');
        $search_query = $this->input->get('search'); // Get search term from query parameter
        $limit = 20; // Limit results for performance

        $this->db->select('id, kelurahan, kecamatan, kota_administrasi');
        $this->db->from('kelurahan'); // Replace 'kelurahan_table' with your actual table name

        if (!empty($search_query)) {
            $this->db->like('kelurahan', $search_query);
            $this->db->or_like('kecamatan', $search_query);
            $this->db->or_like('kota_administrasi', $search_query);
        }

        $this->db->limit($limit); // Apply limit
        $query = $this->db->get();
        $result = $query->result_array(); // Get results as an array of objects

        // Format data to match Choices.js expectation {value: 'id', label: 'text to display'}
        $formatted_data = [];
        foreach ($result as $row) {
            $formatted_data[] = [
                'value' => $row['kelurahan'],
                'label' => $row['kelurahan'] . ' - ' . $row['kecamatan'] . ' - ' . $row['kota_administrasi']
            ];
        }

        echo json_encode($formatted_data);
    }

    public function process_insert_excel()
    {
        $this->load->library('upload');
        require APPPATH . 'third_party/autoload.php';
        require APPPATH . 'third_party/psr/simple-cache/src/CacheInterface.php';
        set_time_limit(300); // 300 seconds = 5 minutes
        $config['upload_path'] = FCPATH . 'uploads/anggota_management';
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

                $nomor_anggota = isset($rowData[0]) ? $rowData[0] : null;
                $cek_anggota = $this->db->get_where('anggota', ['nomor_anggota' => $nomor_anggota])->num_rows();

                if ($cek_anggota != 0) {
                    // Collect the error instead of returning
                    $validationErrors[] = 'Baris ' . $rowIndex . ': Nomor Anggota "' . $nomor_anggota . '" sudah digunakan.';
                    continue; // Skip this row and continue processing others
                }

                $tanggal_excel = isset($rowData[3]) ? $rowData[3] : null;
                if (is_numeric($tanggal_excel)) {
                    // Excel date serial to Y-m-d
                    $tanggal_lahir = date('Y-m-d', \PhpOffice\PhpSpreadsheet\Shared\Date::excelToTimestamp($tanggal_excel));
                } elseif (!empty($tanggal_excel)) {
                    // Already a valid date string
                    $tanggal_lahir = date('Y-m-d', strtotime($tanggal_excel));
                }
                $date = new DateTime($tanggal_lahir);


                $no_telp = $rowData[4];
                $cek_no_telp = $this->db->get_where('anggota', ['no_telp' => $no_telp])->num_rows();

                // echo $no_telp;

                // if ($cek_no_telp != 0) {
                //     // Collect the error instead of returning
                //     $validationErrors[] = 'Baris ' . $rowIndex . ': Nomor Telepon "' . $no_telp . '" sudah digunakan.';
                //     continue; // Skip this row and continue processing others
                // }

                $enc_password = password_hash('password123', PASSWORD_DEFAULT);

                // Now map Excel columns to database fields
                $dataInsert[] = [
                    // 'id'          => $new_id, // **USE GENERATED ID**
                    'nomor_anggota'  => $nomor_anggota,
                    'nama'     => isset($rowData[1]) ? $rowData[1] : null,
                    'tempat_lahir'     => isset($rowData[2]) ? $rowData[2] : null,
                    'tanggal_lahir'   => $tanggal_lahir,
                    'no_telp' => $no_telp,
                    'username' => $nomor_anggota,
                    'password' => $enc_password,
                    'jabatan' => "Anggota",
                    'role' => 4,
                    'id_creator' => $this->session->userdata('user_user_id'),
                    // 'id_toko' => $this->session->userdata('id_toko'),
                    'id_koperasi' => $this->session->userdata('id_koperasi'),
                    'status' => 1,
                ];
            }

            if (!empty($validationErrors)) {
                // If there are any validation errors, don't proceed with insert
                echo json_encode(['status' => false, 'message' => 'Validasi Gagal: ' . implode('<br>', $validationErrors)]);
                // Important: No transaction started yet, so no need for rollback
                return;
            }

            // If no validation errors, proceed with database transaction and insert
            if (empty($dataInsert)) {
                echo json_encode(['status' => false, 'message' => 'Tidak ada data valid yang ditemukan untuk diimpor.']);
                return;
            }

            $this->db->trans_start(); // Start the transaction
            $this->db->insert_batch('anggota', $dataInsert); // Bulk insert
            $this->db->trans_complete(); // This will either commit or rollback based on previous operations

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
