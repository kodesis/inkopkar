<?php defined('BASEPATH') or exit('No direct script access allowed');

class SaldoAkhir_m extends CI_Model
{
    var $table = 'saldo';
    var $column_order = array('saldo.id', 'anggota.nama', 'saldo_simpanan_awal', 'saldo_simpanan_akhir', 'saldo_pinjaman_awal', 'saldo_pinjaman_akhir', 'tanggal_data'); //set column field database for datatable orderable
    var $column_search = array('saldo.id', 'anggota.nama', 'saldo_simpanan_awal', 'saldo_simpanan_akhir', 'saldo_pinjaman_awal', 'saldo_pinjaman_akhir', 'tanggal_data'); //set column field database for datatable searchable 
    var $order = array('saldo.id' => 'asc'); // default order 

    function get_category()
    {
        return $this->db->get('role')->result_array();
    }
    function _get_datatables_query()
    {

        $this->db->select('saldo.*, anggota.nama');
        $this->db->from('saldo');
        $this->db->join('anggota', 'saldo.id_anggota = anggota.id');
        if ($this->session->userdata('role_id') == 4) {
            $this->db->where('saldo.id_anggota', $this->session->userdata('user_user_id'));
        } else if ($this->session->userdata('role_id') == 2) {
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        }

        // --- NEW: Month and Year Filtering ---
        if (isset($_POST['filter_month']) && $_POST['filter_month'] != '') {
            $month = $this->db->escape_str($_POST['filter_month']);
            $this->db->where("MONTH(tanggal_data)", $month);
        }

        if (isset($_POST['filter_year']) && $_POST['filter_year'] != '') {
            $year = $this->db->escape_str($_POST['filter_year']);
            $this->db->where("YEAR(tanggal_data)", $year);
        }
        // --- END NEW ---
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

    public function save_user($data)
    {
        $this->db->insert('saldo', $data);
        return $this->db->insert_id();
    }

    public function get_id_edit($id)
    {
        $this->db->select('saldo.*, anggota.nama');
        $this->db->from($this->table);
        $this->db->join('anggota', 'saldo.id_anggota = anggota.id');
        $this->db->where('saldo.id', $id);
        $query = $this->db->get();

        return $query->row();
    }
    public function get_cari($bulan, $tahun, $uid)
    {
        $this->db->select('saldo.*, anggota.nama');
        $this->db->from($this->table);
        $this->db->join('anggota', 'saldo.id_anggota = anggota.id');
        $this->db->where('saldo.id_anggota', $uid);

        // Add where clause for bulan and tahun
        $this->db->where('MONTH(saldo.tanggal_data)', $bulan);
        $this->db->where('YEAR(saldo.tanggal_data)', $tahun);
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->row();
    }
    public function update_user($data, $where)
    {
        $this->db->update('saldo', $data, $where);
    }

    public function delete($data, $where)
    {
        $this->db->update($this->table, $data, $where);
    }

    public function get_last_saldo()
    {
        $this->db->select('saldo.*');
        $this->db->from('saldo');
        $this->db->where('saldo.id_anggota', $this->session->userdata('user_user_id'));

        // Order by tanggal_data in descending order to get the latest record
        $this->db->order_by('tanggal_data', 'DESC');

        // Limit to 1 to get only the latest data
        $this->db->limit(1);

        $query = $this->db->get();

        return $query->row();
    }
}
