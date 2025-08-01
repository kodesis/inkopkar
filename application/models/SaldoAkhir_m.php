<?php defined('BASEPATH') or exit('No direct script access allowed');

class SaldoAkhir_m extends CI_Model
{
    var $table = 'saldo';
    var $column_order = array('saldo.id', 'anggota.nama', 'keterangan_simpanan', 'saldo_simpanan_akhir', 'saldo_pinjaman_akhir', 'tanggal_data'); //set column field database for datatable orderable
    var $column_search = array('saldo.id', 'anggota.nama', 'keterangan_simpanan', 'saldo_simpanan_akhir', 'saldo_pinjaman_akhir', 'tanggal_data'); //set column field database for datatable searchable 
    var $order = array('saldo.id' => 'asc'); // default order 

    function get_category()
    {
        return $this->db->get('role')->result_array();
    }
    function _get_datatables_query()
    {
        // 1. Start building the main query
        $this->db->select('saldo.*, anggota.nama');
        $this->db->from('saldo');
        $this->db->join('anggota', 'saldo.id_anggota = anggota.id');

        // Apply initial role-based filtering to the main query
        if ($this->session->userdata('role_id') == 4) {
            $this->db->where('saldo.id_anggota', $this->session->userdata('user_user_id'));
        } else if ($this->session->userdata('role_id') == 2) {
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        }

        // 2. Check if filter month and year are NOT filled
        $month_filter_empty = !isset($_POST['filter_month']) || $_POST['filter_month'] == '';
        $year_filter_empty = !isset($_POST['filter_year']) || $_POST['filter_year'] == '';

        // --- Conditional Filtering Logic ---
        if ($month_filter_empty && $year_filter_empty) {
            // If filters are empty, get the latest entry for each anggota

            // IMPORTANT: Get a fresh, isolated database object for the subquery
            // This prevents the subquery's build process from interfering with the main query
            $CI = &get_instance(); // Get the CodeIgniter super object
            $subquery_db = $CI->load->database('', TRUE); // Load a new DB instance, TRUE returns the object

            // Build the subquery using the isolated $subquery_db object
            // The subquery should ONLY select id_anggota and MAX(tanggal_data)
            $subquery_db->select('s_inner.id_anggota, MAX(s_inner.tanggal_data) as max_tanggal_data')
                ->from('saldo s_inner') // Alias for clarity
                ->join('anggota a_inner', 's_inner.id_anggota = a_inner.id');

            // Apply the same role-based filtering to the subquery as well
            if ($this->session->userdata('role_id') == 4) {
                $subquery_db->where('s_inner.id_anggota', $this->session->userdata('user_user_id'));
            } else if ($this->session->userdata('role_id') == 2) {
                $subquery_db->where('a_inner.id_koperasi', $this->session->userdata('id_koperasi'));
            }
            $subquery_db->group_by('s_inner.id_anggota');

            // Compile the subquery into an SQL string from the NEW isolated instance
            $subquery_sql = $subquery_db->get_compiled_select();

            // Optional: Close the temporary subquery DB connection if it's no longer needed
            // This helps free up resources, though CI often manages connections well.
            $subquery_db->close();

            // Join the main query with the result of the subquery (a derived table)
            // This ensures we only select rows that match the maximum tanggal_data for their id_anggota
            $this->db->join(
                "($subquery_sql) latest_saldos",
                'saldo.id_anggota = latest_saldos.id_anggota AND saldo.tanggal_data = latest_saldos.max_tanggal_data',
                'inner' // Use inner join
            );
        } else {
            // If filters ARE provided, apply the specific month and year filters
            if (isset($_POST['filter_month']) && $_POST['filter_month'] != '') {
                $month = $this->db->escape_str($_POST['filter_month']);
                $this->db->where("MONTH(tanggal_data)", $month);
            }

            if (isset($_POST['filter_year']) && $_POST['filter_year'] != '') {
                $year = $this->db->escape_str($_POST['filter_year']);
                $this->db->where("YEAR(tanggal_data)", $year);
            }
        }
        // --- End Conditional Filtering Logic ---

        // 3. Rest of your existing search and order logic (no changes here)
        $i = 0;
        foreach ($this->column_search as $item) {
            if ($_POST['search']['value']) {
                if ($i === 0) {
                    $this->db->group_start();
                    $this->db->like($item, $_POST['search']['value']);
                } else {
                    $this->db->or_like($item, $_POST['search']['value']);
                }

                if (count($this->column_search) - 1 == $i)
                    $this->db->group_end();
            }
            $i++;
        }

        if (isset($_POST['order'])) {
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
        // 1. Start building the count query
        $this->db->from('saldo');
        $this->db->join('anggota', 'saldo.id_anggota = anggota.id');

        // Apply initial role-based filtering
        if ($this->session->userdata('role_id') == 4) {
            $this->db->where('saldo.id_anggota', $this->session->userdata('user_user_id'));
        } else if ($this->session->userdata('role_id') == 2) {
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        }

        // 2. Check if filter month and year are NOT filled
        $month_filter_empty = !isset($_POST['filter_month']) || $_POST['filter_month'] == '';
        $year_filter_empty = !isset($_POST['filter_year']) || $_POST['filter_year'] == '';

        // --- Conditional Filtering Logic (same as _get_datatables_query) ---
        if ($month_filter_empty && $year_filter_empty) {
            $CI = &get_instance();
            $subquery_db = $CI->load->database('', TRUE);

            $subquery_db->select('s_inner.id_anggota, MAX(s_inner.tanggal_data) as max_tanggal_data')
                ->from('saldo s_inner')
                ->join('anggota a_inner', 's_inner.id_anggota = a_inner.id');

            if ($this->session->userdata('role_id') == 4) {
                $subquery_db->where('s_inner.id_anggota', $this->session->userdata('user_user_id'));
            } else if ($this->session->userdata('role_id') == 2) {
                $subquery_db->where('a_inner.id_koperasi', $this->session->userdata('id_koperasi'));
            }
            $subquery_db->group_by('s_inner.id_anggota');

            $subquery_sql = $subquery_db->get_compiled_select();
            $subquery_db->close();

            $this->db->join(
                "($subquery_sql) latest_saldos",
                'saldo.id_anggota = latest_saldos.id_anggota AND saldo.tanggal_data = latest_saldos.max_tanggal_data',
                'inner'
            );
        } else {
            // Apply month and year filters to count_all as well
            if (isset($_POST['filter_month']) && $_POST['filter_month'] != '') {
                $month = $this->db->escape_str($_POST['filter_month']);
                $this->db->where("MONTH(tanggal_data)", $month);
            }

            if (isset($_POST['filter_year']) && $_POST['filter_year'] != '') {
                $year = $this->db->escape_str($_POST['filter_year']);
                $this->db->where("YEAR(tanggal_data)", $year);
            }
        }
        // --- End Conditional Filtering Logic ---

        return $this->db->count_all_results();
    }

    public function get_sum_columns()
    {
        // Start a new query for sums
        $this->db->select_sum('saldo.saldo_simpanan_akhir', 'total_saldo_simpanan'); // Sum for column 3
        $this->db->select_sum('saldo.saldo_pinjaman_akhir', 'total_saldo_pinjaman'); // Assuming column 5 is saldo_pinjaman_akhir, adjust if different

        $this->db->from('saldo');
        $this->db->join('anggota', 'saldo.id_anggota = anggota.id');

        // Apply role-based filtering (same as _get_datatables_query)
        if ($this->session->userdata('role_id') == 4) {
            $this->db->where('saldo.id_anggota', $this->session->userdata('user_user_id'));
        } else if ($this->session->userdata('role_id') == 2) {
            $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
        }

        // Check if filter month and year are NOT filled (same conditional logic)
        $month_filter_empty = !isset($_POST['filter_month']) || $_POST['filter_month'] == '';
        $year_filter_empty = !isset($_POST['filter_year']) || $_POST['filter_year'] == '';

        if ($month_filter_empty && $year_filter_empty) {
            // Use the same isolated subquery logic for sums
            $CI = &get_instance();
            $subquery_db = $CI->load->database('', TRUE);

            $subquery_db->select('s_inner.id_anggota, MAX(s_inner.tanggal_data) as max_tanggal_data')
                ->from('saldo s_inner')
                ->join('anggota a_inner', 's_inner.id_anggota = a_inner.id');

            if ($this->session->userdata('role_id') == 4) {
                $subquery_db->where('s_inner.id_anggota', $this->session->userdata('user_user_id'));
            } else if ($this->session->userdata('role_id') == 2) {
                $subquery_db->where('a_inner.id_koperasi', $this->session->userdata('id_koperasi'));
            }
            $subquery_db->group_by('s_inner.id_anggota');

            $subquery_sql = $subquery_db->get_compiled_select();
            $subquery_db->close();

            $this->db->join(
                "($subquery_sql) latest_saldos",
                'saldo.id_anggota = latest_saldos.id_anggota AND saldo.tanggal_data = latest_saldos.max_tanggal_data',
                'inner'
            );
        } else {
            // Apply month and year filters
            if (isset($_POST['filter_month']) && $_POST['filter_month'] != '') {
                $month = $this->db->escape_str($_POST['filter_month']);
                $this->db->where("MONTH(tanggal_data)", $month);
            }

            if (isset($_POST['filter_year']) && $_POST['filter_year'] != '') {
                $year = $this->db->escape_str($_POST['filter_year']);
                $this->db->where("YEAR(tanggal_data)", $year);
            }
        }

        $query = $this->db->get();
        return $query->row(); // Return a single row with the sums
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
