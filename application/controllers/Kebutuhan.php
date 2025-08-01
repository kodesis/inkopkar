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
        // Asumsi ID anggota yang login disimpan di session
        $id_anggota = $this->session->userdata('user_user_id');

        // Ambil data kebutuhan yang sudah ada untuk anggota ini dari model
        $data['detail_kebutuhan'] = $this->Kebutuhan_m->get_kebutuhan_by_anggota_id($id_anggota);

        // PINDAHKAN DEFINISI KE SINI
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

        $data['content']    = 'webview/admin/kebutuhan/kebutuhan_v';
        $data['content_js'] = 'webview/admin/kebutuhan/kebutuhan_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }

    public function simpan()
    {
        $id_anggota = $this->session->userdata('user_user_id');
        $items_from_form = $this->input->post('items');

        $data_to_insert = [];
        $data_to_update = [];
        $submitted_ids = [];

        // 1. PISAHKAN DATA UNTUK INSERT & UPDATE
        if (!empty($items_from_form)) {
            foreach ($items_from_form as $item) {
                // Pastikan item & jumlah valid
                if (empty($item['name']) || empty($item['quantity']) || $item['quantity'] <= 0) {
                    continue; // Lewati baris yang tidak valid
                }

                $satuan = ($item['name'] == 'Minyak') ? 'liter' : 'kg';

                $prepared_data = [
                    'id_anggota'     => $id_anggota,
                    'nama_kebutuhan' => $item['name'],
                    'tipe_kebutuhan' => isset($item['type']) ? $item['type'] : NULL,
                    'jumlah'         => $item['quantity'],
                    'satuan'         => $satuan
                ];

                // Jika ada 'id', berarti ini data untuk di-UPDATE
                if (isset($item['id']) && !empty($item['id'])) {
                    $prepared_data['id'] = $item['id'];
                    $data_to_update[] = $prepared_data;
                    $submitted_ids[] = $item['id'];
                } else {
                    // Jika tidak ada 'id', berarti ini data baru untuk di-INSERT
                    $data_to_insert[] = $prepared_data;
                }
            }
        }

        // 2. LOGIKA UNTUK MENGHAPUS DATA
        // Ambil semua ID yang ada di DB untuk user ini
        $existing_ids_in_db = $this->Kebutuhan_m->get_all_ids_by_anggota($id_anggota);
        // Cari ID yang ada di DB tapi tidak ada di form yang disubmit (artinya dihapus oleh user)
        $ids_to_delete = array_diff($existing_ids_in_db, $submitted_ids);

        // 3. EKSEKUSI QUERY KE DATABASE
        if (!empty($data_to_insert)) {
            $this->db->insert_batch('kebutuhan', $data_to_insert);
        }
        if (!empty($data_to_update)) {
            $this->db->update_batch('kebutuhan', $data_to_update, 'id');
        }
        if (!empty($ids_to_delete)) {
            $this->Kebutuhan_m->delete_by_ids($ids_to_delete);
        }

        $this->session->set_flashdata('success', 'Data kebutuhan berhasil diperbarui!');
        redirect('kebutuhan');
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

    public function laporan()
    {
        // Ambil filter bulan dari URL (jika ada) atau default ke bulan ini
        $filter_bulan = $this->input->get('filter_bulan') ? $this->input->get('filter_bulan') : date('Y-m');

        // 1. Ambil header kolom (tetap sama)
        $item_headers_raw = $this->Kebutuhan_m->get_unique_items_by_month($filter_bulan);
        $data['item_headers'] = [];
        foreach ($item_headers_raw as $header) {
            $header_name = $header['nama_kebutuhan'];
            if ($header['tipe_kebutuhan']) {
                $header_name .= ' Tipe ' . strtoupper($header['tipe_kebutuhan']);
            }
            $data['item_headers'][] = $header_name;
        }
        $data['item_headers'] = array_unique($data['item_headers']);
        sort($data['item_headers']);

        // 2. Ambil data detail (tetap sama)
        $detail_kebutuhan = $this->Kebutuhan_m->get_all_detail_by_month($filter_bulan);

        // 3. Proses Pivot dan HITUNG TOTAL SECARA BERSAMAAN
        $pivoted_data = [];
        $column_totals = []; // Inisialisasi array untuk menampung total per kolom

        foreach ($detail_kebutuhan as $row) {
            $nama_anggota = $row['nama'];

            $nama_kebutuhan_key = $row['nama_kebutuhan'];
            if ($row['tipe_kebutuhan']) {
                $nama_kebutuhan_key .= ' Tipe ' . strtoupper($row['tipe_kebutuhan']);
            }

            // $jumlah = (float) $row['jumlah'];
            $jumlah = (float) $row['jumlah'];
            $satuan = $row['satuan'];
            $jumlah_satuan = $jumlah . ' ' . $satuan;

            // Proses pivot (tetap sama)
            $pivoted_data[$nama_anggota][$nama_kebutuhan_key] = $jumlah_satuan;

            // --- LOGIKA BARU UNTUK MENGHITUNG TOTAL ---
            // Jika item ini belum ada di array total, inisialisasi dulu
            if (!isset($column_totals[$nama_kebutuhan_key])) {
                $column_totals[$nama_kebutuhan_key] = [
                    'total' => 0,
                    'satuan' => $satuan
                ];
            }
            // Tambahkan jumlah saat ini ke total kolom
            $column_totals[$nama_kebutuhan_key]['total'] += $jumlah;
            // --- END LOGIKA BARU ---
        }

        $data['pivoted_data'] = $pivoted_data;
        $data['column_totals'] = $column_totals; // Kirim data total ke view
        $data['filter_bulan'] = $filter_bulan;
        $data['title'] = "Laporan Pivot Kebutuhan";

        $data['content']    = 'webview/admin/kebutuhan/kebutuhan_laporan_v';
        $data['content_js']    = 'webview/admin/kebutuhan/kebutuhan_laporan_js';
        $this->load->view('parts/admin/Wrapper', $data);
    }
}
