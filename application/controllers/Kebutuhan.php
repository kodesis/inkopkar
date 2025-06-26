<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kebutuhan extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        // Load helper dan library yang dibutuhkan
        $this->load->helper(array('form', 'url'));
        $this->load->library(array('form_validation', 'session'));
        $this->load->database(); // Load library database
        $this->load->model('Kebutuhan_m', 'Kebutuhan_m');
    }

    public function index()
    {
        // Menampilkan halaman form
        // $this->load->view('v_form_kebutuhan');
        $data['kebutuhan_list'] = [
            'Beras'  => [
                'unit' => 'kg',
                'has_type' => true,
                'types' => [
                    'a' => 'Tipe A (Premium)',
                    'b' => 'Tipe B (Medium)'
                ]
            ],
            'Gula'   => ['unit' => 'kg', 'has_type' => false],
            'Minyak' => ['unit' => 'liter', 'has_type' => false],
            'Terigu' => ['unit' => 'kg', 'has_type' => false],
            'Telur'  => ['unit' => 'kg', 'has_type' => false],
        ];

        $data['content']     = 'webview/admin/kebutuhan/kebutuhan_v';
        $data['content_js'] = 'webview/admin/kebutuhan/kebutuhan_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function simpan()
    {
        $this->form_validation->set_rules('nama_anggota', 'Nama Anggota', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('v_form_kebutuhan');
        } else {
            $nama_anggota = $this->input->post('nama_anggota');
            $items = $this->input->post('items'); // Ambil semua data item sebagai array

            $data_to_insert = [];

            // Cek jika ada item yang dikirim
            if (!empty($items)) {
                foreach ($items as $item) {
                    // Pastikan item dipilih dan jumlahnya diisi
                    if (!empty($item['name']) && !empty($item['quantity']) && $item['quantity'] > 0) {

                        // Definisikan satuan berdasarkan nama item
                        $satuan = '';
                        if ($item['name'] == 'Minyak') {
                            $satuan = 'liter';
                        } else {
                            $satuan = 'kg';
                        }

                        $data_to_insert[] = [
                            'id_anggota' => $this->session->userdata('user_user_id'),
                            'nama_kebutuhan' => $item['name'],
                            // Cek jika tipe ada, jika tidak, isi NULL
                            'tipe_kebutuhan' => isset($item['type']) ? $item['type'] : NULL,
                            'jumlah'         => $item['quantity'],
                            'satuan'         => $satuan
                        ];
                    }
                }
            }

            if (!empty($data_to_insert)) {
                $this->db->insert_batch('kebutuhan', $data_to_insert);
                $this->session->set_flashdata('success', 'Data kebutuhan berhasil disimpan!');
            } else {
                $this->session->set_flashdata('error', 'Gagal menyimpan. Pastikan Anda memilih item dan mengisi jumlahnya.');
            }

            redirect('kebutuhan');
        }
    }

    public function list()
    {

        $data['content']     = 'webview/admin/kebutuhan/kebutuhan_list_v';
        $data['content_js'] = 'webview/admin/kebutuhan/kebutuhan_list_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function ajax_list()
    {
        // Ambil parameter filter dari POST request yang dikirim DataTable
        $params = [
            'filter_bulan' => $this->input->post('filter_bulan')
        ];

        $list = $this->Kebutuhan_m->get_datatables($params);
        // $list = $this->Kebutuhan_m->get_datatables($detail);
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
            $row[] = $cat->nama;
            if ($cat->tipe_kebutuhan) {
                $tipe_kebutuhan = '- Tipe ' . strtoupper($cat->tipe_kebutuhan);
            } else {
                $tipe_kebutuhan = '';
            }
            $row[] = $cat->nama_kebutuhan . ' ' . $tipe_kebutuhan;
            $row[] = $cat->jumlah . ' ' . $cat->satuan;
            $row[] = $cat->tanggal_pilih;

            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "recordsTotal" => $this->Kebutuhan_m->count_all($params), // Kirim params
            "recordsFiltered" => $this->Kebutuhan_m->count_filtered($params), // Kirim params
            // "recordsTotal" => $this->Kebutuhan_m->count_all($detail),
            // "recordsFiltered" => $this->Kebutuhan_m->count_filtered($detail),
            "data" => $data,
        );
        echo json_encode($output);
    }

    public function ajax_summary()
    {
        $filter_bulan = $this->input->post('filter_bulan');

        // Panggil model untuk mendapatkan data rekap
        $summary_data = $this->Kebutuhan_m->get_rekap_by_month($filter_bulan);

        // Kirim data sebagai JSON
        header('Content-Type: application/json');
        echo json_encode($summary_data);
    }
}
