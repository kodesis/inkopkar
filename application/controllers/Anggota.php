<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Anggota extends CI_Controller
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
        $this->load->model('Nota_m', 'nota');
        $this->load->model('anggota_Management_m', 'anggota_management');
        $this->load->model('toko_Management_m', 'toko_management');
        $this->load->model('koperasi_Management_m', 'koperasi_management');
        $this->load->model('nota_Management_m', 'nota_management');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('user_logged_in')) {
            redirect('auth'); // Redirect to the 'autentic' page
        }
    }
    public function ajax_list($id)
    {
        $list = $this->nota->get_datatables($id);
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $cat->id;
            $date = new DateTime($cat->tanggal_jam);
            $row[] = $date->format('d F Y, H:i:s');
            // $row[] = $cat->nama;
            // $row[] = "Rp. " . $cat->nominal_kredit;
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->nominal_kredit,
                0,
                ',',
                '.'
            ) . '</div>';
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->nominal_cash,
                0,
                ',',
                '.'
            ) . '</div>';
            // $row[] = $cat->tanggal_jam;
            $row[] = $cat->nama_koperasi . " - " . $cat->nama_toko . " - " . $cat->nama;
            // $row[] = $cat->view_count;
            if ($cat->status == 0) {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                                                <a title="Delete User" href="' . base_url('nota_management/verifikasi/' . $cat->sub_id) . '" class="btn btn-danger">Belum Verifikasi</a>
            </div>
    </center>';
                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a title="Delete User" onclick="onDelete(' . $cat->sub_id . ')" class="btn btn-danger"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
                                                        <polyline points="3 6 5 6 21 6"></polyline>
                                                        <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                                        <line x1="10" y1="11" x2="10" y2="17"></line>
                                                        <line x1="14" y1="11" x2="14" y2="17"></line>
                                                    </svg></a>
            </div>
    </center>';
            } else {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a class="btn btn-success">Terverifikasi</a>
            </div>
    </center>';
                $row[] = '';
            }
            // <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"> <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path> <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path> </svg></a>


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->nota->count_all($id),
            "recordsFiltered" => $this->nota->count_filtered($id),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function detail($id)
    {
        $data['Anggota'] = $this->anggota_management->get_id_edit($id);
        $data['content']     = 'webview/admin/nota/nota_v';
        $data['content_js'] = 'webview/admin/nota/nota_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function add()
    {

        $data['koperasi'] = $this->nota->get_koperasi();
        $data['content']     = 'webview/admin/nota/anggota_form_v';
        $data['content_js'] = 'webview/admin/nota/nota_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function update($id)
    {
        $data['Anggota'] = $this->nota->get_id_edit($id);
        $data['koperasi'] = $this->nota->get_koperasi();
        $data['content']     = 'webview/admin/nota/anggota_form_v';
        $data['content_js'] = 'webview/admin/nota/nota_js';
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
        $kredit_limit = $this->input->post('kredit_limit');
        $usage_kredit = $this->input->post('usage_kredit');
        $id_koperasi = $this->input->post('id_koperasi');

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
            'id_koperasi' => $id_koperasi
        );

        // Save data using the model
        $this->nota->save_file($data);
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
        $kredit_limit = $this->input->post('kredit_limit');
        $usage_kredit = $this->input->post('usage_kredit');
        $id_koperasi = $this->input->post('id_koperasi');

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
            'usage_kredit' => $usage_kredit,
            'id_koperasi' => $id_koperasi
        ];

        if (!empty($password)) {
            $data_update['password'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->nota->update_data($data_update, array('id' => $id_edit));
        // echo json_encode(array("status" => TRUE, "title" => $title));
        // $this->nota->update_data($data_update, array('Id' => $id_edit));
        echo json_encode(array("status" => TRUE));
    }
    public function delete()
    {

        $id = $this->input->post('id_delete');

        $nota = $this->nota->get_id_nota($id);

        if ($nota->status == 1) {
            // $anggota = $this->anggota_management->get_id_edit($nota->id_anggota);

            // $usage_kredit = $anggota->usage_kredit - $nota->nominal_kredit;
            // // Prepare data array
            // $data_update = [
            //     'usage_kredit' => $usage_kredit,
            // ];

            // $this->anggota_management->update_data($data_update, array('id' => $nota->id_anggota));

            echo json_encode(array("status" => 'Tidak Bisa Delete'));
            return;
        }
        $this->nota_management->delete(array('sub_id' => $id));

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
    public function detail_pembayaran($id)
    {
        $anggota = $this->anggota_management->get_id_edit($id);
        $data['Anggota'] = $anggota;
        $toko = $this->toko_management->get_id_edit($anggota->id_toko);
        $koperasi = $this->koperasi_management->get_id_edit($toko->id_koperasi);
        $data['koperasi'] = $koperasi;
        $data['content']     = 'webview/admin/nota/nota_pembayaran_v';
        $data['content_js'] = 'webview/admin/nota/nota_pembayaran_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function ajax_list_pembayaran($id)
    {
        $list = $this->nota->get_datatables_pembayaran($id);
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $cat->id;
            $date = new DateTime($cat->tanggal_jam);
            $row[] = $date->format('d F Y, H:i:s');
            // $row[] = $cat->nama;
            // $row[] = "Rp. " . $cat->nominal_kredit;
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->nominal,
                0,
                ',',
                '.'
            ) . '</div>';
            // $row[] = $cat->tanggal_jam;
            $row[] = $cat->nama_koperasi . " - " . $cat->nama_toko . " - " . $cat->nama;
            // $row[] = $cat->view_count;
            if ($cat->status == "1") {

                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a class="btn btn-success">Terbayar Ke Koperasi</a>
            </div>
    </center>';
            } else if ($cat->status == "1") {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a class="btn btn-success">Terbayar Ke Inkopkar</a>
            </div>
    </center>';
            }
            // <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"> <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path> <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path> </svg></a>


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->nota->count_all_pembayaran($id),
            "recordsFiltered" => $this->nota->count_filtered_pembayaran($id),
            "data" => $data,
        );
        echo json_encode($output);
    }
}
