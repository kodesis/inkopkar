<?php defined('BASEPATH') or exit('No direct script access allowed');

class Nota_m extends CI_Model
{
    var $table = 'nota';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order = array('id', 'tanggal_jam', 'nominal_kredit', 'nominal_cash', 'toko.nama_toko', 'nama'); //set column field database for datatable orderable
    var $column_search = array('id', 'tanggal_jam', 'nominal_kredit', 'nominal_cash', 'toko.nama_toko', 'nama'); //set column field database for datatable searchable 

    var $order = array('nota.id' => 'DESC'); // default order 

    function _get_datatables_query($id)
    {

        $this->db->select('nota.*, toko.nama_toko, koperasi.nama_koperasi, anggota.nama');
        $this->db->from('nota');
        $this->db->where('id_anggota', $id);
        $this->db->join('toko', 'nota.id_toko = toko.id', 'left');
        $this->db->join('koperasi', 'toko.id_koperasi = koperasi.id', 'left');
        $this->db->join('anggota', 'anggota.id = nota.id_kasir', 'left');

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

    function get_datatables($id)
    {
        $this->_get_datatables_query($id);
        if ($_POST['length'] != -1)
            $this->db->limit($_POST['length'], $_POST['start']);
        $query = $this->db->get();
        return $query->result();
    }

    function count_filtered($id)
    {
        $this->_get_datatables_query($id);
        $query = $this->db->get();
        return $query->num_rows();
    }

    function count_all($id)
    {

        $this->_get_datatables_query($id);
        $query = $this->db->get();

        return $this->db->count_all_results();
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
}
