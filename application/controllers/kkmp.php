<?php
defined('BASEPATH') or exit('No direct script access allowed');

class kkmp extends CI_Controller
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
		$this->db->from('kelurahan');
		$kelurahan = $this->db->get()->result();
		$data['kelurahan'] = $kelurahan;
		$data['content'] = 'webview/kkmp/kkmp_v';
		$data['content_js'] = 'webview/kkmp/kkmp_js';
		$this->load->view('parts/index_1/wrapper', $data);
	}
}
