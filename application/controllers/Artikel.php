<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Artikel extends CI_Controller
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
		$this->load->library('pagination');
	}
	public function index()
	{
		$search = htmlspecialchars($this->input->get('search') ?? '', ENT_QUOTES, 'UTF-8');

		//pagination settings
		$config['base_url'] = site_url('artikel');
		$config['total_rows'] = $this->artikel_management->item_count($search);
		$config['per_page'] = "9";
		$config["uri_segment"] = 3;
		$config['enable_query_strings'] = TRUE;
		$config['page_query_string'] = TRUE;
		$config['use_page_numbers'] = TRUE;
		$config['reuse_query_string'] = TRUE;

		$choice = $config["total_rows"] / $config["per_page"];
		//$config["num_links"] = floor($choice);
		$config["num_links"] = 10;
		// integrate bootstrap pagination
		$config['full_tag_open'] = '<ul class="pagination list-wrap">';
		$config['full_tag_close'] = '</ul>';
		$config['first_link'] = false;
		$config['last_link'] = false;
		$config['first_tag_open'] = '<li>';
		$config['first_tag_close'] = '</li>';
		$config['prev_link'] = '<span class="fas fa-angle-double-left"></span>';
		$config['prev_tag_open'] = '<li class="page-item">';
		$config['prev_tag_close'] = '</li>';
		$config['next_link'] = '<span class="fas fa-angle-double-right"></span>';
		$config['next_tag_open'] = '<li class="page-item">';
		$config['next_tag_close'] = '</li>';
		$config['last_tag_open'] = '<li>';
		$config['last_tag_close'] = '</li>';
		$config['cur_tag_open'] = '<li class="page-item active"><a class="page-link" href="#">';
		$config['cur_tag_close'] = '</a></li>';
		// $config['num_tag_open'] = '<li class="page-item"><a class="page-link">';  // Add page-link class here
		// $config['num_tag_close'] = '</a></li>';
		// Initialize pagination
		$this->pagination->initialize($config);

		// Get the current page number from the query string (page=X)
		$data['page'] = $this->input->get('page') ? $this->input->get('page') : 1;  // Default to 1 if no page param is set
		$offset = ($data['page'] - 1) * $config['per_page'];  // Calculate the offset for the query

		// Fetch data for the current page
		$data['users_data'] = $this->artikel_management->item_get($config["per_page"], $offset, $search);

		// Generate the pagination links
		$data['pagination'] = $this->pagination->create_links();

		$data['recent'] = $this->artikel_management->artikel_recent();
		// $data['artikel'] = $this->artikel_management->get_artikel();
		$data['content'] = 'webview/artikel/artikel_v';
		// $data['content_js'] = 'webview/home/home_js';
		$this->load->view('parts/index_1/wrapper', $data);
	}
	public function detail($id = null)
	{
		$data['recent'] = $this->artikel_management->artikel_recent();

		if ($id) {
			$this->artikel_management->update_count($id);
			$detail = $this->artikel_management->get_id_edit($id);

			if ($detail) {
				$data['detail'] = $detail;
				$data['content'] = 'webview/artikel/artikel_detail_v';
			} else {
				redirect('error404');
			}
		} else {
			redirect('error404');
		}
		// $data['detail'] = $this->artikel_management->get_id_edit($id);
		// $data['content_js'] = 'webview/home/home_js';
		$this->load->view('parts/index_1/wrapper', $data);
	}
}
