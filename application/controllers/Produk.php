	<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	class Produk extends CI_Controller
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
			// $this->load->model('Artikel_Management_m', 'artikel_management');
			// $data['users_data'] = $this->artikel_management->artikel_home();
			$data['content'] = 'webview/produk/produk_v';
			// $data['content_js'] = 'webview/home/home_js';
			$this->load->view('parts/index_1/wrapper', $data);
		}
	}
