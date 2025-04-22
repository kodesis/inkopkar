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
			}
			$query = $this->db->get();
			$result = $query->row();

			$saldo_tagihan = $result->saldo_tagihan ?? 0;
			$saldo_rekening = $result->saldo_rekening ?? 0;
			$data['saldo_tagihan'] = $saldo_tagihan;
			$data['saldo_rekening'] = $saldo_rekening;
		} else {
			$this->db->select('kredit_limit');
			$this->db->from('anggota');
			$this->db->where('id', $this->session->userdata('user_user_id'));
			$query = $this->db->get();
			$result = $query->row();

			$saldo_tagihan = $result->kredit_limit ?? 0;
			$data['saldo_tagihan'] = $saldo_tagihan;
		}

		$this->db->select_sum('usage_kredit');
		$this->db->from('nota');
		// $this->db->join('toko', 'toko.id = nota.id_toko');
		$this->db->join('anggota', 'anggota.id = nota.id_anggota');
		// $this->db->join('toko', 'toko.id = anggota.id_toko');
		if ($this->session->userdata('role') == "Kasir") {
			$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
			// $this->db->where('nota.id_toko', $this->session->userdata('id_toko'));
		} else if ($this->session->userdata('role') == "Koperasi") {
			$this->db->where('anggota.id_koperasi', $this->session->userdata('id_koperasi'));
		} else if ($this->session->userdata('role') == "Anggota") {
			$this->db->where('anggota.id_anggota', $this->session->userdata('user_user_id'));
		}

		// $this->db->select_sum('nominal_kredit');
		// $this->db->from('nota');
		// // $this->db->join('toko', 'toko.id = nota.id_toko');
		// $this->db->join('anggota', 'anggota.id = nota.id_anggota');
		// $this->db->join('toko', 'toko.id = anggota.id_toko');
		// if ($this->session->userdata('role') == "Kasir") {
		// 	$this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
		// 	$this->db->where('nota.id_toko', $this->session->userdata('id_toko'));
		// } else if ($this->session->userdata('role') == "Koperasi") {
		// 	$this->db->where('id_koperasi', $this->session->userdata('id_koperasi'));
		// } else if ($this->session->userdata('role') == "Anggota") {
		// 	$this->db->where('id_anggota', $this->session->userdata('user_user_id'));
		// }
		$query = $this->db->get();
		$result = $query->row();

		$total_semua_kredit = 0;
		if ($this->session->userdata('role') == "Admin") {
			$this->db->select_sum('nominal_kredit');
			$this->db->from('nota');
			$this->db->where('status >', '0');

			$query = $this->db->get();
			$semua_kredit = $query->row();
			$total_semua_kredit = $semua_kredit->nominal_kredit;
		}

		$data['total_semua_kredit'] = $total_semua_kredit;

		$data['total_kredit'] = $result->usage_kredit;
		// $data['total_kredit'] = $result->nominal_kredit;

		$data['content']  = 'webview/admin/dashboard/dashboard_v';
		// $data['content_js'] = 'webview/admin/dashboard/dashboard_js';


		$this->load->view('parts/admin/Wrapper', $data);
	}
}
