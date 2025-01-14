<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Blog extends CI_Controller
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
	function __construct()
	{
		// require_once APPPATH . 'third_party/PhpSpreadsheet/src/Bootstrap.php';
		parent::__construct();
		$this->load->model('Artikel_Management_m', 'artikel_management');
		$this->load->helper(array('form', 'url'));
		$this->load->library('upload');
		if (!$this->session->userdata('user_logged_in')) {
			redirect('auth'); // Redirect to the 'autentic' page
		}
		$this->load->library('pagination');
	}
	public function index()
	{
		$data['content'] = 'webview/blog/blog_template_v';
		// $data['content_js'] = 'webview/home/home_js';
		$this->load->view('parts/index_1/wrapper', $data);
	}
	public function detail($id = null)
	{

		$data['content'] = 'webview/blog/blog_detail_template_v';
		// $data['content_js'] = 'webview/home/home_js';
		$this->load->view('parts/index_1/wrapper', $data);
	}
}
