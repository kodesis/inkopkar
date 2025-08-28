<?php defined('BASEPATH') or exit('No direct script access allowed');

class Saldo_Pinjaman_m extends CI_Model
{
    var $table = 'saldo_pinjaman';
    var $column_order = array('id', 'nomor_anggota', 'tanggal_jam', 'nama', 'nominal_kredit'); //set column field database for datatable orderable
    var $column_search = array('id', 'nomor_anggota', 'tanggal_jam', 'nama', 'nominal_kredit'); //set column field database for datatable searchable 

    var $order = array('saldo_pinjaman.id' => 'DESC'); // default order 

    function _get_datatables_query()
    {
        $this->db->select('saldo_pinjaman.*, anggota.nama, anggota.nomor_anggota');
        $this->db->from('saldo_pinjaman');
        $this->db->join('anggota', 'anggota.id = saldo_pinjaman.id_anggota');
        $this->db->where('saldo_pinjaman.status', '1');
        if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('saldo_pinjaman.id_anggota', $this->session->userdata('user_user_id'));
        }
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

    function get_datatables()
    {
        $this->_get_datatables_query();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered()
    {
        $this->_get_datatables_query();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all()
    {

        $this->_get_datatables_query();
        $query = $this->db->get();

        return $this->db->count_all_results();
    }

    public function save_file($data)
    {
        $this->db->insert('saldo_pinjaman', $data);
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
        $this->db->update('saldo_pinjaman', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('saldo_pinjaman');
        return $this->db->get()->result();
    }
    public function get_anggota()
    {
        $this->db->select('anggota.*, koperasi.nama_koperasi');
        $this->db->from('anggota');
        $this->db->join('toko', 'anggota.id_toko = toko.id', 'left');
        $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        // if ($this->session->userdata('role') == "Koperasi") {
        // $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        // $this->db->where('role >', '1');
        // } else if ($this->session->userdata('role') == "Kasir") {
        // $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        // $this->db->where('role', '4');
        // }
        $this->db->where('role >', '3');

        return $this->db->get()->result();
    }
    public function get_anggota_by_koperasi()
    {
        $this->db->select('anggota.*, koperasi.nama_koperasi');
        $this->db->from('anggota');
        // $this->db->join('toko', 'anggota.id_toko = toko.id', 'left');
        $this->db->join('koperasi', 'anggota.id_koperasi = koperasi.id', 'left');
        if ($this->session->userdata('role') != 'Admin') {
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        }
        $this->db->where('role >', '3');

        return $this->db->get()->result();
    }
    public function get_latest_entry($year)
    {
        $this->db->select('id');
        $this->db->from('saldo_pinjaman'); // Change to your actual table name
        $this->db->where("RIGHT(id, 4) =", $year); // Fix the SQL syntax
        $this->db->order_by("id", "DESC");
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row(); // Return the latest row
    }

    public function get_saldo_pinjaman_kredit_by_anggota_id($id)
    {
        // Step 1: Get the records
        $this->db->from('saldo_pinjaman');
        $this->db->where('id_anggota', $id);
        $this->db->where('status', '1');
        $saldo_pinjamans = $this->db->get()->result();

        // Step 2: Loop through and update status
        foreach ($saldo_pinjamans as $saldo_pinjaman) {
            $this->db->where('id', $saldo_pinjaman->id); // assuming 'id' is the primary key
            $this->db->update('saldo_pinjaman', ['status' => '2']);
        }
    }

    public function total_saldo_pinjaman_anggota($id)
    {
        $this->db->select_sum('nominal');
        $this->db->from('saldo_pinjaman');
        $this->db->where('id_anggota', $id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result = $query->row();

        return $result->nominal;
    }

    var $table_monitor_pinjaman = 'anggota';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order_monitor_pinjaman = array('anggota.id', 'nomor_anggota', 'nama', 'tanggal_pinjaman_terakhir'); //set column field database for datatable orderable
    var $column_search_monitor_pinjaman = array('anggota.id', 'nomor_anggota', 'nama', 'tanggal_pinjaman_terakhir'); //set column field database for datatable searchable 

    var $order_monitor_pinjaman = array('anggota.id' => 'DESC'); // default order 

    function _get_datatables_query_monitor_pinjaman($filter_status  = null)
    {

        $this->db->select('anggota.*, koperasi.nama_koperasi');
        $this->db->from('anggota');
        // $this->db->join('toko', 'anggota.id_toko = toko.id', 'left');
        $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');
        $this->db->where('anggota.status', 1);
        $this->db->where('role', 4);

        // Tambahkan logika filter
        if ($filter_status == 'Belum Dibayar') {
            $this->db->where('tanggal_pinjaman_terakhir <', date('Y-m-d'));
            $this->db->or_where('tanggal_pinjaman_terakhir', null);
        } else if ($filter_status == 'Sudah Dibayar') {
            $this->db->where('tanggal_pinjaman_terakhir >=', date('Y-m-d'));
            $this->db->or_where("DATE_FORMAT(tanggal_pinjaman_terakhir, '%Y-%m') =", date('Y-m'));
        }
        // if ($this->session->userdata('role') == "Kasir") {
        //     $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        // }

        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        }

        $i = 0;
        foreach ($this->column_search_monitor_pinjaman as $item) // loop column 
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

                if (count($this->column_search_monitor_pinjaman) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_monitor_pinjaman[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_monitor_pinjaman)) {
            $order = $this->order_monitor_pinjaman;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_monitor_pinjaman($filter_status)
    {
        $this->_get_datatables_query_monitor_pinjaman($filter_status);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_monitor_pinjaman($filter_status)
    {
        $this->_get_datatables_query_monitor_pinjaman($filter_status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_monitor_pinjaman()
    {

        $this->_get_datatables_query_monitor_pinjaman();
        $query = $this->db->get();

        return $this->db->count_all_results();
    }


    public function get_data_untuk_export($status)
    {
        // Build the main WHERE clause
        $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        $this->db->where('status', 1);
        $this->db->where('role', '4');

        // Add a group for the 'Belum Dibayar' status conditions
        if ($status == 'Belum Dibayar') {
            $this->db->group_start();
            // $this->db->where('tanggal_pinjaman_terakhir <', date('Y-m-d'));
            $this->db->where("DATE_FORMAT(tanggal_pinjaman_terakhir, '%Y-%m') <", date('Y-m'));
            $this->db->or_where('tanggal_pinjaman_terakhir', null);
            // $this->db->or_where("DATE_FORMAT(tanggal_pinjaman_terakhir, '%Y-%m') <", date('Y-m'));
            $this->db->group_end();
        }

        // Assume your table is named 'anggota'
        $query = $this->db->get('anggota');
        return $query->result();
    }

    var $table_monitor_pinjaman_anggota = 'saldo_pinjaman';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order_monitor_pinjaman_anggota = array('saldo_pinjaman.id', 'nominal', 'keterangan', 'cicilan', 'sisa_cicilan', 'tanggal_jam'); //set column field database for datatable orderable
    var $column_search_monitor_pinjaman_anggota = array('saldo_pinjaman.id', 'nominal', 'keterangan', 'cicilan', 'sisa_cicilan', 'tanggal_jam'); //set column field database for datatable searchable 

    var $order_monitor_pinjaman_anggota = array('saldo_pinjaman.id' => 'DESC'); // default order 

    function _get_datatables_query_monitor_pinjaman_anggota($nomor_anggota, $filter_status  = null)
    {

        // $this->db->select('anggota.*, koperasi.nama_koperasi');
        // $this->db->from('anggota');
        // $this->db->join('toko', 'anggota.id_toko = toko.id', 'left');
        // $this->db->join('koperasi', 'koperasi.id = anggota.id_koperasi', 'left');

        $this->db->select('saldo_pinjaman.*, anggota.nama, anggota.nomor_anggota');
        $this->db->from('saldo_pinjaman');
        $this->db->join('anggota', 'anggota.id = saldo_pinjaman.id_anggota');
        $this->db->where('saldo_pinjaman.status', 1);
        $this->db->where('anggota.nomor_anggota', $nomor_anggota);

        // $this->db->where('role', 4);

        // Tambahkan logika filter
        // if ($this->session->userdata('role') == "Kasir") {
        //     $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        // }

        $i = 0;
        foreach ($this->column_search_monitor_pinjaman_anggota as $item) // loop column 
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

                if (count($this->column_search_monitor_pinjaman_anggota) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_monitor_pinjaman_anggota[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_monitor_pinjaman_anggota)) {
            $order = $this->order_monitor_pinjaman_anggota;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_monitor_pinjaman_anggota($nomor_anggota, $filter_status)
    {
        $this->_get_datatables_query_monitor_pinjaman_anggota($nomor_anggota, $filter_status);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_monitor_pinjaman_anggota($nomor_anggota, $filter_status)
    {
        $this->_get_datatables_query_monitor_pinjaman_anggota($nomor_anggota, $filter_status);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_monitor_pinjaman_anggota($nomor_anggota)
    {

        $this->_get_datatables_query_monitor_pinjaman_anggota($nomor_anggota);
        $query = $this->db->get();

        return $this->db->count_all_results();
    }


    public function get_data_untuk_export_per_anggota($nomor_anggota)
    {
        // Logika untuk mengambil semua data yang belum dibayar


        // Asumsi tabel Anda bernama 'anggota'
        $this->db->select('saldo_pinjaman.*, anggota.nama, anggota.nomor_anggota');
        $this->db->from('saldo_pinjaman');
        $this->db->join('anggota', 'anggota.id = saldo_pinjaman.id_anggota');
        $this->db->where('saldo_pinjaman.status', 1);
        $this->db->where('anggota.nomor_anggota', $nomor_anggota);
        $query = $this->db->get();
        return $query->result();
    }
}
