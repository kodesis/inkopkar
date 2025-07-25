	<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Home extends CI_Controller
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
			$this->load->model('Artikel_Management_m', 'artikel_management');
			$data['users_data'] = $this->artikel_management->artikel_home();
			$data['content'] = 'webview/home_view_1';
			// $data['content_js'] = 'webview/home/home_js';
			$this->load->view('parts/index_1/wrapper', $data);
		}
		public function index2()
		{
			$data['content'] = 'webview/home_view_2';
			// $data['content_js'] = 'webview/home/home_js';
			$this->load->view('parts/index_2/wrapper', $data);
		}

		public function kkmp()
		{
			$this->db->select('kelurahan.*, COUNT(koperasi.id) as user_count'); // Select all kelurahan columns and count users
			$this->db->from('kelurahan');
			$this->db->join('koperasi', 'koperasi.kelurahan = kelurahan.id', 'left'); // LEFT JOIN to include all kelurahan, even those without users
			$this->db->group_by('kelurahan.id'); // Group by kelurahan ID to count users for each
			$this->db->order_by('user_count', 'DESC'); // Order by the user count in descending order
			$kelurahan = $this->db->get()->result();
			$data['kelurahan'] = $kelurahan;
			$data['content'] = 'webview/kkmp/kkmp_v';
			$data['content_js'] = 'webview/kkmp/kkmp_js';
			$this->load->view('parts/index_1/wrapper', $data);
		}
	}
