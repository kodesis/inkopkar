<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Koperasi_Management extends CI_Controller
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
        $this->load->model('koperasi_Management_m', 'koperasi_management');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('user_logged_in')) {
            redirect('auth'); // Redirect to the 'autentic' page
        }
    }
    public function ajax_list()
    {
        $list = $this->koperasi_management->get_datatables();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cat->nama_koperasi;
            $row[] = $cat->alamat;
            $row[] = $cat->telp;
            // $row[] = $cat->view_count;
            // $row[] = $cat->halaman_page;

            $row[] = '<center> <div class="list-icons d-inline-flex">
                <a title="Update User" href="' . base_url('Koperasi_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
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
            "recordsTotal" => $this->koperasi_management->count_all(),
            "recordsFiltered" => $this->koperasi_management->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function index()
    {

        $data['content']     = 'webview/admin/koperasi_management/koperasi_management_v';
        $data['content_js'] = 'webview/admin/koperasi_management/koperasi_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function add()
    {

        // $data['category'] = $this->koperasi_management->get_category();
        $data['content']     = 'webview/admin/koperasi_management/koperasi_form_v';
        $data['content_js'] = 'webview/admin/koperasi_management/koperasi_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function update($id)
    {
        $data['Koperasi'] = $this->koperasi_management->get_id_edit($id);
        // $data['category'] = $this->koperasi_management->get_category();
        $data['content']     = 'webview/admin/koperasi_management/koperasi_form_v';
        $data['content_js'] = 'webview/admin/koperasi_management/koperasi_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function save()
    {
        $nama_koperasi = $this->input->post('nama_koperasi');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');

        $this->koperasi_management->save_file(
            array(
                'nama_koperasi'            => $nama_koperasi,
                'alamat'            => $alamat,
                'telp'             => $telp,
            ),
        );
        echo json_encode(array("status" => TRUE));
    }
    public function proses_update()
    {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $id_edit = $this->input->post('id_edit');
        $nama_koperasi = $this->input->post('nama_koperasi');
        $alamat = $this->input->post('alamat');
        $telp = $this->input->post('telp');

        $data_update = [
            'nama_koperasi'             => $nama_koperasi,
            'alamat'              => $alamat,
            'telp'              => $telp,
        ];


        $this->koperasi_management->update_data($data_update, array('id' => $id_edit));
        // echo json_encode(array("status" => TRUE, "title" => $title));
        // $this->koperasi_management->update_data($data_update, array('Id' => $id_edit));
        echo json_encode(array("status" => TRUE));
    }
    public function delete()
    {
        $id = $this->input->post('id_delete');

        $this->koperasi_management->delete(array('id' => $id));

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
