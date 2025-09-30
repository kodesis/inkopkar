<?php defined('BASEPATH') or exit('No direct script access allowed');

class Riwayat_Kasir_m extends CI_Model
{
    var $table = 'nota';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order = array('nota.id', 'tanggal_jam', 'nominal_kredit', 'nominal_cash', 'koperasi.nama_koperasi', 'nama', 'nota.status'); //set column field database for datatable orderable
    var $column_search = array('nota.id', 'tanggal_jam', 'nominal_kredit', 'nominal_cash', 'koperasi.nama_koperasi', 'nama', 'nota.status'); //set column field database for datatable searchable 

    var $order = array('nota.id' => 'DESC'); // default order 

    function _get_datatables_query()
    {

        $this->db->select('nota.*, koperasi.nama_koperasi, anggota.nama');
        $this->db->from('nota');
        $this->db->join('anggota', 'anggota.id = nota.id_anggota');
        $this->db->join('koperasi', 'anggota.id_koperasi = koperasi.id', 'left');
        $this->db->join('toko', 'toko.id = nota.id_toko', 'left');

        if ($this->session->userdata('role') == "Kasir") {
            $this->db->where('anggota.status', '1');
            $this->db->where('nota.id_toko', $this->session->userdata('id_toko'));
            // $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
            // $this->db->where('nota.status', '1');
            $this->db->where('nota.status <', '2');
        } else if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('anggota.status', '1');
            $this->db->where('toko.id_koperasi', $this->session->userdata('id_koperasi'));
            // $this->db->where('toko.id_koperasi', $this->session->userdata('id_koperasi'));
            // $this->db->where('nota.status', '1');
            // $this->db->where('nota.status <', '2');
        } else if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('nota.id_anggota', $this->session->userdata('user_user_id'));
        }
        // else {
        //     $this->db->where('nota.status <', '2');
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

    public function get_total_saldo_filtered_kredit()
    {
        $this->_get_datatables_query(); // same filter logic as your table
        $this->db->select_sum('nominal_kredit');
        $query = $this->db->get();
        return $query->row()->nominal_kredit;
    }
    public function get_total_saldo_filtered_cash()
    {
        $this->_get_datatables_query(); // same filter logic as your table
        $this->db->select_sum('nominal_cash');
        $query = $this->db->get();
        return $query->row()->nominal_cash;
    }

    public function save_file($data)
    {
        $this->db->insert('nota', $data);
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
        $this->db->update('nota', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('nota');
        return $this->db->get()->result();
    }
    public function get_anggota()
    {
        $this->db->select('*');
        $this->db->from('anggota');
        return $this->db->get()->result();
    }
    public function get_id_nota($id)
    {
        $this->db->select('*');
        $this->db->from($this->table);
        $this->db->where('sub_id', $id);
        $query = $this->db->get();

        return $query->row();
    }

    var $table_pembayaran = 'nota_pembayaran';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order_pembayaran = array('nota_pembayaran.id', 'anggota.nama', 'nama_koperasi', 'tanggal_jam', 'nominal', 'status'); //set column field database for datatable orderable
    var $column_search_pembayaran = array('nota_pembayaran.id', 'anggota.nama', 'nama_koperasi', 'tanggal_jam', 'nominal', 'status'); //set column field database for datatable searchable 

    var $order_pembayaran = array('nota_pembayaran.id' => 'DESC'); // default order 

    function _get_datatables_query_pembayaran()
    {

        $this->db->select('nota_pembayaran.*, koperasi.nama_koperasi as nama_koperasi, anggota.nama');
        $this->db->from('nota_pembayaran');
        // $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        $this->db->join('anggota', 'anggota.id = nota_pembayaran.id_anggota', 'left');
        $this->db->join('koperasi', 'anggota.id_koperasi = koperasi.id', 'left');
        $this->db->where('anggota.status', '1');

        if ($this->session->userdata('role') == "Kasir") {
            $this->db->where('anggota.status', 1);
            // $this->db->where('toko.id', $this->session->userdata('id_toko'));
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        } else if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('anggota.status', 1);
            // $this->db->where('toko.id_koperasi', $this->session->userdata('id_koperasi'));
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        } else if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('nota_pembayaran.id_anggota', $this->session->userdata('user_user_id'));
        }
        $i = 0;
        foreach ($this->column_search_pembayaran as $item) // loop column 
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

                if (count($this->column_search_pembayaran) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_pembayaran[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_pembayaran)) {
            $order = $this->order_pembayaran;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_pembayaran()
    {
        $this->_get_datatables_query_pembayaran();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_pembayaran()
    {
        $this->_get_datatables_query_pembayaran();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_pembayaran()
    {

        $this->_get_datatables_query_pembayaran();
        $query = $this->db->get();

        return $this->db->count_all_results();
    }

    public function get_total_saldo_filtered_pembayaran()
    {
        $this->_get_datatables_query_pembayaran(); // same filter logic as your table
        $this->db->select_sum('nominal');
        $query = $this->db->get();
        return $query->row()->nominal;
    }

    function get_total_pembayaran()
    {

        $this->db->select_sum('nominal');
        $this->db->from('nota_pembayaran');
        // $this->db->join('toko', 'nota_pembayaran.id_toko = toko.id', 'left');
        // $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        $this->db->join('anggota', 'anggota.id = nota_pembayaran.id_anggota', 'left');
        $this->db->where('anggota.status', '1');
        if ($this->session->userdata('role') == "Kasir") {
            $this->db->where('anggota.status', 1);
            // $this->db->where('toko.id', $this->session->userdata('id_toko'));
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        } else if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('anggota.status', 1);
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        } else if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('nota_pembayaran.id_anggota', $this->session->userdata('user_user_id'));
        }
        return $this->db->get()->row();
    }

    var $table_transaksi_inkopkar = 'log_transaksi';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order_transaksi_inkopkar = array('log_transaksi.id', 'anggota.nama', 'a.nama_koperasi', 'b.nama_koperasi', 'post_date', 'sebelum', 'nominal', 'sesudah'); //set column field database for datatable orderable
    var $column_search_transaksi_inkopkar = array('log_transaksi.id', 'anggota.nama', 'a.nama_koperasi', 'b.nama_koperasi', 'post_date', 'sebelum', 'nominal', 'sesudah');

    var $order_transaksi_inkopkar = array('log_transaksi.id' => 'DESC'); // default order 

    function _get_datatables_query_transaksi_inkopkar()
    {

        $this->db->select('log_transaksi.*, anggota.nama, a.nama_koperasi as koperasi_awal, b.nama_koperasi as koperasi_tujuan');
        $this->db->from('log_transaksi');
        $this->db->join('anggota', 'anggota.id = log_transaksi.id_admin', 'left');
        $this->db->join('koperasi a', 'a.id = log_transaksi.id_koperasi_awal', 'left');
        $this->db->join('koperasi b', 'b.id = log_transaksi.id_koperasi_tujuan', 'left');
        $this->db->where('anggota.status', '1');


        $i = 0;
        foreach ($this->column_search_transaksi_inkopkar as $item) // loop column 
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

                if (count($this->column_search_transaksi_inkopkar) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_transaksi_inkopkar[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_transaksi_inkopkar)) {
            $order = $this->order_transaksi_inkopkar;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_transaksi_inkopkar()
    {
        $this->_get_datatables_query_transaksi_inkopkar();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_transaksi_inkopkar()
    {
        $this->_get_datatables_query_transaksi_inkopkar();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_transaksi_inkopkar()
    {

        $this->_get_datatables_query_transaksi_inkopkar();
        $query = $this->db->get();

        return $this->db->count_all_results();
    }
    public function get_total_saldo_filtered_transaksi_inkopkar()
    {
        $this->_get_datatables_query_transaksi_inkopkar(); // same filter logic as your table
        $this->db->select_sum('nominal');
        $query = $this->db->get();
        return $query->row()->nominal;
    }

    function get_total_transaksi_inkopkar()
    {

        $this->db->select_sum('nominal');
        $this->db->from('log_transaksi');
        return $this->db->get()->row();
    }

    var $table_saldo_simpanan = 'saldo_simpanan';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order_saldo_simpanan = array('anggota.nomor_anggota', 'anggota.nama', 'tipe_simpanan', 'nominal', 'tanggal_jam', 'sampai_dengan'); //set column field database for datatable orderable
    var $column_search_saldo_simpanan = array('anggota.nomor_anggota', 'anggota.nama', 'tipe_simpanan', 'nominal', 'tanggal_jam', 'sampai_dengan'); //set column field database for datatable searchable 

    var $order_saldo_simpanan = array('saldo_simpanan.id' => 'DESC'); // default order 

    function _get_datatables_query_saldo_simpanan($month = null, $year = null)
    {
        $this->db->select('saldo_simpanan.*, koperasi.nama_koperasi as nama_koperasi,anggota.nomor_anggota ,anggota.nama');
        $this->db->from('saldo_simpanan');
        $this->db->join('anggota', 'anggota.id = saldo_simpanan.id_anggota', 'left');
        $this->db->join('koperasi', 'anggota.id_koperasi = koperasi.id', 'left');
        $this->db->where('saldo_simpanan.status', '1');

        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('anggota.status', '1');
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        } else if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('saldo_simpanan.id_anggota', $this->session->userdata('user_user_id'));
        } else if ($this->session->userdata('role') == "Puskopkar") {
            $this->db->where('anggota.status', '1');
            $this->db->where('anggota.id_puskopkar', $this->session->userdata('user_user_id'));
        }

        // Add the new date range filtering logic
        // if (!empty($month) && !empty($year)) {
        //     // Construct the start and end dates for the selected month/year
        //     $start_date = date('Y-m-01', strtotime("$year-$month-01"));
        //     $end_date = date('Y-m-t', strtotime("$year-$month-01"));

        //     // Apply the WHERE clause. This checks for any overlap between the record's date range
        //     // (tanggal_jam to sampai_dengan) and the selected month's date range.
        //     // $this->db->where("(`tanggal_jam` <= '$end_date' AND `sampai_dengan` >= '$start_date')");
        //     $this->db->where("(`tanggal_jam` <= '$end_date' AND `sampai_dengan` >= '$start_date')");
        // }

        // Add the new date range filtering logic
        if (!empty($month) || !empty($year)) {
            // Both month and year are specified
            if (!empty($month) && !empty($year)) {
                $start_date = date('Y-m-01', strtotime("$year-$month-01"));
                $end_date = date('Y-m-t', strtotime("$year-$month-01"));

                $this->db->where("(`tanggal_jam` <= '$end_date' AND `sampai_dengan` >= '$start_date')");
            }
            // Only month is specified (search within the current year)
            else if (!empty($month)) {
                $current_year = date('Y');
                $start_date = date('Y-m-01', strtotime("$current_year-$month-01"));
                $end_date = date('Y-m-t', strtotime("$current_year-$month-01"));

                $this->db->where("(`tanggal_jam` <= '$end_date' AND `sampai_dengan` >= '$start_date')");
            }
            // Only year is specified (search all months within that year)
            else if (!empty($year)) {
                $start_date = date('Y-01-01', strtotime("$year-01-01"));
                $end_date = date('Y-12-31', strtotime("$year-12-31"));

                $this->db->where("(`tanggal_jam` <= '$end_date' AND `sampai_dengan` >= '$start_date')");
            }
        }

        $i = 0;
        foreach ($this->column_search_saldo_simpanan as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }
                if (count($this->column_search_saldo_simpanan) - 1 == $i) {
                    $this->db->group_end();
                }
            }
            $i++;
        }

        if (isset($_POST['order'])) {
            $this->db->order_by($this->column_order_saldo_simpanan[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_saldo_simpanan)) {
            $order = $this->order_saldo_simpanan;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    // Update the function signatures for get_datatables and count functions
    function get_datatables_saldo_simpanan($month, $year)
    {
        $this->_get_datatables_query_saldo_simpanan($month, $year);
        if ($_POST['length'] != -1) {
            $this->db->limit($_POST['length'], $_POST['start']);
        }
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_saldo_simpanan($month, $year)
    {
        $this->_get_datatables_query_saldo_simpanan($month, $year);
        $query = $this->db->get();
        return $query->num_rows();
    }


    function count_all_saldo_simpanan()
    {

        $this->_get_datatables_query_saldo_simpanan();
        $query = $this->db->get();

        return $this->db->count_all_results();
    }

    // Note: count_all doesn't need the filter, as it counts all records, not just the filtered ones.
    // So no change is needed here.

    public function get_total_saldo_filtered_simpanan($month, $year)
    {
        $this->_get_datatables_query_saldo_simpanan($month, $year);
        $this->db->select_sum('nominal');
        $query = $this->db->get();
        return $query->row()->nominal;
    }

    function get_total_saldo_simpanan()
    {

        $this->db->select_sum('nominal');
        $this->db->from('saldo_simpanan');
        $this->db->join('anggota', 'saldo_simpanan.id_anggota = anggota.id', 'left');
        // $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('anggota.status', '1');
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        } else if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('saldo_simpanan.id_anggota', $this->session->userdata('user_user_id'));
        } else if ($this->session->userdata('role') == "Puskopkar") {
            $this->db->where('anggota.status', '1');
            $this->db->where('anggota.id_puskopkar', $this->session->userdata('user_user_id'));
        }
        return $this->db->get()->row();
    }

    var $table_iuran = 'iuran';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order_iuran = array('iuran.id', 'koperasi.nama_koperasi', 'nominal', 'tanggal_bayar', 'iuran.status'); //set column field database for datatable orderable
    var $column_search_iuran = array('iuran.id', 'koperasi.nama_koperasi', 'nominal', 'tanggal_bayar', 'iuran.status'); //set column field database for datatable searchable 

    var $order_iuran = array('iuran.tanggal_bayar' => 'DESC', 'iuran.status' => 'ASC'); // default order 

    function _get_datatables_query_iuran()
    {

        $this->db->select('iuran.*, koperasi.nama_koperasi');
        $this->db->from('iuran');
        $this->db->join('koperasi', 'iuran.id_koperasi = koperasi.id', 'left');
        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
        }
        // $this->db->where('status', '1');

        $i = 0;
        foreach ($this->column_search_iuran as $item) // loop column 
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

                if (count($this->column_search_iuran) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_iuran[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_iuran)) {
            $order = $this->order_iuran;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_iuran()
    {
        $this->_get_datatables_query_iuran();
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_iuran()
    {
        $this->_get_datatables_query_iuran();
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_iuran()
    {

        $this->_get_datatables_query_iuran();
        $query = $this->db->get();

        return $this->db->count_all_results();
    }
    public function get_total_saldo_filtered_iuran()
    {
        $this->_get_datatables_query_iuran(); // same filter logic as your table
        $this->db->select_sum('nominal');
        $query = $this->db->get();
        return $query->row()->nominal;
    }

    var $table_saldo_pinjaman = 'saldo_pinjaman';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order_saldo_pinjaman = array('saldo_pinjaman.id', 'anggota.nama', 'keterangan', 'jenis_pinjaman', 'bulan', 'tanggal_jam', 'nominal', 'cicilan', 'sisa_cicilan'); //set column field database for datatable orderable
    var $column_search_saldo_pinjaman = array('saldo_pinjaman.id', 'anggota.nama', 'keterangan', 'jenis_pinjaman', 'bulan', 'tanggal_jam', 'nominal', 'cicilan', 'sisa_cicilan'); //set column field database for datatable searchable 

    var $order_saldo_pinjaman = array('saldo_pinjaman.id' => 'DESC'); // default order 

    function _get_datatables_query_saldo_pinjaman($month = null, $year = null)
    {

        $this->db->select('saldo_pinjaman.*, koperasi.nama_koperasi as nama_koperasi, anggota.nama');
        $this->db->from('saldo_pinjaman');
        // $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        $this->db->join('anggota', 'anggota.id = saldo_pinjaman.id_anggota', 'left');
        $this->db->join('koperasi', 'anggota.id_koperasi = koperasi.id', 'left');
        $this->db->where('saldo_pinjaman.status', '1');

        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('anggota.status', '1');
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        } else  if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('saldo_pinjaman.id_anggota', $this->session->userdata('user_user_id'));
        } else if ($this->session->userdata('role') == "Puskopkar") {
            $this->db->where('anggota.status', '1');
            $this->db->where('anggota.id_puskopkar', $this->session->userdata('user_user_id'));
        }

        if (!empty($month) || !empty($year)) {
            // Start the WHERE clause with an empty string
            $where_clause = '';

            // If both month and year are specified, search for the exact month and year
            if (!empty($month) && !empty($year)) {
                $where_clause = "`tanggal_jam` BETWEEN '$year-$month-01 00:00:00' AND '$year-$month-31 23:59:59'";
            }
            // If only the month is specified, search for that month in any year
            else if (!empty($month)) {
                $where_clause = "MONTH(`tanggal_jam`) = '$month' OR `bulan` = '.$month.'";
            }
            // If only the year is specified, search for that year in any month
            else if (!empty($year)) {
                $where_clause = "YEAR(`tanggal_jam`) = '$year'";
            }

            // Apply the WHERE clause if it's not empty
            if (!empty($where_clause)) {
                $this->db->where($where_clause);
            }
        }

        $i = 0;
        foreach ($this->column_search_saldo_pinjaman as $item) // loop column 
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

                if (count($this->column_search_saldo_pinjaman) - 1 == $i) //last loop
                    $this->db->group_end(); //close bracket
            }
            $i++;
        }

        if (isset($_POST['order'])) // here order processing
        {
            $this->db->order_by($this->column_order_saldo_pinjaman[$_POST['order']['0']['column']], $_POST['order']['0']['dir']);
        } else if (isset($this->order_saldo_pinjaman)) {
            $order = $this->order_saldo_pinjaman;
            $this->db->order_by(key($order), $order[key($order)]);
        }
    }

    function get_datatables_saldo_pinjaman($month, $year)
    {
        $this->_get_datatables_query_saldo_pinjaman($month, $year);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered_saldo_pinjaman($month, $year)
    {
        $this->_get_datatables_query_saldo_pinjaman($month, $year);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all_saldo_pinjaman()
    {

        $this->_get_datatables_query_saldo_pinjaman();
        $query = $this->db->get();

        return $this->db->count_all_results();
    }

    public function get_total_saldo_filtered_pinjaman($month, $year)
    {
        $this->_get_datatables_query_saldo_pinjaman($month, $year); // same filter logic as your table
        $this->db->select_sum('cicilan');
        $query = $this->db->get();
        return $query->row()->cicilan;
    }

    function get_total_saldo_pinjaman()
    {

        // $this->db->select_sum('nominal');
        $this->db->select_sum('cicilan');
        $this->db->from('saldo_pinjaman');
        $this->db->join('anggota', 'saldo_pinjaman.id_anggota = anggota.id', 'left');
        // $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        if ($this->session->userdata('role') == "Koperasi") {
            $this->db->where('anggota.status', '1');
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        } else if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('saldo_pinjaman.id_anggota', $this->session->userdata('user_user_id'));
        } else if ($this->session->userdata('role') == "Puskopkar") {
            $this->db->where('anggota.status', '1');
            $this->db->where('anggota.id_puskopkar', $this->session->userdata('user_user_id'));
        }
        return $this->db->get()->row();
    }


    // ... other functions ...

    /**
     * Retrieves saldo pinjaman data, grouped by the posting date, for the current Koperasi.
     */
    public function get_saldo_pinjaman_by_date()
    {
        // Get the current Koperasi ID from the session
        $id_koperasi = $this->session->userdata('id_koperasi');
        $date_format_select = "DATE_FORMAT(t_main.post_dates, '%Y-%m-%d')";

        // 1. Select the relevant fields and perform the aggregation
        $this->db->select(
            't_main.post_dates as post_date, 
             SUM(t_main.nominal) as total_nominal, 
             SUM(t_main.cicilan) as total_cicilan, 
             SUM(t_main.sisa_cicilan) as total_outstanding',
            FALSE
        );
        $this->db->from('saldo_pinjaman t_main');

        // 2. Join with the 'anggota' table to apply the Koperasi filter
        $this->db->join('anggota', 'anggota.id = t_main.id_anggota');

        // 3. Apply the mandatory Koperasi filter
        $this->db->where('anggota.id_koperasi', $id_koperasi);

        // 4. Group the results by the posting date
        // Note: Assuming 'tanggal_jam' is the column that represents your 'post_dates'
        // $this->db->group_by('t_main.post_dates');
        $this->db->group_by($date_format_select);

        // 5. Order the results (optional, but useful for chronological order)
        $this->db->order_by('t_main.post_dates', 'DESC');

        return $this->db->get()->result();
    }

    public function delete_saldo_pinjaman_by_month($year, $month)
    {
        // Use CI's query builder where to filter based on MySQL functions YEAR() and MONTH()
        $this->db->where('YEAR(tanggal_jam)', $year);
        $this->db->where('MONTH(tanggal_jam)', $month);

        // Define the target table
        $table_name = 'saldo_pinjaman';

        // Execute the deletion
        $this->db->delete($table_name);

        // Check for database errors after the query executes
        $error = $this->db->error();

        if ($error['code'] != 0) {
            // Database error occurred
            return [
                'success' => false,
                'error_message' => $error['message'],
                'affected_rows' => 0
            ];
        } else {
            // Successful deletion (even if 0 rows were affected)
            return [
                'success' => true,
                'error_message' => null,
                'affected_rows' => $this->db->affected_rows()
            ];
        }
    }
}
