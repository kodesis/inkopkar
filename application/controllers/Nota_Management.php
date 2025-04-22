<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Nota_Management extends CI_Controller
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
    public function add()
    {

        $data['anggota'] = $this->nota_management->get_anggota();
        $data['content']     = 'webview/admin/nota_management/nota_form_v';
        $data['content_js'] = 'webview/admin/nota_management/nota_management_js';
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
        $latest_entry = $this->nota_management->get_latest_entry($current_year);

        if ($latest_entry) {
            // Extract only the first 6 digits of the latest ID (numeric part)
            $latest_number = (int) substr($latest_entry->id, 0, 6);
            $new_number = str_pad($latest_number + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $new_number = "000001"; // Start from 000001 if no previous entry
        }

        $usage_now = $anggota->usage_kredit + $nominal_kredit;
        if ($usage_now >= $anggota->kredit_limit) {
            $cash = $usage_now - $anggota->kredit_limit;
            $kredit = $nominal_kredit - $cash;
        } else {
            $cash = 0;
            $kredit = $nominal_kredit;
        }

        // Create the new ID
        $new_id = $new_number . $current_year;

        // Save the new data
        $sub_id = $this->nota_management->save_file([
            'id'             => $new_id, // New generated ID
            'tanggal_jam'    => $date,
            'id_anggota'     => $id_anggota,
            'nominal_kredit' => $kredit,
            'nominal_cash' => $cash,
            'token'          => $token,
            'id_kasir'       => $this->session->userdata('user_user_id'),
            'id_toko'        => $this->session->userdata('id_toko'),
            'status'         => 0
        ]);

        // $task_name = $get_task_detail['task_name'];
        // $nama_member = $get_user["nama"];
        // $comment = $this->input->post("commentt");
        // $nama_session = $this->session->userdata('nama');
        // $msg = "Kode verifikasi Anda adalah: " . $token . " \n Gunakan kode ini untuk melengkapi proses verifikasi nota anda.";
        // $this->api_whatsapp->wa_notif($msg, $anggota->no_telp);
        // Update anggota's usage_kredit
        // $usage_kredit = $anggota->usage_kredit + $nominal_kredit;

        // $this->anggota_management->update_data(['usage_kredit' => $usage_kredit], ['id' => $id_anggota]);
        $msg = "Kode verifikasi Anda adalah: " . $token . " \n Gunakan kode ini untuk melengkapi proses verifikasi nota anda.";
        $response = $this->api_whatsapp->wa_notif($msg, $anggota->no_telp);

        if (!$response) {
            echo json_encode(["status" => FALSE, "error" => "Failed to send WhatsApp message"]);
            exit;
        } elseif (isset($response['error'])) {
            echo json_encode(["status" => FALSE, "error" => $response['error']]);
            exit;
        }

        // If successful
        echo json_encode(["status" => TRUE, "sub_id" => $sub_id, "Telp" => $anggota->no_telp]);

        // echo json_encode(["status" => TRUE, "sub_id" => $sub_id]);
    }

    public function proses_verifikasi()
    {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $id_nota = $this->input->post('id_nota');
        $nota = $this->nota->get_id_nota($id_nota);
        if ($this->input->post('token') == $nota->token) {
            $data_update = [
                'token'            => null,
                'status'            => 1,
            ];

            $anggota = $this->anggota_management->get_id_edit($nota->id_anggota);
            $usage_kredit = $anggota->usage_kredit + $nota->nominal_kredit;

            $this->anggota_management->update_data(['usage_kredit' => $usage_kredit], ['id' => $nota->id_anggota]);

            $this->nota_management->update_data($data_update, array('sub_id' => $id_nota));
            // echo json_encode(array("status" => TRUE, "title" => $title));
            // $this->nota_management->update_data($data_update, array('Id' => $id_edit));
            echo json_encode(array("status" => TRUE, "id_anggota" => $nota->id_anggota));
        } else {
            echo json_encode(array("status" => FALSE, "Pesan" => 'Token Salah'));
        }
    }
    // public function proses_update()
    // {
    //     $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
    //     $id_edit = $this->input->post('id_edit');
    //     $id_anggota = $this->input->post('id_anggota');
    //     $nominal_kredit = $this->input->post('nominal_kredit');

    //     $data_update = [
    //         'tanggal_jam'            => $date,
    //         'id_anggota'            => $id_anggota,
    //         'nominal_kredit'             => $nominal_kredit,
    //     ];


    //     $this->nota_management->update_data($data_update, array('id' => $id_edit));
    //     // echo json_encode(array("status" => TRUE, "title" => $title));
    //     // $this->nota_management->update_data($data_update, array('Id' => $id_edit));
    //     echo json_encode(array("status" => TRUE));
    // }
    public function delete()
    {
        $id = $this->input->post('id_delete');

        $nota = $this->nota_management->get_id_edit($id);

        $anggota = $this->anggota_management->get_id_edit($nota->id_anggota);

        $usage_kredit = $anggota->usage_kredit - $nota->nominal_kredit;
        // Prepare data array
        $data_update = [
            'usage_kredit' => $usage_kredit,
        ];

        $this->anggota_management->update_data($data_update, array('id' => $nota->id_anggota));

        $this->nota_management->delete(array('id' => $id));

        echo json_encode(array("status" => TRUE));
    }

    public function get_anggota()
    {
        $data = $this->nota_management->get_anggota(); // Get anggota data from DB
        echo json_encode($data);
    }

    public function cari_detail_user($id)
    {
        $anggota = $this->anggota_management->get_id_edit($id);
        echo json_encode(array("status" => TRUE, 'nama' => $anggota->nama, 'nomor_anggota' => $anggota->nomor_anggota, 'kredit_limit' => $anggota->kredit_limit, 'usage_kredit' => $anggota->usage_kredit));
    }

    public function add_pembayaran()
    {
        $data['anggota'] = $this->nota_management->get_anggota_by_koperasi();
        $data['content']     = 'webview/admin/nota_management/nota_pembayaran_form_v';
        $data['content_js'] = 'webview/admin/nota_management/nota_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function save_pembayaran()
    {
        $date = (new DateTime('now', new DateTimeZone('Asia/Jakarta')))->format('Y-m-d H:i:s');
        $id_anggota = $this->input->post('id_anggota');
        $anggota = $this->anggota_management->get_id_edit($id_anggota);

        $nominal_bayar = (int) str_replace('.', '', $this->input->post('nominal_kredit'));
        $token = random_int(100000, 999999); // Generate a secure random number

        // Get the current year
        $current_year = date('Y');

        // Get the latest ID from the database for the current year
        $latest_entry = $this->nota_management->get_latest_entry_pembayaran($current_year);

        if ($latest_entry) {
            // Extract only the first 6 digits of the latest ID (numeric part)
            $latest_number = (int) substr($latest_entry->id, 0, 6);
            $new_number = str_pad($latest_number + 1, 6, '0', STR_PAD_LEFT);
        } else {
            $new_number = "000001"; // Start from 000001 if no previous entry
        }

        $usage_now = $anggota->usage_kredit - $nominal_bayar;

        // Create the new ID
        $new_id = $new_number . $current_year;

        // Save the new data
        $sub_id = $this->nota_management->save_pembayaran([
            'id'             => $new_id, // New generated ID
            'tanggal_jam'    => $date,
            'id_anggota'     => $id_anggota,
            'nominal' => $nominal_bayar,
            'token'          => $token,
            'id_kasir'       => $this->session->userdata('user_user_id'),
            'id_toko'        => $this->session->userdata('id_toko'),
            'status'         => 1
        ]);

        $Pergantian_status = $this->nota_management->get_nota_kredit_by_anggota_id($id_anggota);
        // $task_name = $get_task_detail['task_name'];
        // $nama_member = $get_user["nama"];
        // $comment = $this->input->post("commentt");
        // $nama_session = $this->session->userdata('nama');
        // $msg = "Kode verifikasi Anda adalah: " . $token . " \n Gunakan kode ini untuk melengkapi proses verifikasi nota anda.";
        // $this->api_whatsapp->wa_notif($msg, $anggota->no_telp);
        // Update anggota's usage_kredit
        // $usage_kredit = $anggota->usage_kredit + $nominal_kredit;

        // $this->anggota_management->update_data(['usage_kredit' => $usage_kredit], ['id' => $id_anggota]);
        $anggota = $this->anggota_management->get_id_edit($id_anggota);

        $update = $this->anggota_management->update_data(['usage_kredit' => $usage_now], ['id' => $id_anggota]);


        $toko = $this->toko_management->get_id_edit($anggota->id_toko);
        $koperasi = $this->koperasi_management->get_id_edit($toko->id_koperasi);
        $saldo_tagihan = $koperasi->saldo_tagihan + $nominal_bayar;

        $this->koperasi_management->update_data(['saldo_tagihan' => $saldo_tagihan], ['id' => $koperasi->id]);

        if (!$sub_id) {
            echo json_encode(["status" => FALSE, "error" => "Failed to send WhatsApp message"]);
            exit;
        } elseif (isset($response['error'])) {
            echo json_encode(["status" => FALSE, "error" => $response['error']]);
            exit;
        }

        // If successful
        echo json_encode(["status" => TRUE, "sub_id" => $sub_id, "Telp" => $anggota->no_telp]);

        // echo json_encode(["status" => TRUE, "sub_id" => $sub_id]);
    }
}
