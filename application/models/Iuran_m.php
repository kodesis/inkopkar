<?php defined('BASEPATH') or exit('No direct script access allowed');

class Iuran_m extends CI_Model
{
    var $table = 'iuran';
    var $column_order = array('iuran.id', 'nama_koperasi', 'nominal', 'post_date'); //set column field database for datatable orderable
    var $column_search = array('iuran.id', 'nama_koperasi', 'nominal', 'post_date'); //set column field database for datatable searchable 

    var $order = array('iuran.id' => 'DESC'); // default order 

    function _get_datatables_query()
    {
        $this->db->select('iuran.*, koperasi.nama_koperasi');
        $this->db->from('iuran');
        $this->db->join('koperasi', 'koperasi.id = iuran.id_koperasi');
        // $this->db->where('saldo_simpanan.status', '1');
        $this->db->where('koperasi.id_puskopkar', $this->session->userdata('user_user_id'));
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
        $this->db->insert('iuran', $data);
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

    public function get_latest_entry($year)
    {
        $this->db->select('id');
        $this->db->from('iuran'); // Change to your actual table name
        $this->db->where("RIGHT(id, 4) =", $year); // Fix the SQL syntax
        $this->db->order_by("id", "DESC");
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row(); // Return the latest row
    }
}
