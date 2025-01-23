<?php defined('BASEPATH') or exit('No direct script access allowed');

class Artikel_Management_m extends CI_Model
{
    var $table = 'artikel';
    // var $column_order = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable orderable
    // var $column_search = array('Id', 'title', 'thumbnail', 'tanggal', 'view_count'); //set column field database for datatable searchable 
    var $column_order = array('Id', 'thumbnail'); //set column field database for datatable orderable
    var $column_search = array('Id', 'thumbnail'); //set column field database for datatable searchable 

    var $order = array('artikel.Id' => 'DESC'); // default order 

    function _get_datatables_query()
    {

        $this->db->select('artikel.*');
        $this->db->from('artikel');
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
        $this->db->insert('artikel', $data);
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

    public function update_file($data, $where)
    {
        $this->db->update('artikel', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete($this->table, $where);
    }
    public function get_category()
    {
        $this->db->select('*');
        $this->db->from('category');
        // $this->db->where('posisi', 'Pengurus');
        return $this->db->get()->result();
    }
    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('artikel');
        return $this->db->get()->result();
    }

    public function get_artikel()
    {
        $this->db->select('*');
        $this->db->from('artikel');


        $this->db->order_by('tanggal', 'DESC');
        // $this->db->limit(1);
        $query = $this->db->get();
        return $query->result();
    }
    public function artikel_recent()
    {

        // Get weekly top news, ensuring it does not include trending_1, trending_2, sub_trending_1, or sub_trending_2
        $this->db->select('*');
        $this->db->from('artikel');

        // Exclude the articles that are part of trending_1, trending_2, sub_trending_1, and sub_trending_2
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(5);
        $query = $this->db->get();
        return $query->result();
    }
    public function artikel_home()
    {

        // Get weekly top news, ensuring it does not include trending_1, trending_2, sub_trending_1, or sub_trending_2
        $this->db->select('*');
        $this->db->from('artikel');

        // Exclude the articles that are part of trending_1, trending_2, sub_trending_1, and sub_trending_2
        $this->db->order_by('tanggal', 'DESC');
        $this->db->limit(3);
        $query = $this->db->get();
        return $query->result();
    }
    public function update_count($id)
    {
        $this->db->set('view_count', 'view_count + 1', FALSE); // FALSE prevents escaping of the expression
        $this->db->where('Id', $id);
        $this->db->update('artikel'); // Replace 'your_table_name' with your actual table name
    }

    function item_get($limit, $start, $search)
    {
        if ($search) {
            // $sql = "SELECT * FROM item_list WHERE nama LIKE '%$search%' OR nomor LIKE '%$search%' ORDER BY Id DESC limit " . $start . ", " . $limit;
            $sql = "SELECT * FROM artikel WHERE artikel.title LIKE '%$search%' ORDER BY Id DESC limit " . $start . ", " . $limit;
        } else {
            $sql = "SELECT * FROM artikel ORDER BY Id DESC limit " . $start . ", " . $limit;
        }
        $query = $this->db->query($sql);
        return $query->result();
    }

    function item_count($search)
    {
        if ($search) {
            $sql = "SELECT * FROM artikel WHERE title LIKE '%$search%'";
        } else {
            $sql = "SELECT * FROM artikel";
        }
        $query = $this->db->query($sql);
        return $query->num_rows();
    }
}
