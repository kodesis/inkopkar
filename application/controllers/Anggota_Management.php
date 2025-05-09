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
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cat->nomor_anggota;
            $row[] = $cat->nama;
            $row[] = $cat->tempat_lahir;
            $row[] = $cat->tanggal_lahir;
            $row[] = $cat->no_telp;
            $row[] = $cat->username;
            // $row[] = $cat->kredit_limit;
            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $cat->kredit_limit,
                0,
                ',',
                '.'
            ) . '</div>';
            // $row[] = $cat->usage_kredit;
            $this->db->select_sum('nominal_kredit');
            $this->db->from('nota');
            $this->db->where('id_anggota', $cat->id);
            $this->db->where('status', '1');
            $query = $this->db->get();
            $result = $query->row();

            // $row[] = '<div style="text-align: right;">' . number_format(
            //     $cat->usage_kredit,
            //     0,
            //     ',',
            //     '.'
            // ) . '</div>';
            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $result->nominal_kredit ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';

            $this->db->select_sum('nominal');
            $this->db->from('saldo_simpanan');
            $this->db->where('id_anggota', $cat->id);
            $this->db->where('status', '1');
            $query = $this->db->get();
            $result = $query->row();
            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $result->nominal ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';


            $row[] = $cat->nama_koperasi;
            if ($cat->role == '1') {
                $row[] = 'Admin';
            } else if ($cat->role == '2') {
                $row[] = 'Koperasi';
            } else if ($cat->role == '3') {
                $row[] = 'Kasir';
            } else {
                $row[] = 'Anggota';
            }
            // $row[] = $cat->view_count;
            // $row[] = $cat->halaman_page;

            // $row[] = $cat->nama_koperasi . " - " . $cat->nama_toko;



            $row[] = '<center> <div class="list-icons d-inline-flex">
            <a title="Detail User" href="' . base_url('Anggota/detail_saldo_simpanan/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M400 96l0 .7c-5.3-.4-10.6-.7-16-.7L256 96c-16.5 0-32.5 2.1-47.8 6c-.1-2-.2-4-.2-6c0-53 43-96 96-96s96 43 96 96zm-16 32c3.5 0 7 .1 10.4 .3c4.2 .3 8.4 .7 12.6 1.3C424.6 109.1 450.8 96 480 96l11.5 0c10.4 0 18 9.8 15.5 19.9l-13.8 55.2c15.8 14.8 28.7 32.8 37.5 52.9l13.3 0c17.7 0 32 14.3 32 32l0 96c0 17.7-14.3 32-32 32l-32 0c-9.1 12.1-19.9 22.9-32 32l0 64c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32l0-32-128 0 0 32c0 17.7-14.3 32-32 32l-32 0c-17.7 0-32-14.3-32-32l0-64c-34.9-26.2-58.7-66.3-63.2-112L68 304c-37.6 0-68-30.4-68-68s30.4-68 68-68l4 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-4 0c-11 0-20 9-20 20s9 20 20 20l31.2 0c12.1-59.8 57.7-107.5 116.3-122.8c12.9-3.4 26.5-5.2 40.5-5.2l128 0zm64 136a24 24 0 1 0 -48 0 24 24 0 1 0 48 0z"/></svg></a>

             <a title="Detail User" href="' . base_url('Anggota/detail_pembayaran/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M64 64C28.7 64 0 92.7 0 128L0 384c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-256c0-35.3-28.7-64-64-64L64 64zm64 320l-64 0 0-64c35.3 0 64 28.7 64 64zM64 192l0-64 64 0c0 35.3-28.7 64-64 64zM448 384c0-35.3 28.7-64 64-64l0 64-64 0zm64-192c-35.3 0-64-28.7-64-64l64 0 0 64zM288 160a96 96 0 1 1 0 192 96 96 0 1 1 0-192z"/></svg></svg></a>

             <a title="Detail User" href="' . base_url('Anggota/detail/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M64 32C28.7 32 0 60.7 0 96l0 32 576 0 0-32c0-35.3-28.7-64-64-64L64 32zM576 224L0 224 0 416c0 35.3 28.7 64 64 64l448 0c35.3 0 64-28.7 64-64l0-192zM112 352l64 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-64 0c-8.8 0-16-7.2-16-16s7.2-16 16-16zm112 16c0-8.8 7.2-16 16-16l128 0c8.8 0 16 7.2 16 16s-7.2 16-16 16l-128 0c-8.8 0-16-7.2-16-16z"/></svg></a>

                <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg></a> 

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
        $data['content']     = 'webview/admin/anggota_management/anggota_form_v';
        $data['content_js'] = 'webview/admin/anggota_management/anggota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function save()
    {
        $nomor_anggota = $this->input->post('nomor_anggota');
        $nama = $this->input->post('nama');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $no_telp = $this->input->post('no_telp');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $kredit_limit = (int) str_replace('.', '', $this->input->post('kredit_limit'));

        // $usage_kredit = $this->input->post('usage_kredit');
        if ($this->session->userdata('role') != "Puskopkar") {
            $role = $this->input->post('role') ? $this->input->post('role') : 4; // 1 if checked, 0 if unchecked
        } else {
            $role = 2; // Kalo Puskopkar Auto Create Koperasi
        }
        if ($role == '2' || $role == '5' || $role == '4') {
            $id_toko = null;
            $id_koperasi = $this->input->post('id_koperasi');
        } else if ($role == '3') {
            $id_toko = $this->input->post('id_toko');

            $this->db->from('toko');
            $this->db->where('id', $id_toko);
            $toko = $this->db->get()->row();
            if ($toko) {
                $id_koperasi = $toko->id_koperasi;
            } else {
                $id_koperasi = $this->session->userdata('id_koperasi');
            }
        } else {
            $id_toko = null;
            $id_koperasi = null;
        }

        // Prepare data array
        $data = array(
            'nomor_anggota' => $nomor_anggota,
            'nama' => $nama,
            'tempat_lahir' => $tempat_lahir,
            'tanggal_lahir' => $tanggal_lahir,
            'no_telp' => $no_telp,
            'username' => $username,
            'password' => password_hash($password, PASSWORD_BCRYPT), // Hash the password
            'kredit_limit' => $kredit_limit,
            // 'usage_kredit' => $usage_kredit,
            'usage_kredit' => 0,
            'id_toko' => $id_toko,
            'id_koperasi' => $id_koperasi,
            'role' => $role, // Add the checkbox value to the array
            'id_creator' => $this->session->userdata('user_user_id'),
        );

        if ($role == 2) {
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
        $nomor_anggota = $this->input->post('nomor_anggota');
        $nama = $this->input->post('nama');
        $tempat_lahir = $this->input->post('tempat_lahir');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $no_telp = $this->input->post('no_telp');
        $username = $this->input->post('username');
        $password = $this->input->post('password');
        $kredit_limit = (int) str_replace('.', '', $this->input->post('kredit_limit'));
        // $usage_kredit = $this->input->post('usage_kredit');
        $id_toko = $this->input->post('id_toko');
        $role = $this->input->post('role') ? $this->input->post('role') : 4; // 1 if checked, 0 if unchecked

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
            'username' => $username,
            // 'password' => password_hash($password, PASSWORD_BCRYPT), // Hash the password
            'kredit_limit' => $kredit_limit,
            // 'usage_kredit' => $usage_kredit,
            'id_toko' => $id_toko,
            'id_toko' => $id_toko,
            // 'id_creator' => $this->session->userdata('user_user_id'),
            'role' => $role // Add the checkbox value to the array
        ];

        if ($role == 2) {
            $data['id_puskopkar'] = $this->session->userdata('user_user_id');
        } else {
            $data['id_puskopkar'] = $this->input->post('id_puskopkar');
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
}
