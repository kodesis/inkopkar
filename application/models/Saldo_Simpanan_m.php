<?php defined('BASEPATH') or exit('No direct script access allowed');

class Saldo_Simpanan_m extends CI_Model
{
    var $table = 'saldo_simpanan';
    var $column_order = array('id', 'nomor_anggota', 'tanggal_jam', 'nama', 'nominal_kredit'); //set column field database for datatable orderable
    var $column_search = array('id', 'nomor_anggota', 'tanggal_jam', 'nama', 'nominal_kredit'); //set column field database for datatable searchable 

    var $order = array('saldo_simpanan.id' => 'DESC'); // default order 

    function _get_datatables_query()
    {
        $this->db->select('saldo_simpanan.*, anggota.nama, anggota.nomor_anggota');
        $this->db->from('saldo_simpanan');
        $this->db->join('anggota', 'anggota.id = saldo_simpanan.id_anggota');
        $this->db->where('saldo_simpanan.status', '1');
        $this->db->where('anggota.status', 1);
        if ($this->session->userdata('role') == "Anggota") {
            $this->db->where('saldo_simpanan.id_anggota', $this->session->userdata('user_user_id'));
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
        $this->db->insert('saldo_simpanan', $data);
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
        $this->db->update('saldo_simpanan', $data, $where);
    }

    public function delete($where)
    {
        $this->db->delete($this->table, $where);
    }

    public function get_all()
    {
        $this->db->select('*');
        $this->db->from('saldo_simpanan');
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
        $this->db->from('saldo_simpanan'); // Change to your actual table name
        $this->db->where("RIGHT(id, 4) =", $year); // Fix the SQL syntax
        $this->db->order_by("id", "DESC");
        $this->db->limit(1);

        $query = $this->db->get();
        return $query->row(); // Return the latest row
    }

    public function get_saldo_simpanan_kredit_by_anggota_id($id)
    {
        // Step 1: Get the records
        $this->db->from('saldo_simpanan');
        $this->db->where('id_anggota', $id);
        $this->db->where('status', '1');
        $saldo_simpanans = $this->db->get()->result();

        // Step 2: Loop through and update status
        foreach ($saldo_simpanans as $saldo_simpanan) {
            $this->db->where('id', $saldo_simpanan->id); // assuming 'id' is the primary key
            $this->db->update('saldo_simpanan', ['status' => '2']);
        }
    }

    public function total_saldo_simpanan_anggota($id)
    {
        $this->db->select_sum('nominal');
        $this->db->from('saldo_simpanan');
        $this->db->where('id_anggota', $id);
        $this->db->where('status', '1');
        $query = $this->db->get();
        $result = $query->row();

        return $result->nominal;
    }

    public function insert_tipe_simpanan($data)
    {
        $this->db->insert('tipe_simpanan', $data);
        return $this->db->insert_id();
    }

    public function get_tipe_saldo_simpanan()
    {
        $this->db->select('*');
        $this->db->from('tipe_simpanan');

        return $this->db->get()->result();
    }
}
