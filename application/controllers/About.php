<?php
defined('BASEPATH') or exit('No direct script access allowed');

class About extends CI_Controller
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
		$data['content'] = 'webview/about/about_us_v';
		// $data['content_js'] = 'webview/home/home_js';
		$this->load->view('parts/index_1/wrapper', $data);
	}
	public function visi_misi()
	{
		$data['content'] = 'webview/about/visi_misi_v';
		// $data['content_js'] = 'webview/home/home_js';
		$this->load->view('parts/index_1/wrapper', $data);
	}
}