<?php defined('BASEPATH') or exit('No direct script access allowed');

class Anggota_Management_m extends CI_Model
{
    var $table = 'anggota';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order = array('id', 'nomor_anggota', 'nama', 'tempat_lahir', 'tanggal_lahir', 'no_telp', 'username', 'kredit_limit', 'usage_kredit', 'id_toko'); //set column field database for datatable orderable
    var $column_search = array('id', 'nomor_anggota', 'nama', 'tempat_lahir', 'tanggal_lahir', 'no_telp', 'username', 'kredit_limit', 'usage_kredit', 'id_toko'); //set column field database for datatable searchable 

    var $order = array('anggota.id' => 'DESC'); // default order 

    function _get_datatables_query()
    {

        $this->db->select('anggota.*, koperasi.nama_koperasi, toko.nama_toko');
        $this->db->from('anggota');
        $this->db->join('toko', 'anggota.id_toko = toko.id', 'left');
        $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
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
    public function get_koperasi()
    {
        $this->db->select('toko.*, koperasi.nama_koperasi');
        $this->db->from('toko');
        $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        return $this->db->get()->result();
    }
}
