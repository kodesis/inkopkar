<?php defined('BASEPATH') or exit('No direct script access allowed');

class Kebutuhan_m extends CI_Model
{
    var $table = 'kebutuhan';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order = array('kebutuhan.id', 'anggota.nama', 'nama_kebutuhan', 'tipe_kebutuhan', 'jumlah', 'tanggal_pilih'); //set column field database for datatable orderable
    var $column_search = array('kebutuhan.id', 'nama_kebutuhan', 'tipe_kebutuhan', 'jumlah', 'tanggal_pilih'); //set column field database for datatable searchable 

    var $order = array('kebutuhan.tanggal_pilih' => 'DESC'); // default order 

    function _get_datatables_query($detail = null)
    {

        $this->db->select('kebutuhan.*, anggota.nama');
        $this->db->from('kebutuhan');
        $this->db->join('anggota', 'anggota.id = kebutuhan.id_anggota', 'left');
        $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');
        $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));

        // --- LOGIKA FILTER BARU ---
        if (!empty($detail['filter_bulan'])) {
            $bulan_tahun = $detail['filter_bulan']; // Formatnya "YYYY-MM", misal: "2025-06"
            $tahun = date('Y', strtotime($bulan_tahun));
            $bulan = date('m', strtotime($bulan_tahun));

            $this->db->where('YEAR(kebutuhan.tanggal_pilih)', $tahun);
            $this->db->where('MONTH(kebutuhan.tanggal_pilih)', $bulan);
        }
        // --- END LOGIKA FILTER BARU ---

        $i = 0;
        foreach ($this->column_search as $item) // loop column 
        {
            if ($_POST['search']['value']) // if datatable send POST for search
            {

                if ($i === 0) // first loop
                {
                    $this->db->group_start(); // open bracket. query Where with OR clause better with bracket. because maybe can combine with other WHERE with AND.
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order)) {
            $order = $this->order;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables($detail)
    {
        $this->_get_datatables_query($detail);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($detail)
    {
        $this->_get_datatables_query($detail);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all($detail)
    {

        $this->_get_datatables_query($detail);
        $query = $this->db->get();

        return $this->db->count_all_results();
    }

    public function save_file($data)
    {
        $this->db->insert('kebutuhan', $data);
        return $this->db->insert_id();
    }

    public function get_id_edit($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('Id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    public function update_data($data, $where)
    {
        $this->db->update('kebutuhan', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('kebutuhan');
        return $this->db->get()->result();
    }

    // Di dalam file Kebutuhan_m.php

    public function get_rekap_by_month($bulan_tahun)
    {
        $this->db->select('nama_kebutuhan, tipe_kebutuhan, satuan, SUM(jumlah) as total_jumlah');
        $this->db->from('kebutuhan'); // Pastikan nama tabel benar
        $this->db->join('anggota', 'anggota.id = kebutuhan.id_anggota', 'left');
        $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');
        $this->db->where('koperasi.id', $this->session->userdata('id_koperasi'));

        // Filter berdasarkan bulan jika disediakan
        if (!empty($bulan_tahun)) {
            $tahun = date('Y', strtotime($bulan_tahun));
            $bulan = date('m', strtotime($bulan_tahun));
            $this->db->where('YEAR(tanggal_pilih)', $tahun);
            $this->db->where('MONTH(tanggal_pilih)', $bulan);
        } else {
            // Jika tidak ada bulan dipilih, kembalikan array kosong agar tidak menjumlahkan semua data
            return [];
        }

        $this->db->group_by(['nama_kebutuhan', 'tipe_kebutuhan', 'satuan']);
        $this->db->order_by('nama_kebutuhan', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_kebutuhan_by_anggota_id($id_anggota)
    {
        $this->db->from('kebutuhan');
        $this->db->where('id_anggota', $id_anggota);
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_all_ids_by_anggota($id_anggota)
    {
        $this->db->select('id');
        $this->db->from('kebutuhan');
        $this->db->where('id_anggota', $id_anggota);
        $query = $this->db->get();
        return array_column($query->result_array(), 'id');
    }

    public function delete_by_ids($ids)
    {
        if (!empty($ids)) {
            $this->db->where_in('id', $ids);
            $this->db->delete('kebutuhan');
        }
    }

    public function get_all_detail_by_month($bulan_tahun)
    {
        $this->db->select('anggota.nama, kebutuhan.nama_kebutuhan, kebutuhan.tipe_kebutuhan, kebutuhan.jumlah, kebutuhan.satuan');
        $this->db->from('kebutuhan');
        $this->db->join('anggota', 'anggota.id = kebutuhan.id_anggota', 'left');
        $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');
        $this->db->where('koperasi.id', $this->session->userdata('id_koperasi'));

        if (!empty($bulan_tahun)) {
            $tahun = date('Y', strtotime($bulan_tahun));
            $bulan = date('m', strtotime($bulan_tahun));
            $this->db->where('YEAR(kebutuhan.tanggal_pilih)', $tahun);
            $this->db->where('MONTH(kebutuhan.tanggal_pilih)', $bulan);
        }

        $query = $this->db->get();
        return $query->result_array();
    }

    /**
     * Mengambil semua jenis kebutuhan unik (untuk header tabel) pada bulan tertentu
     */
    public function get_unique_items_by_month($bulan_tahun)
    {
        $this->db->distinct();
        $this->db->select('nama_kebutuhan, tipe_kebutuhan');
        $this->db->from('kebutuhan');
        $this->db->join('anggota', 'anggota.id = kebutuhan.id_anggota', 'left');
        $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');
        $this->db->where('koperasi.id', $this->session->userdata('id_koperasi'));

        if (!empty($bulan_tahun)) {
            $tahun = date('Y', strtotime($bulan_tahun));
            $bulan = date('m', strtotime($bulan_tahun));
            $this->db->where('YEAR(kebutuhan.tanggal_pilih)', $tahun);
            $this->db->where('MONTH(kebutuhan.tanggal_pilih)', $bulan);
        }

        $this->db->order_by('nama_kebutuhan', 'ASC');
        $this->db->order_by('tipe_kebutuhan', 'ASC');
        $query = $this->db->get();
        return $query->result_array();
    }

    public function get_rekap()
    {
        $this->db->select('nama_kebutuhan, tipe_kebutuhan, satuan, SUM(jumlah) as total_jumlah');
        $this->db->from('kebutuhan');
        $this->db->join('anggota', 'anggota.id = kebutuhan.id_anggota', 'left');
        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');
            $this->db->where('koperasi.id', $this->session->userdata('id_koperasi'));
        } else if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('id_anggota', $this->session->userdata('user_user_id'));
        }
        $this->db->group_by(['nama_kebutuhan', 'tipe_kebutuhan', 'satuan']);
        $this->db->order_by('nama_kebutuhan', 'ASC');

        $query = $this->db->get();
        return $query->result_array();
    }
}
