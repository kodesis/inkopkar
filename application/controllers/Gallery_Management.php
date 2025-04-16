<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Gallery_Management extends CI_Controller
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
        $this->load->model('Gallery_Management_m', 'gallery_management');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('user_logged_in')) {
            redirect('auth'); // Redirect to the 'autentic' page
        }
    }
    public function ajax_list()
    {
        $list = $this->gallery_management->get_datatables();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            $path = base_url() . 'uploads/gallery/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $no;
            // $row[] = $cat->category;
            // $row[] = $cat->title;
            $row[] = '<img width="100px" src="' . $path . '">';
            // $row[] = $cat->tanggal;
            // $row[] = $cat->view_count;
            // $row[] = $cat->halaman_page;

            $row[] = '<center> <div class="list-icons d-inline-flex">
            <a title="Detail Gallery" href="' . base_url('gallery/detail/' . $cat->Id) . '" class="btn btn-secondary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M288 80c-65.2 0-118.8 29.6-159.9 67.7C89.6 183.5 63 226 49.4 256c13.6 30 40.2 72.5 78.6 108.3C169.2 402.4 222.8 432 288 432s118.8-29.6 159.9-67.7C486.4 328.5 513 286 526.6 256c-13.6-30-40.2-72.5-78.6-108.3C406.8 109.6 353.2 80 288 80zM95.4 112.6C142.5 68.8 207.2 32 288 32s145.5 36.8 192.6 80.6c46.8 43.5 78.1 95.4 93 131.1c3.3 7.9 3.3 16.7 0 24.6c-14.9 35.7-46.2 87.7-93 131.1C433.5 443.2 368.8 480 288 480s-145.5-36.8-192.6-80.6C48.6 356 17.3 304 2.5 268.3c-3.3-7.9-3.3-16.7 0-24.6C17.3 208 48.6 156 95.4 112.6zM288 336c44.2 0 80-35.8 80-80s-35.8-80-80-80c-.7 0-1.3 0-2 0c1.3 5.1 2 10.5 2 16c0 35.3-28.7 64-64 64c-5.5 0-10.9-.7-16-2c0 .7 0 1.3 0 2c0 44.2 35.8 80 80 80zm0-208a128 128 0 1 1 0 256 128 128 0 1 1 0-256z"/></svg></a>
                <a title="Update User" href="' . base_url('Gallery_Management/update/' . $cat->Id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg></a>
                                                <a title="Delete User" onclick="onDelete(' . $cat->Id . ')" class="btn btn-danger"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
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
            "recordsTotal" => $this->gallery_management->count_all(),
            "recordsFiltered" => $this->gallery_management->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function index()
    {

        $data['content']     = 'webview/admin/gallery_management/gallery_management_v';
        $data['content_js'] = 'webview/admin/gallery_management/gallery_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function add()
    {

        $data['category'] = $this->gallery_management->get_category();
        $data['content']     = 'webview/admin/gallery_management/gallery_form_v';
        $data['content_js'] = 'webview/admin/gallery_management/gallery_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function update($id)
    {
        $data['gallery'] = $this->gallery_management->get_id_edit($id);
        $data['category'] = $this->gallery_management->get_category();
        $data['content']     = 'webview/admin/gallery_management/gallery_form_v';
        $data['content_js'] = 'webview/admin/gallery_management/gallery_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function save()
    {
        $kategori = $this->input->post('kategori');
        $title = $this->input->post('title');
        // $thumbnail = $this->input->post('thumbnail');
        $text = $this->input->post('text');
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jam');

        $tanggal_full = $tanggal . ' ' . $jam;

        $config['upload_path'] = FCPATH . 'uploads/gallery/'; // Same as the config file
        $config['allowed_types'] = 'jpg|jpeg|png';
        $config['file_name'] = 'thumbnail_' . $title;

        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if (!$this->upload->do_upload('thumbnail')) {
            $error = $this->upload->display_errors();
            // echo $error;
            echo json_encode(array("status" => FALSE, "Pesan" => $error));
        } else {
            $image_data = $this->upload->data();
            $thumbnail = file_get_contents($image_data['full_path']);
            // CEK SIZE
            $file_path = $image_data['full_path']; // Full file path

            list($width, $height) = getimagesize($file_path); // Get dimensions of the uploaded image

            // if ($width == 670 && $height == 503) {
            //     $file = $image_data['file_name'];
            //     $this->team->save_file(
            //         array(

            //             // 'created'           => $date->format('Y-m-d H:i:s'),
            //             'file' => $file,
            //             'nama'             => $nama,
            //             'posisi'              => $posisi,
            //             'detail_posisi'           => $detail_posisi,
            //         )
            //     );
            //     echo json_encode(array("status" => TRUE));
            // } else {
            //     // Dimensions are incorrect, delete the uploaded file and return error
            //     unlink($file_path); // Delete the uploaded file
            //     echo json_encode(array(
            //         "status" => "Size Salah",
            //         "message" => "Image dimensions must be exactly 670x503 pixels."
            //     ));
            // }

            $file = $image_data['file_name'];
            $this->gallery_management->save_file(
                array(

                    // 'category'           => $kategori,
                    'title'             => $title,
                    'thumbnail'            => $file,
                    'text'            => $text,
                    'tanggal'             => $tanggal_full,
                    'view_count' => 0
                ),
            );
            echo json_encode(array("status" => TRUE));
        }
    }
    public function proses_update()
    {
        $date = new DateTime('now', new DateTimeZone('Asia/Jakarta'));
        $id_edit = $this->input->post('id_edit');
        $kategori = $this->input->post('kategori');
        $title = $this->input->post('title');
        // $thumbnail = $this->input->post('thumbnail');
        $text = $this->input->post('text');
        $tanggal = $this->input->post('tanggal');
        $jam = $this->input->post('jam');
        $tanggal_full = $tanggal . ' ' . $jam;

        $data_update = [
            // 'updated'           => $date->format('Y-m-d H:i:s'),
            // 'category'             => $kategori,
            'title'             => $title,
            'text'              => $text,
            'tanggal'              => $tanggal_full,
        ];

        $config['upload_path'] = FCPATH . 'uploads/gallery/'; // Same as the config file
        $config['allowed_types'] = 'jpeg|jpg|png';
        $config['file_name'] = 'thumbnail_' . $title;


        $this->load->library('upload', $config);
        $this->upload->initialize($config);

        if ($this->upload->do_upload('thumbnail')) {
            $image_data = $this->upload->data();
            $imgdata = file_get_contents($image_data['full_path']);
            $file = $image_data['file_name'];

            // $file_path = $image_data['full_path']; // Full file path

            // list($width, $height) = getimagesize($file_path); // Get dimensions of the uploaded image

            // if ($width == 670 && $height == 503) {
            //     // Correct dimensions, proceed with update
            //     $data_update['file_team'] = $file;
            // } else {
            //     // Dimensions are incorrect, delete the uploaded file and return error
            //     unlink($file_path); // Delete the uploaded file
            //     echo json_encode(array(
            //         "status" => "Size Salah",
            //         "message" => "Image dimensions must be exactly 670x503 pixels."
            //     ));
            //     return; // Stop execution here
            // }
            $data_update['thumbnail'] = $file;
        }

        // Continue only if dimensions were correct
        $this->gallery_management->update_file($data_update, array('Id' => $id_edit));
        echo json_encode(array("status" => TRUE, "title" => $title));
        // $this->gallery_management->update_file($data_update, array('Id' => $id_edit));
        // echo json_encode(array("status" => TRUE, "title" => $title));
    }
    public function delete()
    {
        $id = $this->input->post('id_delete');
        $this->db->select('*');
        $this->db->from('gallery');
        $this->db->where('Id', $id);
        $query = $this->db->get()->row();
        $filePath = './uploads/gallery/' . $query->thumbnail;
        $this->gallery_management->delete(array('Id' => $id));
        if (file_exists($filePath)) {
            unlink($filePath); // Delete the file from the uploads folder
        }
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
