<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_Kasir extends CI_Controller
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
        $this->load->model('Riwayat_Kasir_m', 'riwayat_kasir');
        $this->load->model('anggota_Management_m', 'anggota_management');
        $this->load->model('toko_Management_m', 'toko_management');
        $this->load->model('koperasi_Management_m', 'koperasi_management');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('user_logged_in')) {
            redirect('auth'); // Redirect to the 'autentic' page
        }
    }
    public function ajax_list()
    {
        $list = $this->riwayat_kasir->get_datatables();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $cat->id;
            $row[] = $cat->nama;
            $date = new DateTime($cat->tanggal_jam);
            $row[] = $date->format('d F Y, H:i:s');
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
            // $row[] = $cat->view_count;
            if ($this->session->userdata('role') != "Anggota") {
                $button = base_url('riwayat_kasir_management/verifikasi/' . $cat->sub_id);
            } else {
                $button = "#";
            }
            if ($cat->status == 0) {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                                                <a title="Delete User" href="' . $button . '" class="btn btn-danger">Belum Verifikasi</a>
            </div>
    </center>';;
            } else {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a class="btn btn-success">Terverifikasi</a>
            </div>
    </center>';
                // $row[] = '';
            }

            // <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"> <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path> <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path> </svg></a>


            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->riwayat_kasir->count_all(),
            "recordsFiltered" => $this->riwayat_kasir->count_filtered(),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function detail()
    {
        $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_v';
        $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function detail_pembayaran()
    {
        $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_pembayaran_v';
        $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_pembayaran_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function ajax_list_pembayaran()
    {
        $list = $this->riwayat_kasir->get_datatables_pembayaran();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $cat->id;
            $row[] = $cat->nama;
            $date = new DateTime($cat->tanggal_jam);
            $row[] = $date->format('d F Y, H:i:s');
            // $row[] = "Rp. " . $cat->nominal_kredit;
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->nominal,
                0,
                ',',
                '.'
            ) . '</div>';
            // $row[] = $cat->tanggal_jam;
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
            "recordsTotal" => $this->riwayat_kasir->count_all_pembayaran(),
            "recordsFiltered" => $this->riwayat_kasir->count_filtered_pembayaran(),
            "data" => $data,
        );
        echo json_encode($output);
    }
}
