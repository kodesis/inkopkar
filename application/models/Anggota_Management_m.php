<?php defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_Management_m extends CI_Model
{
    var $table = 'anggota';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order = array('anggota.id', 'nomor_anggota', 'nama', 'tempat_lahir', 'tanggal_lahir', 'no_telp', 'username', 'kredit_limit', 'usage_kredit', 'nama_koperasi', 'jabatan'); //set column field database for datatable orderable
    var $column_search = array('anggota.id', 'nomor_anggota', 'nama', 'tempat_lahir', 'tanggal_lahir', 'no_telp', 'username', 'kredit_limit', 'usage_kredit', 'nama_koperasi', 'jabatan'); //set column field database for datatable searchable 

    var $order = array('anggota.id' => 'DESC'); // default order 

    function _get_datatables_query($detail = null)
    {

        $this->db->select('anggota.*, koperasi.nama_koperasi');
        $this->db->from('anggota');
        // $this->db->join('toko', 'anggota.id_toko = toko.id', 'left');
        $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');
        if ($detail) {
            $this->db->where('id_koperasi', $detail);
            $this->db->where('usage_kredit >', '0');
        } else if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
            // $this->db->where('role >', '2');
        } else if ($this->session->userdata('role') == "Kasir") {
            $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
            $this->db->where('role', '4');
        } else if ($this->session->userdata('role') == "Puskopkar") {
            $this->db->where('anggota.id_puskopkar', $this->session->userdata('user_user_id'));
            $this->db->where('role', '2');
        }
        // if ($this->session->userdata('role') == "Kasir") {
        //     $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        // }
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
        $this->db->insert('anggota', $data);
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
        $this->db->update('anggota', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('anggota');
        return $this->db->get()->result();
    }
    public function get_toko_koperasi()
    {
        $this->db->select('toko.*, koperasi.nama_koperasi');
        $this->db->from('toko');
        $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('koperasi.id', $this->session->userdata('id_koperasi'));
        }
        return $this->db->get()->result();
    }

    public function get_koperasi()
    {
        $this->db->from('koperasi');
        return $this->db->get()->result();
    }

    public function total_kredit_anggota($id)
    {
        $this->db->select_sum('nominal_kredit');
        $this->db->from('nota');
        $this->db->where('id_anggota', $id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result = $query->row();

        return $result->nominal_kredit;
    }
    public function get_id_saldo_simpanan($id)
    {
        $this->db->select_sum('nominal');
        $this->db->from('saldo_simpanan');
        $this->db->where('id_anggota', $id);
        $this->db->where('status', '1');
        $query = $this->db->get()->row();

        return $query->nominal;
    }
    public function get_puskopkar()
    {
        $this->db->from('anggota');
        $this->db->where('role', '5');
        return $this->db->get()->result();
    }
    public function update_profile($data, $where)
    {
        $this->db->update('anggota', $data, $where);
    }
    public function get_kelurahan()
    {
        $this->db->from('kelurahan');
        return $this->db->get()->result();
    }
    public function get_toko_by_koperasi($koperasi_id)
    {
        $this->db->where('id_koperasi', $koperasi_id);
        $query = $this->db->get('toko'); // Assuming your table name is 'toko'
        return $query->result(); // Returns an array of objects
    }


    var $table_monitor_simpanan = 'anggota';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order_monitor_simpanan = array('anggota.id', 'nomor_anggota', 'nama', 'tanggal_simpanan_terakhir'); //set column field database for datatable orderable
    var $column_search_monitor_simpanan = array('anggota.id', 'nomor_anggota', 'nama', 'tanggal_simpanan_terakhir'); //set column field database for datatable searchable 

    var $order_monitor_simpanan = array('anggota.id' => 'DESC'); // default order 

    function _get_datatables_query_monitor_simpanan($filter_status  = null)
    {

        $this->db->select('anggota.*, koperasi.nama_koperasi');
        $this->db->from('anggota');
        // $this->db->join('toko', 'anggota.id_toko = toko.id', 'left');
        $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');
        $this->db->where('anggota.status', 1);

        // Tambahkan logika filter
        if ($filter_status == 'Belum Dibayar') {
            $this->db->where('tanggal_simpanan_terakhir <', date('Y-m-d'));
            $this->db->or_where('tanggal_simpanan_terakhir', null);
        } else if ($filter_status == 'Sudah Dibayar') {
            $this->db->where('tanggal_simpanan_terakhir >=', date('Y-m-d'));
        }
        // if ($this->session->userdata('role') == "Kasir") {
        //     $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        // }

        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
            $this->db->where('role', '4');
        } else if ($this->session->userdata('role') == "Kasir") {
            $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
            $this->db->where('role', '4');
        } else if ($this->session->userdata('role') == "Puskopkar") {
            $this->db->where('anggota.id_puskopkar', $this->session->userdata('user_user_id'));
            $this->db->where('role', '2');
        }

        $i = 0;
        foreach ($this->column_search_monitor_simpanan as $item) // loop column 
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

                if (count($this->column_search_monitor_simpanan) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_monitor_simpanan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_monitor_simpanan)) {
            $order = $this->order_monitor_simpanan;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_monitor_simpanan($filter_status)
    {
        $this->_get_datatables_query_monitor_simpanan($filter_status);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_monitor_simpanan($filter_status)
    {
        $this->_get_datatables_query_monitor_simpanan($filter_status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_monitor_simpanan()
    {

        $this->_get_datatables_query_monitor_simpanan();
        $query = $this->db->get();

        return $this->db->count_all_results();
    }

    public function get_data_untuk_export($status)
    {
        // Logika untuk mengambil semua data yang belum dibayar
        if ($status == 'Belum Dibayar') {
            $this->db->where('tanggal_simpanan_terakhir <', date('Y-m-d'));
            $this->db->or_where('tanggal_simpanan_terakhir', null);
        }

        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
            $this->db->where('status', 1);
            $this->db->where('role', '4');
        } else if ($this->session->userdata('role') == "Kasir") {
            $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
            $this->db->where('status', 1);
            $this->db->where('role', '4');
        }
        // Asumsi tabel Anda bernama 'anggota'
        $query = $this->db->get('anggota');
        return $query->result();
    }
}
