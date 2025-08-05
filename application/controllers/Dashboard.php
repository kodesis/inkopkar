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

		$this->db->select_sum('nominal');
		$this->db->from('saldo_pinjaman');
		$this->db->join('anggota', 'anggota.id = saldo_pinjaman.id_anggota');
		// $this->db->select_sum('saldo_pinjaman_akhir');
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
		$total_saldo_pinjaman = $result->nominal;
		// $total_saldo_pinjaman = $result->saldo_pinjaman_akhir;
		$data['total_saldo_pinjaman'] = $total_saldo_pinjaman;


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
