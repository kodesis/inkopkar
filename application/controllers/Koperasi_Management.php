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
        $this->load->model('Anggota_Management_m', 'anggota_management');
        $this->load->helper(array('form', 'url'));
        $this->load->library('upload');
        if (!$this->session->userdata('user_logged_in')) {
            redirect('auth'); // Redirect to the 'autentic' page
        }
    }
    public function ajax_list($url)
    {
        $list = $this->koperasi_management->get_datatables($url);
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;
            // echo '<pre>';
            // var_dump($cat->saldo_tagihan);
            // echo '</pre>';


            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $cat->nama_koperasi;
            $row[] = $cat->alamat;
            $row[] = $cat->telp;
            // $row[] = $saldo_tagihan;


            // $this->db->select_sum('usage_kredit');
            // $this->db->from('anggota');
            // // $this->db->join('toko', 'toko.id = anggota.id_toko');
            // $this->db->where('id_koperasi', $cat->id);
            // $query = $this->db->get();
            // $result = $query->row();

            $this->db->select_sum('nominal_kredit');
            $this->db->from('nota');
            $this->db->join('anggota', 'anggota.id = nota.id_anggota');
            // $this->db->select_sum('usage_kredit');
            // $this->db->from('anggota');
            // $this->db->join('anggota', 'anggota.id = nota.id_anggota');
            if ($this->session->userdata('role') == "Kasir") {
                $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
            } else if ($this->session->userdata('role') == "Koperasi") {
                $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
            } else if ($this->session->userdata('role') == "Anggota") {
                $this->db->where('id_anggota', $this->session->userdata('user_user_id'));
            }
            $this->db->where('anggota.id_koperasi', $cat->id);
            $this->db->where('status', '1');
            $query = $this->db->get();
            $result = $query->row();
            $usage_kredit = $result->nominal_kredit;

            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $usage_kredit ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';

            // $this->db->select_sum('nominal');
            // $this->db->from('nota_pembayaran');
            // $this->db->join('anggota', 'anggota.id = nota_pembayaran.id_toko');
            // $this->db->join('toko', 'toko.id = anggota.id_toko');
            // $this->db->where('id_koperasi', $cat->id);
            // $this->db->where('nota_pembayaran.status', '1');
            // $query = $this->db->get();
            // $result = $query->row();
            // $total_nominal_tagihan = $result->nominal ?? 0;
            // $row[] = '<div style="text-align: right;">Rp. ' . number_format(
            //     $total_nominal_tagihan,
            //     0,
            //     ',',
            //     '.'
            // ) . '</div>';
            $this->db->select_sum('nominal');
            $this->db->from('nota_pembayaran');
            $this->db->join('anggota', 'anggota.id = nota_pembayaran.id_anggota');
            if ($this->session->userdata('role') == "Kasir" || $this->session->userdata('role') == "Koperasi") {
                $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
            }
            $this->db->where('status', '1');
            $this->db->where('anggota.id_koperasi', $cat->id);
            $query = $this->db->get();
            $result = $query->row();
            $saldo_tagihan = $result->nominal ?? 0;
            // echo 'Saldo Tagihan : ' . $saldo_tagihan;
            // echo 'Saldo Tagihan Cat : ' . $cat->$saldo_tagihan;
            // echo $saldo_tagihan;


            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $saldo_tagihan ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';

            // $this->db->select_sum('nominal');
            // $this->db->from('nota_pembayaran');
            // $this->db->join('anggota', 'anggota.id = nota_pembayaran.id_toko');
            // $this->db->join('toko', 'toko.id = anggota.id_toko');
            // $this->db->where('id_koperasi', $cat->id);
            // $this->db->where('nota_pembayaran.status', '2');
            // $query = $this->db->get();
            // $result = $query->row();
            // $total_nominal_rekening = $result->nominal ?? 0;
            // $row[] = '<div style="text-align: right;">Rp. ' . number_format(
            //     $total_nominal_rekening,
            //     0,
            //     ',',
            //     '.'
            // ) . '</div>';
            $this->db->select_sum('nominal_kredit');
            $this->db->from('nota');
            $this->db->join('anggota', 'anggota.id = nota.id_anggota');
            $this->db->join('toko', 'toko.id = nota.id_toko');
            // if ($this->session->userdata('role') == "Kasir" || $this->session->userdata('role') == "Koperasi") {
            //     $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
            // }
            $this->db->where('status', '3');
            $this->db->where('toko.id_koperasi', $cat->id);
            $query = $this->db->get();
            $result = $query->row();
            $saldo_rekening = $result->nominal_kredit ?? 0;
            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $saldo_rekening ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';


            // <a title="Detail Koperasi" href="' . base_url('koperasi_management/transfer_inkopkar/' . $cat->id) . '" class="btn btn-success"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M535 41c-9.4-9.4-9.4-24.6 0-33.9s24.6-9.4 33.9 0l64 64c4.5 4.5 7 10.6 7 17s-2.5 12.5-7 17l-64 64c-9.4 9.4-24.6 9.4-33.9 0s-9.4-24.6 0-33.9l23-23L384 112c-13.3 0-24-10.7-24-24s10.7-24 24-24l174.1 0L535 41zM105 377l-23 23L256 400c13.3 0 24 10.7 24 24s-10.7 24-24 24L81.9 448l23 23c9.4 9.4 9.4 24.6 0 33.9s-24.6 9.4-33.9 0L7 441c-4.5-4.5-7-10.6-7-17s2.5-12.5 7-17l64-64c9.4-9.4 24.6-9.4 33.9 0s9.4 24.6 0 33.9zM96 64l241.9 0c-3.7 7.2-5.9 15.3-5.9 24c0 28.7 23.3 52 52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5 608 384c0 35.3-28.7 64-64 64l-241.9 0c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5 32 128c0-35.3 28.7-64 64-64zm64 64l-64 0 0 64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64l64 0 0-64zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg></a>
            // if ($this->session->userdata('role') == "Admin") {
            // if ($cat->saldo_tagihan <= 0) {
            //         if ($saldo_tagihan <= 0) {
            //             $row[] = '<center> <div class="list-icons d-inline-flex">
            //         <a title="Detail Koperasi" href="' . base_url('Anggota_Management/detail/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg></a>

            //             <a title="Update User" href="' . base_url('Koperasi_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            //                                                     <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            //                                                     <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            //                                                 </svg></a>
            //                                             <a title="Delete User" onclick="onDelete(' . $cat->id . ')" class="btn btn-danger"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
            //                                                     <polyline points="3 6 5 6 21 6"></polyline>
            //                                                     <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            //                                                     <line x1="10" y1="11" x2="10" y2="17"></line>
            //                                                     <line x1="14" y1="11" x2="14" y2="17"></line>
            //                                                 </svg></a>

            //         </div>
            // </center>';
            //         } else {
            $row[] = '
             52 52l117.4 0c-4 17 .6 35.5 13.8 48.8c20.3 20.3 53.2 20.3 73.5 0L608 169.5 608 384c0 35.3-28.7 64-64 64l-241.9 0c3.7-7.2 5.9-15.3 5.9-24c0-28.7-23.3-52-52-52l-117.4 0c4-17-.6-35.5-13.8-48.8c-20.3-20.3-53.2-20.3-73.5 0L32 342.5 32 128c0-35.3 28.7-64 64-64zm64 64l-64 0 0 64c35.3 0 64-28.7 64-64zM544 320c-35.3 0-64 28.7-64 64l64 0 0-64zM320 352a96 96 0 1 0 0-192 96 96 0 1 0 0 192z"/></svg></button>

            <a title="Detail Koperasi" href="' . base_url('Anggota_Management/detail/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg></a>

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
            // }
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->koperasi_management->count_all($url),
            "recordsFiltered" => $this->koperasi_management->count_filtered($url),
            "data" => $data,
        );
        echo json_encode($output);
    }
    public function ajax_list1()
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
            $row[] = $cat->no_induk;
            $row[] = $cat->nama_koperasi;
            $row[] = $cat->alamat;
            $row[] = $cat->telp;

            $this->db->select_sum('nominal');
            $this->db->from('log_transaksi');
            $this->db->where('id_koperasi_tujuan', $cat->id);
            $query = $this->db->get();
            $result = $query->row();
            $saldo_rekening = $result->nominal;

            // $this->db->select_sum('nominal_kredit');
            // $this->db->from('nota');
            // $this->db->join('anggota', 'anggota.id = nota.id_anggota');
            // $this->db->join('toko', 'toko.id = nota.id_toko');
            // $this->db->where('status', '3');
            // $this->db->where('toko.id_koperasi', $cat->id);
            // $query = $this->db->get();
            // $result = $query->row();
            // $saldo_rekening = $result->nominal_kredit ?? 0;
            $row[] = '<div style="text-align: right;">Rp. ' . number_format(
                $saldo_rekening ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';

            // '<a title="Detail Koperasi" href="' . base_url('Anggota_Management/detail/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg></a>'
            if ($this->session->userdata('role') == "Admin") {
                $row[] = '
            <center> <div class="list-icons d-inline-flex">

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
            } else {
                $row[] = '
            <center> <div class="list-icons d-inline-flex">

                <a title="Update User" href="' . base_url('Koperasi_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
                                                        <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
                                                        <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
                                                    </svg></a>
                                                     
            </div>
    </center>';
            }


            //         } else {
            //             $row[] = '<center> <div class="list-icons d-inline-flex">
            //         <a title="Detail Koperasi" href="' . base_url('Anggota_Management/detail/' . $cat->id) . '" class="btn btn-primary"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"><!--!Font Awesome Free 6.7.2 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2025 Fonticons, Inc.--><path fill="#ffffff" d="M256 512A256 256 0 1 0 256 0a256 256 0 1 0 0 512zM216 336l24 0 0-64-24 0c-13.3 0-24-10.7-24-24s10.7-24 24-24l48 0c13.3 0 24 10.7 24 24l0 88 8 0c13.3 0 24 10.7 24 24s-10.7 24-24 24l-80 0c-13.3 0-24-10.7-24-24s10.7-24 24-24zm40-208a32 32 0 1 1 0 64 32 32 0 1 1 0-64z"/></svg></a>

            //             <a title="Update User" href="' . base_url('Koperasi_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit">
            //                                                     <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path>
            //                                                     <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path>
            //                                                 </svg></a>
            //                                             <a title="Delete User" onclick="onDelete(' . $cat->id . ')" class="btn btn-danger"><svg viewBox="0 0 24 24" width="24" height="24" stroke="currentColor" stroke-width="2" fill="none" stroke-linecap="round" stroke-linejoin="round" class="css-i6dzq1">
            //                                                     <polyline points="3 6 5 6 21 6"></polyline>
            //                                                     <path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
            //                                                     <line x1="10" y1="11" x2="10" y2="17"></line>
            //                                                     <line x1="14" y1="11" x2="14" y2="17"></line>
            //                                                 </svg></a>

            //         </div>
            // </center>';
            //         }

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

        $data['total_saldo_tagihan'] = $this->koperasi_management->total_saldo_koperasi_tagihan();
        $data['total_saldo_rekening'] = $this->koperasi_management->total_saldo_koperasi_rekening();
        $data['total_usage'] = $this->koperasi_management->total_saldo_usage_anggota();
        $data['content']     = 'webview/admin/koperasi_management/koperasi_management_v';
        $data['content_js'] = 'webview/admin/koperasi_management/koperasi_management_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function transaksi()
    {

        $data['total_saldo_tagihan'] = $this->koperasi_management->total_saldo_koperasi_tagihan();
        $data['total_saldo_rekening'] = $this->koperasi_management->total_saldo_koperasi_rekening();
        $data['total_usage'] = $this->koperasi_management->total_saldo_usage_anggota();
        $data['content']     = 'webview/admin/koperasi_management/koperasi_transaksi_v';
        $data['content_js'] = 'webview/admin/koperasi_management/koperasi_transaksi_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function add()
    {

        $data['puskopkar'] = $this->anggota_management->get_puskopkar();
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
        $no_induk = $this->input->post('no_induk');
        $id_puskopkar = $this->input->post('id_puskopkar');

        $this->koperasi_management->save_file(
            array(
                'nama_koperasi'            => $nama_koperasi,
                'alamat'            => $alamat,
                'telp'             => $telp,
                'no_induk'             => $no_induk,
                'id_puskopkar'             => $id_puskopkar,
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

    public function transfer_inkopkar($id)
    {
        $id_edit = $id;
        // $koperasi = $this->koperasi_management->get_id_edit($id_edit);
        // $saldo_tagihan = $koperasi->saldo_tagihan;
        // $saldo_rekening = $koperasi->saldo_rekening;
        // $new_saldo_rekening = $saldo_tagihan + $saldo_rekening;
        $data_update = [
            // 'saldo_rekening'             => $new_saldo_rekening,
            'saldo_tagihan' => 0,
        ];

        $this->koperasi_management->update_data($data_update, array('id' => $id_edit));

        $id_nota_kredit = [];
        $koperasi = $this->koperasi_management->update_nota_pembayaran($id_edit);
        foreach ($koperasi as $nota) {
            // echo 'Masuk 1';
            // Update status
            $this->db->where('nota_pembayaran.sub_id', $nota->sub_id);
            $this->db->update('nota_pembayaran', ['status' => '2']);
            // $this->db->update('nota_pembayaran', ['status' => '1']);

            // Decode id_nota_kredit jika dalam format JSON
            $decoded_ids = json_decode($nota->id_nota_kredit, true);

            // Gabungkan hasil decode ke array utama jika valid
            if (is_array($decoded_ids)) {
                $id_nota_kredit = array_merge($id_nota_kredit, $decoded_ids);
            }
            // echo json_encode(array("Progress" => 'koperasi as nota', "decoded_ids" => $decoded_ids));
        }

        $koperasi_totals = [];
        // var_dump($id_nota_kredit);
        foreach ($id_nota_kredit as $kredit) {
            // echo "Sebelum Query: $kredit<br>";

            // Get nota details
            $this->db->select('*');
            $this->db->from('nota');
            $this->db->join('toko', 'toko.id = nota.id_toko');
            $this->db->where('nota.sub_id', $kredit);
            $nota = $this->db->get()->row();
            // echo "Sesudah Query: $kredit<br>";
            // var_dump($nota);

            if (!$nota) continue;

            // Group by id_koperasi
            if (!isset($koperasi_totals[$nota->id_koperasi])) {
                $koperasi_totals[$nota->id_koperasi] = [
                    'total_nominal_kredit' => 0,
                    'sub_ids' => [],
                    'notas' => [],
                ];
            }

            $koperasi_totals[$nota->id_koperasi]['total_nominal_kredit'] += $nota->nominal_kredit;
            $koperasi_totals[$nota->id_koperasi]['sub_ids'][] = $nota->sub_id;
            $koperasi_totals[$nota->id_koperasi]['notas'][] = $nota;

            // echo json_encode(array("Progress" => 'id_nota_kredit', 'koperasi_totals' => $koperasi_totals));
        }

        // var_dump($koperasi_totals);
        // Now process each koperasi once
        foreach ($koperasi_totals as $id_koperasi => $data) {
            // Get existing saldo
            // echo 'Masuk pak eko';
            $this->db->select_sum('nominal_kredit');
            $this->db->from('nota');
            $this->db->join('toko', 'toko.id = nota.id_toko');
            $this->db->where('toko.id_koperasi', $id_koperasi);
            $this->db->where('status', '3');
            $nominal_rekening = $this->db->get()->row();

            // echo $nominal_rekening;
            $existing = $nominal_rekening->nominal_kredit ?? 0;
            $new_saldo_rekening = $existing + $data['total_nominal_kredit'];

            // Update koperasi saldo
            $this->koperasi_management->update_data(['saldo_rekening' => $new_saldo_rekening], ['id' => $id_koperasi]);

            $cek = $this->koperasi_management->save_log_transaksi([
                'id_koperasi_awal'   => $id_edit,
                'id_koperasi_tujuan' => $id_koperasi,
                'id_admin'           => $this->session->userdata('user_user_id'),
                // 'id_nota_kredit'     =>  json_encode($data['sub_ids']),
                'id_nota_kredit'     => json_encode(array_map(fn($n) => $n->sub_id, $data['notas'])),
                'sebelum'            => $existing,
                'nominal'            => $data['total_nominal_kredit'],
                'sesudah'            => $new_saldo_rekening,
            ]);
            foreach ($data['notas'] as $nota) {
                // Update nota status
                $this->db->where('sub_id', $nota->sub_id);
                $this->db->update('nota', ['status' => '3']);
            }
            // echo json_encode(array("Progress" => 'koperasi_totals', 'notas' => $data['notas']));
        }


        // var_dump($koperasi);

        // $this->koperasi_management->save_log_transaksi(
        //     array(
        //         'id_koperasi'            => ,
        //         'id_admin'            => $this->session->userdata('user_user_id'),
        //         'sebelum'            => $saldo_rekening,
        //         'nominal'            => $saldo_tagihan,
        //         'sesudah'            => $new_saldo_rekening,
        //     ),
        // );

        // echo json_encode(array("status" => TRUE, "title" => $title));
        // $this->koperasi_management->update_data($data_update, array('Id' => $id_edit));
        // echo json_encode(array("status" => TRUE));
    }
}
