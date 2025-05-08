<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Profile extends CI_Controller
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
    public function index()
    {
        $this->db->from('anggota');
        $this->db->where('id', $this->session->userdata('user_user_id'));
        $query = $this->db->get();

        $detail = $query->row();
        $data['detail'] = $detail;
        $data['content'] = 'webview/admin/profile/profile_v';
        $data['content_js'] = 'webview/admin/profile/profile_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function update()
    {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $id_edit = $this->input->post('id_anggota');

        $data_update = [
            'nama'             => $this->input->post('nama'),
            'tempat_lahir'              => $this->input->post('tempat_lahir'),
            'tanggal_lahir'              => $this->input->post('tanggal_lahir'),
            'no_telp'              => $this->input->post('no_telp'),
        ];

        if ($this->input->post('password') != null) {
            $enc_password = password_hash($this->input->post('password1'), PASSWORD_DEFAULT);

            $data_update['password'] = $enc_password;
        }


        // Continue only if dimensions were correct
        $this->anggota_management->update_profile($data_update, array('id' => $id_edit));
        echo json_encode(array("status" => TRUE));
    }
}
