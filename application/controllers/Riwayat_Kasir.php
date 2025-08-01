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
    public function ajax_list($detail = null)
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
                $button = base_url('Nota_Management/verifikasi/' . $cat->sub_id);
            } else {
                $button = "#";
            }
            if ($cat->status == 0) {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                                                <a title="Delete User" href="' . $button . '" class="btn btn-danger">Belum Verifikasi</a>
            </div>
    </center>';
            } else if ($cat->status == "1") {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a class="btn btn-primary">Terverifikasi</a>
            </div>
    </center>';
                // $row[] = '';
            } else if ($cat->status == '2') {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a class="btn btn-success">Terbayar ke Koperasi</a>
            </div>
    </center>';
            } else {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a class="btn btn-success">Terbayar ke Inkopkar</a>
            </div>
    </center>';
            }

            // <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"> <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path> <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path> </svg></a>

            if ($detail == "detail") {
                if ($cat->status > 2) {
                    continue;
                }
            }

            $data[] = $row;
        }
        $total_saldo_kredit = $this->riwayat_kasir->get_total_saldo_filtered_kredit();
        $total_saldo_cash = $this->riwayat_kasir->get_total_saldo_filtered_cash();

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->riwayat_kasir->count_all(),
            "recordsFiltered" => $this->riwayat_kasir->count_filtered(),
            "data" => $data,
            "total_saldo_kredit" => $total_saldo_kredit,
            "total_saldo_cash" => $total_saldo_cash,
        );
        echo json_encode($output);
    }
    public function detail()
    {
        $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_v';
        $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function detail_penjualan()
    {
        $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_penjualan_v';
        $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_penjualan_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function detail_pembayaran()
    {
        $data['total']     = $this->riwayat_kasir->get_total_pembayaran();
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
            $row[] = $cat->nama_koperasi;
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
            //         if ($cat->status == "1") {

            //             $row[] = '<center> <div class="list-icons d-inline-flex">

            //                                             <a class="btn btn-success">Terbayar Ke Koperasi</a>
            //         </div>
            // </center>';
            //         } else if ($cat->status == "1") {
            //             $row[] = '<center> <div class="list-icons d-inline-flex">

            //                                             <a class="btn btn-success">Terbayar Ke Inkopkar</a>
            //         </div>
            // </center>';
            //         }
            // <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"> <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path> <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path> </svg></a>


            $data[] = $row;
        }
        $total_saldo = $this->riwayat_kasir->get_total_saldo_filtered_pembayaran();

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->riwayat_kasir->count_all_pembayaran(),
            "recordsFiltered" => $this->riwayat_kasir->count_filtered_pembayaran(),
            "data" => $data,
            "total_saldo" => $total_saldo
        );
        echo json_encode($output);
    }
    public function detail_transaksi_inkopkar()
    {
        $data['total']     = $this->riwayat_kasir->get_total_transaksi_inkopkar();
        $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_transaksi_inkopkar_v';
        $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_transaksi_inkopkar_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function ajax_list_transaksi_inkopkar()
    {
        $list = $this->riwayat_kasir->get_datatables_transaksi_inkopkar();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $cat->id;
            $row[] = $cat->nama;
            $this->db->from('koperasi');
            $this->db->where('id', $cat->id_koperasi_awal);
            $awal = $this->db->get()->row();
            $row[] = $awal->nama_koperasi ?? '-';

            $this->db->from('koperasi');
            $this->db->where('id', $cat->id_koperasi_tujuan);
            $tujuan = $this->db->get()->row();
            $row[] = $tujuan?->nama_koperasi ?? '-';

            $date = new DateTime($cat->post_date);
            $row[] = $date->format('d F Y, H:i:s');
            // $row[] = "Rp. " . $cat->nominal_kredit;
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->sebelum ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->nominal ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->sesudah ?? 0,
                0,
                ',',
                '.'
            ) . '</div>';
            // $row[] = $cat->tanggal_jam;
            // $row[] = $cat->view_count;
            // <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"> <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path> <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path> </svg></a>


            $data[] = $row;
        }
        $total_saldo = $this->riwayat_kasir->get_total_saldo_filtered_transaksi_inkopkar();

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->riwayat_kasir->count_all_transaksi_inkopkar(),
            "recordsFiltered" => $this->riwayat_kasir->count_filtered_transaksi_inkopkar(),
            "data" => $data,
            "total_saldo" => $total_saldo
        );
        echo json_encode($output);
    }
    public function detail_saldo_simpanan()
    {
        $data['total']     = $this->riwayat_kasir->get_total_saldo_simpanan();
        $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_saldo_simpanan_v';
        $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_saldo_simpanan_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function ajax_list_saldo_simpanan()
    {
        $list = $this->riwayat_kasir->get_datatables_saldo_simpanan();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {
            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();
            $row[] = $cat->id;
            $row[] = $cat->nama;
            // $row[] = $cat->nama_koperasi;
            $row[] = $cat->keterangan;
            $date = new DateTime($cat->tanggal_jam);
            $row[] = $date->format('d F Y, H:i:s');
            // $row[] = "Rp. " . $cat->nominal_kredit;
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->nominal,
                0,
                ',',
                '.'
            ) . '</div>';


            $data[] = $row;
        }
        $total_saldo = $this->riwayat_kasir->get_total_saldo_filtered_simpanan();

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->riwayat_kasir->count_all_saldo_simpanan(),
            "recordsFiltered" => $this->riwayat_kasir->count_filtered_saldo_simpanan(),
            "data" => $data,
            "total_saldo" => $total_saldo
        );
        echo json_encode($output);
    }

    public function detail_pencairan()
    {
        $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_pencairan_v';
        $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_pencairan_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    public function ajax_list_iuran($detail = null)
    {
        $list = $this->riwayat_kasir->get_datatables_iuran();
        $data = array();
        $crs = "";
        $no = $_POST['start'];

        foreach ($list as $cat) {

            // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

            $no++;
            $row = array();


            $row[] = $cat->id;
            $row[] = $cat->nama_koperasi;
            $row[] = '<div style="text-align: right;">' . number_format(
                $cat->nominal,
                0,
                ',',
                '.'
            ) . '</div>';
            $date = new DateTime($cat->tanggal_jam);
            $row[] = $date->format('d F Y, H:i:s');
            // $row[] = "Rp. " . $cat->nominal_kredit;


            if ($cat->status == 0) {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                                                <button title="Delete User" class="btn btn-danger" onclick="confirmVerifikasi(' . $cat->sub_id . ')">Belum Verifikasi</button>
            </div>
    </center>';
            } else if ($cat->status == "1") {
                $row[] = '<center> <div class="list-icons d-inline-flex">
                
                                                <a class="btn btn-primary">Terverifikasi</a>
            </div>
    </center>';
                // $row[] = '';
            }

            // <a title="Update User" href="' . base_url('Anggota_Management/update/' . $cat->id) . '" class="btn btn-warning"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-edit"> <path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path> <path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path> </svg></a>

            $data[] = $row;
        }
        // Get total saldo of all filtered results (not just current page)
        $total_saldo = $this->riwayat_kasir->get_total_saldo_filtered_iuran();

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->riwayat_kasir->count_all_iuran(),
            "recordsFiltered" => $this->riwayat_kasir->count_filtered_iuran(),
            "data" => $data,
            "total_saldo" => $total_saldo
        );
        echo json_encode($output);
    }

    public function detail_saldo_pinjaman()
    {
        $data['total']     = $this->riwayat_kasir->get_total_saldo_pinjaman();
        $data['content']     = 'webview/admin/riwayat_kasir/riwayat_kasir_saldo_pinjaman_v';
        $data['content_js'] = 'webview/admin/riwayat_kasir/riwayat_kasir_saldo_pinjaman_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
    // public function ajax_list_saldo_pinjaman()
    // {
    //     $list = $this->riwayat_kasir->get_datatables_saldo_pinjaman();
    //     $data = array();
    //     $crs = "";
    //     $no = $_POST['start'];

    //     foreach ($list as $cat) {
    //         // $path = base_url() . 'uploads/blog/' . $cat->thumbnail;

    //         $no++;
    //         $row = array();
    //         $row[] = $cat->id;
    //         $row[] = $cat->nama;
    //         $row[] = $cat->nama_koperasi;
    //         $date = new DateTime($cat->tanggal_jam);
    //         $row[] = $date->format('d F Y, H:i:s');
    //         // $row[] = "Rp. " . $cat->nominal_kredit;
    //         $row[] = '<div style="text-align: right;">' . number_format(
    //             $cat->nominal,
    //             0,
    //             ',',
    //             '.'
    //         ) . '</div>';


    //         $data[] = $row;
    //     }

    //     $output = array(
    //         "draw" => $_POST['draw'],
    //         "recordsTotal" => $this->riwayat_kasir->count_all_saldo_pinjaman(),
    //         "recordsFiltered" => $this->riwayat_kasir->count_filtered_saldo_pinjaman(),
    //         "data" => $data,
    //     );
    //     echo json_encode($output);
    // }

    public function ajax_list_saldo_pinjaman()
    {
        $list = $this->riwayat_kasir->get_datatables_saldo_pinjaman();
        $data = array();
        $total_saldo = 0;
        $no = $_POST['start'];

        foreach ($list as $cat) {
            $no++;
            $row = array();
            $row[] = $cat->id;
            $row[] = $cat->nama;
            $row[] = $cat->nama_koperasi;
            $date = new DateTime($cat->tanggal_jam);
            $row[] = $date->format('d F Y, H:i:s');
            $row[] = '<div style="text-align: right;">' . number_format($cat->nominal, 0, ',', '.') . '</div>';

            // $total_saldo += $cat->nominal;

            $data[] = $row;
        }


        // Get total saldo of all filtered results (not just current page)
        $total_saldo = $this->riwayat_kasir->get_total_saldo_filtered_pinjaman();

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->riwayat_kasir->count_all_saldo_pinjaman(),
            "recordsFiltered" => $this->riwayat_kasir->count_filtered_saldo_pinjaman(),
            "data" => $data,
            "total_saldo" => $total_saldo
        );
        echo json_encode($output);
    }
}
