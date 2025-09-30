<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/userguide3/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();
		$this->load->database(); // Load library database
		$this->load->model('Kebutuhan_m', 'Kebutuhan_m');
	}

	public function index()
	{

		if ($this->session->userdata('user_logged_in') == false) {
			redirect('auth');
		}
		if ($this->session->userdata('role') != "Anggota") {
			$this->db->select_sum('saldo_tagihan');
			$this->db->select_sum('saldo_rekening');
			$this->db->from('koperasi');
			if ($this->session->userdata('role') == "Kasir" || $this->session->userdata('role') == "Koperasi") {
				$this->db->where('id', $this->session->userdata('id_koperasi'));
			} else if ($this->session->userdata('role') == "Puskopkar") {
				$this->db->where('id_puskopkar', $this->session->userdata('user_user_id'));
			}
			$query = $this->db->get();
			$result = $query->row();

			$saldo_tagihan = $result->saldo_tagihan ?? 0;
			$saldo_rekening = $result->saldo_rekening ?? 0;

			$data['saldo_tagihan'] = $saldo_tagihan;
			$data['saldo_rekening'] = $saldo_rekening;

			// $this->db->select_sum('nominal');
			// $this->db->from('nota_pembayaran');
			// $this->db->join('anggota', 'anggota.id = nota_pembayaran.id_anggota');
			// if ($this->session->userdata('role') == "Kasir" || $this->session->userdata('role') == "Koperasi") {
			// 	$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
			// }
			// $this->db->where('status', '1');
			// $query = $this->db->get();
			// $result = $query->row();
			// $saldo_tagihan = $result->nominal ?? 0;

			// $data['saldo_tagihan'] = $saldo_tagihan;

			// $this->db->select_sum('nominal');
			// $this->db->from('nota_pembayaran');
			// $this->db->join('anggota', 'anggota.id = nota_pembayaran.id_anggota');
			// if ($this->session->userdata('role') == "Kasir" || $this->session->userdata('role') == "Koperasi") {
			// 	$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
			// }
			// $this->db->where('status', '2');
			if ($this->session->userdata('role') == "Admin") {

				// $this->db->select_sum('nominal');
				// $this->db->from('log_transaksi');
				$this->db->select_sum('saldo_rekening');
				$this->db->from('koperasi');

				$query = $this->db->get();
				$result = $query->row();
				// $saldo_rekening = $result->nominal ?? 0;
				$saldo_rekening = $result->saldo_rekening ?? 0;
			} else {
				// $this->db->select_sum('nominal_kredit');
				// $this->db->from('nota');
				// $this->db->join('toko', 'toko.id = nota.id_toko');
				// if ($this->session->userdata('role') == "Kasir" || $this->session->userdata('role') == "Koperasi") {
				// 	$this->db->where('toko.id_koperasi', $this->session->userdata('id_koperasi'));
				// }
				// $this->db->where('status', '3');

				// $query = $this->db->get();
				// $result = $query->row();
				// $saldo_rekening = $result->nominal ?? 0;
				// $saldo_rekening = $result->nominal_kredit ?? 0;
			}
		} else {
			$this->db->select('kredit_limit');
			$this->db->from('anggota');
			$this->db->where('id', $this->session->userdata('user_user_id'));
			$query = $this->db->get();
			$result = $query->row();

			$saldo_tagihan = $result->kredit_limit ?? 0;
			$data['saldo_tagihan'] = $saldo_tagihan;
		}

		// $this->db->select_sum('usage_kredit');
		// $this->db->from('nota');
		// $this->db->join('anggota', 'anggota.id = nota.id_anggota');
		// if ($this->session->userdata('role') == "Kasir") {
		// 	$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		// } else if ($this->session->userdata('role') == "Koperasi") {
		// 	$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		// } else if ($this->session->userdata('role') == "Anggota") {
		// 	$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
		// }
		// $query = $this->db->get();
		// $result = $query->row();

		$total_semua_kredit = 0;
		$total_kredit = 0;
		if ($this->session->userdata('role') == "Admin") {
			$this->db->select_sum('nominal_kredit');
			$this->db->from('nota');
			$this->db->where('status >', '0');

			$query = $this->db->get();
			$semua_kredit = $query->row();
			$total_semua_kredit = $semua_kredit->nominal_kredit;
		} else if ($this->session->userdata('role') == "Anggota" || $this->session->userdata('role') == "Koperasi") {
			// SALDO SIMPANAN
			// $this->db->select_sum('nominal');
			// $this->db->from('saldo_simpanan');
			// $this->db->where('status', '1');
			// $this->db->where('id_anggota', $this->session->userdata('user_user_id'));

			// $query = $this->db->get();
			// $semua_kredit = $query->row();
			// $total_semua_kredit = $semua_kredit->nominal;

			$this->db->select_sum('nominal_kredit');
			$this->db->from('nota');
			$this->db->join('anggota', 'anggota.id = nota.id_anggota');
			$this->db->join('toko', 'toko.id = nota.id_toko');
			$this->db->where('anggota.status', '1');

			if ($this->session->userdata('role') == "Koperasi") {
				// $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
				$this->db->where('anggota.status', '1');

				$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
			} else if ($this->session->userdata('role') == "Anggota") {
				$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
			}

			$query = $this->db->get();
			$semua_kredit = $query->row();
			$total_semua_kredit = $semua_kredit->nominal_kredit;
		}
		$this->db->select_sum('nominal_kredit');
		$this->db->from('nota');
		$this->db->join('anggota', 'anggota.id = nota.id_anggota');
		$this->db->join('toko', 'toko.id = nota.id_toko');
		// $this->db->select_sum('usage_kredit');
		// $this->db->from('anggota');
		// $this->db->join('anggota', 'anggota.id = nota.id_anggota');
		if ($this->session->userdata('role') == "Kasir") {
			// $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
			$this->db->where('nota.id_toko', $this->session->userdata('id_toko'));
		} else if ($this->session->userdata('role') == "Koperasi") {
			// $this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
			$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		} else if ($this->session->userdata('role') == "Anggota") {
			$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
		}
		$this->db->where('anggota.status', '1');

		$query = $this->db->get();
		$result = $query->row();
		// $total_kredit = $result->usage_kredit;
		$total_kredit = $result->nominal_kredit;


		$data['total_semua_kredit'] = $total_semua_kredit;

		$data['total_kredit'] = $total_kredit;

		// $this->db->select_sum('saldo_iuran');
		// $this->db->from('koperasi');
		// if ($this->session->userdata('role') == "Koperasi") {
		// 	$this->db->where('id', $this->session->userdata('id_koperasi'));
		// } else if ($this->session->userdata('role') == "Puskopkar") {
		// 	$this->db->where('id_puskopkar', $this->session->userdata('user_user_id'));
		// }
		// $this->db->where('status', '1');

		// $query = $this->db->get();
		// $result = $query->row();
		// $total_saldo_iuran = $result->saldo_iuran;

		$this->db->select_sum('nominal');
		$this->db->from('iuran');
		$this->db->join('koperasi', 'koperasi.id = iuran.id_koperasi');
		if ($this->session->userdata('role') == "Koperasi") {
			$this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
		} else if ($this->session->userdata('role') == "Puskopkar") {
			$this->db->where('id_puskopkar', $this->session->userdata('user_user_id'));
		}

		$query = $this->db->get();
		$result = $query->row();
		$total_saldo_iuran = $result->nominal;
		if ($this->session->userdata('role') == "Koperasi" || $this->session->userdata('role') == "Puskopkar") {
			// $data['saldo_rekening'] = $saldo_rekening - $total_saldo_iuran;
			// $data['saldo_rekening'] = $saldo_rekening;
			$data['saldo_rekening'] = $saldo_rekening + $total_saldo_iuran;
			$data['total_saldo'] = $saldo_rekening + $total_saldo_iuran;
		} else if ($this->session->userdata('role') != "Anggota") {
			$data['total_saldo'] = $saldo_rekening + $total_saldo_iuran;
		}
		// $data['saldo_rekening'] = $saldo_rekening;
		$data['total_saldo_iuran'] = $total_saldo_iuran;

		// $data['total_saldo'] = $saldo_rekening;

		// echo $total_semua_kredit;
		// echo  $total_kredit;
		// $data['total_kredit'] = $result->nominal_kredit;

		$this->db->select_sum('nominal');
		$this->db->from('saldo_simpanan');
		$this->db->join('anggota', 'anggota.id = saldo_simpanan.id_anggota');

		// $this->db->select_sum('saldo_simpanan_akhir');
		// $this->db->from('saldo');
		// $this->db->join('anggota', 'anggota.id = saldo.id_anggota');
		if ($this->session->userdata('role') == "Koperasi") {
			$this->db->where('anggota.status', 1);
			$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		} else if ($this->session->userdata('role') == "Anggota") {
			$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
		}
		$tanggal = date('Y-m');
		$month = date('m', strtotime($tanggal)); // Get the month
		$year = date('Y', strtotime($tanggal));  // Get the year
		// $this->db->where(
		// 	'MONTH(tanggal_data)',
		// 	$month
		// ); // Filter by month
		// $this->db->where('YEAR(tanggal_data)', $year);   // Filter by year

		$query = $this->db->get();
		$result = $query->row();
		$total_saldo_simpanan = $result->nominal;
		// $total_saldo_simpanan = $result->saldo_simpanan_akhir;
		$data['total_saldo_simpanan'] = $total_saldo_simpanan;

		// 	// if ($this->session->userdata('role') == "Anggota") {
		// 	$this->db->select('MAX(id) as max_id', FALSE);
		// 	$this->db->from('saldo_pinjaman');

		// 	// Filter for Anggota role
		// 	if ($this->session->userdata('role') == "Anggota") {
		// 		// Filter by id_anggota directly since the column exists in saldo_pinjaman
		// 		$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
		// 	}
		// 	$this->db->group_by(array('id_anggota', 'jenis_pinjaman'));
		// 	$subquery = $this->db->get_compiled_select(); // Get the compiled SQL for the subquery


		// 	// Main query to select all columns from saldo_pinjaman
		// 	$this->db->select(
		// 		'SUM(saldo_pinjaman.cicilan) as total_cicilan, 
		//  SUM(saldo_pinjaman.nominal) as total_nominal, 
		//  SUM(saldo_pinjaman.sisa_cicilan) as total_outstanding',
		// 		FALSE
		// 	);
		// 	$this->db->from('saldo_pinjaman');

		// 	// Filter the main query to include only rows where the ID is in the result of the subquery
		// 	$this->db->where("saldo_pinjaman.id IN ({$subquery})", NULL, FALSE);
		// 	if ($this->session->userdata('role') == "Anggota") {
		// 		// Apply the same filtering again for the main query
		// 		$this->db->where('anggota.id', $this->session->userdata('user_user_id'));
		// 	}

		// 	$query = $this->db->get();
		// 	$result = $query->row();
		// 	$total_cicilan = $result->total_cicilan;
		// 	$total_nominal = $result->total_nominal;
		// 	$total_outstanding = $result->total_outstanding;

		$this->db->select('id_anggota, jenis_pinjaman, MAX(bulan) as max_bulan', FALSE);
		$this->db->from('saldo_pinjaman');

		// Filter for Anggota role in the subquery
		if ($this->session->userdata('role') == "Anggota") {
			$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
		}

		// Group by to find the LATEST month for each unique loan type per member
		$this->db->group_by(array('id_anggota', 'jenis_pinjaman'));
		$subquery_max_bulan = $this->db->get_compiled_select();

		// 2. Main query to select and SUM the required fields

		$this->db->select(
			'SUM(t1.cicilan) as total_cicilan, 
    SUM(t1.nominal) as total_nominal, 
    SUM(t1.sisa_cicilan) as total_outstanding',
			FALSE
		);
		$this->db->from('saldo_pinjaman t1');

		// JOIN the subquery to filter only the rows that match the latest month/combination
		// This effectively finds the single latest record for each loan combination.
		// We alias the subquery as 't2'
		$this->db->join("({$subquery_max_bulan}) t2", 't1.id_anggota = t2.id_anggota AND t1.jenis_pinjaman = t2.jenis_pinjaman AND t1.bulan = t2.max_bulan');

		// *Important:* Since you said you're worried about users having *two* pinjaman with the same jenis_pinjaman,
		// and you want both to be summed if they share the same latest 'bulan' date,
		// the join approach above is correct: it selects ALL records (including duplicates with the same date)
		// that match the latest date for that loan type group.

		// Filter the main query by the specific 'bulan' value you mentioned, '2025-10-01',
		// to ensure we only count active loans *up to* that date.
		// If your goal is truly to only sum items that have EXACTLY this 'bulan' value:
		// $this->db->where('t1.bulan', $latest_bulan);

		// If your goal is to sum the *latest* record, regardless of the date, you don't need the extra WHERE clause here,
		// as the JOIN on t1.bulan = t2.max_bulan already filters it to the latest record(s).

		// Final Anggota filter for the main query
		if ($this->session->userdata('role') == "Anggota") {
			// Filter by the id_anggota on the main table (t1)
			$this->db->where('t1.id_anggota', $this->session->userdata('user_user_id'));
		}

		$query = $this->db->get();
		$result = $query->row();
		$total_cicilan = $result->total_cicilan;
		$total_nominal = $result->total_nominal;
		$total_outstanding = $result->total_outstanding;

		// } else {
		// 	// $this->db->select_sum('nominal');
		// 	$this->db->select_sum('cicilan');
		// 	$this->db->from('saldo_pinjaman');
		// 	$this->db->join('anggota', 'anggota.id = saldo_pinjaman.id_anggota');
		// 	// $this->db->select_sum('saldo_pinjaman_akhir');
		// 	// $this->db->from('saldo');
		// 	// $this->db->join('anggota', 'anggota.id = saldo.id_anggota');
		// 	if ($this->session->userdata('role') == "Koperasi") {
		// 		$this->db->where('anggota.status', 1);
		// 		$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		// 	} else if ($this->session->userdata('role') == "Anggota") {
		// 		$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
		// 	}
		// 	$tanggal = date('Y-m');
		// 	$month = date('m', strtotime($tanggal)); // Get the month
		// 	$year = date('Y', strtotime($tanggal));  // Get the year
		// 	// $this->db->where(
		// 	// 	'MONTH(tanggal_data)',
		// 	// 	$month
		// 	// ); // Filter by month
		// 	// $this->db->where('YEAR(tanggal_data)', $year);   // Filter by year

		// 	$query = $this->db->get();
		// 	$result = $query->row();
		// 	// $total_saldo_pinjaman = $result->nominal;
		// 	$total_saldo_pinjaman = $result->cicilan;
		// 	// $total_saldo_pinjaman = $result->saldo_pinjaman_akhir;
		// }
		$data['total_cicilan'] = $total_cicilan;
		$data['total_nominal'] = $total_nominal;
		$data['total_outstanding'] = $total_outstanding;


		// ================================
		// SALDO INPUTAN AKHIR
		// ================================
		// $CI = &get_instance(); // Get the CodeIgniter super object

		// // Create an isolated database object for compiling the subquery
		// $subquery_db = $CI->load->database('', TRUE);

		// $subquery_db->select('s_inner.id_anggota, MAX(s_inner.tanggal_data) as max_tanggal_data')
		// 	->from('saldo s_inner')
		// 	->join('anggota a_inner', 's_inner.id_anggota = a_inner.id');

		// // Apply role-based filtering to the subquery
		// if ($this->session->userdata('role') == "Koperasi") {
		// 	$subquery_db->where('a_inner.id_koperasi', $this->session->userdata('id_koperasi'));
		// } else if ($this->session->userdata('role') == "Anggota") {
		// 	$subquery_db->where('s_inner.id_anggota', $this->session->userdata('user_user_id'));
		// }
		// $subquery_db->group_by('s_inner.id_anggota');

		// // Compile the subquery into an SQL string
		// $latest_saldos_subquery_sql = $subquery_db->get_compiled_select();
		// $subquery_db->close(); // Close the temporary DB connection


		// // --- Calculate total saldo simpanan from the latest inserted data for each anggota ---
		// $this->db->select_sum('saldo.saldo_simpanan_akhir', 'total_saldo_simpanan'); // Alias for the sum result
		// $this->db->from('saldo');
		// $this->db->join('anggota', 'anggota.id = saldo.id_anggota');

		// // Apply role-based filtering to the main sum query
		// if ($this->session->userdata('role') == "Koperasi") {
		// 	$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		// } else if ($this->session->userdata('role') == "Anggota") {
		// 	$this->db->where('saldo.id_anggota', $this->session->userdata('user_user_id'));
		// }

		// // Join with the derived table to get only the latest records for each anggota
		// $this->db->join(
		// 	"($latest_saldos_subquery_sql) latest_saldos",
		// 	'saldo.id_anggota = latest_saldos.id_anggota AND saldo.tanggal_data = latest_saldos.max_tanggal_data',
		// 	'inner'
		// );

		// $query_simpanan = $this->db->get();
		// $result_simpanan = $query_simpanan->row();

		// $total_saldo_simpanan = 0; // Initialize with 0
		// if ($result_simpanan && isset($result_simpanan->total_saldo_simpanan)) {
		// 	$total_saldo_simpanan = $result_simpanan->total_saldo_simpanan;
		// }
		// $data['total_saldo_simpanan'] = $total_saldo_simpanan;


		// // --- Calculate total saldo pinjaman from the latest inserted data for each anggota ---
		// $this->db->reset_query(); // IMPORTANT: Reset query builder state for the next query

		// $this->db->select_sum('saldo.saldo_pinjaman_akhir', 'total_saldo_pinjaman'); // Alias for the sum result
		// $this->db->from('saldo');
		// $this->db->join('anggota', 'anggota.id = saldo.id_anggota');

		// // Apply role-based filtering to the main sum query
		// if ($this->session->userdata('role') == "Koperasi") {
		// 	$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		// } else if ($this->session->userdata('role') == "Anggota") {
		// 	$this->db->where('saldo.id_anggota', $this->session->userdata('user_user_id'));
		// }

		// // Join with the derived table to get only the latest records for each anggota
		// $this->db->join(
		// 	"($latest_saldos_subquery_sql) latest_saldos",
		// 	'saldo.id_anggota = latest_saldos.id_anggota AND saldo.tanggal_data = latest_saldos.max_tanggal_data',
		// 	'inner'
		// );

		// $query_pinjaman = $this->db->get();
		// $result_pinjaman = $query_pinjaman->row();

		// $total_saldo_pinjaman = 0; // Initialize with 0
		// if ($result_pinjaman && isset($result_pinjaman->total_saldo_pinjaman)) {
		// 	$total_saldo_pinjaman = $result_pinjaman->total_saldo_pinjaman;
		// }
		// $data['total_saldo_pinjaman'] = $total_saldo_pinjaman;

		// ================================
		// SALDO INPUTAN AKHIR
		// ================================

		// UNTUK KEBUTUHAN

		// UNTUK SALDO SIMPANAN


		$this->db->select('saldo_simpanan.tipe_simpanan, SUM(saldo_simpanan.nominal) as total_nominal');
		$this->db->from('saldo_simpanan');
		$this->db->join('anggota', 'anggota.id = saldo_simpanan.id_anggota');
		if ($this->session->userdata('role') == 'Koperasi') {
			$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		} else {
			$this->db->where('anggota.id', $this->session->userdata('user_user_id'));
		}
		$this->db->group_by('saldo_simpanan.tipe_simpanan');
		$this->db->order_by('tipe_simpanan', 'DESC');

		$saldo_simpanan = $this->db->get()->result();
		$data['saldo_simpanan']  = $saldo_simpanan;

		if ($this->session->userdata('role') == "Koperasi") {

			// 1. Subquery: Find the MAX(bulan) for each unique id_anggota and jenis_pinjaman
			$this->db->select('t1.id_anggota, t1.jenis_pinjaman, MAX(t1.bulan) as max_bulan', FALSE);
			$this->db->from('saldo_pinjaman t1');
			$this->db->join('anggota', 'anggota.id = t1.id_anggota'); // Join to filter by id_koperasi
			$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
			$this->db->group_by(array('t1.id_anggota', 't1.jenis_pinjaman'));
			$subquery_max_bulan = $this->db->get_compiled_select();

			// 2. Main query: Select type and sum the records matching the MAX(bulan)
			$this->db->select(
				't_main.jenis_pinjaman, 
				t_main.bulan,
				t_main.tanggal_jam,
         SUM(t_main.cicilan) as total_cicilan, 
         SUM(t_main.nominal) as total_nominal, 
         SUM(t_main.sisa_cicilan) as total_outstanding,
		     MAX(t_main.bulan) as latest_post_dates,
',
				FALSE
			);
			$this->db->from('saldo_pinjaman t_main');

			// Filter using INNER JOIN on id_anggota, jenis_pinjaman, AND the MAX(bulan) date
			$this->db->join(
				"({$subquery_max_bulan}) t_latest",
				't_main.id_anggota = t_latest.id_anggota AND t_main.jenis_pinjaman = t_latest.jenis_pinjaman AND t_main.bulan = t_latest.max_bulan'
			);

			// The Koperasi filter is handled implicitly by the join logic above, but we must ensure we only
			// process the correct subset of members in the main query too, as the subquery is compiled separately.
			// To be robust and ensure data integrity, re-apply the filter or ensure the join includes the necessary table.

			// We need the 'anggota' table in the main query only if we re-apply the Koperasi WHERE clause.
			$this->db->join('anggota', 'anggota.id = t_main.id_anggota');
			$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));


			// FINAL GROUPING: Group the final sum by jenis_pinjaman across all members
			$this->db->group_by('t_main.jenis_pinjaman');
			// $this->db->order_by('t_main.jenis_pinjaman', 'DESC');
			$this->db->order_by('t_main.post_dates', 'DESC');
		} else { // Role is Anggota
			// 1. Subquery: Find the MAX(bulan) for each unique jenis_pinjaman for the current Anggota
			$this->db->select('id_anggota, jenis_pinjaman, MAX(bulan) as max_bulan', FALSE);
			$this->db->from('saldo_pinjaman');
			$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
			$this->db->group_by(array('id_anggota', 'jenis_pinjaman'));
			$subquery_max_bulan = $this->db->get_compiled_select();


			// 2. Main query: Select the full latest records for the Anggota
			// $this->db->select('t1.*'); // Select all columns from saldo_pinjaman
			$this->db->select(
				't1.jenis_pinjaman, 
				t1.tanggal_jam,
				t1.bulan,
         SUM(t1.cicilan) as total_cicilan, 
         SUM(t1.nominal) as total_nominal, 
         SUM(t1.sisa_cicilan) as total_outstanding,
		 		     MAX(t1.bulan) as latest_post_dates,',
				FALSE
			);
			$this->db->from('saldo_pinjaman t1');

			// Filter using INNER JOIN on id_anggota, jenis_pinjaman, AND the MAX(bulan) date
			$this->db->join(
				"({$subquery_max_bulan}) t2",
				't1.id_anggota = t2.id_anggota AND t1.jenis_pinjaman = t2.jenis_pinjaman AND t1.bulan = t2.max_bulan'
			);

			// Final Anggota filter for robustness
			$this->db->where('t1.id_anggota', $this->session->userdata('user_user_id'));

			// Note: No final GROUP BY is needed here since you want individual records (t1.*)
			$this->db->order_by('t1.post_dates', 'DESC');
		}

		$saldo_pinjaman = $this->db->get()->result();
		$data['saldo_pinjaman'] = $saldo_pinjaman;
		$first_row = $saldo_pinjaman[0];

		$data['latest_post_dates'] = $first_row->latest_post_dates;

		$data['content']  = 'webview/admin/dashboard/dashboard_v';
		$data['content_js'] = 'webview/admin/dashboard/dashboard_js';


		$this->load->view('parts/admin/Wrapper', $data);
	}

	public function rekap_kebutuhan()
	{
		$summary_data = $this->Kebutuhan_m->get_rekap();

		// Kirim data sebagai JSON
		header('Content-Type: application/json');
		echo json_encode($summary_data);
	}
}
