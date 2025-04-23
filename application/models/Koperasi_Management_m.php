<?php defined('BASEPATH') or exit('No direct script access allowed');

class Koperasi_Management_m extends CI_Model
{
    var $table = 'koperasi';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order = array('id', 'nama_koperasi', 'alamat', 'telp'); //set column field database for datatable orderable
    var $column_search = array('id', 'nama_koperasi', 'alamat', 'telp'); //set column field database for datatable searchable 

    var $order = array('koperasi.id' => 'DESC'); // default order 

    function _get_datatables_query()
    {

        $this->db->select('koperasi.*');
        $this->db->from('koperasi');
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
        $this->db->insert('koperasi', $data);
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
        $this->db->update('koperasi', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('koperasi');
        return $this->db->get()->result();
    }

    public function total_saldo_koperasi_tagihan()
    {
        // $this->db->select_sum('saldo_tagihan');
        // $this->db->select_sum('saldo_rekening');
        // $this->db->from('koperasi');
        $this->db->select_sum('nominal');
        $this->db->from('nota_pembayaran');
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result = $query->row();
        $saldo_tagihan = $result->nominal ?? 0;

        return $saldo_tagihan;
    }
    public function total_saldo_koperasi_rekening()
    {
        // $this->db->select_sum('saldo_tagihan');
        // $this->db->select_sum('saldo_rekening');
        // $this->db->from('koperasi');

        $this->db->select_sum('nominal');
        $this->db->from('nota_pembayaran');
        $this->db->where('status', '2');
        $query = $this->db->get();
        $result = $query->row();
        $saldo_rekening = $result->nominal ?? 0;

        return $saldo_rekening;
    }
    public function total_saldo_usage_anggota()
    {
        // $this->db->select_sum('usage_kredit');
        // $this->db->from('anggota');

        $this->db->select_sum('nominal_kredit');
        $this->db->from('nota');
        $this->db->where('status', '1');

        $query = $this->db->get();
        $semua_kredit = $query->row();
        $total_semua_kredit = $semua_kredit->nominal_kredit;
        // return $this->db->get()->row();
        return $total_semua_kredit;
    }

    public function save_log_transaksi($data)
    {
        $this->db->insert('log_transaksi', $data);
        return $this->db->insert_id();
    }
    public function update_nota_pembayaran($id)
    {
        // Step 1: Get the records
        $this->db->from('nota_pembayaran');
        $this->db->join('anggota', 'anggota.id = nota_pembayaran.id_anggota');
        $this->db->where('anggota.id_koperasi', $id);
        $this->db->where('status', '1');
        $notas = $this->db->get()->result();
        return $notas;
        // Step 2: Loop through and update status

    }
}
